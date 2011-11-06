-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2011 at 03:25 AM
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
-- Table structure for table `user_networks`
--

DROP TABLE `user_networks`;

CREATE TABLE IF NOT EXISTS `user_networks` (
  `USER_ID` int(11) NOT NULL,
  `NETWORK_ID` int(11) NOT NULL,
  `ACTIVITY_ID` varchar(50) NOT NULL,
  PRIMARY KEY (`USER_ID`,`NETWORK_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_networks`
--

INSERT INTO `user_networks` (`USER_ID`, `NETWORK_ID`, `ACTIVITY_ID`) VALUES
(1, 0, '0,1'),
(1, 1, '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
