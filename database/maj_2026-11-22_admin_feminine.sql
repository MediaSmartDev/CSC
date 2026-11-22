-- =====================================================================
-- Espace admin : ÉQUIPE FÉMININE (page equipe-feminine.php)
-- À importer dans phpMyAdmin (onglet Importer). Peut être importé
-- plusieurs fois sans risque (rien n'est écrasé ni dupliqué).
-- Groupes : 1 = Gardiennes, 2 = Joueuses, 3 = Staff technique
-- =====================================================================
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `equipe_feminine` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupe` TINYINT UNSIGNED NOT NULL DEFAULT 2,
  `nom` VARCHAR(150) NOT NULL DEFAULT '',
  `nom_ar` VARCHAR(150) NULL,
  `num` TINYINT UNSIGNED NULL,
  `role_fr` VARCHAR(80) NOT NULL DEFAULT '',
  `role_ar` VARCHAR(80) NULL,
  `img` VARCHAR(255) NULL,
  `ordre` INT NOT NULL DEFAULT 0,
  `publie` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `groupe_ordre` (`groupe`, `ordre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Effectif actuel (photos déjà sur le site, noms à compléter dans l'admin)
INSERT IGNORE INTO `equipe_feminine` (`id`, `groupe`, `nom`, `nom_ar`, `num`, `role_fr`, `role_ar`, `img`, `ordre`, `publie`) VALUES
(1, 1, '', NULL, NULL, '', NULL, 'images/feminine/gardienne-01.jpg', 1, 1),
(2, 1, '', NULL, NULL, '', NULL, 'images/feminine/gardienne-02.jpg', 2, 1),
(3, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-01.jpg', 1, 1),
(4, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-02.jpg', 2, 1),
(5, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-03.jpg', 3, 1),
(6, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-04.jpg', 4, 1),
(7, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-05.jpg', 5, 1),
(8, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-06.jpg', 6, 1),
(9, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-07.jpg', 7, 1),
(10, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-08.jpg', 8, 1),
(11, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-09.jpg', 9, 1),
(12, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-10.jpg', 10, 1),
(13, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-11.jpg', 11, 1),
(14, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-12.jpg', 12, 1),
(15, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-13.jpg', 13, 1),
(16, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-14.jpg', 14, 1),
(17, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-15.jpg', 15, 1),
(18, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-16.jpg', 16, 1),
(19, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-17.jpg', 17, 1),
(20, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-18.jpg', 18, 1),
(21, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-19.jpg', 19, 1),
(22, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-20.jpg', 20, 1),
(23, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-21.jpg', 21, 1),
(24, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-22.jpg', 22, 1),
(25, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-23.jpg', 23, 1),
(26, 2, '', NULL, NULL, '', NULL, 'images/feminine/joueuse-24.jpg', 24, 1),
(27, 3, '', NULL, NULL, '', NULL, 'images/feminine/staff-01.jpg', 1, 1),
(28, 3, '', NULL, NULL, '', NULL, 'images/feminine/staff-02.jpg', 2, 1);
