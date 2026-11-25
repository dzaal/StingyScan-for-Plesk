<?php
// Load our non-autoloaded library classes
$_vtLib = '/usr/local/psa/admin/plib/modules/stingyscan/library';
if (!is_dir($_vtLib)) {
    $_vtLib = realpath(dirname(__FILE__) . '/../library');
}
require_once $_vtLib . '/VtDataDir.php';
require_once $_vtLib . '/VtSettings.php';
require_once $_vtLib . '/VtCache.php';
require_once $_vtLib . '/VtRateLimiter.php';
require_once $_vtLib . '/VtApi.php';
require_once $_vtLib . '/PleskDomains.php';
require_once $_vtLib . '/VtNotifier.php';
require_once $_vtLib . '/VtHistory.php';
require_once $_vtLib . '/VtManualQueue.php';
require_once $_vtLib . '/VtEvents.php';
require_once $_vtLib . '/VtScanEngine.php';
require_once $_vtLib . '/VtReviews.php';
require_once $_vtLib . '/VtSiteLog.php';
require_once $_vtLib . '/VtAvastStore.php';
require_once $_vtLib . '/VtLogRotate.php';
require_once $_vtLib . '/VtSafeBrowsing.php';
require_once $_vtLib . '/VtExternal.php';
require_once $_vtLib . '/VtPwned.php';

/**
 * IndexController — Plesk extension controller (extends pm_Controller_Action for layout).
 */
class IndexController extends pm_Controller_Action
{
    /**
     * PayPal.Me username for the "Buy me a coffee" button on the About tab.
     * Leave empty to hide the button.
     */
    private const PAYPAL_ME = 'zirk020';
    private const COFFEE_PRICE = '3USD';

    /** @var VtSettings */
    private $settings;
    /** @var VtApi */
    private $api;
    /** @var VtCache */
    private $cache;
    /** Effective API key (own key, or admin's key as fallback) */
    private string $effectiveApiKey = '';
    /** True when using the admin's key as a fallback */
    private bool $usingAdminKey = false;

    public function init(): void
    {
        parent::init();
        $userId         = $this->resolveUserId();
        $this->settings = new VtSettings($userId);
        // Use own API key; fall back to admin's key if the user hasn't configured one
        $ownKey = $this->settings->get('api_key') ?: '';
        if ($ownKey) {
            $this->effectiveApiKey = $ownKey;
        } elseif ($userId !== 'admin') {
            $adminKey = (new VtSettings('admin'))->get('api_key') ?: '';
            if ($adminKey) {
                $this->effectiveApiKey = $adminKey;
                $this->usingAdminKey   = true;
            }
        }
        $this->api   = new VtApi($this->effectiveApiKey);
        $this->cache = new VtCache($this->settings);
        // Use .php view extension (not .phtml)
        $this->getHelper('ViewRenderer')->setViewSuffix('php');
    }

    private function resolveUserId(): string
    {
        try {
            $client = pm_Session::getClient();
            if ($client !== null) {
                return $client->getLogin();
            }
        } catch (\Throwable $e) {
            // pm_Session not available or admin context
        }
        return 'admin';
    }

    // ── Page ────────────────────────────────────────────────────

    public function indexAction(): void
    {
        // Browser tab title; Plesk's own page header is hidden by the view (branded header instead)
        $this->view->pageTitle = 'Stingy Scanner';
        $this->view->baseUrl   = pm_Context::getBaseUrl();
        $version = $this->installedVersion();
        $this->view->version   = $version;
        // The old extension (VT Site Scanner 1.x) still installed next to Stingy Scanner: both would scan
        $this->view->oldVtInstalled = $this->role() === 'admin' && basename(dirname(__DIR__)) !== 'virustotal-extension'
            && is_dir('/usr/local/psa/admin/plib/modules/virustotal-extension');
        $this->view->paypalUrl = self::PAYPAL_ME !== ''
            ? 'https://www.paypal.com/paypalme/' . rawurlencode(self::PAYPAL_ME) . '/' . self::COFFEE_PRICE
            : '';
        // All scan data is fetched via AJAX
    }

    // ── AJAX ────────────────────────────────────────────────────

    public function scanAction(): void
    {
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain) { $this->respond(['error' => 'invalid']); return; }
        if (!$this->mayCheck($domain)) {
            $this->respond(['error' => 'forbidden']); return;
        }

        $cached = $this->cache->get($domain);

        // force=1: bypass cache (used right after a manual rescan completes)
        $force = (bool)$this->_getParam('force', false);
        if ($cached && !$force && !$this->cache->isStale($domain)) {
            $this->respond($cached); return;
        }

        if (!$this->effectiveApiKey) {
            $this->respond(['status' => 'error', 'domain' => $domain, 'message' => 'No API key configured']); return;
        }

        $canSpend = $this->cache->autoBudgetRemaining() > 0
            || ($force && $this->cache->manualBudgetRemaining() > 0);
        if ($canSpend) {
            $result = $this->api->getReport($domain);
            // Don't cache or charge budget for auth errors (401) — bad API key
            $isAuthError = $result['status'] === 'error' && ($result['http_code'] ?? 0) === 401;
            if ($isAuthError) {
                $this->appendLog("[scan] error $domain — invalid API key (401)");
                $this->respond(['status' => 'error', 'domain' => $domain, 'message' => 'Invalid API key (401)']); return;
            }
            $status = $result['status'];
            if ($status === 'infected') {
                $score = isset($result['malicious'], $result['total']) ? " ({$result['malicious']}/{$result['total']})" : '';
                $vendors = !empty($result['flagged_by']) ? ' — ' . implode(', ', array_slice($result['flagged_by'], 0, 3)) : '';
                $this->appendLog("[scan] INFECTED $domain$score$vendors");
            } elseif ($status === 'suspicious') {
                $score = isset($result['malicious'], $result['total']) ? " ({$result['malicious']}/{$result['total']})" : '';
                $this->appendLog("[scan] suspicious $domain$score");
            } elseif ($status === 'clean') {
                $score = isset($result['total']) ? " (0/{$result['total']})" : '';
                $this->appendLog("[scan] clean $domain$score");
            } elseif ($status === 'error') {
                $code = $result['http_code'] ?? '?';
                $this->appendLog("[scan] error $domain HTTP $code");
            } elseif ($status === 'ratelimit') {
                $this->appendLog("[scan] ratelimit (per-minute) $domain");
            } elseif ($status === 'quota_exceeded') {
                $ra = $result['retry_after'] ?? null;
                $resets = $ra ? ' resets in ' . gmdate('H\hi', $ra) . ' UTC' : '';
                $this->appendLog("[scan] quota_exceeded$resets $domain");
            } else {
                $this->appendLog("[scan] $status $domain");
            }
            if ($result['status'] !== 'ratelimit' && $result['status'] !== 'quota_exceeded') {
                $this->cache->set($domain, $result, false);
                try {
                    $mailed = VtNotifier::flush(false); // summaries whose oldest change waited 10 min
                    if ($mailed) $this->appendLog('[mail] summary sent to ' . implode(', ', $mailed));
                } catch (\Throwable $e) {
                }
                $this->respond($result); return;
            }
            // Pass ratelimit/quota_exceeded through to frontend — do NOT cache
            $this->respond($result); return;
        }

