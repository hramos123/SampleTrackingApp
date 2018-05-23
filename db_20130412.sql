-- --------------------------------------------------------
-- Host:                         50.116.98.111
-- Server version:               5.5.23-55 - Percona Server (GPL), Release rel25.3, Revision 2
-- Server OS:                    Linux
-- HeidiSQL version:             7.0.0.4147
-- Date/time:                    2013-04-12 14:56:43
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  CONSTRAINT `FK_experiments_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `experiments_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table hramos_dndn01.experiments: ~3 rows (approximately)
/*!40000 ALTER TABLE `experiments` DISABLE KEYS */;
INSERT INTO `experiments` (`id`, `project_id`, `name`, `description`, `goal`, `department_origin`) VALUES
	(1, 2, 'Clips reduction', 'Try various experimental parameters in the production of the pro', 'Find conditions that reduce the production of clipped proteins', '630'),
	(3, 1, 'New virus', 'New virus was created to increase yield of PA production.', 'Compare the product to see if it is identical to the product cre', '630'),
	(7, 1, 'Working Cell Bank', 'Trying to use a working cell bank (WCB) instead of the master ce', 'Compare the PA produced with the working cell bank to the one pr', '625');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `concentration` float DEFAULT NULL,
  `ph` float DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `analyzed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_samples_assays` (`assay_requested`),
  KEY `FK_samples_assays2` (`assay_performed`),
  CONSTRAINT `FK_samples_assays` FOREIGN KEY (`assay_requested`) REFERENCES `assays` (`id`),
  CONSTRAINT `FK_samples_assays2` FOREIGN KEY (`assay_performed`) REFERENCES `assays` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.samples: ~24 rows (approximately)
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
INSERT INTO `samples` (`id`, `sampleset_id`, `sample_id`, `description`, `assay_requested`, `assay_performed`, `status`, `concentration`, `ph`, `location`, `analyzed`) VALUES
	(1, 1, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A1', 0),
	(2, 1, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A2', 0),
	(3, 1, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A3', 0),
	(4, 1, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A4', 0),
	(5, 1, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A5', 0),
	(6, 1, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A6', 0),
	(7, 1, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A7', 0),
	(8, 1, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A8', 0),
	(9, 3, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A1', 0),
	(10, 3, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A2', 0),
	(11, 3, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A3', 0),
	(12, 3, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A4', 0),
	(13, 3, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A5', 0),
	(14, 3, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A6', 0),
	(15, 3, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A7', 0),
	(16, 3, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A8', 0),
	(17, 4, '1', '012513-EZ2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A1', 0),
	(18, 4, '2', '012513-EZ3 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A2', 0),
	(19, 4, '3', '012513-EZ4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A3', 0),
	(20, 4, '4', '012513-EZ5 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A4', 0),
	(21, 4, '5', '012513-EZ7 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A5', 0),
	(22, 4, '6', '012513-A1 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A6', 0),
	(23, 4, '7', '012513-A2 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A7', 0),
	(24, 4, '8', '012513-A4 (Round 1 - 40hpi) QXL Load t=0', 3, NULL, 0, 3.45, 5.5, 'A8', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table hramos_dndn01.sampleSets: ~4 rows (approximately)
/*!40000 ALTER TABLE `sampleSets` DISABLE KEYS */;
INSERT INTO `sampleSets` (`id`, `name`, `experiment_id`, `submission_date`, `expected_completion_date`, `priority`, `submitted_by`, `submitted_to`, `analyzed_by`, `reviewed_by`, `storage_temp`, `theorized_concentration`, `result_type`, `require_raw_data`, `provide_spent_media`, `chromatogram_overlays`, `information_sought`, `result_format`, `results_location`, `status`, `comments`, `matrix_comments`, `date_analyzed`, `date_reviewed`) VALUES
	(1, 'Hector Test1', 3, '2013-04-11 15:07:01', '2013-04-15 00:00:00', 3, 8, 6, NULL, NULL, '-70', NULL, 'Quantitative,Qualitative', 0, 1, 1, NULL, NULL, NULL, 6, 'They smell really really funny.', NULL, NULL, NULL),
	(2, 'test 2', 1, '2013-04-11 15:39:16', '2013-04-16 00:00:00', 5, 8, 7, NULL, NULL, '-70', NULL, 'Quantitative,Qualitative', 1, 1, 0, 'precision', NULL, NULL, 1, 'don\'t taste them!', 'peg', NULL, NULL),
	(3, 'test 2', 1, '2013-04-11 15:39:59', '2013-04-16 00:00:00', 5, 8, 6, NULL, NULL, '-70', NULL, 'Quantitative,Qualitative', 1, 1, 0, 'precision', NULL, NULL, 4, 'don\'t taste them!', 'peg', NULL, NULL),
	(4, 'to Simon', 7, '2013-04-11 16:38:28', '2013-04-24 00:00:00', 3, 8, 5, 6, 5, '-90', NULL, 'Qualitative', 0, 1, 1, 'conc.', 'excel, msms', 'right here', 9, 'leave them alone.', 'peg', '2013-04-11 00:00:00', '2013-04-11 00:00:00');
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
