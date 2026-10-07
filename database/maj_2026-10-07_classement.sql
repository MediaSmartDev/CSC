-- Classement avant CSC-USB (4e journée, 07/10/2026 18h) - source lfp.dz, autres matchs de la J4 inclus
-- phpMyAdmin : cliquer sur la base (csc_db en local / csconstantine_csc sur le serveur) > Importer > ce fichier
-- colonnes des noms arabes (sans effet si elles existent déjà)
ALTER TABLE `classement` ADD COLUMN IF NOT EXISTS `club_ar` VARCHAR(60) DEFAULT NULL AFTER `club`;
ALTER TABLE `joueurs` ADD COLUMN IF NOT EXISTS `nom_ar` VARCHAR(150) DEFAULT NULL AFTER `prenom`;
DELETE FROM `classement`;
INSERT INTO `classement` (`pos`,`club`,`club_ar`,`logo`,`j`,`g`,`n`,`p`,`bp`,`bc`,`db`,`points`) VALUES
(1,'CRB','ش.بلوزداد','ressources/logo/logo_crb_t2.png',4,2,2,0,5,3,2,8),
(2,'USMA','إ.الجزائر','ressources/logo/logo_usma_t2.png',3,2,1,0,5,2,3,7),
(3,'MCO','م.وهران','ressources/logo/logo_mco_t2.png',2,2,0,0,3,0,3,6),
(4,'ESBA','ن.بن عكنون','ressources/logo/logo_esba_t2.png',4,1,3,0,4,3,1,6),
(5,'JSEB','ش.الأبيار','ressources/logo/logo_jseb_t2.png',4,1,1,2,4,4,0,4),
(6,'CSC','ش.قسنطينة','ressources/logo/logo_min_csc.png',3,1,1,1,5,6,-1,4),
(7,'CRT','ش.تموشنت','https://lfp.dz/clubs-logos/754-1663163636.png',3,1,1,1,2,3,-1,4),
(8,'MCA','م.الجزائر','ressources/logo/logo_mca_t2.png',1,1,0,0,2,0,2,3),
(9,'JSK','ش.القبائل','ressources/logo/logo_jsk_t2.png',2,1,0,1,1,1,0,3),
(10,'MBR','م.الرويسات','https://lfp.dz/clubs-logos/409-1755174810.png',3,1,0,2,2,3,-1,3),
(11,'ESS','و.سطيف','ressources/logo/logo_ess_t2.png',3,1,0,2,5,3,2,3),
(12,'USMK','إ.خنشلة','ressources/logo/logo_usmk_t2.png',3,0,3,0,1,1,0,3),
(13,'OA','أ.أقبو','ressources/logo/logo_oakbou_t2.png',3,1,0,2,4,5,-1,3),
(14,'USB','إ.بسكرة','ressources/logo/logo_usb_t2.png',3,0,2,1,2,3,-1,2),
(15,'ASO','ج.الشلف','ressources/logo/logo_asoc_t2.png',3,0,1,2,3,7,-4,1),
(16,'JSS','ش.الساورة','ressources/logo/logo_jss_t2.png',2,0,1,1,0,4,-4,1);
UPDATE `classement_info` SET `saison`='2026/2027', `journee`=4, `mise_a_jour`='2026-10-07 21:00:00';
