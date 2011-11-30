-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2011 at 09:58 PM
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
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `ACTIVITY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVITY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ACTIVITY_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`ACTIVITY_ID`, `ACTIVITY_NAME`) VALUES
(1, 'Baseball'),
(2, 'Swimming'),
(3, 'Running');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  `COMMENT` varchar(4000) NOT NULL,
  `COMMENT_DATE` date NOT NULL,
  PRIMARY KEY (`COMMENT_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `connactions`
--

CREATE TABLE IF NOT EXISTS `connactions` (
  `CONNACTION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `POST_TIME` date NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `LOCATION` varchar(255) NOT NULL,
  `START_TIME` datetime DEFAULT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `END_TIME` datetime DEFAULT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  `IS_PRIVATE` int(11) DEFAULT '0',
  PRIMARY KEY (`CONNACTION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `connactions`
--

INSERT INTO `connactions` (`CONNACTION_ID`, `POST_TIME`, `USER_ID`, `LOCATION`, `START_TIME`, `MESSAGE`, `END_TIME`, `UNIQUE_NETWORK_ID`, `IS_PRIVATE`) VALUES
(13, '2011-11-28', 11, 'Cathedral lawn', '2011-11-30 12:00:00', 'Getting cold, bring a hat!', '2011-11-30 13:00:00', 3, 0),
(14, '2011-11-29', 11, 'Forbes and Sennot', '2011-12-01 07:00:00', 'Let us all go run!', '2011-12-01 09:00:00', 3, 0),
(15, '2011-11-30', 11, 'Cathedral', '2011-11-28 10:00:00', 'Testing a past Connaction', '2011-11-28 11:00:00', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `connaction_attending`
--

CREATE TABLE IF NOT EXISTS `connaction_attending` (
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  PRIMARY KEY (`CONNACTION_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `connaction_requests`
--

CREATE TABLE IF NOT EXISTS `connaction_requests` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `APPROVED` int(11) DEFAULT '-1',
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `HIDDEN_FOR_FROM` int(1) NOT NULL DEFAULT '0',
  `HIDDEN_FOR_TO` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FROM_USER`,`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `connaction_requests`
--

INSERT INTO `connaction_requests` (`FROM_USER`, `TO_USER`, `CONNACTION_ID`, `MESSAGE`, `APPROVED`, `DATE`, `HIDDEN_FOR_FROM`, `HIDDEN_FOR_TO`) VALUES
(12, 11, 14, 'I would like to come!', 1, '2011-11-29 01:49:02', 0, 0),
(12, 11, 13, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `EVENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `NETWORK_ID` int(11) NOT NULL,
  `MESSAGE` varchar(4000) NOT NULL,
  `START` datetime DEFAULT NULL,
  `END` datetime DEFAULT NULL,
  `LOCATION` varchar(20) DEFAULT NULL,
  `RECURRENCE` int(11) DEFAULT NULL,
  `APPROVED` int(1) DEFAULT -1,
  PRIMARY KEY (`EVENT_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_attending`
--

CREATE TABLE IF NOT EXISTS `event_attending` (
  `EVENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  PRIMARY KEY (`EVENT_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE IF NOT EXISTS `favorites` (
  `USER_ID` int(11) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`UNIQUE_NETWORK_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `USER_ID` int(11) NOT NULL,
  `FRIEND_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`FRIEND_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE IF NOT EXISTS `friend_requests` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `MESSAGE` varchar(4000) DEFAULT NULL,
  `IS_ACTIVE` int(11) DEFAULT '1',
  PRIMARY KEY (`FROM_USER`,`TO_USER`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `FROM_USER` int(11) NOT NULL,
  `TO_USER` int(11) NOT NULL,
  `SUBJECT` varchar(100) DEFAULT NULL,
  `BODY` varchar(4000) DEFAULT NULL,
  `DATE` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FROM_USER`,`TO_USER`,`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`FROM_USER`, `TO_USER`, `SUBJECT`, `BODY`, `DATE`) VALUES
(12, 11, 'Contact information for Amy Reehl', 'Email: amy4reehl@gmail.com\nPhone: \n', '2011-11-30 14:12:23'),
(12, 11, 'Contact information for Amy Reehl', 'Email: amy4reehl@gmail.com\nPhone: \n', '2011-11-30 14:16:44'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:14:36'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:17:03'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:17:07'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:17:58'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:20:23'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:20:42'),
(12, 11, 'Contact information for Amy Reehl', '', '2011-11-30 15:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE IF NOT EXISTS `networks` (
  `NETWORK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `AREA` varchar(25) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  PRIMARY KEY (`NETWORK_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`NETWORK_ID`, `AREA`, `STATE`) VALUES
(1, 'Oakland', 'PA'),
(2, 'Pittsburgh', 'PA');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `USER_ID` int(11) NOT NULL,
  `SECURITY` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `USER_ID` int(11) NOT NULL,
  `FROM_USER` int(11) NOT NULL,
  `IS_ANONYMOUS` int(11) DEFAULT '0',
  `CONNACTION_ID` int(11) NOT NULL,
  `IS_POSITIVE` int(11) DEFAULT NULL,
  `REVIEW_DATE` date DEFAULT NULL,
  `REVIEW` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`FROM_USER`,`CONNACTION_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unique_networks`
--

CREATE TABLE IF NOT EXISTS `unique_networks` (
  `UNIQUE_NETWORK_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NETWORK_ID` int(11) DEFAULT NULL,
  `ACTIVITY_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`UNIQUE_NETWORK_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `unique_networks`
--

INSERT INTO `unique_networks` (`UNIQUE_NETWORK_ID`, `NETWORK_ID`, `ACTIVITY_ID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1),
(5, 2, 2),
(6, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PASSWORD` varchar(100) NOT NULL,
  `FIRST_NAME` char(20) DEFAULT NULL,
  `LAST_NAME` char(20) DEFAULT NULL,
  `STREET` varchar(25) DEFAULT NULL,
  `CITY` char(20) DEFAULT NULL,
  `STATE` char(2) DEFAULT NULL,
  `ZIP` int(11) DEFAULT NULL,
  `PHONE` char(12) DEFAULT NULL,
  `INTERESTS` varchar(4000) DEFAULT NULL,
  `PROFILE_PIC` varchar(45) NOT NULL DEFAULT '../public/images/avatar.png',
  `EMAIL` varchar(25) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `GENDER` char(1) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`, `STREET`, `CITY`, `STATE`, `ZIP`, `PHONE`, `INTERESTS`, `PROFILE_PIC`, `EMAIL`, `DOB`, `GENDER`) VALUES
(11, '8f53e82e508c96115551317048cba97e', 'Rob', 'Filippi', '', 'Pittsburgh', 'PA', 15232, '', 'Hello my name is Rob', '../public/images/avatar.png', 'flippi273@gmail.com', '1989-11-28', 'M'),
(12, '8f53e82e508c96115551317048cba97e', 'Amy', 'Reehl', '', 'Pittsburgh', 'PA', 15232, '', '', '../public/images/avatar.png', 'amy4reehl@gmail.com', '1992-06-28', 'F'),
(1, '9ae984b8b7e71ee69caf0a7b82b31b1e', 'ConnActiv', 'Admin', '', '', '', NULL, '', '', '../public/images/avatar.png', 'admin@connactiv.com', NULL, NULL);

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
  `OWN_LEVEL` int(11) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`USER_ID`, `ACTIVITY_ID`, `LOW_LEVEL`, `HIGH_LEVEL`, `PREFERRED`, `OWN_LEVEL`) VALUES
(11, 3, 6, 9, 8, 8),
(11, 1, 2, 6, 4, 5),
(12, 3, NULL, NULL, NULL, NULL),
(12, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_networks`
--

CREATE TABLE IF NOT EXISTS `user_networks` (
  `USER_ID` int(11) NOT NULL,
  `UNIQUE_NETWORK_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`UNIQUE_NETWORK_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_networks`
--

INSERT INTO `user_networks` (`USER_ID`, `UNIQUE_NETWORK_ID`) VALUES
(11, 1),
(11, 3),
(11, 6),
(12, 1),
(12, 3),
(12, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
