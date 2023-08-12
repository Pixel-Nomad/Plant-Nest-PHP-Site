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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.cart: ~0 rows (approximately)
DELETE FROM `cart`;

-- Dumping structure for table plants.category
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.category: ~12 rows (approximately)
DELETE FROM `category`;
INSERT INTO `category` (`category_id`, `Name`) VALUES
	(1, 'Flowering'),
	(2, 'Non-flowering'),
	(3, 'Indoor'),
	(4, 'Outdoor'),
	(5, 'Succulents'),
	(6, 'Medicinal'),
	(54, '1'),
	(55, '1'),
	(56, '1'),
	(57, '1'),
	(58, '1'),
	(59, '1');

-- Dumping structure for table plants.codes
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.codes: ~0 rows (approximately)
DELETE FROM `codes`;

-- Dumping structure for table plants.feedbacks
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `Feedback_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `satisfaction` varchar(50) NOT NULL DEFAULT '0',
  `message` longtext NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.feedbacks: ~12 rows (approximately)
DELETE FROM `feedbacks`;
INSERT INTO `feedbacks` (`id`, `user_id`, `Feedback_Date`, `satisfaction`, `message`) VALUES
	(5, 35, '2023-08-12 04:17:00', 'satisfied', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(6, 35, '2023-08-12 12:52:38', 'Neutral', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(7, 35, '2023-08-12 12:52:42', 'Neutral', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(8, 35, '2023-08-12 12:52:48', 'dissatisfied', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(9, 35, '2023-08-12 12:52:52', 'Very satisfied', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(10, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf'),
	(11, 35, '2023-08-12 13:56:03', 'Very satisfied', 'must improve your feedback page'),
	(12, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf'),
	(13, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf'),
	(14, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf'),
	(15, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf'),
	(16, 35, '2023-08-12 12:53:01', 'dissatisfied', 'sdfsdfsdfsdf');

-- Dumping structure for table plants.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `order_secret` varchar(50) NOT NULL DEFAULT '0',
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Total_Amount` int(11) NOT NULL DEFAULT 0,
  `Total_Price` int(11) NOT NULL DEFAULT 0,
  `Status` varchar(50) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `USER` (`user_id`),
  KEY `Secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.orders: ~15 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`order_id`, `user_id`, `order_secret`, `OrderDate`, `Total_Amount`, `Total_Price`, `Status`) VALUES
	(1, 35, 'AyxELKb8RL', '2023-08-11 08:58:01', 2, 150, 'Cancelled'),
	(2, 35, '7Jjv7JijiQ', '2023-08-11 08:59:17', 2, 150, 'Delivered'),
	(3, 35, 'BGV6yDBhxu', '2023-08-11 09:00:08', 2, 1500, 'Delivered'),
	(4, 35, '2FG9dNEkkA', '2023-08-11 09:10:54', 1, 885, 'Confirmed'),
	(5, 35, 'usaNfsiGKI', '2023-08-11 09:20:31', 2, 1770, 'Picked UP'),
	(6, 35, 'wAC2Dvenoz', '2023-08-11 09:24:47', 1, 295, 'On The Way'),
	(7, 35, 'dBaepdYI9o', '2023-08-11 10:24:27', 1, 885, 'Cancelled'),
	(8, 35, 'Le38s3k1m5', '2023-08-11 10:33:10', 1, 59, 'Cancelled'),
	(9, 35, 'ebRWnTju2A', '2023-08-11 10:33:26', 1, 1416, 'Cancelled'),
	(10, 35, 'Cl1Rvx9JDf', '2023-08-11 10:36:45', 1, 59, 'Cancelled'),
	(11, 35, 'I3bxwibFtu', '2023-08-11 10:37:02', 1, 59, 'Cancelled'),
	(12, 35, 'rA1mcOFf5f', '2023-08-11 10:48:30', 1, 885, 'Cancelled'),
	(16, 35, 'BfGc0jGTjz', '2023-08-12 04:20:18', 1, 708, 'Cancelled'),
	(17, 35, '5ZdMscNchG', '2023-08-12 13:58:30', 1, 118, 'On The Way'),
	(18, 35, 'QEhrvHSOYL', '2023-08-12 14:21:16', 0, 0, 'Cancelled'),
	(19, 35, 'v6CATuHH3R', '2023-08-12 15:29:15', 2, 826, 'Picked UP'),
	(20, 35, 'NpEWC9i3Mr', '2023-08-12 15:56:33', 1, 118, 'Pending'),
	(21, 35, 'mcPoU0YCzc', '2023-08-12 16:54:21', 1, 1180, 'Pending'),
	(22, 35, 'LgdfSiDMzA', '2023-08-12 17:01:11', 1, 590, 'Pending');

-- Dumping structure for table plants.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_secret` varchar(50) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `plant_id` (`plant_id`),
  KEY `secret` (`order_secret`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.order_items: ~31 rows (approximately)
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
	(26, 'rA1mcOFf5f', 4, 15),
	(30, 'BfGc0jGTjz', 5, 12),
	(31, '5ZdMscNchG', 7, 1),
	(32, 'QEhrvHSOYL', 7, 1),
	(33, 'v6CATuHH3R', 7, 2),
	(34, 'v6CATuHH3R', 6, 10),
	(35, 'NpEWC9i3Mr', 7, 1),
	(36, 'mcPoU0YCzc', 7, 10),
	(37, 'LgdfSiDMzA', 7, 5);

-- Dumping structure for table plants.plants
CREATE TABLE IF NOT EXISTS `plants` (
  `plant_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `image` longtext NOT NULL,
  `featured` varchar(5) NOT NULL DEFAULT 'no',
  `category_id` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plant_id`),
  KEY `Index 2` (`category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.plants: ~4 rows (approximately)
DELETE FROM `plants`;
INSERT INTO `plants` (`plant_id`, `name`, `description`, `price`, `quantity`, `image`, `featured`, `category_id`) VALUES
	(3, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '11'),
	(4, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'no', '4'),
	(5, 'test1', 'description 1', 50, 0, 'http://localhost/panel/assets/image/logos/logo3.png', 'yes', '11'),
	(6, 'test69', 'description69', 50, 0, 'https://media.istockphoto.com/id/1470130937/photo/young-plants-growing-in-a-crack-on-a-concrete-footpath-conquering-adversity-concept.webp?b=1&s=170667a&w=0&k=20&c=IRaA17rmaWOJkmjU_KD29jZo4E6ZtG0niRpIXQN17fc=', 'no', '4'),
	(7, 'product 1', 'product description 1', 100, 0, 'https://pixfeeds.com/images/8/331295/640-518728634-lady-fern.jpg', 'no', '4');

-- Dumping structure for table plants.reviews
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `Review_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `stars` int(11) NOT NULL DEFAULT 0,
  `review` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.reviews: ~4 rows (approximately)
DELETE FROM `reviews`;
INSERT INTO `reviews` (`id`, `plant_id`, `user_id`, `Review_Date`, `stars`, `review`) VALUES
	(4, 2, 35, '2023-08-12 04:17:46', 5, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(5, 1, 35, '2023-08-12 04:26:36', 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(6, 2, 35, '2023-08-12 05:47:31', 3, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(7, 3, 35, '2023-08-12 12:45:11', 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto eveniet delectus accusamus quaerat ratione error a laboriosam voluptas reprehenderit dolores similique voluptatibus, quis debitis quod minus in quos? Expedita, veritatis eaque error pariatur labore blanditiis molestiae natus facilis hic, porro sunt nostrum explicabo unde. Quos quibusdam dolor perferendis optio doloribus esse ratione praesentium tempore tempora eligendi ipsam quidem asperiores quam sequi ipsum eaque, nesciunt laboriosam rem a modi commodi nobis reprehenderit magni eos! Officiis quis dolor delectus ad inventore? Voluptatibus vero iste nostrum, perspiciatis adipisci cupiditate necessitatibus quod a unde alias maxime quae voluptate cumque harum numquam! Accusantium, molestiae fugiat!'),
	(8, 7, 35, '2023-08-12 13:55:22', 5, 'feedback'),
	(9, 4, 35, '2023-08-12 15:56:08', 5, 'gyhs');

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table plants.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `contact`, `company`, `address`, `country`, `city`, `password`, `role`, `date`) VALUES
	(35, '9dgamer', 'Tayyab Naseem', 'mr.tgamer247797703@gmail.com', '123456', 'abcd', 'abcd', 'PK', 'karachi', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'master', '2023-08-12 15:21:16');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
