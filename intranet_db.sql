-- --------------------------------------------------------
-- Host:                         web-snake02.native-webspace.com
-- Server-Version:               10.5.23-MariaDB-0+deb11u1 - Debian 11
-- Server-Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_antraege_be
CREATE TABLE IF NOT EXISTS `cirs_antraege_be` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniqueid` int(11) NOT NULL,
  `name_dn` varchar(255) NOT NULL,
  `dienstgrad` varchar(255) NOT NULL,
  `time_added` datetime NOT NULL DEFAULT current_timestamp(),
  `freitext` text NOT NULL,
  `cirs_manager` varchar(255) DEFAULT NULL,
  `cirs_time` datetime DEFAULT NULL,
  `cirs_status` tinyint(3) NOT NULL DEFAULT 0,
  `cirs_text` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=648 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_cases
CREATE TABLE IF NOT EXISTS `cirs_cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `btr_bf` tinyint(1) NOT NULL,
  `btr_rd` tinyint(1) NOT NULL,
  `r_mitarbeiter` tinyint(1) NOT NULL,
  `r_fahrzeug` tinyint(1) NOT NULL,
  `r_geraet` tinyint(1) NOT NULL,
  `r_zivilisten` tinyint(1) NOT NULL,
  `r_bos` tinyint(1) NOT NULL,
  `r_sonst` tinyint(1) NOT NULL,
  `t_beschwerde` tinyint(1) NOT NULL,
  `t_mangel` tinyint(1) NOT NULL,
  `t_wunsch` tinyint(1) NOT NULL,
  `t_sonst` tinyint(1) NOT NULL,
  `freitext` text NOT NULL,
  `time_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cirs_manager` varchar(255) DEFAULT NULL,
  `cirs_title` varchar(255) DEFAULT NULL,
  `cirs_text` text DEFAULT NULL,
  `cirs_time` datetime DEFAULT NULL,
  `cirs_status` tinyint(4) NOT NULL DEFAULT 1,
  `uniqueid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_frs_exams
CREATE TABLE IF NOT EXISTS `cirs_frs_exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL,
  `test` tinyint(2) NOT NULL,
  `used` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp_used` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_rd_protokolle
CREATE TABLE IF NOT EXISTS `cirs_rd_protokolle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patname` varchar(255) DEFAULT NULL,
  `patgebdat` date DEFAULT NULL,
  `patsex` tinyint(1) DEFAULT NULL,
  `edatum` date DEFAULT NULL,
  `ezeit` varchar(255) DEFAULT NULL,
  `enr` varchar(255) NOT NULL,
  `eort` varchar(255) DEFAULT NULL,
  `sendezeit` datetime DEFAULT current_timestamp(),
  `awfrei_1` tinyint(1) DEFAULT NULL,
  `awfrei_2` tinyint(1) DEFAULT NULL,
  `awfrei_3` tinyint(1) DEFAULT NULL,
  `awsicherung_1` tinyint(1) DEFAULT NULL,
  `awsicherung_2` tinyint(1) DEFAULT NULL,
  `awsicherung_neu` tinyint(1) DEFAULT NULL,
  `zyanose_1` tinyint(1) DEFAULT NULL,
  `zyanose_2` tinyint(1) DEFAULT NULL,
  `o2gabe` tinyint(15) DEFAULT 0,
  `b_symptome` tinyint(4) DEFAULT NULL,
  `b_auskult` tinyint(3) DEFAULT NULL,
  `b_beatmung` tinyint(3) DEFAULT NULL,
  `spo2` varchar(255) DEFAULT NULL,
  `atemfreq` varchar(255) DEFAULT NULL,
  `etco2` varchar(255) DEFAULT NULL,
  `c_kreislauf` tinyint(2) DEFAULT NULL,
  `rrsys` varchar(255) DEFAULT NULL,
  `rrdias` varchar(255) DEFAULT NULL,
  `rrmad` varchar(255) DEFAULT NULL,
  `herzfreq` varchar(255) DEFAULT NULL,
  `c_ekg` tinyint(9) DEFAULT NULL,
  `c_zugang_art_1` tinyint(9) DEFAULT NULL,
  `c_zugang_gr_1` tinyint(9) DEFAULT NULL,
  `c_zugang_ort_1` varchar(255) DEFAULT NULL,
  `c_zugang_art_2` tinyint(9) DEFAULT NULL,
  `c_zugang_gr_2` tinyint(9) DEFAULT NULL,
  `c_zugang_ort_2` varchar(255) DEFAULT NULL,
  `c_zugang_art_3` tinyint(9) DEFAULT NULL,
  `c_zugang_gr_3` tinyint(9) DEFAULT NULL,
  `c_zugang_ort_3` varchar(255) DEFAULT NULL,
  `d_bewusstsein` tinyint(3) DEFAULT NULL,
  `d_pupillenw_1` tinyint(3) DEFAULT NULL,
  `d_pupillenw_2` tinyint(3) DEFAULT NULL,
  `d_lichtreakt_1` tinyint(2) DEFAULT NULL,
  `d_lichtreakt_2` tinyint(2) DEFAULT NULL,
  `d_gcs_1` tinyint(3) DEFAULT NULL,
  `d_gcs_2` tinyint(4) DEFAULT NULL,
  `d_gcs_3` tinyint(5) DEFAULT NULL,
  `d_ex_1` tinyint(2) DEFAULT NULL,
  `d_ex_2` tinyint(1) DEFAULT NULL,
  `d_ex_3` tinyint(1) DEFAULT NULL,
  `d_ex_4` tinyint(1) DEFAULT NULL,
  `bz` varchar(255) DEFAULT NULL,
  `temp` varchar(255) DEFAULT NULL,
  `v_muster_k` tinyint(3) DEFAULT NULL,
  `v_muster_k1` tinyint(2) DEFAULT NULL,
  `v_muster_w` tinyint(3) DEFAULT NULL,
  `v_muster_w1` tinyint(2) DEFAULT NULL,
  `v_muster_t` tinyint(3) DEFAULT NULL,
  `v_muster_t1` tinyint(2) DEFAULT NULL,
  `v_muster_a` tinyint(3) DEFAULT NULL,
  `v_muster_a1` tinyint(2) DEFAULT NULL,
  `v_muster_al` tinyint(3) DEFAULT NULL,
  `v_muster_al1` tinyint(2) DEFAULT NULL,
  `v_muster_ar` tinyint(3) DEFAULT NULL,
  `v_muster_ar1` tinyint(2) DEFAULT NULL,
  `v_muster_bl` tinyint(3) DEFAULT NULL,
  `v_muster_bl1` tinyint(2) DEFAULT NULL,
  `v_muster_br` tinyint(3) DEFAULT NULL,
  `v_muster_br1` tinyint(2) DEFAULT NULL,
  `sz_nrs` tinyint(2) DEFAULT NULL,
  `sz_toleranz_1` tinyint(2) DEFAULT NULL,
  `sz_toleranz_2` tinyint(2) DEFAULT NULL,
  `medis` longtext DEFAULT NULL,
  `diagnose` text DEFAULT NULL,
  `anmerkungen` text DEFAULT NULL,
  `notfallteam` tinyint(1) DEFAULT NULL,
  `transportverw` tinyint(1) DEFAULT NULL,
  `nacascore` tinyint(5) DEFAULT NULL,
  `pfname` varchar(255) DEFAULT NULL,
  `fzg_transp` varchar(255) DEFAULT NULL,
  `fzg_transp_perso` varchar(255) DEFAULT NULL,
  `fzg_na` varchar(255) DEFAULT NULL,
  `fzg_na_perso` varchar(255) DEFAULT NULL,
  `fzg_sonst` varchar(255) DEFAULT NULL,
  `naname` varchar(255) DEFAULT NULL,
  `transportziel` varchar(255) DEFAULT NULL,
  `transportziel2` tinyint(2) DEFAULT NULL,
  `protokoll_status` tinyint(3) DEFAULT 0,
  `bearbeiter` varchar(255) DEFAULT NULL,
  `qmkommentar` text DEFAULT NULL,
  `freigegeben` tinyint(1) DEFAULT 0,
  `freigeber_name` varchar(255) DEFAULT NULL,
  `last_edit` timestamp NULL DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2481 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_rd_prot_log
CREATE TABLE IF NOT EXISTS `cirs_rd_prot_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protokoll_id` int(11) NOT NULL,
  `kommentar` longtext NOT NULL,
  `log_aktion` tinyint(1) DEFAULT NULL,
  `bearbeiter` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=929 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_rd_prot_verlauf
CREATE TABLE IF NOT EXISTS `cirs_rd_prot_verlauf` (
  `id` int(11) NOT NULL,
  `protokoll_id` int(11) NOT NULL,
  `param_typ` tinyint(1) NOT NULL,
  `param_value` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_roles
CREATE TABLE IF NOT EXISTS `cirs_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `importance` int(11) NOT NULL DEFAULT 0,
  `permissions` longtext NOT NULL DEFAULT '[]',
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_uploads
CREATE TABLE IF NOT EXISTS `cirs_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `upload_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.cirs_users
CREATE TABLE IF NOT EXISTS `cirs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `passwort` varchar(255) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `aktenid` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 3,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.klinik_anmeldungen
CREATE TABLE IF NOT EXISTS `klinik_anmeldungen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ankunftzeit` varchar(255) NOT NULL,
  `zielklinik` tinyint(1) NOT NULL DEFAULT 0,
  `zielobjtyp` tinyint(1) NOT NULL DEFAULT 0,
  `kat_1` tinyint(1) NOT NULL DEFAULT 0,
  `kat_2` tinyint(1) NOT NULL DEFAULT 0,
  `kat_3` int(1) NOT NULL DEFAULT 0,
  `diagnose` text NOT NULL,
  `a_1` tinyint(1) NOT NULL DEFAULT 0,
  `a_2` tinyint(1) NOT NULL DEFAULT 0,
  `b_1` tinyint(1) NOT NULL DEFAULT 0,
  `b_2` tinyint(1) NOT NULL DEFAULT 0,
  `c_1` tinyint(1) NOT NULL DEFAULT 0,
  `c_2` tinyint(1) NOT NULL DEFAULT 0,
  `c_3` tinyint(1) NOT NULL DEFAULT 0,
  `c_4` tinyint(1) NOT NULL DEFAULT 0,
  `d_1` tinyint(1) NOT NULL DEFAULT 0,
  `d_2` tinyint(1) NOT NULL DEFAULT 0,
  `d_3` tinyint(1) NOT NULL DEFAULT 0,
  `s_1` tinyint(1) NOT NULL DEFAULT 0,
  `s_2` tinyint(1) NOT NULL DEFAULT 0,
  `estichwort` varchar(255) NOT NULL DEFAULT '0',
  `enr` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.klinik_row_count
CREATE TABLE IF NOT EXISTS `klinik_row_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rows` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.mail_mails
CREATE TABLE IF NOT EXISTS `mail_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `favorited` tinyint(1) NOT NULL DEFAULT 0,
  `marked` tinyint(1) NOT NULL DEFAULT 0,
  `viewed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.mail_signatures
CREATE TABLE IF NOT EXISTS `mail_signatures` (
  `user` int(11) NOT NULL,
  `signature` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.mail_users
CREATE TABLE IF NOT EXISTS `mail_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_username` varchar(255) NOT NULL,
  `mail_ending` varchar(255) NOT NULL,
  `paneluser` int(11) NOT NULL,
  `displayname` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail_username` (`mail_username`),
  UNIQUE KEY `paneluser` (`paneluser`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.personal_dokumente
CREATE TABLE IF NOT EXISTS `personal_dokumente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT 0,
  `anrede` tinyint(1) NOT NULL DEFAULT 0,
  `erhalter` varchar(255) DEFAULT NULL,
  `inhalt` longtext DEFAULT NULL,
  `suspendtime` date DEFAULT NULL,
  `erhalter_gebdat` date DEFAULT NULL,
  `erhalter_rang` tinyint(2) DEFAULT NULL,
  `erhalter_rang_rd` tinyint(2) DEFAULT NULL,
  `erhalter_quali` tinyint(2) DEFAULT NULL,
  `ausstelungsdatum` date DEFAULT NULL,
  `ausstellerid` int(11) NOT NULL,
  `aussteller_name` varchar(255) DEFAULT NULL,
  `aussteller_rang` tinyint(2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `profileid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=2205 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.personal_log
CREATE TABLE IF NOT EXISTS `personal_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `profilid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `content` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `paneluser` varchar(255) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=6170 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle hypaxna1_cirs.personal_profile
CREATE TABLE IF NOT EXISTS `personal_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `gebdatum` date NOT NULL,
  `charakterid` varchar(255) NOT NULL,
  `forumprofil` int(5) DEFAULT NULL,
  `discordtag` varchar(255) DEFAULT NULL,
  `telefonnr` varchar(255) DEFAULT NULL,
  `dienstnr` varchar(255) NOT NULL,
  `einstdatum` date NOT NULL,
  `dienstgrad` tinyint(2) NOT NULL DEFAULT 0,
  `qualifw` longtext NOT NULL,
  `qualird` tinyint(1) NOT NULL DEFAULT 0,
  `fachdienste` longtext NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=999 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
