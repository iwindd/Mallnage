-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.25-MariaDB - mariadb.org binary distribution
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

-- Dumping structure for table cooperatives.barcodes
CREATE TABLE IF NOT EXISTS `barcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resultGenerate` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.barcodes: ~0 rows (approximately)

-- Dumping structure for table cooperatives.borrows
CREATE TABLE IF NOT EXISTS `borrows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `historyId` bigint(20) unsigned NOT NULL DEFAULT 0,
  `cooperative` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `closeType` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.borrows: ~11 rows (approximately)
INSERT IGNORE INTO `borrows` (`id`, `historyId`, `cooperative`, `product`, `quantity`, `used`, `note`, `note2`, `status`, `closeType`, `created_at`, `updated_at`) VALUES
	(56, 0, 45, 139, 100, 100, NULL, '-', 1, 0, '2022-12-02 07:03:17', '2022-12-02 07:03:27'),
	(57, 0, 45, 138, 50, 50, NULL, '-', 1, 0, '2022-12-02 07:04:45', '2022-12-02 07:05:13'),
	(58, 0, 45, 140, 50, 50, NULL, '-', 1, 0, '2022-12-02 07:04:54', '2022-12-02 07:05:17'),
	(59, 0, 45, 141, 50, 50, NULL, '-', 1, 0, '2022-12-02 07:05:04', '2022-12-02 07:05:21'),
	(60, 0, 45, 138, 50, 50, NULL, '-', 1, 0, '2022-12-02 07:06:23', '2022-12-02 07:06:29'),
	(61, 0, 45, 148, 3, 3, NULL, '-', 1, 0, '2022-12-05 11:06:20', '2022-12-05 11:06:39'),
	(62, 0, 45, 148, 3, 0, NULL, '-', 1, 1, '2022-12-05 11:06:50', '2022-12-05 11:06:56'),
	(63, 0, 45, 143, 40, 30, NULL, '-', 1, 0, '2022-12-14 13:15:56', '2022-12-14 13:16:31'),
	(64, 0, 46, 151, 5, 5, NULL, '-', 1, 0, '2022-12-16 13:14:40', '2022-12-16 13:19:27'),
	(65, 0, 45, 141, 40, 40, NULL, '-', 1, 0, '2022-12-21 19:05:22', '2022-12-21 19:05:59'),
	(66, 0, 49, 154, 8, 5, NULL, '-', 1, 0, '2022-12-21 19:12:15', '2022-12-21 19:12:48'),
	(67, 0, 57, 157, 6, 6, NULL, '-', 1, 0, '2023-01-18 10:29:18', '2023-01-18 10:29:33'),
	(68, 0, 57, 157, 10, 5, NULL, '-', 1, 0, '2023-01-18 10:29:29', '2023-01-18 10:29:43'),
	(69, 0, 45, 156, 1, 0, NULL, NULL, 0, 0, '2023-01-31 08:28:34', '2023-01-31 08:28:34');

-- Dumping structure for table cooperatives.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` int(11) NOT NULL,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.categories: ~11 rows (approximately)
INSERT IGNORE INTO `categories` (`id`, `cooperative`, `category_name`, `created_at`, `updated_at`) VALUES
	(3, 45, 'เล็ก', '2022-12-01 12:55:59', '2022-12-01 12:55:59'),
	(4, 45, 'กลาง', '2022-12-01 12:56:02', '2022-12-01 12:56:02'),
	(5, 45, 'ใหญ่', '2022-12-01 12:56:07', '2022-12-01 12:56:07'),
	(6, 45, 'คอนเฟลก', '2022-12-01 13:43:17', '2022-12-01 13:43:17'),
	(7, 45, 'เม็ดมะม่วง', '2022-12-01 13:43:25', '2022-12-01 13:43:25'),
	(8, 45, 'มะพร้าว', '2022-12-01 13:43:42', '2022-12-01 13:43:42'),
	(9, 45, 'wwwws', '2022-12-02 07:07:51', '2022-12-02 07:07:58'),
	(10, 45, 'เครื่องดื่ม', '2022-12-14 13:10:12', '2022-12-14 13:10:21'),
	(11, 46, 'เครื่องดื่ม', '2022-12-16 12:28:02', '2022-12-16 12:28:09'),
	(12, 45, 'เล็ก', '2022-12-21 19:00:33', '2022-12-21 19:00:33'),
	(13, 49, 'เครื่องดื่ม', '2022-12-21 19:09:17', '2022-12-21 19:09:27'),
	(14, 57, 'เครื่องดื่ม', '2023-01-18 10:12:41', '2023-01-18 10:12:41');

