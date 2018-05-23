-- --------------------------------------------------------
-- Host:                         50.116.98.111
-- Server version:               5.5.23-55 - Percona Server (GPL), Release rel25.3, Revision 2
-- Server OS:                    Linux
-- HeidiSQL version:             7.0.0.4147
-- Date/time:                    2013-06-11 13:24:32
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='admin table';

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.assays
CREATE TABLE IF NOT EXISTS `assays` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.mailing_lists
CREATE TABLE IF NOT EXISTS `mailing_lists` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci DEFAULT '0',
  `description` varchar(256) COLLATE utf8_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.samples
CREATE TABLE IF NOT EXISTS `samples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sampleset_id` mediumint(8) unsigned NOT NULL,
  `sample_id` varchar(32) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `characterization_requested` smallint(5) unsigned NOT NULL,
  `assay_performed` smallint(5) unsigned DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `estimated_concentration` float DEFAULT NULL,
  `measured_concentration` float DEFAULT NULL,
  `ph` float DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `analyzed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_samples_assays` (`characterization_requested`),
  KEY `FK_samples_assays2` (`assay_performed`),
  CONSTRAINT `FK_samples_assays2` FOREIGN KEY (`assay_performed`) REFERENCES `assays` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.sample_characterizations
CREATE TABLE IF NOT EXISTS `sample_characterizations` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table hramos_dndn01.statuses
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
