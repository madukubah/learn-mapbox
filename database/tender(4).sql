-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2022 at 05:30 PM
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
-- Table structure for table `acta`
--

CREATE TABLE `acta` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` date NOT NULL,
  `notary` text NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acta`
--

INSERT INTO `acta` (`id`, `company_id`, `name`, `date`, `notary`, `desc`) VALUES
(2, 1, 'Nomor', '2022-07-07', 'Notaris', 'Keterangan'),
(3, 1, ' Nama Ijin', '2022-07-05', 'Notaris', 'Keterangan');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `tender_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `tender_id`, `user_id`, `content`, `datetime`) VALUES
(3, 5, 19, '', '2022-07-14 16:44:44'),
(4, 5, 19, 'test', '2022-07-14 16:50:00'),
(5, 5, 19, 'test', '2022-07-14 16:51:57'),
(6, 5, 32, 'haluuu', '2022-07-14 16:55:06'),
(7, 5, 32, 'test', '2022-07-14 16:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `company_type` text NOT NULL,
  `company_cert` text NOT NULL,
  `npwp` text NOT NULL,
  `postal_code` text NOT NULL,
  `province` text NOT NULL,
  `city` text NOT NULL,
  `website` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `user_id`, `name`, `company_type`, `company_cert`, `npwp`, `postal_code`, `province`, `city`, `website`) VALUES
(1, 23, 'usaha penyedia yuhu', 'CV', 'sertifikat 1', 'npwp', 'kode pos', 'provinsi', 'kota', 'website'),
(2, 29, 'PT. Rambutan', 'PT', '12345', '1.23.4.5', '93117', 'Sulawesi Tenggara', 'Kendari', ''),
(3, 31, 'Kita', 'CV', 'kitakita', '1283439809', '93123', 'Sulawwsi', 'fdjnjknsd', 'Sibhbiuf'),
(4, 32, 'usaha', 'CV', 'Badan', 'NPWP', 'Kode Pos', 'Provinsi', ' Kabupaten/Kota', 'Website');

-- --------------------------------------------------------

--
-- Table structure for table `company_permission`
--

CREATE TABLE `company_permission` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `cert_no` text NOT NULL,
  `agency_from` text NOT NULL,
  `qualification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_permission`
--

INSERT INTO `company_permission` (`id`, `company_id`, `name`, `cert_no`, `agency_from`, `qualification`) VALUES
(3, 1, 'Nama Ijin', 'Nomor Surat', 'Instansi Pemberi', 'Besar');

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
(3, 4, 16, 'Pengadaan Komputer Server', 'Lumpsum', 1500000, '', '', '', '2022-07-22', 'Draft'),
(4, 2, 16, 'Pemeliharaan Gedung ATM', 'Lumpsum', 1000000, '', '', '', '2022-07-14', 'Draft'),
(5, 1, 16, 'Pembangunan Gedung Kantor Cabang BPD', 'Lumpsum', 0, '', '', '', '2022-07-14', ''),
(6, 5, 16, 'Mobil', 'Lumpsum', 80000000, 'TENDER_1657630137.pdf', 'TENDER_16576301371.pdf', 'TENDER_16576301372.pdf', '2022-07-12', 'Draft'),
(7, 6, 16, 'Pengadaan Aqua Gelas', 'Harga Satuan', 60000000, '', '', '', '2022-07-13', 'Draft');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL,
  `agency` text NOT NULL,
  `address` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `company_id`, `name`, `location`, `agency`, `address`, `start_date`, `end_date`) VALUES
(1, 1, ' Nama Pekerjaan 22', 'Lokasi', 'Instansi 22', 'Alamat', '2022-07-21', '2022-07-12');

-- --------------------------------------------------------

--
-- Table structure for table `expert`
--

CREATE TABLE `expert` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `birthday` date NOT NULL,
  `address` text NOT NULL,
  `last_study` text NOT NULL,
  `email` text NOT NULL,
  `experience` text NOT NULL,
  `skill` text NOT NULL,
  `npwp` text NOT NULL,
  `sex` text NOT NULL,
  `nationality` text NOT NULL,
  `status` text NOT NULL,
  `position` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expert`
