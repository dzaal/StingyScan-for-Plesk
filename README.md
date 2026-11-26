<img src="docs/logo.png" alt="" width="72" align="right">

# Stingy Scanner for Plesk

**A reputation scanner for every website on your Plesk server, and a helper to get a site's good name back after an attack.**

When a site is hacked, the damage does not stop when the malware is gone. Browsers warn visitors away, security vendors keep the address on their blocklists, mail from the domain lands in spam, and one bad site can drag down the reputation of the server's IP address and every other site on it. Stingy Scanner watches that reputation and walks you through the recovery:

1. **Notice it early.** Every hosted site (and any [external site](#external-sites) you add) is checked against [VirusTotal](https://www.virustotal.com)¹, and optionally Google Safe Browsing¹ and AVG / Avast¹, for malware, phishing and spam, within the limits of VirusTotal's free API.
2. **Find the cause.** Scan the site's files with ClamAV, Maldet or Imunify, clean or quarantine what was found, and look at the WordPress administrator accounts: unknown or recently added admins, and admins whose e-mail address is **[pwned](#pwned-admins-data-breaches)** in a known data breach, the usual way back in for an attacker.
3. **Close the door.** Delete rogue admins, reset passwords, and use the Pwned Admins overview to see every administrator address on the server that appears in a breach.
4. **Get delisted.** See exactly which vendors still flag the site, ask each of them for a review with one click, and follow the [history of the site](#cleaned-but-still-red) until every vendor has removed it.

<sub>¹ Stingy Scanner is an independent product by Digizaal. It is not affiliated with, endorsed or sponsored by VirusTotal, Google, Gen Digital (AVG, Avast) or WebPros (Plesk). All trademarks belong to their owners; see [Trademarks](#trademarks).</sub>

Made by **Dirk Zaal** of **[Digizaal](https://www.digizaal.nl)**, a web development and hosting company in Amsterdam. *Stingy* because it is sparing with every API call. Stingy Scanner was called **VT Site Scanner** until version 1.35; see [Coming from VT Site Scanner](#coming-from-vt-site-scanner-1x).

> **Nothing happens without your click.** Scans, lookups and breach checks only look and report. Changes are made only when the administrator clicks them, one at a time and with a confirmation: cleaning or quarantining a file (both can be undone), deleting a WordPress admin or resetting its password, and backing up an orphan database.

> [!TIP]
> **Beta testers wanted.** Do you run a Plesk server with many websites, as a hosting company, agency or sysadmin? Try Stingy Scanner for two weeks and tell us what you think. You get early access to new versions, direct contact with the developer, and a mention in this README if you like.
>
> **[Sign up as a beta tester](https://github.com/dzaal/StingyScan-for-Plesk/issues/new?template=beta-signup.yml)** · install with [one command](#installation) · **[send feedback](https://github.com/dzaal/StingyScan-for-Plesk/issues/new?template=beta-feedback.yml)**

![Stingy Scanner dashboard in Plesk: every hosted site with its status, score, file scanners and Rescan (placeholder names)](docs/screenshots/scanner-dashboard.png)

## Who it's for

Hosting companies, agencies and server admins who look after **more sites than VirusTotal's free API can check in a day**. The free key allows 500 requests per day and 4 per minute. With 500 sites or more you can't check them all every day, and a simple scanner burns the whole quota before you get to the one site you just cleaned up.

Stingy Scanner makes that quota go a long way:

- **Every site gets its turn.** The nightly scan picks up where it stopped the night before, so all sites are checked in rotation, however many there are.
- **Quota left for you.** Part of the daily budget is always kept for manual rescans.
- **No wasted calls.** Clean sites are re-checked after 30 days, infected or suspicious sites after 1 day.
- **One overview.** All sites with their status on one page and on the Plesk Home page, so a flagged site stands out right away.

## Screenshots

**Dashboard:** every hosted website, grouped by reseller and customer, with its status, detection score, last scan, file scanner buttons and Rescan. Badges such as *Avast: Botnet* come from the optional direct checks.

(See the screenshot at the top.)

**Why is a site flagged, and how do you fix it?** Click a flagged site: you see Google Safe Browsing, AVG and Avast (direct), every VirusTotal vendor that flags it with a review link, and which reviews you already requested.

![Vendors that flag a site, with review links and requests already made](docs/screenshots/why-flagged.png)

Below that, the **history of the site**: detections, review requests, and classifications appearing or going away.

![History of a site](docs/screenshots/site-history.png)

**Card on the Plesk Home page:** counts per status and the sites flagged by the most engines.

<p>
  <img src="docs/screenshots/home-widget.png" alt="Stingy Scanner card on the Plesk Home page" width="346">
</p>

*Domain names, IP addresses, customer names and API keys in these screenshots are replaced with placeholders. The trend graph partly shows demo data (the shaded days).*

---

## Why this extension exists

Digizaal hosts about 600 WordPress sites on a single Plesk server. A single compromised site can harm its visitors, get the server's IP address blacklisted, and damage the reputation of every other site on it, so we need to know early when a site has been flagged.

With that many sites, VirusTotal's free API quota (500 requests per day) runs out every single day: checking every site even once takes more than a day, and rescans of infected sites come on top of that. Plesk ships with its own VirusTotal integration (*VirusTotal Website Check*), but every day it reported that the API calls were exhausted and not all sites had been scanned, leaving the rest unscanned, with no control over which sites were checked or when. That left no room to rescan a site after cleaning it up, which is the moment you need it most.

Stingy Scanner was built to fix that:

- **Careful with API calls.** Every call goes through a rate limiter, results are cached, and the daily budget is split between background scans and manual rescans.
- **Interactive.** A live dashboard shows all sites, grouped by reseller and customer (click a customer to fold its sites away; the search box also finds customers), lets you filter on infected or suspicious ones, and rescans a site on demand, with a Scan Monitor that shows each step of each scan.
- **Hands-off.** A nightly background scan works through all sites in turn and picks up where it left off the night before.

## Features

- Dashboard with every website hosted on the server (WordPress or not): status (Infected / Suspicious / Clean / Queued / Error), detection score (e.g. `3/93` engines), IP address, domain age and danger tags (malware, phishing, …), with direct links to the site and to its VirusTotal page.
- **Home page card** for the Plesk admin (Plesk 18.0.60 or newer): infected / suspicious / clean counts and the worst-scoring sites, styled like Plesk's own cards. It reads cached results only and never uses API calls. Show or hide it via **Home → Customize → Security → Stingy Scanner**.
- **Scan Monitor**: a panel on the right that shows the VirusTotal lookups, file scans and Pwned? breach tests that are running, waiting and finished, each with its steps and result (blue = VirusTotal running, amber = file scan running, green = done and clean, red = failed or infected). The pause for VirusTotal's 4-requests-per-minute limit is waited out automatically instead of failing. Each entry that is still waiting has a **Skip** button to take just that one out of the queue. Click its header to open or close it.
- **Rescans keep going when you leave the page.** A rescan is also queued on the server, and a task that runs every 5 minutes finishes it if the browser was closed first.
- **Group or Sort:** sites grouped by reseller and customer, or one flat list. Click the **Domain**, **Score** or **Last scan** header to sort (within each group in Group mode). Mode, sort column and direction are remembered. *Last scan* shows how long ago the site was checked, with the exact time on hover.
- **Details per site:** click anywhere on a site's row (or its score) to open its details: the vendors that flag it with review links, Google Safe Browsing and AVG / Avast if switched on, and the history of the site. Click again to close.
- **History per site:** when it was first detected, when vendors started or stopped flagging it, status changes and every review request (see [Cleaned, but still red?](#cleaned-but-still-red)).
- **Optional Google Safe Browsing**, Google's official API: every site each night and live when you open its details (see [Google Safe Browsing](#google-safe-browsing-optional)).
- **Optional AVG / Avast Web Shield** classification (experimental), asked live (see [AVG / Avast Web Shield](#avg--avast-web-shield-optional-experimental)).
- **Update check:** when a newer version is on GitHub, a yellow banner appears with the release notes and, for the administrator, an **Install** button that upgrades the extension in one click.
- **Nightly background scan** (03:00, server time), scheduled automatically through Plesk's own scheduler.
- **Statistics tab:** a trend graph of infected, suspicious and cleaned sites per day over the last 1, 2 or 3 months, for the whole server, per reseller or per customer (see [Statistics](#statistics)).
- **Helps you solve it, not just report it.** Click the score of an infected or suspicious site to see which vendors flag it, with a link per vendor to ask for a review (see [Cleaned, but still red?](#cleaned-but-still-red)).
- **E-mail notifications:** one summary e-mail with status changes and the full list of infected sites (see [Notifications](#notifications)).
- **Works for every Plesk user level:** administrator, reseller and client (see [Users and roles](#users-and-roles)).
- **Category menus:** the small arrow next to each status button (All, Infected, Suspicious, …) opens a menu with **Rescan**, which rescans every site in that category, worst first and never more than today's manual budget allows. The menu next to **All** also has **Refresh site list**.
- **File scanners on demand:** in a site's details, one file-scan button for the engine found on the server (ClamAV, or Maldet when ClamAV is missing) plus Imunify's results. Results and infected files appear right under the site (see [File scanners](#file-scanners-clamav-maldet-imunify)).
- **Clean and quarantine** (administrator): let Imunify clean a file after showing what changes, or move it to a root-only quarantine; both can be undone (see [Cleaning and quarantine](#cleaning-and-quarantine-administrator)).
- **WordPress rogue admin detection** (administrator): open any site's details to see all WordPress administrator accounts. Four heuristics flag suspicious ones: account younger than 30 days, generic/bot-added username, free-email provider (Gmail, Yahoo, …), or email domain unrelated to the site. Every admin e-mail address is tested once against the breach service chosen in the Pwned Admins tab (XposedOrNot by default, free) — a red shield icon and red email address appear when the address was found in a known data breach, with the breach names in a tooltip. You can **Delete** the user (posts are reassigned to another admin) or **Reset password** directly from the panel using WP-CLI. Click **▶ Log** on any user to see recent logins, content activity, and — if the Stream plugin is installed — a full audit trail. See [WordPress rogue admin detection](#wordpress-rogue-admin-detection-administrator).
- **Pwned Admins tab:** every WordPress administrator on the server and whether their e-mail address is in a known data breach, with search, filters (Pwned / Not pwned / Not tested) and a view per address; each address is tested once. Add any other address by hand (see [Pwned?](#pwned-admins-data-breaches)).
- **External sites:** watch the reputation of sites hosted elsewhere, in the same list (see [External sites](#external-sites)).
- **Log tab** with a colour-coded scan log, and **log rotation** so the logs stay small (see [Settings](#settings)).
- **About tab** about the maker, with a *Buy me a coffee* button.

## File scanners (ClamAV, maldet, Imunify)

VirusTotal judges a site from the outside (its URL and domain). To look inside a site, click the site (or its **Details** button): the details show a line **Check the files on the server** with the file-scan buttons. They are for further investigation and run only when you click them. A scan or rescan never starts a file scan, and neither does the nightly background scan.

**One scan engine, chosen automatically.** Maldet scans with ClamAV's engine when ClamAV is installed, and copies its own signatures (`rfxn.hdb`, `rfxn.ndb`, `rfxn.yara`) into ClamAV's database. A ClamAV scan therefore already covers Maldet, and running both would only scan every file twice. So a file scan uses exactly one engine:

| Installed on the server | Engine used | Button |
|---|---|---|
| ClamAV only | ClamAV | **ClamAV scan** |
| ClamAV and Maldet | ClamAV (with the Maldet signatures) | **ClamAV/Maldet scan** |
| Maldet only, *Maldet enabled* on | Maldet | **Maldet scan** |
| Maldet only, *Maldet enabled* off | none | disabled: *Maldet is installed but disabled in settings* |
| neither | none | disabled: *No scanner found (install ClamAV)* |

- **ClamAV** ([clamav.net](https://www.clamav.net)) scans the site's document root. It uses a running `clamd` (for example the one for mail scanning) via `clamdscan --fdpass`, so signatures are not loaded again; otherwise `clamscan`.
- **Maldet** ([Linux Malware Detect](https://www.rfxn.com/projects/linux-malware-detect/)) runs `maldet -a` on the document root only (the temp folders maldet normally adds are skipped). It is refused while ClamAV is installed.
- **Imunify results** (ImunifyAV / Imunify360) is not a scan engine: it **starts no scan** and shows the result of Imunify's own latest scan of the site, including files Imunify has already cleaned.

![A ClamAV scan in progress: 35%, 2,165 of 6,116 files](docs/screenshots/file-scan-progress.png)

A click opens the result under the site: the scan while it runs (with a progress bar, the number of files done and an estimate of the time left), then the result (labelled with the engine that was used) and the list of infected files with the signature that matched. **← Details** goes back to the site details. While a file scan runs, or when it found infected files, the site's **Details** button shows a spinner or a red number. **Scan again** runs a new scan.

- **On demand only.** One scan runs at a time on the server; a click while another scan is busy waits its turn and starts by itself. You can leave the page; the scan keeps running.
- **Detection only.** The extension asks the scanner to report, never to clean, quarantine or delete. maldet runs with its own quarantine setting, which is off by default; leave `quarantine_hits=0` in `/usr/local/maldetect/conf.maldet`.
- **Why Imunify is read-only:** Imunify handles what it finds according to its own settings (*Default action on detect*, for example *cleanup*). Starting an Imunify scan from here could therefore change files, so the extension only reads its results.
- Scans run at low CPU and disk priority. A large site takes a few minutes (about 17,000 files took 5–6 minutes with ClamAV in testing).
- maldet's own daily cron scan (`/etc/cron.daily/maldet`, on when `cron_daily_scan="1"` in `conf.maldet`) runs outside the extension. With ClamAV installed you may not need it; that is up to you.
- Scanners don't always agree, and VirusTotal can flag a site for spam or phishing content in its database while its files are clean. Signatures starting with `PUA.` or `Heuristics.` are often false alarms.

### Cleaning and quarantine (administrator)

In the list of infected files, the administrator gets an **Action** column. Nothing happens without a click and a confirmation, and every action can be undone:

- **Clean** (needs ImunifyAV+ or Imunify360): Stingy Scanner first asks Imunify whether it recognises the file; if Imunify has not seen it yet, it scans only that file (detection only). It then shows **what Imunify will change** (removed lines in red) before you confirm. Imunify removes the malicious code, or empties the file when the whole file is malicious, and keeps the original: **Undo** puts it back. Files Imunify does not recognise cannot be cleaned; use Quarantine for those. This also works for files ClamAV found.
- **Quarantine** (any server): the file is moved to `/var/lib/stingyscan/quarantine`, a folder only root can open, together with its original place, permissions, date and checksum. **Restore** puts it back exactly, and never overwrites a file that is there again.
- A quarantined or cleaned file **no longer counts as infected**: the counts and badges go down right away; after a restore it counts again.
- **Quarantined files are kept 30 days**, then the nightly scan deletes them (**Settings → Quarantine**; 0 = keep them until you delete them). **Delete** removes one file for good from the site's details; **Settings → Quarantine** shows how many files are in quarantine and has **Delete all quarantined files**. Deleted files cannot be restored; both ask first.
![Infected files with Clean and Quarantine, and Imunify's preview of what cleaning changes](docs/screenshots/file-actions.png)

- **Clean all with Imunify** / **Quarantine all** handle every listed file one by one and report what was skipped.
- **Cleaned and quarantined files** in the site details lists everything that was handled, with Undo / Restore. Each action is written to the site history and the Log tab.

Safety: the file must be inside the site's document root (no `..`, no symbolic links). Quarantine and Restore work for any file owner (site user, `apache`, root), and do the file work without following links: the path is opened folder by folder from `/var/www/vhosts`, a link anywhere in it stops the action, files with extra hard links are refused, and only the exact file that was copied is removed. Restore never overwrites a file and puts back the original owner, permissions and date. Cleaning is done by Imunify itself. Check the site after cleaning: a cleaned or removed file can break it until you undo. Cleaning removes the symptom, not the hole; update the site and change passwords too.

### Settings and request rates

Every optional online service and every internal scanner has its own **1–5 requests/minute** limit (default **2**), shared by all users and browser tabs. Cached results use no request. New checks wait for their turn; internal file scans run one at a time.

### Scan engine settings

**Settings → File scanners** (the *Internal serverside file scanners* section) shows:

- **Scan engine:** ClamAV installed or not, with its version and whether the `clamd` daemon is running; Maldet installed or not, with its version.
- **Maldet enabled** (default off): use Maldet when ClamAV is **not** installed. With ClamAV installed the switch is ignored, and the page says so.
- **Signatures** (when both are installed): whether the Maldet signatures (`rfxn.hdb`, `rfxn.ndb`, `rfxn.yara`) are in ClamAV's signature folder. If they are missing, run `maldet -u` on the server.
- **Active engine:** the engine the rules above choose, and the label of its button.
- **Imunify:** an on/off switch for the Imunify results button.

The switches save right away and apply to the whole server; only the administrator can change them. The extension checks what is installed once an hour, and again each time the administrator opens Settings. After you install or remove a scanner, **Re-detect engines** updates it immediately.

## WordPress rogue admin detection (administrator)

A compromised or attacker-added WordPress administrator account is one of the most common ways a cleaned site gets re-infected: the attacker logs back in and re-uploads the malware. Stingy Scanner surfaces these accounts before that happens.

Open any site's details panel (click anywhere on the row) and scroll to **WordPress admin accounts** at the bottom. The section loads all WordPress administrator accounts for that site and flags suspicious ones with coloured badges:

| Badge | Meaning |
|-------|---------|
| New account | Registered less than 30 days ago |
| Suspicious name | Generic or bot-pattern username (`admin`, `wp-admin`, random strings, …) |
| Free email | Gmail, Yahoo, Hotmail, Outlook, … — disposable, hard to trace |
| Foreign email | Email domain unrelated to the site domain |
| Found in N breaches | Email address in a known data breach (source: XposedOrNot) |

Every admin email is checked once against the breach service chosen in the **Pwned Admins** tab (see below). When a breach is found, a red shield icon appears left of the username, the email address turns red, and hovering the badge shows the breach names (Adobe, LinkedIn, Dropbox, …).

A flag is a reason to investigate, not proof. Always verify before taking action.

### Actions

- **▶ Log** — expands an inline activity row for that user showing: recent logins with timestamps and IP addresses (from WordPress session tokens), recent posts and pages created or edited, and — if the [Stream plugin](https://wordpress.org/plugins/stream/) is installed — a full audit trail with logins, password resets and content changes.
- **Delete** — removes the user via WP-CLI; posts and pages are automatically reassigned to another administrator. Hover the button to see who gets the content. Requires WP-CLI on the server.
- **Reset pwd** — generates a strong random password and applies it via WP-CLI. The new password is shown once; copy it immediately.

### Settings

**Settings → WordPress admin user detection** (administrator only):

- **Enable / disable** the scan for all users on the server.

WP-CLI must be installed on the server for Delete and Reset pwd. Without it, those buttons show an error with a link to [wp-cli.org](https://wp-cli.org).

## Pwned Admins (data breaches)

**Why it matters.** Most hacked WordPress sites are not broken into through a clever exploit, but simply logged into. Billions of e-mail addresses and passwords from old data breaches (LinkedIn, Adobe, Canva, …) are traded, and bots try them on every WordPress login page they find. An administrator who once used the same password for a breached service and for WordPress hands the attacker the keys: they log in, upload malware, add an admin of their own, and the site is flagged again days after you cleaned it. On a server with many sites, one address that is administrator of dozens of sites can put all of them at risk.

The **Pwned Admins** tab (second, right after Dashboard) shows where that risk is:

- **Every site administrator on the server**: WordPress (from the database the site's `wp-config.php` points to), **Joomla** (groups *Administrator* and *Super Users*), **Drupal** 7–11 (role *administrator* and user 1) **Wotan / phpwotan** (users with admin rights, directly or through their group), **Nextcloud / ownCloud** (group *admin*), **WHMCS** (active staff accounts) and **Laravel** apps with their own `admins` table: site, customer, login, e-mail address and since when the account exists. Other systems than WordPress get a small label. Only the install in a site's document root counts (old copies next to it are skipped), and only databases on this server are read, read-only.
- **Whether the address is in a known data breach**: *Pwned: 3 breaches*, with the breach names and years (hover a name for the kind of data that leaked). Pwned addresses have a **red shield** and are printed in red, as in a site's *WordPress admin accounts*.
- It works like the site list: **search** (site, customer, login, address or breach name), filter buttons **All · Pwned · Not pwned · Not tested** with their counts, and **Group** (one block per site) or **Sort** (each address once, with every site it is administrator of; click a column to sort by address, number of sites or number of breaches, so the address that controls the most sites is on top).
- **Other e-mail addresses:** add any address by hand (your own, a colleague's, a customer's) and remove it again. Each user sees the addresses they added; the administrator sees all of them.
- Resellers and customers see the accounts of their own sites.

**Tested once.** A breach is history: an address that was in a breach stays in it. So each address is tested only once and the result is kept; a site's *WordPress admin accounts* section uses the same result, so an address is never sent twice. A failed test is tried again. **Check N addresses** tests the ones that were never tested, one after another within the service's rate limit; each test appears in the **Scan Monitor** (*Pwned?*, red), with the wait for the request limit and the result. You don't have to keep the page open: a background task tests a few addresses every hour, and the nightly run tests new ones too. Accounts are read again every 6 hours (**Read accounts again** for right now).

**What to do with a pwned address.** A pwned address does not mean the site is hacked; it means a password used with that address may be known to attackers.

1. Ask the owner of the address to set a new, unique password for the WordPress account (or click **Reset pwd** in the site's details), and for every other place they used the old one.
2. Turn on two-factor login for WordPress administrators.
3. Check the site's admin accounts for ones you don't know (the *WordPress admin accounts* section flags new accounts, bot-like names and foreign e-mail domains), and remove them.
4. If the site was flagged, scan its files, clean them, and ask the vendors for a review (see [Cleaned, but still red?](#cleaned-but-still-red)).

**Fix a pwned address** (administrator). Click **Fix…** next to a pwned administrator address and choose:

- **Warn** (recommended, the default): an e-mail only; nothing is changed. It asks the owner to check the account and set a new, unique password, with *Log in and change password* and *Forgot password* links for every site where the address is administrator (WordPress, Joomla, Drupal, Wotan, Nextcloud, WHMCS and Laravel).
- **Emergency: reset and warn**: the WordPress password is reset to an unknown random password (WP-CLI, run as the site's own user), the account is logged out everywhere, and the e-mail explains why the password was reset and links to each site's *Lost your password?* page. Only for WordPress accounts; requires WP-CLI on the server.

Both e-mails come from the server administrator's Plesk address and name the server as you open it. They list every breach (year, what leaked, how the passwords were stored), and under each site **what is known about the account**: last login with date and IP address (from WordPress' login sessions or a logging plugin such as WP Last Login or Stream; Joomla, Drupal, Nextcloud and WHMCS store it themselves), active login sessions, the last page or post edited, and when the account was created, so the owner can spot a login that was not theirs.

The panel shows the sites with that activity and a **preview** of the e-mail. **Send test** sends it to an address of your choice, marked as a test, and changes nothing. Sending for real asks for confirmation; the address is then marked *✓ warned* or *✓ reset* with the date, and the Log tab lists it.

**Settings → Breach data** (administrator) chooses the service; the Pwned Admins tab shows which one is in use, with a link to it:

| Choice | Notes |
|---|---|
| **XposedOrNot** (default) | Free, no key. Breach years and leaked data come from its public breach list, fetched once a week. It allows about 25 tests an hour and Stingy Scanner keeps to 90 a day, so a large server is done in a few days, in the background. |
| **Have I Been Pwned** | Your own API key from [haveibeenpwned.com/API/Key](https://haveibeenpwned.com/API/Key) (paid subscription). The key is tested and its rate limit read when you save it. Breach data under CC BY 4.0. |
| **Off** | Nothing is sent; the overview still lists the accounts, without breach results. |

Only the e-mail address is sent, once per address. No passwords or password hashes ever leave the server.

## External sites

Watch the reputation of sites that are **not hosted on this server**: **Settings → Add custom not hosted domains → Add site** (type `example.com`, or paste an address). They are checked like the hosted sites by VirusTotal (lookups, nightly refresh, Rescan), Google Safe Browsing and AVG / Avast, and they count under Infected, Suspicious and Clean, marked **External** in the list and grouped under *External sites*. ClamAV, Maldet, Imunify and Pwned? do not apply: the site's files and accounts are not here.

Remove a site in Settings → Add custom not hosted domains, or with **Remove from the list** in its details. Each user has their own external sites (and gets them in their notification e-mails); the administrator sees and can remove all of them. A hostname that is hosted on this server cannot be added: it is already in the list.

## Settings

![Settings: VirusTotal with its daily budget, Google Safe Browsing, the experimental AVG / Avast checks, and the scan engine](docs/screenshots/settings.png)

The **Settings** tab starts with a **table of contents**: one column per group, with a link to each section (only the sections you can use are listed). The sections, grouped (text in Settings is never lighter than rgb(32, 32, 32), for easy reading):

**Reputation services**
- **VirusTotal**: the API key, with a green check *API key active* when VirusTotal accepts it (a red cross when it doesn't).
  - **Daily API budget**: the number of VirusTotal calls made today, large, split into background scan and manual rescans.
  - **Max calls / day** (default 500, the free tier).
  - A slider with a thin black line: left of it is the **background scan**, right of it is **reserved for manual scans (%)**. Each part is coloured and shows in orange how much of it was used today.
  - How long clean and infected results are cached.
- **Google Safe Browsing** (administrator): on/off, API key with green check, calls today, requests per minute, and how to get a key with direct links to the Google Cloud Console. See [Google Safe Browsing](#google-safe-browsing-optional).
- **AVG & Avast – Experimental** (administrator): **AVG Web Shield** and **Avast Web Shield**, each with its own switch, calls today and requests per minute. See [AVG / Avast Web Shield](#avg--avast-web-shield-optional-experimental).
- **Breach data** (administrator): which service tests the administrator addresses of the Pwned Admins tab (Off, XposedOrNot, Have I Been Pwned) and the Have I Been Pwned API key, tested before it is saved. See [Pwned Admins](#pwned-admins-data-breaches).

**Sites**
- **Sites to scan**: all hosted websites, or WordPress sites only.
- **Add custom not hosted domains**: sites hosted elsewhere, see [External sites](#external-sites).
- **WordPress admin user detection** (administrator): enable or disable the rogue admin scan for all users on the server. When enabled, the **WordPress admin accounts** section appears at the bottom of every site's details panel. See [WordPress rogue admin detection](#wordpress-rogue-admin-detection-administrator).

**On this server**
- **Internal serverside file scanners**: ClamAV, Maldet and Imunify, see [File scanners](#file-scanners-clamav-maldet-imunify).
- **Quarantine** (administrator): how long quarantined files are kept, and delete them all.

**E-mail**
- **Notifications**: see [Notifications](#notifications).
- **E-mail sender** (administrator): see [E-mail sender](#e-mail-sender).

**Maintenance**
- **Log rotation** (administrator, whole server): a scan log larger than the limit (default **5 MB**) is compressed to an old copy (`cron_<user>.log.1.gz`, `.2.gz`, …) and a new log is started; at most **5** old copies are kept, none older than **90 days**. The limits apply to each log file (every Plesk user has their own). Checked every 5 minutes and before the nightly scan.

Each online service has its own coloured block with its logo, so you see at a glance which service a setting belongs to.

## Users and roles

Stingy Scanner works at all three Plesk user levels: **administrator**, **reseller** and **client**. Each user opens it from their own Plesk panel and only ever sees their own sites.

| Level | Sees |
|---|---|
| **Administrator** | Every hosted site on the server |
| **Reseller** | Their own sites and those of their customers |
| **Client** | Only their own sites |

Every user has their own settings: API key, budget, sites to scan and notifications. Users without an API key of their own automatically use the administrator's key.

## Notifications

In **Settings → Notifications**, each user can switch on e-mail for when one of their sites changes status:

- **When a site becomes:** Infected, Suspicious, and/or Clean again (only after it was infected or suspicious, so a first clean result doesn't count).
- **Send to:** one e-mail address. Leave it empty to use the address of your Plesk account.

You don't get an e-mail per site. Changes are collected and sent as **one summary e-mail** with:

1. the status changes (old → new status, score, and the vendors that flag the site), and
2. the full list of your sites that are **infected right now**, plus the suspicious ones.

The summary goes out at the end of the nightly scan, and during the day 10 minutes after a change, so several changes share one e-mail. A site that flips back to its old status before the summary is sent is left out. **Send test e-mail** sends a sample summary with your current infected list.

Mail is sent with the server's own mail system (PHP `mail()` via sendmail), from the administrator's e-mail address. Keep in mind that a single vendor flagging a site can be a false alarm, so check a site before alarming its owner.

## Statistics

The **Statistics** tab shows how infections develop, per day, over the last **1, 2 or 3 months**. The administrator sees the whole server; a **reseller** sees only their own customers and sites, and a **customer** only their own sites:

- **Infected** and **suspicious** sites per day, as lines.
- **Sites cleaned per day**: sites that were infected or suspicious and are clean again, as bars.
- At the top: infected and suspicious now, with the change since the start of the period; how many sites were cleaned in the period; and the number of clean sites.
- Hover over a day for its figures, or open **Show as table**.
- **Recent status changes**, newest first, one line per change: the date (time), the status before and after as coloured badges with a solid arrow between them (green = better, red = worse), and the site, for example `20-11-2026 (11:10)  [Infected] ➡ [Suspicious]  flower-centrum.example`. Click the site to open its VirusTotal report. A site that was infected or suspicious and leaves the site list (deleted, disabled or suspended in Plesk) shows as *Left the list*. Changes from before this list existed are filled in once from the scan logs.

![Statistics: trend graph, infected and suspicious sites per day, and sites cleaned per day](docs/screenshots/trend.png)

*The shaded days are demo data; the days after are real totals.*

![Recent status changes: VirusTotal status changes and AVG / Avast classifications per site](docs/screenshots/status-changes.png)

The totals are saved once a day: by the nightly scan (for the server, every reseller and every customer), and whenever someone opens the dashboard. The history is kept for about a year in the data folder (`vt_history.json` for the server, `vt_history_r_<login>.json` per reseller, `vt_history_c_<login>.json` per customer). Demo data is only added when you run the demo script below.

To see what the graph looks like before there is any history, you can fill the last 92 days with made-up example data (clearly marked as *demo*, shaded in the graph, and replaced by real totals day by day):

```bash
sudo -u psaadm /usr/local/psa/admin/bin/php /usr/local/psa/admin/plib/modules/stingyscan/scripts/seed_demo_history.php
```

Options: `--resellers` also fills every reseller's history, `--customers` every customer's. The demo figures are scaled to the number of sites (never more infected sites than there are) and end at today's real totals. `--remove` deletes all demo days again, everywhere. Resellers and customers see the same *Demo data* note and shading, so they can tell it's example data.

## Orphan databases

The **Orphan DBs** button next to the status filters (shown only when there are any) opens a separate list, WordPress databases on the server for a hostname under one of your domains that doesn't exist in DNS: usually old copies, test or staging sites (`staging.`, `test.`, `2025.`, …) whose database was never removed.

Nobody can visit them, but VirusTotal often still has them on file, sometimes as infected, and an old copy that is never updated is an easy target. Per hostname you see:

- **The database**, the number of tables and their **size**, and the subscription it belongs to.
- **Whether a live site still uses it** (the extension reads the `wp-config.php` files on the server):
  - *No WordPress install on this server uses this database*: the whole database can go.
  - *Old tables inside a database a live site uses*: the old copy shares a database with a live site, under its own table prefix (for example `WzyRCpCbc_*`). **Delete only those tables, never the database**, or the live site goes down.
  - *A WordPress install on disk uses these tables*: check before deleting anything.
- The VirusTotal **score**, **Why?** and **Rescan**, as for any other site. They are not looked up automatically, to save API calls. There is no file scan button, because there are no files.

Buttons (administrator only):

- **Back up** makes a `.sql.gz` copy of the database, or only of the old tables, in the subscription's `private/vt-db-backups/` folder, owned by the subscription's user. Nothing is deleted.
- **Delete in Plesk ↗** opens the subscription's **Databases** page in Plesk. Delete the database there, or use phpMyAdmin from that page to drop only the old tables.

Stingy Scanner never deletes anything itself. After you delete a database, the hostname disappears from the list within a day, or right away with **Refresh site list** in the menu next to **All**.

## Cleaned, but still red?

A red or orange site raises two questions for the webmaster: *who* says the site is unsafe, and *how* do I get that changed once the site is clean? Stingy Scanner answers both on the same screen, so you don't have to search for each vendor's support page yourself.

![Vendors that flag a site, with review links and the steps to get delisted](docs/screenshots/why-flagged.png)

The status in Stingy Scanner comes from **VirusTotal**, not from the files on your server. VirusTotal shows what dozens of security vendors think of a site, and **each vendor keeps its own blocklist** and updates it on its own schedule. So after you clean a site, it can stay *infected* or *suspicious* in the dashboard for a while: sometimes hours, often days, sometimes weeks, and some vendors only remove a site when you ask.

Click a flagged site's row, or its **score** (for example *8/92 · Why?*). A second line opens with:

- **The vendors that flag the site** and what they call it (for example *Fortinet: malware*).
- **A review link per vendor**: a form or e-mail address where you can report that the site is clean. The contacts come from [VirusTotal's list of vendor contacts](https://docs.virustotal.com/docs/false-positive-contacts); where a vendor has its own form for websites, that form is used instead (for example [alphaMountain](https://www.alphamountain.ai/false-positive/) and [Gridinsoft](https://portal.gridinsoft.com/false-positive)). For a vendor that is not in the list, the link goes to VirusTotal's list.
- **Which vendors you already asked.** A click on a review link is remembered per site and per vendor, with the date and time and who clicked (*✓ Requested 21-11-2026 (22:58) by admin · denied · undo*). When a vendor turns the request down (for example because the site was added to its list less than a day ago), click **denied** and optionally give the reason: the note disappears so you can ask again later, and the history keeps *Review denied* with the reason. *Undo* is for a click made by mistake. It is saved on the server (`vt_reviews.json`), so everyone who manages the site sees it. The header shows at how many of the flagging vendors a review was requested.
- **The history of the site**, newest first: when it was first detected (score and vendors), when each vendor started or stopped flagging it, its status changes, and every review request: which vendor, via website form or by e-mail (and to which address), and by whom. Clean sites that have a history get a **History** button on their score. Saved in `vt_sitelog.json`; the first detection of each site is filled in once from the scan logs.
- **The steps to get delisted:**
  1. **Clean the site first.** Use the file scanner buttons to find infected files. Update WordPress, plugins and themes, remove unused plugins, change all passwords (admin, FTP/SFTP, database, hosting) and remove unknown admin users. Otherwise the site is soon hacked and listed again.
  2. **Click Rescan.** VirusTotal checks the site address again with all vendors (one manual API call). The score in the dashboard comes from VirusTotal's report for the whole domain, which follows when the vendors update their own lists, so it does not always drop right away.
  3. **Ask the vendors that still flag it for a review**, using the links. Mention the site address, that it has been cleaned and what you did.
  4. **Google:** if Chrome shows a red warning, the site owner can request a review in [Google Search Console → Security issues](https://search.google.com/search-console/security-issues).
  5. **Rescan again after a few days** to see who has removed it. Infected and suspicious sites are also re-checked daily by the background scan. If a vendor says it has removed the site but VirusTotal still shows it, open the `www.` and `http://` versions of the address on virustotal.com and click **Reanalyze** on each: VirusTotal keeps a separate report for each version.

**Vendors that often flag websites**, and where to ask for a review (checked November 2026):

| Vendor | Where | Notes |
|---|---|---|
| alphaMountain.ai | [false-positive page](https://www.alphamountain.ai/false-positive/) | Ticket form; you have to log in or sign up. After approval it takes up to 24 hours to apply; then reanalyze on VirusTotal. Many site owners complain about slow answers. |
| Gridinsoft | [portal.gridinsoft.com/false-positive](https://portal.gridinsoft.com/false-positive) | Gridinsoft's own form for websites (not their support desk). It works without an account only for an e-mail address Gridinsoft has not seen before; with an address that was used there already, you need a free Gridinsoft account. Give the full address and proof the site was cleaned. Gridinsoft also looks at other vendors' verdicts, so ask the others first. |
| Fortinet | [Malicious URL Appeal](https://www.fortiguard.com/faq/malurl) | Web form: the URL, your name, e-mail and company, and a comment. (Not the "classification dispute" form, which is for software.) |
| Sophos | [Submit a sample](https://support.sophos.com/support/s/filesubmission) | Choose *Web Address (URL)*; no Sophos account needed. Usually 24–72 hours; you may not get a reply. |
| BitDefender | [bitdefender.com/submit](https://www.bitdefender.com/submit) | Choose *False positive* and *URL*; mention you own the site and add the VirusTotal link. |
| CRDF | [false-positive form](https://threatcenter.crdf.fr/false_positive.html) | Web form. |
| G-Data | [submit a URL](https://www.gdata.de/help/en/general/GeneralInformation/submitFileAppURL/) | Web form. |
| Lionic | [report a false positive](https://www.lionic.com/supports/report-false-positive/) | Web form. |
| Chong Lua Dao | [report a mistake](https://chongluadao.vn/en/report/reportmistake) | Complaint form for mislabelled sites. |
| Trustwave | [VirusTotal detection review](https://support.trustwave.com/virustotal-detection-review/) | Web form. |
| Bfore.Ai PreCrime | [ticket form](https://portal.bfore.ai/knowledge-base/kb-tickets/new) | Ticket form. |
| Webroot | [change request](https://support.threatintel.opentext.com/tools/change-request.php) | Web form. |
| SOCRadar | vt@socradar.io | No form; e-mail with the VirusTotal link. Site owners report that it works. |
| CyRadar | virustotal@cyradar.com | No form; e-mail with the VirusTotal link. |
| MalwareURL | team@malwareurl.com | No form; e-mail with the VirusTotal link. |
| Google Safe Browsing | [Search Console → Security issues](https://search.google.com/search-console/security-issues) | For the site owner; otherwise the [report form](https://safebrowsing.google.com/safebrowsing/report_error/). |

For vendors with only an e-mail address, the link in the extension opens an e-mail with the subject and a short message already filled in, including the VirusTotal link. If a vendor has confirmed the removal but VirusTotal still shows it after reanalyzing, you can send that confirmation to VirusTotal through its [false positive page](https://docs.virustotal.com/docs/false-positive).

The extension does not send review requests itself: each vendor has its own form or address, and a request should come from someone who can vouch that the site is clean.

## Google Safe Browsing (optional)

[Google Safe Browsing](https://safebrowsing.google.com) is Google's list of unsafe sites (malware, phishing, unwanted software, harmful apps). Chrome, Firefox and Safari use it to warn visitors, so a listed site loses visitors right away. VirusTotal also shows a Google Safe Browsing verdict, but asking Google directly gives a fresh answer, uses no VirusTotal calls, and links straight to the right review page.

**Set it up** (administrator, once for the whole server):

1. In the [Google Cloud Console](https://console.cloud.google.com/projectselector2/home/dashboard), open or create a project.
2. [Enable the Safe Browsing API](https://console.cloud.google.com/apis/library/safebrowsing.googleapis.com).
3. [Create an API key](https://console.cloud.google.com/apis/credentials) (*+ Create credentials → API key*) and restrict it: *API restrictions* → only **Safe Browsing API**; *Application restrictions* → **IP addresses** → your server's outgoing IP address.
4. In **Settings → Google Safe Browsing**, tick the switch, paste the key and click **Save settings**. The key is first tested with Google's own test page (always listed as phishing); a key that doesn't work is not saved and you see Google's error. A green check *API key active* shows it works. The key is stored on the server and never sent to the browser.

**What it does:**

- **Every night** all sites are checked, up to 250 per request (the `https://` and `http://` address of each), before the VirusTotal scan.
- **Live** when you open a site's details or rescan it.
- A listed site gets a red badge such as *Google: Phishing* and a **Google Safe Browsing (direct)** row in the vendor table, with a link to [Search Console → Security issues](https://search.google.com/search-console/security-issues) to request a review after cleaning. The click is remembered like the other review links.
- Listing and delisting go into the site history and **Recent status changes**; clean results don't, so the feed is not flooded.
- Google's terms do not allow treating a site as unsafe on information older than 30 minutes. A result is therefore used for 30 minutes at most; after that it is shown as *last known* and checked again when you open the details.
- **Limits:** Google gives every project a default quota; see the [Quotas](https://console.cloud.google.com/apis/api/safebrowsing.googleapis.com/quotas) page of the API, where you can also ask for more. The nightly check needs 1 request per 250 sites. When Google answers *quota exceeded*, all checks pause for 10 minutes.

> Google allows the Safe Browsing API for **non-commercial use only** ([terms](https://developers.google.com/safe-browsing/terms)). For commercial use Google offers the paid [Web Risk API](https://cloud.google.com/web-risk). Only the site addresses are sent; Google may use them to improve its services.

Results are kept in `vt_gsb.json`, calls per day in `vt_gsb_state.json`.

## AVG / Avast Web Shield (optional, experimental)

VirusTotal's list does not always show what AVG and Avast think of a site, while many visitors use those products. In **Settings → External reputation checks** the administrator can switch on **AVG Web Shield** (product 147), **Avast Web Shield** (product 146) or both. It asks the URL reputation service those products use themselves (their antivirus Web Shield and browser extensions) how they classify each site, for example `URL:Botnet`. Only that service is asked; the sites themselves are not visited.

> **Unofficial.** There is no public API for this; the format was worked out by hand and may change or stop working at any time. When it does, the result shows *Check failed* and nothing else is affected.

- **Live, not in the background.** The check runs when you open the details of a site and after every rescan. A result of the last 5 minutes is reused; *check again* asks right away. Each product has its own requests-per-minute limit (default 2), and there is never more than one request per second for the whole server. On HTTP 429 all checks pause for the *Retry-After* time (at least 60 seconds). Settings shows the number of calls made today for each.
- **What you see.** AVG and/or Avast are rows of the vendor table in the details, marked *(direct)*: the classification with its detection name, *No classification received*, or *Check failed* with the reason. A classified site also gets a red badge such as *AVG: Botnet* under its status. For a false positive there is a link to the official form ([Avast](https://www.avast.com/report-false-positive), [AVG](https://www.avg.com/en-us/report-false-positive)); you submit it yourself and choose **URL** in the form.
- **History.** The site history and **Recent status changes** note when the classification appears, changes or goes away.
- The latest result per site is kept in `vt_avast.json`.

## How it saves API calls

VirusTotal's free API allows **4 requests per minute** and **500 requests per day**.

| Mechanism | What it does |
|---|---|
| Global rate limiter | Counts every request per API key across all users and never sends more than 4/min or 500/day. |
| Result cache | Clean sites are re-checked after 30 days, infected or suspicious sites after 1 day (both configurable). Opening the dashboard reads from the cache and costs no API calls. |
| Daily budget split | By default 80% of the daily limit is reserved for the nightly scan and 20% for manual rescans. |
| Round-robin queue | The nightly scan continues where it stopped the night before, so even with hundreds of sites every site is still checked in turn. |
| One request at a time | Manual rescans go through a single queue, together with the dashboard's automatic first-time lookups. |

Every API call is a domain report lookup (`GET /domains/{domain}`), a re-analysis request (`POST /domains/{domain}/analyse`) or an analysis status check (`GET /analyses/{id}`). Only domain names are sent to VirusTotal, never site content or customer data.

---

## Requirements

- **Plesk Obsidian 18.0 or newer** on Linux, with root SSH access to the server
- Websites hosted in Plesk. Every active domain and subdomain with web hosting is checked, whatever it runs (WordPress, Joomla, plain HTML, …), plus WordPress sites on a hostname under a hosted domain. Hostnames that only appear in a leftover WordPress database and no longer exist in DNS are listed separately under **Orphan databases** (see below). Forwarding-only domains, domains without hosting and suspended domains are skipped. The list is read from Plesk's own database. To check WordPress sites only, choose **Settings → Sites to scan → WordPress sites only**.
- A **VirusTotal API key**. The free key is enough: create an account at [virustotal.com](https://www.virustotal.com), then open your profile menu → **API key**.
- Optional: a **Google API key** for Google Safe Browsing (free, non-commercial use; see [Google Safe Browsing](#google-safe-browsing-optional)).
- Optional: **ClamAV** (recommended) or **maldet** for the file scans, and **ImunifyAV / Imunify360** for its results. None of them is required. A file scan uses one engine: ClamAV when installed, otherwise maldet if you enable it in **Settings → Internal serverside file scanners**.

The extension runs on Plesk's own bundled PHP (8.x), so the PHP version of your websites doesn't matter.

---

## Installation

### Step 1: Install the extension

Log in to your Plesk server as root and run:

```bash
plesk bin extension --upgrade-url https://github.com/dzaal/StingyScan-for-Plesk/releases/latest/download/stingyscan.zip
```

That's all. Plesk downloads the latest release from GitHub and installs it. The same command updates an existing installation to the newest version.

**Without the command line:** download `stingyscan-<version>.zip` from the [latest release](https://github.com/dzaal/StingyScan-for-Plesk/releases/latest), then in Plesk go to **Extensions → My Extensions → Upload Extension** and select the zip. If you don't see the **Upload Extension** button, enable it once by adding these lines to `/usr/local/psa/admin/conf/panel.ini` on the server (create the file if it doesn't exist):

```ini
[ext-catalog]
extensionUpload = true
```

> Use the zip from the **Releases** page. GitHub's green **Code → Download ZIP** button gives you the *source*, which Plesk can't install.

Installing registers the nightly background scan automatically. You don't need to set up a cron job.

### Step 2: Check the requirements for file scans (optional)

The VirusTotal checks work right away. The **file scan** button in a site's details uses the scan engine already installed on the server (ClamAV, or Linux Malware Detect when ClamAV is missing), next to ImunifyAV / Imunify360's results; see [File scanners](#file-scanners-clamav-maldet-imunify). You can check what was found under **Settings → Internal serverside file scanners**.

### Step 3: Add your VirusTotal API key

1. In Plesk, open **Stingy Scanner** in the left navigation (under **Links to Additional Services**; in the Power User view and for customers in the main menu), or under **Extensions → My Extensions**. Until you add a key, the sites show **Needs API key** and nothing is looked up.
2. Go to the **Settings** tab. The VirusTotal API key is the first card.
3. Paste your API key and click **Save settings**.
4. Optional: choose **Sites to scan** (all hosted websites, or WordPress sites only), and adjust **Max calls / day** (500 for the free tier, higher if you have a premium key), the background/manual split with the slider, and how long results are cached. See [Settings](#settings).

### Step 4: Check that it works

1. Open the **Dashboard** tab. Your hosted websites appear within a few seconds. Sites without a cached result are looked up gradually (at most 10 per page load, 4 per minute); the nightly scan handles the rest.
2. Click **Rescan** on any site. The **Scan Monitor** shows the scan moving through its steps.
3. Optional: switch on the summary e-mail in **Settings → Notifications** and click **Send test e-mail**.
4. Check that the nightly scan is scheduled:
   ```bash
   crontab -l -u psaadm | grep stingyscan
   ```
   You should see a line ending in `stingyscan/scripts/background_scan.php` (the nightly scan) and one ending in `scripts/manual_scan.php` (every 5 minutes: rescans that were still queued when the page was closed).

To start a background scan straight away instead of waiting for 03:00:

```bash
sudo -u psaadm /usr/local/psa/admin/bin/php /usr/local/psa/admin/plib/modules/stingyscan/scripts/background_scan.php
```

> Always run it as `psaadm` with Plesk's PHP (`/usr/local/psa/admin/bin/php`). Running it as root leaves files the panel can't write to, and the operating system's own `php` is often too old for this code.

### Step 5 (recommended): Avoid two scanners sharing one quota

If Plesk's built-in **VirusTotal Website Check** is also active with the same API key, both draw from the same 500 requests per day, and the built-in one checks every hour. Turn it off in its own settings, or remove it:

```bash
plesk bin extension --uninstall website-virus-check
```

---

## Updating

When a newer version is out, a yellow banner appears at the top of the dashboard; the administrator can click **Install** to upgrade in one click. Or run the same command as for installing:

```bash
plesk bin extension --upgrade-url https://github.com/dzaal/StingyScan-for-Plesk/releases/latest/download/stingyscan.zip
```

Plesk keeps your settings, API key, scan results and history, and the nightly task is re-registered automatically. Each release on the [Releases page](https://github.com/dzaal/StingyScan-for-Plesk/releases) lists what changed in it and in all earlier versions; the full history is in [CHANGELOG.md](CHANGELOG.md). In the extension, **About → What's new** links to both.

### Coming from VT Site Scanner (1.x)

Until version 1.35 Stingy Scanner was called **VT Site Scanner** (repository [dzaal/VT-Scanner-for-Plesk](https://github.com/dzaal/VT-Scanner-for-Plesk)). An installed VT Site Scanner updates to Stingy Scanner **in place**: click **Install** on its update banner (1.31.2 and newer), or run as root:

```bash
plesk bin extension --upgrade-url https://github.com/dzaal/VT-Scanner-for-Plesk/releases/latest/download/virustotal-extension.zip
```

This is the same Stingy Scanner, packaged under the old extension id (`virustotal-extension`), so your settings, API keys, results and history stay where they are and the panel address stays `/modules/virustotal-extension/`. After that, updates come from this repository automatically.

New installations use the extension id `stingyscan` ([Installation](#installation)). If a server has both, Stingy Scanner copies the data of VT Site Scanner once and shows a reminder to remove the old one with `plesk bin extension --uninstall virustotal-extension`.

**Upgrading from 1.0.x?** Earlier versions asked you to add a line to root's crontab by hand. Remove that line (`crontab -e` as root, delete the line with `background_scan.php`); the extension now schedules itself.

## Uninstalling

```bash
plesk bin extension --uninstall stingyscan
```

This removes the extension and its scheduled task. To also delete all stored settings, results and logs (including the API key), remove the data directory:

```bash
rm -rf /usr/local/psa/var/modules/stingyscan
```

---

## Troubleshooting

| Problem | What to check |
|---|---|
| "No sites found" | Open the arrow menu next to **All** and click **Refresh site list** (the site list is cached for a day). Only active domains with web hosting are listed; forwarding-only and suspended domains are skipped. |
| "Invalid API key (401)" | Re-paste the key in **Settings**; make sure there are no spaces around it. |
| Many sites stay "Queued" | VirusTotal has never seen these domains; the first lookup submits them for a scan. They resolve on a later lookup or the next nightly run. |
| Rescans say "Daily manual rescan limit reached" | The manual share of today's budget is used up. It resets at midnight UTC, or raise the percentage in **Settings**. |
| Google Safe Browsing: key not saved, or a red cross | The message shows Google's answer. *API key not valid*: re-paste the key. *Access denied*: enable the Safe Browsing API for the key's project, and check that the key's IP restriction contains the server's outgoing IP address. *Quota*: see the Quotas page of the API in the Google Cloud Console. |
| The nightly scan doesn't seem to run | Run `crontab -l -u psaadm \| grep virustotal`, then run the scan by hand (step 4) to see its output. The **Log** tab shows every run. |

## E-mail sender

**Settings → E-mail sender** (administrator) sets the address and name of every e-mail Stingy Scanner sends: the Pwned? warnings to site administrators and the status notifications. Empty = the administrator's Plesk address. The address is also the envelope sender (Return-Path), so receiving mail servers check SPF, DKIM and DMARC against the same domain.

**Check SPF, DKIM and DMARC** looks it up live, from the server:

- **SPF:** does the domain's SPF record allow the server that actually hands the mail to the internet? That is the relay host when Postfix uses one (`relayhost`), otherwise this server's own addresses. Includes are followed.
- **DKIM:** does this server sign mail of that domain (Plesk: *Use DKIM spam protection system to sign outgoing email messages*), and does the published key `default._domainkey.<domain>` match the key on the server? This needs a domain with mail service on this server.
- **DMARC:** is there a `_dmarc.<domain>` record, and its policy. `p=none` only monitors; once SPF and DKIM pass for all mail of the domain, `p=quarantine` makes forged mail in your name land in spam.

**Send test** sends a short e-mail from the address; in the received message's source, *Authentication-Results* shows whether SPF, DKIM and DMARC passed.

## Data and privacy

All data stays on your server in `/usr/local/psa/var/modules/stingyscan/data/`: settings (including the API keys, readable only by the panel user), cached results, budget counters and logs (rotated, see [Settings](#settings)). Nothing is stored in this repository.

What leaves the server, and only for the services you switched on:

| Service | What is sent |
|---|---|
| VirusTotal | The domain names of the sites being checked. |
| Google Safe Browsing | The `https://` and `http://` address of each site. Google may use them to improve its services. |
| AVG / Avast | The address of the site whose details are opened or that is rescanned. |
| XposedOrNot or Have I Been Pwned (Pwned?) | The e-mail addresses of WordPress administrators and the addresses added in the Pwned Admins tab, each once. Off when **Settings → Breach data** is set to Off. |
| GitHub | The update check asks GitHub for the latest release number. |

No site content or files are sent anywhere.

---

## Development

### Releases

Every new version gets a ready-made zip on the [Releases page](https://github.com/dzaal/StingyScan-for-Plesk/releases). This happens automatically: when the `<version>` in `META_INF/meta.xml` changes on `main`, the GitHub Action in `.github/workflows/release.yml` builds the package with `build.sh` and publishes release `v<version>` with three copies of it: `stingyscan-<version>.zip`, `stingyscan.zip` (a fixed name, so the `releases/latest/download/...` link always gives the newest version) and `virustotal-extension.zip` (the same Stingy Scanner built with the old extension id by `bash build.sh legacy`, so installations of VT Site Scanner 1.x update to it in place).

The release notes come from `CHANGELOG.md` (`.github/release-notes.sh`): add a `## <version> — <date>` section there with each version bump. Changing `CHANGELOG.md` also refreshes the notes of all existing releases.

### Building it yourself

On any machine with `bash` and either `zip` or Python:

```bash
git clone https://github.com/dzaal/StingyScan-for-Plesk.git
cd StingyScan-for-Plesk
bash build.sh
```

This creates `dist/stingyscan-<version>.zip`. Install it on the server with `plesk bin extension --install <file>`.


```
META_INF/meta.xml            Extension metadata (id, name, version)
htdocs/index.php             Entry point (Plesk MVC bootstrap)
plib/controllers/            IndexController: page + JSON actions
plib/views/scripts/index/    Dashboard UI (vanilla JS + CSS, no build step)
plib/library/                VirusTotal client, Google Safe Browsing, AVG / Avast, rate limiters,
                             cache, settings, domain discovery, queue, history, log rotation
plib/library/Hook/           Home page card (HomeBlock)
plib/scripts/                Nightly scan, 5-minute rescan queue, install/uninstall hooks
sbin/                        Root helpers: file scans (site-scan), one-click updates (extension-update)
plib/hooks/Home.php          Registers the Home page card (Plesk SDK hook, returns an anonymous class)
_meta/icons/                 Extension icons shown in Plesk's Extensions list
docs/                        Logo and screenshots used in this README
build.sh                     Builds dist/stingyscan-<version>.zip
.github/workflows/release.yml  Publishes the zip as a GitHub Release for every new version
deploy.sh                    Build + install on a server over SSH
LICENSE                      License (included in every package)
```

Build and install in one step:

```bash
VT_DEPLOY_HOST=root@your-plesk-server bash deploy.sh
```

Notes:
- Plesk routes `?action=save-settings` to `saveSettingsAction()` (dashes become camelCase).
- For JSON responses, disable the layout with `$this->_helper->layout->disableLayout()` and set the response body. Never use `header()` or `exit` inside `pm_Application`.

## Stack

- PHP 8 (Plesk's bundled sw-engine), Zend Framework 1 (Plesk's built-in MVC)
- VirusTotal API v3, Google Safe Browsing Lookup API v4
- Vanilla JavaScript and CSS, no dependencies

## Trademarks

Stingy Scanner is an independent product of Digizaal. It is **not affiliated with, endorsed, sponsored or approved by** any of the companies below. Their names and logos are used only to identify the services and software the extension works with (nominative use); the logos are their favicons, shown next to the settings and results of that service.

- **Stingy Scanner** and **Digizaal** are names of Dirk Zaal (Digizaal).
- **VirusTotal** is a trademark of Google LLC.
- **Google**, **Google Safe Browsing**, **Google Cloud**, **Google Search Console** and **Chrome** are trademarks of Google LLC.
- **AVG** and **Avast** are trademarks of Gen Digital Inc. or its affiliates.
- **Plesk** is a trademark of WebPros International GmbH.
- **WordPress** is a trademark of the WordPress Foundation. **Joomla** is a trademark of Open Source Matters, Inc.
- **ClamAV** is a trademark of Cisco Systems, Inc. **Imunify360** and **ImunifyAV** are trademarks of CloudLinux Software, Inc. **Linux Malware Detect** (maldet) is a product of R-fx Networks. **Linux** is a registered trademark of Linus Torvalds.
- **Firefox** is a trademark of the Mozilla Foundation. **Safari** is a trademark of Apple Inc.
- **GitHub** is a trademark of GitHub, Inc. **PayPal** is a trademark of PayPal, Inc.
- The security vendors named in [Cleaned, but still red?](#cleaned-but-still-red) (Fortinet, Sophos, Bitdefender, G DATA and others) and all other product and company names mentioned are trademarks or registered trademarks of their respective holders.

Use of these services is subject to their own terms, which you accept with your own account or API key.

## License

Copyright © 2026 Dirk Zaal, trading as Digizaal. All rights reserved.

Stingy Scanner, its code, design and the way it works, is the intellectual property of Dirk Zaal. The source code is public so you can read it; it is **not** open source.

- **You may:** install and use Stingy Scanner, exactly as published, on servers you manage, also for your business and for sites you host for others. Free of charge.
- **You may not, without written permission:** change the code (also not privately), copy parts into other software, or distribute it.

Want to do one of these? Just ask, via [digizaal.nl](https://www.digizaal.nl). Full terms, in plain language: [LICENSE](LICENSE).

## Author

**Dirk Zaal**, [Digizaal](https://www.digizaal.nl), Amsterdam

Stingy Scanner is free. If it saves you time or catches a hacked site, you can [buy me a cup of coffee ($3)](https://www.paypal.com/paypalme/zirk020/3USD) ☕
