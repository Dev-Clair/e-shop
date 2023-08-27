-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2023 at 03:11 PM
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
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` varchar(20) NOT NULL,
  `book_title` varchar(150) NOT NULL,
  `book_author` varchar(150) NOT NULL,
  `book_edition` varchar(10) NOT NULL,
  `book_price` decimal(10,2) NOT NULL,
  `book_qty` int(11) NOT NULL,
  `book_cover_image` blob DEFAULT NULL,
  `book_publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_title`, `book_author`, `book_edition`, `book_price`, `book_qty`, `book_cover_image`, `book_publication_date`) VALUES
('bk4904', 'The Great Gatsby', 'F. Scott Fitzgerald', '1st', 25.99, 50, NULL, '2022-01-15'),
('bk4905', 'To Kill a Mockingbird', 'Harper Lee', '2nd', 19.95, 30, NULL, '2021-08-10'),
('bk4906', 'The Catcher in the Rye', 'J.D. Salinger', '2nd', 10.05, 20, NULL, '2018-07-11'),
('bk4907', 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', '4th', 39.95, 15, NULL, '2015-12-03'),
('bk4908', 'The Alchemist', 'Paulo Coelho', '1st', 11.95, 55, NULL, '2016-06-03'),
('bk8233', 'The Great Gatsby', 'F. Scott Fitzgerald', '2nd', 35.00, 20, NULL, '2023-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_item_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `cart_item_qty` int(11) NOT NULL DEFAULT 1,
  `cart_item_price` decimal(10,2) NOT NULL,
  `cart_item_amt` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `order_amt` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `book_id`, `order_qty`, `order_amt`, `order_date`) VALUES
('ord1390', 'adm1692273698', 'bk4905', 2, 39.90, '2023-08-27 12:58:38'),
('ord3510', 'adm1692273698', 'bk4906', 2, 20.10, '2023-08-27 12:51:41'),
('ord7641', 'adm1692273698', 'bk4907', 1, 39.95, '2023-08-27 12:58:38'),
('ord9471', 'adm1692273698', 'bk4904', 1, 25.99, '2023-08-27 12:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `return_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `return_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_address` varchar(150) DEFAULT NULL,
  `user_role` enum('ADMIN','CUSTOMER') DEFAULT 'CUSTOMER',
  `user_account_status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_address`, `user_role`, `user_account_status`) VALUES
('adm1692273698', 'Samuel Aniogbu', 'aniogbu.samuel@yahoo.com', '$2y$10$SLg2grbpqptHKB0oyZfd9.Z5jscsEwu6Q3ZdOolBTzfWLW1iADrzm', 'C94, Street C6 Nicon Town Lekki, Lagos', 'ADMIN', 'Active'),
('cus1692273984', 'Wendy Uche', 'uche.wendy@yahoo.com', '$2y$10$qYgYSs5kAoJplU1URQ2Upu2zQWt/jaHMQIkTF.1yJyoJ9WRc.otSm', 'B10, Street B4 Nicon Town Lekki, Lagos', 'CUSTOMER', 'Active'),
('cus1692875364', 'Aley Eden', 'aleyeden25@yahoo.com', '$2y$10$FqzWbZ8Ysbc/dEpr9rcTnesiiIquE7BBbYtrIOMA13X61ChuXVESO', '20, Olorunfunmi Street Kosofe LGA, Lagos', 'CUSTOMER', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `returns_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
