-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.2.0.6576
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table bookings.times: ~11 rows (approximately)
INSERT INTO `times` (`id`, `app`, `room`, `start`, `end`, `deleted`) VALUES
	(56, 1, 7, '08:00:00', '08:59:00', 0),
	(57, 1, 7, '09:00:00', '09:59:00', 0),
	(62, 1, 7, '10:00:00', '10:59:00', 0),
	(63, 1, 7, '11:00:00', '11:59:00', 0),
	(64, 1, 7, '12:00:00', '12:59:00', 0),
	(65, 1, 7, '13:00:00', '13:59:00', 0),
	(66, 1, 7, '14:00:00', '14:59:00', 0),
	(67, 1, 7, '15:20:00', '16:19:00', 0),
	(68, 1, 7, '16:20:00', '17:19:00', 0),
	(69, 1, 7, '17:20:00', '18:19:00', 0),
	(70, 1, 7, '18:20:00', '19:20:00', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
