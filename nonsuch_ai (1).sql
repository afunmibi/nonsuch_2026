-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 09:22 PM
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
-- Database: `nonsuch_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billvetting`
--

CREATE TABLE `billvetting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'staff_vetted',
  `full_name` varchar(255) DEFAULT NULL,
  `policy_no` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `package_code` varchar(255) DEFAULT NULL,
  `package_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `package_limit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pry_hcp` varchar(255) DEFAULT NULL,
  `pry_hcp_code` varchar(255) DEFAULT NULL,
  `sec_hcp` varchar(255) DEFAULT NULL,
  `sec_hcp_code` varchar(255) DEFAULT NULL,
  `sec_hcp_bank_name` varchar(255) DEFAULT NULL,
  `sec_hcp_account_number` varchar(255) DEFAULT NULL,
  `sec_hcp_account_name` varchar(255) DEFAULT NULL,
  `sec_hcp_contact` varchar(255) DEFAULT NULL,
  `sec_hcp_email` varchar(255) DEFAULT NULL,
  `diagnosis` longtext DEFAULT NULL,
  `treatment_plan` longtext DEFAULT NULL,
  `further_investigation` longtext DEFAULT NULL,
  `billing_month` varchar(255) DEFAULT NULL,
  `admission_days` int(11) NOT NULL DEFAULT 0,
  `admission_date` date DEFAULT NULL,
  `discharge_date` date DEFAULT NULL,
  `hcp_amount_due_grandtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hcp_amount_claimed_grandtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hcp_name` varchar(255) DEFAULT NULL,
  `hcp_code` varchar(255) DEFAULT NULL,
  `hcp_bank_name` varchar(255) DEFAULT NULL,
  `hcp_account_number` varchar(255) DEFAULT NULL,
  `hcp_account_name` varchar(255) DEFAULT NULL,
  `hcp_contact` varchar(255) DEFAULT NULL,
  `hcp_email` varchar(255) DEFAULT NULL,
  `pa_code_approved_by` varchar(255) DEFAULT NULL,
  `vetted_by` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `re_checked_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `scheduled_for_payment_by` varchar(255) DEFAULT NULL,
  `paid_by` varchar(255) DEFAULT NULL,
  `log_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_vetted_at` timestamp NULL DEFAULT NULL,
  `checked_at` timestamp NULL DEFAULT NULL,
  `re_checked_at` timestamp NULL DEFAULT NULL,
  `authorized_at` timestamp NULL DEFAULT NULL,
  `cm_processed_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billvetting`
--

INSERT INTO `billvetting` (`id`, `pa_code`, `status`, `full_name`, `policy_no`, `dob`, `phone_no`, `package_code`, `package_price`, `package_limit`, `pry_hcp`, `pry_hcp_code`, `sec_hcp`, `sec_hcp_code`, `sec_hcp_bank_name`, `sec_hcp_account_number`, `sec_hcp_account_name`, `sec_hcp_contact`, `sec_hcp_email`, `diagnosis`, `treatment_plan`, `further_investigation`, `billing_month`, `admission_days`, `admission_date`, `discharge_date`, `hcp_amount_due_grandtotal`, `hcp_amount_claimed_grandtotal`, `hcp_name`, `hcp_code`, `hcp_bank_name`, `hcp_account_number`, `hcp_account_name`, `hcp_contact`, `hcp_email`, `pa_code_approved_by`, `vetted_by`, `checked_by`, `re_checked_by`, `approved_by`, `scheduled_for_payment_by`, `paid_by`, `log_request_id`, `staff_vetted_at`, `checked_at`, `re_checked_at`, `authorized_at`, `cm_processed_at`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, '051/PHIS/4283/cold/2026/FEB/0001', 'paid', 'FUNMIBI ADEWALE', 'WB/02/2026/376623', '2026-02-02', '08062328638', 'WB', 70000.00, 60000.00, 'Sacred heart Hospital', 'OG/0116/P', 'Sacred heart Hospital', 'OG/0116/P', NULL, NULL, NULL, NULL, NULL, 'rest', 'expert advice', 'rest and sleep', '2026-02', 1, NULL, NULL, 5360.00, 1000.00, NULL, NULL, 'Access bank', '09044444', 'Sacred Heart', NULL, NULL, NULL, 'GM User', 'GM User', 'GM User', 'GM User', NULL, 'GM User', 1, NULL, NULL, NULL, '2026-02-03 03:36:11', '2026-02-03 03:56:39', '2026-02-03 03:56:39', '2026-02-03 02:43:27', '2026-02-03 03:56:39'),
(2, '051/PHIS/5392/hd/2026/FEB/0002', 'paid', 'Ayo', 'WB/02/2026/840324', '2004-01-03', '098776666', 'WB', 70000.00, 60000.00, 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', 'Wema bank', '09044676578', 'Lafia Hospital', NULL, NULL, 'headache', 'drugs', 'Scan', '2026-02', 0, NULL, NULL, 6720.20, 7000.00, NULL, NULL, 'Wema bank', '09044676578', 'Lafia Hospital', NULL, NULL, 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Idris A', 2, NULL, '2026-02-03 11:33:18', '2026-02-03 11:33:33', '2026-02-03 11:33:47', '2026-02-03 11:34:25', '2026-02-03 11:49:02', '2026-02-03 10:08:54', '2026-02-03 11:49:02'),
(3, '051/PHIS/0232/htn/2026/FEB/0003', 'paid', 'Tolulope', 'GD-032/02/2026/554555', '2026-02-03', '08132686523', 'GD-032', 50000.00, 45000.00, 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', 'Wema bank', '09044676578', 'Lafia Hospital', NULL, NULL, 'hypertension', 'drugs', 'investigation', '2026-02', 1, '2026-02-03', '2026-02-03', 2786.00, 400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 3, NULL, '2026-02-03 11:11:55', '2026-02-03 11:12:15', '2026-02-03 11:12:32', '2026-02-03 11:16:56', '2026-02-03 11:20:51', '2026-02-03 11:09:29', '2026-02-03 11:20:51'),
(4, '051/PHIS/3520/hd/2026/FEB/0004', 'paid', 'Tayo', 'WB/02/2026/192790', '2026-02-03', '099888776', 'WB', 70000.00, 60000.00, 'Lafia Hospital', 'OY/0001/P', 'Sacred heart Hospital', 'OG/0116/P', 'Wema bank', '09044676578', 'Lafia Hospital', NULL, NULL, 'headache', 'drugs', 'nill', '2026-02', 1, '2026-02-02', '2026-02-02', 2591.90, 1800.00, NULL, NULL, NULL, NULL, NULL, NULL, 'lafia@lafia.com', 'GM User', 'GM User', 'GM User', 'GM User', 'GM User', 'GM User', 'GM User', 4, NULL, '2026-02-03 17:48:45', '2026-02-03 17:49:00', '2026-02-03 17:49:24', '2026-02-03 17:50:01', '2026-02-03 17:52:38', '2026-02-03 17:48:27', '2026-02-03 17:52:38'),
(5, '051/PHIS/6566/dm/2026/FEB/0005', 'ready_for_payment', 'Nuru Ribadu', 'WB/02/2026/330112', '2026-02-02', '6788292929', 'WB', 70000.00, 60000.00, 'Lafia Hospital', 'OY/0001/P', 'Federal Medical centre', 'OG/0001/P', 'Wema bank', '09044676578', 'Lafia Hospital', NULL, NULL, 'DM', 'to see Endo', 'no', '2026-02', 0, NULL, NULL, 4259.00, 11600.00, NULL, NULL, NULL, NULL, NULL, NULL, 'lafia@lafia.com', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, 5, NULL, '2026-02-09 10:51:09', '2026-02-09 10:51:28', '2026-02-09 10:51:49', '2026-02-09 10:52:42', NULL, '2026-02-09 10:37:34', '2026-02-09 10:52:43'),
(6, '051/PHIS/8237/cold/2026/FEB/0006', 'vetted_ud', 'Suleiman', 'WB/02/2026/355346', '2026-02-02', '78999090', 'WB', 70000.00, 60000.00, 'Federal Medical centre', 'OG/0001/P', 'Federal Medical centre', 'OG/0001/P', NULL, NULL, NULL, NULL, NULL, 'cold and catthar', 'drugs', 'n', '2026-02', 1, NULL, NULL, 2054.00, 8300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin User', 'Admin User', 'Admin User', NULL, NULL, NULL, NULL, 6, NULL, '2026-02-09 11:29:18', NULL, NULL, NULL, NULL, '2026-02-09 11:28:52', '2026-02-09 11:29:18'),
(7, '051/PHIS/9116/hd/2026/FEB/0007', 'staff_vetted', 'FUNMIBI Funmi', 'GD-032/02/2026/359036', '2026-02-09', '08062328638', 'GD-032', 50000.00, 45000.00, 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', NULL, NULL, NULL, NULL, NULL, 'headache', 'drugs', 'n', '2026-02', 0, NULL, NULL, 2243.00, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Admin User', 'Admin User', NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 12:53:55', '2026-02-09 12:54:58'),
(8, '051/PHIS/0218/htn/2026/FEB/0008', 'ready_for_payment', 'FUNMIBI Funmi', 'GD-032/02/2026/359036', '2026-02-09', '08062328638', 'GD-032', 50000.00, 45000.00, 'Federal Medical centre', 'OG/0001/P', 'Sacred heart Hospital', 'OG/0116/P', 'Access bank', '09044444', 'Sacred Heart', NULL, NULL, 'hypertension and inv', 'drugs', 'n', '2026-01', 1, '2026-02-10', '2026-02-11', 3306.00, 8000.00, NULL, NULL, NULL, NULL, NULL, NULL, 'shh@gmail.com', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, 8, NULL, '2026-02-11 10:43:46', '2026-02-11 10:44:06', '2026-02-11 10:44:30', '2026-02-11 10:45:21', NULL, '2026-02-11 10:42:00', '2026-02-11 10:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('nonsuch-medicare-limited-cache-afunmibi@gmail.com|127.0.0.1', 'i:1;', 1770636389),
('nonsuch-medicare-limited-cache-afunmibi@gmail.com|127.0.0.1:timer', 'i:1770636389;', 1770636389);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` varchar(255) NOT NULL,
  `diag_code` varchar(255) NOT NULL,
  `treatment_plan` varchar(255) NOT NULL,
  `cost` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`id`, `diagnosis`, `diag_code`, `treatment_plan`, `cost`, `created_at`, `updated_at`) VALUES
