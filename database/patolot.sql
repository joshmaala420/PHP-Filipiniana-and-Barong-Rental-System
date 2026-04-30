-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 11:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

-- Create the database if it doesn't already exist
CREATE DATABASE IF NOT EXISTS `patolot`;

USE `patolot`;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patolot`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `username`, `password`) VALUES
(1, 'admin123@gmail.com', 'admin', '0192023a7bbd73250516f069df18b500'),
(2, 'admin101@gmail.com', 'admin2 ', '4297f44b13955235245b2497399d7a93');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_image` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(5) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `name`, `product_image`, `price`, `size`, `qty`, `created_at`, `status`) VALUES
(116, 7, 14, 'product 2', 'uploads/pro.jpg.jpg', 500.00, 'M', 6, '2024-11-14 23:58:42', 0),
(117, 7, 13, 'product 1', 'uploads/d2d62758-93bc-479d-87b6-f8ac12b7c3de.jpg', 500.00, 'L', 2, '2024-11-15 00:00:34', 0),
(118, 13, 14, 'product 2', 'uploads/pro.jpg.jpg', 500.00, 'M', 1, '2024-11-15 01:03:04', 0),
(170, 8, 14, 'product 2', 'uploads/pro.jpg.jpg', 500.00, 'M', 3, '2024-11-17 22:12:07', 0),
(171, 8, 14, 'product 2', 'uploads/pro.jpg.jpg', 500.00, 'S', 3, '2024-11-17 22:12:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `transaction_no` varchar(50) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `qty` int(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `user_id`, `product_name`, `product_image`, `transaction_no`, `size`, `qty`, `total`, `created_at`, `status`) VALUES
(250, 15, 8, 'product 3', 'uploads/p1.jpg', 'TRANS-673a6911a5e38', 'XL', 3, 1500.00, '2024-11-17 22:07:13', 1),
(251, 17, 8, 'product 5', 'uploads/1aac1cdd-b115-4466-b52d-62579c0c64b9.jpg', 'TRANS-673a6911a5e38', 'XL', 3, 1500.00, '2024-11-17 22:07:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(50) NOT NULL,
  `prod_title` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` int(5) NOT NULL,
  `size` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `prod_img` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `prod_title`, `description`, `price`, `size`, `qty`, `prod_img`) VALUES
(13, 'product 1', 'Good Quality', 500, '', 3, 'uploads/d2d62758-93bc-479d-87b6-f8ac12b7c3de.jpg'),
(14, 'product 2', 'Confortable, fashion , Good Quality', 500, 'X , S , L , XL', 5, 'uploads/pro.jpg.jpg'),
(15, 'product 3', 'Good Quality', 500, 'XS , S , M , L , XL', 8, 'uploads/p1.jpg'),
(16, 'product 4', 'Fashion', 500, 'XS , S , M , L , XL', 2, 'uploads/b5175460-3a35-4248-a02c-5f944c17aec0.jpg'),
(17, 'product 5', 'formal', 500, 'XS , S , M , L , XL', 3, 'uploads/1aac1cdd-b115-4466-b52d-62579c0c64b9.jpg'),
(18, 'product 6', 'Comfortable', 500, 'XS , S , M , L , XL', 4, 'uploads/p1s.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(109, 15, 8, 4, 'sasa\n', '2024-11-17 13:07:53'),
(110, 17, 8, 5, 'sasa', '2024-11-17 13:08:04'),
(111, NULL, 8, 5, 'hjgjhj\n', '2024-11-17 14:52:25'),
(112, NULL, 8, 4, 'sasa', '2024-11-17 14:52:48'),
(113, 14, 8, 5, 'sss', '2024-11-17 21:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `to_pay_orders`
--

CREATE TABLE `to_pay_orders` (
  `id` int(50) NOT NULL,
  `user_id` int(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `transaction_no` varchar(50) NOT NULL,
  `reference_no` varchar(250) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(50) NOT NULL,
  `date_r` date DEFAULT NULL,
  `time_r` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `to_pay_orders`
--

INSERT INTO `to_pay_orders` (`id`, `user_id`, `email`, `transaction_no`, `reference_no`, `qty`, `total`, `created_at`, `status`, `date_r`, `time_r`) VALUES
(82, 8, 'sample3@gmail.com', 'TRANS-673a6911a5e38', '45367', 3, 3000, '2024-11-17 22:28:24', 1, '2024-11-14', '06:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`) VALUES
(2, 'user1', 'user1@gmail.com ', 2314123, 'b59c67bf196a4758191e42f76670ceba'),
(3, 'bogart', 'bogart123@gmail.com ', 2312, '4297f44b13955235245b2497399d7a93'),
(4, 'marlo', 'marlo@gmail.com', 9365445551, '4297f44b13955235245b2497399d7a93'),
(5, 'boogie', 'boogie@gmail.com', 935131564, '4297f44b13955235245b2497399d7a93'),
(6, 'bogartds', 'bogartdsa@gmail.com', 12345678910, '4297f44b13955235245b2497399d7a93'),
(7, 'bogart33', 'testuser@example.com', 12345678910, '4297f44b13955235245b2497399d7a93'),
(8, 'sample3', 'sample3@gmail.com', 9019203940, '4297f44b13955235245b2497399d7a93');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `to_pay_orders`
--
ALTER TABLE `to_pay_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `to_pay_orders`
--
ALTER TABLE `to_pay_orders`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
