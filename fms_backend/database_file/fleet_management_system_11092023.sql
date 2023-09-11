-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 11, 2023 at 07:40 AM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fleet_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=admin users, 1=staff users',
  `permissions` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'user.png',
  `view_all_data` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=only your data, 2=all data',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0 = inactive, 1 = active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `phone_no`, `email`, `password`, `type`, `permissions`, `image`, `view_all_data`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'admin', '03001234567', 'admin@gmail.com', '$2y$10$G2f5/.nVaCistb7Pah7nnu2kugwLlD/4D8KzO7wctvF8ROQZ8Bgnq', 0, NULL, 'user.png', 1, 1, '2022-11-08 17:29:08', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uen` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_address` text COLLATE utf8_unicode_ci,
  `pic_mobile_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_account_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic_nric` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pic_address` text COLLATE utf8_unicode_ci,
  `vehicle_rental_tatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=monthly rental, 2=Free rental, 3=own vehicle',
  `car_plateno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diesel_tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_project` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nric_front_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nric_back_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=inactive, 1= active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `uen`, `email`, `password`, `pic_name`, `company_address`, `pic_mobile_no`, `bank_account_no`, `pic_nric`, `pic_address`, `vehicle_rental_tatus`, `car_plateno`, `diesel_tag`, `driver_project`, `nric_front_side`, `nric_back_side`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Test user', '030414141414', 'd@gmail.com', '123456', '2023-09-09', '35021363636363', '01020304052023', 'lahore', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-08 13:32:13', 1, '2023-09-08 13:32:13', NULL, 1),
(3, 'Test user', '030414141414', 'd3d@gmail.com', '123456', '2023-09-09', '35021363636363', '01020304052023', 'lahore', '1', '1', 1, 'leo 1234', '454545', 'one, two', '123123_1694412054.png', '1231233_1694412054.jpg', '2023-09-11 06:00:54', 1, '2023-09-11 06:00:54', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

DROP TABLE IF EXISTS `drivers`;
CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nric` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `dob` date DEFAULT NULL,
  `bank_account_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `licence_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Motorcar/jeep, 2=non-commercial car, 3=commercial ',
  `driver_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=freelance, 2=Full Time Staff, 3=Sub-con',
  `joining_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `vehicle_rental_tatus` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=monthly rental, 2=Free rental, 3=own vehicle',
  `car_plateno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diesel_tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_project` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nric_front_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nric_back_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `licence_front_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `licence_back_side` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0=inactive, 1= active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone_no`, `email`, `password`, `nric`, `address`, `dob`, `bank_account_no`, `licence_type`, `driver_status`, `joining_date`, `end_date`, `vehicle_rental_tatus`, `car_plateno`, `diesel_tag`, `driver_project`, `nric_front_side`, `nric_back_side`, `licence_front_side`, `licence_back_side`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Abdul Waheed', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:54', 1, '2023-09-08 12:34:05', 1, 0),
(2, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:58', 1, '2023-09-08 12:32:58', NULL, 1),
(3, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:59', 1, '2023-09-08 12:32:59', NULL, 1),
(4, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:00', 1, '2023-09-08 12:33:00', NULL, 1),
(5, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:01', 1, '2023-09-08 12:33:01', NULL, 1),
(6, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:02', 1, '2023-09-08 12:33:02', NULL, 1),
(7, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:03', 1, '2023-09-08 12:33:03', NULL, 1),
(8, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:04', 1, '2023-09-08 12:33:04', NULL, 1),
(9, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:05', 1, '2023-09-08 12:33:05', NULL, 1),
(11, 'Test user', '030414141414', 'da@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 13:31:14', 1, '2023-09-08 13:31:14', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_tag` varchar(255) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `meta_tag`, `meta_key`, `meta_value`) VALUES
(1, 'project', 'site_title', 'Transport Directory'),
(2, 'project', 'short_site_title', 'T D'),
(3, 'project', 'site_logo', 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

DROP TABLE IF EXISTS `vehicle_types`;
CREATE TABLE IF NOT EXISTS `vehicle_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `vehicle_type`, `capacity`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, '6 Wheeler Half Body', '25000 KG', 1, '2022-09-15 09:19:40', '2022-09-19 11:12:51', 1, NULL),
(3, '6 Wheeler Full Body', '25000 KG', 1, '2022-09-16 09:51:14', '2022-09-19 11:12:37', 1, NULL),
(4, '10 Wheeler Full Body', '25000 KG', 1, '2022-09-19 11:04:16', '2022-09-19 11:12:18', 1, NULL),
(5, '10 Wheeler Half Body', '12000 KG', 1, '2022-09-19 11:07:51', '2022-09-19 11:12:02', 1, NULL),
(6, 'Trala Half  Body', '25000 KG', 1, '2022-09-19 11:08:29', '2022-09-19 11:11:40', 1, NULL),
(7, 'Trala Phatta Body', '25000 KG', 1, '2022-09-19 11:09:17', '2022-09-19 11:11:24', 1, NULL),
(8, 'Container 20 Feet', '25000 KG', 1, '2022-09-19 11:10:28', '2022-09-19 11:11:09', 1, NULL),
(9, 'Container 40 Feet', '50000 KG', 1, '2022-09-19 11:13:18', '2022-09-19 11:13:18', 1, NULL),
(10, 'No Bed Vehicle', '1000 KG', 1, '2022-09-19 11:15:08', '2022-11-10 08:42:45', 1, 1),
(13, '90-waheeler-Shey-zor', '100 Ton', 1, '2022-11-14 12:32:37', '2022-11-14 12:32:37', 10, NULL),
(14, 'Land Cruser', '5x5', 1, '2022-11-14 12:39:25', '2022-11-14 12:39:25', 12, NULL),
(15, '32-Waheeler Truck', '180-Mond', 1, '2022-11-14 14:10:31', '2022-11-14 14:10:48', 15, 15);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
