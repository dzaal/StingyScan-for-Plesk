<?php
require_once __DIR__ . '/VtDataDir.php';
require_once __DIR__ . '/VtSettings.php';
require_once __DIR__ . '/VtServerName.php';

/**
 * VtMailSender: the address Stingy Scanner sends its e-mails from (Settings → E-mail sender), and a check
 * whether receiving mail servers will trust it: SPF, DKIM and DMARC of the sender's domain.
 *
 * The address is used as From and as the envelope sender (Return-Path), so SPF and DMARC check the same
 * domain. When nothing is set, the administrator's Plesk address is used, as before.
 */
class VtMailSender
{
    /** [name, address] */
    public static function get(): array
    {
        $s    = new VtSettings('admin');
        $addr = trim((string)$s->get('mail_from', ''));
        $name = trim((string)$s->get('mail_from_name', ''));
        if (!filter_var($addr, FILTER_VALIDATE_EMAIL)) {
            require_once __DIR__ . '/VtNotifier.php';
            $addr = VtNotifier::emailOfLogin('admin') ?: ('noreply@' . VtServerName::used());
        }
        return [$name, $addr];
    }

    /** "Name" <address> header value (name encoded for any language) */
    public static function fromHeader(string $fallbackName): string
    {
        [$name, $addr] = self::get();
        $name = $name !== '' ? $name : $fallbackName;
        return '=?UTF-8?B?' . base64_encode($name) . '?= <' . $addr . '>';
    }

    /** The fifth mail() argument: envelope sender = From address */
    public static function envelope(): string
    {
        $addr = self::get()[1];
        return filter_var($addr, FILTER_VALIDATE_EMAIL) ? '-f' . $addr : '';
    }

    // ── Check: SPF, DKIM, DMARC ────────────────────────────────

    /**
     * [{id, state: ok|warn|bad, label, detail}] for the sender's domain.
     * $local: what the root helper found on this server (mailcheck): relay host, DKIM key and signing.
     */
    public static function check(string $addr, array $local): array
    {
        $domain = strtolower(substr(strrchr($addr, '@') ?: '', 1));
        $out = [];
        if ($domain === '') return [['id' => 'addr', 'state' => 'bad', 'label' => 'Address', 'detail' => 'Not a valid e-mail address']];

        // Which IP addresses the receiving mail server sees: the relay host, or this server itself
        $relay = (string)($local['relay'] ?? '');
        $ips   = $relay !== '' ? self::resolve($relay) : array_values(array_filter((array)($local['ips'] ?? [])));
        $via   = $relay !== '' ? 'the relay server ' . $relay . ' (this server sends all mail through it)' : 'this server';

        // SPF
        $spf = self::txt($domain, 'v=spf1');
        if (!$spf) {
            $out[] = ['id' => 'spf', 'state' => 'bad', 'label' => 'SPF', 'detail' => 'No SPF record for ' . $domain . '. Add a TXT record that allows ' . $via . ' (' . implode(', ', $ips) . ').'];
        } else {
            $bad = [];
            foreach ($ips as $ip) if (self::spfAllows($domain, $ip) !== true) $bad[] = $ip;
            $out[] = $bad
                ? ['id' => 'spf', 'state' => 'bad', 'label' => 'SPF', 'detail' => 'The SPF record of ' . $domain . ' does not allow ' . $via . ': ' . implode(', ', $bad) . '. Add it (for example <code>ip4:' . htmlspecialchars($bad[0]) . '</code>).']
                : ['id' => 'spf', 'state' => 'ok', 'label' => 'SPF', 'detail' => 'Allows ' . $via . ' (' . implode(', ', $ips) . ').'];
        }

        // DKIM: Plesk signs mail of domains it hosts with the key in /etc/domainkeys/<domain>/default
        if (empty($local['hosted'])) {
            $out[] = ['id' => 'dkim', 'state' => 'bad', 'label' => 'DKIM', 'detail' => $domain . ' has no mail service on this server, so this server cannot sign its mail. '
                    . 'Use an address of a domain with mail on this server, or sign the mail on the relay server.'];
        } elseif (empty($local['dkim_sign']) || empty($local['dkim_key'])) {
            $out[] = ['id' => 'dkim', 'state' => 'bad', 'label' => 'DKIM', 'detail' => 'DKIM signing is off for ' . $domain . '. Turn it on in Plesk: Websites &amp; Domains → ' . htmlspecialchars($domain) . ' → Mail Settings → <em>Use DKIM spam protection system to sign outgoing email messages</em>.'];
        } elseif (empty($local['dkim_dns'])) {
            $out[] = ['id' => 'dkim', 'state' => 'bad', 'label' => 'DKIM', 'detail' => 'This server signs mail of ' . $domain . ', but the public key is not published: add the TXT record <code>default._domainkey.' . htmlspecialchars($domain) . '</code> (Plesk shows it in the DNS settings of the domain).'];
        } elseif (empty($local['dkim_match'])) {
            $out[] = ['id' => 'dkim', 'state' => 'bad', 'label' => 'DKIM', 'detail' => 'The published key <code>default._domainkey.' . htmlspecialchars($domain) . '</code> does not match the key this server signs with, so signatures fail. Publish the key from this server.'];
        } else {
            $out[] = ['id' => 'dkim', 'state' => 'ok', 'label' => 'DKIM', 'detail' => 'Signed by this server (selector <code>default</code>); the published key matches.'
                    . ($relay !== '' ? ' The relay server must pass the mail on unchanged, which relays normally do.' : '')];
        }

        // DMARC
        $dm = self::txt('_dmarc.' . $domain, 'v=DMARC1');
        if (!$dm) {
            $out[] = ['id' => 'dmarc', 'state' => 'bad', 'label' => 'DMARC', 'detail' => 'No DMARC record. Add a TXT record <code>_dmarc.' . htmlspecialchars($domain) . '</code>, for example <code>v=DMARC1; p=quarantine; rua=mailto:postmaster@' . htmlspecialchars($domain) . '</code>.'];
        } else {
            $p = preg_match('/(?:^|;)\s*p\s*=\s*(\w+)/i', $dm, $m) ? strtolower($m[1]) : 'none';
            $out[] = $p === 'none'
                ? ['id' => 'dmarc', 'state' => 'warn', 'label' => 'DMARC', 'detail' => 'Present but <code>p=none</code>: receivers only monitor, and forged mail in your name is not stopped. '
                   . 'When SPF and DKIM pass for all mail of ' . htmlspecialchars($domain) . ', change it to <code>p=quarantine</code> (and add <code>rua=mailto:…</code> to receive reports). Current: <code>' . htmlspecialchars($dm) . '</code>']
                : ['id' => 'dmarc', 'state' => 'ok', 'label' => 'DMARC', 'detail' => 'Policy <code>p=' . htmlspecialchars($p) . '</code>. SPF and DKIM use the sender\'s domain, so they line up with it.'];
        }
        return $out;
    }

