-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 07, 2022 at 05:21 PM
-- Server version: 5.7.38-0ubuntu0.18.04.1
-- PHP Version: 7.0.33-60+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tender`
--

-- --------------------------------------------------------

--
-- Table structure for table `draft_tender`
--

CREATE TABLE `draft_tender` (
  `id` int(11) NOT NULL,
  `tender_id` int(11) NOT NULL,
  `pa_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `contract_type` text NOT NULL,
  `budget_estimation` int(11) NOT NULL,
  `kak_file` text NOT NULL,
  `design_file` text NOT NULL,
  `other_file` text NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `draft_tender`
--

INSERT INTO `draft_tender` (`id`, `tender_id`, `pa_id`, `name`, `contract_type`, `budget_estimation`, `kak_file`, `design_file`, `other_file`, `date`, `status`) VALUES
(1, 1, 16, 'test tender', 'Lumpsum', 1500000, '2014-1-1-87201-231408012-bab1-21082014043343.pdf', '2014-1-1-87201-231408012-bab1-210820140433431.pdf', '2014-1-1-87201-231408012-bab1-210820140433432.pdf', '2022-07-13', 'Draft');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'uadmin', 'user admin'),
(3, 'user', 'user'),
(4, 'auditor', 'auditor'),
(5, 'pa', 'pa'),
(6, 'pjp', 'pjp'),
(7, 'pt', 'pt'),
(8, 'tpphp', 'tpphp');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(50) NOT NULL,
  `list_id` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `position` int(4) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_id`, `name`, `link`, `list_id`, `icon`, `status`, `position`, `description`) VALUES
(101, 1, 'Beranda', 'admin/', 'home_index', 'home', 1, 1, '-'),
(102, 1, 'Group', 'admin/group', 'group_index', 'home', 1, 2, '-'),
(103, 1, 'Setting', 'admin/menus', '-', 'cogs', 1, 3, '-'),
(104, 1, 'User', 'admin/user_management', 'user_management_index', 'users', 1, 4, '-'),
(106, 103, 'Menu', 'admin/menus', 'menus_index', 'circle', 1, 1, '-'),
(107, 2, 'Beranda', 'uadmin/home', 'home_index', 'home', 1, 1, '-'),
(108, 2, 'Pengguna', 'uadmin/users', 'users_index', 'home', 1, 99, '-'),
(110, 3, 'Beranda', 'user/home', 'home_index', 'home', 1, 1, '-'),
(111, 3, 'Paket', 'user/paket', 'paket_index', 'home', 1, 2, '-'),
(112, 6, 'Rencana Tender', 'pjp/tender', '-', 'file', 1, 1, '-'),
(113, 6, 'Draft Tender', 'pjp/draft_tender', '-', 'home', 1, 1, '-'),
(114, 5, 'Pokmil', 'pa/pokmil', '-', 'home', 1, 1, '-'),
(115, 5, 'Draft Tender', 'pa/draft_tender', '-', 'home', 1, 1, '-'),
(116, 5, 'Paket', 'pa/paket', '-', 'home', 1, 1, '-'),
(117, 7, 'Paket', 'pt/paket', '-', 'home', 1, 1, '-');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `draft_tender_id` int(11) NOT NULL,
  `pa_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `pokmil_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `draft_tender_id`, `pa_id`, `name`, `pokmil_id`, `date`, `status`) VALUES
(3, 1, 16, 'test tender', 1, '2022-07-07', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pokmil`
--

CREATE TABLE `pokmil` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `sk_no` text NOT NULL,
  `lead_id` int(11) NOT NULL,
  `member_1_id` int(11) NOT NULL,
  `member_2_id` int(11) NOT NULL,
  `member_3_id` int(11) NOT NULL,
  `member_4_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pokmil`
--

