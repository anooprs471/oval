-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2015 at 10:35 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ovalinfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `couponplans`
--

CREATE TABLE IF NOT EXISTS `couponplans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planname` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `couponplans`
--

INSERT INTO `couponplans` (`id`, `planname`, `price`, `created_at`, `updated_at`) VALUES
(1, 'sample1', 453, '2015-03-06 07:34:57', '2015-03-06 07:34:57'),
(2, 'sample1', 500, '2015-03-06 07:35:19', '2015-03-06 07:35:19'),
(3, 'daloRADIUS-Disabled-Users', 212, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'sample2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `patient_id` varchar(20) NOT NULL,
  `op_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(6) NOT NULL,
  `coupon_type` varchar(10) NOT NULL,
  `complementary` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `customer_id`, `patient_id`, `op_id`, `username`, `password`, `coupon_type`, `complementary`, `created_at`, `updated_at`) VALUES
(14, 4, 'ttyf', 2, 'wewwwt', 'qwerty', '2', 1, '2015-03-10 07:08:23', '2015-03-10 07:08:23'),
(15, 4, 'ttyf', 2, 'wewwwt', 'qwerty', '2', 0, '2015-02-03 07:12:08', '2015-03-10 07:12:08'),
(16, 4, 'ttyf', 2, 'tfmjrc', 'febtdb', '2', 0, '2015-03-12 04:41:39', '2015-03-12 04:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(20) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `id_proof_number` varchar(30) NOT NULL,
  `id_proof_type` varchar(30) NOT NULL,
  `id_proof_filename` varchar(150) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `patient_id`, `customer_name`, `mobile_number`, `id_proof_number`, `id_proof_type`, `id_proof_filename`, `operator_id`, `created_at`, `updated_at`) VALUES
(4, 'ttyf', 'name', '9847586512', '', 'Voters ID', 'some-2015-03-04-04-10.png', 2, '2015-03-04 10:40:51', '2015-03-04 10:40:51'),
(5, '0', 'name', '9847586512', '', 'Voters ID', 'werewrw-2015-03-06-01-44.jpg', 3, '2015-03-06 08:14:19', '2015-03-06 08:14:19'),
(6, '0', 'name', 'fghfghtyutyu', '', 'Voters ID', 't56788-2015-03-06-01-47.png', 3, '2015-03-06 08:17:07', '2015-03-06 08:17:07'),
(7, '0', 'name', '9847586512', '', 'Voters ID', 'werewrw-2015-03-07-10-26.png', 3, '2015-03-07 04:56:09', '2015-03-07 04:56:09'),
(8, '0', 'new name', '9879878844', '', 'Driving License', 'NON-PATIENT-2015-03-09-10-31.jpg', 2, '2015-03-09 05:01:37', '2015-03-09 05:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '{"admin":1,"users":1}', '2015-02-27 05:01:12', '2015-02-27 05:01:12'),
(2, 'Operator', '{"users":1}', '2015-02-27 05:02:42', '2015-02-27 05:02:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(4) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`) VALUES
(4, 2, NULL, 0, 0, 0, NULL, NULL, NULL),
(5, 3, NULL, 0, 0, 0, NULL, NULL, NULL),
(7, 1, NULL, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`, `username`) VALUES
(1, 'admin@administrator.com', '$2y$10$93aP1sZfDMnOdgElTUxckuq9L.L/0bNd7vvT6lJOaPR8x6YWuAwqS', NULL, 1, NULL, NULL, '2015-03-12 09:54:38', '$2y$10$8BW6.fQyg8p..J2ioXj7xOx19ZF.XSddD7gDURWzJhoT3GNDyiIEy', NULL, NULL, NULL, '2015-02-27 05:06:00', '2015-03-12 04:24:38', 'administrator'),
(2, 'op@op.com', '$2y$10$0BcU/eZpLCH5WNIXbT51N.R3UbQkpvh1/mItdSJqfyHCpwhZLKJQu', NULL, 1, NULL, NULL, '2015-03-12 09:55:23', '$2y$10$cj7TGyuR9bIfdNPxGiyEVugFGNH1yk/bMLyBEK586hg42/ZYTFmoG', NULL, 'lijith', 'raj', '2015-02-27 05:11:24', '2015-03-12 04:25:23', 'operator1'),
(3, 'op2@op.com', '$2y$10$uBoG54oAIpZXgDWejQ90leAgTvxj8CzTN8zpYEHWTZn1SsQl6rcCi', NULL, 1, NULL, NULL, '2015-03-10 12:26:48', '$2y$10$yTEn0JBpddcXRXZclEaBYu2tjDPXT/AvG7nWgPrJclePNMujtxS82', NULL, NULL, NULL, '2015-02-27 05:11:58', '2015-03-10 06:56:48', 'operator2');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
