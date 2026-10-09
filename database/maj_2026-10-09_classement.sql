-- Classement apres la 4e journee (CSC 4-0 USB) - source lfp.dz/ar/ranking du 09/10/2026
-- (KS-ASO et MCA-CRT de la J4 pas encore joues)
-- phpMyAdmin : cliquer d'abord sur la base (csc_db en local / csconstantine_csc sur le serveur) > Importer > ce fichier
ALTER TABLE `classement` ADD COLUMN IF NOT EXISTS `club_ar` VARCHAR(60) DEFAULT NULL AFTER `club`;
DELETE FROM `classement`;
INSERT INTO `classement` (`pos`,`club`,`club_ar`,`logo`,`j`,`g`,`n`,`p`,`bp`,`bc`,`db`,`points`) VALUES
(1,'CRB','ش.بلوزداد','ressources/logo/logo_crb_t2.png',4,3,1,0,6,3,3,10),
(2,'CSC','ش.قسنطينة','ressources/logo/logo_min_csc.png',4,2,1,1,9,6,3,7),
(3,'MCO','م.وهران','ressources/logo/logo_mco_t2.png',3,2,1,0,3,0,3,7),
(4,'USMA','إ.الجزائر','ressources/logo/logo_usma_t2.png',4,2,1,1,5,3,2,7),
(5,'ESBA','ن.بن عكنون','ressources/logo/logo_esba_t2.png',4,1,3,0,6,5,1,6),
(6,'MBR','م.الرويسات','https://lfp.dz/clubs-logos/409-1755174810.png',4,2,0,2,3,3,0,6),
(7,'OA','أ.أقبو','ressources/logo/logo_oakbou_t2.png',4,1,1,2,4,5,-1,4),
(8,'ESS','و.سطيف','ressources/logo/logo_ess_t2.png',4,1,1,2,5,3,2,4),
(9,'JSEB','ش.الأبيار','ressources/logo/logo_jseb_t2.png',4,1,1,2,6,6,0,4),
(10,'CRT','ش.تموشنت','https://lfp.dz/clubs-logos/754-1663163636.png',3,1,1,1,2,3,-1,4),
(11,'MCA','م.الجزائر','ressources/logo/logo_mca_t2.png',1,1,0,0,2,0,2,3),
(12,'JSK','ش.القبائل','ressources/logo/logo_jsk_t2.png',2,1,0,1,1,1,0,3),
(13,'JSS','ش.الساورة','ressources/logo/logo_jss_t2.png',3,0,2,1,0,4,-4,2),
(14,'USB','إ.بسكرة','ressources/logo/logo_usb_t2.png',4,0,2,2,2,7,-5,2),
(15,'USMK','إ.خنشلة','ressources/logo/logo_usmk_t2.png',3,0,2,1,1,2,-1,2),
(16,'ASO','ج.الشلف','ressources/logo/logo_asoc_t2.png',3,0,1,2,3,7,-4,1);
UPDATE `classement_info` SET `saison`='2026/2027', `journee`=4, `mise_a_jour`='2026-10-09 12:00:00';
