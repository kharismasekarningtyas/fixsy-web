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
-- Table structure for table `input`
--

CREATE TABLE `input` (
  `id` int(11) NOT NULL,
  `departement` varchar(100) DEFAULT NULL,
  `asset_tag` varchar(100) DEFAULT NULL,
  `asset_name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `asset_user` varchar(100) DEFAULT NULL,
  `asset_admin` varchar(100) DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `device_merk` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `mac_address` varchar(100) DEFAULT NULL,
  `bios_version` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `input`
--

INSERT INTO `input` (`id`, `departement`, `asset_tag`, `asset_name`, `category`, `supplier`, `location`, `status`, `asset_user`, `asset_admin`, `manufacturer`, `model`, `maintenance_date`, `device_merk`, `serial_number`, `ip_address`, `mac_address`, `bios_version`) VALUES
(14, 'finance', 'SBI261580', 'laptop', '', '', 'Gedung B', '', 'Risma', '', '', '', '2025-05-12', 'Aspire 3 14', 'a2810s91sa', '192.168.12.110', '00-B0-D0-63-C2-26', '2022-10-19'),
(15, 'hrd', 'SBI1921018', 'Laptop', '', '', '', '', 'Sekar', '', '', '', '2025-05-08', 'Lenovo MT1 A', '1219192as', '192.168.12.122', 'A0-B0-D0-63-C2-12', '2025-05-01'),
(16, 'hrd', 'SBI9872012', 'Laptop', '', '', '', '', 'Sassa', '', '', '', '2025-05-02', 'Lenovo MT1 A', '19291291kkk', '192.168.12.132', 'A1-B0-D1-63-C2-14', '2025-05-01'),
(17, 'marketing', 'SBI8720127', 'Laptop', '', '', '', '', 'Are', '', '', '', '2024-12-02', 'Lenovo MT10', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F6', '2025-05-02'),
(18, 'hrd', 'SBI8720127', 'Laptop', '', '', 'Gedung B', '', 'Risma', '', '', '', '2025-05-02', 'Aspire 3 14', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F1', '2025-05-02'),
(19, 'hrd', 'SBI8720127', 'Laptop', '', '', 'Gedung B', '', 'Risma', '', '', '', '2024-11-30', 'Aspire 3 14', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F1', '2025-05-02'),
(20, 'marketing', 'SBI87201243', 'Laptop', '', '', '', '', 'Kar', '', '', '', '2024-12-28', 'Lenovo MT1 A', 'HDFH840000', '192.168.12.112', '1A:2B:3C:D4:E5:F0', '2025-05-08'),
(25, 'it', 'SBI87201248', 'Laptop', '', '', '', '', 'Sa', '', '', '', '2025-05-28', 'Lenovo MT1 A', 'HDFH840001', '192.168.12.119', '1A:2B:3C:D4:E5:F9', '2025-05-08'),
(28, 'it', 'SBI87201248', 'Laptop', '', '', '', '', 'Sa', '', '', '', '2025-06-28', 'Lenovo MT1 A', 'HDFH840003', '192.168.12.119', '1A:2B:3C:D4:E5:F9', '2025-05-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `input`
--
ALTER TABLE `input`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `input`
--
ALTER TABLE `input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