(1, 'hypertension', 'htn', 'drugs', 2000.00, '2026-02-03 02:19:15', '2026-02-03 02:19:15'),
(2, 'diabetes', 'dm', 'drugs', 2000.00, '2026-02-03 02:19:58', '2026-02-03 02:19:58'),
(3, 'headache', 'hd', 'drugs', 1500.00, '2026-02-03 02:20:29', '2026-02-03 02:20:29'),
(4, 'cold and catthar', 'cold', 'drugs', 1200.00, '2026-02-03 02:21:04', '2026-02-03 02:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `enrolments`
--

CREATE TABLE `enrolments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `policy_no` varchar(255) NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `address` longtext NOT NULL,
  `location` varchar(255) NOT NULL,
  `photograph` varchar(255) NOT NULL,
  `package_code` varchar(255) NOT NULL,
  `package_description` longtext NOT NULL,
  `package_price` decimal(8,2) NOT NULL,
  `package_limit` decimal(8,2) NOT NULL,
  `pry_hcp` varchar(255) NOT NULL,
  `dependants_1_name` varchar(255) DEFAULT NULL,
  `dependants_1_dob` varchar(255) DEFAULT NULL,
  `dependants_1_photograph` varchar(255) DEFAULT NULL,
  `dependants_1_status` varchar(255) DEFAULT NULL,
  `dependants_2_name` varchar(255) DEFAULT NULL,
  `dependants_2_dob` varchar(255) DEFAULT NULL,
  `dependants_2_photograph` varchar(255) DEFAULT NULL,
  `dependants_2_status` varchar(255) DEFAULT NULL,
  `dependants_3_name` varchar(255) DEFAULT NULL,
  `dependants_3_dob` varchar(255) DEFAULT NULL,
  `dependants_3_photograph` varchar(255) DEFAULT NULL,
  `dependants_3_status` varchar(255) DEFAULT NULL,
  `dependants_4_name` varchar(255) DEFAULT NULL,
  `dependants_4_dob` varchar(255) DEFAULT NULL,
  `dependants_4_photograph` varchar(255) DEFAULT NULL,
  `dependants_4_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrolments`
--

INSERT INTO `enrolments` (`id`, `policy_no`, `organization_name`, `full_name`, `phone_no`, `email`, `dob`, `address`, `location`, `photograph`, `package_code`, `package_description`, `package_price`, `package_limit`, `pry_hcp`, `dependants_1_name`, `dependants_1_dob`, `dependants_1_photograph`, `dependants_1_status`, `dependants_2_name`, `dependants_2_dob`, `dependants_2_photograph`, `dependants_2_status`, `dependants_3_name`, `dependants_3_dob`, `dependants_3_photograph`, `dependants_3_status`, `dependants_4_name`, `dependants_4_dob`, `dependants_4_photograph`, `dependants_4_status`, `created_at`, `updated_at`) VALUES
(3, 'WB/02/2026/376623', 'Tedprime Hub Support Initiative', 'FUNMIBI ADEWALE', '08062328638', 'afunmibi@gmail.com', '2026-02-02', '111102\r\nNo. #25, Opeolu Street, Off Subeb Ijeun Titun, Abeokuta Ogun State Nigeria', 'Abeokuta', 'enrolments/zI20o1dGt1tTPibgStcbLe21KoFGRg9EPKYViOem.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Sacred heart Hospital', NULL, NULL, 'enrolments/Kx4vWQIyAYhuplQLjtuhPqdi9dfQqFThEhqj9Gad.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 02:08:41', '2026-02-03 02:08:41'),
(4, 'GD-032/02/2026/704585', 'Divine_love bags', 'Adewale Opeyemi', '08132686523', 'fotyem@gmail.com', '2026-02-02', 'No. #25, Opeolu Street, Off Subeb Ijeun Titun, Abeokuta Ogun State Nigeria', 'Abeokuta', 'enrolments/bxJKpRD3Xv2pRdcWXGb7uzRBzm8EKuMlNip54mcH.jpg', 'GD-032', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50000.00, 45000.00, 'Federal Medical centre', 'Deborah', '2026-02-03', 'enrolments/XE6Bl7RcDOBLosCyzbDDQ1925LQhUyU7gzjj1xvi.jpg', '1', 'tabitha', '2026-02-01', 'enrolments/uyPfJiWJB8apWXvYa6vVpdyhxT7d6wKBbF2CtnNE.jpg', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 02:12:51', '2026-02-03 02:12:51'),
(5, 'WB/02/2026/840324', 'Nonsuch HMO', 'Ayo', '098776666', 'ay@gmail.com', '2004-01-03', 'ibadan', 'ibadan', 'enrolments/vNM3TjMdXv7HfmAZRJpGCB8A0SxqjBasXjr1cEhi.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Federal Medical centre', 'Fatia', '2017-06-03', 'enrolments/hNlb9wCZ1OCokBLHHdjpknliT7RTY8fm90LjGw78.jpg', 'child', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 09:41:11', '2026-02-03 09:41:11'),
(6, 'GD-032/02/2026/554555', 'Tolu Enterprises', 'Tolulope', '08132686523', 'tolu@gmail.com', '2026-02-03', 'No. #25, Opeolu Street, Off Subeb Ijeun Titun, Abeokuta Ogun State Nigeria', '111102', 'enrolments/sAcD9B1IyqDs8MKtbHp2vWSdghqd80YV6xNENUDJ.jpg', 'GD-032', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50000.00, 45000.00, 'Federal Medical centre', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 09:42:28', '2026-02-03 09:42:28'),
(7, 'WB/02/2026/192790', 'Tayo Tayo', 'Tayo', '099888776', 'tayo@tayo.com', '2026-02-03', 'Lagos', 'Lagos', 'enrolments/THgj3Yk7EXlYbuebGaGpUYqUJ7p6CWIVoErFDPBY.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Lafia Hospital', 'Rabecca', '2026-02-03', 'enrolments/i0RGf9pFVL5yMO7a0Lft0PJNGPZIKyjxEpY7OA01.jpg', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-03 17:45:04', '2026-02-03 17:45:04'),
(8, 'WB/02/2026/330112', 'Nonsuch HMO', 'Nuru Ribadu', '6788292929', 'nuru@nuru.com', '2026-02-02', 'Ibadan', 'Ibadan', 'enrolments/36xscZ24uX5h8pRFeAlk4bTMg5t7nUJ6wBZjPtfp.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Lafia Hospital', 'Sola', '2026-02-01', 'enrolments/qXRPVLid6kHns9f8VPniIx7rUhhvH7hOkmdtRLTb.jpg', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 10:31:46', '2026-02-09 10:31:46'),
(9, 'WB/02/2026/355346', 'Sula Enter', 'Suleiman', '78999090', 'sula@sula.com', '2026-02-02', 'hhssnsnsns', 'ib', 'enrolments/6CZhqCrMpR51YxEueWCn7PnnxeW6UAsgY2zTRcFC.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Federal Medical centre', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 11:26:21', '2026-02-09 11:26:21'),
(10, 'WB/02/2026/113040', 'Divine_love bags Abk', 'Adewale Opeyemi', '08132686523', 'fotyemw@gmail.com', '2026-02-01', 'No. #25, Opeolu Street, Off Subeb Ijeun Titun, Abeokuta Ogun State Nigeria', 'Abeokuta', 'enrolments/afnXDtrZlLcMIsCkb8M2BgJiJp7MaSFp3IzgbQhm.jpg', 'WB', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 70000.00, 60000.00, 'Sacred heart Hospital', 'FUNMI', '2026-02-02', 'enrolments/39ZPOgiUdr587x5Fu79Y5nOALQJl5NqjTP1yGYSF.jpg', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 12:47:33', '2026-02-09 12:47:33'),
(11, 'GD-032/02/2026/359036', 'Tedprime Hub', 'FUNMIBI Funmi', '08062328638', 'afunmi@gmail.com', '2026-02-09', '111102\r\nNo. #25, Opeolu Street, Off Subeb Ijeun Titun, Abeokuta Ogun State Nigeria', 'Abeokuta', 'enrolments/Dz7mXXd4a20dQbZm347XS68uyGc9hVVrriTn7PP3.jpg', 'GD-032', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50000.00, 45000.00, 'Federal Medical centre', 'iyi', '2026-02-08', 'enrolments/C0KVXbLOqJFsPqj0EdRtQ922t4BSyNYbiWshmKRb.jpg', 'child', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-09 12:50:49', '2026-02-09 12:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_code` varchar(255) DEFAULT NULL,
  `policy_no` varchar(255) NOT NULL,
  `type` enum('feedback','complaint','review') NOT NULL DEFAULT 'feedback',
  `rating` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `pa_code`, `policy_no`, `type`, `rating`, `comment`, `user_id`, `created_at`, `updated_at`) VALUES
