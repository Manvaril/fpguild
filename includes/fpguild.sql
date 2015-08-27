-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 27, 2015 at 12:57 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fpguild`
--
CREATE DATABASE IF NOT EXISTS `fpguild` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `fpguild`;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_adjustments`
--

CREATE TABLE IF NOT EXISTS `fpguild_adjustments` (
  `adjustment_id` int(11) NOT NULL AUTO_INCREMENT,
  `roster_id` int(11) NOT NULL,
  `adjustment_date` int(11) NOT NULL,
  `adjustment_amount` float(6,2) NOT NULL DEFAULT '0.00',
  `adjustment_desc` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`adjustment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_destinations`
--

CREATE TABLE IF NOT EXISTS `fpguild_destinations` (
  `dest_id` int(11) NOT NULL AUTO_INCREMENT,
  `dest_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `dest_value` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`dest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_events`
--

CREATE TABLE IF NOT EXISTS `fpguild_events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `event_no_signup` tinyint(3) NOT NULL,
  `event_date` int(11) NOT NULL,
  `event_signup_start` int(11) NOT NULL,
  `event_signup_end` int(11) NOT NULL,
  `event_desc` text COLLATE utf8_bin NOT NULL,
  `event_max_signup` int(3) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_event_signups`
--

CREATE TABLE IF NOT EXISTS `fpguild_event_signups` (
  `event_id` int(11) NOT NULL,
  `roster_id` int(11) NOT NULL,
  `signup_late` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_gallery`
--

CREATE TABLE IF NOT EXISTS `fpguild_gallery` (
  `gallery_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gallery_filename` varchar(255) CHARACTER SET latin1 NOT NULL,
  `gallery_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `gallery_comment` text CHARACTER SET latin1 NOT NULL,
  `gallery_date` int(11) NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_items`
--

CREATE TABLE IF NOT EXISTS `fpguild_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `item_notes` varchar(255) COLLATE utf8_bin NOT NULL,
  `item_magelo` varchar(255) COLLATE utf8_bin NOT NULL,
  `item_value` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_item_received`
--

CREATE TABLE IF NOT EXISTS `fpguild_item_received` (
  `ireceived_id` int(11) NOT NULL AUTO_INCREMENT,
  `raid_id` int(11) NOT NULL,
  `roster_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `ireceived_cost` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ireceived_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_links`
--

CREATE TABLE IF NOT EXISTS `fpguild_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `link_url` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_raids`
--

CREATE TABLE IF NOT EXISTS `fpguild_raids` (
  `raid_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `dest_id` int(11) NOT NULL,
  `raid_desc` text COLLATE utf8_bin NOT NULL,
  `raid_value` float(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`raid_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_raid_attendance`
--

CREATE TABLE IF NOT EXISTS `fpguild_raid_attendance` (
  `raid_id` int(11) NOT NULL,
  `roster_id` int(11) NOT NULL,
  `attendance_value` float(6,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_ranks`
--

CREATE TABLE IF NOT EXISTS `fpguild_ranks` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `rank_order` int(11) NOT NULL,
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fpguild_ranks`
--

INSERT INTO `fpguild_ranks` VALUES(1, 'Guild Leader', 1);
INSERT INTO `fpguild_ranks` VALUES(2, 'Council', 2);
INSERT INTO `fpguild_ranks` VALUES(3, 'Officer', 3);
INSERT INTO `fpguild_ranks` VALUES(4, 'Class Leader', 4);
INSERT INTO `fpguild_ranks` VALUES(5, 'Recruiter', 5);
INSERT INTO `fpguild_ranks` VALUES(6, 'Member', 6);
INSERT INTO `fpguild_ranks` VALUES(7, 'Applicant', 7);
INSERT INTO `fpguild_ranks` VALUES(8, 'Inactive', 8);

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_recruitment`
--

CREATE TABLE IF NOT EXISTS `fpguild_recruitment` (
  `class_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `class_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fpguild_recruitment`
--

INSERT INTO `fpguild_recruitment` VALUES('1', 1);
INSERT INTO `fpguild_recruitment` VALUES('2', 1);
INSERT INTO `fpguild_recruitment` VALUES('3', 1);
INSERT INTO `fpguild_recruitment` VALUES('4', 1);
INSERT INTO `fpguild_recruitment` VALUES('5', 1);
INSERT INTO `fpguild_recruitment` VALUES('6', 1);
INSERT INTO `fpguild_recruitment` VALUES('7', 1);
INSERT INTO `fpguild_recruitment` VALUES('8', 1);
INSERT INTO `fpguild_recruitment` VALUES('9', 1);
INSERT INTO `fpguild_recruitment` VALUES('10', 1);
INSERT INTO `fpguild_recruitment` VALUES('11', 1);
INSERT INTO `fpguild_recruitment` VALUES('12', 1);
INSERT INTO `fpguild_recruitment` VALUES('13', 1);
INSERT INTO `fpguild_recruitment` VALUES('14', 1);
INSERT INTO `fpguild_recruitment` VALUES('15', 1);
INSERT INTO `fpguild_recruitment` VALUES('16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_roster`
--

CREATE TABLE IF NOT EXISTS `fpguild_roster` (
  `roster_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `roster_type` tinyint(3) NOT NULL,
  `roster_charfirst` varchar(255) COLLATE utf8_bin NOT NULL,
  `roster_charlast` varchar(255) COLLATE utf8_bin NOT NULL,
  `roster_rank` int(11) NOT NULL,
  `roster_class` int(11) NOT NULL,
  `roster_level` int(11) NOT NULL,
  `roster_epic` tinyint(4) NOT NULL,
  `roster_magelo` varchar(255) COLLATE utf8_bin NOT NULL,
  `roster_earned` float(11,2) NOT NULL DEFAULT '0.00',
  `roster_spent` float(11,2) NOT NULL DEFAULT '0.00',
  `roster_adjusted` float(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`roster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_roster_keys`
--

CREATE TABLE IF NOT EXISTS `fpguild_roster_keys` (
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `roster_id` int(11) NOT NULL,
  `sky_1` tinyint(3) NOT NULL,
  `sky_2` tinyint(3) NOT NULL,
  `sky_3` tinyint(3) NOT NULL,
  `sky_4` tinyint(3) NOT NULL,
  `sky_5` tinyint(3) NOT NULL,
  `sky_6` tinyint(3) NOT NULL,
  `sky_7` tinyint(3) NOT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_roster_tradeskills`
--

CREATE TABLE IF NOT EXISTS `fpguild_roster_tradeskills` (
  `tskills_id` int(11) NOT NULL,
  `roster_id` int(11) NOT NULL,
  `tskills_alchemy` smallint(6) NOT NULL,
  `tskills_baking` smallint(6) NOT NULL,
  `tskills_blacksmithing` smallint(6) NOT NULL,
  `tskills_brewing` smallint(6) NOT NULL,
  `tskills_fishing` smallint(6) NOT NULL,
  `tskills_fletching` smallint(6) NOT NULL,
  `tskills_jewelcrafting` smallint(6) NOT NULL,
  `tskills_poisonmaking` smallint(6) NOT NULL,
  `tskills_pottery` smallint(6) NOT NULL,
  `tskills_research` smallint(6) NOT NULL,
  `tskills_tailoring` smallint(6) NOT NULL,
  `tskills_tinkering` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fpguild_settings`
--

CREATE TABLE IF NOT EXISTS `fpguild_settings` (
  `setting_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `setting_value` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `fpguild_settings`
--

INSERT INTO `fpguild_settings` VALUES('setting_enable_gzip', '1');
INSERT INTO `fpguild_settings` VALUES('setting_gzip_level', '5');
INSERT INTO `fpguild_settings` VALUES('setting_http_path', 'http://localhost/fpguild');
INSERT INTO `fpguild_settings` VALUES('setting_charter', '');
INSERT INTO `fpguild_settings` VALUES('setting_application', '');
INSERT INTO `fpguild_settings` VALUES('setting_news_forum', '7');
INSERT INTO `fpguild_settings` VALUES('setting_allowed_groups', '5, 4, 7, 2, 8, 9, 10, 11, 12,');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
