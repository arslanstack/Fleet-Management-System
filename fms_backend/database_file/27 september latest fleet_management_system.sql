-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 03:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_type` int(4) NOT NULL DEFAULT 2,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=admin users, 1=staff users',
  `permissions` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'user.png',
  `view_all_data` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=only your data, 2=all data',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `phone_no`, `email`, `password`, `role_type`, `type`, `permissions`, `image`, `view_all_data`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'admin', '03001234567', 'admin@gmail.com', '$2y$10$G2f5/.nVaCistb7Pah7nnu2kugwLlD/4D8KzO7wctvF8ROQZ8Bgnq', 1, 0, NULL, 'user.png', 2, 1, '2022-11-08 17:29:08', 1, NULL, NULL),
(20, 'caleb', '+923134188721', 'calebjanaltair@gmail.com', '$2y$10$E.V4WNOjJ./DoBm6NNddPO4nO7g3alrMuf5oK0EvxbBI4hOTu2UPu', 2, 1, NULL, 'http://127.0.0.1:8000/assets/upload_images/Untitled design_1695384979.png', 1, 1, '2023-09-22 12:16:19', 1, '2023-09-22 12:16:19', NULL),
(26, 'backend1', '+923134188721', 'backend1gmail.com', '$2y$10$9R.vnFiunKOK4WzDhAfT4OlJ1qN5X/wg.KrXBqGTlpppYgrFa9xoy', 9, 1, NULL, 'http://127.0.0.1:8000/assets/upload_images/Untitled design_1695709219.png', 1, 1, '2023-09-26 06:20:19', 1, '2023-09-26 06:20:19', NULL),
(27, 'backend2', '+923134188721', 'backend2gmail.com', '$2y$10$df9ddCqLmQC1RTEZ/Bl7gehAglEkFOj2H9NWFQEKCZqojwKSULRFK', 8, 1, NULL, 'http://127.0.0.1:8000/assets/upload_images/Untitled design_1695709241.png', 1, 1, '2023-09-26 06:20:41', 1, '2023-09-26 06:20:41', NULL),
(28, 'backend3', '+923134188721', 'backend3gmail.com', '$2y$10$nHgu7l/swQ1/dmsp6xXWxu.vvfc1xCE7QeBB8caSofp5GgxQm5VpW', 10, 1, NULL, 'http://127.0.0.1:8000/assets/upload_images/Untitled design_1695709307.png', 1, 1, '2023-09-26 06:21:47', 1, '2023-09-26 06:21:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `allowances`
--

CREATE TABLE `allowances` (
  `id` int(11) NOT NULL,
  `allowance_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `allowances`
--

