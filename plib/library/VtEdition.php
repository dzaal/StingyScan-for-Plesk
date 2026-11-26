<?php
/**
 * VtEdition: which package this is.
 *
 * CATALOG is false in the package published on GitHub. `bash build.sh catalog` sets it to true for the
 * edition submitted to the Plesk Extensions Catalog. That edition:
 *   - has no updater of its own: Plesk updates catalog extensions (no GitHub check, no sbin/extension-update);
 *   - has no installation statistics ("Talk to mama"): VtStats is not in the package, nothing is sent to Digizaal;
 *   - does not uninstall the old VT Site Scanner (virustotal-extension) by itself.
 * Everything else is the same code.
 */
final class VtEdition
{
    const CATALOG = false;
}
