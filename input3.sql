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
-- Table structure for table `input3`
--

CREATE TABLE `input3` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `antivirus` varchar(255) DEFAULT NULL,
  `office` varchar(255) DEFAULT NULL,
  `sap` tinyint(1) DEFAULT NULL,
  `chrome` tinyint(1) DEFAULT NULL,
  `acrobat` tinyint(1) DEFAULT NULL,
  `vnc` tinyint(1) DEFAULT NULL,
  `vlc` tinyint(1) DEFAULT NULL,
  `fp` tinyint(1) DEFAULT NULL,
  `pv` tinyint(1) DEFAULT NULL,
  `add_1` varchar(255) DEFAULT NULL,
  `add_2` varchar(255) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input3`
--

INSERT INTO `input3` (`id`, `asset_id`, `os`, `antivirus`, `office`, `sap`, `chrome`, `acrobat`, `vnc`, `vlc`, `fp`, `pv`, `add_1`, `add_2`, `uploaded_file`) VALUES
(9, 14, 'Windows 10 Pro', 'Symantec 14.3', 'Office 2013', 1, 1, 1, 1, 1, 1, 1, '', '', 'upload_6822a57992d6f9.72973872.jpg'),
(10, 15, 'Windows 10 Pro', 'Symantec 14.3', 'Office 2013', 1, 1, 0, 0, 0, 1, 0, '', '', 'upload_6822bf6e1a9fd1.64036621.jpg'),
(11, 16, 'Windows 10 Pro', 'Symantec 14.3', 'Office 2013', 1, 1, 1, 0, 1, 1, 0, '', '', 'upload_6822bfcbce25a9.31900054.jpg'),
(12, 17, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 1, 1, 1, 1, 1, '', '', 'upload_682d2a82a10c14.22404853.jpg'),
(13, 18, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 1, 1, 1, 1, '', '', 'upload_68333acdcbb792.72406128.jpg'),
(14, 19, 'Windows 10 Pro', 'Crowd Strike 14.5', '2013', 1, 1, 0, 1, 1, 0, 0, 'a', '', 'upload_68334501b35da3.30914153.png'),
(15, 20, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 1, 1, 1, 0, '', '', 'upload_6833f0ab329716.09726285.png'),
(20, 25, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 1, 1, 1, 1, 1, '', '', 'upload_68349d6ec2c9c0.61393408.png'),
(23, 28, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 1, 1, 1, 0, '', '', 'upload_68356e175b9f64.90118038.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `input3`
--
ALTER TABLE `input3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `input3`
--
ALTER TABLE `input3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `input3`
--
ALTER TABLE `input3`
  ADD CONSTRAINT `input3_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `input` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
