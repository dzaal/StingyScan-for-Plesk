<?php
require_once __DIR__ . '/VtPwned.php';
require_once __DIR__ . '/VtNotifier.php';
require_once __DIR__ . '/PleskDomains.php';
require_once __DIR__ . '/VtServerName.php';

/**
 * VtPwnedMail: the e-mail to a site administrator whose address is in known data breaches.
 *
 * Two kinds: 'warn' changes nothing and asks the owner to check the account and change the password;
 * 'reset' follows an emergency reset of the password and explains why. Both explain what was found
 * (every breach, with year and leaked data), show per site when the account was last used, and link
 * to the site's own login and "Lost your password?" pages. Nobody else learns the new password.
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
     * $kind: 'warn' (nothing was changed; check the account and change the password) or 'reset' (the password
     * was reset as an emergency measure). $sites: [{host, login, cms, urls: {login, lost}, act: activity}].
     * $testFor: the real recipient, when this is a test.
     */
    public static function build(string $email, array $sites, array $result, ?string $testFor = null, string $kind = 'warn'): array
    {
        [$from] = self::sender();
        $reset  = $kind === 'reset';
        // The site's address: the domain plus the folder of the install, e.g. example.com/shop
        foreach ($sites as &$s) $s['site'] = $s['site'] ?? $s['host'];
        unset($s);
        $hosts  = array_values(array_unique(array_column($sites, 'site')));
        $n      = count($hosts);
        $siteTxt = $n === 1 ? $hosts[0] : $hosts[0] . ' and ' . ($n - 1) . ' other site' . ($n === 2 ? '' : 's');
        $breaches = $result['breaches'] ?? [];
        $nb       = count($breaches);
        $subject  = $reset ? 'Security notice: your password for ' . $siteTxt . ' has been reset'
                           : 'Security notice: please check your account on ' . $siteTxt;
        if ($testFor !== null) $subject = '[TEST] ' . $subject;
        $src    = VtPwned::SOURCES[$result['source'] ?? ''] ?? 'a breach database';
        $logins = array_values(array_unique(array_column($sites, 'login')));
        $e      = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
        $date   = fn($ts) => $ts ? date('j M Y, H:i', (int)$ts) : '';

        // ── HTML ──
        $td  = 'style="padding:8px 10px;border-bottom:1px solid #e5e7eb;vertical-align:top;text-align:left"';
        $th  = 'style="padding:6px 10px;border-bottom:2px solid #d1d5db;text-align:left;font-size:12px;color:#6b7280"';
        $btn = fn($href, $label, $bg) => '<a href="' . $e($href) . '" style="display:inline-block;background:' . $bg . ';color:#fff;text-decoration:none;padding:5px 12px;border-radius:5px;font-weight:600;margin:2px 4px 2px 0">' . $e($label) . '</a>';
        $h  = '<div style="font-family:-apple-system,Segoe UI,Arial,sans-serif;font-size:14px;line-height:1.55;color:#1f2937;max-width:680px">';
        if ($testFor !== null) {
            $h .= '<div style="background:#fef9c3;border:1px solid #fde047;border-radius:6px;padding:10px 12px;margin-bottom:16px;font-size:13px">'
                . '<strong>Test message.</strong> The real message goes to <strong>' . $e($testFor) . '</strong>. Nothing was changed'
                . ($reset ? ': no password was reset.' : '.') . '</div>';
        }
        $h .= '<p>Hello ' . $e(implode(' / ', $logins)) . ',</p>'
            . '<p>Your e-mail address <strong>' . $e($email) . '</strong> appears in <strong>' . $nb . ' known data breach' . ($nb === 1 ? '' : 'es')
            . '</strong> of other websites and services. These breaches happened elsewhere, not on your website, and you did not do anything wrong.</p>'
            . '<p>But e-mail addresses and passwords from such breaches are traded, and bots try them on website login pages every day. '
            . 'If you ever used the same (or a similar) password for one of those services and for your website, someone could log in as you, '
            . 'infect the site with malware and get it blocked by browsers, antivirus software and e-mail filters.</p>';
        if ($reset) {
            $h .= '<p><strong>As an emergency measure we have reset the password of your administrator account and logged you out on '
                . ($n === 1 ? 'this site' : 'these sites') . '.</strong> We did this because the risk was too high to wait: '
                . 'a login with a leaked password can not be told apart from your own, and a hacked administrator account can infect the site within minutes. '
                . 'Nothing was deleted or changed on your website itself.</p>';
        } else {
            $h .= '<p><strong>Nothing has been changed.</strong> We ask you to check your administrator account on '
                . ($n === 1 ? 'this site' : 'these sites') . ' and to change the password, unless you are sure it is unique and was never used anywhere else. '
                . 'Below each site you see when your account was last used: if you do not recognise a login, contact us right away.</p>';
        }
        $h .= '<table style="border-collapse:collapse;margin:6px 0 14px;width:100%"><tr><th ' . $th . '>Website</th><th ' . $th . '>Your account</th></tr>';
        foreach ($sites as $s) {
            $a = $s['act'] ?? [];
            $info = [];
            if (!empty($a['last_login'])) $info[] = 'Last login: <strong>' . $e($date($a['last_login'])) . '</strong>' . (!empty($a['last_ip']) ? ' from IP address ' . $e($a['last_ip']) : '');
            else $info[] = 'Last login: not recorded by the site';
            if (isset($a['sessions'])) $info[] = $a['sessions'] ? $a['sessions'] . ' login session' . ($a['sessions'] === 1 ? '' : 's') . ' still active' . ($reset ? ' (now logged out)' : '') : 'no active login sessions';
            if (!empty($a['last_edit'])) $info[] = 'Last page or post edited: ' . $e($date($a['last_edit'])) . (isset($a['posts']) ? ' (' . $a['posts'] . ' in total)' : '');
            if (!empty($a['created'])) $info[] = 'Account created: ' . $e(date('j M Y', (int)$a['created']));
            $links = $reset ? $btn($s['urls']['lost'], 'Choose a new password', '#2563eb')
                            : $btn($s['urls']['login'], 'Log in and change password', '#2563eb') . $btn($s['urls']['lost'], 'Forgot password', '#6b7280');
            $h .= '<tr><td ' . $td . '><strong>' . $e($s['site']) . '</strong>' . (($s['cms'] ?? 'WordPress') !== 'WordPress' ? '<br><span style="font-size:12px;color:#6b7280">' . $e($s['cms']) . '</span>' : '') . '</td>'
                . '<td ' . $td . '>Username <strong>' . $e($s['login']) . '</strong><div style="font-size:12px;color:#4b5563;margin:3px 0 6px">' . implode('<br>', $info) . '</div>' . $links . '</td></tr>';
        }
        $h .= '</table>';
        $h .= $reset
            ? '<p><strong>What you need to do:</strong> click <em>Choose a new password</em>, enter your username or e-mail address, '
              . 'and the site sends you a link to choose a new password yourself. Nobody else knows that password, also not us. '
              . 'Please use a password you have <strong>never used anywhere else</strong>. Until then you cannot log in with your old password.</p>'
            : '<p><strong>What we ask you to do:</strong> click <em>Log in and change password</em> and set a new password you have '
              . '<strong>never used anywhere else</strong>. Lost your password? <em>Forgot password</em> sends you a link to choose a new one. '
              . 'Also check whether you recognise the last login above.</p>';
        $h .= '<h3 style="font-size:15px;margin:22px 0 6px">The breaches your address appears in</h3>'
            . '<table style="border-collapse:collapse;font-size:13px;width:100%"><tr><th ' . $th . '>Breach</th><th ' . $th . '>Year</th><th ' . $th . '>What leaked</th></tr>';
        foreach ($breaches as $b) {
            $data = implode(', ', $b['data'] ?? []);
            $risk = self::PW_RISK[$b['pw'] ?? ''] ?? '';
            $h .= '<tr><td ' . $td . '>' . $e($b['title'] ?? $b['name']) . '</td><td ' . $td . '>' . $e(substr((string)($b['date'] ?? ''), 0, 4) ?: '—') . '</td>'
                . '<td ' . $td . '>' . $e($data ?: '—') . ($risk ? '<br><span style="color:#b91c1c">' . $e($risk) . '</span>' : '') . '</td></tr>';
        }
        $h .= '</table>'
            . '<h3 style="font-size:15px;margin:22px 0 6px">' . ($reset ? 'Why we reset your password' : 'Why this matters') . '</h3>'
            . '<ul style="margin:0;padding-left:20px">'
            . '<li>A password that leaked once stays in the lists that attackers use, for years.</li>'
            . '<li>We cannot see whether you used that password for your website' . ($reset ? ', so we took no risk.' : '; only you know.') . '</li>'
            . '<li>A hacked administrator account is the most common way websites get infected. Cleaning up afterwards, and getting the site off the blocklists again, takes days or weeks.</li>'
            . '</ul>'
            . '<h3 style="font-size:15px;margin:22px 0 6px">Good to do as well</h3>'
            . '<ul style="margin:0;padding-left:20px">'
            . '<li>Change your password at the services listed above, and anywhere else you used the same password.</li>'
            . '<li>Use a password manager, so every site gets its own strong password.</li>'
            . '<li>Turn on two-factor login (for example with an authenticator app) for your website and your e-mail.</li>'
            . '</ul>'
            . '<p style="margin-top:22px">Questions, or a login you do not recognise? Just reply to this e-mail.</p>'
            . '<p>Kind regards,<br>' . $e($from) . '</p>'
            . '<p style="font-size:11px;color:#9ca3af;margin-top:24px">Sent by the hosting server ' . $e(VtServerName::label()) . '. Breach data: ' . $e($src) . '. Only your e-mail address was looked up; no passwords were sent anywhere.</p>'
            . '</div>';

        // ── Plain text ──
        $t = ($testFor !== null ? "TEST MESSAGE. The real message goes to $testFor. Nothing was changed.\n\n" : '')
           . 'Hello ' . implode(' / ', $logins) . ",\n\n"
           . "Your e-mail address $email appears in $nb known data breach" . ($nb === 1 ? '' : 'es') . " of other websites and services. "
           . "These breaches happened elsewhere, and you did not do anything wrong. But passwords from such breaches are tried on website login pages every day.\n\n"
           . ($reset ? "As an emergency measure we have reset the password of your administrator account and logged you out on:\n\n"
                     : "Nothing has been changed. Please check your administrator account and change the password on:\n\n");
        foreach ($sites as $s) {
            $a = $s['act'] ?? [];
            $t .= '  ' . $s['site'] . ' (username ' . $s['login'] . ")\n"
                . '    Last login: ' . (!empty($a['last_login']) ? $date($a['last_login']) . (!empty($a['last_ip']) ? ' from ' . $a['last_ip'] : '') : 'not recorded') . "\n"
                . (!empty($a['last_edit']) ? '    Last page or post edited: ' . $date($a['last_edit']) . "\n" : '')
                . ($reset ? '    Choose a new password: ' . $s['urls']['lost'] . "\n"
                          : '    Log in and change password: ' . $s['urls']['login'] . "\n    Forgot password: " . $s['urls']['lost'] . "\n");
        }
        $t .= "\nPlease use a password you have never used anywhere else. If you do not recognise a login above, reply to this e-mail right away.\n\nThe breaches your address appears in:\n";
        foreach ($breaches as $b) {
            $t .= '  - ' . ($b['title'] ?? $b['name']) . (!empty($b['date']) ? ' (' . substr($b['date'], 0, 4) . ')' : '')
                . (!empty($b['data']) ? ': ' . implode(', ', $b['data']) : '') . "\n";
        }
        $t .= "\nAlso change your password at those services and anywhere else you used it, use a password manager, and turn on two-factor login.\n\n"
            . "Kind regards,\n$from\n\n-- \nSent by the hosting server " . VtServerName::label() . "\n";
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
