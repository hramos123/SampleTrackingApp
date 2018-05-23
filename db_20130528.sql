-- --------------------------------------------------------
-- Host:                         50.116.98.111
-- Server version:               5.5.23-55 - Percona Server (GPL), Release rel25.3, Revision 2
-- Server OS:                    Linux
-- HeidiSQL version:             7.0.0.4147
-- Date/time:                    2013-05-28 16:23:15
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for hramos_dndn01
CREATE DATABASE IF NOT EXISTS `hramos_dndn01` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `hramos_dndn01`;


-- Dumping structure for table hramos_dndn01.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='admin table';

-- Dumping data for table hramos_dndn01.admin: 2 rows
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`, `email`, `role`, `name`, `status`, `date`) VALUES
	(1, 'admin', 'YWRtaW4=', 'honeyonsys@gmail.com', 0, 'Harish', 1, '4 jan 2012, 11:35 AM'),
	(3, 'hramos', 'YWJjeHl6', 'ramoshf@gmail.com', 0, 'Hector', 1, 'March 30th, 2013 8:00 PM');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.assays
CREATE TABLE IF NOT EXISTS `assays` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table hramos_dndn01.assays: ~18 rows (approximately)
/*!40000 ALTER TABLE `assays` DISABLE KEYS */;
INSERT INTO `assays` (`id`, `name`) VALUES
	(3, 'ForteBio'),
	(4, 'Western'),
	(5, 'Caliper'),
	(6, 'Gel'),
	(7, 'RP HPLC'),
	(8, 'AEX'),
	(9, 'SEC'),
	(10, 'MALS'),
	(11, 'Peptice Map'),
	(12, 'Glycan Profiling'),
	(13, 'LC-MS Analysis'),
	(14, 'CD'),
	(15, 'DSC'),
	(16, 'Luninex'),
	(17, 'TF1'),
	(18, 'BTA'),
	(19, 'ELISA'),
	(20, 'Hybridoma');
/*!40000 ALTER TABLE `assays` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.experiments
CREATE TABLE IF NOT EXISTS `experiments` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` smallint(5) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `description` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `goal` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `department_origin` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_experiments_project` (`project_id`),
  CONSTRAINT `experiments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `FK_experiments_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table hramos_dndn01.experiments: ~4 rows (approximately)
/*!40000 ALTER TABLE `experiments` DISABLE KEYS */;
INSERT INTO `experiments` (`id`, `project_id`, `name`, `description`, `goal`, `department_origin`) VALUES
	(1, 2, 'Clips reduction', 'Try various experimental parameters in the production of the pro', 'Find conditions that reduce the production of clipped proteins', '630'),
	(3, 1, 'New virus', 'New virus was created to increase yield of PA production.', 'Compare the product to see if it is identical to the product cre', '630'),
	(7, 1, 'Working Cell Bank', 'Trying to use a working cell bank (WCB) instead of the master ce', 'Compare the PA produced with the working cell bank to the one pr', '625'),
	(36, 1, 'test Exp', 'lkjfd lskldsfj', 'kljsdlfkjsf', '444');
/*!40000 ALTER TABLE `experiments` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.mailing_lists
CREATE TABLE IF NOT EXISTS `mailing_lists` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.mailing_lists: ~8 rows (approximately)
/*!40000 ALTER TABLE `mailing_lists` DISABLE KEYS */;
INSERT INTO `mailing_lists` (`id`, `name`) VALUES
	(1, 'Proteomics'),
	(2, 'Protein Analytics'),
	(3, 'Bioassays'),
	(4, 'Downstream'),
	(5, 'Upstream'),
	(6, 'NA'),
	(8, 'Research'),
	(9, 'Process Science');
/*!40000 ALTER TABLE `mailing_lists` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table hramos_dndn01.projects: ~2 rows (approximately)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `name`, `description`) VALUES
	(1, 'PA2024', '<p>anything involving <strong>PA2024</strong></p>'),
	(2, 'BA7072', '<p>anything involving <strong>BA7074</strong></p>');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.samples
CREATE TABLE IF NOT EXISTS `samples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sampleset_id` mediumint(8) unsigned NOT NULL,
  `sample_id` varchar(32) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `assay_requested` smallint(5) unsigned NOT NULL,
  `assay_performed` smallint(5) unsigned DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `estimated_concentration` float DEFAULT NULL,
  `measured_concentration` float DEFAULT NULL,
  `ph` float DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `analyzed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_samples_assays` (`assay_requested`),
  KEY `FK_samples_assays2` (`assay_performed`),
  CONSTRAINT `FK_samples_assays` FOREIGN KEY (`assay_requested`) REFERENCES `assays` (`id`),
  CONSTRAINT `FK_samples_assays2` FOREIGN KEY (`assay_performed`) REFERENCES `assays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.samples: ~177 rows (approximately)
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
INSERT INTO `samples` (`id`, `sampleset_id`, `sample_id`, `description`, `assay_requested`, `assay_performed`, `status`, `estimated_concentration`, `measured_concentration`, `ph`, `location`, `analyzed`) VALUES
	(1, 1, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A1', 0),
	(2, 1, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A2', 0),
	(3, 1, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A3', 0),
	(4, 1, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A4', 0),
	(5, 1, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A5', 0),
	(6, 1, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A6', 0),
	(7, 1, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A7', 0),
	(8, 1, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A8', 0),
	(9, 3, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A1', 0),
	(10, 3, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A2', 0),
	(11, 3, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A3', 0),
	(12, 3, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A4', 0),
	(13, 3, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A5', 0),
	(14, 3, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A6', 0),
	(15, 3, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A7', 0),
	(16, 3, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A8', 0),
	(17, 4, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A1', 0),
	(18, 4, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A2', 0),
	(19, 4, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A3', 0),
	(20, 4, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A4', 0),
	(21, 4, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A5', 0),
	(22, 4, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A6', 0),
	(23, 4, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A7', 0),
	(24, 4, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A8', 0),
	(25, 5, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A1', 0),
	(26, 5, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A2', 0),
	(27, 5, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A3', 0),
	(28, 5, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A4', 0),
	(29, 5, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A5', 0),
	(30, 5, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A6', 0),
	(31, 5, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A7', 0),
	(32, 5, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, NULL, 5.5, 'A8', 0),
	(33, 6, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(34, 6, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(35, 6, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(36, 6, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(37, 6, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(38, 6, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(39, 6, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(40, 6, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(41, 6, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(42, 6, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(43, 6, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(44, 7, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(45, 7, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(46, 7, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(47, 7, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(48, 7, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(49, 7, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(50, 7, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(51, 7, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(52, 7, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(53, 7, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(54, 7, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(55, 8, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(56, 8, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(57, 8, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(58, 8, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(59, 8, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(60, 8, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(61, 8, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(62, 8, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(63, 8, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(64, 8, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(65, 8, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(66, 9, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(67, 9, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(68, 9, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(69, 9, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(70, 9, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(71, 9, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(72, 9, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(73, 9, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(74, 9, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(75, 9, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(76, 9, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(77, 10, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(78, 10, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(79, 10, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(80, 10, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(81, 10, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(82, 10, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(83, 10, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(84, 10, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(85, 10, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(86, 10, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(87, 10, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(88, 11, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(89, 11, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(90, 11, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(91, 11, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(92, 11, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(93, 11, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(94, 11, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(95, 11, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(96, 11, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(97, 11, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(98, 11, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(99, 12, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(100, 12, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(101, 12, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(102, 12, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(103, 12, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(104, 12, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(105, 12, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(106, 12, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(107, 12, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(108, 12, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(109, 12, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(110, 13, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(111, 13, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(112, 13, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(113, 13, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(114, 13, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(115, 13, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(116, 13, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(117, 13, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(118, 13, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(119, 13, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(120, 13, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(121, 14, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(122, 14, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(123, 14, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(124, 14, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(125, 14, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(126, 14, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(127, 14, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(128, 14, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(129, 14, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(130, 14, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(131, 14, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(132, 15, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(133, 15, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(134, 15, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(135, 15, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(136, 15, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(137, 15, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(138, 15, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(139, 15, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(140, 15, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(141, 15, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(142, 15, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(143, 16, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(144, 16, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(145, 16, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(146, 16, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(147, 16, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(148, 16, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(149, 16, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A7', 0),
	(150, 16, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A8', 0),
	(151, 16, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A9', 0),
	(152, 16, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A10', 0),
	(153, 16, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 2.2, NULL, 3.4, 'A11', 0),
	(154, 17, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A1', 0),
	(155, 17, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A2', 0),
	(156, 17, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A3', 0),
	(157, 17, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A4', 0),
	(158, 18, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A5', 0),
	(159, 18, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 2.2, NULL, 3.4, 'A6', 0),
	(160, 21, '2', 'lkjdf', 3, NULL, 0, 1, NULL, 4, '1', 0),
	(161, 22, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, NULL, NULL, 2.2, 'A8', 0),
	(162, 22, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A9', 0),
	(163, 22, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A10', 0),
	(164, 22, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A11', 0),
	(165, 23, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 333, NULL, 2.2, 'A8', 0),
	(166, 23, '9', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A9', 0),
	(167, 23, '10', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A10', 0),
	(168, 23, '11', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'A11', 0),
	(169, 27, 'f', 'f', 18, NULL, 0, 5, NULL, 3, 'sdf', 0),
	(170, 28, '14', '012513-A1 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 3, NULL, 2.2, 'B2', 0),
	(171, 28, '15', '012513-A2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 3, NULL, 2.2, 'B3', 0),
	(172, 28, '16', '012513-A4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, 3, NULL, 2.2, 'B4', 0),
	(173, 28, '17', '012513-EZ2 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, 3, NULL, 2.2, 'B5', 0),
	(174, 28, '18', '012513-EZ3 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, 3, NULL, 2.2, 'B6', 0),
	(175, 28, '19', '012513-EZ4 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, 3, NULL, 2.2, 'B7', 0),
	(176, 29, '14', '012513-A1 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'B2', 0),
	(177, 29, '15', '012513-A2 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'B3', 0),
	(178, 29, '16', '012513-A4 (Round 1 - 40hpi) QXL Load t=24 (4C)', 3, NULL, 0, NULL, NULL, 2.2, 'B4', 0),
	(179, 29, '17', '012513-EZ2 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, NULL, NULL, 2.2, 'B5', 0),
	(180, 29, '18', '012513-EZ3 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, NULL, NULL, 2.2, 'B6', 0),
	(181, 29, '19', '012513-EZ4 (Round 2 - 56hpi) QXL Load t=0', 3, NULL, 0, NULL, NULL, 2.2, 'B7', 0),
	(182, 30, '1', 'fasfg', 8, NULL, 0, NULL, NULL, 7, '2', 0),
	(183, 32, '2', 'fernando', 3, NULL, 0, 3, NULL, 2.2, '1', 0),
	(184, 35, 'A1', '120412-EZ4', 8, NULL, 0, 1, 5, 7, NULL, 0),
	(185, 35, 'A2', '120412-EZ6', 8, NULL, 0, 1, 5, 7, NULL, 0),
	(186, 35, 'A3', '120412-EZ7', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(187, 35, 'A4', '120412-EZ8', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(188, 35, 'A5', '120412-B2', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(189, 35, 'A6', '120412-B4', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(190, 35, 'A7', '120412-B7', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(191, 35, 'A8', '120412-B8', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(192, 35, 'A9', '120412-C2', 8, NULL, 0, 1, 5, 5, NULL, 0),
	(193, 35, 'A10', '120412-C4', 8, NULL, 0, 1, 5, 7, NULL, 0),
	(194, 35, 'A11', '120412-C8', 8, NULL, 0, 1, 5, 7, NULL, 0),
	(195, 35, 'A12', '120412-EZ4', 5, NULL, 0, 1, 5, 7, NULL, 0),
	(196, 35, 'B1', '120412-EZ6', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(197, 35, 'B2', '120412-EZ7', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(198, 35, 'B3', '120412-EZ8', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(199, 35, 'B4', '120412-B2', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(200, 35, 'B5', '120412-B4', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(201, 35, 'B6', '120412-B7', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(202, 35, 'B7', '120412-B8', 5, NULL, 0, 1, 3, 7, NULL, 0),
	(203, 35, 'B8', '120412-C2', 5, NULL, 0, 1, 5, 7, NULL, 0),
	(204, 35, 'B9', '120412-C4', 5, NULL, 0, 1, 5, 7, NULL, 0),
	(205, 35, 'B10', '120412-C8', 5, NULL, 0, 1, 5, 7, NULL, 0),
	(206, 36, 'A1', '120412-EZ4', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(207, 36, 'A2', '120412-EZ6', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(208, 36, 'A3', '120412-EZ7', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(209, 36, 'A4', '120412-EZ8', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(210, 36, 'A5', '120412-B2', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(211, 36, 'A6', '120412-B4', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(212, 36, 'A7', '120412-B7', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(213, 36, 'A8', '120412-B8', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(214, 36, 'A9', '120412-C2', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(215, 36, 'A10', '120412-C4', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(216, 36, 'A11', '120412-C8', 9, NULL, 0, 1, NULL, 7, NULL, 0),
	(217, 36, 'A12', '120412-EZ4', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(218, 36, 'B1', '120412-EZ6', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(219, 36, 'B2', '120412-EZ7', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(220, 36, 'B3', '120412-EZ8', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(221, 36, 'B4', '120412-B2', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(222, 36, 'B5', '120412-B4', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(223, 36, 'B6', '120412-B7', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(224, 36, 'B7', '120412-B8', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(225, 36, 'B8', '120412-C2', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(226, 36, 'B9', '120412-C4', 7, NULL, 0, 1, NULL, 7, NULL, 0),
	(227, 36, 'B10', '120412-C8', 7, NULL, 0, 1, NULL, 7, NULL, 0);
/*!40000 ALTER TABLE `samples` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.sampleSets
CREATE TABLE IF NOT EXISTS `sampleSets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `experiment_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `submission_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expected_completion_date` datetime NOT NULL,
  `priority` smallint(5) unsigned NOT NULL DEFAULT '3',
  `submitted_by` smallint(5) unsigned NOT NULL DEFAULT '0',
  `submitted_to` smallint(5) unsigned NOT NULL DEFAULT '0',
  `analyzed_by` smallint(5) unsigned DEFAULT NULL,
  `reviewed_by` smallint(5) unsigned DEFAULT NULL,
  `storage_temp` varchar(64) DEFAULT NULL,
  `theorized_concentration` varchar(64) DEFAULT NULL,
  `result_type` set('Quantitative','Qualitative') DEFAULT NULL,
  `require_raw_data` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `provide_spent_media` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `chromatogram_overlays` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `information_sought` varchar(256) DEFAULT NULL,
  `result_format` varchar(128) DEFAULT NULL,
  `results_location` varchar(128) DEFAULT NULL,
  `keep_samples` varchar(8) DEFAULT NULL,
  `status` tinyint(3) unsigned DEFAULT '1',
  `comments` varchar(768) DEFAULT NULL,
  `matrix_comments` varchar(128) DEFAULT NULL,
  `date_analyzed` datetime DEFAULT NULL,
  `date_reviewed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_samplesSets_status` (`status`),
  KEY `FK_samplesSets_submittedto` (`submitted_to`),
  KEY `FK_samplesSets_submittedBy` (`submitted_by`),
  KEY `FK_samplesSets_analyzedBy` (`analyzed_by`),
  KEY `FK_samplesSets_reviewedBy` (`reviewed_by`),
  KEY `FK_samplesSets_experiment` (`experiment_id`),
  CONSTRAINT `FK_samplesSets_analyzedBy` FOREIGN KEY (`analyzed_by`) REFERENCES `staff_list` (`id`),
  CONSTRAINT `FK_samplesSets_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `experiments` (`id`),
  CONSTRAINT `FK_samplesSets_reviewedBy` FOREIGN KEY (`reviewed_by`) REFERENCES `staff_list` (`id`),
  CONSTRAINT `FK_samplesSets_status` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`),
  CONSTRAINT `FK_samplesSets_submittedBy` FOREIGN KEY (`submitted_by`) REFERENCES `staff_list` (`id`),
  CONSTRAINT `FK_samplesSets_submittedto` FOREIGN KEY (`submitted_to`) REFERENCES `staff_list` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.sampleSets: ~31 rows (approximately)
/*!40000 ALTER TABLE `sampleSets` DISABLE KEYS */;
INSERT INTO `sampleSets` (`id`, `name`, `experiment_id`, `submission_date`, `expected_completion_date`, `priority`, `submitted_by`, `submitted_to`, `analyzed_by`, `reviewed_by`, `storage_temp`, `theorized_concentration`, `result_type`, `require_raw_data`, `provide_spent_media`, `chromatogram_overlays`, `information_sought`, `result_format`, `results_location`, `keep_samples`, `status`, `comments`, `matrix_comments`, `date_analyzed`, `date_reviewed`) VALUES
	(1, 'Hector Test1', 3, '2013-04-11 15:07:01', '2013-04-15 00:00:00', 3, 8, 6, NULL, NULL, '-70', NULL, 'Quantitative,Qualitative', 0, 1, 1, NULL, NULL, NULL, NULL, 6, 'They smell really really funny.', NULL, NULL, NULL),
	(2, 'test 2', 1, '2013-04-11 15:39:16', '2013-04-16 00:00:00', 22, 8, 7, 7, NULL, '-70', NULL, 'Quantitative,Qualitative', 1, 1, 0, 'precision', NULL, NULL, NULL, 3, NULL, 'peg', NULL, NULL),
	(3, 'test 2', 1, '2013-04-11 15:39:59', '2013-04-16 00:00:00', 5, 8, 6, NULL, NULL, '-70', NULL, 'Quantitative,Qualitative', 1, 1, 0, 'precision', NULL, NULL, NULL, 4, 'don\'t taste them!', 'peg', NULL, NULL),
	(4, 'to Simon', 7, '2013-04-11 16:38:28', '2013-04-24 00:00:00', 3, 8, 5, 6, 5, '-90', NULL, 'Qualitative', 0, 1, 1, 'conc.', 'excel, msms', 'right here', NULL, 9, 'leave them alone.', 'peg', '2013-04-11 00:00:00', '2013-04-11 00:00:00'),
	(5, 'hec to simon 2', 7, '2013-04-16 09:50:25', '2013-04-18 00:00:00', 3, 8, 5, 6, NULL, NULL, NULL, 'Qualitative', 1, 1, 0, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL),
	(6, 'd gfh', 7, '2013-04-22 13:24:06', '2013-04-24 00:00:00', 3, 8, 7, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 7, 'they smell funny.\n\nREJECTED: cuz it sucks!', NULL, NULL, NULL),
	(7, 'oooooo', 7, '2013-04-22 13:33:24', '2013-04-24 00:00:00', 3, 8, 7, 7, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 4, 'they smell funny.\n\nREJECTED:  no no no.  ugly.', NULL, NULL, NULL),
	(8, 'hhhh hhhh', 7, '2013-04-22 13:34:11', '2013-04-24 00:00:00', 3, 8, 7, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 7, 'they smell funny.\n\nREJECTED: no! no sir', NULL, NULL, NULL),
	(9, '9999999', 7, '2013-04-22 13:35:37', '2013-04-24 00:00:00', 22, 8, 13, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL),
	(10, 'Monday\'s Work', 7, '2013-04-22 13:37:44', '2013-04-24 00:00:00', 3, 8, 7, 7, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 6, 'they smell funny.', NULL, NULL, NULL),
	(11, 'jjjj jjj jj j ', 7, '2013-04-22 13:40:26', '2013-04-24 00:00:00', 3, 8, 7, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 7, 'they smell funny.\n\nREJECTED: dsgs sdgdsgds', NULL, NULL, NULL),
	(12, 'Monday\'s Work', 7, '2013-04-22 13:40:51', '2013-04-24 00:00:00', 3, 8, 7, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 7, 'they smell funny.\n\nREJECTED: lkjdf lksjdf lkjdsf \n\nREJECTED: no no.  not good', NULL, NULL, NULL),
	(13, 'erterterter', 7, '2013-04-22 13:42:07', '2013-04-24 00:00:00', 3, 8, 7, 7, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 6, 'they smell funny.', NULL, NULL, NULL),
	(14, 'Monday\'s Work', 7, '2013-04-23 17:32:53', '2013-04-24 00:00:00', 3, 8, 7, 7, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 4, 'they smell funny.', NULL, '2013-05-05 23:24:54', NULL),
	(15, 'uuu u uuu', 7, '2013-04-23 18:08:11', '2013-04-24 00:00:00', 3, 8, 15, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 9, 'they smell funny.', NULL, NULL, NULL),
	(16, 'llllll  llllll', 7, '2013-04-24 14:59:28', '2013-04-24 00:00:00', 3, 8, 7, NULL, NULL, NULL, NULL, 'Quantitative', 1, 1, 1, 'concentration', NULL, NULL, NULL, 4, 'they smell funny.', NULL, NULL, NULL),
	(17, 'hec 2 brian', 3, '2013-04-25 13:30:02', '2013-04-27 00:00:00', 3, 8, 15, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
	(18, 'XYZ', 7, '2013-04-26 09:38:37', '2013-04-28 00:00:00', 4, 8, 6, 7, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL),
	(19, 'asap sample', 1, '2013-04-26 10:33:23', '2013-04-29 00:00:00', 3, 5, 15, NULL, NULL, NULL, NULL, 'Quantitative', 1, 0, 0, 'conc', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
	(20, 'asap sample', 1, '2013-04-26 10:35:18', '2013-04-29 00:00:00', 3, 5, 15, NULL, NULL, NULL, NULL, 'Quantitative', 1, 0, 0, 'conc', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
	(21, 'asap sample', 1, '2013-04-26 10:35:54', '2013-04-29 00:00:00', 3, 5, 15, NULL, NULL, NULL, NULL, 'Quantitative', 1, 0, 0, 'conc', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL),
	(22, 'test xyz', 1, '2013-04-26 14:31:51', '2013-04-28 00:00:00', 3, 8, 15, NULL, NULL, 'sfsdf', NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 1, 'testing testing', 'sfsd', NULL, NULL),
	(23, 'Hec to Deb test', 36, '2013-04-26 15:11:21', '2013-04-28 00:00:00', 3, 8, 7, 7, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, 'ffff', 'fffggggg sdfsdf', NULL, 9, 'sddsf', NULL, '2013-05-24 13:42:34', '2013-05-24 13:47:03'),
	(24, 'No. 24', 1, '2013-05-05 22:34:13', '2013-05-08 00:00:00', 5, 30, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL),
	(25, 'No. 25', 1, '2013-05-05 22:36:02', '2013-05-08 00:00:00', 5, 30, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL),
	(26, 'No. 26', 1, '2013-05-05 22:37:59', '2013-05-08 00:00:00', 5, 30, 6, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 7, NULL, NULL, NULL, NULL),
	(27, 'Orale Buey!', 1, '2013-05-05 22:40:13', '2013-05-08 00:00:00', 5, 30, 6, 6, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 'dsfsdf', 'ccc fff', NULL, 9, 'dfgdf dfg hghhhhhh', NULL, '2013-05-06 14:20:54', '2013-05-24 13:49:03'),
	(28, 'Test 1', 3, '2013-05-06 14:37:02', '2013-05-08 00:00:00', 5, 8, 6, 6, NULL, '-40', NULL, 'Quantitative,Qualitative', 1, 0, 1, 'precision', 'MS Excel', 'on the shared Folder', NULL, 2, NULL, NULL, '2013-05-06 16:40:19', NULL),
	(29, 'test 04', 1, '2013-05-19 01:04:26', '2013-05-21 00:00:00', 3, 28, 6, 6, NULL, NULL, NULL, NULL, 1, 0, 1, NULL, NULL, NULL, NULL, 4, 'no', NULL, NULL, NULL),
	(30, 'breakfast samples', 1, '2013-05-22 16:34:03', '2013-05-24 00:00:00', 3, 8, 5, 6, NULL, '4', NULL, NULL, 0, 0, 1, 'concentration', 'dsfsdfsd', 'sf sd f', NULL, 9, 'this was not good!', 'milk', '2013-05-24 15:45:24', '2013-05-24 16:01:45'),
	(31, 'breakfast samples', 1, '2013-05-23 08:21:23', '2013-05-24 00:00:00', 3, 8, 5, 5, NULL, '4', NULL, 'Quantitative', 0, 0, 1, 'concentration', NULL, NULL, NULL, 4, NULL, 'milk', NULL, NULL),
	(32, 'No. 45', 1, '2013-05-26 16:07:55', '2013-05-28 00:00:00', 4, 8, 6, NULL, NULL, 'room temp', NULL, NULL, 0, 0, 0, 'what they taste like', NULL, NULL, 'no', 1, NULL, 'blah', NULL, NULL),
	(33, 'test sample 1', 3, '2013-05-28 09:47:24', '2013-05-30 00:00:00', 3, 5, 15, NULL, NULL, 'room temp', NULL, 'Qualitative', 0, 0, 1, 'extremely dirty!', NULL, NULL, 'no', 1, 'please run ASAP', 'dirt', NULL, NULL),
	(34, 'test sample 1', 3, '2013-05-28 09:48:17', '2013-05-30 00:00:00', 3, 5, 15, NULL, NULL, 'room temp', NULL, 'Qualitative', 0, 0, 1, 'extremely dirty!', NULL, NULL, 'no', 2, 'please run ASAP', 'dirt', NULL, NULL),
	(35, 'test sample 1', 3, '2013-05-28 09:50:06', '2013-05-30 00:00:00', 3, 5, 15, 15, NULL, 'room temp', NULL, 'Qualitative', 0, 0, 1, 'extremely dirty!', NULL, NULL, 'no', 4, 'please run ASAP', 'dirt', NULL, NULL),
	(36, 'asagah', 1, '2013-05-28 16:07:46', '2013-05-30 00:00:00', 3, 12, 21, NULL, NULL, '-70C', NULL, NULL, 0, 0, 0, 'dgdsfgfdsag', NULL, NULL, 'no', 1, NULL, 'afgafd', NULL, NULL);
/*!40000 ALTER TABLE `sampleSets` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.staff_list
CREATE TABLE IF NOT EXISTS `staff_list` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(1) NOT NULL,
  `first_name` varchar(64) NOT NULL DEFAULT '0',
  `last_name` varchar(64) NOT NULL DEFAULT '0',
  `email` varchar(64) NOT NULL DEFAULT '0',
  `title` set('Supervisor','Analyst','Reviewer','Collaborator','Director') DEFAULT NULL,
  `department` set('610','620','625','630') DEFAULT NULL,
  `mailing_list_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mailing_list_id` (`mailing_list_id`),
  CONSTRAINT `staff_list_ibfk_1` FOREIGN KEY (`mailing_list_id`) REFERENCES `mailing_lists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.staff_list: ~22 rows (approximately)
/*!40000 ALTER TABLE `staff_list` DISABLE KEYS */;
INSERT INTO `staff_list` (`id`, `username`, `password`, `role`, `first_name`, `last_name`, `email`, `title`, `department`, `mailing_list_id`) VALUES
	(5, 'sletarte', 'c2xldGFydGU=', 0, 'Simon', 'Letarte', 'sletarte@dendreon.com', 'Supervisor', '620', 1),
	(6, '', '', 0, 'Jason', 'Luscher', 'jluscher@dendreon.com', 'Analyst', '620', 1),
	(7, '', '', 0, 'Debbie', 'Chang', 'dchang@dendreon.com', 'Analyst', '620', 1),
	(8, 'hramos', 'YWJjeHl6', 1, 'Hector', 'Ramos', 'hector@integrativews.com', 'Supervisor', '620', 1),
	(9, '', '', 0, 'Steve', 'Apone', 'sapone@dendreon.com', 'Director', '620', 6),
	(10, '', '', 0, 'Richard', 'Blackmore', 'rblackmore@dendreon.com', 'Director', '630', 6),
	(11, '', '', 0, 'Roshan', 'Lianage', 'rliyanage@Dendreon.com', 'Supervisor', '620', 2),
	(12, '', '', 0, 'Kate', 'Bailey', 'kbailey@dendreon.com', 'Analyst', '620', 1),
	(13, '', '', 0, 'Doug', 'MacDonald', 'dmacdonald@dendreon.com', 'Collaborator', '630', 4),
	(14, '', '', 0, 'Gina', 'Nichols', 'gnichols@dendreon.com', 'Collaborator', '630', 5),
	(15, '', '', 0, 'Brian', 'Sims-Fahey', 'bsimsfahey@Dendreon.com', 'Analyst', '620', 2),
	(16, '', '', 0, 'Shannon', 'Worster', 'sworster@dendreon.com', 'Collaborator', '630', 5),
	(17, '', '', 0, 'Karen', 'Yoshino', 'kyoshino@Dendreon.com', 'Analyst', '620', 3),
	(18, '', '', 0, 'Patrick', 'Maunder', 'pmaunder@dendreon.com', 'Supervisor', '620', 3),
	(19, '', '', 0, 'David', 'Lee', 'dlee@Dendreon.com', 'Collaborator', '630', 5),
	(20, '', '', 0, 'Richa', 'Rai', 'rrai@Dendreon.com', 'Collaborator', '630', 5),
	(21, '', '', 0, 'Shane', 'Nelson', 'ssnelson@Dendreon.com', 'Collaborator', '630', 5),
	(22, '', '', 0, 'Jeremy', 'Capalungan', 'jcapalungan@Dendreon.com', 'Analyst', '620', 3),
	(23, '', '', 0, 'Randy', 'Ng', 'rng@Dendreon.com', 'Collaborator', '625', 9),
	(28, '', '', 0, 'Craig', 'Meagher', 'cmeagher@dendreon.com', 'Collaborator', '610', 8),
	(29, '', '', 0, 'Joe', 'Rajewski', 'jrajewski@Dendreon.com', 'Collaborator', '625', 9),
	(30, 'admin', 'YWRtaW4=', 1, 'Harish', 'Kumar', 'honeyonsys@gmail.com', 'Supervisor', '620', 4);
/*!40000 ALTER TABLE `staff_list` ENABLE KEYS */;


-- Dumping structure for table hramos_dndn01.statuses
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table hramos_dndn01.statuses: ~7 rows (approximately)
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` (`id`, `status`) VALUES
	(1, 'Submitted'),
	(2, 'Analyzed'),
	(3, 'Reviewed'),
	(4, 'In Progress'),
	(6, 'Accepted'),
	(7, 'Rejected'),
	(9, 'Completed');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
