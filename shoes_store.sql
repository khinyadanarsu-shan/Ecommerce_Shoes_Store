-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 29, 2025 at 02:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoes_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Zay Yar Naing', 'zemmfang@gmail.com', 'Product quality is so good', '2025-05-28 13:45:56'),
(2, 'Rimm', 'rimmlv20@gmail.com', 'Can I ask you something ?', '2025-05-29 11:46:49'),
(3, 'Rimm', 'rimmlv20@gmail.com', 'Hello', '2025-05-29 12:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `payment_method`, `status`, `created_at`) VALUES
(2, 7, 119.99, 'Cash on Delivery', 'Pending', '2025-05-28 15:56:07'),
(3, 7, 119.99, 'Cash on Delivery', 'Pending', '2025-05-28 15:57:41'),
(4, 7, 119.99, 'Cash on Delivery', 'Pending', '2025-05-28 16:01:05'),
(5, 7, 75.00, 'Visa', 'Pending', '2025-05-28 16:02:39'),
(6, 12, 130.00, 'Cash on Delivery', 'Pending', '2025-05-28 16:05:41'),
(7, 12, 89.50, 'Visa', 'Pending', '2025-05-28 16:05:56'),
(8, 13, 89.50, 'Cash on Delivery', 'Pending', '2025-05-29 11:45:57'),
(9, 14, 119.99, 'Cash on Delivery', 'Pending', '2025-05-29 12:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 2, 1, 119.99),
(2, 3, 2, 1, 119.99),
(3, 4, 2, 1, 119.99),
(4, 5, 4, 1, 75.00),
(5, 6, 9, 1, 130.00),
(6, 7, 3, 1, 89.50),
(7, 8, 3, 1, 89.50),
(8, 9, 2, 1, 119.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `stock`) VALUES
(1, 'Nike Air Max', 99.99, 'Comfortable and stylish running shoes with Air Max cushioning.', 'img/nike.jpeg', 56),
(2, 'Adidas Ultraboost', 119.99, 'High performance running shoes with responsive Boost technology.', 'img/adidas.jpeg', 61),
(3, 'Puma RS-X', 89.50, 'Retro-style sneakers with RS cushioning and bold colorways.', 'img/puma.jpeg', 70),
(4, 'New Balance 574', 75.00, 'Classic and comfy everyday sneakers for walking and casual wear.', 'img/nb.jpeg', 65),
(5, 'Reebok Classic Leather', 70.00, 'Iconic leather sneakers for timeless street style.', 'img/reebook.jpeg', 61),
(6, 'Converse Chuck Taylor', 60.00, 'Canvas high-top sneakers perfect for everyday casual use.', 'img/converse.jpeg', 71),
(8, 'Under Armour HOVR Sonic', 110.00, 'Running shoes with HOVR foam for energy return and comfort.', 'img/hovr.jpeg', 68),
(9, 'ASICS Gel-Kayano', 130.00, 'Stability running shoes with GEL cushioning system.', 'img/asics.jpeg', 71),
(10, 'Fila Disruptor II', 85.00, 'Chunky sneakers with bold retro style and cushioned sole.', 'img/fila.jpeg', 72),
(11, 'Jordan Retro 4', 150.00, 'Classic Air Jordan sneakers with retro design and premium build.', 'img/jordan.jpeg', 58),
(12, 'Sketchers Go Walk', 69.99, 'Lightweight walking shoes with cushioned sole for all-day comfort.', 'img/sketcher.jpeg', 79);

-- --------------------------------------------------------

--
-- Table structure for table `shoes_size`
--

CREATE TABLE `shoes_size` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes_size`
--

INSERT INTO `shoes_size` (`id`, `product_id`, `size`, `stock`) VALUES
(1, 1, '37', 8),
(2, 1, '38', 10),
(3, 1, '39', 15),
(4, 1, '40', 8),
(5, 1, '41', 6),
(6, 1, '42', 4),
(7, 1, '43', 3),
(8, 1, '44', 2),
(9, 2, '37', 8),
(10, 2, '38', 13),
(11, 2, '39', 14),
(12, 2, '40', 9),
(13, 2, '41', 6),
(14, 2, '42', 5),
(15, 2, '43', 4),
(16, 2, '44', 2),
(17, 3, '37', 13),
(18, 3, '38', 14),
(19, 3, '39', 9),
(20, 3, '40', 10),
(21, 3, '41', 8),
(22, 3, '42', 7),
(23, 3, '43', 5),
(24, 3, '44', 4),
(25, 4, '37', 8),
(26, 4, '38', 10),
(27, 4, '39', 14),
(28, 4, '40', 10),
(29, 4, '41', 9),
(30, 4, '42', 7),
(31, 4, '43', 5),
(32, 4, '44', 2),
(33, 5, '37', 7),
(34, 5, '38', 9),
(35, 5, '39', 11),
(36, 5, '40', 12),
(37, 5, '41', 10),
(38, 5, '42', 6),
(39, 5, '43', 4),
(40, 5, '44', 2),
(41, 6, '37', 12),
(42, 6, '38', 14),
(43, 6, '39', 13),
(44, 6, '40', 10),
(45, 6, '41', 7),
(46, 6, '42', 7),
(47, 6, '43', 5),
(48, 6, '44', 3),
(57, 8, '37', 9),
(58, 8, '38', 11),
(59, 8, '39', 12),
(60, 8, '40', 12),
(61, 8, '41', 10),
(62, 8, '42', 6),
(63, 8, '43', 5),
(64, 8, '44', 3),
(65, 9, '37', 8),
(66, 9, '38', 9),
(67, 9, '39', 11),
(68, 9, '40', 14),
(69, 9, '41', 11),
(70, 9, '42', 8),
(71, 9, '43', 6),
(72, 9, '44', 4),
(73, 10, '37', 11),
(74, 10, '38', 13),
(75, 10, '39', 15),
(76, 10, '40', 10),
(77, 10, '41', 8),
(78, 10, '42', 7),
(79, 10, '43', 5),
(80, 10, '44', 3),
(81, 11, '37', 7),
(82, 11, '38', 8),
(83, 11, '39', 10),
(84, 11, '40', 12),
(85, 11, '41', 9),
(86, 11, '42', 6),
(87, 11, '43', 4),
(88, 11, '44', 2),
(89, 12, '37', 10),
(90, 12, '38', 12),
(91, 12, '39', 14),
(92, 12, '40', 13),
(93, 12, '41', 11),
(94, 12, '42', 8),
(95, 12, '43', 6),
(96, 12, '44', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(7, 'Zay Yar Naing', 'zemmfang@gmail.com', '$2y$10$94jK48qSjW09BlERvnsIo.f6V3ODM5TJbNgUlda5.CXPYvArFTUyG', 1),
(8, 'Khin Yadanar Hsu Shan', 'hsushan2162005@gmail.com', '$2y$10$lVqy0D01rM1WUSoO4R5g/.Z6e1wYoA2eQXbcXzO4jEYCKZkYDQjFO', 0),
(14, 'Rimm', 'rimmlv20@gmail.com', '$2y$10$Qibgq3IOaUrxhM9.o9FYEOH9hCmQ7J.CAjyQcfbOStwksfMrpMV4K', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoes_size`
--
ALTER TABLE `shoes_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `shoes_size`
--
ALTER TABLE `shoes_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `shoes_size`
--
ALTER TABLE `shoes_size`
  ADD CONSTRAINT `shoes_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
