-- --------------------------------------------------------
-- Host:                         cyan-lion-94298.zap.cloud
-- Server-Version:               10.11.11-MariaDB-0+deb12u1 - Debian 12
-- Server-Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Struktur von Tabelle intradev.intra_antrag_bef
CREATE TABLE IF NOT EXISTS `intra_antrag_bef` (
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
) ENGINE=InnoDB AUTO_INCREMENT=651 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_edivi
CREATE TABLE IF NOT EXISTS `intra_edivi` (
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
  `pfname` varchar(255) DEFAULT NULL,
  `fzg_transp` varchar(255) DEFAULT NULL,
  `fzg_transp_perso` varchar(255) DEFAULT NULL,
  `fzg_na` varchar(255) DEFAULT NULL,
  `fzg_na_perso` varchar(255) DEFAULT NULL,
  `fzg_sonst` varchar(255) DEFAULT NULL,
  `naname` varchar(255) DEFAULT NULL,
  `transportziel` varchar(255) DEFAULT NULL,
  `protokoll_status` tinyint(3) DEFAULT 0,
  `bearbeiter` varchar(255) DEFAULT NULL,
  `qmkommentar` text DEFAULT NULL,
  `freigegeben` tinyint(1) DEFAULT 0,
  `freigeber_name` varchar(255) DEFAULT NULL,
  `last_edit` timestamp NULL DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2494 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_edivi_fahrzeuge
CREATE TABLE IF NOT EXISTS `intra_edivi_fahrzeuge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `veh_type` varchar(255) NOT NULL,
  `doctor` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_edivi_qmlog
CREATE TABLE IF NOT EXISTS `intra_edivi_qmlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protokoll_id` int(11) NOT NULL,
  `kommentar` longtext NOT NULL,
  `log_aktion` tinyint(1) DEFAULT NULL,
  `bearbeiter` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=938 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_edivi_ziele
CREATE TABLE IF NOT EXISTS `intra_edivi_ziele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `transport` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `gebdatum` date NOT NULL,
  `charakterid` varchar(255) NOT NULL,
  `geschlecht` tinyint(1) NOT NULL,
  `forumprofil` int(5) DEFAULT NULL,
  `discordtag` varchar(255) DEFAULT NULL,
  `telefonnr` varchar(255) DEFAULT NULL,
  `dienstnr` varchar(255) NOT NULL,
  `einstdatum` date NOT NULL,
  `dienstgrad` tinyint(2) NOT NULL DEFAULT 0,
  `qualifw2` tinyint(1) NOT NULL DEFAULT 0,
  `qualird` tinyint(1) NOT NULL DEFAULT 0,
  `zusatz` varchar(255) DEFAULT NULL,
  `fachdienste` longtext NOT NULL,
  `createdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `dienstnr` (`dienstnr`)
) ENGINE=InnoDB AUTO_INCREMENT=1038 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter_dienstgrade
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter_dienstgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_m` varchar(255) NOT NULL,
  `name_w` varchar(255) NOT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter_dokumente
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter_dokumente` (
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
  `ausstellungsdatum` date DEFAULT NULL,
  `ausstellerid` int(11) NOT NULL,
  `aussteller_name` varchar(255) DEFAULT NULL,
  `aussteller_rang` tinyint(2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `profileid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `docid` (`docid`)
) ENGINE=InnoDB AUTO_INCREMENT=2286 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter_fwquali
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter_fwquali` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `shortname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_m` varchar(255) NOT NULL,
  `name_w` varchar(255) NOT NULL,
  `none` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter_log
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter_log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `profilid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `content` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `paneluser` varchar(255) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=6400 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_mitarbeiter_rdquali
CREATE TABLE IF NOT EXISTS `intra_mitarbeiter_rdquali` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_m` varchar(255) NOT NULL,
  `name_w` varchar(255) NOT NULL,
  `none` tinyint(1) NOT NULL DEFAULT 0,
  `trainable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_uploads
CREATE TABLE IF NOT EXISTS `intra_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `upload_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_users
CREATE TABLE IF NOT EXISTS `intra_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `passwort` varchar(255) NOT NULL,
  `aktenid` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `full_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle intradev.intra_users_roles
CREATE TABLE IF NOT EXISTS `intra_users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `permissions` longtext DEFAULT '[]',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Daten-Export vom Benutzer nicht ausgewählt

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
