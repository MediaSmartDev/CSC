-- =====================================================================
-- VERSION SERVEUR (cPanel) - tout le site en un seul fichier
-- 1) cPanel > Bases de données MySQL : créer la base + l'utilisateur
-- 2) phpMyAdmin : cliquer sur VOTRE base à gauche, puis Importer ce fichier
-- (ce fichier ne crée pas la base : cPanel l'interdit depuis phpMyAdmin)
-- =====================================================================
-- =====================================================================
-- CSC Constantine - base de données du site (reconstruction 2026-10-05)
-- Données : Ligue de Football Professionnel (lfp.dz) - saison 2026/2027
--   * classement : https://lfp.dz/en/ranking  (après la 3e journée)
--   * effectif   : https://lfp.dz/en/club/678
-- Import : phpMyAdmin > Importer > ce fichier   (ou: mysql -u root < csc_db.sql)
-- =====================================================================
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `classement`;
CREATE TABLE `classement` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pos` INT NOT NULL,
  `club` VARCHAR(60) NOT NULL,
  `club_ar` VARCHAR(60) DEFAULT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `j` INT NOT NULL DEFAULT 0,
  `g` INT NOT NULL DEFAULT 0,
  `n` INT NOT NULL DEFAULT 0,
  `p` INT NOT NULL DEFAULT 0,
  `bp` INT NOT NULL DEFAULT 0,
  `bc` INT NOT NULL DEFAULT 0,
  `db` INT NOT NULL DEFAULT 0,
  `points` INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `classement` (`pos`,`club`,`logo`,`j`,`g`,`n`,`p`,`bp`,`bc`,`db`,`points`) VALUES
(1,'USMA','ressources/logo/logo_usma_t2.png',3,2,1,0,5,2,3,7),
(2,'CRB','ressources/logo/logo_crb_t2.png',3,2,1,0,5,3,2,7),
(3,'MCO','ressources/logo/logo_mco_t2.png',2,2,0,0,3,0,3,6),
(4,'ESBA','ressources/logo/logo_esba_t2.png',3,1,2,0,4,3,1,5),
(5,'CSC','ressources/logo/logo_min_csc.png',3,1,1,1,5,6,-1,4),
(6,'CRT','https://lfp.dz/clubs-logos/754-1663163636.png',3,1,1,1,2,3,-1,4),
(7,'MCA','ressources/logo/logo_mca_t2.png',1,1,0,0,2,0,2,3),
(8,'JSK','ressources/logo/logo_jsk_t2.png',2,1,0,1,1,1,0,3),
(9,'MBR','https://lfp.dz/clubs-logos/409-1755174810.png',3,1,0,2,2,3,-1,3),
(10,'OA','ressources/logo/logo_oakbou_t2.png',3,1,0,2,4,5,-1,3),
(11,'ESS','ressources/logo/logo_ess_t2.png',3,1,0,2,5,3,2,3),
(12,'JSEB','https://lfp.dz/clubs-logos/759-1788436581.png',3,1,0,2,4,4,0,3),
(13,'USMK','ressources/logo/logo_usmk_t2.png',2,0,2,0,1,1,0,2),
(14,'USB','ressources/logo/logo_usb_t2.png',3,0,2,1,2,3,-1,2),
(15,'ASO','ressources/logo/logo_asoc_t2.png',3,0,1,2,3,7,-4,1),
(16,'JSS','ressources/logo/logo_jss_t2.png',2,0,1,1,0,4,-4,1);

DROP TABLE IF EXISTS `classement_info`;
CREATE TABLE `classement_info` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `saison` VARCHAR(20) NOT NULL,
  `journee` INT NOT NULL,
  `mise_a_jour` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `classement_info` (`saison`,`journee`,`mise_a_jour`) VALUES ('2026/2027', 3, '2026-10-05 15:30:00');

DROP TABLE IF EXISTS `joueurs`;
CREATE TABLE `joueurs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL DEFAULT '',
  `nom_ar` VARCHAR(150) DEFAULT NULL,
  `dossard` INT DEFAULT NULL,
  `poste` VARCHAR(50) DEFAULT NULL,
  `categorie` TINYINT NOT NULL COMMENT '1=Gardiens 2=Défenseurs 3=Milieux 4=Attaquants 5=Staff',
  `ordre` INT NOT NULL DEFAULT 0 COMMENT 'ordre affiché (comme sur lfp.dz)',
  `date_naissance` DATE DEFAULT NULL,
  `age` INT DEFAULT NULL,
  `nationalite` VARCHAR(50) DEFAULT 'Algérie',
  `img` VARCHAR(255) DEFAULT NULL,
  `featured` TINYINT NOT NULL DEFAULT 0,
  `published` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `joueurs` (`nom`,`prenom`,`dossard`,`poste`,`categorie`,`ordre`,`age`,`nationalite`,`img`,`featured`,`published`) VALUES
('MELALA OUSSAMA ABDERRAHMANE','',16,'Gardien',1,1,23,'Algérie',NULL,0,1),
('BOUHALFAYA Zakaria','',1,'Gardien',1,2,29,'Algérie',NULL,0,1),
('NECIR ABDELMALEK','',30,'Gardien',1,3,35,'Algérie',NULL,0,1),
('ATIBU RADJABU JOHNSON','',6,'Défenseur',2,1,29,'RD Congo',NULL,0,1),
('TORACH ROGERS OCHAKI','',24,'Défenseur',2,2,23,'Ouganda',NULL,0,1),
('ZEGHAD YACINE','',5,'Défenseur',2,3,24,'Algérie',NULL,0,1),
('BENEDDINE MEHDI MOHAMED','',21,'Défenseur',2,4,30,'Algérie',NULL,0,1),
('BELGOURAI MOHAMED FAIZ','',2,'Défenseur',2,5,21,'Algérie',NULL,0,1),
('BEN MOUSSA RAHMANI IMAD EDDINE','',13,'Défenseur',2,6,21,'Algérie',NULL,0,1),
('MEDDAHI Oussama','',12,'Défenseur',2,7,35,'Algérie',NULL,0,1),
('CHIKHI ABDELMOUMEN','',27,'Défenseur',2,8,30,'Algérie',NULL,0,1),
('AIT ABDESSELAM AHMED','',4,'Défenseur',2,9,29,'Algérie',NULL,0,1),
('AYOUN MOUNDER NOUR EL ISLEM','',3,'Défenseur',2,10,20,'Algérie',NULL,0,1),
('DIB Brahim','',10,'Milieu',3,1,33,'Algérie',NULL,0,1),
('CHEKAL AFFARI HADJI','',8,'Milieu',3,2,23,'Algérie',NULL,0,1),
('BIZIMANA DJIHAD','',14,'Milieu',3,3,29,'Rwanda',NULL,0,1),
('REBIAI Miloud','',25,'Milieu',3,4,32,'Algérie',NULL,0,1),
('BERKANE MOSTAFA','',15,'Milieu',3,5,23,'Algérie',NULL,0,1),
('BOUZEKRI OUALAA MOUNDHIR','',7,'Milieu',3,6,24,'Algérie',NULL,0,1),
('BOUACIDA LOUAI ABDELMOUNTAKEM','',22,'Milieu',3,7,20,'Algérie',NULL,0,1),
('BAKIR Mohamed islam','',11,'Attaquant',4,1,30,'Algérie',NULL,0,1),
('CHABAN KARIM MOHMET','',18,'Attaquant',4,2,26,'Algérie',NULL,0,1),
('DJAOUCHI HAMID','',19,'Attaquant',4,3,31,'Algérie',NULL,0,1),
('ANATOUF MOSLEM','',20,'Attaquant',4,4,20,'Algérie',NULL,0,1),
('L''GHOUL NASSIM DJELLOUL SALEM','',26,'Attaquant',4,5,29,'Algérie',NULL,0,1),
('AGBAGNO YAWO MARCELLE EVRA','',9,'Attaquant',4,6,26,'Togo',NULL,0,1),
('LAHMERI Aimen Abdelaziz','',17,'Attaquant',4,7,30,'Algérie',NULL,0,1);

-- Staff technique (categorie = 5) : non publié par la LFP pour l'instant, à ajouter ici.

-- Tables utilisées ailleurs dans le code (vides pour l'instant)
CREATE TABLE IF NOT EXISTS `contact` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `adresse` VARCHAR(255), `telephone` VARCHAR(50), `email` VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `calendrier25` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `competition` VARCHAR(100), `date_match` DATETIME, `domicile` VARCHAR(60), `exterieur` VARCHAR(60),
  `logo_dom` VARCHAR(255), `logo_ext` VARCHAR(255), `stade` VARCHAR(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `partenaires` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100), `logo` VARCHAR(255), `url` VARCHAR(255), `published` TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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

-- Noms en arabe
UPDATE `classement` SET `club_ar`='إ.الجزائر' WHERE `club`='USMA';
UPDATE `classement` SET `club_ar`='ش.بلوزداد' WHERE `club`='CRB';
UPDATE `classement` SET `club_ar`='م.وهران' WHERE `club`='MCO';
UPDATE `classement` SET `club_ar`='ن.بن عكنون' WHERE `club`='ESBA';
UPDATE `classement` SET `club_ar`='ش.قسنطينة' WHERE `club`='CSC';
UPDATE `classement` SET `club_ar`='ش.تموشنت' WHERE `club`='CRT';
UPDATE `classement` SET `club_ar`='م.الجزائر' WHERE `club`='MCA';
UPDATE `classement` SET `club_ar`='ش.القبائل' WHERE `club`='JSK';
UPDATE `classement` SET `club_ar`='م.الرويسات' WHERE `club`='MBR';
UPDATE `classement` SET `club_ar`='أ.أقبو' WHERE `club`='OA';
UPDATE `classement` SET `club_ar`='و.سطيف' WHERE `club`='ESS';
UPDATE `classement` SET `club_ar`='ش.الأبيار' WHERE `club`='JSEB';
UPDATE `classement` SET `club_ar`='إ.خنشلة' WHERE `club`='USMK';
UPDATE `classement` SET `club_ar`='إ.بسكرة' WHERE `club`='USB';
UPDATE `classement` SET `club_ar`='ج.الشلف' WHERE `club`='ASO';
UPDATE `classement` SET `club_ar`='ش.الساورة' WHERE `club`='JSS';
UPDATE `joueurs` SET `nom_ar`='ملالة أسامة عبد الرحمان' WHERE `dossard`=16 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بوحلفاية زكرياء' WHERE `dossard`=1 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='نصير عبد المالك' WHERE `dossard`=30 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='أتيبو راجابو جونسون' WHERE `dossard`=6 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='طوراش روجرز أوشاكي' WHERE `dossard`=24 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='زغاد ياسين' WHERE `dossard`=5 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بن الدين مهدي محمد' WHERE `dossard`=21 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بلقوراي محمد فايز' WHERE `dossard`=2 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بن موسى رحماني عماد الدين' WHERE `dossard`=13 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='مداحي أسامة' WHERE `dossard`=12 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='شيخي عبد المومن' WHERE `dossard`=27 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='أيت عبد السلام أحمد' WHERE `dossard`=4 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='عيون منذر نور الإسلام' WHERE `dossard`=3 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='ديب إبراهيم' WHERE `dossard`=10 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='شكال عفاري حاجي' WHERE `dossard`=8 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بيزيمانا جيهاد' WHERE `dossard`=14 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='ربيعي ميلود' WHERE `dossard`=25 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بركان مصطفى' WHERE `dossard`=15 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بوزكري ولاء منذر' WHERE `dossard`=7 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بوعصيدة لؤي عبد المنتقم' WHERE `dossard`=22 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='بكير محمد إسلام' WHERE `dossard`=11 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='شعبان كريم محمت' WHERE `dossard`=18 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='جاوشي حميد' WHERE `dossard`=19 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='أناتوف مسلم' WHERE `dossard`=20 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='الغول نسيم جلول سالم' WHERE `dossard`=26 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='أغبانيو ياو مارسيل إيفرا' WHERE `dossard`=9 AND `categorie` BETWEEN 1 AND 4;
UPDATE `joueurs` SET `nom_ar`='لحمري أيمن عبد العزيز' WHERE `dossard`=17 AND `categorie` BETWEEN 1 AND 4;