    /** The TXT record of a name that starts with $prefix (records split in parts are joined) */
    private static function txt(string $name, string $prefix): ?string
    {
        foreach (@dns_get_record($name, DNS_TXT) ?: [] as $r) {
            $t = isset($r['entries']) ? implode('', $r['entries']) : (string)($r['txt'] ?? '');
            if (stripos(ltrim($t), $prefix) === 0) return trim($t);
        }
        return null;
    }

    private static function resolve(string $host): array
    {
        $ips = [];
        foreach (@dns_get_record($host, DNS_A) ?: [] as $r) $ips[] = $r['ip'];
        foreach (@dns_get_record($host, DNS_AAAA) ?: [] as $r) $ips[] = $r['ipv6'];
        return $ips ?: [$host];
    }

    /** Does the SPF record of $domain allow $ip? true, false, or null (unknown). Follows include, a, mx, ip4, ip6, redirect. */
    public static function spfAllows(string $domain, string $ip, int $depth = 0): ?bool
    {
        if ($depth > 10) return null;
        $rec = self::txt($domain, 'v=spf1');
        if (!$rec) return null;
        foreach (preg_split('/\s+/', $rec) as $term) {
            if ($term === '' || stripos($term, 'v=spf1') === 0) continue;
            $q = in_array($term[0], ['+', '-', '~', '?'], true) ? $term[0] : '+';
            $t = ltrim($term, '+-~?');
            $hit = false;
            if (stripos($t, 'ip4:') === 0 || stripos($t, 'ip6:') === 0) $hit = self::inCidr($ip, substr($t, 4));
            elseif (stripos($t, 'include:') === 0) $hit = self::spfAllows(substr($t, 8), $ip, $depth + 1) === true;
            elseif ($t === 'a' || stripos($t, 'a:') === 0 || stripos($t, 'a/') === 0) $hit = in_array($ip, self::resolve($t === 'a' || $t[1] === '/' ? $domain : substr($t, 2)), true);
            elseif ($t === 'mx' || stripos($t, 'mx:') === 0) {
                foreach (@dns_get_record($t === 'mx' ? $domain : substr($t, 3), DNS_MX) ?: [] as $mx) if (in_array($ip, self::resolve($mx['target']), true)) $hit = true;
            } elseif (stripos($t, 'redirect=') === 0) return self::spfAllows(substr($t, 9), $ip, $depth + 1);
            elseif (strtolower($t) === 'all') return $q === '+';
            if ($hit) return $q === '+';
        }
        return false;
    }

    private static function inCidr(string $ip, string $cidr): bool
    {
        [$net, $bits] = array_pad(explode('/', $cidr, 2), 2, null);
        $a = @inet_pton($ip); $b = @inet_pton($net);
        if ($a === false || $b === false || strlen($a) !== strlen($b)) return false;
        $bits = $bits === null ? strlen($a) * 8 : (int)$bits;
        $bytes = intdiv($bits, 8); $rest = $bits % 8;
        if (substr($a, 0, $bytes) !== substr($b, 0, $bytes)) return false;
        if ($rest === 0) return true;
        $mask = chr((0xff << (8 - $rest)) & 0xff);
        return (($a[$bytes] & $mask) === ($b[$bytes] & $mask));
    }
}
