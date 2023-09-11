-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2023 at 12:39 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(9, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:05', 1, '2023-09-08 12:33:05', NULL, 1);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
