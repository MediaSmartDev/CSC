-- =====================================================================
-- ESPACE ADMIN : catégories jeunes (page jeunes.php)
-- Date : 2026-11-22
-- Crée la table (vide : chaque catégorie garde « Effectif bientôt
-- disponible » tant que l'admin n'y ajoute personne).
-- Ré-importable sans danger.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `jeunes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `categorie` VARCHAR(4) NOT NULL,           -- U21, U19, U17, U15, U13
  `type` TINYINT UNSIGNED NOT NULL DEFAULT 1, -- 1 = joueur, 2 = staff
  `nom` VARCHAR(150) NOT NULL,
  `nom_ar` VARCHAR(150) NULL,
  `num` TINYINT UNSIGNED NULL,
  `poste` VARCHAR(60) NOT NULL DEFAULT '',
  `poste_ar` VARCHAR(80) NULL,
  `img` VARCHAR(255) NULL,
  `ordre` INT NOT NULL DEFAULT 0,
  `publie` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cat_ordre` (`categorie`, `type`, `ordre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
