<?php
require_once __DIR__ . '/VtPwned.php';
require_once __DIR__ . '/VtNotifier.php';
require_once __DIR__ . '/PleskDomains.php';
require_once __DIR__ . '/VtServerName.php';

/**
 * VtPwnedMail: the e-mail to a WordPress administrator whose address is in known data breaches,
 * after (or, as a test, instead of) resetting their password on the sites below.
 *
 * The message explains what was found (every breach, with year and leaked data), why the password
 * was reset, and links to each site's own "Lost your password?" page, where they choose a new
 * password themselves. Nobody, also not the hosting provider, knows the new password.
 */
class VtPwnedMail
{
    const PW_RISK = ['plaintext' => 'passwords readable as plain text', 'easytocrack' => 'passwords, easy to crack',
                     'hardtocrack' => 'passwords, strongly encrypted'];

    /** Name and address of the sender: the server administrator (company name from Plesk) */
    public static function sender(): array
    {
        $email = VtNotifier::emailOfLogin('admin') ?: ('noreply@' . VtServerName::used());
        $name  = '';
        try {
            $pdo  = PleskDomains::pdo();
            $name = $pdo ? trim((string)$pdo->query("SELECT COALESCE(NULLIF(TRIM(cname),''), pname) FROM clients WHERE login = 'admin' LIMIT 1")->fetchColumn()) : '';
        } catch (\Throwable $e) {
        }
        return [$name !== '' ? $name : 'Your hosting provider', $email];
    }

