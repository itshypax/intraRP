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

-- Exportiere Daten aus Tabelle intradev.intra_edivi_ziele: ~4 rows (ungefähr)
INSERT INTO `intra_edivi_ziele` (`id`, `priority`, `identifier`, `name`, `transport`, `active`, `created_at`) VALUES
	(2, 98, 'amb', 'Ambulante Versorgung', 0, 1, '2025-03-19 22:32:15'),
	(3, 99, 'ubg', 'Übergabe Notfallteam', 0, 1, '2025-03-19 22:32:22'),
	(4, 96, 'kp', 'Kein Patient', 0, 1, '2025-03-19 22:32:36'),
	(5, 97, 'sf', 'Sozialfahrt', 0, 1, '2025-03-19 22:32:42');

-- Exportiere Daten aus Tabelle intradev.intra_mitarbeiter_dienstgrade: ~19 rows (ungefähr)
INSERT INTO `intra_mitarbeiter_dienstgrade` (`id`, `priority`, `name`, `name_m`, `name_w`, `badge`, `archive`, `created_at`) VALUES
	(1, 1, 'Angestellte/-r', 'Angestellter', 'Angestellte', NULL, 0, '2025-03-20 00:51:26'),
	(2, 2, 'Brandmeisteranwärter/-in', 'Brandmeisteranwärter', 'Brandmeisteranwärterin', '/assets/img/dienstgrade/bf/1.png', 0, '2025-03-20 00:52:59'),
	(3, 3, 'Brandmeister/-in', 'Brandmeister', 'Brandmeisterin', '/assets/img/dienstgrade/bf/2.png', 0, '2025-03-20 00:53:27'),
	(4, 4, 'Oberbrandmeister/-in', 'Oberbrandmeister', 'Oberbrandmeisterin', '/assets/img/dienstgrade/bf/3.png', 0, '2025-03-20 00:54:22'),
	(5, 5, 'Hauptbrandmeister/-in', 'Hauptbrandmeister', 'Hauptbrandmeisterin', '/assets/img/dienstgrade/bf/4.png', 0, '2025-03-20 00:54:49'),
	(6, 6, 'Hauptbrandmeister/-in mit AZ', 'Hauptbrandmeister mit AZ', 'Hauptbrandmesiterin mit AZ', '/assets/img/dienstgrade/bf/5.png', 0, '2025-03-20 00:55:17'),
	(7, 8, 'Brandinspektor/-in', 'Brandinspektor', 'Brandinspektorin', '/assets/img/dienstgrade/bf/6.png', 0, '2025-03-20 00:55:46'),
	(8, 9, 'Oberbrandinspektor/-in', 'Oberbrandinspektor', 'Oberbrandinspektorin', '/assets/img/dienstgrade/bf/7.png', 0, '2025-03-20 00:56:02'),
	(9, 10, 'Brandamtmann/frau', 'Brandamtmann', 'Brandamtfrau', '/assets/img/dienstgrade/bf/8.png', 0, '2025-03-20 00:56:30'),
	(10, 11, 'Brandamtsrat/rätin', 'Brandamtsrat', 'Brandamtsrätin', '/assets/img/dienstgrade/bf/9.png', 0, '2025-03-20 00:56:57'),
	(11, 12, 'Brandoberamtsrat/rätin', 'Brandoberamtsrat', 'Brandoberamtsrätin', '/assets/img/dienstgrade/bf/10.png', 0, '2025-03-20 00:57:18'),
	(12, 13, 'Brandreferendar/-in', 'Brandreferendar', 'Brandreferendarin', '/assets/img/dienstgrade/bf/15.png', 0, '2025-03-20 00:57:48'),
	(13, 14, 'Brandrat/rätin', 'Brandrat', 'Brandrätin', '/assets/img/dienstgrade/bf/11.png', 0, '2025-03-20 00:58:33'),
	(14, 15, 'Oberbrandrat/rätin', 'Oberbrandrat', 'Oberbrandrätin', '/assets/img/dienstgrade/bf/12.png', 0, '2025-03-20 00:58:35'),
	(15, 7, 'Brandinspektoranwärter/-in', 'Brandinspektoranwärter', 'Brandinspektoranwärterin', '/assets/img/dienstgrade/bf/17_2.png', 0, '2025-03-20 00:59:35'),
	(16, 0, 'Ehrenamtliche/-r', 'Ehrenamtlicher', 'Ehrenamtliche', NULL, 0, '2025-03-20 01:02:58'),
	(17, 16, 'Branddirektor/-in', 'Branddirektor', 'Branddirektorin', '/assets/img/dienstgrade/bf/13.png', 0, '2025-03-20 01:03:56'),
	(18, 17, 'Leitende/-r Branddirektor/-in', 'Leitender Branddirektor', 'Leitende Branddirektorin', '/assets/img/dienstgrade/bf/14.png', 0, '2025-03-20 01:04:28'),
	(19, 0, 'Entlassen/Archiv', 'Entlassen/Archiv', 'Entlassen/Archiv', NULL, 1, '2025-03-20 02:10:36');