-- Dumping structure for table cooperatives.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.departments: ~12 rows (approximately)
INSERT IGNORE INTO `departments` (`id`, `label`, `created_at`, `updated_at`) VALUES
	(1, 'ไม่ระบุ', '2023-01-31 07:01:13', '2023-01-31 07:01:13'),
	(6, 'แผนกวิชาสามัญสัมพันธ์', '2023-01-31 07:01:13', '2023-01-31 07:12:17'),
	(7, 'แผนกวิชาการท่องเที่ยว', '2023-01-31 07:12:24', '2023-01-31 07:14:41'),
	(8, 'แผนกวิชาการโรงแรม', '2023-01-31 07:14:52', '2023-01-31 07:14:52'),
	(9, 'แผนกวิชาคหกรรมทั่วไป', '2023-01-31 07:15:09', '2023-01-31 07:15:09'),
	(10, 'แผนกวิชาผ้าและเครื่องแต่งกาย', '2023-01-31 07:15:23', '2023-01-31 07:15:23'),
	(11, 'แผนกวิชาคอมพิวเตอร์กราฟิก', '2023-01-31 07:15:33', '2023-01-31 07:15:33'),
	(12, 'แผนกวิชาการออกแบบ', '2023-01-31 07:15:39', '2023-01-31 07:15:39'),
	(13, 'แผนกวิชาวิจิตรศิลป์', '2023-01-31 07:15:46', '2023-01-31 07:15:46'),
	(14, 'แผนกวิชาการจัดการโลจิสติกส์และซัพพลายเชน', '2023-01-31 07:15:54', '2023-01-31 07:15:54'),
	(15, 'แผนกวิชาคอมพิวเตอร์ธุรกิจ', '2023-01-31 07:16:00', '2023-01-31 07:16:00'),
	(16, 'แผนกวิชาเลขานุการและการจัดการทั่วไป', '2023-01-31 07:16:05', '2023-01-31 07:16:05'),
	(17, 'แผนกวิชาการตลาด', '2023-01-31 07:16:10', '2023-01-31 07:16:10'),
	(18, 'แผนกวิชาบัญชี', '2023-01-31 07:16:15', '2023-01-31 07:16:15');

