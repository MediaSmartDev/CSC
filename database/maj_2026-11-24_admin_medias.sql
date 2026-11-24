-- =====================================================================
-- ESPACE ADMIN : vidéos de l'accueil et bande publicitaire
-- Date : 2026-11-24
-- - `reglages` : réglages du site (vidéo d'accueil, publicité), en JSON
-- - `videos`   : vidéos YouTube affichées dans le bloc « Vidéos » de l'accueil
-- Tables vides : le site garde la bannière actuelle et la pub de
-- Data/pub.php tant que rien n'est enregistré dans l'admin.
-- Ré-importable sans danger.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `reglages` (
  `cle` VARCHAR(40) NOT NULL,
  `valeur` MEDIUMTEXT NOT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `videos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `youtube_id` VARCHAR(20) NOT NULL,
  `titre_fr` VARCHAR(200) NOT NULL,
  `titre_ar` VARCHAR(200) NULL,
  `ordre` INT NOT NULL DEFAULT 0,
  `publie` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ordre` (`publie`, `ordre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