    /**
     * Subject, HTML and plain text.
     * $sites: [{host, login}] where the password is (or would be) reset. $testFor: the real recipient, when this is a test.
     */
    public static function build(string $email, array $sites, array $result, ?string $testFor = null): array
    {
        [$from] = self::sender();
        $hosts  = array_values(array_unique(array_column($sites, 'host')));
        $n      = count($hosts);
        $subject = 'Security notice: your password for ' . ($n === 1 ? $hosts[0] : $hosts[0] . ' and ' . ($n - 1) . ' other site' . ($n === 2 ? '' : 's'))
                 . ' has been reset';
        if ($testFor !== null) $subject = '[TEST] ' . $subject;
        $breaches = $result['breaches'] ?? [];
        $nb       = count($breaches);
        $src      = VtPwned::SOURCES[$result['source'] ?? ''] ?? 'a breach database';
        $logins   = array_values(array_unique(array_column($sites, 'login')));
        $e        = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

        // ── HTML ──
        $td = 'style="padding:6px 10px;border-bottom:1px solid #e5e7eb;vertical-align:top;text-align:left"';
        $th = 'style="padding:6px 10px;border-bottom:2px solid #d1d5db;text-align:left;font-size:12px;color:#6b7280"';
        $h  = '<div style="font-family:-apple-system,Segoe UI,Arial,sans-serif;font-size:14px;line-height:1.55;color:#1f2937;max-width:680px">';
        if ($testFor !== null) {
            $h .= '<div style="background:#fef9c3;border:1px solid #fde047;border-radius:6px;padding:10px 12px;margin-bottom:16px;font-size:13px">'
                . '<strong>Test message.</strong> The real message goes to <strong>' . $e($testFor) . '</strong>. Nothing was changed: no password was reset.</div>';
        }
        $h .= '<p>Hello ' . $e(implode(' / ', $logins)) . ',</p>'
            . '<p>Your e-mail address <strong>' . $e($email) . '</strong> appears in <strong>' . $nb . ' known data breach' . ($nb === 1 ? '' : 'es')
            . '</strong> of other websites and services. Your website was not hacked, and you did not do anything wrong: these breaches happened elsewhere.</p>'
            . '<p>But e-mail addresses and passwords from such breaches are traded, and bots try them on WordPress login pages every day. '
            . 'If you ever used the same (or a similar) password for one of those services and for your website, someone could log in as you, '
            . 'infect the site with malware and get it blocked by browsers, antivirus software and e-mail filters.</p>'
            . '<p><strong>To be safe, we have reset the password of your administrator account and logged you out on '
            . ($n === 1 ? 'this site' : 'these sites') . ':</strong></p>'
            . '<table style="border-collapse:collapse;margin:6px 0 14px"><tr><th ' . $th . '>Website</th><th ' . $th . '>Username</th><th ' . $th . '></th></tr>';
        foreach ($sites as $s) {
            $link = 'https://' . $s['host'] . '/wp-login.php?action=lostpassword';
            $h .= '<tr><td ' . $td . '><strong>' . $e($s['host']) . '</strong></td><td ' . $td . '>' . $e($s['login']) . '</td>'
                . '<td ' . $td . '><a href="' . $e($link) . '" style="display:inline-block;background:#2563eb;color:#fff;text-decoration:none;padding:5px 12px;border-radius:5px;font-weight:600">Choose a new password</a></td></tr>';
        }
        $h .= '</table>'
            . '<p><strong>What you need to do:</strong> click <em>Choose a new password</em>, enter your username or e-mail address, '
            . 'and the site sends you a link to choose a new password yourself. Nobody else knows that password, also not us. '
            . 'Please use a password you have <strong>never used anywhere else</strong>. Until then you cannot log in with your old password.</p>'
            . '<h3 style="font-size:15px;margin:22px 0 6px">The breaches your address appears in</h3>'
            . '<table style="border-collapse:collapse;font-size:13px;width:100%"><tr><th ' . $th . '>Breach</th><th ' . $th . '>Year</th><th ' . $th . '>What leaked</th></tr>';
        foreach ($breaches as $b) {
            $data = implode(', ', $b['data'] ?? []);
            $risk = self::PW_RISK[$b['pw'] ?? ''] ?? '';
            $h .= '<tr><td ' . $td . '>' . $e($b['title'] ?? $b['name']) . '</td><td ' . $td . '>' . $e(substr((string)($b['date'] ?? ''), 0, 4) ?: '—') . '</td>'
                . '<td ' . $td . '>' . $e($data ?: '—') . ($risk ? '<br><span style="color:#b91c1c">' . $e($risk) . '</span>' : '') . '</td></tr>';
        }
        $h .= '</table>'
            . '<h3 style="font-size:15px;margin:22px 0 6px">Why we reset your password</h3>'
            . '<ul style="margin:0;padding-left:20px">'
            . '<li>A password that leaked once stays in the lists that attackers use, for years.</li>'
            . '<li>We cannot see whether you used that password for your website, so we take no risk.</li>'
            . '<li>A hacked administrator account is the most common way websites get infected. Cleaning up afterwards, and getting the site off the blocklists again, takes days or weeks.</li>'
            . '</ul>'
            . '<h3 style="font-size:15px;margin:22px 0 6px">Good to do as well</h3>'
            . '<ul style="margin:0;padding-left:20px">'
            . '<li>Change your password at the services listed above, and anywhere else you used the same password.</li>'
            . '<li>Use a password manager, so every site gets its own strong password.</li>'
            . '<li>Turn on two-factor login (for example with an authenticator app) for your website and your e-mail.</li>'
            . '</ul>'
            . '<p style="margin-top:22px">Questions? Just reply to this e-mail.</p>'
            . '<p>Kind regards,<br>' . $e($from) . '</p>'
            . '<p style="font-size:11px;color:#9ca3af;margin-top:24px">Sent by the hosting server ' . $e(VtServerName::label()) . '. Breach data: ' . $e($src) . '. Only your e-mail address was looked up; no passwords were sent anywhere.</p>'
            . '</div>';

        // ── Plain text ──
        $t = ($testFor !== null ? "TEST MESSAGE. The real message goes to $testFor. Nothing was changed: no password was reset.\n\n" : '')
           . 'Hello ' . implode(' / ', $logins) . ",\n\n"
           . "Your e-mail address $email appears in $nb known data breach" . ($nb === 1 ? '' : 'es') . " of other websites and services. "
           . "Your website was not hacked, and you did not do anything wrong.\n\n"
           . "Passwords from such breaches are tried on WordPress login pages every day. To be safe, we have reset the password of your administrator account and logged you out on:\n\n";
        foreach ($sites as $s) $t .= '  ' . $s['host'] . ' (username ' . $s['login'] . "): https://" . $s['host'] . "/wp-login.php?action=lostpassword\n";
        $t .= "\nOpen the link, enter your username or e-mail address, and the site sends you a link to choose a new password yourself. "
            . "Please use a password you have never used anywhere else.\n\nThe breaches your address appears in:\n";
        foreach ($breaches as $b) {
            $t .= '  - ' . ($b['title'] ?? $b['name']) . (!empty($b['date']) ? ' (' . substr($b['date'], 0, 4) . ')' : '')
                . (!empty($b['data']) ? ': ' . implode(', ', $b['data']) : '') . "\n";
        }
        $t .= "\nAlso change your password at those services and anywhere else you used it, use a password manager, and turn on two-factor login.\n\n"
            . "Questions? Just reply to this e-mail.\n\nKind regards,\n$from\n\n-- \nSent by the hosting server " . VtServerName::label() . "\n";
        return [$subject, $h, $t];
    }

    /** Send as HTML with a plain-text part */
    public static function send(string $to, string $subject, string $html, string $text): bool
    {
        [$name, $from] = self::sender();
        $b = 'b' . bin2hex(random_bytes(8));
        $headers = implode("\r\n", [
            'From: =?UTF-8?B?' . base64_encode($name) . '?= <' . $from . '>',
            'Reply-To: ' . $from,
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $b . '"',
            'X-Mailer: Stingy Scanner',
        ]);
        $body = "--$b\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n" . chunk_split(base64_encode($text))
              . "--$b\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n" . chunk_split(base64_encode($html))
              . "--$b--\r\n";
        // Envelope sender = the From address, so SPF/DMARC checks of the recipient's mail server see one sender
        $env = filter_var($from, FILTER_VALIDATE_EMAIL) ? '-f' . $from : '';
        return @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers, $env);
    }
}
