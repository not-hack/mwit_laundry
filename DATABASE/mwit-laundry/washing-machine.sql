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

-- Dumping structure for table mwit-laundry.washing-machine
CREATE TABLE IF NOT EXISTS `washing-machine` (
  `ID` int(255) NOT NULL AUTO_INCREMENT,
  `DOM` varchar(5) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'ready',
  `end_usetime` varchar(255) DEFAULT NULL,
  `current_user` varchar(10) DEFAULT NULL,
  `last_user` varchar(10) DEFAULT NULL,
  `alluse` int(255) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `userID_FK` (`last_user`),
  CONSTRAINT `userID_FK` FOREIGN KEY (`last_user`) REFERENCES `datauser` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mwit-laundry.washing-machine: ~3 rows (approximately)
INSERT INTO `washing-machine` (`ID`, `DOM`, `status`, `end_usetime`, `current_user`, `last_user`, `alluse`) VALUES
	(1, '9', 'ready', NULL, NULL, NULL, 0),
	(2, '9', 'working', '1706240305000', 's6609005', 's6609005', 0),
	(3, '7', 'ready', NULL, NULL, NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
