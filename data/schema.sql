-- Nario Labs CMS schema (MySQL 5.7+ / MariaDB 10.3+)

CREATE TABLE IF NOT EXISTS admins (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(60)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    last_login    DATETIME NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- One table for everything the site showcases: partners, clients, products and games.
CREATE TABLE IF NOT EXISTS items (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type        ENUM('partner','client','product','game') NOT NULL,
    name        VARCHAR(150) NOT NULL,
    url         VARCHAR(255) NOT NULL DEFAULT '',
    logo        VARCHAR(255) NOT NULL DEFAULT '',
    preview     VARCHAR(255) NOT NULL DEFAULT '',
    tagline     VARCHAR(255) NOT NULL DEFAULT '',
    description TEXT NULL,
    status      VARCHAR(40)  NOT NULL DEFAULT '',
    category    VARCHAR(80)  NOT NULL DEFAULT '',
    size        ENUM('sm','wide','tall','lg') NOT NULL DEFAULT 'sm',
    accent      VARCHAR(7)   NOT NULL DEFAULT '',
    embed       TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order  INT NOT NULL DEFAULT 0,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_type (type, is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS messages (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120) NOT NULL,
    email      VARCHAR(160) NOT NULL,
    phone      VARCHAR(40)  NOT NULL DEFAULT '',
    company    VARCHAR(160) NOT NULL DEFAULT '',
    interest   VARCHAR(60)  NOT NULL DEFAULT '',
    budget     VARCHAR(60)  NOT NULL DEFAULT '',
    message    TEXT NOT NULL,
    ip         VARCHAR(45)  NOT NULL DEFAULT '',
    is_read    TINYINT(1)   NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
    skey   VARCHAR(60) PRIMARY KEY,
    svalue TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
