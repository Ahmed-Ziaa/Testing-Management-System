-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2025 at 05:47 PM
-- Server version: 8.0.42
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `revise` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `revise`, `created_at`) VALUES
(1, '1234567890', 'Electric Fuse', 'Rev-2', '2025-10-03 16:29:45'),
(2, '1234567891', 'Power Capacitor', 'Rev-1', '2025-10-03 16:29:45'),
(3, '1234567892', 'Resistor Pack', 'Rev-3', '2025-10-03 16:29:45'),
(4, '1234567893', 'Switch Gear', 'Rev-3', '2025-10-03 16:29:45'),
(5, '1234567894', 'Circuit Breaker', 'Rev-1', '2025-10-03 16:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int NOT NULL,
  `test_id` varchar(20) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `type_of_testing` varchar(100) NOT NULL,
  `tester_name` varchar(100) NOT NULL,
  `status` enum('pass','fail') NOT NULL,
  `remarks` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_id`, `product_id`, `type_of_testing`, `tester_name`, `status`, `remarks`, `created_at`) VALUES
(1, 'T202510020001', '1234567890', 'Load Test', 'Ali Khan', 'pass', 'Stable performance under load', '2025-10-03 16:34:24'),
(2, 'T202510020002', '1234567890', 'Heat Test', 'Sara Ahmed', 'fail', 'Overheating after 10 mins', '2025-10-03 16:34:24'),
(3, 'T202510020003', '1234567891', 'Voltage Test', 'Bilal Khan', 'pass', 'Meets required voltage range', '2025-10-03 16:34:24'),
(4, 'T202510020004', '1234567891', 'Endurance Test', 'Zaid Hussain', 'fail', 'Failed after 200 cycles', '2025-10-03 16:34:24'),
(5, 'T202510020005', '1234567892', 'Current Test', 'Zara Malik', 'pass', 'Current stable at max load', '2025-10-03 16:34:24'),
(6, 'T202510020006', '1234567892', 'Resistance Test', 'Ahmer Khan', 'pass', 'Resistance values within tolerance', '2025-10-03 16:34:24'),
(7, 'T202510020007', '1234567893', 'Durability Test', 'Fizza Asim', 'fail', 'Switch broke under stress', '2025-10-03 16:34:24'),
(8, 'T202510020008', '1234567893', 'Safety Test', 'Sara Rani', 'pass', 'Meets safety standards', '2025-10-03 16:34:24'),
(9, 'T202510020009', '1234567894', 'Load Test', 'Ahmad Afaq', 'fail', 'Circuit tripped under overload', '2025-10-03 16:34:24'),
(10, 'T202510020010', '1234567894', 'Functionality Test', 'Aliza Rehan', 'pass', 'Working as expected', '2025-10-03 16:34:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
