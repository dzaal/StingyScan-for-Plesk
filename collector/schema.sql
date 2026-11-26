-- Installation statistics collector (stats.digizaal.nl) — MariaDB 10.3+ / MySQL 8
-- No IP addresses are stored anywhere in this database.

-- One row per installation of a project: its latest check-in only
CREATE TABLE IF NOT EXISTS installations (
    project          VARCHAR(32)  NOT NULL,              -- e.g. 'stingyscan'
    installation_id  CHAR(32)     NOT NULL,              -- random hex ID made by the installation
    hostname         VARCHAR(253) NULL,                  -- self-reported server host name (server software only)
    version          VARCHAR(32)  NOT NULL,              -- self-reported version
    data             TEXT         NOT NULL,              -- the project's own fields as JSON, e.g. {"hosted_sites":128}
    first_seen       DATETIME     NOT NULL,              -- UTC, collector's clock
    last_seen        DATETIME     NOT NULL,              -- UTC, collector's clock
    checkins         INT UNSIGNED NOT NULL DEFAULT 1,    -- number of accepted check-ins
    PRIMARY KEY (project, installation_id),
    KEY project_last_seen (project, last_seen)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Daily figures per project for the trend chart (written by bin/daily.php; totals only, no installations)
CREATE TABLE IF NOT EXISTS daily (
    project  VARCHAR(32)  NOT NULL,
    day      DATE         NOT NULL,
    active   INT UNSIGNED NOT NULL,
    data     TEXT         NOT NULL,                      -- {"sums":{...},"versions":{...},"new":n}
    PRIMARY KEY (project, day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