--

INSERT INTO `expert` (`id`, `company_id`, `name`, `birthday`, `address`, `last_study`, `email`, `experience`, `skill`, `npwp`, `sex`, `nationality`, `status`, `position`) VALUES
(1, 1, 'Nama 2', '2022-07-11', 'Alamat', ' Pendidikan Terakhir', 'Email', ' Pengalaman Kerja (Tahun)', ' Profesi/Keahlian', 'NPWP', 'Laki Laki', 'Kewarganegaraan', 'Tidak Tetap', 'Jabatan');

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
(8, 'tpphp', 'tpphp'),
(9, 'penyedia', 'penyedia');

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
(117, 7, 'Paket', 'pt/paket', '-', 'home', 1, 1, '-'),
(118, 9, 'Tender', 'penyedia/tender', '-', 'home', 1, 1, '-'),
(119, 9, 'Perusahaan Saya', 'penyedia/company', '-', 'home', 1, 1, '-'),
(120, 7, 'Tender Tayang', 'pt/tender', '-', 'home', 1, 1, '-');

-- --------------------------------------------------------

--
-- Table structure for table `ownership`
--

CREATE TABLE `ownership` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `id_number` text NOT NULL,
  `address` text NOT NULL,
  `shared` text NOT NULL,
  `unit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ownership`
--

