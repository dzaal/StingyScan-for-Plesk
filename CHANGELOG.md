# Changes

Every version of Stingy Scanner for Plesk (called StingyScan in 2.0–2.1.1, VT Site Scanner until 1.35), newest first.
Install or update: see the [latest release](https://github.com/dzaal/StingyScan-for-Plesk/releases/latest).

## 2.19.17 — 2026-11-28
- Tools: the large icon of each tool now sits left of the page title, instead of in a column that pushed the whole page to the right. *Admin changes* got a page title too.

## 2.19.16 — 2026-11-28
- Tools: each tool's page (Vendor requests, Pwned Admins, Admin changes, Orphan databases, Scan log) shows the icon of its card, large (8em) and in the card's colour, in a column to the left of the page. On narrow screens it is smaller and above the page.

## 2.19.15 — 2026-11-28
- Settings: the group *E-mail* is now **Notifications**, with three sections: **E-mail notifications**, **Plesk notifications** (now a section of its own) and **E-mail sender**. **Review requests** moved to *Reputation services*, under the services whose vendors you ask for a review.

## 2.19.14 — 2026-11-28
- Settings → Plesk notifications: the style choices now say what they do in Plesk: **Alert** is red and stays on screen until you close it; **Warning** (orange) and **Information** (green, not blue as 2.19.12 said) close by themselves.

## 2.19.13 — 2026-11-28
- Statistics → API usage today: each service now says when its "today" began (00:00 server time for AVG, Avast and Google; 00:00 UTC for the breach check, like its limit) and shows **yesterday's** total too, so a low number just after midnight is not mistaken for a missing count. The heading shows the server time.

## 2.19.12 — 2026-11-28
- Settings → Notifications → Plesk notifications: each kind (infected, suspicious, clean again, admin changes) has, on its own line, a choice of how it shows in Plesk (**Alert** red, **Warning** orange, **Information** blue; Plesk has no "success" style) and a **Test** button that sends one notification of that kind in that style. The separate *Send a test notification* button is gone.

## 2.19.11 — 2026-11-28
- Statistics: new **API usage today** at the top. VirusTotal with large rings (Auto, Manual left, VT quota, the daily limit and date), then every other online service that is switched on: AVG and Avast Web Shield, Google Safe Browsing and the breach check (XposedOrNot or Have I Been Pwned, administrator only), each with its requests today, its daily limit as a ring where there is one, and how many requests a minute it is allowed. Refreshed each time you open Statistics.
- Header: the *by Digizaal* link is gone (the maker is still in About).

## 2.19.10 — 2026-11-28
- Dashboard: the API usage rings (Auto, Manual left, VT quota, with the daily limit and date) moved from their own bar into the header, top right next to *by Digizaal*, at the height of the logo. They show on the Dashboard tab only; on narrow screens the limit and date are left out and the rings move below the title.

## 2.19.9 — 2026-11-28
- Scan Monitor: rescans the server finishes after you left the page now show what the server is doing: the site it checks now with its step (asking VirusTotal, VirusTotal analysing, fetching the report) and how long it takes, then the waiting sites with their place in line and when the next server run starts (or when a site left behind by a page is handed to the server). The summary counts them as *checking* and *queued*.
- Dashboard: those sites show *In queue #n (server)* or *Server: checking* in the table, with the Rescan button disabled, like rescans in the page.
- The server marks each site as done as soon as it has its result (not at the end of its run of up to 6 sites), and the page looks every 15 seconds instead of 30.
- README: FAQ on which sites are checked when, what happens to a rescan when you leave the page, and how to stop queued rescans.

## 2.19.8 — 2026-11-27
- **Fix:** Tools → Vendor requests: the **📋 text** popup fell behind Plesk's menu bars and its **Copy text** button was invisible (the popup sat outside the page's styles). It now opens on top, centred, with a visible **Copy text** button and a **Close** button.

## 2.19.7 — 2026-11-27
- Tools: the card icons are coloured without the tinted box behind them.

## 2.19.6 — 2026-11-27
- Tools: the big card icons are coloured again, each in its own tinted box (64 px).

## 2.19.5 — 2026-11-27
- Tools: the card icons are bigger (52 px instead of 24 px) and dark monochrome, without the coloured box behind them.

## 2.19.4 — 2026-11-27
- **Fix:** Dashboard: with *Collapsed* ticked, switching to *Sort* showed no sites (the folded-up customers kept their sites hidden, without headers to open them). Folding up now only applies in the *Grouped* view; *Sort* always shows every site, and *Collapsed* is hidden there.
- Dashboard: the search box has an **✕** to clear it, like the search in Tools → Vendor requests.
- Tools: new monochrome icons on the cards of Vendor requests, Pwned Admins, Admin changes, Orphan databases and Scan log.
- Plesk notifications: **Send a test notification** now sends an *Alert*, the same category as a site that became infected, so the test shows the way a real alert does. README: the category of each kind.

## 2.19.3 — 2026-11-27
- **Plesk notifications (the bell):** Stingy Scanner can show its news in Plesk's own notifications, with its logo: a site that became **infected** or **suspicious**, a site that is **clean again**, and **admin rights changed** on a site (Tools → Admin changes). Choose the kinds in *Settings → Notifications → Plesk notifications* (default: infected, suspicious and admin changes); Plesk can also switch each kind off under *Tools & Settings → Notifications → Panel*. Several status changes become one notification per kind, within 5 minutes; a click opens Stingy Scanner. *Send a test notification* checks it. For the administrator (Plesk shows panel notifications to administrators).
- **Settings → Access for resellers and customers** (administrator): switch Stingy Scanner off for resellers and/or customers. The entry disappears from their Plesk menu, the page refuses them, and they get no e-mails from it; the sites are still scanned for you.
- Dashboard: the **Collapsed** checkbox (Grouped view only) sits in the toolbar again, after *Grouped | Sort* and before the loading status (*All loaded*), in the normal font; when there is not enough room, they wrap to the next line together.

## 2.19.2 — 2026-11-27
- **Fix:** several buttons and search boxes did nothing, because the page could not reach their function:
  - Tools → **Vendors**: the search (it now filters while you type) and *Refresh*;
  - Tools → **Admin changes**: the search and the *All / Pending / Approved* buttons (the cursor stays in the search box);
  - Status changes: *Show all*;
  - Settings → Quarantine: *Cancel*;
  - a site's file actions: *cancel*;
  - a site's WordPress admin accounts: *Retry* and reload (↺).
