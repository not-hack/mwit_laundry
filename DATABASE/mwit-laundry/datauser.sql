-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.0-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table mwit-laundry.datauser
CREATE TABLE IF NOT EXISTS `datauser` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `userID` varchar(10) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `DOM` int(255) DEFAULT NULL,
  `class` varchar(5) NOT NULL DEFAULT 'USER',
  `OTP` varchar(50) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL COMMENT '(Y-m-d H:i:s)',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '(Y-m-d H:i:s)',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mwit-laundry.datauser: ~1 rows (approximately)
INSERT INTO `datauser` (`ID`, `userID`, `password`, `firstname`, `lastname`, `email`, `gender`, `DOM`, `class`, `OTP`, `last_login`, `created_at`) VALUES
	(1, '00000', 'adcd7048512e64b48da55b027577886ee5a36350', 'test1', 'test1', 'test1@test.test', 'male', 9, 'USER', '(NULL)', NULL, NULL),
	(7, '00001', 'adcd7048512e64b48da55b027577886ee5a36350', 'test2', 'test2', 'test2@test.test', 'male', 9, 'USER', NULL, NULL, '2024-01-16 14:33:27');

/* Encrypt password [adcd7048512e64b48da55b027577886ee5a36350] = 123 */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
