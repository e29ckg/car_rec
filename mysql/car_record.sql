-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2023 at 06:56 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_record`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `name`) VALUES
(1, 'รถโดยสาร (รถตู้) ทะเบียน ฮล  3114 กรุงเทพมหานคร'),
(3, 'รถโดยสาร(4ประตู) ทะเบียน 8 กพ 5540 กรุงเทพมหานคร'),
(4, 'รถจักรยานยนต์ ทะเบียน 5 กฉ 3822 กรุงเทพมหานคร');

-- --------------------------------------------------------

--
-- Table structure for table `car_driver`
--

CREATE TABLE `car_driver` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car_driver`
--

INSERT INTO `car_driver` (`id`, `user_id`) VALUES
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `car_rec`
--

CREATE TABLE `car_rec` (
  `id` int(11) NOT NULL,
  `book_number` int(11) DEFAULT NULL,
  `book_year` varchar(45) DEFAULT NULL,
  `req_date` date DEFAULT NULL,
  `user_req_id` int(11) DEFAULT NULL,
  `user_req_name` varchar(255) NOT NULL,
  `user_req_dep` varchar(255) NOT NULL,
  `user_req_workgroup` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `why` varchar(255) DEFAULT NULL,
  `followers_num` int(11) DEFAULT NULL,
  `use_begin` datetime DEFAULT NULL,
  `use_end` datetime DEFAULT NULL,
  `status` enum('อนุญาต','ไม่อนุญาต') DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `own_created` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `car_id` int(11) NOT NULL,
  `car_name` varchar(250) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_dep` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `car_rec`
--

INSERT INTO `car_rec` (`id`, `book_number`, `book_year`, `req_date`, `user_req_id`, `user_req_name`, `user_req_dep`, `user_req_workgroup`, `location_name`, `why`, `followers_num`, `use_begin`, `use_end`, `status`, `comment`, `own_created`, `updated_at`, `created_at`, `car_id`, `car_name`, `driver_id`, `driver_name`, `driver_dep`) VALUES
(2, 2, '2565', '2023-06-27', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ', NULL, '22', '22', 2, '2023-06-27 11:01:00', '2023-06-27 15:05:00', '', '', NULL, '2023-06-27 14:06:08', '2023-06-27 11:01:35', 1, '', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ'),
(4, 3, '2566', '2023-06-27', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ', 'ผู้อำนวยการฯ', 'ธนาคาร', 'ฝากเงิน', 3, '2023-06-27 04:00:00', '2023-06-27 11:06:00', '', '', NULL, '2023-06-28 11:52:42', '2023-06-27 11:06:04', 1, 'รถโดยสาร (รถตู้) ทะเบียน ฮล  3114 กรุงเทพมหานคร', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ'),
(8, 0, '2555', '2023-06-28', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ', 'ผู้อำนวยการฯ', '', '', 0, '2023-06-25 20:06:00', '2023-06-25 20:06:00', '', '', NULL, '2023-06-28 11:38:33', '2023-06-27 02:02:40', 1, 'รถโดยสาร (รถตู้) ทะเบียน ฮล  3114 กรุงเทพมหานคร', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ'),
(9, 0, '', '2023-06-28', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ', NULL, '', '', 0, '2023-06-27 14:08:00', '2023-06-27 14:08:00', '', '', NULL, '2023-06-28 09:06:51', '2023-06-27 02:08:05', 1, 'รถโดยสาร (รถตู้) ทะเบียน ฮล  3114 กรุงเทพมหานคร', 1, 'พเยาว์ สนพลาย ', 'เจ้าหน้าที่สารบรรณ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `car_driver`
--
ALTER TABLE `car_driver`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `car_rec`
--
ALTER TABLE `car_rec`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`,`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `car_driver`
--
ALTER TABLE `car_driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `car_rec`
--
ALTER TABLE `car_rec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
