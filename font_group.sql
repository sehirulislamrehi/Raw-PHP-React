-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 02:12 PM
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
-- Database: `font_group`
--

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `path` varchar(191) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `name`, `path`, `is_active`, `created_at`) VALUES
(33, 'chili\'s pepper', 'public/uploads/chilispepper.ttf', 1, '2024-09-12 19:56:51'),
(34, 'Walgreens Script (Free Version)', 'public/uploads/walgreensscriptfreeversion.ttf', 1, '2024-09-12 19:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `font_group`
--

CREATE TABLE `font_group` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `font_group`
--

INSERT INTO `font_group` (`id`, `name`, `is_active`, `created_at`) VALUES
(1, 'Example 1', 1, '2024-09-12 19:03:29'),
(5, 'Example 2', 1, '2024-09-13 14:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `font_group_data`
--

CREATE TABLE `font_group_data` (
  `id` int(11) NOT NULL,
  `font_group_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `font_id` int(11) NOT NULL,
  `specific_size` double(10,2) NOT NULL,
  `price_change` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `font_group_data`
--

INSERT INTO `font_group_data` (`id`, `font_group_id`, `name`, `font_id`, `specific_size`, `price_change`) VALUES
(2, 1, 'chili\'s pepper', 33, 5.00, 2.00),
(3, 5, 'Walgreens', 34, 44.00, 12.00),
(4, 5, 'chilis pepper', 33, 12.00, 11.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `font_group`
--
ALTER TABLE `font_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `font_group_data`
--
ALTER TABLE `font_group_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `font_group_data_font_group_id_foreign` (`font_group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `font_group`
--
ALTER TABLE `font_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `font_group_data`
--
ALTER TABLE `font_group_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
