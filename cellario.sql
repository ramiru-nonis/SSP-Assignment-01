-- =====================================================
-- Cellario Database Schema
-- Luxury Electronics E-Commerce Platform
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- =====================================================
-- Table: users
-- =====================================================
CREATE TABLE `users` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `firstName`  varchar(50) NOT NULL,
  `lastName`   varchar(50) NOT NULL,
  `email`      varchar(255) NOT NULL,
  `password`   varchar(255) NOT NULL,
  `role`       enum('admin','customer') NOT NULL DEFAULT 'customer',
  `image_path` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Default admin account (password: admin123)
INSERT INTO `users` (`firstName`, `lastName`, `email`, `password`, `role`) VALUES
('Admin', 'Cellario', 'admin@cellario.com', '$2y$10$/2jijnIxoAoZ0ETUWoTs2OAXUve4IFhIaRD2DmBqvXh/fFgS.tHcu', 'admin');

-- =====================================================
-- Table: products
-- =====================================================
CREATE TABLE `products` (
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `adminID`     int(11) NOT NULL,
  `brand`       varchar(100) NOT NULL,
  `model_name`  varchar(150) NOT NULL,
  `category`    enum('smartphone','laptop','audio','accessory') NOT NULL,
  `description` text NOT NULL,
  `price`       decimal(10,2) NOT NULL,
  `stock`       int(11) NOT NULL DEFAULT 0,
  `status`      enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `adminID` (`adminID`),
  KEY `category` (`category`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Sample luxury products
INSERT INTO `products` (`adminID`, `brand`, `model_name`, `category`, `description`, `price`, `stock`, `status`) VALUES
(1, 'Apple', 'iPhone 15 Pro Max', 'smartphone', 'The ultimate iPhone with titanium design, A17 Pro chip, and an advanced camera system with 5x optical zoom. Available in Natural Titanium, Blue Titanium, White Titanium, and Black Titanium.', 1199.00, 15, 'active'),
(1, 'Samsung', 'Galaxy Z Fold 5', 'smartphone', 'Experience the future with the Galaxy Z Fold 5. A stunning foldable display, Snapdragon 8 Gen 2 processor, and a versatile multi-window system for ultimate productivity.', 1799.00, 8, 'active'),
(1, 'Apple', 'MacBook Pro 16-inch M3 Max', 'laptop', 'Supercharged by M3 Max, the MacBook Pro 16-inch delivers unprecedented performance with up to 30 CPU cores and 40 GPU cores. With up to 128GB unified memory.', 3499.00, 10, 'active'),
(1, 'Sony', 'WH-1000XM5', 'audio', 'Industry-leading noise cancellation with two processors and eight microphones. Up to 30 hours battery life. Crystal-clear hands-free calling with Precise Voice Pickup Technology.', 399.00, 25, 'active'),
(1, 'Bose', 'QuietComfort Ultra Headphones', 'audio', 'Bose QuietComfort Ultra Headphones feature world-class noise cancellation and Bose Immersive Audio for a deeply personal listening experience unlike any other.', 429.00, 18, 'active'),
(1, 'Bang & Olufsen', 'Beoplay H95', 'audio', 'Premium wireless headphones with best-in-class active noise cancellation, hand-stitched lambskin leather ear cushions, and up to 38 hours playtime.', 799.00, 5, 'active'),
(1, 'Apple', 'Apple Watch Ultra 2', 'accessory', 'The most rugged and capable Apple Watch ever. Titanium case, precision dual-frequency GPS, Action Button, and up to 60 hours battery life for the most extreme adventures.', 799.00, 12, 'active'),
(1, 'Samsung', 'Galaxy Tab S9 Ultra', 'laptop', 'The Galaxy Tab S9 Ultra features a massive 14.6-inch Dynamic AMOLED 2X display with 120Hz refresh rate and Snapdragon 8 Gen 2 for ultimate tablet performance.', 1199.00, 7, 'active');

-- =====================================================
-- Table: product_images
-- =====================================================
CREATE TABLE `product_images` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `is_main`    tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: cart
-- =====================================================
CREATE TABLE `cart` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `productID`  int(11) NOT NULL,
  `quantity`   int(11) NOT NULL DEFAULT 1,
  `added_at`   timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customerID` (`customerID`),
  KEY `productID` (`productID`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: favorites
-- =====================================================
CREATE TABLE `favorites` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `productID`  int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customerID` (`customerID`),
  KEY `productID` (`productID`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: billing
-- =====================================================
CREATE TABLE `billing` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `address`    text NOT NULL,
  `apartment`  varchar(255) DEFAULT NULL,
  `city`       varchar(100) NOT NULL,
  `country`    varchar(100) NOT NULL,
  `zipcode`    varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customerID` (`customerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =====================================================
-- Table: orders
-- =====================================================
CREATE TABLE `orders` (
  `id`         int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `productID`  int(11) NOT NULL,
  `quantity`   int(11) NOT NULL DEFAULT 1,
  `price`      decimal(10,2) NOT NULL,
  `status`     enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customerID` (`customerID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- =====================================================
-- Seed Product Images
-- =====================================================
INSERT INTO `product_images` (`product_id`, `image_path`, `is_main`) VALUES
(1, '/Celario_lite/cellario_lite/uploads/iphone.png', 1),
(2, '/Celario_lite/cellario_lite/uploads/fold.png', 1),
(3, '/Celario_lite/cellario_lite/uploads/macbook.png', 1),
(4, '/Celario_lite/cellario_lite/uploads/sony.png', 1),
(5, '/Celario_lite/cellario_lite/uploads/bose.png', 1),
(6, '/Celario_lite/cellario_lite/uploads/bo.png', 1),
(7, '/Celario_lite/cellario_lite/uploads/watch.png', 1),
(8, '/Celario_lite/cellario_lite/uploads/tab.png', 1);
