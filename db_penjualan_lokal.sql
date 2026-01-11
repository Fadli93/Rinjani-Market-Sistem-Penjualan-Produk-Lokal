-- -------------------------------------------------------- 
-- Host:                         127.0.0.1 
-- Server version:               12.1.2-MariaDB - MariaDB Server 
-- Server OS:                    Win64 
-- HeidiSQL Version:             12.11.0.7065 
-- -------------------------------------------------------- 

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; 
/*!40101 SET NAMES utf8 */; 
/*!50503 SET NAMES utf8mb4 */; 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */; 
/*!40103 SET TIME_ZONE='+00:00' */; 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */; 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */; 
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */; 


-- Dumping database structure for db_penjualan_lokal 
CREATE DATABASE IF NOT EXISTS `db_penjualan_lokal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */; 
USE `db_penjualan_lokal`; 

-- Dumping structure for table db_penjualan_lokal.categories 
CREATE TABLE IF NOT EXISTS `categories` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `name` varchar(100) NOT NULL, 
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(), 
  PRIMARY KEY (`id`) 
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.categories: ~5 rows (approximately) 
INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES 
	 (1, 'Fashion & Kain Nusantara', '2026-01-10 16:32:42'), 
	 (2, 'Kuliner & Makanan Khas', '2026-01-10 16:32:42'), 
	 (3, 'Kerajinan Tangan & Kriya', '2026-01-10 16:32:42'), 
	 (4, 'Kesehatan & Herbal', '2026-01-10 16:32:42'), 
	 (5, 'Dekorasi & Perabot Rumah', '2026-01-10 16:32:42'); 

-- Dumping structure for table db_penjualan_lokal.users 
CREATE TABLE IF NOT EXISTS `users` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `name` varchar(100) NOT NULL, 
  `email` varchar(100) DEFAULT NULL, 
  `phone` varchar(20) DEFAULT NULL, 
  `address` text DEFAULT NULL, 
  `gender` enum('L','P') DEFAULT NULL, 
  `birthdate` date DEFAULT NULL, 
  `image` varchar(255) DEFAULT 'default.jpg', 
  `username` varchar(50) NOT NULL, 
  `password` varchar(255) NOT NULL, 
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer', 
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(), 
  PRIMARY KEY (`id`), 
  UNIQUE KEY `username` (`username`) 
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.users: ~3 rows (approximately) 
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `gender`, `birthdate`, `image`, `username`, `password`, `role`, `created_at`) VALUES 
	 (1, 'Administrator', NULL, NULL, NULL, NULL, NULL, 'default.jpg', 'admin', '$2y$10$QYQCrAh/HoEb05y.Tw/zAujLoOIskjd2zeNyEFSXLrQ.8jtf8Ft0m', 'admin', '2026-01-10 15:56:36'), 
	 (2, 'Pelanggan', NULL, NULL, NULL, NULL, NULL, 'default.jpg', 'user', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', '2026-01-10 15:56:36'), 
	 (3, 'Fadli', 'fadlifadlan@gmail.com', '087863683025', 'Dusun Jaler Bat Desa Jurang Jaler, Kecamatan Praya Tengah, Kabupaten Lombok Tengah, NTB', 'L', '1987-01-11', 'profile_3.png', 'fadli123', '$2y$10$b7NyYye8La9VtZZ1jZNShO3nC7gs7Toxus8eOW7DX4m0Gn0nJAyWK', 'customer', '2026-01-10 17:15:08'); 

-- Dumping structure for table db_penjualan_lokal.products 
CREATE TABLE IF NOT EXISTS `products` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `category_id` int(11) NOT NULL, 
  `name` varchar(255) NOT NULL, 
  `description` text DEFAULT NULL, 
  `price` decimal(10,2) NOT NULL, 
  `stock` int(11) NOT NULL DEFAULT 0, 
  `image` varchar(255) DEFAULT NULL, 
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(), 
  PRIMARY KEY (`id`), 
  KEY `category_id` (`category_id`), 
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE 
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.products: ~5 rows (approximately) 
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`) VALUES 
	 (1, 3, 'Alas Gelas Hotel - Kerajinan Anyaman Ketak Lombok', 'Anyaman ketak mula-mula berkembang sekitar tahun 1986 di Desa Nyurbaya Gawah Kecamatan Narmada Kabupaten Lombok Barat, karena bahan baku yang berlimpah disana. Pada tahun 1988 pemerintah mulai melakukan pembinaan serta intensif berupa pelatihan keterampilan, pengembangan design, pameran baik lokal maupun nasional, sehingga produk anyaman ini dapat berkembang mulai dari Lombok Barat, Lombok Tengah ke Lombok Timur. ', 25000.00, 50, '1768063265_Aneka jenis dan model kerajinan anyaman ketak lombok.jpg', '2026-01-10 16:41:05'), 
	 (2, 3, 'Tas Cantik dari Anyaman Ketak Lombok', 'Anyaman ketak mula-mula berkembang sekitar tahun 1986 di Desa Nyurbaya Gawah Kecamatan Narmada Kabupaten Lombok Barat, karena bahan baku yang berlimpah disana. Pada tahun 1988 pemerintah mulai melakukan pembinaan serta intensif berupa pelatihan keterampilan, pengembangan design, pameran baik lokal maupun nasional, sehingga produk anyaman ini dapat berkembang mulai dari Lombok Barat, Lombok Tengah ke Lombok Timur. \r\n', 100000.00, 65, '1768063797_Jual Tas cantik dari Ketak Lombok.jpg', '2026-01-10 16:49:57'), 
	 (3, 3, 'Tas Unik dari anyaman Ketak', 'Anyaman ketak mula-mula berkembang sekitar tahun 1986 di Desa Nyurbaya Gawah Kecamatan Narmada Kabupaten Lombok Barat, karena bahan baku yang berlimpah disana. Pada tahun 1988 pemerintah mulai melakukan pembinaan serta intensif berupa pelatihan keterampilan, pengembangan design, pameran baik lokal maupun nasional, sehingga produk anyaman ini dapat berkembang mulai dari Lombok Barat, Lombok Tengah ke Lombok Timur. \r\n', 60000.00, 60, '1768063985_Tas unik dari anyaman ketak lombok.JPG', '2026-01-10 16:53:05'), 
	 (4, 3, 'Tas Etnik Lombok', 'Tas Etnik Lombok yang diproduksi oleh M_Creative, adalah salah satu produk tas lokal yang dikombinasikan dengan kain tenun songket lombok, sehingga menjadikan aura khas, estetik dan penuh makna. Tas etnik lombok ini diproduksi di Desa Bunut Baok, Kecamatan Praya, Kabupaten Lombok Tengah.', 50000.00, 80, '1768064761_Tas unik khas lombok.jpg', '2026-01-10 17:06:01'), 
	 (5, 1, 'Tenun Etnik Lombok Merah Hitam', 'Kain Tenun Blanket Tenun Etnik Tenun Lombok Tenun NTT Tenun Ikat Nusantara\r\nBelum ada penilaian', 130000.00, 20, '1768070530_tenun lombok.jpeg', '2026-01-10 18:42:10');

