-- =====================================================================
-- ESPACE ADMIN (étape 5) : matchs et scores du CSC
-- Date : 2026-11-18
-- Crée la table et y copie le calendrier actuel de Data/matchs.php
-- (30 matchs, scores compris). Ré-importable sans danger :
-- les matchs déjà présents ne sont pas écrasés.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `matchs_csc` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `j` INT NOT NULL,
  `dom` VARCHAR(10) NOT NULL,
  `ext` VARCHAR(10) NOT NULL,
  `date_match` DATE NULL DEFAULT NULL,
  `heure` TIME NULL DEFAULT NULL,
  `bd` TINYINT UNSIGNED NULL DEFAULT NULL,
  `be` TINYINT UNSIGNED NULL DEFAULT NULL,
  `stade_fr` VARCHAR(150) NOT NULL DEFAULT '',
  `stade_ar` VARCHAR(150) NOT NULL DEFAULT '',
  `slogan_fr` VARCHAR(300) NOT NULL DEFAULT '',
  `slogan_ar` VARCHAR(300) NOT NULL DEFAULT '',
  `actu` INT UNSIGNED NULL DEFAULT NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_j` (`j`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `matchs_csc` (`id`, `j`, `dom`, `ext`, `date_match`, `heure`, `bd`, `be`, `stade_fr`, `stade_ar`, `slogan_fr`, `slogan_ar`, `actu`) VALUES
(1, 1, 'CRT', 'CSC', '2026-09-05', '19:00', 1, 1, '', '', '', '', NULL),
(2, 2, 'CSC', 'ASO', '2026-09-12', '21:00', 3, 0, '', '', '', '', NULL),
(3, 3, 'ESS', 'CSC', '2026-09-19', '19:00', 5, 1, '', '', '', '', NULL),
(4, 4, 'CSC', 'USB', '2026-10-07', '18:00', 4, 0, '', '', '', '', NULL),
(5, 5, 'USMK', 'CSC', '2026-10-12', '15:00', NULL, NULL, 'Stade Amar Hamam, Khenchela', 'ملعب عمار حمام، خنشلة', '', '', NULL),
(6, 6, 'CSC', 'JSEB', '2026-10-17', '17:00', NULL, NULL, '', '', '', '', NULL),
(7, 7, 'OA', 'CSC', '2026-10-23', '15:15', NULL, NULL, 'Stade des Chouhada, Akbou (Béjaïa)', 'ملعب الشهداء، أقبو - بجاية', '', '', NULL),
(8, 8, 'CSC', 'USMA', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(9, 9, 'JSS', 'CSC', NULL, NULL, 1, 0, '', '', '', '', NULL),
(10, 10, 'CSC', 'ESBA', '2026-11-18', '17:45', NULL, NULL, '', '', 'Dans le silence du tunnel, la concentration naît avant la tempête.', 'في صمت النفق.. يولد التركيز قبل العاصفة.', 25),
(11, 11, 'CRB', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(12, 12, 'MBR', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(13, 13, 'CSC', 'MCO', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(14, 14, 'JSK', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(15, 15, 'CSC', 'MCA', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(16, 16, 'CSC', 'CRT', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(17, 17, 'ASO', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(18, 18, 'CSC', 'ESS', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(19, 19, 'USB', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(20, 20, 'CSC', 'USMK', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(21, 21, 'JSEB', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(22, 22, 'CSC', 'OA', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(23, 23, 'USMA', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(24, 24, 'CSC', 'JSS', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(25, 25, 'ESBA', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(26, 26, 'CSC', 'CRB', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(27, 27, 'CSC', 'MBR', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(28, 28, 'MCO', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(29, 29, 'CSC', 'JSK', NULL, NULL, NULL, NULL, '', '', '', '', NULL),
(30, 30, 'MCA', 'CSC', NULL, NULL, NULL, NULL, '', '', '', '', NULL);
