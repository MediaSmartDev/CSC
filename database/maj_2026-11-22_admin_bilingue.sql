-- =====================================================================
-- ESPACE ADMIN : poste des joueurs / du staff en arabe
-- Date : 2026-11-22
-- Ajoute la colonne `poste_ar` (facultative : vide = traduction
-- automatique du poste). Ré-importable sans danger.
-- phpMyAdmin : choisir la base du site > Importer > ce fichier > Exécuter
-- =====================================================================
SET NAMES utf8mb4;

ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `poste_ar` VARCHAR(80) NULL DEFAULT NULL AFTER `poste`;
