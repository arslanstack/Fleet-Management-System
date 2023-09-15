-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 15, 2023 at 06:54 AM
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
-- Table structure for table `allowances`
--

DROP TABLE IF EXISTS `allowances`;
CREATE TABLE IF NOT EXISTS `allowances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `allowance_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
-- Table structure for table `deductions`
--

DROP TABLE IF EXISTS `deductions`;
CREATE TABLE IF NOT EXISTS `deductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deduction_type` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
  `profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `phone_no`, `email`, `password`, `nric`, `address`, `dob`, `bank_account_no`, `licence_type`, `driver_status`, `joining_date`, `end_date`, `vehicle_rental_tatus`, `car_plateno`, `diesel_tag`, `driver_project`, `nric_front_side`, `nric_back_side`, `licence_front_side`, `licence_back_side`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `profile`) VALUES
(1, 'Abdul Waheed', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:54', 1, '2023-09-08 12:34:05', 1, 0, NULL),
(2, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:58', 1, '2023-09-08 12:32:58', NULL, 1, NULL),
(3, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:32:59', 1, '2023-09-08 12:32:59', NULL, 1, NULL),
(4, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:00', 1, '2023-09-08 12:33:00', NULL, 1, NULL),
(5, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:01', 1, '2023-09-08 12:33:01', NULL, 1, NULL),
(6, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:02', 1, '2023-09-08 12:33:02', NULL, 1, NULL),
(7, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:03', 1, '2023-09-08 12:33:03', NULL, 1, NULL),
(8, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, NULL, '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:04', 1, '2023-09-08 12:33:04', NULL, 1, NULL),
(9, 'Test user', '030414141414', 'd@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-19', NULL, 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 12:33:05', 1, '2023-09-13 13:35:26', 1, 1, NULL),
(11, 'Test user', '030414141414', 'da@gmail.com', '123456', '35021363636363', 'lahore', '2023-09-09', '01020304052023', 1, 1, '2023-09-08', '2023-09-08', 1, 'leo 1234', '454545', 'one, two', '', '', '', '', '2023-09-08 13:31:14', 1, '2023-09-08 13:31:14', NULL, 1, NULL),
(12, 'test', '3452345243', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-09-13 13:40:43', NULL, '2023-09-13 13:40:43', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_allowances`
--

DROP TABLE IF EXISTS `driver_allowances`;
CREATE TABLE IF NOT EXISTS `driver_allowances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `allowance_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_allowances`
--

INSERT INTO `driver_allowances` (`id`, `driver_id`, `allowance_id`, `amount`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`) VALUES
(1, 1, 1, 500.00, 1, NULL, '2023-09-13 13:32:33', NULL, '2023-09-13 13:32:33'),
(2, 1, 1, 1500.00, 1, NULL, '2023-09-13 13:32:33', NULL, '2023-09-13 13:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `driver_deductions`
--

DROP TABLE IF EXISTS `driver_deductions`;
CREATE TABLE IF NOT EXISTS `driver_deductions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `deduction_id` int(11) DEFAULT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `effective_date` date DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_deductions`
--

INSERT INTO `driver_deductions` (`id`, `driver_id`, `deduction_id`, `amount`, `effective_date`, `description`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`) VALUES
(1, 1, 1, 100.00, '2023-09-13', 'role break', 1, NULL, '2023-09-13 13:33:28', NULL, '2023-09-13 13:33:28'),
(2, 1, 1, 200.00, '2023-09-13', 'role break', 1, NULL, '2023-09-13 13:33:28', NULL, '2023-09-13 13:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `driver_salaries`
--

DROP TABLE IF EXISTS `driver_salaries`;
CREATE TABLE IF NOT EXISTS `driver_salaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `salary` double(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `driver_salaries`
--

INSERT INTO `driver_salaries` (`id`, `driver_id`, `salary`, `status`, `updated_by`, `created_at`, `created_by`, `updated_at`) VALUES
(1, 1, 35000.00, 1, NULL, '2023-09-13 13:34:34', NULL, '2023-09-13 13:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_management`
--

DROP TABLE IF EXISTS `fuel_management`;
CREATE TABLE IF NOT EXISTS `fuel_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `fuel_type` tinyint(4) NOT NULL DEFAULT '1',
  `quantity` double(10,2) NOT NULL DEFAULT '0.00',
  `cost_per_liter` double(10,2) NOT NULL DEFAULT '0.00',
  `fuel_cost` double(10,2) NOT NULL,
  `previous_meter_reading` double(10,2) NOT NULL DEFAULT '0.00',
  `current_meter_reading` double(10,2) NOT NULL DEFAULT '0.00',
  `fuel_avg` double(10,2) NOT NULL DEFAULT '0.00',
  `per_liter_avg` double(10,2) NOT NULL DEFAULT '0.00',
  `fuel_datetime` datetime DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_types`
--

DROP TABLE IF EXISTS `maintenance_types`;
CREATE TABLE IF NOT EXISTS `maintenance_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maintenance_type` varchar(255) DEFAULT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
-- Table structure for table `road_tax_expiry`
--

DROP TABLE IF EXISTS `road_tax_expiry`;
CREATE TABLE IF NOT EXISTS `road_tax_expiry` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `renewal_date` date DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_payroll`
--

DROP TABLE IF EXISTS `salary_payroll`;
CREATE TABLE IF NOT EXISTS `salary_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `basic_salary` double(10,2) NOT NULL DEFAULT '0.00',
  `allowance_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `deduction_amount` double(10,2) NOT NULL DEFAULT '0.00',
  `net_salary` double(10,2) NOT NULL DEFAULT '0.00',
  `salary_month` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `salary_payroll`
--

INSERT INTO `salary_payroll` (`id`, `driver_id`, `basic_salary`, `allowance_amount`, `deduction_amount`, `net_salary`, `salary_month`, `notes`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 35000.00, 2000.00, 300.00, 36700.00, '2023-09-14', 'notes if any', 1, '2023-09-14 08:42:25', 1, NULL, NULL);

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
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_type` int(11) DEFAULT NULL,
  `fuel_type` tinyint(4) NOT NULL DEFAULT '1',
  `registration_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Vehicle Plate Number',
  `chassis_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `engine_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_mileage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `make` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `vehicle_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `plate_no_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vehicle_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_inspection`
--

DROP TABLE IF EXISTS `vehicle_inspection`;
CREATE TABLE IF NOT EXISTS `vehicle_inspection` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `next_inspection_date` date DEFAULT NULL,
  `maintenance_recommendation` text COLLATE utf8_unicode_ci,
  `inspection_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pass, 2=fail',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_maintenance`
--

DROP TABLE IF EXISTS `vehicle_maintenance`;
CREATE TABLE IF NOT EXISTS `vehicle_maintenance` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `maintenance_type_id` int(11) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `meter_reading` double(10,2) NOT NULL DEFAULT '0.00',
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_plate_check`
--

DROP TABLE IF EXISTS `vehicle_plate_check`;
CREATE TABLE IF NOT EXISTS `vehicle_plate_check` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `plate_expiry_date` date DEFAULT NULL,
  `license_plate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plate_registration_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=pass, 2=fail',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
