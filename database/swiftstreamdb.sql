-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2024 at 11:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swiftstreamdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `account_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(320) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `default_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_details`
--

INSERT INTO `account_details` (`account_id`, `name`, `email`, `password`, `phone_no`, `type_id`, `created_on`, `default_location`) VALUES
(1, 'Sagun Ghimire', 'sagunghimire@gmail.com', '$2y$10$ypeLj6F7P2Da4WuoSGLCS.jZNbDyPxMRuf/bdWQ4qgWMkSjJZuYHG', '9810092754', 1, '2023-05-20 00:00:00', 'Basnettar, Kathmandu'),
(2, 'Nischal Basnet', 'nischalbasnet@gmail.com', '$2y$10$ypeLj6F7P2Da4WuoSGLCS.jZNbDyPxMRuf/bdWQ4qgWMkSjJZuYHG', '9869117848', 2, '2023-05-20 00:00:00', 'Phutung, Kathmandu'),
(3, 'Ram Bahadur', 'ram@gmail.com', '$2y$10$ypeLj6F7P2Da4WuoSGLCS.jZNbDyPxMRuf/bdWQ4qgWMkSjJZuYHG', '9766455446', 3, '2023-05-21 00:00:00', 'Banasthali, Kathmandu'),
(4, 'Shyam Kaji', 'shyam@gmail.com', '$2y$10$BBJqx/D5Lc6UvubJPkLbnun9abuiVDU249WCctS/vR9tcFGd3MmVy', '9860646900', 3, '2024-09-16 14:34:12', 'Nepaltar, Kathmandu');

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `type_id` int(11) NOT NULL,
  `type_name` enum('user','admin','delivery rider') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`type_id`, `type_name`) VALUES
(1, 'user'),
(2, 'admin'),
(3, 'delivery rider');

-- --------------------------------------------------------

--
-- Table structure for table `address_details`
--

CREATE TABLE `address_details` (
  `address_id` int(11) NOT NULL,
  `order_code` int(11) DEFAULT NULL,
  `address_type_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `address_type`
--

CREATE TABLE `address_type` (
  `address_type_id` int(11) NOT NULL,
  `address_type_name` enum('Pickup Address','Delivery Address') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address_type`
--

INSERT INTO `address_type` (`address_type_id`, `address_type_name`) VALUES
(1, 'Pickup Address'),
(2, 'Delivery Address');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status`
--

CREATE TABLE `delivery_status` (
  `status_id` int(11) NOT NULL,
  `status_name` enum('Pending for approval','Waiting for pickup','In Transit','Delivered','Canceled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_status`
--

INSERT INTO `delivery_status` (`status_id`, `status_name`) VALUES
(1, 'Pending for approval'),
(2, 'Waiting for pickup'),
(3, 'In Transit'),
(4, 'Delivered'),
(5, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `package_details`
--

CREATE TABLE `package_details` (
  `order_code` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `delivery_rider_id` int(11) DEFAULT NULL,
  `date_received` datetime DEFAULT NULL,
  `date_delivered` datetime DEFAULT NULL,
  `delivery_status_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `pickup_latitude` decimal(10,8) DEFAULT NULL,
  `pickup_longitude` decimal(11,8) DEFAULT NULL,
  `dropoff_latitude` decimal(10,8) DEFAULT NULL,
  `dropoff_longitude` decimal(11,8) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `date_assigned` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receiver_details`
--

CREATE TABLE `receiver_details` (
  `receiver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `idx_type_name` (`type_name`);

--
-- Indexes for table `address_details`
--
ALTER TABLE `address_details`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `idx_order_code` (`order_code`),
  ADD KEY `idx_address_type_id` (`address_type_id`);

--
-- Indexes for table `address_type`
--
ALTER TABLE `address_type`
  ADD PRIMARY KEY (`address_type_id`),
  ADD KEY `idx_type_name` (`address_type_name`);

--
-- Indexes for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `idx_status_name` (`status_name`);

--
-- Indexes for table `package_details`
--
ALTER TABLE `package_details`
  ADD PRIMARY KEY (`order_code`),
  ADD KEY `idx_account_id` (`account_id`),
  ADD KEY `idx_receiver_id` (`receiver_id`),
  ADD KEY `idx_delivery_rider_id` (`delivery_rider_id`),
  ADD KEY `idx_delivery_status_id` (`delivery_status_id`);

--
-- Indexes for table `receiver_details`
--
ALTER TABLE `receiver_details`
  ADD PRIMARY KEY (`receiver_id`),
  ADD KEY `idx_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_details`
--
ALTER TABLE `account_details`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `address_details`
--
ALTER TABLE `address_details`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `address_type`
--
ALTER TABLE `address_type`
  MODIFY `address_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `package_details`
--
ALTER TABLE `package_details`
  MODIFY `order_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `receiver_details`
--
ALTER TABLE `receiver_details`
  MODIFY `receiver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_details`
--
ALTER TABLE `account_details`
  ADD CONSTRAINT `account_details_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `account_type` (`type_id`) ON DELETE CASCADE;

--
-- Constraints for table `address_details`
--
ALTER TABLE `address_details`
  ADD CONSTRAINT `address_details_ibfk_1` FOREIGN KEY (`order_code`) REFERENCES `package_details` (`order_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `address_details_ibfk_2` FOREIGN KEY (`address_type_id`) REFERENCES `address_type` (`address_type_id`) ON DELETE CASCADE;

--
-- Constraints for table `package_details`
--
ALTER TABLE `package_details`
  ADD CONSTRAINT `package_details_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account_details` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_details_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `receiver_details` (`receiver_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_details_ibfk_3` FOREIGN KEY (`delivery_rider_id`) REFERENCES `account_details` (`account_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `package_details_ibfk_4` FOREIGN KEY (`delivery_status_id`) REFERENCES `delivery_status` (`status_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