-- Exportiere Daten aus Tabelle intradev.intra_mitarbeiter_fwquali: ~6 rows (ungefähr)
INSERT INTO `intra_mitarbeiter_fwquali` (`id`, `priority`, `shortname`, `name`, `name_m`, `name_w`, `none`, `created_at`) VALUES
	(2, 0, '-', 'Keine', 'Keine', 'Keine', 1, '2025-03-20 01:11:16'),
	(3, 1, 'B1', 'Grundausbildung', 'Grundausbildung', 'Grundausbildung', 0, '2025-03-20 01:11:32'),
	(4, 2, 'B2', 'Maschinist/-in', 'Maschinist', 'Maschinistin', 0, '2025-03-20 01:11:46'),
	(5, 3, 'B3', 'Gruppenführer/-in', 'Gruppenführer', 'Gruppenführerin', 0, '2025-03-20 01:12:06'),
	(6, 4, 'B4', 'Zugführer/-in', 'Zugführer', 'Zugführerin', 0, '2025-03-20 01:12:23'),
	(7, 5, 'B5', 'B-Dienst', 'B-Dienst', 'B-Dienst', 0, '2025-03-20 01:12:31'),
	(8, 6, 'B6', 'A-Dienst', 'A-Dienst', 'A-Dienst', 0, '2025-03-20 01:12:41');

-- Exportiere Daten aus Tabelle intradev.intra_mitarbeiter_rdquali: ~6 rows (ungefähr)
INSERT INTO `intra_mitarbeiter_rdquali` (`id`, `priority`, `name`, `name_m`, `name_w`, `none`, `trainable`, `created_at`) VALUES
	(2, 1, 'Rettungssanitäter/-in i. A.', 'Rettungssanitäter i. A.', 'Rettungssanitäterin i. A.', 0, 0, '2025-03-20 01:07:47'),
	(3, 0, 'Keine', 'Keine', 'Keine', 1, 0, '2025-03-20 01:08:48'),
	(4, 2, 'Rettungssanitäter/-in', 'Rettungssanitäter', 'Rettungssanitäterin', 0, 1, '2025-03-20 01:09:04'),
	(5, 3, 'Notfallsanitäter/-in i. A.', 'Notfallsanitäter i. A.', 'Notfallsanitäterin i. A.', 0, 0, '2025-03-20 01:09:31'),
	(6, 4, 'Notfallsanitäter/-in', 'Notfallsanitäter', 'Notfallsanitäterin', 0, 1, '2025-03-20 01:09:46'),
	(7, 5, 'Notarzt/ärztin', 'Notarzt', 'Notärztin', 0, 0, '2025-03-20 01:10:00'),
	(8, 6, 'Ärztliche/-r Leiter/-in RD', 'Ärztlicher Leiter RD', 'Ärztliche Leiterin RD', 0, 0, '2025-03-20 01:10:25');

-- Exportiere Daten aus Tabelle intradev.intra_users: ~1 rows (ungefähr)
INSERT INTO `intra_users` (`id`, `username`, `fullname`, `created_at`, `passwort`, `aktenid`, `role`, `full_admin`) VALUES
	(114, 'admin', 'Admin Admin', '2025-03-24 05:55:35', '$2y$10$xJ7JSBFpJhSaoutQwqJwa.62jjU8dVYFzUYtCXfcl5IGPOwuN.x.y', 0, 3, 1);

-- Exportiere Daten aus Tabelle intradev.intra_users_roles: ~7 rows (ungefähr)
INSERT INTO `intra_users_roles` (`id`, `priority`, `name`, `color`, `permissions`, `created_at`) VALUES
	(1, 10, 'Admin', 'danger', '["admin"]', '2025-03-23 22:17:15'),
	(2, 100, 'SGL', 'primary', '["antraege_view", "antraege_edit", "edivi_view", "personal_view", "personal_edit", "intra_mitarbeiter_dokumente", "users_view", "users_edit", "users_create", "files_upload", "files_log"]', '2025-03-23 22:27:45'),
	(3, 110, 'TL', 'primary', '["personal_view", "intra_mitarbeiter_dokumente"]', '2025-03-23 22:28:16'),
	(4, 200, 'QM-RD', 'info', '["personal_view", "edivi_view", "edivi_edit"]', '2025-03-23 22:30:31'),
	(5, 210, 'Ausbilder', 'success', '["personal_view", "intra_mitarbeiter_dokumente"]', '2025-03-23 22:31:57'),
	(6, 220, 'Personaler', 'success', '["personal_view", "personal_edit", "intra_mitarbeiter_dokumente"]', '2025-03-23 22:32:18'),
	(7, 999, 'Gast', 'secondary', '[]', '2025-03-23 22:33:25');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
