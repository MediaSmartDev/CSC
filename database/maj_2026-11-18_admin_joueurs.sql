-- =====================================================================
-- ESPACE ADMIN (étape 2) : gestion des joueurs
-- Date : 2026-11-18
-- La table `joueurs` existe déjà : ce fichier vérifie seulement qu'elle a
-- toutes les colonnes utilisées par l'admin. Sans danger si déjà à jour.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;
ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `nom_ar` VARCHAR(150) DEFAULT NULL AFTER `prenom`;
ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `date_naissance` DATE DEFAULT NULL;
ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `age` INT DEFAULT NULL;
ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `ordre` INT NOT NULL DEFAULT 0;