        if ($cached) {
            $cached['stale'] = true;
            $this->respond($cached);
        } else {
            $this->respond(['status' => 'ratelimit', 'domain' => $domain, 'message' => 'VT rate limit — try again shortly']);
        }
    }

    public function reanalyzeAction(): void
    {
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain) { $this->respond(['error' => 'invalid']); return; }
        if (!$this->mayCheck($domain)) {
            $this->respond(['error' => 'forbidden']); return;
        }

        if ($this->cache->manualBudgetRemaining() <= 0) {
            $this->respond(['status' => 'budget_exceeded', 'domain' => $domain,
                            'message' => 'Daily limit for manual rescans reached']);
            return;
        }

        $result = $this->api->reanalyze($domain);
        if ($result['status'] === 'queued') {
            // Keep the previous result in cache (no "pending" overwrite) — the UI
            // fetches the fresh report with scan&force=1 once VT has finished.
            $this->cache->charge(true);
            $this->appendLog("[manual] Rescan started: $domain");
        } elseif ($result['status'] === 'ratelimit') {
            $this->appendLog("[manual] Rate-limit (per-minute) on rescan: $domain");
        } elseif ($result['status'] === 'quota_exceeded') {
            $this->appendLog("[manual] Quota exceeded on rescan: $domain");
        } else {
            $code = $result['http_code'] ?? '?';
            $this->appendLog("[manual] Error on rescan: $domain (HTTP $code)");
        }
        $this->respond($result);
    }

    public function pollAnalysisAction(): void
    {
        $id = $this->_getParam('id', '');
        // Analysis IDs look like: u-<hex>-<timestamp> or similar alphanumeric
        if (!$id || !preg_match('/^[a-zA-Z0-9_\-]+$/', $id)) {
            $this->respond(['error' => 'invalid']); return;
        }
        $this->respond($this->api->getAnalysisStatus($id));
    }

    public function domainsQuickAction(): void
    {
        // Fast path: just the domain list + budget — no results file, no history write.
        // Used by the JS init to render the domain table immediately while full data loads.
        $domains = PleskDomains::forCurrentUser($this->wpOnly());
        $budgetInfo = $this->cache->budgetInfo();
        $budgetInfo['vt_quota_used'] = VtRateLimiter::todayCountForKey($this->effectiveApiKey);
        $this->respond([
            'domains' => $domains,
            'count'   => count($domains),
            'budget'  => $budgetInfo,
        ]);
    }

    public function allAction(): void
    {
        $domains    = PleskDomains::forCurrentUser($this->wpOnly());
        $related    = PleskDomains::relatedForCurrentUser();
        $allResults = $this->cache->all();
        // Filter cached results to only domains this user has access to
        $results = array_intersect_key($allResults, array_flip(array_merge($domains, $related)));
        $budgetInfo = $this->cache->budgetInfo();
        $budgetInfo['vt_quota_used'] = VtRateLimiter::todayCountForKey($this->effectiveApiKey);
        // Today's totals for the trend graph: the whole server for the admin, otherwise the user's own sites
        VtHistory::scope($this->historyScope());
        VtHistory::record(array_map(fn($d) => (string)($allResults[$d]['status'] ?? 'unknown'), array_combine($domains, $domains)));
        $external = VtExternal::forCurrentUser();
        $owners   = $this->role() === 'client' ? [] : PleskDomains::owners(array_merge($domains, $related));
        foreach ($external as $d) if ($this->role() !== 'client') $owners[$d] = ['c' => 'External sites', 'cl' => '', 'ct' => 'external', 'r' => '', 'rl' => ''];
        $this->respond([
            'domains' => $domains,
            'related' => $related,
            'external' => $this->externalList(),
            'owners'  => $owners,
            'panel'   => PleskDomains::panelUrls($domains, $this->role()),
            'orphans' => $this->role() === 'admin' ? self::orphanInfo($related) : [],
            'results' => $results,
            'budget'  => $budgetInfo,
            'scans'    => self::scanResults($domains),
            'scanners' => self::enabledScanners(),
            'fileact'  => ['admin' => $this->role() === 'admin', 'qdays' => (int)(new VtSettings('admin'))->get('quarantine_days', 30),
                           'imunify' => (bool)array_filter(self::scanners(), fn($s) => $s['id'] === 'imunify' && !empty($s['installed']) && !empty($s['cleanup']))],
            'reviews' => VtReviews::forDomains(array_merge($domains, $related)),
            'history'  => array_values(array_intersect(VtSiteLog::domains(), array_merge($domains, $related))),
            'avast'    => self::avastInfo($domains),
            'gsb'      => VtSafeBrowsing::enabled() ? ['enabled' => true, 'fresh' => VtSafeBrowsing::FRESH, 'review' => VtSafeBrowsing::REVIEW_URL,
                                                       'results' => VtSafeBrowsing::results($domains)] : ['enabled' => false],
        ]);
    }

    /** Avast / AVG classification: the products switched on and the latest results for these sites */
    private static function avastInfo(array $domains): array
    {
        $ps = VtAvastStore::products();
        if (!$ps) return ['products' => []];
        return ['products' => array_map(fn($p) => ['id' => $p, 'name' => VtAvast::PRODUCTS[$p], 'form' => VtAvast::FP_FORMS[$p]], $ps),
                'results'  => VtAvastStore::results($domains)];
    }

    /** Live Google Safe Browsing check of one site: when its details are opened (reuses a result of the last 30 minutes) or after a rescan (force=1) */
    public function gsbLiveAction(): void
    {
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain || !$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        if (!VtSafeBrowsing::enabled()) { $this->respond(['error' => 'This check is switched off']); return; }
        $this->respond(['result' => VtSafeBrowsing::live($domain, (bool)$this->_getParam('force', false))]);
    }

    /** Live Avast / AVG check of one site: when its details are opened (reuses a result of the last 5 minutes) or after a rescan (force=1) */
    public function avastLiveAction(): void
    {
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain || !$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        $p = (int)$this->_getParam('product', 0);
        if (!in_array($p, VtAvastStore::products(), true)) { $this->respond(['error' => 'This check is switched off']); return; }
        $this->respond(['product' => $p, 'result' => VtAvastStore::live($domain, $p, (bool)$this->_getParam('force', false))]);
    }

    /** Remember (or forget, with remove=1) that a review was requested from a vendor for a site */
    public function reviewMarkAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        $vendor = trim(substr((string)$this->_getParam('vendor', ''), 0, 80));
        if (!$domain || $vendor === '') { $this->respond(['error' => 'invalid']); return; }
        if (!$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        $by     = $this->resolveUserId();
        $denied = (bool)$this->_getParam('denied', false); // the vendor turned it down: forget the request, log why
        $remove = $denied || (bool)$this->_getParam('remove', false);
        $reason = $denied ? trim(mb_substr((string)$this->_getParam('reason', ''), 0, 300)) : null;
        // The review target is shown as a link in the site history: only an http(s) address or an e-mail address
        $to = trim(substr((string)$this->_getParam('to', ''), 0, 300));
        if ($to !== '' && !filter_var($to, FILTER_VALIDATE_EMAIL)
            && !(preg_match('#^https?://#i', $to) && filter_var($to, FILTER_VALIDATE_URL))) $to = '';
        VtSiteLog::review($domain, $vendor, (string)$this->_getParam('via', 'form'), $to, $by, $remove, $reason);
        $this->respond(['ok' => true, 'reviews' => VtReviews::mark($domain, $vendor, $by, $remove)]);
    }

    /** History of one site: detections, vendors that started or stopped flagging it, status changes, review requests */
    public function siteHistoryAction(): void
    {
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain || !$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        // Once: the first detections from before the history existed, found in the scan logs
        $marker = VtDataDir::path('vt_sitelog_backfilled');
        if (!file_exists($marker) && @touch($marker)) VtSiteLog::backfillFromLogs();
        $this->respond(['domain' => $domain, 'history' => VtSiteLog::history($domain)]);
    }

    // ── File scanners (ClamAV, maldet, …), on demand ───────────

    /**
     * What the root helper found: ['scanners' => [{id, name, installed, instant, detail}], 'engines' => [clamav => …, maldet => …]].
     * Cached for an hour; detected again when the administrator opens Settings or clicks "Re-detect engines".
     */
    private static function detection(bool $fresh = false): array
    {
        $cache = VtDataDir::path('vt_scanners.json');
        if (!$fresh && is_file($cache) && time() - filemtime($cache) < 3600) {
            $d = json_decode((string)file_get_contents($cache), true);
            if (is_array($d) && isset($d['scanners'], $d['engines'])) return $d;
        }
        try {
            $res = pm_ApiCli::callSbin('site-scan', ['list'], pm_ApiCli::RESULT_FULL);
            $d   = json_decode(trim((string)($res['stdout'] ?? '')), true);
        } catch (\Throwable $e) {
            $d = null;
        }
        if (!is_array($d) || !is_array($d['scanners'] ?? null) || !is_array($d['engines'] ?? null)) {
            return ['scanners' => [], 'engines' => ['clamav' => ['installed' => false], 'maldet' => ['installed' => false]], 'failed' => true];
        }
        @file_put_contents($cache, json_encode($d));
        return $d;
    }

    private static function scanners(bool $fresh = false): array { return self::detection($fresh)['scanners']; }

    /** "Maldet enabled" (server-wide, default off). Only matters when ClamAV is not installed. */
    private static function maldetEnabled(): bool
    {
        return (bool)(new VtSettings('admin'))->get('maldet_enabled', false);
    }

    /** Scanners switched off by the administrator (server-wide; now only used for Imunify) */
    private static function disabledScanners(): array
    {
        $d = (new VtSettings('admin'))->get('scanners_disabled', []);
        return is_array($d) ? $d : [];
    }

    private static function imunifyOn(): bool
    {
        foreach (self::scanners() as $s) {
            if ($s['id'] === 'imunify') return !empty($s['installed']) && !in_array('imunify', self::disabledScanners(), true);
        }
        return false;
    }

    /**
     * The buttons in a site's details: ONE scan engine (VtScanEngine decides which), or a disabled
     * button with the reason, plus Imunify's results when switched on.
     */
    private static function enabledScanners(): array
    {
        return VtScanEngine::buttons(self::detection()['engines'], self::maldetEnabled(), self::imunifyOn());
    }

    /** Engine status and switches, for the settings page */
    private static function scannerSettings(bool $fresh = false): array
    {
        $d   = self::detection($fresh);
        $imu = null;
        foreach ($d['scanners'] as $s) if ($s['id'] === 'imunify') $imu = $s;
        return [
            'failed'         => !empty($d['failed']),
            'engines'        => $d['engines'],
            'active'         => VtScanEngine::select($d['engines'], self::maldetEnabled()),
            'maldet_enabled' => self::maldetEnabled(),
            'clamav_detail'  => self::detailOf($d['scanners'], 'clamav'),
            'imunify'        => ['installed' => !empty($imu['installed']), 'detail' => (string)($imu['detail'] ?? ''),
                                 'enabled' => !in_array('imunify', self::disabledScanners(), true)],
            'buttons'        => VtScanEngine::buttons($d['engines'], self::maldetEnabled(), self::imunifyOn()),
        ];
    }

    private static function detailOf(array $list, string $id): string
    {
        foreach ($list as $s) if ($s['id'] === $id) return (string)($s['detail'] ?? '');
        return '';
    }

    /** Detect the installed engines again (after installing or removing one) */
    public function detectScannersAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $this->respond(['scanners' => self::scannerSettings(true)]);
    }

    /** Server-wide switches (administrator only): "Maldet enabled", and Imunify on/off */
    public function saveScannerAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can change the scanners']); return; }
        $id = (string)$this->_getParam('scanner', '');
        $on = filter_var($this->_getParam('enabled', ''), FILTER_VALIDATE_BOOLEAN);
        if ($id === 'maldet') {
            (new VtSettings('admin'))->setAll(['maldet_enabled' => $on]);
            $this->appendLog('[files] Maldet ' . ($on ? 'enabled' : 'disabled') . ' (used only when ClamAV is not installed)');
        } elseif ($id === 'imunify') {
            $off = array_values(array_diff(self::disabledScanners(), ['imunify']));
            if (!$on) $off[] = 'imunify';
            (new VtSettings('admin'))->setAll(['scanners_disabled' => $off]);
            $this->appendLog('[files] Imunify results ' . ($on ? 'switched on' : 'switched off'));
        } else {
            $this->respond(['error' => 'The scan engine is chosen automatically']); return;
        }
        $this->respond(['ok' => true, 'scanners' => self::scannerSettings()]);
    }

    private function scanParams(): ?array
    {
        $domain  = $this->sanitize($this->_getParam('domain', ''));
        $scanner = (string)$this->_getParam('scanner', '');
        if (!$domain || !preg_match('/^[a-z0-9]+$/', $scanner)) { $this->respond(['error' => 'invalid']); return null; }
        if (!in_array($scanner, array_column(self::enabledScanners(), 'id'), true)) {
            $this->respond(['error' => 'This scanner is switched off or not installed']); return null;
        }
        if (VtExternal::is($domain)) { $this->respond(['error' => 'This site is not hosted on this server, so its files cannot be scanned']); return null; }
        if (!in_array($domain, PleskDomains::hostedForCurrentUser($this->wpOnly()), true)) {
            $this->respond(['error' => 'forbidden']); return null;
        }
        return [$domain, $scanner];
    }

    /** Start a file scan of one site (runs in the background as root) */
    public function fileScanAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if (!($p = $this->scanParams())) return;
        [$domain, $scanner] = $p;
        try {
            $res = pm_ApiCli::callSbin('site-scan', ['start', $scanner, $domain], pm_ApiCli::RESULT_FULL);
            $out = json_decode(trim((string)($res['stdout'] ?? '')), true);
        } catch (\Throwable $e) {
            $out = ['error' => 'Could not start the scan: ' . $e->getMessage()];
        }
        if (!is_array($out)) $out = ['error' => 'Could not start the scan'];
        if (!empty($out['started']) && empty($out['already'])) $this->appendLog("[files] {$out['name']} scan started: $domain");
        $this->respond($out + ['result' => self::scanResult($scanner, $domain)]);
    }

    /** Current file-scan result of one site and scanner */
    // ── Clean (Imunify) and quarantine infected files, administrator only ──
    // All file work happens in sbin/site-scan fileact (root, file I/O as the site user).

    private const FA_STORE = 'vt_fileactions.json'; // { domain: { file: {status, at, by, type} } }: files Imunify cleaned

    private static function faStore(?callable $change = null): array
    {
        $f  = VtDataDir::path(self::FA_STORE);
        $fp = @fopen($f . '.lock', 'c');
        if ($fp) flock($fp, LOCK_EX);
        $d = json_decode((string)@file_get_contents($f), true);
        if (!is_array($d)) $d = [];
        if ($change) {
            $d = $change($d);
            if (@file_put_contents($f . '.tmp', json_encode($d)) !== false) @rename($f . '.tmp', $f);
        }
        if ($fp) { flock($fp, LOCK_UN); fclose($fp); }
        return $d;
    }

    private static function faSbin(array $args): array
    {
        try {
            $res = pm_ApiCli::callSbin('site-scan', array_merge(['fileact'], $args), pm_ApiCli::RESULT_FULL);
            $out = json_decode(trim((string)($res['stdout'] ?? '')), true);
        } catch (\Throwable $e) {
            return ['error' => 'The server helper failed: ' . $e->getMessage()];
        }
        return is_array($out) ? $out : ['error' => 'No answer from the server helper'];
    }

    /**
     * A file was cleaned or quarantined ($action), or put back ($action null): mark it in the stored
     * results of every file scanner of the site, so it no longer counts as infected (and counts again after a restore).
     */
    private static function faMarkResults(string $domain, string $file, ?string $action): void
    {
        foreach (['clamav', 'maldet', 'imunify'] as $sid) {
            $f = self::scanFile($sid, $domain);
            $d = json_decode((string)@file_get_contents($f), true);
            if (!is_array($d) || empty($d['found'])) continue;
            $changed = false;
            foreach ($d['found'] as &$e) {
                if (($e['file'] ?? '') !== $file) continue;
                $had = !empty($e['action']);
                if ($action !== null) {
                    $e['action'] = $action;
                    if (!$had && empty($e['handled'])) $d['infected'] = max(0, (int)($d['infected'] ?? 0) - 1);
                } elseif ($had) {
                    unset($e['action']);
                    if (empty($e['handled'])) $d['infected'] = (int)($d['infected'] ?? 0) + 1;
                }
                $changed = true;
            }
            unset($e);
            if ($changed) @file_put_contents($f, json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    /** Quarantine: number and size of the files, and how long they are kept (Settings, administrator) */
    private static function quarantineInfo(): array
    {
        return self::faSbin(['qinfo']) + ['days' => (int)(new VtSettings('admin'))->get('quarantine_days', 30)];
    }

    /** Current number and size of the quarantined files (Settings, when the tab is opened) */
    public function quarantineInfoAction(): void
    {
        if ($this->role() !== 'admin') { $this->respond(['quarantine' => null]); return; }
        $this->respond(['quarantine' => self::quarantineInfo()]);
    }

    /** Delete every quarantined file for good (Settings, administrator) */
    public function quarantineDeleteAllAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can do this']); return; }
        $r  = self::faSbin(['qdeleteall']);
        $by = $this->resolveUserId();
        foreach ($r['deleted'] ?? [] as $q) {
            VtSiteLog::fileAction($q['domain'], 'qdelete', $q['rel'], $by, 'deleted from quarantine (delete all)');
            self::faMarkResults($q['domain'], $q['rel'], 'deleted');
        }
        $this->appendLog('[files] quarantine emptied by ' . $by . ': ' . count($r['deleted'] ?? []) . ' file(s) deleted');
        $this->respond(['ok' => empty($r['error']), 'deleted' => count($r['deleted'] ?? []), 'quarantine' => self::quarantineInfo()]
                       + (isset($r['error']) ? ['error' => $r['error']] : []));
    }

    /** Cleaned and quarantined files of a site: [{file, action: cleaned|quarantined, at, by?, status?, qid?}] */
    private static function faHandled(string $domain): array
    {
        $out = [];
        foreach (self::faStore()[$domain] ?? [] as $file => $e) {
            $out[] = ['file' => (string)$file, 'action' => 'cleaned'] + $e;
        }
        foreach (self::faSbin(['qlist', $domain])['items'] ?? [] as $q) {
            $out[] = ['file' => $q['rel'], 'action' => 'quarantined', 'at' => $q['at'], 'qid' => $q['qid'], 'by' => $q['by'] ?? '',
                      'size' => $q['size'], 'owner' => $q['owner']];
        }
        usort($out, fn($a, $b) => ($b['at'] ?? 0) <=> ($a['at'] ?? 0));
        return $out;
    }

    private function faDomain(): ?string
    {
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can clean or quarantine files']); return null; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain || !in_array($domain, PleskDomains::hostedForCurrentUser(false), true)) { $this->respond(['error' => 'forbidden']); return null; }
        return $domain;
    }

    /** Files of a site that were cleaned or quarantined */
    public function fileHandledAction(): void
    {
        if (!($domain = $this->faDomain())) return;
        $this->respond(['handled' => self::faHandled($domain)]);
    }

    /**
     * One action on one file: check | diff | clean | restore (Imunify) · quarantine | unquarantine.
     * check/diff change nothing. clean and quarantine always have an undo (restore / unquarantine).
     */
    public function fileActAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if (!($domain = $this->faDomain())) return;
        $op   = (string)$this->_getParam('op', '');
        $file = (string)$this->_getParam('file', '');
        $by   = $this->resolveUserId();
        if (!in_array($op, ['check', 'diff', 'clean', 'restore', 'quarantine', 'unquarantine', 'qdelete'], true)) { $this->respond(['error' => 'Unknown action']); return; }
        if ($op === 'unquarantine' || $op === 'qdelete') {
            $qid = (string)$this->_getParam('qid', '');
            $own = array_column(self::faSbin(['qlist', $domain])['items'] ?? [], 'rel', 'qid');
            if (!isset($own[$qid])) { $this->respond(['error' => 'This file is no longer in quarantine']); return; }
            $file = $own[$qid];
            $r = self::faSbin([$op, $qid]);
        } else {
            if ($file === '' || strlen($file) > 4000) { $this->respond(['error' => 'Invalid file path']); return; }
            $r = self::faSbin($op === 'quarantine' ? [$op, $domain, $file, $by] : [$op, $domain, $file]);
        }
        if (!empty($r['ok'])) {
            $sig = (string)($r['item']['type'] ?? '');
            switch ($op) {
                case 'clean':
                    $st = (string)($r['status'] ?? '');
                    self::faStore(function ($d) use ($domain, $file, $st, $by, $sig) {
                        $d[$domain][$file] = ['status' => $st, 'at' => time(), 'by' => $by, 'type' => $sig];
                        return $d;
                    });
                    $what = strpos($st, 'cleanup_removed') === 0 ? 'removed the malicious file content' : 'cleaned the file';
                    VtSiteLog::fileAction($domain, 'clean', $file, $by, 'Imunify ' . $what . ($sig ? ' (' . $sig . ')' : ''));
                    $this->appendLog("[files] Imunify cleaned $domain/$file ($st) by $by");
                    self::faMarkResults($domain, $file, 'cleaned');
                    break;
                case 'restore':
                    self::faStore(function ($d) use ($domain, $file) { unset($d[$domain][$file]); if (empty($d[$domain])) unset($d[$domain]); return $d; });
                    VtSiteLog::fileAction($domain, 'unclean', $file, $by, 'original restored by Imunify');
                    $this->appendLog("[files] Imunify restored the original of $domain/$file by $by");
                    self::faMarkResults($domain, $file, null);
                    break;
                case 'quarantine':
                    VtSiteLog::fileAction($domain, 'quarantine', $file, $by, 'moved to quarantine (' . (int)($r['item']['size'] ?? 0) . ' bytes)');
                    $this->appendLog("[files] quarantined $domain/$file by $by");
                    self::faMarkResults($domain, $file, 'quarantined');
                    break;
                case 'unquarantine':
                    VtSiteLog::fileAction($domain, 'unquarantine', $file, $by, 'put back from quarantine' . (!empty($r['note']) ? '; ' . $r['note'] : ''));
                    $this->appendLog("[files] restored $domain/$file from quarantine by $by");
                    self::faMarkResults($domain, $file, null);
                    break;
                case 'qdelete':
                    VtSiteLog::fileAction($domain, 'qdelete', $file, $by, 'deleted from quarantine for good');
                    $this->appendLog("[files] deleted $domain/$file from quarantine by $by");
                    self::faMarkResults($domain, $file, 'deleted');
                    break;
            }
            $r['handled'] = self::faHandled($domain);
        } elseif (in_array($op, ['clean', 'restore', 'quarantine', 'unquarantine', 'qdelete'], true)) {
            $verb = ['clean' => 'clean', 'restore' => 'undo the cleanup of', 'quarantine' => 'quarantine', 'unquarantine' => 'restore', 'qdelete' => 'delete from quarantine'][$op];
            $this->appendLog("[files] could not $verb $domain/$file: " . ($r['error'] ?? 'unknown error') . " (by $by)");
        }
        $this->respond($r);
    }

    public function fileResultAction(): void
    {
        if (!($p = $this->scanParams())) return;
        [$domain, $scanner] = $p;
        $r = self::scanResult($scanner, $domain);
        if ($r && !in_array($r['status'] ?? '', ['running', 'queued'], true) && empty($r['logged'])) {
            // Log a finished scan once
            $this->appendLog(sprintf('[files] %s %s: %s', $r['name'] ?? $scanner, $domain, ($r['status'] ?? '') === 'done'
                ? (($r['infected'] ?? 0) ? $r['infected'] . ' infected file(s)' : 'no infected files') . ' in ' . ($r['files'] ?? 0) . ' files'
                : ($r['message'] ?? $r['status'] ?? 'error')));
            $r['logged'] = true;
            @file_put_contents(self::scanFile($scanner, $domain), json_encode($r, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        $this->respond(['result' => $r]);
    }

    private static function scanFile(string $scanner, string $domain): string
    {
        return VtDataDir::path('vt_scan_' . $scanner . '_' . preg_replace('/[^a-z0-9]/', '_', $domain) . '.json');
    }

    private static function scanResult(string $scanner, string $domain): ?array
    {
        $d = json_decode((string)@file_get_contents(self::scanFile($scanner, $domain)), true);
        if (!is_array($d)) return null;
        // A scan that has said "running" or "queued" for hours has died
        if (in_array($d['status'] ?? '', ['running', 'queued'], true) && time() - (int)($d['started'] ?? 0) > 4200 * 3) {
            $d['status'] = 'error'; $d['message'] = 'The scan stopped unexpectedly';
        }
        return $d;
    }

    /** File-scan results of the given domains (without file lists): [domain => [scanner => result]] */
    private static function scanResults(array $domains): array
    {
        $want = array_flip($domains);
        $on   = array_flip(array_column(self::enabledScanners(), 'id'));
        $out  = [];
        foreach (glob(VtDataDir::path('vt_scan_*.json')) ?: [] as $f) {
            $d = json_decode((string)@file_get_contents($f), true);
            if (!is_array($d) || !isset($d['domain'], $d['scanner'], $want[$d['domain']], $on[$d['scanner']])) continue;
            $r = self::scanResult($d['scanner'], $d['domain']);
            unset($r['found']);
            $out[$d['domain']][$d['scanner']] = $r;
        }
        return $out;
    }

    // ── Manual rescan server queue ───────────────────────────────

    /** Push a domain into the persistent manual rescan queue (called on Rescan click). */
    public function enqueueRescanAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain) { $this->respond(['error' => 'invalid']); return; }
        if (!$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        VtManualQueue::enqueue([$domain]);
        $this->respond(['ok' => true]);
    }

    /** Remove a domain from the queue (browser completed it before cron could). */
    public function dequeueRescanAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain) { $this->respond(['error' => 'invalid']); return; }
        if (!$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        VtManualQueue::dequeue([$domain]);
        $this->respond(['ok' => true]);
    }

    /** Heartbeat: this page still has these rescans (running or waiting), so cron leaves them alone */
    public function rescanAliveAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $list = array_slice(array_filter(array_map([$this, 'sanitize'], explode(',', (string)$this->_getParam('domains', '')))), 0, 500);
        VtManualQueue::touch(array_values(array_filter($list, fn($d) => $this->mayCheck($d))));
        $this->respond(['ok' => true]);
    }

    /** Current state of the server-side manual queue (filtered to this user's domains). */
    public function queueStatusAction(): void
    {
        $q    = VtManualQueue::all();
        $mine = array_flip(PleskDomains::forCurrentUser($this->wpOnly()));
        $pend = array_values(array_filter($q['pending']   ?? [], fn($d) => isset($mine[$d])));
        $done = array_values(array_filter($q['completed'] ?? [], fn($d) => isset($mine[$d])));
        $this->respond([
            'pending'      => $pend,
            'queued_at'    => array_intersect_key($q['queued_at']    ?? [], array_flip($pend)),
            'completed'    => $done,
            'completed_at' => array_intersect_key($q['completed_at'] ?? [], array_flip($done)),
        ]);
    }

    public function refreshDomainsAction(): void
    {
        PleskDomains::invalidateCache();
        $this->respond(['domains' => PleskDomains::forCurrentUser($this->wpOnly())]);
    }

    public function budgetAction(): void
    {
        $info = $this->cache->budgetInfo();
        $info['vt_quota_used'] = VtRateLimiter::todayCountForKey($this->effectiveApiKey);
        $this->respond($info);
    }

    public function installUpdateAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Administrator only']); return; }

        try {
            $res = pm_ApiCli::callSbin('extension-update', ['start', (string)$this->_getParam('version', '')], pm_ApiCli::RESULT_FULL);
            $data = json_decode(trim((string)($res['stdout'] ?? '')), true);
            $this->respond(is_array($data) ? $data : ['error' => 'Could not start the privileged updater']);
        } catch (\Throwable $e) {
            $this->respond(['error' => $e->getMessage()]);
        }
    }

    public function updateStatusAction(): void
    {
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Administrator only']); return; }
        try {
            $res = pm_ApiCli::callSbin('extension-update', ['status'], pm_ApiCli::RESULT_FULL);
            $data = json_decode(trim((string)($res['stdout'] ?? '')), true);
            $this->respond(is_array($data) ? $data : ['error' => 'Cannot read update status']);
        } catch (\Throwable $e) {
            $this->respond(['error' => $e->getMessage()]);
        }
    }

    public function checkUpdateAction(): void
    {
        // Current version is always read fresh — never cached — so it updates immediately after an upgrade
        $current = $this->installedVersion();

        // Only the GitHub API response is cached (avoid hitting the API on every page load)
        $cacheFile = VtDataDir::path('vt_update_check.json');
        $github    = null;
        if (is_file($cacheFile) && time() - filemtime($cacheFile) < 900) {
            $d = json_decode((string)file_get_contents($cacheFile), true);
            if (is_array($d) && isset($d['latest'])) $github = $d;
        }

        if (!$github) {
            $ch = curl_init('https://api.github.com/repos/dzaal/StingyScan-for-Plesk/releases/latest');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 10,
                CURLOPT_HTTPHEADER     => ['User-Agent: Stingy Scanner-Plesk/' . $current],
                CURLOPT_FOLLOWLOCATION => true,
            ]);
            $raw  = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code !== 200 || !$raw) {
                $this->respond(['error' => 'Could not reach GitHub', 'current' => $current]); return;
            }
            $data   = json_decode($raw, true);
            $latest = ltrim((string)($data['tag_name'] ?? ''), 'v');
            $url    = (string)($data['html_url'] ?? '');
            // Stable URL — works for every release as long as the asset is named
            // stingyscan.zip (without version number).
            $zip = 'https://github.com/dzaal/StingyScan-for-Plesk/releases/latest/download/stingyscan.zip';
            $github = ['latest' => $latest, 'url' => $url, 'zip' => $zip];
            @file_put_contents($cacheFile, json_encode($github));
        }

        $this->respond([
            'current'          => $current,
            'latest'           => $github['latest'],
            'url'              => $github['url'],
            'zip'              => $github['zip'],
            'update_available' => $github['latest'] && $current
                                  && version_compare($github['latest'], $current, '>'),
        ]);
    }

    public function getLogAction(): void
    {
        $logFile = $this->userLogFile();
        if (!file_exists($logFile)) {
            $this->respond(['log' => '', 'size' => 0]);
            return;
        }
        // Return last 200 lines to avoid huge payloads
        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        $lines = array_slice($lines, -200);
        $this->respond(['log' => implode("\n", array_reverse($lines)), 'size' => filesize($logFile)]);
    }

    public function clearLogAction(): void
    {
        if (!$this->getRequest()->isPost() && !$this->_getParam('confirm')) {
            $this->respond(['error' => 'POST required']); return;
        }
        $logFile = $this->userLogFile();
        if (file_exists($logFile)) file_put_contents($logFile, '');
        $this->respond(['ok' => true]);
    }

    public function getSettingsAction(): void
    {
        $s   = $this->settings->all();
        $ownKey = $s['api_key'] ?? '';
        $s['api_key_readable'] = $ownKey;
        $s['role']             = $this->role();
        $s['my_email']         = VtNotifier::emailOfLogin($this->settings->getUserId()) ?? '';
        $s['has_key']          = !empty($ownKey) || $this->usingAdminKey;
        $s['scanners']         = self::scannerSettings($this->role() === 'admin'); // admin opens Settings: detect again
        $s['avast_products']   = VtAvastStore::products();
        $s['avast_calls']      = VtAvast::callsToday();
        if ($this->role() === 'admin') $s['log_rotation'] = VtLogRotate::settings() + VtLogRotate::info();
        if ($this->role() === 'admin') $s['quarantine'] = self::quarantineInfo();
        unset($s['gsb_api_key'], $s['pwned_hibp_key']); // the Google and HIBP keys never go to the browser
        if ($this->role() === 'admin') {
                $s['xon_enabled'] = true; // XposedOrNot breach check — free, no key
            $s['gsb'] = ['enabled' => (bool)(new VtSettings('admin'))->get('gsb_enabled', false),
                         'key' => VtSafeBrowsing::maskedKey(), 'calls' => VtSafeBrowsing::callsToday(), 'last' => VtSafeBrowsing::lastStatus()];
        }
        $s['check_rates']      = VtCheckRateLimiter::rates();
        unset($s['scanners_disabled']);
        $s['using_admin_key']  = false; // Never expose admin key fallback to non-admin users
        // Quick auth check using the effective key (own or admin fallback)
        if ($this->effectiveApiKey) {
            $testResult = $this->api->getReport('virustotal.com');
            $s['api_key_invalid'] = ($testResult['status'] === 'error' && ($testResult['http_code'] ?? 0) === 401);
        } else {
            $s['api_key_invalid'] = false;
        }
        $this->respond($s);
    }

    public function saveSettingsAction(): void
    {
        if (!$this->getRequest()->isPost()) {
            $this->respond(['error' => 'POST required']); return;
        }
        // Try JSON body first, fall back to form-encoded POST
        $raw = $this->getRequest()->getRawBody();
        $input = ($raw && $raw[0] === '{') ? (json_decode($raw, true) ?? []) : $this->getRequest()->getPost();

        $allowed = ['api_key', 'wordpress_only', 'wp_rogue_scan', 'notify_enabled', 'notify_events', 'notify_email', 'daily_limit', 'auto_scan_share', 'clean_ttl_days', 'infected_ttl_days'];
        $save    = [];
        foreach ($allowed as $k) {
            if (!isset($input[$k])) continue;
            if ($k === 'api_key') {
                $v = trim((string)$input[$k]);
                if ($v === '') continue;
                $save[$k] = $v;
            } elseif ($k === 'notify_events') {
                $list = array_filter(array_map('trim', explode(',', (string)$input[$k])));
                $save[$k] = array_values(array_intersect($list, VtNotifier::EVENTS));
            } elseif ($k === 'notify_email') {
                $v = trim((string)$input[$k]);
                if ($v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) {
                    $this->respond(['error' => 'Please enter a valid e-mail address']); return;
                }
                $save[$k] = $v;
            } elseif ($k === 'wordpress_only' || $k === 'notify_enabled' || $k === 'wp_rogue_scan') {
                $save[$k] = filter_var($input[$k], FILTER_VALIDATE_BOOLEAN);
            } elseif (in_array($k, ['daily_limit', 'clean_ttl_days', 'infected_ttl_days'])) {
                $save[$k] = max(1, (int)$input[$k]);
            } elseif ($k === 'auto_scan_share') {
                $save[$k] = max(0.1, min(0.95, (float)$input[$k]));
            }
        }

        if (isset($input['check_rates'])) {
            if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can change check rates']); return; }
            $rates = json_decode((string)$input['check_rates'], true);
            if (!is_array($rates)) { $this->respond(['error' => 'Invalid check rates']); return; }
            $valid = [];
            foreach ($rates as $source => $value) {
                if (!in_array($source, VtCheckRateLimiter::SOURCES, true) || !is_int($value) || $value < 1 || $value > 5) {
                    $this->respond(['error' => 'Each request limit must be a whole number from 1 to 5 per minute']); return;
                }
                $valid[$source] = (int)$value;
            }
            $save['check_rates'] = array_replace(VtCheckRateLimiter::rates(), $valid);
        }

        // Avast / AVG classification: one server-wide setting of the administrator
        if (isset($input['avast_products']) && $this->role() === 'admin') {
            $ps = array_values(array_unique(array_filter(array_map('intval', explode(',', (string)$input['avast_products'])), fn($p) => isset(VtAvast::PRODUCTS[$p]))));
            sort($ps);
            if ($this->settings->getUserId() === 'admin') $save['avast_products'] = $ps; // same file: saved below
            else (new VtSettings('admin'))->set('avast_products', $ps);
        }

        // Google Safe Browsing: server-wide settings of the administrator; a new key is tested first
        $gsbMsg = null;
        if ($this->role() === 'admin' && (isset($input['gsb_enabled']) || isset($input['gsb_api_key']))) {
            $gsb = [];
            if (isset($input['gsb_enabled'])) $gsb['gsb_enabled'] = filter_var($input['gsb_enabled'], FILTER_VALIDATE_BOOLEAN);
            $newKey = trim((string)($input['gsb_api_key'] ?? ''));
            if ($newKey !== '') {
                if (!preg_match('/^[A-Za-z0-9_\-]{20,100}$/', $newKey)) { $this->respond(['error' => 'That does not look like a Google API key']); return; }
                [$ok, $gsbMsg] = VtSafeBrowsing::testKey($newKey);
                if (!$ok) { $this->respond(['error' => 'Google Safe Browsing: ' . $gsbMsg]); return; }
                $gsb['gsb_api_key'] = $newKey;
            }
            if ($this->settings->getUserId() === 'admin') $save += $gsb; // same file: saved below
            else (new VtSettings('admin'))->setAll($gsb);
        }

        // Log rotation and quarantine: server-wide settings of the administrator
        if ($this->role() === 'admin') {
            $logCfg = [];
            if (isset($input['quarantine_days'])) $logCfg['quarantine_days'] = max(0, min(3650, (int)$input['quarantine_days']));
            foreach (array_keys(VtLogRotate::DEFAULTS) as $k) {
                if (isset($input[$k])) $logCfg[$k] = VtLogRotate::clamp($k, $input[$k]);
            }
            if ($logCfg) {
                if ($this->settings->getUserId() === 'admin') $save += $logCfg; // same file: saved below
                else (new VtSettings('admin'))->setAll($logCfg);
            }
        }
        if (isset($save['check_rates']) && $this->settings->getUserId() !== 'admin') {
            (new VtSettings('admin'))->set('check_rates', $save['check_rates']);
            unset($save['check_rates']);
        }
        $save['login'] = $this->settings->getUserId(); // lets the notifier find this user's address
        $this->settings->setAll($save);
        // Clear cached error results when API key changes so they get rescanned
        if (isset($save['api_key'])) {
            $this->cache->clearErrors();
        }
        $this->respond(['ok' => true, 'saved' => array_values(array_diff(array_keys($save), ['gsb_api_key'])), 'gsb_message' => $gsbMsg]);
    }

    // ── Helpers ─────────────────────────────────────────────────

    /** Send a test notification to the current user's own e-mail address */
    public function testNotifyAction(): void
    {
        if (!$this->getRequest()->isPost()) {
            $this->respond(['error' => 'POST required']); return;
        }
        $login = $this->settings->getUserId();
        $to    = trim((string)$this->getRequest()->getPost('email', ''));
        if ($to === '') $to = (string)($this->settings->get('notify_email') ?: VtNotifier::emailOfLogin($login));
        $sent  = VtNotifier::sendTest($login, $to);
        $this->respond($sent ? ['ok' => true, 'email' => $sent]
                             : ['error' => 'No valid e-mail address found for your Plesk account']);
    }

    /** Package version on disk, without depending on panel metadata caches. */
    private function installedVersion(): string
    {
        $file = dirname(__DIR__) . '/meta.xml';
        if (is_file($file)) {
            $meta = @simplexml_load_file($file);
            if ($meta && isset($meta->version)) return (string)$meta->version;
        }
        try { return (string)(pm_Context::getModuleInfo()->version ?? ''); }
        catch (\Throwable $e) { return ''; }
    }

    /** admin, reseller or client */
    private function role(): string
    {
        try {
            $c = pm_Session::getClient();
            if ($c->isAdmin()) return 'admin';
            if ($c->isReseller()) return 'reseller';
            return 'client';
        } catch (\Throwable $e) {
            return 'admin';
        }
    }

    // ── External sites (not hosted on this server) ─────────────

    /** The external sites this user sees: [{domain, by, role, added}] */
    private function externalList(): array
    {
        $all = VtExternal::all();
        return array_map(fn($d) => ['domain' => $d] + ($all[$d] ?? []), VtExternal::forCurrentUser());
    }

    /** Add or remove an external site: op=add|remove, domain */
    public function externalAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $op    = (string)$this->_getParam('op', '');
        $login = $this->resolveUserId();
        $role  = $this->role();
        if ($op === 'add') {
            $r = VtExternal::add((string)$this->_getParam('domain', ''), $login, $role, PleskDomains::hostedAll());
            if (!empty($r['ok'])) $this->appendLog('[external] ' . $r['domain'] . ' added by ' . $login);
        } elseif ($op === 'remove') {
            $d = VtExternal::normalize((string)$this->_getParam('domain', ''));
            $r = VtExternal::remove($d, $login, $role);
            if (!empty($r['ok'])) {
                $this->appendLog('[external] ' . $d . ' removed by ' . $login);
                VtManualQueue::dequeue([$d]);
            }
        } else {
            $r = ['error' => 'Unknown action'];
        }
        $this->respond($r + ['external' => $this->externalList()]);
    }

    // ── Pwned: WordPress administrators and addresses in known data breaches ──

    /** E-mail addresses this user sees: [email => true] (administrators of their WordPress sites, addresses they added) */
    private function pwnedEmails(?array &$sites = null, ?array &$custom = null, bool $fresh = false): array
    {
        $mine   = array_flip(PleskDomains::hostedForCurrentUser(false));
        $sites  = array_intersect_key(VtPwned::accounts($fresh), $mine);
        $custom = VtPwned::customFor($this->resolveUserId(), $this->role());
        $emails = [];
        foreach ($sites as $list) foreach ($list as $a) if ($a['email'] !== '') $emails[$a['email']] = true;
        foreach ($custom as $e => $_) $emails[$e] = true;
        return $emails;
    }

    private function pwnedSummary(): array
    {
        $src = VtPwned::source();
        $out = ['source' => $src, 'source_name' => VtPwned::SOURCES[$src] ?? '', 'admin' => $this->role() === 'admin'];
        if ($this->role() === 'admin') {
            $out['setting'] = (string)(new VtSettings('admin'))->get('pwned_source', '');
            $out['key'] = VtPwned::maskedKey();
            $out['calls'] = VtPwned::callsToday();
        }
        return $out;
    }

    /** The Pwned tab: accounts per site, addresses added by hand, and their breach results */
    public function pwnedAction(): void
    {
        $fresh  = $this->role() === 'admin' && (bool)$this->_getParam('fresh', false);
        $emails = $this->pwnedEmails($sites, $custom, $fresh);
        VtPwned::importXonCache(array_keys($emails));
        $this->respond([
            'sites'   => $sites,
            'custom'  => $custom,
            'results' => VtPwned::withDetails(array_intersect_key(VtPwned::results(), $emails)),
            'owners'  => $this->role() === 'client' ? [] : PleskDomains::owners(array_keys($sites)),
            'fixed'   => $this->role() === 'admin' ? array_intersect_key(self::pwnedFixed(), $emails) : [],
            'config'  => $this->pwnedSummary(),
        ]);
    }

    /** Check one address (email=...), or the next one that was never checked */
    public function pwnedCheckAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if (VtPwned::source() === '') { $this->respond(['error' => 'No breach source is chosen yet']); return; }
        $emails = $this->pwnedEmails();
        $res    = VtPwned::results();
        $want   = strtolower(trim((string)$this->_getParam('email', '')));
        if ($want !== '') {
            if (!isset($emails[$want])) { $this->respond(['error' => 'forbidden']); return; }
        } else {
            foreach ($emails as $e => $_) if (VtPwned::needsCheck($res[$e] ?? null)) { $want = $e; break; }
            if ($want === '') { $this->respond(['done' => true, 'remaining' => 0]); return; }
        }
        $r = VtPwned::check($want);
        if (($r['state'] ?? '') === 'ok' && !empty($r['breaches'])) $this->appendLog('[pwned] ' . $want . ' is in ' . count($r['breaches']) . ' breach(es)');
        if (($r['state'] ?? '') === 'failed') $this->appendLog('[pwned] check of ' . $want . ' failed: ' . ($r['error'] ?? ''));
        $res  = VtPwned::results();
        $left = 0;
        foreach ($emails as $e => $_) if (VtPwned::needsCheck($res[$e] ?? null)) $left++;
        $this->respond(['email' => $want, 'result' => VtPwned::withDetails([$r])[0], 'remaining' => $left]);
    }

    /** Addresses that were fixed: { email: {at, by, sites: [host], failed: [host]} } */
    private static function pwnedFixed(?callable $change = null): array
    {
        $f = VtDataDir::path('vt_pwned_fixed.json');
        $d = json_decode((string)@file_get_contents($f), true);
        if (!is_array($d)) $d = [];
        if ($change) { $d = $change($d); @file_put_contents($f, json_encode($d)); }
        return $d;
    }

    /**
     * Fix a pwned address (administrator): mode=preview shows the e-mail, mode=test sends it to another
     * address (to=…) without changing anything, mode=fix resets the password on every site where the
     * address is administrator, logs it out, and sends the e-mail to the address.
     */
    public function pwnedFixAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can do this']); return; }
        require_once dirname(__DIR__) . '/library/VtPwnedMail.php';
        $email = strtolower(trim((string)$this->_getParam('email', '')));
        $mode  = (string)$this->_getParam('mode', 'preview');
        $res   = VtPwned::results()[$email] ?? null;
        if (($res['state'] ?? '') !== 'ok' || empty($res['breaches'])) { $this->respond(['error' => 'This address is not in a known breach']); return; }
        $res   = VtPwned::withDetails([$res])[0];
        $sites = [];
        foreach (VtPwned::accounts() as $host => $list) {
            foreach ($list as $a) if ($a['email'] === $email) $sites[] = ['host' => $host, 'login' => $a['login'], 'id' => (int)($a['id'] ?? 0), 'path' => (string)($a['path'] ?? '')];
        }
        if (!$sites) { $this->respond(['error' => 'This address is not an administrator of a WordPress site on this server']); return; }
        $by = $this->resolveUserId();

        if ($mode === 'preview' || $mode === 'test') {
            $to = strtolower(trim((string)$this->_getParam('to', '')));
            if ($mode === 'test' && !filter_var($to, FILTER_VALIDATE_EMAIL)) { $this->respond(['error' => 'Enter a valid address to send the test to']); return; }
            [$subject, $html, $text] = VtPwnedMail::build($email, $sites, $res, $mode === 'test' ? $email : null);
            if ($mode === 'preview') { $this->respond(['ok' => true, 'subject' => $subject, 'html' => $html, 'sites' => array_map(fn($s) => ['host' => $s['host'], 'login' => $s['login'], 'ready' => $s['id'] > 0 && $s['path'] !== ''], $sites), 'from' => VtPwnedMail::sender()]); return; }
            $ok = VtPwnedMail::send($to, $subject, $html, $text);
            $this->appendLog('[pwned] test e-mail for ' . $email . ' sent to ' . $to . ' by ' . $by . ($ok ? '' : ' (FAILED)'));
            $this->respond($ok ? ['ok' => true, 'sent_to' => $to] : ['error' => 'The mail server did not accept the message']);
            return;
        }
        if ($mode !== 'fix') { $this->respond(['error' => 'Unknown action']); return; }

        $done = []; $failed = [];
        foreach ($sites as $s) {
            if (!$s['id'] || $s['path'] === '') { $failed[] = ['host' => $s['host'], 'error' => 'WordPress install not found on disk']; continue; }
            try {
                $r = pm_ApiCli::callSbin('site-scan', ['wpreset', $s['path'], (string)$s['id'], $email], pm_ApiCli::RESULT_FULL);
                $o = json_decode(trim((string)($r['stdout'] ?? '')), true);
            } catch (\Throwable $e) {
                $o = ['error' => $e->getMessage()];
            }
            if (!empty($o['ok'])) {
                $done[] = $s;
                $this->appendLog('[pwned] password of ' . $s['login'] . ' on ' . $s['host'] . ' reset (address in a data breach) by ' . $by);
            } else {
                $failed[] = ['host' => $s['host'], 'error' => (string)($o['error'] ?? 'unknown error')];
                $this->appendLog('[pwned] could not reset ' . $s['login'] . ' on ' . $s['host'] . ': ' . ($o['error'] ?? 'unknown error'));
            }
        }
        if (!$done) { $this->respond(['error' => 'No password could be reset, so no e-mail was sent', 'failed' => $failed]); return; }
        [$subject, $html, $text] = VtPwnedMail::build($email, $done, $res);
        $sent = VtPwnedMail::send($email, $subject, $html, $text);
        $this->appendLog('[pwned] e-mail to ' . $email . ($sent ? ' sent' : ' FAILED'));
        $fixed = self::pwnedFixed(function ($d) use ($email, $by, $done, $failed, $sent) {
            $d[$email] = ['at' => time(), 'by' => $by, 'sites' => array_column($done, 'host'), 'failed' => array_column($failed, 'host'), 'mailed' => $sent];
            return $d;
        });
        $this->respond(['ok' => true, 'reset' => array_column($done, 'host'), 'failed' => $failed, 'mailed' => $sent, 'fixed' => $fixed[$email]]);
    }

    /** Add or remove an address of your own: op=add|remove, email */
    public function pwnedEmailAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        $op    = (string)$this->_getParam('op', '');
        $email = (string)$this->_getParam('email', '');
        $login = $this->resolveUserId();
        if ($op === 'add') $r = VtPwned::addCustom($email, $login);
        elseif ($op === 'remove') $r = VtPwned::removeCustom($email, $login, $this->role());
        else $r = ['error' => 'Unknown action'];
        if (!empty($r['ok'])) $this->appendLog('[pwned] address ' . ($op === 'add' ? 'added' : 'removed') . ': ' . $r['email'] . ' by ' . $login);
        $this->respond($r + ['custom' => VtPwned::customFor($login, $this->role())]);
    }

    /** Breach source (administrator, server-wide): source = '' | hibp | xon, key = a new Have I Been Pwned key */
    public function pwnedSettingsAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can change this']); return; }
        $src = (string)$this->_getParam('source', '');
        if ($src !== '' && !isset(VtPwned::SOURCES[$src])) { $this->respond(['error' => 'Unknown source']); return; }
        $save = ['pwned_source' => $src];
        $msg  = '';
        $key  = trim((string)$this->_getParam('key', ''));
        if ($key !== '') {
            if (!preg_match('/^[A-Za-z0-9]{20,64}$/', $key)) { $this->respond(['error' => 'That does not look like a Have I Been Pwned API key']); return; }
            [$ok, $msg, $rpm] = VtPwned::testHibpKey($key);
            if (!$ok) { $this->respond(['error' => $msg]); return; }
            $save += ['pwned_hibp_key' => $key, 'pwned_hibp_rpm' => max(1, $rpm)];
        }
        if ($src === 'hibp' && $key === '' && VtPwned::hibpKey() === '') { $this->respond(['error' => 'Paste your Have I Been Pwned API key first']); return; }
        (new VtSettings('admin'))->setAll($save);
        $this->appendLog('[pwned] breach source: ' . (VtPwned::SOURCES[$src] ?? 'off'));
        $this->respond(['ok' => true, 'message' => $msg, 'config' => $this->pwnedSummary()]);
    }

    // ── Orphan databases (related hostnames), administrator only ──

    /** Database and table prefix of every WordPress install on disk (root helper, cached for an hour) */
    private static function wpConfigs(): ?array
    {
        return VtPwned::wpConfigs();
    }

    /**
     * Per related hostname: the database (or tables) it comes from, their size, and whether
     * a live site still uses them. kind: 'database' = no install uses this database,
     * 'tables' = old tables inside a database a live site uses, 'inuse' = an install uses exactly these.
     */
    private static function orphanInfo(array $related): array
    {
        if (!$related) return [];
        $want    = array_flip($related);
        $configs = self::wpConfigs();
        $dbs     = PleskDomains::pleskDatabases();
        $out     = [];
        foreach (PleskDomains::wordPressSources() ?? [] as $s) {
            if (!isset($want[$s['host']])) continue;
            $usedBy = []; $same = false;
            foreach ($configs ?? [] as $c) {
                if ($c['db'] !== $s['db']) continue;
                $usedBy[] = $c['path'];
                if ($c['prefix'] === $s['prefix']) $same = true;
            }
            $p  = $dbs[$s['db']] ?? null;
            $ws = $p['webspace'] ?? 0;
            $out[$s['host']][] = [
                'db' => $s['db'], 'prefix' => $s['prefix'], 'tables' => $s['tables'], 'size' => $s['size'],
                'kind'      => $configs === null ? 'unknown' : ($same ? 'inuse' : ($usedBy ? 'tables' : 'database')),
                'used_by'   => array_values(array_unique($usedBy)),
                'webspace'  => $p['webspace_name'] ?? '',
                'in_plesk'  => (bool)$p,
                'plesk_url' => $ws ? '/admin/subscription/login/id/' . $ws . '?pageUrl=/smb/database/list/domainId/' . $ws : '',
            ];
        }
        return $out;
    }

    /** Back up an orphan database (or its old tables) to the subscription's private folder. Deletes nothing. */
    public function dumpDbAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Only the administrator can back up databases']); return; }
        $host = $this->sanitize($this->_getParam('domain', ''));
        $db   = (string)$this->_getParam('db', '');
        $item = null;
        foreach (self::orphanInfo(PleskDomains::relatedForCurrentUser())[$host] ?? [] as $o) {
            if ($o['db'] === $db) $item = $o;
        }
        if (!$item || !in_array($item['kind'], ['database', 'tables'], true)) { $this->respond(['error' => 'Not an orphan database']); return; }
        // Only the old tables when a live site shares the database, never the live ones
        $args = ['dump', $item['db'], $item['kind'] === 'tables' ? $item['prefix'] : '-', $host];
        try {
            $res = pm_ApiCli::callSbin('site-scan', $args, pm_ApiCli::RESULT_FULL);
            $out = json_decode(trim((string)($res['stdout'] ?? '')), true);
        } catch (\Throwable $e) {
            $out = ['error' => 'The backup failed: ' . $e->getMessage()];
        }
        if (!is_array($out)) $out = ['error' => 'The backup failed'];
        if (!empty($out['ok'])) $this->appendLog('[db] Backup of ' . $item['db'] . ($item['kind'] === 'tables' ? ' (tables ' . $item['prefix'] . '*)' : '') . " for $host: " . $out['file']);
        $this->respond($out);
    }

    // ── WordPress admin user scan (rogue user detection) ──────────────────────

    /** List of WordPress admin users for a domain, with rogue-score flags (administrator only) */
    public function wpUsersAction(): void
    {
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Administrator only']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        if (!$domain || !$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }
        if (!(bool)$this->settings->get('wp_rogue_scan', true)) {
            $this->respond(['error' => 'WordPress admin scan is disabled in Settings', 'disabled' => true]); return;
        }
        $this->respond(self::fetchWpAdmins($domain));
    }

    /** Delete or reset the password of one WordPress admin user (administrator only) */
    public function wpUserActionAction(): void
    {
        if (!$this->getRequest()->isPost()) { $this->respond(['error' => 'POST required']); return; }
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Administrator only']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        $userId = (int)$this->_getParam('user_id', 0);
        $act    = (string)$this->_getParam('act', '');  // 'action' is reserved by Plesk routing
        if (!$domain || !$userId || !in_array($act, ['delete', 'reset'], true)) {
            $this->respond(['error' => 'Invalid parameters']); return;
        }
        if (!$this->mayCheck($domain)) { $this->respond(['error' => 'forbidden']); return; }

        $data = self::fetchWpAdmins($domain);
        if (!empty($data['error'])) { $this->respond(['error' => $data['error']]); return; }
        $user = null;
        foreach ($data['users'] ?? [] as $u) {
            if ((int)$u['id'] === $userId) { $user = $u; break; }
        }
        if (!$user) { $this->respond(['error' => 'User not found']); return; }

        $wpPath = $data['wp_path'] ?? '';
        if (!$wpPath || !is_dir($wpPath)) { $this->respond(['error' => 'WordPress path not found on disk']); return; }

        // Run as the file owner, not as root (WP-CLI reads wp-config.php as the site user)
        $sysUser = trim((string)@shell_exec('stat -c %U ' . escapeshellarg($wpPath) . ' 2>/dev/null'));
        $runAs   = ($sysUser && $sysUser !== 'root' && $sysUser !== 'UNKNOWN')
                 ? 'sudo -u ' . escapeshellarg($sysUser) . ' ' : '';
        $wpCmd   = $runAs . 'wp --path=' . escapeshellarg($wpPath) . ' --allow-root ';

        if ($act === 'delete') {
            $reassign = '';
            foreach ($data['users'] ?? [] as $u) {
                if ((int)$u['id'] !== $userId) { $reassign = ' --reassign=' . (int)$u['id']; break; }
            }
            exec($wpCmd . 'user delete ' . (int)$userId . $reassign . ' --yes 2>&1', $out, $rc);
            $newPass = null;
        } else {
            $newPass = bin2hex(random_bytes(16));
            exec($wpCmd . 'user update ' . (int)$userId . ' --user_pass=' . escapeshellarg($newPass) . ' 2>&1', $out, $rc);
        }

        if ($rc !== 0) {
            $errMsg = trim(implode(' ', $out));
            $this->respond(['error' => str_contains($errMsg, 'not found') || str_contains($errMsg, 'No such file')
                ? 'WP-CLI is not installed on this server. Install it at https://wp-cli.org to enable user management.'
                : 'Command failed: ' . $errMsg]);
            return;
        }

        $this->appendLog('[wp-users] ' . $act . ' user ' . $user['login'] . ' (ID ' . $userId . ') on ' . $domain);
        $result = ['ok' => true, 'users' => self::fetchWpAdmins($domain)['users'] ?? []];
        if ($newPass !== null) $result['new_password'] = $newPass;
        $this->respond($result);
    }

    /**
     * Resolve the WordPress install for a domain and return DB connection details.
     * Throws \RuntimeException on any error.
     * @return array{pdo:\PDO, db:string, prefix:string, wp_path:string}
     */
    /** Activity log for one WordPress admin user: recent logins, post edits, and plugin log if present */
    public function wpUserActivityAction(): void
    {
        if ($this->role() !== 'admin') { $this->respond(['error' => 'Administrator only']); return; }
        $domain = $this->sanitize($this->_getParam('domain', ''));
        $userId = (int)$this->_getParam('user_id', 0);
        if (!$domain || !$userId) { $this->respond(['error' => 'Missing parameters']); return; }
        try {
            $this->respond(['ok' => true] + self::fetchWpUserActivity($domain, $userId));
        } catch (\RuntimeException $e) {
            $this->respond(['error' => $e->getMessage()]);
        }
    }

    private static function fetchWpUserActivity(string $domain, int $userId): array
    {
        ['pdo' => $pdo, 'db' => $db, 'prefix' => $prefix] = self::getWpInstall($domain);

        // 1. Recent logins — WordPress stores session tokens in usermeta; each session has a 'login' timestamp
        $logins = [];
        $tokenRaw = $pdo->query(
            "SELECT meta_value FROM `$db`.`{$prefix}usermeta`
             WHERE user_id = $userId AND meta_key = 'session_tokens' LIMIT 1"
        )->fetchColumn();
        if ($tokenRaw) {
            $sessions = @unserialize((string)$tokenRaw);
            if (is_array($sessions)) {
                $list = [];
                foreach ($sessions as $sess) {
                    if (isset($sess['login'])) {
                        $list[] = ['ts' => (int)$sess['login'], 'ip' => (string)($sess['ip'] ?? '')];
                    }
                }
                usort($list, fn($a, $b) => $b['ts'] - $a['ts']);
                $logins = array_slice($list, 0, 5);
            }
        }

        // 2. Recent post / page edits by this user
        $posts = [];
        $stmt = $pdo->query(
            "SELECT post_title, post_type, post_status, post_modified, post_date
             FROM `$db`.`{$prefix}posts`
             WHERE post_author = $userId
               AND post_type IN ('post','page')
               AND post_status NOT IN ('auto-draft','trash','inherit')
             ORDER BY post_modified DESC LIMIT 10"
        );
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $posts[] = [
                'title'    => (string)$row['post_title'],
                'type'     => (string)$row['post_type'],
                'status'   => (string)$row['post_status'],
                'modified' => (string)$row['post_modified'],
                'created'  => (string)$row['post_date'],
            ];
        }

        // 3. Stream plugin activity log (if installed) — covers logins, edits, password changes
        $stream = [];
        try {
            $tables = $pdo->query("SHOW TABLES FROM `$db` LIKE '{$prefix}stream'")->fetchAll(\PDO::FETCH_COLUMN);
            if ($tables) {
                $stmt = $pdo->query(
                    "SELECT created, type, action, context, summary
                     FROM `$db`.`{$prefix}stream`
                     WHERE user_id = $userId
                       AND (action IN ('login','login_failed','updated','created','deleted','password_reset')
                            OR type IN ('authentication','posts','users'))
                     ORDER BY created DESC LIMIT 20"
                );
                foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                    $stream[] = [
                        'ts'      => strtotime((string)$row['created']),
                        'type'    => (string)$row['type'],
                        'action'  => (string)$row['action'],
                        'context' => (string)$row['context'],
                        'summary' => (string)($row['summary'] ?? ''),
                    ];
                }
            }
        } catch (\PDOException $e) { /* stream plugin not present or incompatible */ }

        return ['logins' => $logins, 'posts' => $posts, 'stream' => $stream];
    }

    private static function getWpInstall(string $domain): array
    {
        $sources = PleskDomains::wordPressSources();
        if ($sources === null) throw new \RuntimeException('Could not query WordPress databases');

        $install = null;
        foreach ($sources as $s) {
            if ($s['host'] === $domain || $s['host'] === 'www.' . $domain) { $install = $s; break; }
        }
        if (!$install) throw new \RuntimeException('No WordPress install found for this domain');

        $wpPath = '';
        foreach (self::wpConfigs() ?? [] as $c) {
            if (isset($c['db'], $c['prefix']) && $c['db'] === $install['db'] && $c['prefix'] === $install['prefix']) {
                $wpPath = $c['path'] ?? ''; break;
            }
        }

        $pdo = PleskDomains::pdo();
        if (!$pdo) throw new \RuntimeException('Database unavailable');

        $db     = $install['db'];
        $prefix = $install['prefix'];
        if (!preg_match('/^[a-zA-Z0-9_\-]+$/', $db) || !preg_match('/^[a-zA-Z0-9_]+$/', $prefix)) {
            throw new \RuntimeException('Invalid database or table prefix');
        }

        return ['pdo' => $pdo, 'db' => $db, 'prefix' => $prefix, 'wp_path' => $wpPath];
    }

    private static function fetchWpAdmins(string $domain): array
    {
        try {
            ['pdo' => $pdo, 'db' => $db, 'prefix' => $prefix, 'wp_path' => $wpPath] = self::getWpInstall($domain);
        } catch (\RuntimeException $e) {
            return ['error' => $e->getMessage(), 'users' => []];
        }

        try {
            $stmt = $pdo->prepare(
                "SELECT u.ID, u.user_login, u.user_email, u.user_registered, u.display_name, m.meta_value AS caps
                 FROM `$db`.`{$prefix}users` u
                 LEFT JOIN `$db`.`{$prefix}usermeta` m ON m.user_id = u.ID AND m.meta_key = ?
                 ORDER BY u.ID"
            );
            $stmt->execute([$prefix . 'capabilities']);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => 'Could not read user table: ' . $e->getMessage(), 'users' => []];
        }

        $users = [];
        foreach ($rows as $row) {
            $caps = @unserialize((string)($row['caps'] ?? ''));
            if (!is_array($caps) || !isset($caps['administrator'])) continue;
            $users[] = [
                'id'         => (int)$row['ID'],
                'login'      => (string)$row['user_login'],
                'email'      => (string)$row['user_email'],
                'display'    => (string)$row['display_name'],
                'registered' => (string)$row['user_registered'],
                'flags'      => self::rogueFlags($row, $domain),
            ];
        }

        // XposedOrNot: check each admin email for data breaches (free, no key required)
        foreach ($users as &$user) {
            $breaches = self::xonCheck($user['email']);
            if ($breaches !== null && count($breaches) > 0) {
                $n         = count($breaches);
                $listShown = array_slice($breaches, 0, 5);
                $extra     = $n > 5 ? ' and ' . ($n - 5) . ' more' : '';
                $user['flags'][] = [
                    'code'   => 'hibp_breach',
                    'label'  => 'Found in ' . $n . ' breach' . ($n === 1 ? '' : 'es'),
                    'detail' => 'The email address ' . htmlspecialchars($user['email'])
                        . ' appears in ' . $n . ' known data breach' . ($n === 1 ? '' : 'es')
                        . ' (source: XposedOrNot): '
                        . htmlspecialchars(implode(', ', $listShown) . $extra) . '. '
                        . 'If the same or a similar password is used for this WordPress admin account, '
                        . 'attackers can log in and infect every site on this server. '
                        . 'Reset this admin\'s password immediately with the button below.',
                ];
            }
        }
        unset($user);

        return ['users' => $users, 'wp_path' => $wpPath, 'db' => $db];
    }

    /**
     * Breach names of one address, from the shared Pwned store (VtPwned): a checked address is
     * never checked again. Checks it now when the rate limit allows; null when not checked (yet)
     * or when the administrator switched the breach check off.
     */
    private static function xonCheck(string $email): ?array
    {
        $email = strtolower(trim($email));
        if ($email === '') return null;
        $r = VtPwned::results()[$email] ?? null;
        if (VtPwned::needsCheck($r)) $r = VtPwned::check($email);
        if (($r['state'] ?? '') !== 'ok') return null;
        $r = VtPwned::withDetails([$r])[0];
        return array_map(fn($b) => (string)($b['title'] ?? $b['name']) . (!empty($b['date']) ? ' (' . substr($b['date'], 0, 4) . ')' : ''), $r['breaches'] ?? []);
    }

    /** Heuristic flags that may indicate a WordPress admin is rogue or compromised */
    private static function rogueFlags(array $row, string $domain): array
    {
        $flags = [];
        $login = strtolower((string)$row['user_login']);
        $email = strtolower((string)$row['user_email']);
        $regTs = strtotime((string)($row['user_registered'] ?? '')) ?: 0;

        if ($regTs > 0) {
            $daysOld = max(0, (int)((time() - $regTs) / 86400));
            if ($daysOld < 30) {
                $flags[] = ['code' => 'new_account', 'label' => 'Created ' . $daysOld . ' day' . ($daysOld === 1 ? '' : 's') . ' ago',
                    'detail' => 'This admin account is only ' . $daysOld . ' day' . ($daysOld === 1 ? '' : 's') . ' old. '
                        . 'Attackers add an admin user immediately after gaining access, so a recently created admin on a site with infections is a strong red flag. '
                        . 'If you did not create this account yourself, delete it.'];
            }
        }

        static $susNames = ['admin2','admin1','admin0','administrator','wp-admin','wpadmin','wpuser','support',
                            'wordpress','backup','test','user','webmaster','siteadmin','manager','owner',
                            'root','server','info','hello','user1','user2','plugin','theme','mod','superuser'];
        if (in_array($login, $susNames, true) || preg_match('/^[a-f0-9]{12,}$/', $login)) {
            $flags[] = ['code' => 'suspicious_name', 'label' => 'Generic or bot-added username',
                'detail' => 'The username "' . htmlspecialchars((string)$row['user_login']) . '" is a known generic or bot-added name. '
                    . 'Automated attacks use a fixed list of admin usernames to stay hidden in the user list. '
                    . 'Legitimate admins usually have a personal name or initials.'];
        }

        static $freeProviders = ['gmail.com','googlemail.com','yahoo.com','hotmail.com','outlook.com','live.com',
                                  'mail.ru','yandex.com','yandex.ru','protonmail.com','proton.me','icloud.com',
                                  'me.com','mac.com','aol.com','msn.com','web.de','gmx.com','gmx.de','gmx.net'];
        $emailDomain = ltrim(substr($email, (int)strrpos($email, '@')), '@');

        if (in_array($emailDomain, $freeProviders, true)) {
            $flags[] = ['code' => 'free_email', 'label' => 'Free email provider (' . htmlspecialchars($emailDomain) . ')',
                'detail' => 'The admin uses a free public email service (' . htmlspecialchars((string)$row['user_email']) . '). '
                    . 'While some real admins use personal email, attackers prefer free accounts that cannot be traced to any organisation. '
                    . 'Consider whether this matches the people who legitimately manage this site. '
                    . 'Also note: if this admin account\'s password ever appeared in a data breach, attackers can use it to get full access to every site on the server — '
                    . 'check the password at haveibeenpwned.com and change it immediately if it was leaked.'];
        }

        $siteParts = array_reverse(explode('.', $domain));
        $siteRoot  = count($siteParts) >= 2 ? ($siteParts[1] . '.' . $siteParts[0]) : $domain;
        if ($emailDomain && !str_ends_with($emailDomain, $siteRoot) && !in_array($emailDomain, $freeProviders, true)) {
            $flags[] = ['code' => 'foreign_email', 'label' => 'Email from unrelated domain (' . htmlspecialchars($emailDomain) . ')',
                'detail' => 'The admin email domain (' . htmlspecialchars($emailDomain) . ') is unrelated to the site domain ('
                    . htmlspecialchars($domain) . '). This may be normal (e.g. a web agency managing a client\'s site), '
                    . 'but combined with other flags it can indicate a rogue or externally added user.'];
        }

        return $flags;
    }

    /** Which trend history this user sees: the server (admin), or their own sites (reseller, customer) */
    private function historyScope(): string
    {
        $role = $this->role();
        if ($role === 'admin') return 'admin';
        return ($role === 'reseller' ? 'r:' : 'c:') . $this->settings->getUserId();
    }

    /** Daily totals for the trend graph: the whole server (administrator) or the user's own sites */
    public function historyAction(): void
    {
        VtHistory::scope($this->historyScope());
        $this->respond(['days' => VtHistory::days(92), 'scope' => $this->role() === 'admin' ? 'server' : 'own']);
    }

    /** Recent per-domain status changes for the events feed in the Trend tab */
    public function eventsAction(): void
    {
        // Once: add the status changes from before the feed existed, found in the scan logs
        $marker = VtDataDir::path('vt_events_backfilled');
        if (!file_exists($marker) && @touch($marker)) VtEvents::backfillFromLogs();
        VtAvastStore::recordCachedObservations();
        $recent = VtSiteLog::recentChanges();
        if ($this->role() === 'admin') { // the whole server, including sites that have left the list
            $this->respond(['events' => array_slice($recent, 0, 200)]);
            return;
        }
        $allowed = array_flip(array_merge(
            PleskDomains::forCurrentUser($this->wpOnly()),
            PleskDomains::relatedForCurrentUser()
        ));
        $events = array_values(array_filter(
            $recent,
            fn($e) => isset($allowed[$e['domain'] ?? ''])
        ));
        $this->respond(['events' => array_slice($events, 0, 200)]);
    }

    /** A site of this user, or a related hostname under one of the user's domains */
    private function mayCheck(string $domain): bool
    {
        return in_array($domain, PleskDomains::forCurrentUser($this->wpOnly()), true)
            || in_array($domain, PleskDomains::relatedForCurrentUser(), true);
    }

    /** Scan WordPress sites only, instead of every hosted website */
    private function wpOnly(): bool
    {
        return (bool)$this->settings->get('wordpress_only', false);
    }

    private function userLogFile(): string
    {
        $uid = preg_replace('/[^a-z0-9_\-]/i', '_', $this->settings->getUserId());
        return VtDataDir::path('cron_' . $uid . '.log');
    }

    private function appendLog(string $msg): void
    {
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
        @file_put_contents($this->userLogFile(), $line, FILE_APPEND);
    }

    private function sanitize(string $d): string
    {
        $d = preg_replace('#^https?://(www\.)?#', '', strtolower(trim($d)));
        $d = rtrim($d, '/');
        return preg_match('/^[a-z0-9.\-]+\.[a-z]{2,}$/', $d) ? $d : '';
    }

    private function respond(array $data): void
    {
        // Disable layout and view rendering, then emit JSON directly
        // Note: use property access (->layout, ->viewRenderer) not method calls
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->getResponse()->setHeader('Content-Type', 'application/json', true);
        $this->getResponse()->setBody(json_encode($data));
    }
}