(1, NULL, '67543', 'feedback', 4, 'sa', 1, '2026-02-04 10:23:19', '2026-02-04 10:23:19'),
(2, NULL, '67543', 'review', 1, 'not', 1, '2026-02-04 10:24:10', '2026-02-04 10:24:10'),
(3, NULL, '67543', 'complaint', 1, 'no', 1, '2026-02-04 10:24:27', '2026-02-04 10:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `hcp_bill_uploads`
--

CREATE TABLE `hcp_bill_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `hcp_name` varchar(255) NOT NULL,
  `hcp_code` varchar(255) DEFAULT NULL,
  `billing_month` varchar(255) NOT NULL,
  `hmo_officer` varchar(255) DEFAULT NULL,
  `amount_claimed` decimal(15,2) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hcp_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hcp_bill_uploads`
--

INSERT INTO `hcp_bill_uploads` (`id`, `user_id`, `hcp_name`, `hcp_code`, `billing_month`, `hmo_officer`, `amount_claimed`, `file_path`, `status`, `remarks`, `created_at`, `updated_at`, `hcp_id`) VALUES
(1, 14, 'City Hospital', NULL, '2026-02', NULL, 77777.00, 'hcp_bills/nP74nxkdmCUm84nJ8YNcXvEWcPeJPb2J5ptdxGG4.jpg', 'Pending', 'jjjj', '2026-02-04 11:56:51', '2026-02-04 11:56:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hcp_hospitals`
--

CREATE TABLE `hcp_hospitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hcp_name` varchar(255) NOT NULL,
  `hcp_code` varchar(255) NOT NULL,
  `hcp_location` varchar(255) NOT NULL,
  `hcp_contact` varchar(255) NOT NULL,
  `hcp_email` varchar(255) NOT NULL,
  `hcp_account_number` varchar(255) NOT NULL,
  `hcp_account_name` varchar(255) NOT NULL,
  `hcp_bank_name` varchar(255) NOT NULL,
  `hcp_accreditation_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hcp_hospitals`
--

INSERT INTO `hcp_hospitals` (`id`, `hcp_name`, `hcp_code`, `hcp_location`, `hcp_contact`, `hcp_email`, `hcp_account_number`, `hcp_account_name`, `hcp_bank_name`, `hcp_accreditation_status`, `created_at`, `updated_at`) VALUES
(1, 'Sacred heart Hospital', 'OG/0116/P', 'Abeokuta', 'lantoro', 'shh@gmail.com', '09044444', 'Sacred Heart', 'Access bank', 'Accredited', '2026-02-03 01:50:18', '2026-02-03 01:50:18'),
(2, 'Federal Medical centre', 'OG/0001/P', 'Abeokuta', 'Idi Aba Abeokuta', 'fmc@gmail.com', '0909333', 'FMC', 'RRR', 'Accredited', '2026-02-03 01:50:54', '2026-02-03 01:50:54'),
(3, 'Lafia Hospital', 'OY/0001/P', 'Ibadan', 'Ibadan', 'lafia@lafia.com', '09044676578', 'Lafia Hospital', 'Wema bank', 'Accredited', '2026-02-03 09:44:41', '2026-02-03 09:44:41');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_requests`
--

CREATE TABLE `log_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `policy_no` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `package_code` varchar(255) NOT NULL,
  `package_price` decimal(8,2) NOT NULL,
  `package_limit` decimal(8,2) NOT NULL,
  `package_description` varchar(255) NOT NULL,
  `pry_hcp` varchar(255) NOT NULL,
  `pry_hcp_code` varchar(255) NOT NULL,
  `sec_hcp` varchar(255) NOT NULL,
  `sec_hcp_code` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `diagnosis` longtext NOT NULL,
  `diag_code` varchar(255) DEFAULT NULL,
  `treatment_plan` longtext NOT NULL,
  `further_investigation` longtext NOT NULL,
  `pa_code` varchar(255) DEFAULT NULL,
  `pa_code_status` varchar(255) DEFAULT NULL,
  `pa_code_rejection_reason` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `pa_code_approved_by` varchar(255) DEFAULT NULL,
  `vetted_by` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `re_checked_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `hcp_amount_claimed_grandtotal` decimal(8,2) DEFAULT NULL,
  `hcp_amount_due_grandtotal` decimal(8,2) DEFAULT NULL,
  `scheduled_for_payment_by` varchar(255) DEFAULT NULL,
  `paid_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_requests`
--

INSERT INTO `log_requests` (`id`, `full_name`, `policy_no`, `phone_no`, `package_code`, `package_price`, `package_limit`, `package_description`, `pry_hcp`, `pry_hcp_code`, `sec_hcp`, `sec_hcp_code`, `dob`, `diagnosis`, `diag_code`, `treatment_plan`, `further_investigation`, `pa_code`, `pa_code_status`, `pa_code_rejection_reason`, `staff_id`, `pa_code_approved_by`, `vetted_by`, `checked_by`, `re_checked_by`, `approved_by`, `hcp_amount_claimed_grandtotal`, `hcp_amount_due_grandtotal`, `scheduled_for_payment_by`, `paid_by`, `created_at`, `updated_at`) VALUES
(1, 'FUNMIBI ADEWALE', 'WB/02/2026/376623', '08062328638', 'WB', 70000.00, 60000.00, 'WEMA', 'Sacred heart Hospital', 'OG/0116/P', 'Sacred heart Hospital', 'OG/0116/P', '2026-02-02', 'rest', 'cold', 'expert advice', 'rest and sleep', '051/PHIS/4283/cold/2026/FEB/0001', 'paid', NULL, '2', NULL, 'GM User', NULL, 'GM User', 'GM User', NULL, NULL, NULL, 'GM User', '2026-02-03 02:39:32', '2026-02-03 03:56:39'),
(2, 'Ayo', 'WB/02/2026/840324', '098776666', 'WB', 70000.00, 60000.00, 'WEMA', 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', '2004-01-03', 'headache', 'hd', 'drugs', 'Scan', '051/PHIS/5392/hd/2026/FEB/0002', 'scheduled_for_payment', NULL, '1', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, NULL, NULL, 'Admin User', '2026-02-03 09:57:35', '2026-02-03 11:34:25'),
(3, 'Tolulope', 'GD-032/02/2026/554555', '08132686523', 'GD-032', 50000.00, 45000.00, 'Gold', 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', '2026-02-03', 'hypertension', 'htn', 'drugs', 'investigation', '051/PHIS/0232/htn/2026/FEB/0003', 'scheduled_for_payment', NULL, '1', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, NULL, NULL, NULL, '2026-02-03 09:58:33', '2026-02-03 11:16:56'),
(4, 'Tayo', 'WB/02/2026/192790', '099888776', 'WB', 70000.00, 60000.00, 'WEMA', 'Lafia Hospital', 'OY/0001/P', 'Sacred heart Hospital', 'OG/0116/P', '2026-02-03', 'headache', 'hd', 'drugs', 'nill', '051/PHIS/3520/hd/2026/FEB/0004', 'scheduled_for_payment', NULL, '2', 'GM User', 'GM User', 'GM User', 'GM User', 'GM User', 1800.00, 2591.90, 'GM User', NULL, '2026-02-03 17:46:00', '2026-02-03 17:50:01'),
(5, 'Nuru Ribadu', 'WB/02/2026/330112', '6788292929', 'WB', 70000.00, 60000.00, 'WEMA', 'Lafia Hospital', 'OY/0001/P', 'Federal Medical centre', 'OG/0001/P', '2026-02-02', 'DM', 'dm', 'to see Endo', 'no', '051/PHIS/6566/dm/2026/FEB/0005', 'scheduled_for_payment', NULL, '1', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 11600.00, 4259.00, 'Admin User', NULL, '2026-02-09 10:33:08', '2026-02-09 10:52:43'),
(6, 'Suleiman', 'WB/02/2026/355346', '78999090', 'WB', 70000.00, 60000.00, 'WEMA', 'Federal Medical centre', 'OG/0001/P', 'Federal Medical centre', 'OG/0001/P', '2026-02-02', 'cold and catthar', 'cold', 'drugs', 'n', '051/PHIS/8237/cold/2026/FEB/0006', 'vetted', NULL, '1', 'Admin User', 'Admin User', 'Admin User', NULL, NULL, 8300.00, 2054.00, NULL, NULL, '2026-02-09 11:26:55', '2026-02-09 11:29:18'),
(7, 'FUNMIBI Funmi', 'GD-032/02/2026/359036', '08062328638', 'GD-032', 50000.00, 45000.00, 'Gold', 'Federal Medical centre', 'OG/0001/P', 'Lafia Hospital', 'OY/0001/P', '2026-02-09', 'headache', 'hd', 'drugs', 'n', '051/PHIS/9116/hd/2026/FEB/0007', 'vetted', NULL, '1', 'Admin User', 'Admin User', NULL, NULL, NULL, 5000.00, 2243.00, NULL, NULL, '2026-02-09 12:51:37', '2026-02-09 12:54:58'),
(8, 'FUNMIBI Funmi', 'GD-032/02/2026/359036', '08062328638', 'GD-032', 50000.00, 45000.00, 'Gold', 'Federal Medical centre', 'OG/0001/P', 'Sacred heart Hospital', 'OG/0116/P', '2026-02-09', 'hypertension and inv', 'htn', 'drugs', 'n', '051/PHIS/0218/htn/2026/FEB/0008', 'scheduled_for_payment', NULL, '1', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 'Admin User', 8000.00, 3306.00, 'Admin User', NULL, '2026-02-11 10:38:07', '2026-02-11 10:45:22');

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
(44, '0001_01_01_000000_create_users_table', 1),
(45, '0001_01_01_000001_create_cache_table', 1),
(46, '0001_01_01_000002_create_jobs_table', 1),
(47, '2026_01_18_143727_create_packages_table', 1),
(48, '2026_01_18_143928_create_enrolments_table', 1),
(49, '2026_01_18_144003_create_log_requests_table', 1),
(50, '2026_01_18_144238_create_hcp_hospitals_table', 1),
(51, '2026_01_20_112542_add_contacts_to_log_requests_table', 1),
(52, '2026_01_20_181333_create_vetted_services_table', 1),
(53, '2026_01_20_181411_create_vetted_drugs_table', 1),
(54, '2026_01_25_151301_create_diagnosis_table', 1),
(55, '2026_01_25_184849_create_billvetting_table', 1),
(56, '2026_01_27_115304_update_vetted_tables_alignment', 1),
(57, '2026_01_29_113521_create_accounts_table', 1),
(58, '2026_01_29_115128_add_workflow_details_to_billvetting_table', 1),
(59, '2026_01_30_132445_add_checked_by_to_tables', 1),
(60, '2026_02_03_032412_add_diag_code_to_log_requests_table', 2),
(61, '2026_02_03_042044_add_audit_fields_to_line_items', 3),
(62, '2026_02_03_114649_create_tasks_table', 4),
(63, '2026_02_03_121605_add_sec_hcp_payment_columns_to_billvetting_table', 5),
(64, '2026_02_04_095502_create_pa_monitorings_table', 6),
(65, '2026_02_04_095521_create_feedback_table', 6),
(66, '2026_02_04_101734_create_hcp_bill_uploads_table', 6),
(67, '2026_02_04_115020_add_file_path_to_pa_monitorings_table', 7),
(68, '2026_02_04_124938_add_hcp_id_to_users_table', 8),
(69, '2026_02_04_125119_add_hcp_id_to_hcp_bill_uploads_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_description` text NOT NULL,
  `package_code` varchar(255) NOT NULL,
  `package_price` decimal(8,2) NOT NULL,
  `package_limit` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `package_description`, `package_code`, `package_price`, `package_limit`, `created_at`, `updated_at`) VALUES
(1, 'WEMA', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'WB', 70000.00, 60000.00, '2026-02-03 01:53:02', '2026-02-03 01:53:02'),
(2, 'Gold', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'GD-032', 50000.00, 45000.00, '2026-02-03 01:53:24', '2026-02-03 01:53:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pa_monitorings`
--

CREATE TABLE `pa_monitorings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_code` varchar(255) NOT NULL,
  `policy_no` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `treatment_received` text DEFAULT NULL,
  `days_spent` int(11) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `monitoring_status` varchar(255) NOT NULL DEFAULT 'Admitted',
  `monitored_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pa_monitorings`
--

INSERT INTO `pa_monitorings` (`id`, `pa_code`, `policy_no`, `full_name`, `phone_no`, `diagnosis`, `treatment_received`, `days_spent`, `remarks`, `file_path`, `monitoring_status`, `monitored_by`, `created_at`, `updated_at`) VALUES
(1, '051/PHIS/5392/hd/2026/FEB/0002', '051/NONSUCH/7807/2025/12/GD-030/2', 'Tolulope', '666666666', NULL, NULL, 2, NULL, 'monitoring_docs/1poAzx9XT4WrSH1XAok3UYlRL1YJKnwRqPUXsI4o.jpg', 'Admitted', 1, '2026-02-04 10:47:49', '2026-02-04 10:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('o6pN6ke2f1VNf1V5DVluqr7dT1Mag5ydrS2Z9Fj4', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieDVUSUJXUHFiN2thZ2NvZ3lscWU2emVWWm4ydTNMdEs1Yk00U2d2TyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mZWVkYmFjay9jcmVhdGUiO3M6NToicm91dGUiO3M6MTU6ImZlZWRiYWNrLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770810545);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hcp_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `hcp_id`) VALUES
(1, 'Admin User', 'admin@nonsuch.com', NULL, '$2y$12$bnqjxM4QioYdGg6YeiCfee28mi6jaWeqCStwkJeMFtR8Y8OH3nrg.', 'admin', '9yMVwKANnWPLzv459KqBGpJXQOQmlavmGrZPkamwb2diU1VcCNdW5wZ7vqrd', '2026-02-03 01:33:29', '2026-02-03 01:40:15', NULL),
(2, 'GM User', 'gm@nonsuch.com', NULL, '$2y$12$1z0q/JbqQ78gFdbK.aQn4.kMlJYrGLz4xlSZqaqNuzxFnodeD0gcC', 'gm', NULL, '2026-02-03 01:44:45', '2026-02-03 01:44:45', NULL),
(3, 'MD User', 'md@nonsuch.com', NULL, '$2y$12$tvG7FEZ0bXbu5mxQc93cleijqTTD/ne2hAa4lEHvz6Ezq/HHCYagu', 'md', NULL, '2026-02-03 01:44:59', '2026-02-03 01:44:59', NULL),
(4, 'Claims Manager', 'funmi@nonsuch.com', NULL, '$2y$12$0s2ERK9QsdRBb5cMmX0FKuqQyNrSW5COBM.TxAs4dxB4o1UgvnI7u', 'cc', NULL, '2026-02-03 09:25:29', '2026-02-03 09:25:59', NULL),
(6, 'Idris A', 'account@nonsuch.com', NULL, '$2y$12$UVXydFRrsP1Yl80Vkqa6q.BnxShmWpdeQy4jm9hR5tzy0eOGO17Da', 'accounts', NULL, '2026-02-03 09:53:05', '2026-02-04 11:09:29', NULL),
(7, 'tayo', 'tayo@nonsuch.com', NULL, '$2y$12$bNBMCc54Osq1Xp0FU8WWO.mLbJMo.5aavrnN9seHwCm8AWHFAtB2G', 'cc', NULL, '2026-02-03 17:43:05', '2026-02-04 11:09:29', NULL),
(8, 'HR Manager', 'hr@nonsuch.com', NULL, '$2y$12$qfrFuPizJ7bJU9xJODOhXeEDEJdraauUYag/mw92PwSauAn4N9gyS', 'hr', NULL, '2026-02-04 11:09:29', '2026-02-04 11:12:35', NULL),
(9, 'IT Support', 'it@nonsuch.com', NULL, '$2y$12$4AnWeee1csKBBDy/FxA2sOtXWvhkrgguTm5MnAqKKS.Y2ObwecfhK', 'it', NULL, '2026-02-04 11:09:29', '2026-02-04 11:12:36', NULL),
(10, 'UD Underwriter', 'ud@nonsuch.com', NULL, '$2y$12$/ifokSIXVn64pPV0E7dCRuLTOHNXW7IeHwPQ/HqMI6WMZkVWgcJNS', 'ud', NULL, '2026-02-04 11:31:43', '2026-02-04 11:31:43', NULL),
(11, 'CM Reviewer', 'cm@nonsuch.com', NULL, '$2y$12$KfGgJN9LDuSN3sMI9UXoTOwWQVUyt.ysZgQ8G.lLXl4FG61GwzNHq', 'cm', NULL, '2026-02-04 11:31:43', '2026-02-04 11:31:43', NULL),
(12, 'General Staff', 'staff@nonsuch.com', NULL, '$2y$12$82b.rG4NA4Sb1sgrnLOUGu9wEWbDfzPARidPyx8B.nlXKnCvSu.fe', 'staff', NULL, '2026-02-04 11:31:43', '2026-02-04 11:31:43', NULL),
(13, 'sam', 'sam@nonsuch.com', NULL, '$2y$12$9KiENJQL0Pr5c4wkQtr1y.LNmKCo75sQkRpFNWF1jkg.4T6ez1lQq', 'staff', NULL, '2026-02-04 11:37:22', '2026-02-04 11:37:22', NULL),
(14, 'City Hospital', 'hospital@nonsuch.com', NULL, '$2y$12$KPaQqcYY3UGecrO0dwlr1OdxzunG1sI6050Bjl4T8D/6/NioKKWKG', 'hcp', NULL, '2026-02-04 11:42:30', '2026-02-04 11:42:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vetted_drugs`
--

CREATE TABLE `vetted_drugs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_code` varchar(255) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `tariff` decimal(15,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 1,
  `copayment_10` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hcp_amount_due_total_drugs` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hcp_amount_claimed_total_drugs` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remarks` longtext DEFAULT NULL,
  `vetted_by` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `re_checked_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `paid_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vetted_drugs`
--

INSERT INTO `vetted_drugs` (`id`, `pa_code`, `drug_name`, `tariff`, `qty`, `copayment_10`, `hcp_amount_due_total_drugs`, `hcp_amount_claimed_total_drugs`, `remarks`, `vetted_by`, `checked_by`, `re_checked_by`, `approved_by`, `paid_by`, `created_at`, `updated_at`) VALUES
(7, '051/PHIS/4283/cold/2026/FEB/0001', 'pcm', 30.00, 10, 30.00, 270.00, 800.00, 'not', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 03:36:11', '2026-02-03 03:36:11'),
(8, '051/PHIS/4283/cold/2026/FEB/0001', 'vitamin c', 10.00, 10, 10.00, 90.00, 200.00, 'not complied', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 03:36:11', '2026-02-03 03:36:11'),
(20, '051/PHIS/0232/htn/2026/FEB/0003', 'pcm', 27.00, 20, 54.00, 486.00, 400.00, 'undercharged', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:12:32', '2026-02-03 11:12:32'),
(25, '051/PHIS/5392/hd/2026/FEB/0002', 'pcm', 28.00, 10, 28.00, 252.00, 4000.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:33:47', '2026-02-03 11:33:47'),
(26, '051/PHIS/5392/hd/2026/FEB/0002', 'folic acid', 14.90, 20, 29.80, 268.20, 3000.00, NULL, 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:33:47', '2026-02-03 11:33:47'),
(33, '051/PHIS/3520/hd/2026/FEB/0004', 'pcm', 30.00, 20, 60.00, 540.00, 1000.00, 'complied', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 17:49:24', '2026-02-03 17:49:24'),
(34, '051/PHIS/3520/hd/2026/FEB/0004', 'metro', 17.00, 23, 39.10, 351.90, 800.00, NULL, 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 17:49:24', '2026-02-03 17:49:24'),
(41, '051/PHIS/6566/dm/2026/FEB/0005', 'pcm', 27.00, 10, 27.00, 243.00, 3000.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-09 10:51:49', '2026-02-09 10:51:49'),
(42, '051/PHIS/6566/dm/2026/FEB/0005', 'folic acid', 12.00, 20, 24.00, 216.00, 2000.00, 'not', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-09 10:51:49', '2026-02-09 10:51:49'),
(44, '051/PHIS/8237/cold/2026/FEB/0006', 'ferrous', 3.00, 20, 6.00, 54.00, 6000.00, NULL, 'Admin User', 'Admin User', NULL, NULL, NULL, '2026-02-09 11:29:18', '2026-02-09 11:29:18'),
(47, '051/PHIS/9116/hd/2026/FEB/0007', 'pcm', 27.00, 10, 27.00, 243.00, 2000.00, 'n', 'Admin User', NULL, NULL, NULL, NULL, '2026-02-09 12:54:58', '2026-02-09 12:54:58'),
(51, '051/PHIS/0218/htn/2026/FEB/0008', 'folic acid', 34.00, 10, 34.00, 306.00, 3000.00, NULL, 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-11 10:44:30', '2026-02-11 10:44:30');

-- --------------------------------------------------------

--
-- Table structure for table `vetted_services`
--

CREATE TABLE `vetted_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pa_code` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `tariff` decimal(15,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 1,
  `hcp_amount_due_total_services` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hcp_amount_claimed_total_services` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remarks` longtext DEFAULT NULL,
  `vetted_by` varchar(255) DEFAULT NULL,
  `checked_by` varchar(255) DEFAULT NULL,
  `re_checked_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `paid_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vetted_services`
--

INSERT INTO `vetted_services` (`id`, `pa_code`, `service_name`, `tariff`, `qty`, `hcp_amount_due_total_services`, `hcp_amount_claimed_total_services`, `remarks`, `vetted_by`, `checked_by`, `re_checked_by`, `approved_by`, `paid_by`, `created_at`, `updated_at`) VALUES
(13, '051/PHIS/4283/cold/2026/FEB/0001', 'consult', 1000.00, 1, 1000.00, 0.00, 'not complied', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 03:36:11', '2026-02-03 03:36:11'),
(14, '051/PHIS/4283/cold/2026/FEB/0001', 'investigation', 4000.00, 1, 4000.00, 0.00, 'not nnnmmmm nnkiuui', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 03:36:11', '2026-02-03 03:36:11'),
(26, '051/PHIS/0232/htn/2026/FEB/0003', 'consultation', 2300.00, 1, 2300.00, 0.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:12:32', '2026-02-03 11:12:32'),
(31, '051/PHIS/5392/hd/2026/FEB/0002', 'Initial consultation', 2500.00, 1, 2500.00, 0.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:33:47', '2026-02-03 11:33:47'),
(32, '051/PHIS/5392/hd/2026/FEB/0002', 'scan', 3700.00, 1, 3700.00, 0.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-03 11:33:47', '2026-02-03 11:33:47'),
(36, '051/PHIS/3520/hd/2026/FEB/0004', 'consultation', 1700.00, 1, 1700.00, 0.00, 'complied', 'GM User', 'GM User', 'GM User', 'GM User', NULL, '2026-02-03 17:49:24', '2026-02-03 17:49:24'),
(43, '051/PHIS/6566/dm/2026/FEB/0005', 'initial consultaion', 2000.00, 1, 2000.00, 4000.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-09 10:51:49', '2026-02-09 10:51:49'),
(44, '051/PHIS/6566/dm/2026/FEB/0005', 'inv', 1800.00, 1, 1800.00, 2600.00, 'not complied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-09 10:51:49', '2026-02-09 10:51:49'),
(46, '051/PHIS/8237/cold/2026/FEB/0006', 'consult', 2000.00, 1, 2000.00, 2300.00, NULL, 'Admin User', 'Admin User', NULL, NULL, NULL, '2026-02-09 11:29:18', '2026-02-09 11:29:18'),
(49, '051/PHIS/9116/hd/2026/FEB/0007', 'consult', 2000.00, 1, 2000.00, 3000.00, 'not', 'Admin User', NULL, NULL, NULL, NULL, '2026-02-09 12:54:58', '2026-02-09 12:54:58'),
(54, '051/PHIS/0218/htn/2026/FEB/0008', 'consultation', 3000.00, 1, 3000.00, 5000.00, 'npt compied', 'Admin User', 'Admin User', 'Admin User', 'Admin User', NULL, '2026-02-11 10:44:30', '2026-02-11 10:44:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billvetting`
--
ALTER TABLE `billvetting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billvetting_pa_code_index` (`pa_code`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolments`
--
ALTER TABLE `enrolments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrolments_policy_no_unique` (`policy_no`),
  ADD UNIQUE KEY `enrolments_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

--
-- Indexes for table `hcp_bill_uploads`
--
ALTER TABLE `hcp_bill_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hcp_bill_uploads_user_id_foreign` (`user_id`),
  ADD KEY `hcp_bill_uploads_hcp_id_foreign` (`hcp_id`);

--
-- Indexes for table `hcp_hospitals`
--
ALTER TABLE `hcp_hospitals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hcp_hospitals_hcp_code_unique` (`hcp_code`),
  ADD UNIQUE KEY `hcp_hospitals_hcp_email_unique` (`hcp_email`),
  ADD UNIQUE KEY `hcp_hospitals_hcp_account_number_unique` (`hcp_account_number`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_requests`
--
ALTER TABLE `log_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_requests_pa_code_pa_code_status_index` (`pa_code`,`pa_code_status`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `packages_package_code_unique` (`package_code`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pa_monitorings`
--
ALTER TABLE `pa_monitorings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pa_monitorings_pa_code_unique` (`pa_code`),
  ADD KEY `pa_monitorings_monitored_by_foreign` (`monitored_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_hcp_id_foreign` (`hcp_id`);

--
-- Indexes for table `vetted_drugs`
--
ALTER TABLE `vetted_drugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vetted_drugs_pa_code_index` (`pa_code`);

--
-- Indexes for table `vetted_services`
--
ALTER TABLE `vetted_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vetted_services_pa_code_index` (`pa_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billvetting`
--
ALTER TABLE `billvetting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `enrolments`
--
ALTER TABLE `enrolments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hcp_bill_uploads`
--
ALTER TABLE `hcp_bill_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hcp_hospitals`
--
ALTER TABLE `hcp_hospitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_requests`
--
ALTER TABLE `log_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pa_monitorings`
--
ALTER TABLE `pa_monitorings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vetted_drugs`
--
ALTER TABLE `vetted_drugs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `vetted_services`
--
ALTER TABLE `vetted_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `hcp_bill_uploads`
--
ALTER TABLE `hcp_bill_uploads`
  ADD CONSTRAINT `hcp_bill_uploads_hcp_id_foreign` FOREIGN KEY (`hcp_id`) REFERENCES `hcp_hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hcp_bill_uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pa_monitorings`
--
ALTER TABLE `pa_monitorings`
  ADD CONSTRAINT `pa_monitorings_monitored_by_foreign` FOREIGN KEY (`monitored_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_hcp_id_foreign` FOREIGN KEY (`hcp_id`) REFERENCES `hcp_hospitals` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
