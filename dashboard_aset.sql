-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2025 at 04:19 PM
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
-- Table structure for table `handover`
--

CREATE TABLE `handover` (
  `id` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first` varchar(255) DEFAULT NULL,
  `second` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `handover`
--

INSERT INTO `handover` (`id`, `device_name`, `uploaded_file`, `created_at`, `first`, `second`) VALUES
(13, 'Laptop Acer Aspire 3 14', 'handover_6833db206d45a.1748228896.png', '2025-05-25 17:25:04', 'Risma', 'Sassa'),
(14, 'Laptop lenovo MT1', 'handover_6833528aab9486.18042047.png', '2025-05-25 17:25:30', 'Sassa', 'Risma');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `device_merk` varchar(100) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `archived_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `serial_number`, `device_merk`, `uploaded_file`, `archived_at`) VALUES
(5, 'HDFH840001', 'Lenovo MT1 A', '', '2025-05-26 23:57:18'),
(6, 'HDFH840003', 'Lenovo MT1 A', '', '2025-05-27 13:22:11'),
(7, 'HDFH840003', 'Lenovo MT1 A', '', '2025-05-27 14:47:35'),
(8, 'HDFH840007', 'Lenovo MT1 A', '', '2025-05-28 09:47:09');

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
(15, 'hrd', 'SBI1921018', 'Laptop', '', '', '', '', 'Sekar', '', '', '', '2025-05-08', 'Lenovo MT1 A', '1219192as', '192.168.12.122', 'A0-B0-D0-63-C2-12', '2025-05-01'),
(16, 'hrd', 'SBI9872012', 'Laptop', '', '', '', '', 'Sassa', '', '', '', '2025-05-02', 'Lenovo MT1 A', '19291291kkk', '192.168.12.132', 'A1-B0-D1-63-C2-14', '2025-05-01'),
(17, 'marketing', 'SBI8720127', 'Laptop', '', '', '', '', 'Are', '', '', '', '2024-12-02', 'Lenovo MT10', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F6', '2025-05-02'),
(18, 'hrd', 'SBI8720127', 'Laptop', '', '', 'Gedung B', '', 'Risma', '', '', '', '2025-05-02', 'Aspire 3 14', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F1', '2025-05-02'),
(19, 'hrd', 'SBI8720127', 'Laptop', '', '', 'Gedung B', '', 'Risma', '', '', '', '2024-11-30', 'Aspire 3 14', '17639na027', '192.167.227.9', '1A:2B:3C:D4:E5:F1', '2025-05-02'),
(20, 'marketing', 'SBI87201243', 'Laptop', '', '', '', '', 'Kar', '', '', '', '2024-12-28', 'Lenovo MT1 A', 'HDFH840000', '192.168.12.112', '1A:2B:3C:D4:E5:F0', '2025-05-08'),
(25, 'it', 'SBI87201248', 'Laptop', '', '', '', '', 'Shafadilla', '', '', '', '2025-05-28', 'Lenovo MT1 A', 'HDFH840001', '192.168.12.119', '1A:2B:3C:D4:E5:F9', '2025-05-08'),
(28, 'it', 'SBI87201248', 'Laptop', '', '', '', '', 'Sa', '', '', '', '2025-06-28', 'Lenovo MT1 A', 'HDFH840003', '192.168.12.119', '1A:2B:3C:D4:E5:F9', '2025-05-08'),
(30, 'marketing', 'SBI87201248', 'Laptop', '', '', '', '', 'Saputri', '', '', '', '2025-06-28', 'Lenovo MT1 A', 'HDFH840007', '192.168.12.119', '1A:2B:3C:D4:E5:A4', '2025-05-08');

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
(15, 15, 'Normal', '', 'Normal', '8 GB', 'Normal', '200 GB', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(16, 16, 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(17, 17, 'Normal', '', 'Normal', '8 GB', 'Normal', '250 GB', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(18, 18, 'normal', '', 'normal', '8 GB', 'normal', '250 GB', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', ''),
(19, 19, 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(20, 20, 'Normal', '', 'Normal', '8 GB', 'Normal', '200 GB', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', '', 'Normal', ''),
(25, 25, 'error', '', 'normal', '8 GB', 'normal', '250 GB', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', ''),
(28, 28, 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', ''),
(30, 30, 'error', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '', 'normal', '');

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
(15, 20, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 1, 1, 1, 0, '', '', 'upload_6833f0ab329716.09726285.png'),
(20, 25, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 1, 1, 1, 1, 1, '', '', 'upload_68349d6ec2c9c0.61393408.png'),
(23, 28, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 1, 1, 1, 0, '', '', 'upload_68356e175b9f64.90118038.png'),
(25, 30, 'Windows 10 Pro', 'Crowd Strike 14.5', 'Office 2013', 1, 1, 0, 0, 0, 1, 0, '', '', 'upload_6836792d811529.85873197.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('superadmin','admin','guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'Risma', '$2y$10$jPA4x.OSD/cezbE9g14O0uklnr.gm8v8rpYT0J902i/RW30UAP6Wy', 'superadmin'),
(8, 'Risma2', '$2y$10$e2muvDqXgwlmgUi4VdwEz.7QW8nyaF/dh2Q/DL4R0.5KorJMY13DK', 'admin'),
(9, 'Risma3', '$2y$10$COm2aYNG3b6L1Nvrbfr13OKRp7dRlLZcKqK/Jk9TDiviNkXBu6zf2', 'guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `handover`
--
ALTER TABLE `handover`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input`
--
ALTER TABLE `input`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input2`
--
ALTER TABLE `input2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `input3`
--
ALTER TABLE `input3`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `handover`
--
ALTER TABLE `handover`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `input`
--
ALTER TABLE `input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `input2`
--
ALTER TABLE `input2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `input3`
--
ALTER TABLE `input3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `input2`
--
ALTER TABLE `input2`
  ADD CONSTRAINT `input2_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `input` (`id`);

--
-- Constraints for table `input3`
--
ALTER TABLE `input3`
  ADD CONSTRAINT `input3_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `input` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
