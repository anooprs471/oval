-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2015 at 04:09 PM
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
  `op_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(6) NOT NULL,
  `coupon_type` varchar(10) NOT NULL,
  `complementary` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `customer_id`, `op_id`, `username`, `password`, `coupon_type`, `complementary`, `created_at`, `updated_at`) VALUES
(1, 124, 2121, 'wewww', 'www', '2', 1, '2015-03-06 15:12:05', '2015-03-06 15:12:05'),
(2, 0, 56, 'fgfg', '1212', '45', 0, '2015-03-06 15:12:05', '2015-03-06 15:12:05'),
(3, 0, 3, 'vkxbxg', 'cjgz', '3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 0, 3, 'vgufyt', 'yvab', '3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 0, 3, 'zkwytw', 'zgbm', '3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 0, 3, 'hqxqhs', 'uaqs', '3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 0, 3, 'hccvan', 'ksch', '3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 0, 3, 'vrpdmb', 'tafh', '3', 1, '2015-03-07 04:58:24', '2015-03-07 04:58:24'),
(9, 0, 2, 'nwjcmr', 'kpax', '1', 1, '2015-03-09 04:29:26', '2015-03-09 04:29:26'),
(10, 8, 2, 'wpzvrc', 'bramnz', '2', 0, '2015-03-09 05:18:01', '2015-03-09 05:18:01'),
(11, 8, 2, 'msuehc', 'phpyyt', '2', 1, '2015-03-09 05:29:12', '2015-03-09 05:29:12'),
(12, 8, 2, 'sutgay', 'ydfunm', '2', 0, '2015-03-09 05:30:23', '2015-03-09 05:30:23'),
(13, 8, 2, 'knmwyx', 'acypqx', '2', 0, '2015-03-09 05:31:35', '2015-03-09 05:31:35');

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
(4, '0', 'name', '9847586512', '', 'Voters ID', 'some-2015-03-04-04-10.png', 2, '2015-03-04 10:40:51', '2015-03-04 10:40:51'),
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
-- Table structure for table `radcheck`
--

CREATE TABLE IF NOT EXISTS `radcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `radcheck`
--

INSERT INTO `radcheck` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'user1', 'Cleartext-Password', ':=', 'pass1'),
(2, 'wpzvrc', '', '==', 'bramnz'),
(3, 'msuehc', '', '==', 'phpyyt'),
(4, 'sutgay', '', '==', 'ydfunm'),
(5, 'knmwyx', '', '==', 'acypqx');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

CREATE TABLE IF NOT EXISTS `radgroupcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '==',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `radgroupcheck`
--

INSERT INTO `radgroupcheck` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(1, 'daloRADIUS-Disabled-Users', 'Auth-Type', ':=', 'Reject');

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

CREATE TABLE IF NOT EXISTS `radgroupreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `radgroupreply`
--

INSERT INTO `radgroupreply` (`id`, `groupname`, `attribute`, `op`, `value`) VALUES
(1, 'sample1', 'ChilliSpot-Bandwidth-Max-Up', ':=', '67'),
(2, 'sample2', 'Idle-Timeout', ':=', '87');

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

CREATE TABLE IF NOT EXISTS `radreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `attribute` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `op` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '=',
  `value` varchar(253) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `radreply`
--

INSERT INTO `radreply` (`id`, `username`, `attribute`, `op`, `value`) VALUES
(1, 'zkwytw', '', '=', 'zgbm'),
(2, 'hqxqhs', '', '=', 'uaqs'),
(3, 'hccvan', '', '=', 'ksch'),
(4, 'vrpdmb', '', '=', 'tafh'),
(5, 'nwjcmr', '', '=', 'kpax');

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

CREATE TABLE IF NOT EXISTS `radusergroup` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `groupname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '1',
  KEY `username` (`username`(32))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `radusergroup`
--

INSERT INTO `radusergroup` (`username`, `groupname`, `priority`) VALUES
('wpzvrc', 'sample1', 0),
('sutgay', 'sample1', 0),
('knmwyx', 'sample1', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`) VALUES
(4, 2, NULL, 0, 0, 0, '2015-03-05 03:04:41', NULL, NULL),
(5, 3, NULL, 1, 0, 0, '2015-03-07 05:03:14', NULL, NULL),
(6, 1, NULL, 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE IF NOT EXISTS `userinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `workphone` varchar(200) DEFAULT NULL,
  `homephone` varchar(200) DEFAULT NULL,
  `mobilephone` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zip` varchar(200) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `changeuserinfo` varchar(128) DEFAULT NULL,
  `portalloginpassword` varchar(128) DEFAULT '',
  `enableportallogin` int(32) DEFAULT '0',
  `creationdate` datetime DEFAULT '0000-00-00 00:00:00',
  `creationby` varchar(128) DEFAULT NULL,
  `updatedate` datetime DEFAULT '0000-00-00 00:00:00',
  `updateby` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `username`, `firstname`, `lastname`, `email`, `department`, `company`, `workphone`, `homephone`, `mobilephone`, `address`, `city`, `state`, `country`, `zip`, `notes`, `changeuserinfo`, `portalloginpassword`, `enableportallogin`, `creationdate`, `creationby`, `updatedate`, `updateby`) VALUES
(1, 'user1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', '', 0, '2015-02-26 12:22:44', 'administrator', NULL, NULL),
(2, 'sutgay', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2015-03-09 11:00:23', NULL, '2015-03-09 11:00:23', NULL),
(3, 'knmwyx', 'new name', NULL, NULL, NULL, NULL, NULL, NULL, '9879878844', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, '2015-03-09 11:01:35', '8', '2015-03-09 11:01:35', NULL);

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
(1, 'admin@administrator.com', '$2y$10$93aP1sZfDMnOdgElTUxckuq9L.L/0bNd7vvT6lJOaPR8x6YWuAwqS', NULL, 1, NULL, NULL, '2015-03-07 10:30:47', '$2y$10$OIrEErGdGLmMaGFU5U5b4uVZiwbhzpfmuifuHJIYLD0p3eqygbPHa', NULL, NULL, NULL, '2015-02-27 05:06:00', '2015-03-07 05:00:47', 'administrator'),
(2, 'op@op.com', '$2y$10$0BcU/eZpLCH5WNIXbT51N.R3UbQkpvh1/mItdSJqfyHCpwhZLKJQu', NULL, 1, NULL, NULL, '2015-03-09 08:38:17', '$2y$10$.7vrEq9mw4nV5yJbLF8kp.J5F1yFNTtUDYdW8PZf.q81BgP.2Uc2a', NULL, 'lijith', 'raj', '2015-02-27 05:11:24', '2015-03-09 03:08:17', 'operator1'),
(3, 'op2@op.com', '$2y$10$uBoG54oAIpZXgDWejQ90leAgTvxj8CzTN8zpYEHWTZn1SsQl6rcCi', NULL, 1, NULL, NULL, '2015-03-07 10:27:59', '$2y$10$.9K62I.95iLGQxTY31gd5eg/AR0v/EFihsG/OT6.jzbBfMnlvfxsa', NULL, NULL, NULL, '2015-02-27 05:11:58', '2015-03-07 04:57:59', 'operator2');

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
