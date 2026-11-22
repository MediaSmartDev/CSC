-- =====================================================================
-- ESPACE ADMIN (étape 3) : classement Ligue 1 dans la base
-- Date : 2026-11-18
-- Crée 2 tables et y copie le classement actuel de Data/classement.php
-- (J9, saison 2026/2027). Ré-importable : n'écrase pas un classement
-- déjà modifié dans l'admin.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `classement_l1` (
  `code` VARCHAR(10) NOT NULL,
  `pos` INT NOT NULL,
  `j` INT NOT NULL DEFAULT 0,
  `g` INT NOT NULL DEFAULT 0,
  `n` INT NOT NULL DEFAULT 0,
  `p` INT NOT NULL DEFAULT 0,
  `bp` INT NOT NULL DEFAULT 0,
  `bc` INT NOT NULL DEFAULT 0,
  `points` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`code`),
  KEY `idx_pos` (`pos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `classement_l1_info` (
  `id` TINYINT NOT NULL,
  `saison` VARCHAR(20) NOT NULL,
  `journee` INT NOT NULL DEFAULT 0,
  `mise_a_jour` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `classement_l1_info` (`id`, `saison`, `journee`, `mise_a_jour`) VALUES (1, '2026/2027', 9, '2026-11-18 10:00:00');

INSERT IGNORE INTO `classement_l1` (`code`, `pos`, `j`, `g`, `n`, `p`, `bp`, `bc`, `points`) VALUES
('CRB', 1, 8, 6, 2, 0, 13, 7, 20),
('JSK', 2, 8, 5, 2, 1, 11, 3, 17),
('MCA', 3, 7, 5, 1, 1, 9, 2, 16),
('MBR', 4, 9, 4, 3, 2, 9, 6, 15),
('MCO', 5, 8, 4, 3, 1, 5, 2, 15),
('USMA', 6, 7, 4, 2, 1, 10, 5, 14),
('OA', 7, 8, 3, 3, 2, 9, 6, 12),
('JSEB', 8, 9, 3, 2, 4, 13, 12, 11),
('CRT', 9, 9, 2, 4, 3, 7, 10, 10),
('ESS', 10, 8, 2, 3, 3, 10, 8, 9),
('ESBA', 11, 8, 1, 5, 2, 8, 9, 8),
('USMK', 12, 9, 1, 4, 4, 5, 10, 7),
('JSS', 13, 9, 1, 4, 4, 2, 8, 7),
('CSC', 14, 9, 2, 1, 6, 11, 18, 7),
('ASO', 15, 9, 0, 5, 4, 7, 13, 5),
('USB', 16, 9, 0, 4, 5, 4, 14, 4);
