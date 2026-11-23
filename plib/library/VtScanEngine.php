<?php
/**
 * VtScanEngine — which ONE file-scan engine a site scan uses.
 *
 * Maldet (Linux Malware Detect) scans with ClamAV's engine when ClamAV is installed, and copies
 * its own signatures into ClamAV's database (rfxn.hdb, rfxn.ndb, rfxn.yara). So with both
 * installed, a ClamAV scan already covers Maldet; running both only scans every file twice.
 *
 *   ClamAV only                      → ClamAV   "ClamAV scan"
 *   ClamAV + Maldet                  → ClamAV   "ClamAV/Maldet scan"
 *   Maldet only, "Maldet enabled" on → Maldet   "Maldet scan"
 *   Maldet only, setting off         → none     "Maldet is installed but disabled in settings"
 *   neither                          → none     "No scanner found (install ClamAV)"
 *
 * Imunify is not an engine here: it starts no scan, it only shows Imunify's own results.
 *
 * $engines is the detection result of sbin/site-scan list:
 *   ['clamav' => ['installed' => bool, ...], 'maldet' => ['installed' => bool, ...]]
 *
 * No Plesk dependencies: sbin/site-scan (root) uses it too, to refuse a Maldet scan while ClamAV is installed.
 */
class VtScanEngine
{
    const MSG_MALDET_OFF = 'Maldet is installed but disabled in settings';
    const MSG_NONE       = 'No scanner found (install ClamAV)';
    const RFXN           = ['rfxn.hdb', 'rfxn.ndb', 'rfxn.yara'];

    /** @return array{id: ?string, name: string, label: string, message: string} */
    public static function select(array $engines, bool $maldetEnabled): array
    {
        $clam   = !empty($engines['clamav']['installed']);
        $maldet = !empty($engines['maldet']['installed']);
        if ($clam) {
            return ['id' => 'clamav', 'name' => 'ClamAV', 'label' => $maldet ? 'ClamAV/Maldet scan' : 'ClamAV scan', 'message' => ''];
        }
        if ($maldet && $maldetEnabled) {
            return ['id' => 'maldet', 'name' => 'Maldet', 'label' => 'Maldet scan', 'message' => ''];
        }
        if ($maldet) {
            return ['id' => null, 'name' => '', 'label' => 'Maldet scan', 'message' => self::MSG_MALDET_OFF];
        }
        return ['id' => null, 'name' => '', 'label' => 'ClamAV scan', 'message' => self::MSG_NONE];
    }

    /** May this engine run a scan now? Only the selected one ever may. */
    public static function mayRun(string $id, array $engines, bool $maldetEnabled): bool
    {
        return $id !== '' && self::select($engines, $maldetEnabled)['id'] === $id;
    }

    /**
     * The buttons a site gets: the one engine (or a disabled button with the reason),
     * plus Imunify's results when it is installed and switched on.
     */
    public static function buttons(array $engines, bool $maldetEnabled, bool $imunifyOn): array
    {
        $e = self::select($engines, $maldetEnabled);
        $out = [$e['id']
            ? ['id' => $e['id'], 'name' => $e['name'], 'label' => $e['label'], 'instant' => false]
            : ['id' => '', 'name' => '', 'label' => $e['label'], 'disabled' => true, 'message' => $e['message']]];
        if ($imunifyOn) $out[] = ['id' => 'imunify', 'name' => 'Imunify', 'label' => 'Imunify results', 'instant' => true];
        return $out;
    }
}
