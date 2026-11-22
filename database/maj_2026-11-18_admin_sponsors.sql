-- =====================================================================
-- ESPACE ADMIN (étape 4) : sponsors du bandeau de l'accueil
-- Date : 2026-11-18
-- Crée la table et y met les 5 logos actuels (ENTP, Hayat, Macron,
-- Ooredoo, Soummam). Ré-importable sans danger : rien n'est écrasé.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `sponsors` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `logo` VARCHAR(255) NOT NULL,
  `lien` VARCHAR(500) NOT NULL DEFAULT '',
  `position` INT NOT NULL DEFAULT 0,
  `publie` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_publie_position` (`publie`, `position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `sponsors` (`id`, `nom`, `logo`, `lien`, `position`, `publie`) VALUES
(1, 'ENTP',    'images/sponsors/entp.jpeg',    '', 1, 1),
(2, 'Hayat',   'images/sponsors/hayat.jpeg',   '', 2, 1),
(3, 'Macron',  'images/sponsors/macron.png',   '', 3, 1),
(4, 'Ooredoo', 'images/sponsors/ooredoo.jpeg', '', 4, 1),
(5, 'Soummam', 'images/sponsors/soumam.jpeg',  '', 5, 1);
