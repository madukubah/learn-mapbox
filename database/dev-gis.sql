-- MySQL dump 10.13  Distrib 5.7.33, for Linux (x86_64)
--
-- Host: localhost    Database: gis_bombama
-- ------------------------------------------------------
-- Server version	5.7.33-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator'),(2,'uadmin','user admin'),(3,'user','user');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(50) NOT NULL,
  `list_id` varchar(200) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `position` int(4) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (101,1,'Beranda','admin/','home_index','home',1,1,'-'),(102,1,'Group','admin/group','group_index','home',1,2,'-'),(103,1,'Setting','admin/menus','-','cogs',1,3,'-'),(104,1,'User','admin/user_management','user_management_index','users',1,4,'-'),(106,103,'Menu','admin/menus','menus_index','circle',1,1,'-'),(107,2,'Beranda','uadmin/home','home_index','home',1,1,'-'),(108,2,'Pengguna','uadmin/users','users_index','home',1,99,'-'),(109,2,'Paket','uadmin/paket','paket_index','home',1,2,'-');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paket`
--

DROP TABLE IF EXISTS `paket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `physical_progress` int(8) NOT NULL,
  `monetary_progress` int(8) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paket`
--

LOCK TABLES `paket` WRITE;
/*!40000 ALTER TABLE `paket` DISABLE KEYS */;
INSERT INTO `paket` VALUES (1,'PENINGKATAN KUALITAS PERMUKIMAN KUMUH KWS. PUNGGALOBA KEC. KENDARI BARAT KOTA KENDARIKOTA KENDARI, PROVINSI SULAWESI TENGGARA','<p><b>PENINGKATAN KUALITAS PERMUKIMAN KUMUH KWS. PUNGGALOBA KEC. KENDARI BARAT KOTA KENDARIKOTA KENDARI, PROVINSI SULAWESI TENGGARA</b><br></p><p><b><br></b></p><p><b>DESKRIPSI SINGKAT</b><br></p><p>Desa Wisata Kolo terletak di Pulau Togo merupakan salah satu gugusan pulau di Kabupaten Wkatobi dengan Luas Wilayah 866,45 Ha di Wilayah Kecamatan Wangi-Wangi Selatan.&nbsp;</p><p><b>LINGKUP KEGIATAN :</b></p><ul><li>Pekerjaan Jalan Paving Blok P=2.746,23 M</li><li>Pekerjaan Pasangan Talud P=398,10 M</li><li>Pekerjaan Dermaga 1 Unit</li><li>Pekerjaan RTH</li></ul><p><b>WAKTU PELAKSANAAN :</b></p><ul><li>Mulai<span style=\"white-space: pre;\">	</span>: 12 April 2018</li><li>Selesai :&nbsp; 28 Desember 2018</li></ul><p><b>TITIK KOORDINAT :</b></p><ul><li>Latitude&nbsp; &nbsp; &nbsp;: 0123.522533°</li><li>Longitude&nbsp; : - 005.363681°</li></ul><p><b>KEMAJUAN PELAKSANAAN:</b></p><ul><li>Progres fisik&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : 100%&nbsp;</li><li>Progres keuangan&nbsp; :&nbsp; 100%</li></ul><p><b>MANFAAT :</b></p><p>Mendukung aksesibiltas dalam mendistribusikan hasil produksi menuju pasar dan dermaga serta akses ke kawasan permukiman dan pariwisata.</p><p></p>','2021-09-03','2021-09-29','-3.9718923234483583','122.47792433500189',100,100,'PAKET_1632803004.png');
/*!40000 ALTER TABLE `paket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` text NOT NULL,
  `address` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_email` (`email`),
  UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  UNIQUE KEY `uc_remember_selector` (`remember_selector`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','admin@fixl.com','$2y$12$ydMl5gvUnv.r3KM2wHV5jeCsHrkbyRhFJRSiZRwRjsIE/27obAqcO','admin@fixl.com',NULL,'',NULL,NULL,NULL,NULL,NULL,1268889823,1632804826,1,'Admin','istrator','081342989185','USER_1_1571554027.jpeg','admin'),(13,'::1','uadmin@gmail.com','$2y$10$78SZyvKRKMU7nPCew9w4nOpEUmJ1SeTV4L4ZG2NXXSfbEaswqoepq','uadmin@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1568678256,1632968039,1,'admin','Dinas','00','USER_13_1568678463.jpg','jln mutiara no 8'),(14,'127.0.0.1','dinas@gmail.com','$2y$10$jf1DoY5xAPYThOurMt9FH.Rxz4eroAOl0I9uwpFfm7/4D4GPKKZoi','dinas@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1632804971,1632805030,1,'Dinas','Dinas','1234','default.jpg','Alamat');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(29,13,2),(30,14,3);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-30 10:24:43
