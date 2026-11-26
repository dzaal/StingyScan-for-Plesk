#!/bin/bash
# Build the installable Plesk extension package.
# Usage: bash build.sh            -> dist/stingyscan-<version>.zip            (extension id "stingyscan")
#        bash build.sh catalog    -> dist/stingyscan-catalog-<version>.zip    (the edition for the Plesk Extensions
#                                    Catalog: same id and code, without its own updater and without the installation
#                                    statistics; Plesk updates it. See plib/library/VtEdition.php)
#        bash build.sh legacy     -> dist/virustotal-extension-<version>.zip  (the same Stingy Scanner, built with
#                                    the old id "virustotal-extension", so an installed VT Site Scanner 1.x
#                                    is upgraded in place: same data, same panel address, no second extension)
set -e

EXT_ID="stingyscan"
[ "${1:-}" = "legacy" ] && EXT_ID="virustotal-extension"
CATALOG=""
[ "${1:-}" = "catalog" ] && CATALOG=1
cd "$(dirname "$0")"
VERSION=$(sed -n 's:.*<version>\(.*\)</version>.*:\1:p' META_INF/meta.xml)
OUT="dist/${EXT_ID}${CATALOG:+-catalog}-${VERSION}.zip"
BUILD=$(mktemp -d)
trap 'rm -rf "$BUILD"' EXIT

# Package layout: <ext-id>/meta.xml + htdocs/ + plib/ + sbin/ (root helper) + _meta/ (catalog icons and screenshots)
mkdir -p "$BUILD/$EXT_ID" dist
cp -r htdocs plib sbin _meta "$BUILD/$EXT_ID/"
chmod 755 "$BUILD/$EXT_ID"/sbin/*
cp META_INF/meta.xml "$BUILD/$EXT_ID/meta.xml"
cp LICENSE "$BUILD/$EXT_ID/LICENSE"
# Plesk Extensions Catalog: extended description, changelog and privacy policy next to meta.xml
cp DESCRIPTION.md "$BUILD/$EXT_ID/DESCRIPTION.md"
cp CHANGELOG.md "$BUILD/$EXT_ID/CHANGES.md"
cp PRIVACY.md "$BUILD/$EXT_ID/PRIVACY.md"
if [ -n "$CATALOG" ]; then
    # Plesk Extensions Catalog edition: Plesk updates it (no updater, no GitHub check) and it sends nothing to
    # Digizaal (no installation statistics). The code checks VtEdition::CATALOG.
    rm -f "$BUILD/$EXT_ID/sbin/extension-update" "$BUILD/$EXT_ID/plib/library/VtStats.php"
    sed -i 's/const CATALOG = false;/const CATALOG = true;/' "$BUILD/$EXT_ID/plib/library/VtEdition.php"
    grep -q 'const CATALOG = true;' "$BUILD/$EXT_ID/plib/library/VtEdition.php"
    sed -i 's/Nothing is sent to Digizaal unless you switch on the optional installation statistics\./Nothing is sent to Digizaal./' "$BUILD/$EXT_ID/DESCRIPTION.md"
fi
if [ "$EXT_ID" = "virustotal-extension" ]; then
    # Only what ties the package to its id: Plesk module paths, the id itself, hook class
    # names and the zip that updates download. Names, texts and the rest stay Stingy Scanner.
    find "$BUILD/$EXT_ID" -type f \( -name '*.php' -o -name '*.xml' -o -path '*/sbin/*' \) -print0 | xargs -0 sed -i         -e 's#/modules/stingyscan/#/modules/virustotal-extension/#g'         -e "s#pm_Context::init('stingyscan')#pm_Context::init('virustotal-extension')#g"         -e 's#<id>stingyscan</id>#<id>virustotal-extension</id>#g'         -e 's#Modules_Stingyscan_#Modules_VirustotalExtension_#g'         -e 's#/stingyscan\.zip#/virustotal-extension.zip#g'
fi
rm -f "$OUT"

if command -v zip >/dev/null 2>&1; then
    (cd "$BUILD" && zip -qr - "$EXT_ID" -x "*.DS_Store") > "$OUT"
else
    # Fallback for systems without zip (e.g. Git Bash on Windows)
    PY=$(command -v python3 || command -v python)
    "$PY" - "$BUILD" "$EXT_ID" "$OUT" <<'PYEOF'
import os, sys, zipfile
base, ext, out = sys.argv[1], sys.argv[2], sys.argv[3]
with zipfile.ZipFile(out, "w", zipfile.ZIP_DEFLATED) as z:
    for root, _, files in os.walk(os.path.join(base, ext)):
        for f in files:
            if f == ".DS_Store": continue
            p = os.path.join(root, f)
            arc = os.path.relpath(p, base).replace(os.sep, "/")
            zi = zipfile.ZipInfo.from_file(p, arc)
            zi.compress_type = zipfile.ZIP_DEFLATED
            # sbin/ scripts must stay executable (Windows has no exec bit)
            zi.external_attr = ((0o100755 if "/sbin/" in arc else 0o100644) << 16)
            with open(p, "rb") as fh:
                z.writestr(zi, fh.read())
PYEOF
fi

echo "$OUT"
