-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2011 at 03:24 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xgamings_connactiv`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE IF NOT EXISTS `user_activities` (
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `LOW_LEVEL` int(11) DEFAULT NULL,
  `HIGH_LEVEL` int(11) DEFAULT NULL,
  `PREFERRED` int(11) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`USER_ID`, `ACTIVITY_ID`, `LOW_LEVEL`, `HIGH_LEVEL`, `PREFERRED`) VALUES
(1, 0, 2, 4, 4),
(1, 1, 2, 4, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