-- Dumping structure for table db_penjualan_lokal.orders 
CREATE TABLE IF NOT EXISTS `orders` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `user_id` int(11) NOT NULL, 
  `total_amount` decimal(10,2) NOT NULL, 
  `status` varchar(50) NOT NULL DEFAULT 'pending', 
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(), 
  `shipping_courier` varchar(50) DEFAULT NULL, 
  `shipping_cost` decimal(10,2) DEFAULT 0.00, 
  `payment_method` varchar(50) DEFAULT NULL, 
  `shipping_address` text DEFAULT NULL, 
  `payment_provider` varchar(100) DEFAULT NULL, 
  PRIMARY KEY (`id`), 
  KEY `user_id` (`user_id`), 
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE 
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.orders: ~2 rows (approximately) 
INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `shipping_courier`, `shipping_cost`, `payment_method`, `shipping_address`, `payment_provider`) VALUES 
	 (7, 3, 270000.00, 'pending_payment', '2026-01-10 21:46:25', 'SiCepat Halu', 10000.00, 'transfer', 'Dusun Jaler Bat Desa Jurang Jaler, Kecamatan Praya Tengah, Kabupaten Lombok Tengah, NTB', 'Bank BRI'), 
	 (8, 3, 370000.00, 'pending_payment', '2026-01-10 22:30:25', 'SiCepat Halu', 10000.00, 'transfer', 'Dusun Jaler Bat Desa Jurang Jaler, Kecamatan Praya Tengah, Kabupaten Lombok Tengah, NTB', 'DANA'); 

-- Dumping structure for table db_penjualan_lokal.order_items 
CREATE TABLE IF NOT EXISTS `order_items` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `order_id` int(11) NOT NULL, 
  `product_id` int(11) NOT NULL, 
  `quantity` int(11) NOT NULL, 
  `price` decimal(10,2) NOT NULL, 
  `subtotal` decimal(10,2) NOT NULL, 
  PRIMARY KEY (`id`), 
  KEY `order_id` (`order_id`), 
  KEY `product_id` (`product_id`), 
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE, 
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE 
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.order_items: ~3 rows (approximately) 
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES 
	 (12, 7, 5, 2, 130000.00, 260000.00), 
	 (13, 8, 5, 2, 130000.00, 260000.00), 
	 (14, 8, 4, 2, 50000.00, 100000.00);

-- Dumping structure for table db_penjualan_lokal.user_addresses 
CREATE TABLE IF NOT EXISTS `user_addresses` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `user_id` int(11) NOT NULL, 
  `recipient_name` varchar(100) NOT NULL, 
  `phone` varchar(20) NOT NULL, 
  `address` text NOT NULL, 
  `is_primary` tinyint(1) DEFAULT 0, 
  `created_at` timestamp NULL DEFAULT current_timestamp(), 
  PRIMARY KEY (`id`), 
  KEY `user_id` (`user_id`), 
  CONSTRAINT `1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE 
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.user_addresses: ~1 rows (approximately) 
INSERT INTO `user_addresses` (`id`, `user_id`, `recipient_name`, `phone`, `address`, `is_primary`, `created_at`) VALUES 
	 (1, 3, 'Fadli', '087778327975', 'Dusun Jaler Bat Desa Jurang Jaler, Kecamatan Praya Tengah, Kabupaten Lombok Tengah, NTB', 1, '2026-01-10 21:00:34'); 

-- Dumping structure for table db_penjualan_lokal.password_resets 
CREATE TABLE IF NOT EXISTS `password_resets` ( 
  `id` int(11) NOT NULL AUTO_INCREMENT, 
  `email` varchar(255) NOT NULL, 
  `token` varchar(255) NOT NULL, 
  `created_at` timestamp NULL DEFAULT current_timestamp(), 
  PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 

-- Dumping data for table db_penjualan_lokal.password_resets: ~0 rows (approximately) 

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */; 
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */; 
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */; 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */; 
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
