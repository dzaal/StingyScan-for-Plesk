Stingy Reputation Scanner keeps an eye on the reputation of every website on your Plesk server, and helps a site win its good name back after an attack.

**Reputation checks for every site**

- Checks every hosted site (and external sites you add) with **VirusTotal**, and optionally **Google Safe Browsing** and **AVG / Avast**, for malware, phishing and spam.
- Spreads the checks over the day so your free VirusTotal API quota is never used up.
- Shows which vendors flag a site, why, and how to **ask each of them for a review**, with the full history of the site.

**When a site is flagged**

- Scan its files with **ClamAV, Maldet or Imunify**, and clean or quarantine infected files.
- Find **rogue admin accounts**: every hour it compares who has admin rights on each WordPress site (and Joomla, Drupal, Nextcloud, WHMCS, Laravel) and reports new admins, promoted accounts and changed e-mail addresses, with the access-log requests that explain them.
- **Pwned Admins**: see which administrator e-mail addresses appear in known data breaches (XposedOrNot or Have I Been Pwned), warn the administrator or reset the password in an emergency.

**For hosting companies**

- Customers and resellers see their own sites; the administrator sees everything.
- E-mail notifications, a dashboard widget, statistics and orphan-database cleanup.

**Requirements:** Plesk Obsidian 18.0 or later on **Linux** (Plesk for Windows is not supported). A free VirusTotal API key.

Free to use on any server you manage; the source code is public (see the license). Nothing is sent to Digizaal unless you switch on the optional installation statistics. Built by [Digizaal](https://www.digizaal.nl/stingy-scanner/), an Amsterdam web agency hosting 600+ websites on Plesk.
