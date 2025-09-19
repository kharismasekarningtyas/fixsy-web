-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 02:26 PM
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
-- Database: `dashboard_aset`
--

-- --------------------------------------------------------

--
-- Table structure for table `input2`
--

CREATE TABLE `input2` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `monitor` varchar(255) DEFAULT NULL,
  `monitor_info` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `ram_info` varchar(255) DEFAULT NULL,
  `hardisk` varchar(255) DEFAULT NULL,
  `hardisk_info` varchar(255) DEFAULT NULL,
  `power` varchar(255) DEFAULT NULL,
  `power_info` varchar(255) DEFAULT NULL,
  `dvd` varchar(255) DEFAULT NULL,
  `dvd_info` varchar(255) DEFAULT NULL,
  `keyboard` varchar(255) DEFAULT NULL,
  `keyboard_info` varchar(255) DEFAULT NULL,
  `mouse` varchar(255) DEFAULT NULL,
  `mouse_info` varchar(255) DEFAULT NULL,
  `clean_device` varchar(255) DEFAULT NULL,
  `clean_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input2`
--

INSERT INTO `input2` (`id`, `asset_id`, `monitor`, `monitor_info`, `ram`, `ram_info`, `hardisk`, `hardisk_info`, `power`, `power_info`, `dvd`, `dvd_info`, `keyboard`, `keyboard_info`, `mouse`, `mouse_info`, `clean_device`, `clean_info`) VALUES
(14, 14, 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(15, 15, 'Normal', '', 'Normal', '8 GB', 'Normal', '200 GB', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(16, 16, 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(17, 17, 'normal', '', 'normal', '8 GB', 'normal', '250 GB', 'normal', '', 'error', '', 'normal', '', 'normal', '', 'normal', ''),
(18, 18, 'normal', '', 'normal', '8 GB', 'normal', '250 GB', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', ''),
(19, 19, 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(20, 20, 'error', '', 'normal', '8 GB', 'normal', '200 GB', 'normal', '', 'normal', '', 'normal', '', 'error', '', 'normal', ''),
(25, 25, 'error', '', 'normal', '8 GB', 'normal', '250 GB', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', ''),
(28, 28, 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `input2`
--
ALTER TABLE `input2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `input2`
--
ALTER TABLE `input2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `input2`
--
ALTER TABLE `input2`
  ADD CONSTRAINT `input2_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `input` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
