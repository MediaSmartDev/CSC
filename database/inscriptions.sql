-- Table des inscriptions (formulaire inscription.php)
-- Import : phpMyAdmin > csc_db > Importer > ce fichier
USE `csc_db`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `service` VARCHAR(50) NOT NULL,
  `nom` VARCHAR(120) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telephone` VARCHAR(30) NOT NULL,
  `description` TEXT NOT NULL,
  `email_envoye` TINYINT NOT NULL DEFAULT 0,
  `statut` VARCHAR(20) NOT NULL DEFAULT 'nouveau',
  `ip` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