INSERT INTO `allowances` (`id`, `allowance_type`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(15, 'lorem', 'Test', 1, '2023-09-26 07:06:08', '2023-09-26 07:06:08', 1, NULL),
(16, 'ipsum', 'Test', 1, '2023-09-26 07:06:13', '2023-09-26 07:06:13', 1, NULL),
(17, 'donor', 'Test', 1, '2023-09-26 07:06:17', '2023-09-26 07:06:17', 1, NULL),
(18, 'amet', 'Test', 1, '2023-09-26 07:11:24', '2023-09-26 07:11:24', 1, NULL),
(19, 'brains', 'Test', 1, '2023-09-26 07:11:31', '2023-09-26 07:11:31', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `uen` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pic_name` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `pic_mobile_no` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `pic_nric` varchar(255) DEFAULT NULL,
  `pic_address` text DEFAULT NULL,
  `vehicle_rental_tatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=monthly rental, 2=Free rental, 3=own vehicle',
  `car_plateno` varchar(255) DEFAULT NULL,
  `diesel_tag` varchar(255) DEFAULT NULL,
  `driver_project` varchar(255) DEFAULT NULL,
  `nric_front_side` varchar(255) DEFAULT NULL,
  `nric_back_side` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1= active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `uen`, `email`, `password`, `pic_name`, `company_address`, `pic_mobile_no`, `bank_account_no`, `pic_nric`, `pic_address`, `vehicle_rental_tatus`, `car_plateno`, `diesel_tag`, `driver_project`, `nric_front_side`, `nric_back_side`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, 'Test user', '030414141414', 'd@gmail.com', '123456', '2023-09-09', '35021363636363', '01020304052023', 'lahore', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-08 13:32:13', 1, '2023-09-08 13:32:13', NULL, 1),
(3, 'Test user', '030414141414', 'd3d@gmail.com', '123456', '2023-09-09', '35021363636363', '01020304052023', 'lahore', '1', '1', 1, 'leo 1234', '454545', 'one, two', '123123_1694412054.png', '1231233_1694412054.jpg', '2023-09-11 06:00:54', 1, '2023-09-11 06:00:54', NULL, 1),
(5, 'PayPal', 'T09LL0001B', 'paypal@paypal.com', '12345678', 'Paypal CEO', '5 Temasek Blvd, #09-01 Suntec Tower Five, Singapore 038985', '01020304052023', 'T09LL0001B1288UAA1121', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-26 06:01:01', 1, '2023-09-26 06:01:01', NULL, 1),
(6, 'PayPal', 'T09LL0001B', 'paypal2@paypal.com', '12345678', 'Paypal CEO', '5 Temasek Blvd, #09-01 Suntec Tower Five, Singapore 038985', '01020304052023', 'T09LL0001B1288UAA1121', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-26 06:01:18', 1, '2023-09-26 06:01:18', NULL, 1),
(7, 'PayPal', 'T09LL0001B', 'paypal3@paypal.com', '12345678', 'Paypal CEO', '5 Temasek Blvd, #09-01 Suntec Tower Five, Singapore 038985', '01020304052023', 'T09LL0001B1288UAA1121', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-26 06:01:28', 1, '2023-09-26 06:01:28', NULL, 1),
(8, 'PayPal', 'T09LL0001B', 'paypal4@paypal.com', '12345678', 'Paypal CEO', '5 Temasek Blvd, #09-01 Suntec Tower Five, Singapore 038985', '01020304052023', 'T09LL0001B1288UAA1121', '1', '1', 1, 'leo 1234', '454545', 'one, two', '', '', '2023-09-26 06:01:34', 1, '2023-09-26 06:01:34', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `deduction_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `deduction_type`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Car', '650', 0, '2022-09-15 09:19:40', '2023-09-11 08:25:28', 1, 1),
(3, '6 Wheeler Full Body', '25000 KG', 1, '2022-09-16 09:51:14', '2022-09-19 11:12:37', 1, NULL),
(4, '10 Wheeler Full Body', '25000 KG', 1, '2022-09-19 11:04:16', '2022-09-19 11:12:18', 1, NULL),
(5, '10 Wheeler Half Body', '12000 KG', 1, '2022-09-19 11:07:51', '2022-09-19 11:12:02', 1, NULL),
(6, 'Trala Half  Body', '25000 KG', 1, '2022-09-19 11:08:29', '2022-09-19 11:11:40', 1, NULL),
(7, 'Trala Phatta Body', '25000 KG', 1, '2022-09-19 11:09:17', '2022-09-19 11:11:24', 1, NULL),
(8, 'Container 20 Feet', '25000 KG', 1, '2022-09-19 11:10:28', '2022-09-19 11:11:09', 1, NULL),
(9, 'Container 40 Feet', '50000 KG', 1, '2022-09-19 11:13:18', '2022-09-19 11:13:18', 1, NULL),
(10, 'No Bed Vehicle', '1000 KG', 1, '2022-09-19 11:15:08', '2022-11-10 08:42:45', 1, 1),
(13, '90-waheeler-Shey-zor', '100 Ton', 1, '2022-11-14 12:32:37', '2022-11-14 12:32:37', 10, NULL),
(14, 'Land Cruser', '5x5', 1, '2022-11-14 12:39:25', '2022-11-14 12:39:25', 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nric` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `licence_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Motorcar/jeep, 2=non-commercial car, 3=commercial ',
  `driver_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=freelance, 2=Full Time Staff, 3=Sub-con',
  `joining_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `vehicle_rental_tatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=monthly rental, 2=Free rental, 3=own vehicle',
  `car_plateno` varchar(255) DEFAULT NULL,
  `diesel_tag` varchar(255) DEFAULT NULL,
  `driver_project` varchar(255) DEFAULT NULL,
  `nric_front_side` varchar(255) DEFAULT NULL,
  `nric_back_side` varchar(255) DEFAULT NULL,
  `licence_front_side` varchar(255) DEFAULT NULL,
  `licence_back_side` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=inactive, 1= active',
  `profile` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone_no`, `email`, `password`, `nric`, `address`, `dob`, `bank_account_no`, `licence_type`, `driver_status`, `joining_date`, `end_date`, `vehicle_rental_tatus`, `car_plateno`, `diesel_tag`, `driver_project`, `nric_front_side`, `nric_back_side`, `licence_front_side`, `licence_back_side`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `profile`) VALUES
(1, 'Abdul Waheed', '03394008120', 'arslanstack@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:54', 1, '2023-09-20 12:49:51', 1, 0, NULL),
(2, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:58', 1, '2023-09-08 12:32:58', NULL, 1, NULL),
(3, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:59', 1, '2023-09-08 12:32:59', NULL, 1, NULL),
(4, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:00', 1, '2023-09-08 12:33:00', NULL, 1, NULL),
(5, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:01', 1, '2023-09-08 12:33:01', NULL, 1, NULL),
(6, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:02', 1, '2023-09-08 12:33:02', NULL, 1, NULL),
(7, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:03', 1, '2023-09-08 12:33:03', NULL, 1, NULL),
(8, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:04', 1, '2023-09-08 12:33:04', NULL, 1, NULL),
(9, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-19', NULL, 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:05', 1, '2023-09-13 13:35:26', 1, 1, NULL),
(11, 'Test user', '030414141414', 'da@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 13:31:14', 1, '2023-09-08 13:31:14', NULL, 1, NULL),
(12, 'test', '3452345243', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-13 13:40:43', NULL, '2023-09-13 13:40:43', NULL, 1, NULL),
(13, 'Test user', '030414141414', 'da333@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', NULL, 1, 'leo 1234', '454545', NULL, 'D:\\wamp64\\www\\fms\\fms_backend\\public\\/assets/upload_images123123_1694781329.png', '', '', '', '2023-09-15 12:35:29', 1, '2023-09-15 12:35:29', NULL, 1, NULL),
(14, 'Test user', '030414141414', 'da33333@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', NULL, 1, 'leo 1234', '454545', NULL, 'http://127.0.0.1:8000/assets/upload_imagesdesktop wallpaper_1694781776.png', '', '', '', '2023-09-15 12:42:56', 1, '2023-09-15 12:42:56', NULL, 1, NULL),
(15, 'Test user', '030414141414', 'da3333333@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', NULL, 1, 'leo 1234', '454545', NULL, 'http://127.0.0.1:8000/assets/upload_images/coding_1694781855.png', '', '', '', '2023-09-15 12:44:15', 1, '2023-09-15 12:44:15', NULL, 1, NULL),
(18, 'John Doe', '03394008123', 'calebjanaltair@gmail.com', '12345678', '3330198122441', 'Lahore Cantt, Pakistan', '2023-09-09', '090012331881', 1, 1, '2023-09-08', NULL, 1, 'LEQ 12311', '454545', NULL, '', '', '', '', '2023-09-26 05:49:45', 1, '2023-09-26 05:49:45', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_allowances`
--

CREATE TABLE `driver_allowances` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `allowance_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_allowances`
--

INSERT INTO `driver_allowances` (`id`, `driver_id`, `allowance_id`, `amount`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`) VALUES
(7, 2, 16, 500.00, 1, NULL, '2023-09-26 07:13:01', 1, '2023-09-26 07:13:01'),
(6, 1, 15, 500.00, 1, NULL, '2023-09-26 07:12:55', 1, '2023-09-26 07:12:55'),
(5, 18, 15, 500.00, 1, NULL, '2023-09-26 07:12:51', 1, '2023-09-26 07:12:51'),
(8, 3, 17, 500.00, 1, NULL, '2023-09-26 07:13:09', 1, '2023-09-26 07:13:09'),
(9, 4, 18, 500.00, 1, NULL, '2023-09-26 07:13:15', 1, '2023-09-26 07:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `driver_deductions`
--

CREATE TABLE `driver_deductions` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `deduction_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `effective_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `installment_months` int(11) NOT NULL DEFAULT 1,
  `paid_months` int(11) NOT NULL DEFAULT 0,
  `paid_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` double(10,2) NOT NULL DEFAULT 0.00
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_deductions`
--

INSERT INTO `driver_deductions` (`id`, `driver_id`, `deduction_id`, `amount`, `effective_date`, `description`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`, `installment_months`, `paid_months`, `paid_amount`, `remaining_amount`) VALUES
(17, 18, 10, 150.00, '2023-09-23', 'ill Discipline', 1, 1, '2023-09-26 11:59:04', 1, '2023-09-26 11:59:45', 2, 2, 150.00, 0.00),
(15, 18, 10, 2000.00, '2023-09-23', 'Drving under Influence', 1, NULL, '2023-09-26 11:04:54', 1, '2023-09-26 11:04:54', 4, 4, 2000.00, 0.00),
(14, 18, 10, 600.00, '2023-09-23', 'No seatbelt challan', 1, NULL, '2023-09-26 11:04:43', 1, '2023-09-26 11:04:43', 1, 1, 600.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `driver_salaries`
--

CREATE TABLE `driver_salaries` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `salary` double(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_salaries`
--

INSERT INTO `driver_salaries` (`id`, `driver_id`, `salary`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`) VALUES
(1, 1, 35000.00, 1, NULL, '2023-09-13 13:34:34', NULL, '2023-09-13 13:34:34'),
(2, 18, 100000.00, 1, NULL, '2023-09-26 07:13:45', 1, NULL),
(3, 2, 100000.00, 1, NULL, '2023-09-26 07:14:20', 1, NULL),
(4, 3, 100000.00, 1, NULL, '2023-09-26 07:14:23', 1, NULL),
(5, 4, 100000.00, 1, NULL, '2023-09-26 07:14:29', 1, NULL),
(6, 5, 100000.00, 1, NULL, '2023-09-26 07:14:32', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fuel_management`
--

CREATE TABLE `fuel_management` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `fuel_type` tinyint(4) NOT NULL DEFAULT 1,
  `quantity` double(10,2) NOT NULL DEFAULT 0.00,
  `cost_per_liter` double(10,2) NOT NULL DEFAULT 0.00,
  `fuel_cost` double(10,2) NOT NULL,
  `previous_meter_reading` double(10,2) NOT NULL DEFAULT 0.00,
  `current_meter_reading` double(10,2) NOT NULL DEFAULT 0.00,
  `fuel_avg` double(10,2) NOT NULL DEFAULT 0.00,
  `per_liter_avg` double(10,2) NOT NULL DEFAULT 0.00,
  `fuel_datetime` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fuel_management`
--

INSERT INTO `fuel_management` (`id`, `vehicle_id`, `driver_id`, `trip_id`, `fuel_type`, `quantity`, `cost_per_liter`, `fuel_cost`, `previous_meter_reading`, `current_meter_reading`, `fuel_avg`, `per_liter_avg`, `fuel_datetime`, `location`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 3, 18, 4, 1, 12.00, 12.00, 144.00, 0.00, 12.00, 0.00, 0.00, '2023-01-19 03:14:07', 'Singapore Chowk', 1, '2023-09-26 06:34:19', 1, '2023-09-26 06:34:19', NULL),
(3, 3, 18, 4, 2, 14.00, 12.00, 168.00, 0.00, 12.00, 0.00, 0.00, '2020-01-19 03:14:07', 'Singapore Chowk', 1, '2023-09-26 06:34:41', 1, '2023-09-26 06:34:41', NULL),
(4, 3, 18, 5, 3, 20.00, 12.00, 240.00, 0.00, 12.00, 0.00, 0.00, '2023-09-01 03:14:07', 'Singapore Chowk', 1, '2023-09-26 06:34:54', 1, '2023-09-26 06:34:54', NULL),
(5, 6, 12, 7, 4, 12.00, 12.00, 144.00, 0.00, 12.00, 0.00, 0.00, '2023-09-25 03:14:07', 'Singapore Chowk', 1, '2023-09-26 06:37:51', 1, '2023-09-26 06:37:51', NULL),
(6, 7, 12, 7, 5, 12.00, 12.00, 144.00, 0.00, 12.00, 0.00, 0.00, '2023-09-24 03:14:07', 'Singapore Chowk', 1, '2023-09-26 06:38:14', 1, '2023-09-26 06:38:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_types`
--

CREATE TABLE `maintenance_types` (
  `id` int(11) NOT NULL,
  `maintenance_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `maintenance_types`
--

INSERT INTO `maintenance_types` (`id`, `maintenance_type`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Car', '650', 0, '2022-09-15 09:19:40', '2023-09-11 08:25:28', 1, 1),
(3, '6 Wheeler Full Body', '25000 KG', 1, '2022-09-16 09:51:14', '2022-09-19 11:12:37', 1, NULL),
(4, '10 Wheeler Full Body', '25000 KG', 1, '2022-09-19 11:04:16', '2022-09-19 11:12:18', 1, NULL),
(5, '10 Wheeler Half Body', '12000 KG', 1, '2022-09-19 11:07:51', '2022-09-19 11:12:02', 1, NULL),
(6, 'Trala Half  Body', '25000 KG', 1, '2022-09-19 11:08:29', '2022-09-19 11:11:40', 1, NULL),
(7, 'Trala Phatta Body', '25000 KG', 1, '2022-09-19 11:09:17', '2022-09-19 11:11:24', 1, NULL),
(8, 'Container 20 Feet', '25000 KG', 1, '2022-09-19 11:10:28', '2022-09-19 11:11:09', 1, NULL),
(9, 'Container 40 Feet', '50000 KG', 1, '2022-09-19 11:13:18', '2022-09-19 11:13:18', 1, NULL),
(10, 'No Bed Vehicle', '1000 KG', 1, '2022-09-19 11:15:08', '2022-11-10 08:42:45', 1, 1),
(13, '90-waheeler-Shey-zor', '100 Ton', 1, '2022-11-14 12:32:37', '2022-11-14 12:32:37', 10, NULL),
(14, 'Land Cruser', '5x5', 1, '2022-11-14 12:39:25', '2022-11-14 12:39:25', 12, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(14, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(15, '2023_09_20_123311_add_company_id_to_vehicle_maintenance', 1),
(16, '2023_09_21_074543_create_projects_table', 2),
(17, '2023_09_21_075153_create_trips_table', 2),
(18, '2023_09_21_082633_add_status_to_trips', 3),
(19, '2023_09_22_054843_add_role_type_to_admin_users', 4),
(20, '2023_09_22_055147_create_roles_table', 5),
(21, '2023_09_26_085624_add_installment_fields_to_driver_deductions_table', 6),
(22, '2023_09_27_081309_add_trip_id_to_feul_management_table', 7),
(23, '2023_09_27_081653_add_trip_id_to_vehicle_maintenance_table', 8),
(24, '2023_09_27_104336_add_company_id_to_trips_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 'Test Project 1', 'Lorem Ipsum', 1, 1, NULL, '2023-09-25 05:22:59', '2023-09-25 05:22:59'),
(7, 'Test Project 2', 'Lorem Ipsum', 1, 1, NULL, '2023-09-25 05:23:03', '2023-09-25 05:23:03'),
(8, 'Test Project 3', 'Lorem Ipsum', 1, 1, NULL, '2023-09-04 05:23:06', '2023-09-25 05:23:06'),
(9, 'Test Project 4', 'Lorem Ipsum', 1, 1, NULL, '2023-07-25 05:23:10', '2023-09-25 05:23:10'),
(10, 'Test Project 5', 'Lorem Ipsum', 1, 1, NULL, '2021-09-25 05:23:13', '2023-09-25 05:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `road_tax_expiry`
--

CREATE TABLE `road_tax_expiry` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `road_tax_expiry`
--

INSERT INTO `road_tax_expiry` (`id`, `vehicle_id`, `expiry_date`, `renewal_date`, `description`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, '2023-09-12', '2024-09-12', 'Test', 1, '2023-09-26 06:55:09', 1, '2023-09-26 06:55:09', NULL),
(2, 4, '2023-09-12', '2024-09-12', 'Test', 1, '2023-09-26 06:55:13', 1, '2023-09-26 06:55:13', NULL),
(3, 5, '2023-09-12', '2024-09-12', 'Test', 1, '2023-09-26 06:55:16', 1, '2023-09-26 06:55:16', NULL),
(4, 6, '2023-09-12', '2024-09-12', 'Test', 1, '2023-09-26 06:55:19', 1, '2023-09-26 06:55:19', NULL),
(5, 7, '2023-09-12', '2024-09-12', 'Test', 1, '2023-09-26 06:55:23', 1, '2023-09-26 06:55:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `permissions` text DEFAULT NULL,
  `full_access` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1: Yes, 0: No',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Active, 0: Inactive',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `permissions`, `full_access`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'manage_drivers, manage_company, manage_staff, change_staff, manage_role, manage_project, manage_trip, manage_vehicle_type, manage_vehicles, manage_fuel_management, manage_maintenance_type, manage_vehicle_maintenance, manage_vehicle_inspection, manage_vpc, manage_roadtax, manage_deduction_type, manage_deductions, manage_allowance_type, manage_allowances', 1, 1, 1, 1, '2023-09-22 01:43:55', '2023-09-22 03:09:43'),
(2, 'Admin', 'manage_drivers, manage_company, manage_staff, manage_role, manage_project, manage_trip, manage_vehicle_type, manage_vehicles, manage_fuel_management, manage_maintenance_type, manage_vehicle_maintenance, manage_vehicle_inspection, manage_vpc, manage_roadtax, manage_deduction_type, manage_deductions, manage_allowance_type, manage_allowances', 0, 1, 1, 20, '2023-09-22 01:46:53', '2023-09-22 08:15:49'),
(8, 'Admin 3', 'manage_drivers, manage_fuel_management', 0, 1, 1, NULL, '2023-09-26 01:11:58', '2023-09-26 01:11:58'),
(9, 'Admin 2', 'manage_drivers, manage_deduction_type, manage_deductions, manage_allowance_type, manage_allowances', 0, 1, 1, NULL, '2023-09-26 01:12:57', '2023-09-26 01:12:57'),
(10, 'Admin 1', 'manage_drivers, manage_vehicles, manage_maintenance_type, manage_vehicle_maintenance, manage_vehicle_inspection', 0, 1, 1, NULL, '2023-09-26 01:13:53', '2023-09-26 01:13:53');

-- --------------------------------------------------------

--
-- Table structure for table `salary_payroll`
--

CREATE TABLE `salary_payroll` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `basic_salary` double(10,2) NOT NULL DEFAULT 0.00,
  `allowance_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `deduction_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `net_salary` double(10,2) NOT NULL DEFAULT 0.00,
  `salary_month` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `salary_payroll`
--

INSERT INTO `salary_payroll` (`id`, `driver_id`, `basic_salary`, `allowance_amount`, `deduction_amount`, `net_salary`, `salary_month`, `notes`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(12, 4, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 07:15:46', 1, NULL, NULL),
(11, 3, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 07:15:36', 1, NULL, NULL),
(10, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 07:15:25', 1, NULL, NULL),
(9, 2, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 07:15:09', 1, NULL, NULL),
(8, 1, 35000.00, 2000.00, 300.00, 36700.00, '2023-09-25', 'notes if any', 1, '2023-09-25 09:12:29', 1, NULL, NULL),
(13, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:39:25', 1, NULL, NULL),
(14, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:41:40', 1, NULL, NULL),
(15, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:42:08', 1, NULL, NULL),
(16, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:43:40', 1, NULL, NULL),
(17, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:45:45', 1, NULL, NULL),
(18, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:46:03', 1, NULL, NULL),
(19, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:46:26', 1, NULL, NULL),
(20, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:46:56', 1, NULL, NULL),
(21, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:47:29', 1, NULL, NULL),
(22, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 09:59:18', 1, NULL, NULL),
(23, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:18:49', 1, NULL, NULL),
(24, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:21:28', 1, NULL, NULL),
(25, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:21:50', 1, NULL, NULL),
(26, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:35:06', 1, NULL, NULL),
(27, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:39:43', 1, NULL, NULL),
(28, 18, 100000.00, 500.00, 933.33, 99566.67, '2023-09-26', 'notes if any', 1, '2023-09-26 10:45:24', 1, NULL, NULL),
(29, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:47:11', 1, NULL, NULL),
(30, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:52:34', 1, NULL, NULL),
(31, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:52:46', 1, NULL, NULL),
(32, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:53:22', 1, NULL, NULL),
(33, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:54:17', 1, NULL, NULL),
(34, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 10:55:09', 1, NULL, NULL),
(35, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:02:09', 1, NULL, NULL),
(36, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:02:44', 1, NULL, NULL),
(37, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:03:08', 1, NULL, NULL),
(38, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:03:12', 1, NULL, NULL),
(39, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:03:51', 1, NULL, NULL),
(40, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:05:18', 1, NULL, NULL),
(41, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:07:36', 1, NULL, NULL),
(42, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:12:29', 1, NULL, NULL),
(43, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:13:58', 1, NULL, NULL),
(44, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:15:57', 1, NULL, NULL),
(45, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:20:57', 1, NULL, NULL),
(46, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:21:50', 1, NULL, NULL),
(47, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:24:00', 1, NULL, NULL),
(48, 18, 100000.00, 500.00, 1100.00, 99400.00, '2023-09-26', 'notes if any', 1, '2023-09-26 11:26:01', 1, NULL, NULL),
(49, 18, 100000.00, 500.00, 575.00, 99925.00, '2023-09-26', 'notes if any', 1, '2023-09-26 12:22:46', 1, NULL, NULL),
(50, 18, 100000.00, 500.00, 500.00, 100000.00, '2023-09-27', 'notes if any', 1, '2023-09-27 05:25:01', 1, NULL, NULL),
(51, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 05:31:21', 1, NULL, NULL),
(52, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:32:06', 1, NULL, NULL),
(53, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:33:22', 1, NULL, NULL),
(54, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:33:33', 1, NULL, NULL),
(55, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:39:34', 1, NULL, NULL),
(56, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:43:59', 1, NULL, NULL),
(57, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 06:53:01', 1, NULL, NULL),
(58, 18, 100000.00, 500.00, 0.00, 100500.00, '2023-09-27', 'notes if any', 1, '2023-09-27 07:00:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `meta_tag` varchar(255) DEFAULT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `meta_tag`, `meta_key`, `meta_value`) VALUES
(1, 'project', 'site_title', 'Transport Directory'),
(2, 'project', 'short_site_title', 'T D'),
(3, 'project', 'site_logo', 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `start_date_time` datetime DEFAULT NULL,
  `end_date_time` datetime DEFAULT NULL,
  `from_location` varchar(255) DEFAULT NULL,
  `end_location` varchar(255) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: inactive, 1: active',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `vehicle_id`, `driver_id`, `project_id`, `company_id`, `start_date_time`, `end_date_time`, `from_location`, `end_location`, `distance`, `description`, `notes`, `amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 3, 18, 6, 5, '2023-01-19 03:14:07', '2023-01-20 03:14:07', 'Karachi', 'Peshawar', '2000', 'Payloads Lorem Ipsum', 'nill', '150000', 1, 1, NULL, '2023-09-26 01:04:33', '2023-09-26 01:04:33'),
(5, 3, 18, 7, 5, '2023-01-19 03:14:07', '2023-02-20 03:14:07', 'Karachi', 'Peshawar', '2000', 'Payloads Lorem Ipsum', 'nill', '150000', 1, 1, NULL, '2023-09-26 01:05:02', '2023-09-26 01:05:02'),
(6, 6, 13, 7, 5, '2020-08-19 03:14:07', '2020-09-20 03:14:07', 'Karachi', 'Peshawar', '2000', 'Payloads Lorem Ipsum', 'nill', '150000', 1, 1, NULL, '2023-09-26 01:06:09', '2023-09-26 01:06:09'),
(7, 7, 12, 6, 5, '2023-09-19 03:14:07', '2023-09-23 03:14:07', 'Karachi', 'Peshawar', '2700', 'Payloads Lorem Ipsum', 'nill', '150000', 1, 1, NULL, '2023-09-26 01:06:20', '2023-09-26 01:06:20');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_type` int(11) DEFAULT NULL,
  `fuel_type` tinyint(4) NOT NULL DEFAULT 1,
  `registration_no` varchar(255) DEFAULT NULL COMMENT 'Vehicle Plate Number',
  `chassis_no` varchar(255) DEFAULT NULL,
  `engine_no` varchar(255) DEFAULT NULL,
  `current_mileage` varchar(255) DEFAULT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `vehicle_location` varchar(255) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `plate_no_photo` varchar(255) DEFAULT NULL,
  `vehicle_photo` varchar(255) DEFAULT NULL,
  `additional_notes` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_type`, `fuel_type`, `registration_no`, `chassis_no`, `engine_no`, `current_mileage`, `make`, `model`, `year`, `color`, `registration_date`, `vehicle_location`, `driver_id`, `plate_no_photo`, `vehicle_photo`, `additional_notes`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 4, 1, 'FAZ10K', '9762317', '213213123', '1134511', 'Ford', 'e450', '2019', 'white', '2023-09-09', 'Karachi Port', 1, 'http://127.0.0.1:8000/assets/upload_images/Untitled design_1695294564.png', 'http://127.0.0.1:8000/assets/upload_images/adrian-dascal-1QOsJGbNIgk-unsplash_1695294564.jpg', 'Lorem Ipsum', 0, '2023-09-21 09:21:39', 1, '2023-09-21 11:09:24', 1),
(4, 1, 2, 'ABC123', '9762317', '213213123', '1134511', 'Ford', 'e450', '2019', 'white', '2023-09-09', '56 Bakers Street', 1, 'http://127.0.0.1:8000/assets/upload_images/caleb-lucas-PCyhtU6I0iw-unsplash_1695709796.jpg', 'http://127.0.0.1:8000/assets/upload_images/adrian-dascal-1QOsJGbNIgk-unsplash_1695709796.jpg', 'Lorem Ipsum', 1, '2023-09-26 06:29:56', 1, '2023-09-26 06:29:56', NULL),
(5, 2, 3, 'DEF123', '9762317', '213213123', '1134511', 'Ford', 'e450', '2019', 'white', '2023-09-09', '56 Bakers Street', 2, 'http://127.0.0.1:8000/assets/upload_images/caleb-lucas-PCyhtU6I0iw-unsplash_1695709824.jpg', 'http://127.0.0.1:8000/assets/upload_images/adrian-dascal-1QOsJGbNIgk-unsplash_1695709824.jpg', 'Lorem Ipsum', 1, '2023-09-26 06:30:24', 1, '2023-09-26 06:30:24', NULL),
(6, 3, 4, 'GHI123', '9762317', '213213123', '1134511', 'Ford', 'e450', '2019', 'white', '2023-09-09', '56 Bakers Street', 3, 'http://127.0.0.1:8000/assets/upload_images/caleb-lucas-PCyhtU6I0iw-unsplash_1695709842.jpg', 'http://127.0.0.1:8000/assets/upload_images/adrian-dascal-1QOsJGbNIgk-unsplash_1695709842.jpg', 'Lorem Ipsum', 1, '2023-09-26 06:30:42', 1, '2023-09-26 06:30:42', NULL),
(7, 4, 5, 'GHI123', '9762317', '213213123', '1134511', 'Ford', 'e450', '2019', 'white', '2023-09-09', '56 Bakers Street', 4, 'http://127.0.0.1:8000/assets/upload_images/caleb-lucas-PCyhtU6I0iw-unsplash_1695709855.jpg', 'http://127.0.0.1:8000/assets/upload_images/adrian-dascal-1QOsJGbNIgk-unsplash_1695709855.jpg', 'Lorem Ipsum', 1, '2023-09-26 06:30:55', 1, '2023-09-26 06:30:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_inspection`
--

CREATE TABLE `vehicle_inspection` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `next_inspection_date` date DEFAULT NULL,
  `maintenance_recommendation` text DEFAULT NULL,
  `inspection_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=pass, 2=fail',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicle_inspection`
--

INSERT INTO `vehicle_inspection` (`id`, `vehicle_id`, `inspection_date`, `next_inspection_date`, `maintenance_recommendation`, `inspection_status`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, '2023-09-12', '2025-09-12', 'test', 1, 1, '2023-09-26 06:46:10', 1, '2023-09-26 06:46:10', NULL),
(2, 4, '2023-09-12', '2025-09-12', 'test', 1, 1, '2023-09-26 06:46:26', 1, '2023-09-26 06:46:26', NULL),
(3, 5, '2023-09-12', '2025-09-12', 'test', 1, 1, '2023-09-26 06:46:30', 1, '2023-09-26 06:46:30', NULL),
(4, 6, '2023-09-12', '2025-09-12', 'test', 1, 1, '2023-09-26 06:46:33', 1, '2023-09-26 06:46:33', NULL),
(5, 7, '2023-09-12', '2025-09-12', 'test', 1, 1, '2023-09-26 06:46:58', 1, '2023-09-26 06:46:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_maintenance`
--

CREATE TABLE `vehicle_maintenance` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `trip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `maintenance_type_id` int(11) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meter_reading` double(10,2) NOT NULL DEFAULT 0.00,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicle_maintenance`
--

INSERT INTO `vehicle_maintenance` (`id`, `vehicle_id`, `trip_id`, `driver_id`, `company_id`, `maintenance_type_id`, `maintenance_date`, `location`, `description`, `meter_reading`, `amount`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 3, 4, 1, 1, 2, '2023-09-12', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 32010.00, 2500.00, 1, '2023-09-20 12:38:12', 1, '2023-09-20 12:38:12', NULL),
(5, 3, 4, 1, 1, 2, '2023-09-12', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 32010.00, 3000.00, 1, '2023-09-20 12:38:12', 1, '2023-09-20 12:38:12', NULL),
(6, 3, 5, 1, 1, 2, '2023-09-12', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 32010.00, 1500.00, 1, '2023-09-20 12:38:12', 1, '2023-09-20 12:38:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_plate_check`
--

CREATE TABLE `vehicle_plate_check` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `plate_expiry_date` date DEFAULT NULL,
  `license_plate` varchar(255) NOT NULL,
  `plate_registration_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=pass, 2=fail',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vehicle_plate_check`
--

INSERT INTO `vehicle_plate_check` (`id`, `vehicle_id`, `plate_expiry_date`, `license_plate`, `plate_registration_status`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, '2024-09-12', 'FAZ10K', 1, 1, '2023-09-26 06:51:05', 1, '2023-09-26 06:51:05', NULL),
(2, 4, '2024-09-12', 'ABC123', 1, 1, '2023-09-26 06:51:09', 1, '2023-09-26 06:51:09', NULL),
(3, 5, '2024-09-12', 'DEF123', 1, 1, '2023-09-26 06:51:13', 1, '2023-09-26 06:51:13', NULL),
(4, 6, '2024-09-12', 'GHI123', 1, 1, '2023-09-26 06:51:16', 1, '2023-09-26 06:51:16', NULL),
(5, 7, '2024-09-12', 'GHI123', 1, 1, '2023-09-26 06:51:19', 1, '2023-09-26 06:51:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `vehicle_type`, `capacity`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Car', '650', 0, '2022-09-15 09:19:40', '2023-09-11 08:25:28', 1, 1),
(3, '6 Wheeler Full Body', '25000 KG', 1, '2022-09-16 09:51:14', '2022-09-19 11:12:37', 1, NULL),
(4, '10 Wheeler Full Body', '25000 KG', 1, '2022-09-19 11:04:16', '2022-09-19 11:12:18', 1, NULL),
(5, '10 Wheeler Half Body', '12000 KG', 1, '2022-09-19 11:07:51', '2022-09-19 11:12:02', 1, NULL),
(6, 'Trala Half  Body', '25000 KG', 1, '2022-09-19 11:08:29', '2022-09-19 11:11:40', 1, NULL),
(7, 'Trala Phatta Body', '25000 KG', 1, '2022-09-19 11:09:17', '2022-09-19 11:11:24', 1, NULL),
(8, 'Container 20 Feet', '25000 KG', 1, '2022-09-19 11:10:28', '2022-09-19 11:11:09', 1, NULL),
(9, 'Container 40 Feet', '50000 KG', 1, '2022-09-19 11:13:18', '2022-09-19 11:13:18', 1, NULL),
(10, 'No Bed Vehicle', '1000 KG', 1, '2022-09-19 11:15:08', '2022-11-10 08:42:45', 1, 1),
(13, '90-waheeler-Shey-zor', '100 Ton', 1, '2022-11-14 12:32:37', '2022-11-14 12:32:37', 10, NULL),
(14, 'Land Cruser', '5x5', 1, '2022-11-14 12:39:25', '2022-11-14 12:39:25', 12, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allowances`
--
ALTER TABLE `allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_allowances`
--
ALTER TABLE `driver_allowances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_deductions`
--
ALTER TABLE `driver_deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_salaries`
--
ALTER TABLE `driver_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fuel_management`
--
ALTER TABLE `fuel_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance_types`
--
ALTER TABLE `maintenance_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `road_tax_expiry`
--
ALTER TABLE `road_tax_expiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_payroll`
--
ALTER TABLE `salary_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_inspection`
--
ALTER TABLE `vehicle_inspection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_maintenance`
--
ALTER TABLE `vehicle_maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_plate_check`
--
ALTER TABLE `vehicle_plate_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `allowances`
--
ALTER TABLE `allowances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `driver_allowances`
--
ALTER TABLE `driver_allowances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `driver_deductions`
--
ALTER TABLE `driver_deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `driver_salaries`
--
ALTER TABLE `driver_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fuel_management`
--
ALTER TABLE `fuel_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenance_types`
--
ALTER TABLE `maintenance_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `road_tax_expiry`
--
ALTER TABLE `road_tax_expiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `salary_payroll`
--
ALTER TABLE `salary_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vehicle_inspection`
--
ALTER TABLE `vehicle_inspection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_maintenance`
--
ALTER TABLE `vehicle_maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicle_plate_check`
--
ALTER TABLE `vehicle_plate_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
