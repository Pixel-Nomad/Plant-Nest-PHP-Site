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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.codes: ~0 rows (approximately)
DELETE FROM `codes`;

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
	(1, 'test1', 'description 1', 50, 20, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '0'),
	(2, 'test2', 'description 2', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1'),
	(3, 'test1', 'description 1', 50, 15, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1'),
	(4, 'test1', 'description 1', 50, 10, 'http://localhost/panel/assets/image/logos/logo3.png', 'no', '1'),
	(5, 'test1', 'description 1', 50, 8, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.users: ~11 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `contact`, `company`, `address`, `country`, `city`, `password`, `role`, `date`) VALUES
	(23, '9dgamer1', 'Tayyab Naseem', 'mr.tgamer247797704@gmail.com', '123456789', 'ajfw', 'my address 1', 'AL', 'karachi', 'ec4c8836db96b8aca8381c7c64bb095ba46d5e28', 'user', '2023-08-10 07:31:45'),
	(24, '9dgamer2', 'Tayyab Naseem', 'mr.tgamer247797701@gmail.com', '46546413215', 'asdasd', 'dfrsgdjfhs', 'AZ', 'usagfk', 'ec4c8836db96b8aca8381c7c64bb095ba46d5e28', 'user', '2023-08-10 07:33:23'),
	(25, '9dgamer3', 'Tayyab Naseem', 'Tayyab@idk.xyz', '12312312312', 'asddsda', 'asdasd', 'AF', 'dfvsafsa', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 07:34:57'),
	(26, '9dgamer4', 'Tayyab Naseem', 'mr.tgamer2477977@gmail.com', '1234563', 'adasda', 'asdasd', 'YT', 'asdsada', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user', '2023-08-10 07:42:07'),
	(27, 'jigty', 'ouityiu', 'jghhjg@hjgjhg.com', '56165665464', 'asdasd', 'my address 1', 'AU', 'lahore', '7c222fb2927d828af22f592134e8932480637c0d', 'user', '2023-08-10 07:48:14'),
	(28, 'asdfsafas', 'sfsdfs', 'sadfas@sdfvsd.com', '123412', 'sfgvsd', 'asffd', 'AU', 'fasdf', '85136c79cbf9fe36bb9d05d0639c70c265c18d37', 'user', '2023-08-10 07:53:43'),
	(29, 'sghbfhd', 'gdfgdfg', 'asdfasd@fdgfgdfg.com', '1234234234', 'sdfsdd', 'test address1', 'DZ', 'afsdadf', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 07:54:23'),
	(30, 'testtt', 'asda', 'asdasda@asdasd.com', '2432423', 'asdasd', 'test address1', 'AW', 'lahore', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 08:03:09'),
	(31, 'sdasdsad', 'asdasdas', 'adsfasd@adfasfsd.com', '423423423', 'fsdfsdf', 'sdfsfs', 'BS', 'sdfsfs', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 08:13:21'),
	(32, 'afasfsdfs', 'sdfsdfs', 'fsdfsdf@savgsdf.com', '12411243112', 'sdfsdf', 'sdfdsf', 'DZ', 'sdfsdfs', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 08:13:45'),
	(33, 'asdasdasd', 'asdasd', 'asdasd@asdasd.com', '12312423423', 'sdfsdfsd', 'fsdfsdfs', 'AZ', 'sdfsdfs', '601f1889667efaebb33b8c12572835da3f027f78', 'user', '2023-08-10 09:03:11'),
	(34, 'Hammad', 'Sir Hammad', 'mr.tgamer247797703@gmail.com', '03000000009', 'AP', 'aptech/clifton', '', 'karachi', '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'user', '2023-08-10 13:13:52');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
