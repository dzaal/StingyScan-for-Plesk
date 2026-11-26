# Privacy policy: Stingy Scanner for Plesk

*Last updated: 26 November 2026. Online version: <https://www.digizaal.nl/stingy-scanner/privacy/>*

Stingy Scanner is a free Plesk extension made by Dirk Zaal of **Digizaal** (Digizaal webdev VOF), Stuurmankade 224, 1019 WC Amsterdam, the Netherlands (Chamber of Commerce 30153598), <info@digizaal.nl>. This page explains which data the extension handles, where it goes and who is responsible for it.

## In short

- The extension runs **on your own server**. Its settings, results and logs stay there.
- It only contacts the outside services **you switch on**, and only sends them what they need for the check.
- **Nothing is sent to Digizaal unless you switch it on.** Installation statistics ("Talk to mama") are **off by default**.
- Digizaal never receives your sites' files, your customers' data, your API keys or your scan results.

## Who is responsible

For the data on your server and what the extension sends to the services you switch on, **you** (the server administrator or hosting company that installs the extension) decide what is processed and why. Digizaal does not see that data and does not process it on your behalf.

Digizaal is only responsible for the installation statistics described below, and only when you switch them on.

## Data that stays on your server

Everything the extension keeps is stored in `/usr/local/psa/var/modules/stingyscan/data/` on your server: settings (including API keys, readable only by the Plesk panel user), cached scan results, budget counters, the history of each site, the administrator accounts it found (login, e-mail address, role) and logs. Logs are rotated according to *Settings → Log rotation*. Uninstalling the extension deletes this folder.

## Data sent to outside services

Each service is only contacted when it is switched on in Settings (VirusTotal needs your own API key). Each service handles the data under its own privacy policy.

| Service | What is sent | When |
|---|---|---|
| [VirusTotal](https://www.virustotal.com) (Google) | The domain names of the sites being checked. | Always, with your API key. |
| [Google Safe Browsing](https://safebrowsing.google.com) | The `https://` and `http://` address of each site. Google may use them to improve its services. | Only when switched on. |
| AVG / Avast Web Shield | The address of a site whose details are opened or that is rescanned. | Only when switched on. |
| [XposedOrNot](https://xposedornot.com) or [Have I Been Pwned](https://haveibeenpwned.com) | The e-mail addresses of website administrators (WordPress, Joomla, Drupal and others) and addresses you added in the Pwned Admins tab, each once. | Only when *Breached admin accounts* is not Off. |
| GitHub | A request for the latest release number (no data about your server). | Update check. |
| Digizaal (stats.digizaal.nl) | See *Installation statistics* below. | **Only when you switch it on.** |

E-mail notifications and the Pwned warning e-mails are sent by your own server's mail system to the addresses you choose.

The administrator e-mail addresses sent to a breach service are personal data of those administrators. If you switch the breach check on, make sure you have a basis for it under the GDPR (usually the legitimate interest of keeping the websites you host secure) and tell your customers in your own privacy statement.

## Installation statistics ("Talk to mama")

**Off by default.** Nothing is sent until the server administrator ticks *Settings → Maintenance → Talk to mama: Share installation statistics* and saves.

**What is sent when it is on**, once a week over HTTPS to `https://stats.digizaal.nl/check-in`, and nothing else:

| Field | Content |
|---|---|
| `installation_id` | A random ID made by the extension, not linked to anything else. |
| `hostname` | The server host name configured in Plesk. |
| `version` | The Stingy Scanner version. |
| `hosted_sites` | The number of hosted websites (a number, no names). |

**Why:** to count active installations and to know which versions and server sizes are in use, so Digizaal knows what to support and test. The legal basis is your consent (opt-in), which you can withdraw at any time by unticking the setting.

**Storage:** in a database on Digizaal's own server in the Netherlands. The statistics database stores **no IP addresses**. The web server's access log records the connecting IP address of each request, as for any website; it is rotated monthly and the previous month's file is then deleted. It is only used for security and is not linked to the statistics.

**Retention:** an installation that stops checking in is no longer counted after 30 days and is deleted after 90 days.

**Sharing:** the statistics are not sold or shared with anyone. Digizaal may publish totals (for example the number of active installations), never data of a single server.

**Your rights:** you can ask Digizaal to see or delete the data of your installation; send your server's host name to <info@digizaal.nl>. You can also file a complaint with the Dutch Data Protection Authority (Autoriteit Persoonsgegevens).

## The Digizaal website

When you visit www.digizaal.nl, the general [Digizaal privacy policy](https://www.digizaal.nl/privacy-policy/) applies.

## Changes

Changes to this policy are listed in the extension's [changelog](CHANGELOG.md) and on the page above.

## Contact

Digizaal webdev VOF, Stuurmankade 224, 1019 WC Amsterdam, the Netherlands. <info@digizaal.nl>