INSERT INTO `ownership` (`id`, `company_id`, `name`, `id_number`, `address`, `shared`, `unit`) VALUES
(5, 1, 'Nama', ' Nomor KTP', 'Alamat', 'Saham', ' Satuan(Lembar/Persen)');

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
(4, 2, 18, 'test tender 2', 1, '2022-07-09', 'Aktif'),
(5, 6, 16, 'Mobil', 3, '2022-07-12', 'Aktif'),
(6, 7, 16, 'Pengadaan Aqua Gelas', 4, '2022-07-13', 'Non Aktif');

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
(1, 'pokmil 1', 'pokmil 1', 19, 20, 21, 0, 0, '2022-07-06', 'Aktif'),
(2, 'test pokmil 2', 'test pokmil 2', 20, 21, 19, 0, 0, '2022-07-09', 'Aktif'),
(3, 'Local', 'pa@gmail', 19, 20, 21, 0, 0, '2022-07-12', 'Aktif'),
(4, 'Tim Sukses', '38999543', 19, 20, 21, 0, 0, '2022-07-13', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `tender_id` int(11) NOT NULL,
  `announcement_start_date` datetime NOT NULL,
  `announcement_end_date` datetime NOT NULL,
  `file_download_start_date` datetime NOT NULL,
  `file_download_end_date` datetime NOT NULL,
  `explanation_start_date` datetime NOT NULL,
  `explanation_end_date` datetime NOT NULL,
  `effering_file_upload_start_date` datetime NOT NULL,
  `effering_file_upload_end_date` datetime NOT NULL,
  `proof_offering_start_date` datetime NOT NULL,
  `proof_offering_end_date` datetime NOT NULL,
  `evaluation_start_date` datetime NOT NULL,
  `evaluation_end_date` datetime NOT NULL,
  `proof_qualification_start_date` datetime NOT NULL,
  `proof_qualification_end_date` datetime NOT NULL,
  `winner_settle_start_date` datetime NOT NULL,
  `winner_settle_end_date` datetime NOT NULL,
  `winner_announcement_start_date` datetime NOT NULL,
  `winner_announcement_end_date` datetime NOT NULL,
  `interuption_start_date` datetime NOT NULL,
  `interuption_end_date` datetime NOT NULL,
  `choose_letter_start_date` datetime NOT NULL,
  `choose_letter_end_date` datetime NOT NULL,
  `signing_start_date` datetime NOT NULL,
  `signing_end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `tender_id`, `announcement_start_date`, `announcement_end_date`, `file_download_start_date`, `file_download_end_date`, `explanation_start_date`, `explanation_end_date`, `effering_file_upload_start_date`, `effering_file_upload_end_date`, `proof_offering_start_date`, `proof_offering_end_date`, `evaluation_start_date`, `evaluation_end_date`, `proof_qualification_start_date`, `proof_qualification_end_date`, `winner_settle_start_date`, `winner_settle_end_date`, `winner_announcement_start_date`, `winner_announcement_end_date`, `interuption_start_date`, `interuption_end_date`, `choose_letter_start_date`, `choose_letter_end_date`, `signing_start_date`, `signing_end_date`) VALUES
(1, 2, '2022-07-05 19:15:00', '0000-00-00 00:00:00', '2022-07-09 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2022-07-13 09:05:00', '2022-07-21 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 5, '2022-07-12 00:01:00', '2022-08-25 23:59:00', '2022-07-13 00:14:00', '2022-07-15 00:00:00', '2022-07-26 00:01:00', '2022-07-20 12:04:00', '2022-07-13 13:04:00', '2022-07-20 12:04:00', '2022-07-31 21:09:00', '2022-08-03 21:10:00', '2022-07-26 23:04:00', '2022-07-19 12:04:00', '2022-07-21 21:07:00', '2022-07-17 21:09:00', '2022-08-03 21:08:00', '2022-07-28 12:05:00', '2022-07-29 21:11:00', '2022-07-28 12:05:00', '2022-07-29 15:05:00', '2022-08-05 12:08:00', '2022-08-06 21:10:00', '2022-08-05 14:05:00', '2022-08-03 21:12:00', '2022-07-26 14:06:00'),
(3, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2022-07-14 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `date` date NOT NULL,
  `cert_no` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `company_id`, `name`, `date`, `cert_no`) VALUES
(2, 1, ' Nama Pajak', '2022-06-30', ' Nomor Bukti');

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
  `status` text NOT NULL,
  `requirement_file` text NOT NULL,
  `election_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender`
--

INSERT INTO `tender` (`id`, `code`, `name`, `type`, `budget`, `budget_source`, `year`, `location`, `method`, `start_date`, `end_date`, `status`, `requirement_file`, `election_file`) VALUES
(1, '45632187', 'Pembangunan Gedung Kantor Cabang BPD', 'Barang/Pekerjaan', 1000000, 'Dana Belanja', 2022, 'Kab. Buton Utara', 'Tender', '2022-07-25', '2022-07-29', 'Tayang', '', ''),
(2, '34587621', 'Pemeliharaan Gedung ATM', 'Konstruksi/Jasa', 1000000000, 'Dana Belanja', 2022, 'Kab. Konawe', 'Tender', '2022-07-04', '2022-07-08', 'Tayang', '', ''),
(4, '12345678', 'Pengadaan Komputer Server', 'Barang/Pekerjaan', 350000000, 'Dana Belanja', 2022, 'Kota Kendari', 'Tender', '2022-07-18', '2022-07-22', 'Tayang', '', ''),
(5, '89296145', 'Mobil', 'Barang/Pekerjaan', 100000000, 'umum', 2022, 'kota', 'Tender', '2022-07-12', '2022-07-29', 'Tayang', 'Persyaratan_1657762823.pdf', 'TENDER_1657763315.pdf'),
(6, '12345678', 'Pengadaan Aqua Gelas', 'Barang/Pekerjaan', 8000000, 'Bank', 2022, 'Kendari', 'Tender', '2022-07-13', '2022-07-29', 'Rencana', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tender_penyedia`
--

CREATE TABLE `tender_penyedia` (
  `id` int(11) NOT NULL,
  `tender_id` int(11) NOT NULL,
  `penyedia_id` int(11) NOT NULL,
  `effering_file` text NOT NULL,
  `administration` tinyint(1) NOT NULL,
  `technical` tinyint(1) NOT NULL,
  `budget` tinyint(1) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tender_penyedia`
--

INSERT INTO `tender_penyedia` (`id`, `tender_id`, `penyedia_id`, `effering_file`, `administration`, `technical`, `budget`, `position`) VALUES
(6, 1, 23, '', 0, 0, 0, 0),
(7, 2, 23, 'Penawaran_1657557265.pdf', 0, 0, 0, 0),
(8, 1, 15, '', 0, 0, 0, 0),
(9, 4, 13, '', 0, 0, 0, 0),
(10, 4, 23, '', 1, 0, 0, 0),
(11, 5, 23, 'Penawaran_1657632426.pdf', 1, 0, 0, 5),
(12, 5, 29, '', 0, 0, 0, 0),
(13, 6, 31, 'Penawaran_1657696254.pdf', 0, 0, 0, 0),
(16, 6, 32, 'Penawaran_1657771551.pdf', 0, 0, 0, 0),
(17, 5, 32, 'Penawaran_1657772841.pdf', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tool`
--

CREATE TABLE `tool` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` text NOT NULL,
  `condition` text NOT NULL,
  `year` text NOT NULL,
  `location` text NOT NULL,
  `cert_no` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tool`
--

INSERT INTO `tool` (`id`, `company_id`, `name`, `quantity`, `capacity`, `type`, `condition`, `year`, `location`, `cert_no`) VALUES
(1, 1, ' Nama Alat 22', 2, 2, ' Merk/Tipe', 'Kondisi', '1234', ' Lokasi Sekarang', ' Bukti Kepemilikan (Nomor) 2');

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
(1, '127.0.0.1', 'admin@fixl.com', '$2y$12$ydMl5gvUnv.r3KM2wHV5jeCsHrkbyRhFJRSiZRwRjsIE/27obAqcO', 'admin@fixl.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1657541098, 1, 'Admin', 'istrator', '081342989185', 'USER_1_1656405871.jpg', 'admin', '', '', '', NULL, '', NULL, ''),
(13, '::1', 'uadmin@gmail.com', '$2y$10$78SZyvKRKMU7nPCew9w4nOpEUmJ1SeTV4L4ZG2NXXSfbEaswqoepq', 'uadmin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1568678256, 1657790218, 1, 'admin', 'PPE', '00', 'USER_13_1568678463.jpg', 'jln mutiara no 8', '', '', '', NULL, '', NULL, ''),
(15, '127.0.0.1', 'pjp@gmail.com', '$2y$10$E80s6WQogVzBF2ZTAL9k3.MiwoqUet7l1u43St9/sdhkEUBrvqvji', 'pjp@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1656407833, 1657790887, 1, 'Penanggungjawab Pengadaan', 'PJP', '1923847983', 'default.jpg', 'pjp', '', '', '', '0000-00-00', '', '2022-07-07', 'Aktif'),
(16, '127.0.0.1', 'pa@gmail.com', '$2y$10$5GEKL2bU1fhMNqnvI7l.s.uPXXiYwhG0TZ1E55QvIYPQzxiC2dpgy', 'pa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114148, 1657790874, 1, 'Direktur Utama', 'PA', '1023897', 'default.jpg', 'alamat', 'nrrp', 'jabatan', 'alskdhf', '2022-07-06', 'asdfilkj', '2022-07-06', 'Aktif'),
(19, '127.0.0.1', 'pt@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, 1657790911, 1, 'Panitia Tender', 'PT - 01', '-91847', 'default.jpg', 'alamat', '', '', '', '0000-00-00', '', '2022-07-07', 'Aktif'),
(20, '127.0.0.1', 'pt2@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, 1657790297, 1, 'Panitia Tender', 'PT - 02', '-91847', 'default.jpg', 'alamat', 'nrrp', 'alksdfhj', 'alksdhlf', '2022-07-06', 'asdfasdf', '2022-07-06', 'Aktif'),
(21, '127.0.0.1', 'pt3@gmail.com', '$2y$10$CXjHKVY6fPyEnZQlf3kU2.xM.GeLXGjbDbiwvump/oq.7AsZBZfGC', 'pt3@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657114417, NULL, 1, 'Panitia Tender', 'PT - 03', '-91847', 'default.jpg', 'alamat', 'nrrp', 'alksdfhj', 'alksdhlf', '2022-07-06', 'asdfasdf', '2022-07-06', 'Aktif'),
(23, '127.0.0.1', 'penyedia@gmail.com', '$2y$10$vOyp6wdUdPNbSHfLfV2AzO7EmN3l11d42zq5MVd6c.KoXtXpj/a3S', 'penyedia@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657431943, 1657790933, 1, 'Penyedia', 'Barang/Jasa', '143554523', 'default.jpg', 'almat', '', '', '', '0000-00-00', '', '0000-00-00', 'Aktif'),
(30, '180.251.149.200', 'pjp6@gmail.com', '$2y$10$u1yb264AGuzljlPrlG7Pd.E2Y8gyk2LfHt3mYzS3.e6tVhhEGsXfS', 'pjp6@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657693298, NULL, 1, 'PJP', 'pjp', '3487374', 'default.jpg', 'Jl. Kompleks Perkantoran Bumi Praja Anduonohu Gedung III Lantai 3', '23445', 'Kepala', '123456', '2022-07-21', '56789', '2022-07-29', 'Aktif'),
(31, '180.251.149.200', 'akukamu@gmail.com', '$2y$10$wCpY6WGoIGuVDUmisCCxK.ihK/YQiG4ypXx7KaEdiCFNGi3vLmVvS', 'akukamu@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657695982, 1657696340, 1, 'Aku', 'Kamu', '08229122233', 'default.jpg', 'Jl jl', '', '', '', '0000-00-00', '', '0000-00-00', 'Aktif'),
(32, '127.0.0.1', 'penyedia2@gmail.com', '$2y$10$4ZIszXxjViT3jr01egdU8O.DQxl2911WhFnK4d56Ghf4ysu1fbrOm', 'penyedia2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1657770857, 1657788751, 1, 'Nama Depan', 'Nama Belakang', '0123740987', 'default.jpg', 'l;asdjf', '', '', '', NULL, '', NULL, '');

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
(83, 15, 6),
(84, 16, 5),
(57, 19, 7),
(58, 20, 7),
(59, 21, 7),
(60, 23, 9),
(79, 30, 6),
(82, 31, 9),
(85, 32, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acta`
--
ALTER TABLE `acta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_permission`
--
ALTER TABLE `company_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `draft_tender`
--
ALTER TABLE `draft_tender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expert`
--
ALTER TABLE `expert`
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
-- Indexes for table `ownership`
--
ALTER TABLE `ownership`
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
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender`
--
ALTER TABLE `tender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tender_penyedia`
--
ALTER TABLE `tender_penyedia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tool`
--
ALTER TABLE `tool`
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
-- AUTO_INCREMENT for table `acta`
--
ALTER TABLE `acta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `company_permission`
--
ALTER TABLE `company_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `draft_tender`
--
ALTER TABLE `draft_tender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `expert`
--
ALTER TABLE `expert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
--
-- AUTO_INCREMENT for table `ownership`
--
ALTER TABLE `ownership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pokmil`
--
ALTER TABLE `pokmil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tender`
--
ALTER TABLE `tender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tender_penyedia`
--
ALTER TABLE `tender_penyedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tool`
--
ALTER TABLE `tool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
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