-- Dumping structure for table cooperatives.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table cooperatives.histories
CREATE TABLE IF NOT EXISTS `histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` int(11) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `product` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_borrows` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `qrcode` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `temp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `district` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `province` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `postalcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'ไม่มีแผนก',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.histories: ~7 rows (approximately)
INSERT IGNORE INTO `histories` (`id`, `cooperative`, `note`, `product`, `product_borrows`, `price`, `qrcode`, `created_at`, `updated_at`, `temp`, `address`, `district`, `firstname`, `lastname`, `area`, `province`, `postalcode`, `department`) VALUES
	(172, 45, 'ไม่มีหมายเหตุ', '{"22":1,"23":1}', '', 580, 1, '2023-01-31 10:28:47', '2023-01-31 10:28:47', NULL, '39/2', 'ทุ่งเตาใหม่', 'นาย อชิรวิชฌ์', 'แก้วคง', 'บ้านนาสาร', 'สุราษฎร์ธานี', '84120', 'แผนกวิชาคอมพิวเตอร์ธุรกิจ'),
	(173, 45, 'ไม่มีหมายเหตุ', '{"23":1}', '', 290, 0, '2023-01-31 10:55:17', '2023-01-31 10:55:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(174, 45, '-', '{"22":1}', '', 290, 0, '2023-02-01 10:15:42', '2023-02-01 10:15:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(175, 45, '-', '{"23":1}', '', 290, 0, '2023-02-01 10:17:10', '2023-02-01 10:17:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(176, 45, '-', '{"21":1}', '', 290, 0, '2023-02-01 10:17:43', '2023-02-01 10:17:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(177, 45, '-', '{"22":1,"23":1}', '["23"]', 580, 0, '2023-02-01 10:27:41', '2023-02-01 10:27:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(178, 45, 'ไม่มีหมายเหตุ', '{"22":2,"21":2,"13":1,"11":1,"12":1}', '["21","11","12"]', 1570, 0, '2023-02-01 10:44:16', '2023-02-01 10:44:16', NULL, '39/2', 'ทุ่งเตาใหม่', 'นาย อชิรวิชฌ์', 'แก้วคง', 'บ้านนาสาร', 'สุราษฎร์ธานี', '84120', 'แผนกวิชาคอมพิวเตอร์ธุรกิจ');

-- Dumping structure for table cooperatives.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `qrcode` int(11) NOT NULL DEFAULT 0,
  `borrow` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '1 add, 2 remove, 3 sell, 4 borrow',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=543 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.logs: ~65 rows (approximately)
INSERT IGNORE INTO `logs` (`id`, `cooperative`, `serial`, `type`, `qrcode`, `borrow`, `amount`, `created_at`, `updated_at`) VALUES
	(475, '45', '23', 3, 0, 0, 1, '2023-01-18 06:51:24', '2023-01-18 06:51:24'),
	(476, '57', '8279728146', 3, 0, 0, 0, '2023-01-18 10:12:32', '2023-01-18 10:12:32'),
	(477, '57', '8279728146', 1, 0, 0, 500, '2023-01-18 10:13:01', '2023-01-18 10:13:01'),
	(478, '57', '8279728146', 3, 1, 0, 1, '2023-01-18 10:13:47', '2023-01-18 10:13:47'),
	(479, '57', '8279728146', 3, 0, 0, 3, '2023-01-18 10:14:11', '2023-01-18 10:14:11'),
	(482, '57', '8279728146', 4, 0, 0, 6, '2023-01-18 10:29:18', '2023-01-18 10:29:18'),
	(483, '57', '8279728146', 4, 0, 0, 10, '2023-01-18 10:29:29', '2023-01-18 10:29:29'),
	(484, '57', '8279728146', 3, 0, 0, 6, '2023-01-18 10:29:33', '2023-01-18 10:29:33'),
	(485, '57', '8279728146', 3, 0, 0, 5, '2023-01-18 10:29:43', '2023-01-18 10:29:43'),
	(486, '57', '8279728146', 1, 0, 0, 5, '2023-01-18 10:29:43', '2023-01-18 10:29:43'),
	(488, '45', '22', 3, 0, 0, 1, '2023-01-18 10:57:37', '2023-01-18 10:57:37'),
	(489, '62', '59476269194', 3, 0, 0, 0, '2023-01-18 11:04:18', '2023-01-18 11:04:18'),
	(490, '62', '59476269194', 1, 0, 0, 1, '2023-01-18 11:04:27', '2023-01-18 11:04:27'),
	(491, '62', '59476269194', 1, 0, 0, 14, '2023-01-18 11:04:33', '2023-01-18 11:04:33'),
	(492, '62', '59476269194', 3, 0, 0, 1, '2023-01-18 11:04:55', '2023-01-18 11:04:55'),
	(493, '63', '12805795188', 3, 0, 0, 0, '2023-01-18 13:10:32', '2023-01-18 13:10:32'),
	(494, '63', '12805795188', 1, 0, 0, 300, '2023-01-18 13:10:42', '2023-01-18 13:10:42'),
	(495, '63', '12805795188', 3, 0, 0, 1, '2023-01-18 13:11:05', '2023-01-18 13:11:05'),
	(496, '64', '90984340601', 3, 0, 0, 0, '2023-01-18 13:18:03', '2023-01-18 13:18:03'),
	(497, '64', '90984340601', 1, 0, 0, 300, '2023-01-18 13:18:16', '2023-01-18 13:18:16'),
	(498, '64', '90984340601', 3, 0, 0, 1, '2023-01-18 13:18:56', '2023-01-18 13:18:56'),
	(499, '64', '72783282600', 3, 0, 0, 0, '2023-01-18 13:22:26', '2023-01-18 13:22:26'),
	(500, '64', '72783282600', 1, 0, 0, 1, '2023-01-18 13:22:38', '2023-01-18 13:22:38'),
	(501, '64', '90984340601', 3, 1, 0, 1, '2023-01-18 13:23:00', '2023-01-18 13:23:00'),
	(502, '64', '72783282600', 3, 1, 0, 1, '2023-01-18 13:23:00', '2023-01-18 13:23:00'),
	(503, '45', '1', 4, 0, 0, 1, '2023-01-31 08:28:34', '2023-01-31 08:28:34'),
	(504, '45', '22', 3, 0, 0, 1, '2023-01-31 08:49:33', '2023-01-31 08:49:33'),
	(505, '45', '22', 3, 0, 0, 1, '2023-01-31 08:50:21', '2023-01-31 08:50:21'),
	(506, '45', '23', 3, 0, 0, 1, '2023-01-31 08:52:20', '2023-01-31 08:52:20'),
	(507, '45', '23', 3, 1, 0, 1, '2023-01-31 08:53:03', '2023-01-31 08:53:03'),
	(508, '45', '22', 3, 0, 0, 1, '2023-01-31 08:53:16', '2023-01-31 08:53:16'),
	(509, '45', '23', 3, 0, 0, 1, '2023-01-31 09:04:48', '2023-01-31 09:04:48'),
	(510, '45', '23', 3, 0, 0, 1, '2023-01-31 09:05:28', '2023-01-31 09:05:28'),
	(511, '45', '22', 3, 0, 0, 1, '2023-01-31 09:06:33', '2023-01-31 09:06:33'),
	(512, '45', '13', 3, 1, 0, 3, '2023-01-31 10:02:43', '2023-01-31 10:02:43'),
	(513, '45', '1', 3, 1, 0, 1, '2023-01-31 10:02:43', '2023-01-31 10:02:43'),
	(514, '45', '23', 3, 1, 0, 1, '2023-01-31 10:02:43', '2023-01-31 10:02:43'),
	(515, '45', '23', 3, 1, 0, 3, '2023-01-31 10:22:12', '2023-01-31 10:22:12'),
	(516, '45', '22', 3, 1, 0, 2, '2023-01-31 10:22:12', '2023-01-31 10:22:12'),
	(517, '45', '13', 3, 1, 0, 2, '2023-01-31 10:22:12', '2023-01-31 10:22:12'),
	(518, '45', '1', 3, 1, 0, 3, '2023-01-31 10:22:12', '2023-01-31 10:22:12'),
	(519, '45', '58423217952', 3, 1, 0, 4, '2023-01-31 10:22:12', '2023-01-31 10:22:12'),
	(520, '45', '23', 3, 1, 0, 2, '2023-01-31 10:24:18', '2023-01-31 10:24:18'),
	(521, '45', '22', 3, 1, 0, 2, '2023-01-31 10:24:18', '2023-01-31 10:24:18'),
	(522, '45', '1', 3, 1, 0, 2, '2023-01-31 10:24:18', '2023-01-31 10:24:18'),
	(523, '45', '13', 3, 1, 0, 1, '2023-01-31 10:24:18', '2023-01-31 10:24:18'),
	(524, '45', '58423217952', 3, 1, 0, 2, '2023-01-31 10:24:18', '2023-01-31 10:24:18'),
	(525, '45', '22', 3, 1, 0, 1, '2023-01-31 10:28:47', '2023-01-31 10:28:47'),
	(526, '45', '23', 3, 1, 0, 1, '2023-01-31 10:28:47', '2023-01-31 10:28:47'),
	(527, '45', '23', 3, 0, 0, 3, '2023-01-31 10:54:45', '2023-01-31 10:54:45'),
	(528, '45', '23', 3, 0, 0, 1, '2023-01-31 10:55:17', '2023-01-31 10:55:17'),
	(529, '45', '23', 3, 0, 0, 56, '2023-02-01 10:14:41', '2023-02-01 10:14:41'),
	(530, '45', '21', 3, 0, 0, 2, '2023-02-01 10:14:41', '2023-02-01 10:14:41'),
	(531, '45', '1234', 3, 0, 0, 9, '2023-02-01 10:14:41', '2023-02-01 10:14:41'),
	(532, '45', '22', 3, 0, 0, 1, '2023-02-01 10:15:42', '2023-02-01 10:15:42'),
	(533, '45', '23', 3, 0, 0, 1, '2023-02-01 10:17:10', '2023-02-01 10:17:10'),
	(534, '45', '21', 3, 0, 0, 1, '2023-02-01 10:17:43', '2023-02-01 10:17:43'),
	(535, '45', '21', 2, 0, 0, 4, '2023-02-01 10:18:32', '2023-02-01 10:18:32'),
	(536, '45', '22', 3, 0, 0, 1, '2023-02-01 10:27:41', '2023-02-01 10:27:41'),
	(537, '45', '23', 3, 0, 1, 1, '2023-02-01 10:27:41', '2023-02-01 10:27:41'),
	(538, '45', '22', 3, 0, 0, 2, '2023-02-01 10:44:16', '2023-02-01 10:44:16'),
	(539, '45', '21', 3, 0, 7, 2, '2023-02-01 10:44:16', '2023-02-01 10:44:16'),
	(540, '45', '13', 3, 0, 0, 1, '2023-02-01 10:44:16', '2023-02-01 10:44:16'),
	(541, '45', '11', 3, 0, 1, 1, '2023-02-01 10:44:16', '2023-02-01 10:44:16'),
	(542, '45', '12', 3, 0, 1, 1, '2023-02-01 10:44:16', '2023-02-01 10:44:16');

-- Dumping structure for table cooperatives.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.migrations: ~7 rows (approximately)
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_11_02_090153_create_products_table', 1),
	(6, '2022_11_02_090408_create_histories_table', 1),
	(7, '2022_11_02_090507_create_logs_table', 1),
	(8, '2022_11_22_162656_create_borrows_table', 2),
	(9, '2022_11_23_165433_create_barcodes_table', 3),
	(10, '2022_12_01_185218_create_categories_table', 4),
	(11, '2022_12_12_150554_create_trades_table', 5),
	(12, '2023_01_09_225547_create_receipts_table', 6),
	(13, '2023_01_31_133052_create_departments_table', 7);

-- Dumping structure for table cooperatives.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.password_resets: ~0 rows (approximately)

-- Dumping structure for table cooperatives.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table cooperatives.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cooperative` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL DEFAULT 0,
  `serial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcodeGen` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` int(11) NOT NULL,
  `cost` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `sold` int(11) NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.products: ~19 rows (approximately)
INSERT IGNORE INTO `products` (`id`, `cooperative`, `categoryId`, `serial`, `barcodeGen`, `name`, `price`, `cost`, `quantity`, `added`, `sold`, `image`, `created_at`, `updated_at`) VALUES
	(138, 45, 3, '11', NULL, 'คุกกี้เนยสด - เล็ก', 100, 0, -1, 130, 1, '', '2022-12-01 17:41:50', '2023-02-01 10:44:16'),
	(139, 45, 4, '12', NULL, 'คุกกี้เนยสด - กลาง', 130, 130, -1, 101, 1, '', '2022-12-01 17:42:48', '2023-02-01 10:44:16'),
	(140, 45, 5, '13', NULL, 'คุกกี้เนยสด - ใหญ่', 180, 180, 17, 100, 33, '', '2022-12-01 17:43:42', '2023-02-01 10:44:16'),
	(141, 45, 6, '21', NULL, 'คุกกี้พรีเมียม - คอนเฟลก', 290, 290, -7, 100, 15, '', '2022-12-01 17:45:02', '2023-02-01 10:44:16'),
	(142, 45, 7, '22', NULL, 'คุกกี้พรีเมียม - เม็ดมะม่วง', 290, 290, 84, 100, 16, '', '2022-12-01 17:46:05', '2023-02-01 10:44:16'),
	(143, 45, 8, '23', NULL, 'คุกกี้พรีเมียม - มะพร้าว', 290, 290, -1, 100, 85, '', '2022-12-01 17:46:45', '2023-02-01 10:27:41'),
	(148, 45, 0, '1234', NULL, 'สินค้าไม่มีชื่อ', 0, 0, 0, 15, 11, '', '2022-12-05 11:05:14', '2023-02-01 10:14:41'),
	(149, 45, 10, '58423217952', NULL, 'โค้ก', 18, 15, 24, 30, 6, '', '2022-12-14 13:09:16', '2023-01-31 10:24:18'),
	(151, 46, 0, '33295650774', NULL, 'สินค้าไม่มีชื่อ', 0, 0, 0, 6, 1, '', '2022-12-15 12:38:36', '2022-12-16 13:14:40'),
	(152, 46, 0, '78550077917', NULL, 'สินค้าไม่มีชื่อ', 20, 0, 0, 15, 15, '', '2022-12-16 12:38:56', '2022-12-18 16:30:39'),
	(153, 45, 0, '99286748587', NULL, 'สินค้าไม่มีชื่อ', 0, 0, 0, 1, 1, '', '2022-12-21 19:01:19', '2023-01-09 16:25:03'),
	(154, 49, 13, '27734814796', NULL, 'โค้ก', 30, 0, 23, 30, 2, '', '2022-12-21 19:09:54', '2022-12-21 19:12:48'),
	(155, 58, 0, '1234', NULL, 'สินค้าไม่มีชื่อ', 50, 0, 1233, 1234, 1, '', '2023-01-09 17:18:33', '2023-01-09 17:18:45'),
	(156, 45, 0, '1', NULL, 'ทดสอบเพิ่มโดยแอดมิน', 15, 15, 8, 0, 6, '', '2023-01-18 06:41:33', '2023-01-31 10:24:18'),
	(157, 57, 14, '8279728146', NULL, 'โค้ก', 18, 12, 485, 500, 4, '', '2023-01-18 10:12:31', '2023-01-18 10:29:43'),
	(160, 62, 0, '59476269194', NULL, 'สินค้าไม่มีชื่อ', 15, 15, 14, 15, 1, '', '2023-01-18 11:04:18', '2023-01-18 11:04:55'),
	(161, 63, 0, '12805795188', NULL, 'สินค้าไม่มีชื่อ', 15, 10, 299, 300, 1, '', '2023-01-18 13:10:32', '2023-01-18 13:11:05'),
	(162, 64, 0, '90984340601', NULL, 'สินค้าไม่มีชื่อ', 15, 10, 298, 300, 2, '', '2023-01-18 13:18:03', '2023-01-18 13:23:00'),
	(163, 64, 0, '72783282600', NULL, 'สินค้าไม่มีชื่อ2', 15, 15, 0, 1, 1, '', '2023-01-18 13:22:26', '2023-01-18 13:23:00');

-- Dumping structure for table cooperatives.receipts
CREATE TABLE IF NOT EXISTS `receipts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` bigint(20) unsigned NOT NULL DEFAULT 0,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ค่าเช่า',
  `price` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.receipts: ~6 rows (approximately)
INSERT IGNORE INTO `receipts` (`id`, `cooperative`, `description`, `price`, `created_at`, `updated_at`) VALUES
	(1, 45, 'ค่าเช่ารายเดือน', 2400, '2023-01-09 19:13:28', '2023-01-09 19:13:28'),
	(2, 57, 'ค่าเช่ารายเดือน', 1234, '2023-01-09 20:17:11', '2023-01-09 20:17:11'),
	(3, 61, '15 วัน', 150, '2023-01-18 10:55:42', '2023-01-18 10:55:42'),
	(4, 62, '15 วัน', 150, '2023-01-18 11:02:40', '2023-01-18 11:02:40'),
	(5, 63, 'ค่าเช่ารายเดือน', 1500, '2023-01-18 13:09:16', '2023-01-18 13:09:16'),
	(6, 64, 'ค่าเช่ารายเดือน', 1500, '2023-01-18 13:17:27', '2023-01-18 13:17:27');

-- Dumping structure for table cooperatives.trades
CREATE TABLE IF NOT EXISTS `trades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooperative` int(11) NOT NULL,
  `trade_item` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trade_quantity` int(11) NOT NULL DEFAULT 0,
  `trade_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.trades: ~5 rows (approximately)
INSERT IGNORE INTO `trades` (`id`, `cooperative`, `trade_item`, `trade_quantity`, `trade_price`, `created_at`, `updated_at`) VALUES
	(4, 45, 'ขนมเลย์', 15, 1, '2022-12-12 08:37:35', '2022-12-12 08:37:35'),
	(5, 45, 'ขนมเลย์', 1, 1, '2022-12-12 08:37:44', '2022-12-12 08:37:44'),
	(6, 46, 'ขนมเลย์', 10, 1, '2022-12-12 08:57:03', '2022-12-12 08:57:03'),
	(7, 46, 'โค้ก', 15, 1, '2022-12-12 08:57:27', '2022-12-12 08:57:27'),
	(8, 46, 'ขนมเลย์', 25, 25, '2022-12-12 09:03:57', '2022-12-12 09:03:57'),
	(9, 45, 'ขนมเลย์', 20, 15, '2022-12-13 01:21:09', '2022-12-13 01:21:09'),
	(10, 45, 'ขนมเลย์', 1, 20, '2022-12-14 13:15:08', '2022-12-14 13:15:08');

-- Dumping structure for table cooperatives.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(0) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT 0,
  `grade` tinyint(4) NOT NULL DEFAULT 0,
  `allowed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `accountAge` datetime DEFAULT NULL,
  `lineToken` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lineId` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postalcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table cooperatives.users: ~17 rows (approximately)
INSERT IGNORE INTO `users` (`id`, `name`, `fullname`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `isAdmin`, `grade`, `allowed`, `created_at`, `updated_at`, `accountAge`, `lineToken`, `lineId`, `address`, `district`, `area`, `province`, `postalcode`, `tel`, `temp`) VALUES
	(44, '-', '-', 'admin', '-', NULL, '$2y$10$aE4WcAjkpFpf1wWWWbg0p.pyQzBogIbB6BdtpQwOT2fqHDLPq9JQC', NULL, 1, 0, 1, '2022-11-29 06:56:14', '2022-11-29 06:56:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(45, 'SVC Bakery', 'Achirawit Kaewkhong', 'svcCookie', '-', NULL, '$2y$10$FUdgpS.xMGjMSk0bj.HsX.u8TsuieJp8zJ7PVv.qTYENoEAZg9YEW', NULL, 0, 1, 1, '2022-11-29 06:59:00', '2023-01-31 08:11:20', '2023-02-28 00:00:00', NULL, 'thiswina', '39/2', 'ทุ่งเตาใหม่', 'บ้านนาสาร', 'สุราษฎร์ธานี', '84120', '0825324117', NULL),
	(46, 'SVC สหกรณ์', '-', 'svcCooperative', '-', NULL, '$2y$10$4ziGfXx1NICLhP31Uf5zWO0Rc144NNJKjRgaVNOeGGWPHRrF8SpSu', NULL, 0, 1, 1, '2022-11-29 06:59:00', '2022-12-18 16:25:52', '2022-11-29 13:59:00', '1234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(47, 'SVC ร้านค้า', '-', 'svcShop', '-', NULL, '$2y$10$fhkLeinn9gArmUI4YQKy3.dIyDO3YePmLdcskCNkytlixRj3HiNom', NULL, 0, 0, 1, '2022-11-29 06:59:40', '2022-11-29 06:59:51', '2023-02-28 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(48, 'Cookie', 'Achirawit Kaewkhong', '1234', '-', NULL, '$2y$10$NMcMS1o123q582FVSdYiceE2prKAjzDvnWuOcOx0AlfGEtV8H.iDy', NULL, -1, 1, 0, '2022-12-21 18:59:16', '2023-01-18 10:05:53', '2023-04-22 00:00:00', NULL, '@thiswina', NULL, NULL, NULL, NULL, NULL, '0825324117', NULL),
	(49, '1234', '1234', '123444', '-', NULL, '$2y$10$pS7Nyisz4loau2gzSFQxl.MIZW5I6rS.VdsPFXyhzOaF0maTbd8GK', NULL, -1, 1, 0, '2022-12-21 19:08:26', '2023-01-18 10:05:48', '2022-12-31 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(50, '12345', '12345', 'cookie', '-', NULL, '$2y$10$mAwpbaVx6C9MWL0E8Gm1VulzsKWNUuvMJjFVSx.9pridJJRXlnzm2', NULL, -1, 1, 0, '2023-01-09 07:03:19', '2023-01-18 10:04:45', '2022-11-29 13:59:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(51, '-', '-', 'Achirawit', '-', NULL, '$2y$10$dUg9zkx277Q11koHwIA6/O5exijOZjDHKs.8U8kT7r8AAsNfKhS9i', NULL, -1, 1, 0, '2023-01-09 07:05:33', '2023-01-18 10:05:34', '2023-01-09 15:54:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(56, '1234', 'นาย อชิรวิชฌ์ แก้วคง', 'Achirawit2', '-', NULL, '$2y$10$O7WctmSZ9FcMeNIkDXz9guXMvMbj5ih6hcv1gHv437YjYw2cbTYlG', NULL, 0, 1, 1, '2023-01-09 09:28:47', '2023-01-18 09:55:46', NULL, NULL, '@thiswina', '39/2 หมู่ 5', 'ทุ่งเตา', 'บ้านนาสาร', 'สุราษฎร์ธานี', NULL, '0825324117', NULL),
	(57, 'Syntech', 'Achirawit Kaewkhong', 'windesu', '-', NULL, '$2y$10$x1CTLr1vKEGjqU8tHRNtJu1sAg/IYJm0pDlSuMNeveqJAB9ZECdxu', NULL, 0, 1, 1, '2023-01-09 09:31:08', '2023-01-09 20:16:44', '2023-04-26 00:00:00', '123441234', 'thiswina', '39/2 หมู่ 5', 'ทุ่งเตาใหม่', 'บ้านนาสาร', 'สุราษฎร์ธานี', '84120', '0825324117', NULL),
	(58, 'SVC Mall', 'Achirawit Kaewkhong', 'mall12', '-', NULL, '$2y$10$3rVXcaEiwd8U62Y1lUrUEu5ZwV.jpxWDdHaABnu3zqZ/sW3Rv2b3K', NULL, 0, 1, 1, '2023-01-09 17:16:49', '2023-01-09 17:18:11', NULL, NULL, '@svcMall', 'svc', 'svc', 'svc', 'svc', 'svc', '0777777777', NULL),
	(59, '12341234', '12341234', 'achirawitkaewkhong', '-', NULL, '$2y$10$vdu6P4c3P1kP2alJIUEIUevXSBe6tcBatHdYt8T5DR6WURG7A61Fy', NULL, -1, 0, 1, '2023-01-18 06:39:52', '2023-01-18 10:05:22', NULL, NULL, '1234', '-', '-', '-', '-', '-', '1234567890', NULL),
	(60, '1234', 'ach', '12345666666', '-', NULL, '$2y$10$QMNrRuRQyY.syaN/.kF7xOyl7giwKxHnJPxbhkx3.zRqk6Us.DIHG', NULL, -1, 1, 0, '2023-01-18 10:00:52', '2023-01-18 10:05:42', '2023-01-31 00:00:00', NULL, '12345', '-', '-', '-', '-', '-', '1234567890', NULL),
	(61, 'Lek Shop', 'นาย อชิรวิชฌ์ แก้วคง', 'achirawit1234', '-', NULL, '$2y$10$YeAAPwGgAhThV64hkoogp.P8BEzNfKUrWB4SyDSjxZgylGeAVQQoK', NULL, 0, 0, 1, '2023-01-18 10:54:02', '2023-01-18 10:55:59', '2023-01-30 00:00:00', NULL, 'thiswina2', '39/2', 'ทุ่งเตาใหม่', 'บ้านนาสาร', 'สุราษฎร์ธานี', '84120', '0825324117', NULL),
	(62, 'Lek', 'achirawit', 'achix12', '-', NULL, '$2y$10$6lowxtiI1RxdSjwic73xy.41psBTHc1HV/sERM0FmdDtDSjxbuN0C', NULL, 0, 1, 1, '2023-01-18 11:02:00', '2023-01-18 11:02:44', '2023-01-31 00:00:00', NULL, 'wwinnnz', '-', '-', '-', '-', '-', '0825324117', NULL),
	(63, 'ShopMall', 'AchirawitKaewkhong', 'svcMalluser1', '-', NULL, '$2y$10$qt8QbTfc8nXHiMaDOQCzZ.ykIT/kaRjOTe8Y3MYze/neDw5cHXDZe', NULL, 0, 1, 1, '2023-01-18 13:08:28', '2023-01-18 13:09:21', '2023-04-30 00:00:00', NULL, 'Winnzdesu', '-', '-', '-', '-', '-', '0825324117', NULL),
	(64, 'WinShop', 'Achirawit Kaewkhong', 'mallachi', '-', NULL, '$2y$10$Ky9hL3C8OwpS/opFssrHiOAsdc/a.rNPAiN63gMKAUQXBzQgUgau.', NULL, 0, 1, 1, '2023-01-18 13:16:42', '2023-01-18 13:17:32', '2023-07-31 00:00:00', NULL, 'Winna', '-', '-', '-', '-', '-', '0825324117', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