- README: a section about **Tools → Vendor requests**, and the Tools tab, Orphan databases and alphaMountain's form address brought up to date.
- README: a new **FAQ** (who decides the verdict, a site that turns red because VirusTotal added a vendor, still red after cleaning, AVG's alert ID, what Stingy Scanner changes by itself, orphan databases and VirusTotal, the clean line in Statistics).
- *Why?* panel and README: the overall verdict is VirusTotal's, not Stingy Scanner's. One vendor that calls a site *malicious* makes it infected; a vendor that VirusTotal **newly adds** and that already had the site on its blocklist can turn a site from suspicious to infected overnight without a new infection. The panel explains this and how to check it.
- **Statistics:** the line chart has a **logarithmic scale** (default; *Linear* switches back), so the infected and suspicious lines stay readable next to the hundreds of clean sites. *Clean sites* in the chart are all sites that are not flagged, at today's number of sites: days that counted fewer sites (WordPress sites only, or sites not checked yet) no longer make the line jump; the tooltip shows the number recorded that day.
- **Statistics:** the chart opens on **2 months** (your choice of range is remembered) and also shows the **clean sites** (dashed green line). Click a line name in the legend to hide or show it: the scale adapts, so with *Clean sites* hidden the infected and suspicious lines fill the chart again. Hovering shows a dot on every line for that day; a click pins the day (click again to release). The suspicious line is a darker amber, easier to see.
- **Fix:** Tools → Vendor requests said *No sites are currently flagged by any vendor* when it was opened before the scan results had loaded, and stayed that way. It now says *Loading the scan results…* and shows the vendors as soon as they are in.
- **Fix:** Tools → Vendor requests: *Copy … URLs* did nothing (the list of addresses broke the button). It is now **Copy N domain names** and copies the shown domain names one per line (search applied). Each site also has a small copy button next to its name.
- **Vendor data in one file: `vendors.json`.** Every vendor's false positive form (or e-mail address), how the request goes (`form`, `prefill`, `email`), which fields are filled in, what is copied on click, and advice, are now in `plib/library/vendors.json` (105 vendors) instead of spread over the page code. One generic link builder uses it, so AVG, Fortinet, alphaMountain, Gridinsoft and G Data are no longer special cases. A copy in the data folder (`/usr/local/psa/var/modules/stingyscan/data/vendors.json`) is used instead when it is there; without either file the built-in list of addresses is used. See the README.
- **G Data:** *request a review* opens G Data's URL form (submit.gdatasoftware.com/url) and copies the text; the advice says what to fill in (the site address, the first option, *Website* in the list, `https://virustotal.com`). G Data first asks for consent and an "I am human" check, which stays yours to do.
- E-mail review requests now use the ready-made text (with your signature) as the body.
- **Ready-made texts for review requests:** next to every *request a review* there is **📋 text**. It opens a panel with a polite, factual request for the form's description box (the site, the vendor's classification, the VirusTotal link and your signature) that you can edit, copy with one click, or replace with **another wording**. For Fortinet and alphaMountain the text is also copied when you click *request a review*. Copying now also works inside the Plesk frame (it tried the clipboard function first, which Plesk's frame often refuses, and then showed the text in a message you could not copy from). Check it before you send it: it says the site was checked and cleaned.
- **Settings → Review requests:** your name, company and e-mail address for review requests (per user). Used in the texts and filled in on the forms that allow it. Without a company name, the domain of your e-mail address is used.
- **alphaMountain** and **Gridinsoft:** *request a review* opens the vendor's form (alphaMountain: its new ticket form on Freshdesk) and copies the text for the description at the same click. Both forms were tested in a browser: they take no values from the address (Gridinsoft's page only reads a token from it), so they cannot be filled in from here.
- **Fortinet** (the vendor most often asked here): the Malicious URL Appeal form opens with the URL, your name, e-mail and company filled in, and the text for the comment box is copied when you click (that box cannot be filled from outside). Researched for the vendors that flag sites most on this server: only AVG and Fortinet accept filled-in fields; Gridinsoft, alphaMountain, CRDF, CyRadar, Chong Lua Dao, G-Data, Lionic and Webroot don't, so they get the copied text.
- **AVG: false positive form filled in for you.** AVG has a new form (avg.com/en-ww/report-false-positive), and it takes its field values from the address. *Request a review* / *report a false positive* for AVG now opens it with **Website** chosen and the site address, your e-mail address (Settings → Review requests, the notification address, or your Plesk address), AVG's detection name (`URF…`), the **alert ID** and a description filled in; you only tick the reCAPTCHA and click Send (the form is never sent by Stingy Scanner). Each site has an **Alert ID** box next to the AVG link: copy the ID once from AVG Web Shield's block page and it is remembered.
- **Tools:** *Vendors* is renamed **Vendor requests** and comes first (card and navigation). *Orphan databases* is always listed, right from the start, instead of appearing once the data is loaded.
- **Vendor requests:** each vendor has a clear step-by-step box: make sure the site is clean, how to ask (form with the address on the clipboard, or a ready e-mail, or no known form), what this vendor asks for, and what to click when the vendor answers; with how many sites were requested and confirmed. The AVG / Avast advice now explains the **Web Shield alert ID**.
- **Database scan with real progress:** *Scan with ClamAV* (Tools → Orphan databases) now runs in the background. The Scan Monitor shows the real progress of the dump (*table 12 of 34*, megabytes written, time), then *ClamAV is scanning the 8.4 MB dump* with a moving stripe instead of a made-up percentage (ClamAV reports nothing until it is done). Afterwards it shows the figures: tables, rows (MySQL's estimate), size in the database, dump size and time, scan engine and time, ClamAV signature version. The log line and the ClamAV column show them too. If you leave the page during a scan, it continues on the server and is picked up the next time the page opens.
- Settings: every **Save settings** button shows what happens: *Saving…* with a spinner, then a green *✓ Saved* or a red *✕ Not saved*, and a message at the bottom of the screen (before, the message only showed at the top and bottom of Settings, often out of view).
- **Fix:** Settings → **Trusted admin addresses** and *E-mail me when admin rights change* were never saved (the field was empty again after saving), so trusted addresses were never approved automatically or left out. The same was true for *Show a Delete button for admin accounts* and the WordPress admin account scan switch. All four are saved now.
- **Fix:** Tools → Vendors showed `[object Object]` as the verdict of AVG / Avast; it now shows the classification and the detection code, e.g. *Botnet (URF9C02CF8BEEAC615-0200)*. Google Safe Browsing shows its threat types instead of *unsafe*. Sites that only Google or AVG / Avast flag (VirusTotal clean) are listed in Vendors too.

## 2.19.1 — 2026-11-27
- **Tools → Orphan databases redesigned:** one row per database with its own columns for **Database**, **Tables**, **Size**, **Why orphan**, **Reputation** and **ClamAV**; click any column heading to sort (largest first by default). A **keyword search** of its own filters on domain, database, table prefix and subscription (the search box of the site list still applies here too).
- **Scan with ClamAV** for an orphan database (administrator): the root helper makes a temporary SQL dump in the root-only folder `/var/lib/stingyscan`, scans it with ClamAV (clamd, or clamscan with higher size limits for large dumps) and deletes it again right after, also when the scan fails. Nothing is written in the site's folders; only the result is kept (date, size, what was found) and shown in the ClamAV column. A scan error is reported as an error, never as clean. For a database that a live site shares, only the old tables are scanned.
- A database scan is shown in the **Scan Monitor** (running, then the result or the error) and written to the **Scan log** (result, dump size, engine, duration, who) and to the site's **history**; a failed scan is logged too.
- Dashboard: the *Orphan DBs* button in the site list toolbar is gone; the orphan databases are in Tools → Orphan databases.
- **Orphan databases are no longer checked by VirusTotal** (their hostnames don't exist in DNS): no Rescan button and no Reputation column, the server refuses a VirusTotal check or rescan for them, and the 5-minute task takes any that are still in the rescan queue out of it. This saves VirusTotal quota for the real sites.
- The orphan table has no fixed column widths, so it fits narrow screens; long names wrap, and the action buttons are stacked one per line.
- Tools → Admin changes: in *Same address, admin on sites of different customers* the address column has a fixed width (a long address wraps), so the sites line up.
- **Dashboard → Grouped → Collapsed:** a checkbox on the line below the toolbar, shown only in the *Grouped* view (the button was renamed from *Group*), folds up every customer in the site list; each customer's header still shows how many of its sites are flagged. Click a customer to open or close it; the choice is remembered in the browser.
- **Tools → Vendors:** a keyword search for vendor names and domains (every word must match), so you can quickly find a site to request a review or confirm a delisting. The sites under each vendor are indented, so the vendor names stand out.
- **Tools → Scan log:** a find box: shows only the lines with all the words and highlights them.
- **Pwned Admins:** the **Trusted admin addresses** from Settings (your own and your agencies') are left out: not shown and not checked with the breach service. An address you added by hand in Pwned Admins stays.
- **Settings → File scanners:** shows how recent the **latest definitions** are for ClamAV, Maldet and Imunify (orange after 3 days, red after 7, with how to update them).

## 2.18.8 — 2026-11-27
- **Statistics tab always visible:** the tab no longer hides until settings finish loading — it is shown immediately when the page opens.
- **Settings index appears instantly:** the contents list at the top of Settings is now built from the static page structure at load time, so it appears without waiting for domain data. Dynamic sections (quarantine, mail sender, log rotation) are added once settings finish loading.
- **Faster initial load:** the full scan results (`action=all`) and settings (`action=get-settings`) are now fetched in parallel instead of sequentially, cutting the wait on servers with many domains roughly in half.

## 2.18.6 — 2026-11-27
- **Vendors tool:** new entry in the Tools tab showing every security vendor that flags one or more of your sites, sorted by number of flagged sites. Under each vendor the flagged domains are shown as coloured chips (red = infected, orange = suspicious). A **Copy URLs** button copies all flagged site addresses at once — handy for vendors like CRDF / Fortinet whose form accepts multiple URLs in one go. Clicking a site name switches to Overview and opens that site's Why? panel. Includes VirusTotal vendors, Google Safe Browsing and AVG / Avast.

## 2.18.4 — 2026-11-27
- **Persistent tools navigation:** a horizontal nav strip stays visible at the top of every tool (Pwned Admins, Admin changes, Orphan DBs, Scan log) so you can jump directly to another tool without going back to the grid. Badges on the nav items mirror the card badges (orange count for pending admin changes, red for pwned admins, gray for orphan databases). The old ← Tools back links are removed.

## 2.18.3 — 2026-11-27
- **Vendor delisting confirmation:** after a review request is accepted and the vendor delists your domain, click **✓ delisted** in the Why? panel to record the confirmation. The orange "Requested" pill turns into a bold green "✓ Delisted [date]" badge; the vendor row gets a "✓ delisted" label; and the confirmation is added to the site's history. Click *undo* if you recorded it by mistake.

## 2.18.2 — 2026-11-27
- **Admin changes now visible to resellers and clients:** each role sees only the changes on their own sites. Approve and Explain work for resellers and clients too (domain ownership is verified server-side).
- **Admin changes redesigned:** domain-grouped view with a search bar and All / Pending / Approved filter. Domains with pending changes sort to the top. The "Scan now" button is only shown to administrators.

## 2.18.1 — 2026-11-27
- Statistics stays as its own tab (reverted from Tools card in 2.18.0).

## 2.18.0 — 2026-11-27
- **Tools tab:** Pwned Admins, Admin changes, Orphan databases and the Scan log moved from separate tabs into a single **Tools** tab. Statistics stays as its own tab. The Tools tab opens to a card grid — each tool has an icon, a short description and a live badge showing the number of items that need attention. Clicking a card opens that tool with a **← Tools** back link. The Tools tab itself shows a red badge when admin changes are waiting to be reviewed.
- **Dashboard:** When admin changes need review, a compact alert bar links directly to Tools → Admin changes. The *Orphan DBs* filter button in the site list toolbar now navigates to Tools → Orphan databases instead of hiding the site table.

## 2.17.1 — 2026-11-26
- **Plesk Extensions Catalog edition** published with every release: `stingyscan-catalog-<version>.zip` (see below).
- **Database backup (Orphan DBs) uses Plesk's own `plesk db dump`:** the root helper no longer reads the Plesk database password (`/etc/psa/.psa.shadow`) or uses `mysql`/`mysqldump` directly. A backup of only the tables with one prefix skips the other tables with `--ignore-table`; a database with unusual table names is refused (back it up in Plesk instead).
- Settings → External reputation checks (AVG & Avast): a clear note that these checks use **undocumented endpoints** of Gen Digital and are **experimental** (may change, be limited or stop without notice; off by default; a hint, not proof).
- Privacy policy and README: the update check (GitHub) and the installation statistics ("Talk to mama") are marked **GitHub edition only**; the Plesk catalog edition sends nothing to Digizaal and does not contact GitHub.
- The extension's name in Plesk and in the catalog is now **Stingy Reputation Scanner** (was *Stingy Scanner by Digizaal*), the same as the header in the extension. The `meta.xml` description mentions Joomla, Drupal and the hourly admin check, and *Pwned Admins*.
- `meta.xml` declares **Linux only** (`<os>unix</os>`); the catalog description says Plesk for Windows is not supported.
- **Security (root helper `site-scan`):** root no longer writes anywhere a less trusted user could have put a link. Database backups are written into the private folder by the site user itself (root's database password is not passed on). Scan results are written as new files and renamed into place, the scan lock moved to the root-only `/var/lib/stingyscan`, and the request rate limiter runs as the panel user. WP-CLI and file actions only run as a real site user (uid 1000 or higher), never as a system account such as `psaadm` or `nginx`. A Laravel `.env` that is a link is skipped. The helper's description lists every command and these rules.
- Vendor table (*Why?*): a short explanation above it: *request a review* opens the vendor's form and copies the site address to the clipboard, and every request is remembered for the site (date, who, history), with *denied* and *undo*.
- **Plesk catalog edition:** `bash build.sh catalog` builds `stingyscan-catalog-<version>.zip` from the same code (`VtEdition::CATALOG`): no updater of its own (Plesk updates catalog extensions; no GitHub check, no `sbin/extension-update`), no installation statistics (`VtStats` is not in the package), and it does not uninstall the old VT Site Scanner by itself.
- The demo-data script for the trend graph is no longer in the extension package: it moved to [`tools/seed_demo_history.php`](tools/seed_demo_history.php) in the repository. Copy it to the server to use it (see the README); it uses the installed extension's library.

## 2.17.0 — 2026-11-26
- **Installation statistics are now off by default (opt-in).** Nothing is sent to Digizaal until the server administrator ticks *Settings → Maintenance → Talk to mama: Share installation statistics* and saves. This also applies after an upgrade: a server where the setting was never saved explicitly stops sending. A server where the administrator ticked it keeps sharing.
- **Privacy policy** for the extension: [PRIVACY.md](PRIVACY.md), also online at <https://www.digizaal.nl/stingy-scanner/privacy/>. It lists what stays on the server, what goes to which service, and what the optional statistics contain, why, where they are stored and for how long.
- **Plesk Extensions Catalog:** `meta.xml` has the product page (`url`, `help_url`), the support page (`support_url`) and the privacy policy (`privacy_policy_url`); the package contains `DESCRIPTION.md` (the catalog description), `CHANGES.md` (this changelog) and `PRIVACY.md`, and three catalog screenshots of 1024×768 in `_meta/screenshots/`.
- Product and support page: <https://www.digizaal.nl/stingy-scanner/>. The extension has a **Help and support** card with links to it and to the privacy policy; the README links to it too.

## 2.16.2 — 2026-11-26
- **Fix:** *Delete* and *Reset pwd* for a site's WordPress admin accounts always failed with *WordPress path not found on disk*. The path is now passed to the root helper (`site-scan wpuser`), which runs WP-CLI as the site's user, the same way as the Pwned emergency reset. Both also log the account out everywhere.
- **Delete is off by default:** Settings → WordPress admin accounts → *Show a Delete button for admin accounts*. When it is on, *Delete* has to be clicked twice; the server refuses a delete while the setting is off.
- README: new screenshots of **Pwned Admins**, **Admin changes** (with Explain) and a site's **WordPress admin accounts** with red signals and grey hints, and a new Settings screenshot with the index; the intro, features and Settings section describe the current functionality (placeholder names in all screenshots).
- Settings: every section and group heading has an **↑ Index** link back to the index at the top. The statistics section is listed in the index as *Talk to mama (statistics)*.
- **Installation statistics ("Talk to mama"), on by default:** Settings → Maintenance → *Talk to mama: Share installation statistics*. Once a week the 5-minute task sends the server's host name, the version, the number of hosted websites and a random installation ID to stats.digizaal.nl. Nothing else; never domain names, customers, API keys or scan results. Untick it and save to stop. Settings shows what is sent, from the server itself. See the README.
- Settings: the checkbox next to a long text is no longer squeezed (all checkboxes in Settings).
- **Collector** for those statistics in `collector/` (separate from the extension package), for stats.digizaal.nl: PHP and MariaDB, validation of exactly the documented fields, rate limits, one row per installation, a retention period (90 days) and a private dashboard with an overview, a trend chart of active installations, versions and hosted websites. Ready for more open-source programs: each is a project with its own fields in the config.

## 2.16.1 — 2026-11-26
- Settings: **Breached admin accounts** moved to the *Sites* group, right below *WordPress admin accounts*.

## 2.16.0 — 2026-11-26
- **Admin changes:** every hour Stingy Scanner compares who has admin rights on each WordPress site with the scan before, and reports what changed: a **new admin**, an **existing account made admin** (with its previous role), **admin rights without the administrator role** (capabilities given to an account or a custom role), a **role that got admin rights**, a new **Multisite super admin**, an admin's **e-mail address changed** and a **new application password**. Joomla, Drupal, Wotan, Nextcloud, WHMCS and Laravel admins are compared too. The first scan is the baseline.
- **Dashboard → Admin changes** lists the changes to review, with **Approve** and **Explain**: the requests to the admin screens in the site's access logs around that time (with IP address), the Stream plugin's audit log, and the account's logins. Each change is e-mailed once (Settings → WordPress admin accounts → *E-mail me when admin rights change*). **Scan now** compares right away.
- **Trusted admin addresses** (Settings): your own and your agencies' addresses or `@domains`; their changes are approved automatically. An untrusted address with admin rights on sites of **different customers** is shown as a hint.
- Site details, WordPress admin accounts: **red** badges are strong signals (a change, a breach, a new account), **grey** badges only hints (generic name, free or unrelated e-mail domain); only red ones count as *to review*. Each account shows since when it has admin rights and how. Accounts with admin rights but without the administrator role are listed too.
- **🛠 Fix** for a pwned admin, in a site's admin accounts (instead of *Reset pwd*) and in Pwned Admins (now a clear red button): opens the Fix panel to warn the administrator or reset the password in an emergency.
- README: a new section *What makes an account suspected*.

## 2.15.0 — 2026-11-26
- Site details: the vendor table first lists the **VirusTotal vendors** that flag the site (with how many of all VirusTotal vendors), then the **extra services** switched on in Settings (Google Safe Browsing, AVG, Avast), each group under its own heading.
- Pwned Admins: the first column (e-mail address, or site in the Group view) is wider.

## 2.14.1 — 2026-11-26
- Site details: the note *Already cleaned the site, and it is still red or orange?* is only shown for an infected (red) or suspicious (orange) site, or when a vendor flags it; no longer for clean sites.

## 2.14.0 — 2026-11-26
- Settings: the section *Breach data* is now called **Breached admin accounts**.
- When it is switched **Off**, the **Pwned Admins** tab is hidden for every user (right away after saving, and on every page load). Choosing XposedOrNot or Have I Been Pwned brings it back.

## 2.13.1 — 2026-11-26
- Settings: the section *External sites* is now called **Add custom not hosted domains**. In the site list these sites are still marked *External*.

## 2.13.0 — 2026-11-26
- **Settings has a table of contents** at the top, with a link to every section, and the sections are grouped: *Reputation services* (VirusTotal, Google Safe Browsing, AVG & Avast, Breach data), *Sites* (Sites to scan, External sites, WordPress admin accounts), *On this server* (File scanners, Quarantine), *E-mail* (Notifications, E-mail sender) and *Maintenance* (Log rotation). Only the sections you can use are listed.
- **Settings → Breach data** (new section): the choice of breach service (Off, XposedOrNot, Have I Been Pwned) and the Have I Been Pwned API key moved here from the Pwned Admins tab. That tab now shows which service is in use, with a link to the setting.

## 2.12.1 — 2026-11-26
- The Pwned? tab is now called **Pwned Admins** and is the second tab, right after Dashboard.

## 2.12.0 — 2026-11-26
- **Scan Monitor: Skip** a single waiting entry. Every entry that is still waiting has a *Skip* button: a VirusTotal rescan waiting for its turn (it is taken out before it costs a VirusTotal call), a rescan waiting in the server queue for cron, and a Pwned? test waiting for the request limit of the breach service (when *Check N addresses* runs, it goes on with the next address). *Cancel waiting* still takes out all waiting rescans at once.

## 2.11.1 — 2026-11-25
- Settings → E-mail sender: the address field is wider, so long addresses are fully visible.

## 2.11.0 — 2026-11-25
- **Settings → E-mail sender** (administrator): the address and name every e-mail of Stingy Scanner is sent from (Pwned? warnings and status notifications), for example *webmaster@example.com*. It is also the envelope sender, so receiving mail servers check SPF, DKIM and DMARC against it. Empty = the administrator's Plesk address, as before.
- **Check SPF, DKIM and DMARC** for that address, live from the server: whether SPF allows the server that really sends the mail (the relay host when there is one), whether this server signs the domain's mail with DKIM and the published key matches, and the DMARC policy, each with what to change. **Send test** sends a short test e-mail from it.

## 2.10.0 — 2026-11-25
- **Pwned? lists more systems:** administrators of **Nextcloud / ownCloud** (group *admin*; e-mail address and last login from the user preferences), **WHMCS** (active staff accounts; last login and IP address from the admin log; a custom admin folder is followed) and **Laravel** apps that have their own `admins` table (the app's `public/` folder is the site's document root) are listed and tested too, and can be warned by e-mail. An emergency reset is still WordPress only.

## 2.9.3 — 2026-11-25
- Sites installed in a folder of a domain (for example several Joomla sites in `example.com/shop`, `example.com/demo`) are shown with that folder: in the Pwned? list (a small label with the folder), the fix panel and the e-mails, instead of only the domain name. The links already went to the right folder.

## 2.9.2 — 2026-11-25
- Wotan sites: the *Forgot password* link in the Pwned? e-mails now goes to `/login/forgotpassword/`.

## 2.9.1 — 2026-11-25
- Fix… panel: in the e-mail preview the buttons and links are grey and cannot be clicked (they would open the customer's site); the real e-mail is unchanged.

## 2.9.0 — 2026-11-25
- **Fix… has two options.** **Warn** (the default) only sends an e-mail and changes nothing: it asks the owner to check the account and change the password, with *Log in and change password* and *Forgot password* links per site; it covers WordPress, Joomla, Drupal and Wotan sites. **Emergency: reset and warn** resets the WordPress password, logs the account out everywhere, and sends an e-mail that explains why it was reset. Both can be previewed and sent as a test; the address is then marked *warned* or *reset*.
- Both e-mails show **per site what is known about the account**: last login with date and IP address (from WordPress' login sessions, or a logging plugin such as WP Last Login or Stream; Joomla and Drupal store it themselves), active login sessions, the last page or post edited, and when the account was created. *If you do not recognise a login, contact us right away.*

## 2.8.1 — 2026-11-25
- E-mails and links name the server **as you open it** in the browser (for example *server22.example.com*), with the machine's internal name in brackets when it differs: in the Pwned? fix e-mail ("Sent by the hosting server …"), the fix panel, the notification e-mails and their link to Stingy Scanner. The name is remembered each time the administrator opens Stingy Scanner.

## 2.8.0 — 2026-11-25
- **Pwned? covers more than WordPress:** administrators of **Joomla** (groups *Administrator* and *Super Users*), **Drupal** 7–11 (role *administrator* and user 1) and **Wotan / phpwotan** (users with admin rights, directly or through their group) are listed and tested too, with a small label showing the system. Only the install in a site's document root counts, so old copies next to it are skipped; only databases on this server are read, read-only.
- *Fix…* resets WordPress passwords only; accounts in other systems are listed in the fix panel to change by hand.

## 2.7.1 — 2026-11-25
- The name next to the shield at the top of the page is now **Stingy Reputation Scanner**; the line under it no longer repeats "reputation scanner".

## 2.7.0 — 2026-11-25
- **Fix a pwned address** (administrator): *Fix…* next to a pwned administrator address in the Pwned? tab. It resets that administrator's password on every WordPress site where the address is administrator (to an unknown random password, with WP-CLI as the site's own user), logs them out everywhere, and e-mails them: which breaches their address is in (every breach with year, what leaked and how the passwords were stored), why the password was reset, and per site a link to choose a new password themselves. Nobody knows the new password.
- The panel shows the sites, a preview of the e-mail, and **Send test** to any address: the test is marked as a test and changes nothing. The real action asks for confirmation first, and the address is marked *fixed* with the date.

## 2.6.8 — 2026-11-25
- Settings: section names (Notifications, Sites to scan, …) are larger with a blue bar, and the content of each section is indented below its name.

## 2.6.7 — 2026-11-25
- Pwned?: every breach shows its **year** (for example *Collection-1 (2019), MyHeritage (2017)*), newest first, with the kind of data that leaked on hover. With Have I Been Pwned the date comes with each result; XposedOrNot only gives breach names per address, so there the dates come from its public list of breaches, fetched once a week. A site's WordPress admin accounts show the years too.

## 2.6.6 — 2026-11-25
- About tab: instead of the maker, it now explains what happens when a WordPress administrator is pwned (infection, blocklists and web shields, e-mail refused because it mentions a listed site), what Stingy Scanner does about it, and that it runs entirely on free APIs, optionally with Imunify, Maldet or ClamAV.

## 2.6.5 — 2026-11-25
- New subtitle under the name: *Reputation scanner for every website on this server: finds malware, phishing and hacked admin accounts, and helps a site win its good name back after an attack* (also on the Stingy Scanner button in Plesk).

## 2.6.4 — 2026-11-25
- Pwned?: the red shield of a pwned address is twice as large.

## 2.6.3 — 2026-11-25
- Gridinsoft review tip: the form works without an account only for an e-mail address that was not used there before; otherwise you need a free Gridinsoft account.

## 2.6.2 — 2026-11-25
- **Pwned? tests in the Scan Monitor:** every address sent to the breach service shows up there (red *Pwned?* label) with the wait for the request limit and the result (*Pwned: 3* or *Not pwned*). A short wait for the limit is now waited out instead of stopping.
- XposedOrNot allows only about 25 tests an hour (above that it asks to wait half an hour), so tests are now spread out: one every 2½ minutes at most, and the 5-minute background task tests untested addresses on its own, so nobody has to keep the page open. When the service asks for a long wait, the message says so instead of calling it the daily limit.
- The category for addresses that were not tested yet is called **Not tested** (next to Pwned and Not pwned).
- Documentation: Stingy Scanner described as what it has become, a reputation scanner and a helper to get a site's good name back after an attack; a new Pwned? section on why breached admin addresses matter and what to do about them.

## 2.6.1 — 2026-11-25
- **Pwned?** works like the site list: a **search** box (site, customer, login, e-mail address or breach name), filter buttons **All · Pwned · Not pwned · Not tested** with their counts, and **Group / Sort**. *Group* shows one block per WordPress site; *Sort* shows each e-mail address once, with every site it is administrator of, sortable by address, number of sites or number of breaches.
- A pwned address shows the same **red shield** as in a site's WordPress admin accounts, and is printed in red.

## 2.6.0 — 2026-11-25
- **Pwned?** tab next to Statistics: the administrator accounts of every WordPress site in one list, with whether each e-mail address is in a known data breach (breach names and years). *Only pwned* shows just the ones that need a new password. Each address is checked **once** and never again; **Check N addresses** does the rest within the rate limit, and the nightly run checks new ones.
- Add **other e-mail addresses** by hand in the Pwned? tab, and remove them again.
- **Breach data from** XposedOrNot (free, default) or Have I Been Pwned (your own key), or Off; chosen by the administrator in the Pwned? tab. The *WordPress admin accounts* section of a site uses the same results, so an address is never asked twice (results of the 24-hour cache of 2.5.7 are taken over).
- **External sites:** watch the reputation of sites hosted elsewhere (Settings → External sites). VirusTotal, Google Safe Browsing and AVG / Avast check them like the other sites; they are listed under Infected, Suspicious or Clean with an **External** mark, and can be removed in Settings or from their details. File scans and Pwned? do not apply to them.

## 2.5.8 — 2026-11-25
- **Fix: OTA update failed silently on some Plesk versions.** The self-install button used `--upgrade-url`, which is not a valid Plesk CLI flag on all versions; Plesk would exit 0 without installing anything. The updater now downloads the zip first and runs `--upgrade` with a local file, which works on every supported Plesk version.

## 2.5.7 — 2026-11-25
- **XposedOrNot breach check** (replaces EmailRep.io and HIBP). Each WordPress admin email is now checked against XposedOrNot — free, no API key needed, 25 checks/hour per server. The red badge shows the breach count; hover shows the breach names (e.g. "Adobe, LinkedIn, Dropbox"). Results are cached 24 hours.

## 2.5.6 — 2026-11-25
- **Have I Been Pwned v3 breach check.** Replaces EmailRep.io. Each WordPress admin email is now checked against the actual HIBP database — the same source everyone checks manually. The red badge shows the breach count; hover shows the breach names (e.g. "Adobe, LinkedIn, Dropbox"). Results are cached 24 hours. Requires a HIBP API key in Settings (personal plan, $3.50/month from haveibeenpwned.com). Without a key the check is skipped.

## 2.5.5 — 2026-11-25
- **Collapsible cleanup steps and site history.** In the Details panel of a flagged site, the "How to clean up" numbered steps and the "History of this site" section are now collapsible. Both always appear at the bottom. All collapsible sections (including WordPress admin users) now have a larger, more prominent ▶/▼ arrow in accent blue.

## 2.5.4 — 2026-11-25
- **Free breach check via EmailRep.io.** Each WordPress admin email is automatically checked against EmailRep.io (free, no key required, 100 checks/day). A red "Credentials leaked" or "Found in data breach" badge appears when an email was found in known breach data; results are cached 24 hours. An optional free EmailRep.io API key raises the limit to 1000/day.
- **Fix: "Invalid database or table prefix"** for sites whose database name contains a hyphen (common in Plesk-generated names). The validation regex now allows hyphens in database names.

## 2.5.3 — 2026-11-25
- **Have I Been Pwned integration** (replaced in 2.5.4 by EmailRep.io). Add a HIBP API key in Settings → WordPress admin user detection. Each admin email is then checked against the HIBP database; a red badge appears if the address was found in a known data breach, with the breach names as a tooltip. Results are cached 24 hours.
- **Fix: Reset password / Delete returned "invalid parameters"** — the POST parameter was named `action`, which Plesk's router reserves for routing. Renamed to `act`.
- **Delete tooltip** shows which admin will receive the deleted user's posts and pages (or warns when there is no other admin).

## 2.5.2 — 2026-11-25
- **WordPress admin user detection.** A site's Details panel now shows all WordPress administrator accounts and flags suspicious ones. Four heuristics: account younger than 30 days, generic/bot-added username, free email provider, and email domain unrelated to the site. Each flag comes with a full explanation. Requires the administrator role; can be switched off in Settings → WordPress admin user detection.
- **Delete or reset password** for a flagged (or any) admin user, using WP-CLI. Reset shows the new random password once; it is never stored. Useful when a pwned password may have given an attacker access to every site on the server.
- **Pwned password warning** in the WP admin section and in the flag details: even a known legitimate admin account is dangerous when its password appeared in a data breach — the attacker can log in and infect all sites on the server.
- **AVG / Avast false-positive help**: the contact tip for AVG now explains that the whitelist form requires a browser extension ID that is only visible inside the full AVG Browser app (not a Chrome extension). Same context added for Avast.

## 2.5.1 — 2026-11-24
- Installing or upgrading to Stingy Scanner now automatically removes the old VT Site Scanner extension (`virustotal-extension`) if it is still installed. Settings, results and history are copied over first.

## 2.5.0 — 2026-11-24
- Dashboard budget strip replaced by three compact donut charts: **Auto** (blue), **Manual left** (green) and **VT quota** (amber), with the daily limit and date alongside.
- File scanner jobs in the Scan Monitor now show real progress: ClamAV reports *X of Y files · ~N min left*; Imunify shows its own phase and percentage. Duration is shown when the scan finishes.

## 2.4.1 — 2026-11-23
- The **Error** filter button above the site list is gone. Sites without a result still show *No result* in the list and can be rescanned from their row.

## 2.4.0 — 2026-11-23
- A file that is quarantined or cleaned **no longer counts as infected**: the *files infected* badges and counts go down right away, and the file stays in the list, struck through, with Restore / Undo. After a restore it counts again. Imunify results also skip files that no longer exist.
- **Quarantined files are deleted after 30 days** (Settings → Quarantine; 0 = keep them until you delete them), by the nightly scan. Each site's list of quarantined files shows the date.
- **Delete** a quarantined file for good from the site's details, or **Delete all quarantined files** in Settings → Quarantine, which also shows how many files (and how much space) are in quarantine. Both ask first and warn that deleted files cannot be restored. Every deletion is in the site history and the log.

## 2.3.0 — 2026-11-23
- **Real progress for file scans.** A ClamAV scan now shows a bar that fills up, with *X of Y files*, the percentage and an estimate of the time left (from the speed so far). ClamAV scans from a list of the site's files, so it reports every file; this is as fast as before.
- When Imunify is scanning the site itself, **Imunify results** waits for it and shows Imunify's own percentage and phase, then the results.
- Site list: **Site**, **VT**, **Panel** and **Copy** are now small icons (globe, VirusTotal logo, control panel, copy), with a tooltip; Copy turns into a green check when copied.

## 2.2.2 — 2026-11-23
- Site list: next to **Site** and **VT**, two more small buttons: **Panel** opens the site in Plesk (Websites & Domains), and **Copy** copies the domain name.

## 2.2.1 — 2026-11-23
- Quarantine now works for every file, also for files owned by root or another user (before, only files the site user could read). Root does the file work without following any link: the path is opened folder by folder, a link anywhere stops it, hard links are refused, and only the exact file that was copied is removed. Restore puts back the original owner, permissions and date, and never overwrites a file.
- When cleaning or quarantine fails, the log says why, and *Clean all* / *Quarantine all* name the reason per file.

## 2.2.0 — 2026-11-23
- **New name: Stingy Scanner** (was StingyScan). Everywhere you see it: the Plesk menu, the extension list, the Home card, e-mails, the About tab, the license and the documentation. The extension id (`stingyscan`), the panel address, the download names and the repository stay the same, so updates keep working as before.

## 2.1.1 — 2026-11-23
- Site list: the status column is wider, so every detection (file scans, Avast/AVG, Google) stays on one line.
- On the site rows, *Infected* now reads **Infected Reputation**: it is the reputation of the site address (VirusTotal and the other online services), not a file scan. The filter buttons keep the short name.

## 2.1.0 — 2026-11-23
- **Clean and quarantine infected files** (administrator), in the list of infected files of a file scan:
  - **Clean** with Imunify (ImunifyAV+ or Imunify360): shows first what Imunify will change, then cleans after your confirmation. Imunify keeps the original: **Undo** puts it back. Works for files ClamAV found too (Imunify checks that one file first).
  - **Quarantine** on any server: the file moves to a root-only folder with its original place, permissions and date; **Restore** puts it back exactly.
  - **Clean all** / **Quarantine all**, a list of cleaned and quarantined files per site with Undo / Restore, and every action in the site history and the log.
  - Safe by design: only files inside the site's folder, no links, and all file work runs as the site's own system user, never as root.
- The **Trend** tab is now called **Statistics**.
- Settings show the Imunify license; with the free ImunifyAV (detection only) there is no Clean button.

## 2.0.4 — 2026-11-23
- **One file-scan engine, chosen automatically.** Maldet scans with ClamAV's engine and puts its signatures (rfxn.*) in ClamAV's database, so running both only scanned every file twice. Now: ClamAV only → **ClamAV scan**; ClamAV and Maldet → ClamAV only, button **ClamAV/Maldet scan**; Maldet only → **Maldet scan**, but only when the new setting *Maldet enabled* is on (default off); otherwise the button is disabled with the reason. A Maldet scan is refused while ClamAV is installed. Old Maldet results stay in the files but are no longer shown while ClamAV is used.
- Settings → Internal serverside file scanners: new **Scan engine** section with ClamAV and Maldet versions, whether clamd runs, the *Maldet enabled* switch, whether the Maldet signatures are in ClamAV (with a hint to run `maldet -u`), the active engine, and **Re-detect engines**. Opening Settings detects the engines again.
- The result of a file scan names the engine; a ClamAV scan with the Maldet signatures says so.

## 2.0.3 — 2026-11-23
- The file scanners (ClamAV, Maldet, Imunify) are for further investigation only. Their buttons are no longer on every site row; click a site (or its **Details** button) to see them. A scan or rescan never starts a file scan; a file scan starts only when you click its button. While a file scan runs, or when it found infected files, the Details button shows that.

## 2.0.2 — 2026-11-22
- New home: [dzaal/StingyScan-for-Plesk](https://github.com/dzaal/StingyScan-for-Plesk). The old repository dzaal/VT-Scanner-for-Plesk stays, so existing installations keep finding their updates.
- An installed VT Site Scanner now updates to StingyScan **in place**: `virustotal-extension.zip` is the same StingyScan, packaged under the old extension id (`bash build.sh legacy`). Settings, keys, results, history and the panel address stay as they are. Updates then come from the new repository.
- License in plain language: StingyScan is the intellectual property of Dirk Zaal (Digizaal). Free to install and use as published; changing, copying into other software or distributing needs written permission.

## 2.0.1 — 2026-11-22
- Fix: the Plesk hooks (menu button, Home card) still had class names of the old extension id. While VT Site Scanner was installed next to StingyScan this gave "Cannot redeclare class Modules_VirustotalExtension_CustomButtons", and the Home card did not load.

## 2.0.0 — 2026-11-22
- **New name: StingyScan** (was VT Site Scanner), with a new logo. *Stingy* because it is sparing with every API call; the name no longer contains a third party's trademark.
- New extension id `stingyscan` (was `virustotal-extension`), panel address `/modules/stingyscan/`, and repository `dzaal/StingyScan-for-Plesk` (the old address redirects).
- **Coming from VT Site Scanner:** install StingyScan; it copies the settings, API keys, results, history and logs of VT Site Scanner. Then remove the old extension with `plesk bin extension --uninstall virustotal-extension`. Until then StingyScan shows a reminder, because both would run their own scans. Releases also carry the zip under its old name, so the update check of VT Site Scanner finds StingyScan.
- Documentation: Settings, Google Safe Browsing and AVG / Avast Web Shield described in full; what is sent to which service; trademark notices in the README and in the About tab.

## 1.35.3 — 2026-11-22
- License: VT Site Scanner by Digizaal, including its code, design and way of working, is the intellectual property of Digizaal. The source code may be read; installing and running the unmodified extension is allowed. Modifying the code in any way, derivative works and redistribution are not allowed without written permission. See LICENSE.

## 1.35.2 — 2026-11-22
- Google Safe Browsing has its own card in Settings, apart from the experimental AVG / Avast checks (it is Google's official API).
- The card explains how to get a key, with direct links to the Google Cloud Console: enable the Safe Browsing API, create and restrict the key, and see its quotas and usage.

## 1.35.1 — 2026-11-22
- Settings: no text lighter than rgb(32, 32, 32), for easier reading.
- The online services (VirusTotal, AVG, Avast, Google Safe Browsing) each have their own coloured block with a larger logo.
- A green check (*API key active*) next to VirusTotal and Google Safe Browsing when the key is accepted and in use; a red cross with the reason when VirusTotal or Google rejects it (for Google: the last answer from Google).

## 1.35.0 — 2026-11-22
- New: **Google Safe Browsing** (optional, administrator), Google's official list of unsafe sites that Chrome, Firefox and Safari use to warn visitors. Uses your own Google API key (Google Cloud → APIs & Services → Safe Browsing API); a new key is tested with Google's own test page before it is saved, and the key is never sent to the browser.
- Every site is checked each night (up to 250 sites per request), and live when you open a site's details or rescan it. Adds no VirusTotal API usage. Calls today and a per-minute limit are shown in Settings.
- A listed site gets a badge (for example *Google: Phishing*) and a row in the Why? table with a link to Google Search Console to request a review. Listing and delisting go into the site history and Recent status changes.
- Following Google's terms, a result is used for 30 minutes at most; after that it is shown as *last known* and checked again. Google allows this API for non-commercial use only.

## 1.34.1 — 2026-11-22
- Fix: a rescan could run twice, in the browser and by the server queue at the same time (two VirusTotal calls, budget charged twice). The open page now reports its rescans every 30 seconds; the server only takes over a rescan when no page has reported it for 3 minutes.
- Fix: after the server queue had finished rescans, every page load for 2 hours fetched those reports again from VirusTotal (spending manual calls). It now shows the result the server already saved.
- Fix: two runs of the server queue could overlap and scan the same sites; only one runs at a time now. The queue file is changed under a lock and written safely, so the browser and the server no longer overwrite each other's changes. A rescan that VirusTotal refuses is taken off the queue instead of being retried every 5 minutes.
- Security: the review address saved with a review request must be an http(s) address or an e-mail address, and the site history only makes links of http(s) addresses (a `javascript:` link could otherwise run code when the administrator clicked it).
- Removing a rescan from the server queue now checks that the site is yours.

## 1.34.0 — 2026-11-22
- Max calls / day is a number field again (default 500); the separate slider for it is gone.
- The slider for background scan / reserved for manual scans has a thin black line as its handle.
- Number fields in Settings (cache days, max calls, log rotation) are narrower: 2/12 of the width each.
- New: **Log rotation** (administrator, server-wide). A scan log larger than the limit (default 5 MB) is compressed to an old copy (`cron_<user>.log.1.gz`, …) and a new log is started; at most 5 old copies are kept and none older than 90 days. All three are adjustable. Checked every 5 minutes and before the nightly scan.

## 1.33.0 — 2026-11-22
- VirusTotal daily budget as two clear sliders, each with its name inside: **Max calls / day** (0 – 1,000) and **Reserved for manual scans (%)**. Each range has its own colour (background scan blue, manual rescans purple, outside the budget hatched) and an orange bar inside it shows what was used today. The number of VirusTotal calls made today is shown large above the sliders, split into background and manual rescans.
- AVG and Avast one below the other as **AVG Web Shield** and **Avast Web Shield**, with what they are, and the number of calls made today next to each.
- "Internal scanners" is now "Internal serverside file scanners".

## 1.32.0 — 2026-11-22
- VirusTotal daily budget as one slider from 0 to 10,000 calls: drag the bottom knob for the daily limit and the top knob for the share kept for manual rescans (the rest is for the background scan). Orange bars show the calls used today in each part. The numbers can still be typed.
- A 20px logo next to each scanner and service in Settings (VirusTotal, AVG, Avast, ClamAV, Maldet, Imunify) and next to Avast / AVG in the site details. The logos ship with the extension; nothing is loaded from outside.

## 1.31.2 — 2026-11-22
- Fix a missing request-token variable that stopped the Install button before it sent a request. Use Plesk's privileged extension helper, wait for its actual result, and verify the installed version before reloading.
- Report failed upgrades and connection errors instead of treating them as success.
- Read the installed version directly from package metadata; refresh GitHub update checks every 15 minutes instead of 24 hours.

## 1.31.1 — 2026-11-22
- Keep today's VirusTotal API usage with its API settings in a compact two-column summary, including background/manual counters and the date. Remove the separate statistics card at the bottom.

## 1.31.0 — 2026-11-22
- Redesign Settings: VirusTotal first with four columns of numeric controls; AVG/Avast directly below in a separate Experimental section; detected internal scanners next.
- Enable AVG, Avast, Imunify, Maldet and ClamAV independently, with a separate 1–5 requests/minute limit per provider/scanner (default 2).
- Enforce optional check limits server-wide across users and browser tabs. External checks wait without losing the previous result; internal scanner starts respect their rate and the existing single-scan queue. Imunify still only reads its own results.
- Keep settings usable on narrow screens, with two-column VirusTotal fields and stacked provider controls.

## 1.30.4 — 2026-11-22
- Copy the site's full HTTPS URL when opening a vendor review form or e-mail, including direct AVG/Avast false-positive requests.
- Clipboard contents are replaced, never appended; show confirmation or an explicit message if copying is blocked. Undoing or denying a request does not copy anything.

## 1.30.3 — 2026-11-22
- Show direct AVG and Avast checks and classification changes in Recent status changes, separately from VirusTotal verdicts.
- Record the first successful clear check as “No classification”; do not present it as a proven delisting. Import existing checks at their original timestamps.
- Compare with the last successful observation, so a failed request between two successful checks does not hide an improvement.

## 1.30.2 — 2026-11-22
- Trend tab, Recent status changes: a solid, coloured arrow between the two statuses (green = better, red = worse).

## 1.30.1 — 2026-11-22
- The Avast / AVG badge in the site list (for example *Avast: Botnet*) no longer wraps onto two lines.

## 1.30.0 — 2026-11-22
- Click anywhere on a site's row to open or close its details (Why?), not only on the score.
- Fix: the details of an infected site made the page too wide; long text and links now wrap within the table.

## 1.29.1 — 2026-11-22
- Avast / AVG false-positive link: explains that the form's Alert ID comes from the warning popup of the Avast / AVG app, not from this check, and what to do without one.

## 1.29.0 — 2026-11-22
- Avast and AVG are now two checkboxes in Settings: switch on either one or both. With both, each site gets a row for Avast and one for AVG in the details, and a badge for each that classifies it (two requests, one second apart).
- The earlier choice and the saved results are carried over.

## 1.28.0 — 2026-11-22
- Avast / AVG is now checked live instead of in the background: when you open the details of a site, and with every rescan. A result of the last 5 minutes is reused; *check again* asks right away. Still at most one request per second server-wide.
- AVG (or Avast) is the first row of the vendor table in the details, marked *(direct)*, with its classification, *No classification received* or *Check failed*, and the false-positive link (remembered like the other review links).
- While the check is on, every site has a *Details* button on its score, also clean sites.
- The background task (`avast_scan.php`) and its queue are gone.

## 1.27.1 — 2026-11-22
- Fix: the Avast / AVG setting jumped back to Off after saving.

## 1.27.0 — 2026-11-22
- Optional Avast / AVG classification (Settings, administrator; off by default). Asks the URL reputation service of Avast (product 146) or AVG (147) how it classifies each site, for example *URL:Botnet*. Unofficial: worked out by hand, so it may stop working; failures show as *Check failed*.
- Runs as its own background task every 5 minutes, never in a page request: at most one request per second server-wide, never two at once (shared lock, also across processes), and a pause on HTTP 429 (Retry-After, at least 60 seconds).
- Every site about once a week, classified sites every day, failed checks after an hour; *Check now* in the Why? panel puts a site first in the queue.
- Dashboard: a red *AVG: Botnet* badge under the status of a classified site. Why? panel: the checked URL, time, HTTP status, classification and detection name, or *No classification received*, with a link to the official false-positive form (choose URL in the form).
- Site history: when the classification appears, changes or goes away.

## 1.26.0 — 2026-11-22
- Review requests: mark one as **denied** (for example "added less than a day ago"), with an optional reason. The Requested note is removed from the overview, so you can ask again later, and the site's history shows "Review denied" with the reason.
- The undo link is now only for a click made by mistake.

## 1.25.0 — 2026-11-21
- History per site, at the bottom of the Why? panel, newest first, with date (time):
  - Detected: the first time the site was flagged, with the score and the vendors.
  - Flagged / Delisted: a vendor started flagging the site, or no longer flags it.
  - Status changes: coloured [status] → [status].
  - Review asked: which vendor, via website form or by e-mail (and to which address), and by whom; undone requests too.
- Clean sites that have a history get a History button on their score.
- The first detection of every site is filled in once from the scan logs.

## 1.24.0 — 2026-11-21
- Why? panel: a click on a vendor's review link (website form or e-mail) is remembered per site and per vendor: "✓ Requested 21-11-2026 (22:58) by admin", with undo.
- Saved on the server, so every admin, reseller or customer who manages the site sees it, in any browser.
- The panel header shows at how many of the flagging vendors a review was requested, and those vendors get a check mark.

## 1.23.1 — 2026-11-21
- Recent status changes: the coloured status change is now the second column, before the site name; badges have the same width so the columns line up.

## 1.23.0 — 2026-11-21
- Includes the work of 1.21 to 1.22.1, which ran on the server but was never released:
  - Rescans keep going on the server when you leave the page: a queue that is processed every 5 minutes.
  - Recent status changes are recorded at the moment a site is scanned.
- Recent status changes (bottom of the Trend tab): one line per change with date (time), site, and coloured [status] → [status]; the arrow is green when it got better, red when it got worse.
- Older status changes are filled in once from the scan logs.
- An infected or suspicious site that leaves the site list (deleted, disabled or suspended) shows as Left the list.
- A site's first result (pending → infected) no longer counts as a change.
- The administrator sees all changes on the server, including sites that have left the list.

## 1.20.0 — 2026-11-21
- Trend tab: Recent status changes at the bottom, per site with date and time, coloured from → to status (infected, suspicious, clean, or left the list).
- Older status changes are filled in once from the scan logs.
- A site that was infected or suspicious and leaves the site list (deleted, disabled or suspended) is recorded as Left the list.
- About tab: What's new, with links to the latest changes and all versions.

## 1.19.0 — 2026-11-20
- Infected files badge: when ClamAV, maldet or Imunify finds infected files, a red badge appears in the site's status column; a click opens the file scanner details.
- Click the Scan Monitor header to open or close it.
- Fix: after a failed rescan the Score and Last scan columns kept spinning.

## 1.18.0 — 2026-11-20
- File scans (ClamAV, maldet, Imunify) show in the Scan Monitor next to the VirusTotal lookups, with the infected count.
- Colour bars per job: blue = VirusTotal running, amber = file scan running, green = done and clean, red = failed or infected.
- A Completed divider separates running from finished jobs; Clear finished also clears file scans.
- Scan Monitor is a panel on the right, just below the header.

## 1.17.0 — 2026-11-19
- Scan Queue renamed to Scan Monitor, with Collapse and Expand.
- Shows several jobs at once (running, up to 5 waiting, up to 8 finished), so failures stay visible; finished jobs disappear after 30 seconds.
- A failed job marks only the step that failed in red.
- When the Plesk session has expired, the page reloads to the login.

## 1.16.0 — 2026-11-19
- Update check: a yellow banner shows when a newer version is available, with the release notes and an Install button (admin only) that upgrades the extension in one click.
- Sort by Domain, Score or Last scan by clicking the column header, in both Group and Sort mode (within each group).
- Group or Sort mode: grouped by reseller and customer, or one flat list. Mode, sort column and direction are remembered.
- Last scan shows how long ago the site was checked; the exact time on hover, VirusTotal's own analysis date below it.
- Faster first load: the site list appears right away while results load, with a progress bar.
- Fix: Rescan failed with Submit failed.
- Fix: two VT Site Scanner items in the Plesk menu; stray menu buttons are cleaned up on update.

## 1.15.6 — 2026-11-18
- Demo data for resellers and customers: `seed_demo_history.php --resellers`, `--customers` and `--remove`.
- Demo data is scaled to the number of sites on the server.

## 1.15.4 — 2026-11-18
- Trend tab for customers: their own sites, recorded daily per customer.

## 1.15.3 — 2026-11-18
- Menu item in the customer panel too (hosting panel tabs).

## 1.15.2 — 2026-11-18
- Trend tab for resellers: their own customers and sites, recorded daily per reseller.

## 1.15.1 — 2026-11-18
- A ready-made, installable zip is published as a GitHub Release for every version.
- One-command install and update:
  `plesk bin extension --upgrade-url https://github.com/dzaal/VT-Scanner-for-Plesk/releases/latest/download/virustotal-extension.zip`

## 1.15.0 — 2026-11-18
- Dashboard groups sites by reseller and customer; groups can be folded.
- Search also finds customers.

## 1.14.1 — 2026-11-18
- Orphan databases outside Plesk can be backed up too.
- Demo trend data in proportion to the number of sites.
- README: trend screenshot.

## 1.14.0 — 2026-11-17
- New Trend tab: infected, suspicious and cleaned sites per day over 1, 2 or 3 months; daily totals are saved.
- Orphan DBs has its own filter button.
- Refresh also reloads the orphan databases.

## 1.13.0 — 2026-11-17
- Orphan databases: per leftover hostname the database, its size and whether a live site still uses it.
- Back up an orphan database to a private folder, with a Delete-in-Plesk link.

## 1.12.0 — 2026-11-17
- Related hostnames: leftover WordPress hostnames without DNS are listed separately and checked only on request.
- API key comes first in Settings.

## 1.11.1 — 2026-11-17
- WordPress hostnames from leftover databases that no longer exist in DNS are skipped.

## 1.11.0 — 2026-11-17
- Left menu item for the admin, resellers, customers and the Power User view.
- Sites wait for an API key instead of showing Error.

## 1.10.3 — 2026-11-17
- Fortinet: links the Malicious URL Appeal form instead of the software dispute form.

## 1.10.2 — 2026-11-17
- Review links to the website forms of Sophos, BitDefender, Chong Lua Dao, Trustwave and Bfore.Ai.
- Tips per vendor and a pre-filled e-mail for vendors without a form.

## 1.10.1 — 2026-11-17
- Review links to the vendor forms of alphaMountain and Gridinsoft.
- Clearer rescan steps.

## 1.10.0 — 2026-11-17
- Why flagged: per site, the vendors that flag it, with review links and delisting steps.

## 1.9.1 — 2026-11-17
- Settings: scanner details wrap at words.

## 1.9.0 — 2026-11-17
- File scanners can be switched on and off in Settings, with their detection status.

## 1.8.3 — 2026-11-17
- The page breaks out of the Plesk frame, so notifications are no longer shown twice.

## 1.8.2 — 2026-11-17
- Fix: scanner bar was squashed by the score-bar style.

## 1.8.1 — 2026-11-17
- Scanner buttons are easier to see.

## 1.8.0 — 2026-11-17
- Scanner bar per site for ClamAV, maldet and Imunify, through one root helper (`sbin/site-scan`) with an adapter per scanner.
- Detects which scanners are installed; runs ClamAV or maldet on demand on the document root.
- Reads Imunify's latest result without starting a scan (Imunify may be set to clean up on detect).
- A click opens a second line under the site with progress, then the infected files.
- The extension only detects; it never changes sites.

## 1.7.4 — 2026-11-17
- Queued count includes automatic lookups.
- File-list dialog shows above the Plesk UI.

## 1.7.2 — 2026-11-17
- Scan files: on infected or suspicious rows, scans the site's document root with the running clamd (read-only, one scan at a time, later clicks queue).
- Results show on the row, with a file-list dialog.
- About tab and README explain why the tool exists: Plesk's own VirusTotal check ran out of API calls daily and left sites unscanned.

## 1.6.4 — 2026-11-17
- Disabled and suspended sites drop out of the list, also when they are WordPress subsites of a hosted domain.
- The hosted-domain list is cached 10 minutes instead of a day.

## 1.6.3 — 2026-11-17
- Coffee button: PayPal.Me link updated.

## 1.6.2 — 2026-11-17
- Buy-me-a-coffee button goes to PayPal, $3.

## 1.6.1 — 2026-11-17
- Notifications go to one e-mail address (empty = your Plesk address).
- One summary e-mail with the status changes and the full list of infected and suspicious sites: after the nightly scan, and during the day 10 minutes after a change.
- A site that flips back before the summary is sent is left out.

## 1.6.0 — 2026-11-17
- E-mail notifications when a site becomes infected, suspicious or clean again; from the nightly scan and from dashboard lookups and rescans.
- Refresh and Rescan infected buttons replaced by a menu on each status button: Rescan (capped at the manual budget) and, on All, Refresh site list.
- README: users and roles, notifications.

## 1.5.0 — 2026-11-17
- New official VT shield logo with a transparent background, in the Extensions list, left menu, tools entry, page header and README.

## 1.4.0 — 2026-11-17
- Scan queue on one line: the site being checked, or the latest result.
- Animated bar counts down the pause for VirusTotal's 4-per-minute limit.
- New About tab: the maker, who the tool is for, and a Buy-me-a-coffee button.
- README: who it's for.

## 1.3.2 — 2026-11-17
- Scan queue keeps every finished site with its result: status, score and time, or why the lookup failed.

## 1.3.1 — 2026-11-17
- Plesk's page header is hidden on the scanner page; only the branded header shows.

## 1.3.0 — 2026-11-17
- Scans every hosted website: active domains and subdomains with hosting, plus WordPress sites on hostnames under them.
- New setting Sites to scan: all hosted websites or WordPress only.
- The Scanner enabled switch is gone.
- Home card and nightly scan follow the chosen scope.

## 1.2.1 — 2026-11-17
- Page title completes Plesk's breadcrumb (Home > Extensions > VT Site Scanner).
- Branded header with logo, version and Digizaal link.
- Catalog icons; deep links work.

## 1.2.0 — 2026-11-17
- Plesk Home page card: infected, suspicious and clean counts and the worst-scoring sites; reads cached results only.
- Fix: removed a broken permissions hook that logged an error on every request.
- README: screenshots.

## 1.1.0 — 2026-11-17
- Installable by others: the nightly scan is registered in Plesk's scheduler on install and removed on uninstall.
- `build.sh` builds the zip; settings file with the API key is written with mode 0600.
- README: requirements, installation, updating, uninstalling, troubleshooting, data and privacy.

## 1.0.0 — 2026-11-17
- First version: scans the WordPress sites on a Plesk server against the VirusTotal API v3.
- Per-key rate limiter (4 per minute, 500 per day), result caching, nightly background scan and a live queue for manual rescans.
