
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `crud` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crud`;

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(255) DEFAULT NULL,
    `last_name` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    `pesel` varchar(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Table of users';

DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `first_name`, `last_name`, `address`, `pesel`, `created_at`, `updated_at`) VALUES
	(1, 'Test1', 'Test1', 'Test address1', '88070717981', '2022-02-02 10:01:55', NULL),
    (2, 'Test2', 'Test2', 'Test address2', '22213108216', '2022-05-07 20:11:34', NULL),
    (3, 'Test3', 'Test3', 'Test address3', '87032727045', '2022-09-30 16:08:12', NULL),
    (4, 'Test4', 'Test4', 'Test address4', '98120852934', '2022-07-20 12:01:22', '2022-08-30 14:03:48'),
/*!40000 ALTER TABLE `users` ENABLE KEYS */;