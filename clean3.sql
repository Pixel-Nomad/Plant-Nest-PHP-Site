-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
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


-- Dumping database structure for plants
CREATE DATABASE IF NOT EXISTS `plants` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `plants`;

-- Dumping structure for table plants.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `plant_id` int(11) NOT NULL DEFAULT 0,
  `Quantity` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`cart_id`) USING BTREE,
  KEY `USER` (`user_id`) USING BTREE,
  KEY `Plants` (`plant_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.cart: ~0 rows (approximately)
DELETE FROM `cart`;

-- Dumping structure for table plants.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.category: ~6 rows (approximately)
DELETE FROM `category`;
INSERT INTO `category` (`category_id`, `Name`) VALUES
	(1, 'Flowering'),
	(2, 'Non-flowering'),
	(3, 'Indoor'),
	(4, 'Outdoor'),
	(5, 'Succulents'),
	(6, 'Medicinal');

-- Dumping structure for table plants.codes
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.codes: ~0 rows (approximately)
DELETE FROM `codes`;

-- Dumping structure for table plants.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `order_secret` varchar(50) NOT NULL DEFAULT '0',
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Total_Amount` int(11) NOT NULL DEFAULT 0,
  `Total_Price` int(11) NOT NULL DEFAULT 0,
  `Status` varchar(50) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`order_id`),
  KEY `USER` (`user_id`),
  KEY `Secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.orders: ~12 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`order_id`, `user_id`, `order_secret`, `OrderDate`, `Total_Amount`, `Total_Price`, `Status`) VALUES
	(1, 35, 'AyxELKb8RL', '2023-08-11 13:58:01', 2, 150, 'pending'),
	(2, 35, '7Jjv7JijiQ', '2023-08-11 13:59:17', 2, 150, 'pending'),
	(3, 35, 'BGV6yDBhxu', '2023-08-11 14:00:08', 2, 1500, 'pending'),
	(4, 35, '2FG9dNEkkA', '2023-08-11 14:10:54', 1, 885, 'pending'),
	(5, 35, 'usaNfsiGKI', '2023-08-11 14:20:31', 2, 1770, 'pending'),
	(6, 35, 'wAC2Dvenoz', '2023-08-11 14:24:47', 1, 295, 'pending'),
	(7, 35, 'dBaepdYI9o', '2023-08-11 15:24:27', 1, 885, 'pending'),
	(8, 35, 'Le38s3k1m5', '2023-08-11 15:33:10', 1, 59, 'pending'),
	(9, 35, 'ebRWnTju2A', '2023-08-11 15:33:26', 1, 1416, 'pending'),
	(10, 35, 'Cl1Rvx9JDf', '2023-08-11 15:36:45', 1, 59, 'pending'),
	(11, 35, 'I3bxwibFtu', '2023-08-11 15:37:02', 1, 59, 'pending'),
	(12, 35, 'rA1mcOFf5f', '2023-08-11 15:48:30', 1, 885, 'pending');

-- Dumping structure for table plants.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_secret` varchar(50) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `plant_id` (`plant_id`),
  KEY `secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.order_items: ~26 rows (approximately)
DELETE FROM `order_items`;
INSERT INTO `order_items` (`id`, `order_secret`, `plant_id`, `quantity`) VALUES
	(1, '8tK9DIq0eX', 1, 5),
	(2, '8tK9DIq0eX', 3, 5),
	(3, 'mScd8bUSOm', 1, 2),
	(4, 'mScd8bUSOm', 3, 1),
	(5, 'G3NKTCkZBU', 1, 2),
	(6, 'G3NKTCkZBU', 3, 1),
	(7, 'spw2WCjEca', 1, 2),
	(8, 'spw2WCjEca', 3, 1),
	(9, 'spw2WCjEca', 1, 2),
	(10, 'spw2WCjEca', 3, 1),
	(11, 'AyxELKb8RL', 1, 2),
	(12, 'AyxELKb8RL', 3, 1),
	(13, '7Jjv7JijiQ', 1, 2),
	(14, '7Jjv7JijiQ', 3, 1),
	(15, 'BGV6yDBhxu', 1, 15),
	(16, 'BGV6yDBhxu', 3, 15),
	(17, '2FG9dNEkkA', 2, 15),
	(18, 'usaNfsiGKI', 5, 15),
	(19, 'usaNfsiGKI', 1, 15),
	(20, 'wAC2Dvenoz', 3, 5),
	(21, 'dBaepdYI9o', 1, 15),
	(22, 'Le38s3k1m5', 2, 1),
	(23, 'ebRWnTju2A', 2, 24),
	(24, 'Cl1Rvx9JDf', 5, 1),
	(25, 'I3bxwibFtu', 5, 1),
	(26, 'rA1mcOFf5f', 4, 15);

-- Dumping structure for table plants.plants
CREATE TABLE IF NOT EXISTS `plants` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL DEFAULT '0',
  `featured` varchar(5) NOT NULL DEFAULT 'no',
  `category_id` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plant_id`),
  KEY `Index 2` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.plants: ~5 rows (approximately)
DELETE FROM `plants`;
INSERT INTO `plants` (`plant_id`, `name`, `description`, `price`, `quantity`, `image`, `featured`, `category_id`) VALUES
	(1, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '0'),
	(2, 'test2', 'description 2', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1'),
	(3, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1'),
	(4, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'no', '1'),
	(5, 'test1', 'description 1', 50, 12, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1');

-- Dumping structure for table plants.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.sliders: ~4 rows (approximately)
DELETE FROM `sliders`;
INSERT INTO `sliders` (`id`, `image`, `text`, `description`, `dark`) VALUES
	(1, 'http://localhost/panel/assets/image/sliders/1.jpg', 'slider 1', 'test description 1', 'no'),
	(2, 'http://localhost/panel/assets/image/sliders/2.jpg', 'slider 2', 'test description 2', 'no'),
	(3, 'http://localhost/panel/assets/image/sliders/3.jpg', 'slider 3', 'test description 3', 'no'),
	(4, 'http://localhost/panel/assets/image/sliders/3.jpg', 'slider 3', 'test description 3', 'no');

-- Dumping structure for table plants.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `contact`, `company`, `address`, `country`, `city`, `password`, `role`, `date`) VALUES
	(35, 'asd', 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', '123456', 'abcd', 'abcd', 'PK', 'karachi', 'df2983700ffecb52e6649f0cb3981b66537083a4', 'user', '2023-08-11 15:52:07');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