INSERT INTO `pokmil` (`id`, `name`, `sk_no`, `lead_id`, `member_1_id`, `member_2_id`, `member_3_id`, `member_4_id`, `date`, `status`) VALUES
(1, 'pokmil 1', 'pokmil 1', 19, 20, 21, 0, 0, '2022-07-06', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tender`
--

CREATE TABLE `tender` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `budget` int(11) NOT NULL,
  `budget_source` text NOT NULL,
  `year` int(11) NOT NULL,
  `location` text NOT NULL,
  `method` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender`
--

INSERT INTO `tender` (`id`, `code`, `name`, `type`, `budget`, `budget_source`, `year`, `location`, `method`, `start_date`, `end_date`, `status`) VALUES
(1, 'test tender', 'test tender', 'Barang/Pekerjaan', 1000000, 'test', 2022, 'lokasi', 'Tender', '2022-07-06', '2022-07-29', 'Tayang');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` text NOT NULL,
  `address` varchar(200) NOT NULL,
  `nrrp` text NOT NULL,
  `job_position` text NOT NULL,
  `sk_number` text NOT NULL,
  `due_date` date DEFAULT NULL,
  `cert_no` text NOT NULL,
  `cert_date` date DEFAULT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `phone`, `image`, `address`, `nrrp`, `job_position`, `sk_number`, `due_date`, `cert_no`, `cert_date`, `status`) VALUES
(1, '127.0.0.1', 'admin@fixl.com', '$2y$12$ydMl5gvUnv.r3KM2wHV5jeCsHrkbyRhFJRSiZRwRjsIE/27obAqcO', 'admin@fixl.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1657178601, 1, 'Admin', 'istrator', '081342989185', 'USER_1_1656405871.jpg', 'admin', '', '', '', NULL, '', NULL, ''),
(13, '::1', 'uadmin@gmail.com', '$2y$10$78SZyvKRKMU7nPCew9w4nOpEUmJ1SeTV4L4ZG2NXXSfbEaswqoepq', 'uadmin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1568678256, 1657178630, 1, 'admin', 'PPE', '00', 'USER_13_1568678463.jpg', 'jln mutiara no 8', '', '', '', NULL, '', NULL, ''),
(14, '127.0.0.1', 'auditor@gmail.com', '$2y$10$O9/YYtvknWWZ.vYEAZa/M.RsnTR1LMu10ntsbRbedd29wga081CRy', 'auditor@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1632804971, 1656407632, 1, 'Auditor', 'Auditor', '1234', 'default.jpg', 'Alamat', '', '', '', NULL, '', NULL, ''),
(15, '127.0.0.1', 'pjp@gmail.com', '$2y$10$fEZdcDRTVJ57Zm0L7wlDheTqq3sZR48MeT1qWDXPBCh6Fj7MecLi.', 'pjp@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1656407833, 1657179749, 1, 'pjp', 'pjp', '1923847983', 'default.jpg', 'pjp', '', '', '', '0000-00-00', '', '2022-07-07', '1'),
(16, '127.0.0.1', 'pa@gmail.com', '$2y$10$PWtzu1GsItjcSmvU3zRESOGSjSg5bR/MiMEiJj7jGXKxwsKVjAeIy', 'pa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114148, 1657179287, 1, 'pa', 'pa', '1023897', 'default.jpg', 'alamat', 'nrrp', 'jabatan', 'alskdhf', '2022-07-06', 'asdfilkj', '2022-07-06', '1'),
(18, '127.0.0.1', 'pa2@gmail.com', '$2y$10$PWtzu1GsItjcSmvU3zRESOGSjSg5bR/MiMEiJj7jGXKxwsKVjAeIy', 'pa2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114148, NULL, 1, 'pa2', 'pa2', '1023897', 'default.jpg', 'alamat', '', '', '', '0000-00-00', '', '0000-00-00', '1'),
(19, '127.0.0.1', 'pt@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, 1657179555, 1, 'pt', 'pt', '-91847', 'default.jpg', 'alamat', '', '', '', '0000-00-00', '', '2022-07-07', '1'),
(20, '127.0.0.1', 'pt2@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, NULL, 1, 'pt2', 'pt2', '-91847', 'default.jpg', 'alamat', 'nrrp', 'alksdfhj', 'alksdhlf', '2022-07-06', 'asdfasdf', '2022-07-06', 'Aktif'),
(21, '127.0.0.1', 'pt3@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt3@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, NULL, 1, 'pt3', 'pt3', '-91847', 'default.jpg', 'alamat', 'nrrp', 'alksdfhj', 'alksdhlf', '2022-07-06', 'asdfasdf', '2022-07-06', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(29, 13, 2),
(36, 14, 4),
(47, 15, 6),
(40, 16, 5),
(45, 18, 5),
(46, 19, 7),
(48, 20, 7),
(49, 21, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `draft_tender`
--
ALTER TABLE `draft_tender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pokmil`
--
ALTER TABLE `pokmil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender`
--
ALTER TABLE `tender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `draft_tender`
--
ALTER TABLE `draft_tender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pokmil`
--
ALTER TABLE `pokmil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tender`
--
ALTER TABLE `tender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
