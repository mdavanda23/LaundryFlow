-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2026 at 04:19 PM
-- Server version: 8.4.3
-- PHP Version: 8.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundryflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `address` text,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `points` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `address`, `gender`, `birth_date`, `points`, `created_at`, `updated_at`) VALUES
(1, 3, 'Jl. Ahmad Yani No.10', 'Male', '2003-05-10', 120, '2026-07-04 19:15:30', '2026-07-04 19:15:30'),
(2, 5, '', NULL, NULL, 0, '2026-07-04 22:09:47', '2026-07-04 22:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `customer_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Laundry Received', 'Your laundry has been received.', 1, '2026-07-04 19:16:27'),
(2, 1, 'Laundry Washing', 'Your laundry is now washing.', 0, '2026-07-04 19:16:27'),
(3, 1, 'Laundry Ready', 'Your laundry is ready to pick up.', 0, '2026-07-04 19:16:27'),
(4, 1, 'Payment Success', 'Payment completed successfully.', 1, '2026-07-04 19:16:27'),
(5, 1, 'Promo', 'Get 20% discount for Express Service!', 1, '2026-07-04 19:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `invoice` varchar(30) NOT NULL,
  `customer_id` int NOT NULL,
  `service_id` int NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `pickup_date` datetime DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `pickup_address` text,
  `status` enum('Pending','Received','Washing','Drying','Ironing','Ready','Completed','Cancelled') DEFAULT 'Pending',
  `subtotal` decimal(10,2) DEFAULT '0.00',
  `discount` decimal(10,2) DEFAULT '0.00',
  `total` decimal(10,2) DEFAULT '0.00',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice`, `customer_id`, `service_id`, `weight`, `pickup_date`, `finish_date`, `pickup_address`, `status`, `subtotal`, `discount`, `total`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV-240701', 1, 1, 4.50, '2026-07-01 09:00:00', '2026-07-03 10:00:00', NULL, 'Completed', 31500.00, 0.00, 31500.00, 'Regular customer', '2026-07-04 19:15:53', '2026-07-05 15:57:56'),
(2, 'INV-240702', 1, 2, 3.00, '2026-07-02 08:00:00', '2026-07-02 15:00:00', NULL, 'Ready', 36000.00, 5000.00, 31000.00, 'Express', '2026-07-04 19:15:53', '2026-07-04 19:15:53'),
(3, 'INV-240703', 1, 3, 6.00, '2026-07-02 11:00:00', '2026-07-03 17:00:00', NULL, 'Completed', 54000.00, 0.00, 54000.00, '', '2026-07-04 19:15:53', '2026-07-04 19:15:53'),
(4, 'INV-240704', 1, 4, 2.50, '2026-07-03 09:00:00', '2026-07-03 18:00:00', NULL, 'Received', 12500.00, 0.00, 12500.00, '', '2026-07-04 19:15:53', '2026-07-05 10:56:30'),
(6, 'INV-260705-DA22', 2, 4, 5.00, '2026-07-05 10:25:50', NULL, 'jl tank no 44', 'Completed', 25000.00, 0.00, 25000.00, '', '2026-07-05 03:25:50', '2026-07-05 16:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_logs`
--

CREATE TABLE `order_status_logs` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_status_logs`
--

INSERT INTO `order_status_logs` (`id`, `order_id`, `status`, `description`, `created_at`) VALUES
(1, 1, 'Received', 'Laundry received', '2026-07-04 19:16:07'),
(2, 1, 'Washing', 'Laundry is being washed', '2026-07-04 19:16:07'),
(3, 2, 'Received', 'Laundry received', '2026-07-04 19:16:07'),
(4, 2, 'Washing', 'Laundry is being washed', '2026-07-04 19:16:07'),
(5, 2, 'Drying', 'Laundry drying', '2026-07-04 19:16:07'),
(6, 2, 'Ironing', 'Laundry ironing', '2026-07-04 19:16:07'),
(7, 2, 'Ready', 'Ready for pickup', '2026-07-04 19:16:07'),
(8, 3, 'Received', 'Laundry received', '2026-07-04 19:16:07'),
(9, 3, 'Washing', 'Laundry washing', '2026-07-04 19:16:07'),
(10, 3, 'Drying', 'Laundry drying', '2026-07-04 19:16:07'),
(11, 3, 'Ironing', 'Laundry ironing', '2026-07-04 19:16:07'),
(12, 3, 'Completed', 'Order completed', '2026-07-04 19:16:07'),
(13, 6, 'Diterima', 'Order dibuat oleh customer', '2026-07-05 03:25:50'),
(14, 6, 'Diterima', 'Pembayaran QRIS berhasil', '2026-07-05 03:25:55'),
(15, 6, 'Pending', 'Status diubah oleh staff', '2026-07-05 10:53:51'),
(16, 6, 'Pending', 'Status diubah oleh staff', '2026-07-05 10:53:53'),
(17, 6, 'Pending', 'Status diubah oleh staff', '2026-07-05 10:53:59'),
(18, 6, 'Received', 'Status diubah oleh staff', '2026-07-05 10:54:04'),
(19, 6, 'Washing', 'Status diubah oleh staff', '2026-07-05 10:54:06'),
(20, 6, 'Pending', 'Status diubah oleh staff', '2026-07-05 10:54:09'),
(22, 1, 'Drying', 'Status diubah oleh staff', '2026-07-05 10:54:42'),
(23, 1, 'Ironing', 'Status diubah oleh staff', '2026-07-05 10:54:45'),
(24, 1, 'Ready', 'Status diubah oleh staff', '2026-07-05 10:54:48'),
(25, 6, 'Received', 'Status diubah oleh staff', '2026-07-05 10:55:13'),
(26, 6, 'Washing', 'Status diubah oleh staff', '2026-07-05 10:55:27'),
(27, 6, 'Drying', 'Status diubah oleh staff', '2026-07-05 10:55:54'),
(28, 6, 'Ironing', 'Status diubah oleh staff', '2026-07-05 10:56:13'),
(29, 4, 'Received', 'Status diubah oleh staff', '2026-07-05 10:56:30'),
(30, 4, 'Received', 'Status diubah oleh staff', '2026-07-05 10:56:33'),
(31, 1, 'Completed', 'Status diubah oleh staff', '2026-07-05 15:57:56'),
(32, 4, 'Received', 'Status diubah oleh staff', '2026-07-05 15:57:58'),
(33, 4, 'Received', 'Status diubah oleh staff', '2026-07-05 15:58:15'),
(34, 6, 'Ready', 'Status diubah oleh staff', '2026-07-05 16:01:45'),
(35, 6, 'Completed', 'Status diubah oleh staff', '2026-07-05 16:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_method` enum('Cash','QRIS','Transfer') DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `amount` decimal(10,2) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `amount`, `paid_at`, `created_at`) VALUES
(1, 1, 'Cash', 'Paid', 31500.00, '2026-07-01 09:00:00', '2026-07-04 19:16:17'),
(2, 2, 'QRIS', 'Paid', 31000.00, '2026-07-02 08:30:00', '2026-07-04 19:16:17'),
(3, 3, 'Transfer', 'Paid', 54000.00, '2026-07-02 11:00:00', '2026-07-04 19:16:17'),
(4, 4, 'Cash', 'Pending', 12500.00, NULL, '2026-07-04 19:16:17'),
(6, 6, 'QRIS', 'Paid', 25000.00, '2026-07-05 10:25:55', '2026-07-05 03:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2026-07-04 19:14:57', '2026-07-04 19:43:29'),
(2, 'staff', '2026-07-04 19:14:57', '2026-07-04 19:43:29'),
(3, 'customer', '2026-07-04 19:14:57', '2026-07-04 19:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price_per_kg` decimal(10,2) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price_per_kg`, `duration`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 'Standard washing service', 7000.00, '2 Days', '🧺', 'active', '2026-07-04 19:15:44', '2026-07-04 19:15:44'),
(2, 'Express', 'Finished within 6 hours', 12000.00, '6 Hours', '⚡', 'active', '2026-07-04 19:15:44', '2026-07-04 19:15:44'),
(3, 'Wash & Iron', 'Wash and ironing', 9000.00, '1 Day', '✨', 'active', '2026-07-04 19:15:44', '2026-07-04 19:15:44'),
(4, 'Iron Only', 'Ironing service only', 5000.00, '1 Day', '🔥', 'active', '2026-07-04 19:15:44', '2026-07-04 19:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `address` text,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `shop_name`, `address`, `phone`, `email`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'LaundryFlow', 'Jl. Sudirman No.100', '081234567890', 'admin@laundryflow.com', 'logo.png', '2026-07-04 19:16:37', '2026-07-04 19:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `phone`, `password`, `photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Administrator', 'admin@laundryflow.com', '081111111111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-07-04 19:15:22', '2026-07-05 11:47:44', NULL),
(2, 2, 'Kasir', 'cashier@laundryflow.com', '082222222222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'active', '2026-07-04 19:15:22', '2026-07-05 10:44:59', NULL),
(3, 3, 'Ramdan Moo', 'ramdan@gmail.com', '083333333333', '$2b$12$qw/3B4u/izfIgFvfgrAY9O7I2S69x1WnKKkYNboyPJFONKBrG8ZDi', NULL, 'active', '2026-07-04 19:15:22', '2026-07-04 19:43:29', NULL),
(4, 3, 'Radiva Maulidin Pratama', 'radivamaulidin30@gmail.com', '082129439463', '$2y$10$cLR2/pPXCplgbzlu0c4NYO52J3/9182FKiz7oRvEdBEdXOuCz228.', NULL, 'active', '2026-07-04 13:20:49', '2026-07-04 13:20:49', NULL),
(5, 3, 'Van', 'van@gmail.com', '0888888888', '$2y$12$9gg6qsRp56sK4zn11por5OkWxJmyoT9W/NTyT18kmubkYDfM3oUAK', NULL, 'active', '2026-07-04 22:09:47', '2026-07-04 22:09:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_user` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notification_customer` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice` (`invoice`),
  ADD KEY `fk_order_customer` (`customer_id`),
  ADD KEY `fk_order_service` (`service_id`);

--
-- Indexes for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status_order` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_order` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notification_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD CONSTRAINT `fk_status_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
