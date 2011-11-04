-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2011 at 05:45 AM
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
-- Table structure for table `networks`
--

DROP TABLE `networks`;

CREATE TABLE IF NOT EXISTS `networks` (
  `NETWORK_ID` int(11) NOT NULL,
  `AREA` varchar(25) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`NETWORK_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`NETWORK_ID`, `AREA`, `ACTIVITY_ID`) VALUES
(0, 'Oakland', 0),
(0, 'Oakland', 1),
(1, 'Pittsburgh', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
