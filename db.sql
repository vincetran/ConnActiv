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

drop database xgamings_connactiv;
create database xgamings_connactiv;
use xgamings_connactiv;

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
(3, 'Running'),
(4, 'Shotput'),
(5, 'Quidditch'),
(6, 'ChairSkiing'),
(7, 'Cycling'),
(8, 'Racquetball'),
(9, 'Chess'),
(10, 'Snowboarding'),
(11, 'Diving'),
(12, 'Parkour');

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
(14, '2011-11-29', 12, 'Forbes and Sennot', '2011-12-01 07:00:00', 'Let us all go run!', '2011-12-01 09:00:00', 3, 0),
(15, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a past Connaction', '2011-11-28 11:00:00', 3, 0),
(16, '2011-11-30', 11, 'here', '2011-11-28 10:00:00', 'Testing a past Connaction', '2011-11-28 11:00:00', 3, 0),
(17, '2011-11-30', 12, 'This is a very long location string so that we can see what it looks like when someone decides to give very specific directions that are probably not even that useful because they are probably a woman who was a horrible sense of direction and chooses horrible places to meet for connactions.  whew!', '2011-11-28 10:00:00', 'Testing a long location', '2011-11-28 11:00:00', 4, 0),
(18, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'This is testing a very long message which I dont really feel like typing out but i will try to bullshit for a little and then i will just start typing random letters GO! adsglkasjdghlaskdjghalsdkjaghlsdkjgahsldgkjadshlvkcjndsflvknjadsvdkljvnlasdkjvnasldkjgadshlgkjashdlgk', '2011-11-28 11:00:00', 5, 0),
(19, '2011-11-30', 11, 'Cathedral', '2011-11-28 10:00:00', 'Testing a private Connaction', '2011-11-28 11:00:00', 3, 1),
(20, '2011-11-30', 12, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 3, 0),
(21, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 6, 0),
(22, '2011-11-30', 14, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 7, 0),
(23, '2011-11-30', 15, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 8, 0),
(24, '2011-11-30', 14, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 9, 0),
(25, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 10, 0),
(26, '2011-11-30', 11, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 11, 0),
(27, '2011-11-30', 12, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 12, 0),
(28, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 13, 0),
(29, '2011-11-30', 14, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 14, 0),
(30, '2011-11-30', 12, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 15, 0),
(31, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 16, 0),
(32, '2011-11-30', 14, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 17, 0),
(33, '2011-11-30', 11, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 18, 0),
(34, '2011-11-30', 12, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 19, 0),
(35, '2011-11-30', 13, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 20, 0),
(36, '2011-11-30', 14, 'Cathedral', '2011-11-28 10:00:00', 'Testing a Connaction', '2011-11-28 11:00:00', 21, 0);

-- --------------------------------------------------------

--
-- Table structure for table `connaction_attending`
--

CREATE TABLE IF NOT EXISTS `connaction_attending` (
  `USER_ID` int(11) NOT NULL,
  `CONNACTION_ID` int(11) NOT NULL,
  PRIMARY KEY (`CONNACTION_ID`,`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into `connaction_attending` values(11,13),
(12,14),
(13,15),
(14,16),
(15,17),
(16,18),
(17,19),
(18,20),
(17,21),
(16,22),
(15,23),
(14,24),
(16,25),
(17,26);

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
(13, 14, 15, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 0),
(14, 11, 16, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 0),
(15, 13, 32, 'Hi can I join!', 2, '2011-11-30 20:21:54', 1, 0),
(16, 11, 14, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 1),
(13, 14, 20, 'Hi can I join!', 2, '2011-11-30 20:21:54', 1, 1),
(14, 15, 19, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 0),
(15, 14, 24, 'Hi can I join!', 2, '2011-11-30 20:21:54', 0, 0);


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

insert into `events` values (1, 12, 1, 1, 'we are having an event', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0),
(2, 14, 2, 1, 'we are having another event', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0),
(3, 15, 3, 2, 'we are having big event, we show you good time', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0),
(4, 13, 4, 1, 'event for cancer', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0),
(5, 18, 5, 2, 'event for aids', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0),
(6, 17, 6, 1, 'event for canine retardation', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in lawrenceville', 0, 0),
(7, 11, 12, 1, 'we are having an event', '2011-21-01 20:21:54', '2011-12-02 20:21:54', 'in pittsburgh', 0, 0);
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

insert into `favorites` values (11, 7),
(12,8),
(13,9),
(14,10),
(15,11),
(12, 16);
-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `USER_ID` int(11) NOT NULL,
  `FRIEND_ID` int(11) NOT NULL,
  PRIMARY KEY (`USER_ID`,`FRIEND_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into `friends` values (13, 14), (14,13),
(14,15),
(15,14),
(13,15),
(15,13),
(15,16),
(16,15);
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
(12, 11, 'Contact info', 'Email: amy4reehl@gmail.com\nPhone: \n', '2011-11-30 14:12:23'),
(12, 11, 'Contact info', 'Email: amy4reehl@gmail.com\nPhone: \n', '2011-11-30 14:16:44'),
(13, 12, 'Contact info', '', '2011-11-30 15:14:36'),
(14, 13, 'Contact info', '', '2011-11-30 15:17:03'),
(11, 11, 'Contact info', '', '2011-11-30 15:17:07'),
(12, 12, 'Contact info', '', '2011-11-30 15:17:58'),
(13, 13, 'Contact info', '', '2011-11-30 15:20:23'),
(12, 14, 'Contact info', '', '2011-11-30 15:20:42'),
(12, 11, 'Contact info', '', '2011-11-30 15:21:54');

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
(2, 'Pittsburgh', 'PA'),
(3, 'Lawrenceville', 'PA'),
(4, 'Erie', 'PA'),
(5, 'Oakland', 'CA'),
(6, 'Uniontown', 'PA');

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

insert into reviews values(11, 12, 0, 13, 0, '2011-11-30 15:17:07', 'This is a test review'),
(12, 13, 1, 13, 1, '2011-11-30 15:17:07', 'This is a test review'),
(11, 12, 0, 14, 0, '2011-11-30 15:17:07', 'This is a test review'),
(14, 12, 0, 16, 1, '2011-11-30 15:17:07', 'This is a test review'),
(14, 13, 0, 20, 0, '2011-11-30 15:17:07', 'This is a test review'),
(11, 13, 0, 21, 0, '2011-11-30 15:17:07', 'This is a test review'),
(13, 12, 0, 15, 0, '2011-11-30 15:17:07', 'This is a test review');
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
(6, 2, 3),
(7,1,1),
(8,1,2),
(9,1,3),
(10,1,4),
(11,1,6),
(12,1,8),
(13,1,12),
(14,2,2),
(15,2,3),
(16,2,4),
(17,3,2),
(18,3,3),
(19,4,4),
(20,5,8);
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
(1, '9ae984b8b7e71ee69caf0a7b82b31b1e', '', 'Admin', '', '', '', NULL, '', '', '../public/images/avatar.png', 'admin@connactiv.com', NULL, NULL),
(13, '9ae984b8b7e71ee69caf0a7b82b31b1e', 'User', 'Test', '', '', '', NULL, '', '', '../public/images/avatar.png', 'admin@connactiv.com', NULL, NULL),
(14, '9ae984b8b7e71ee69caf0a7b82b31b1e', 'Fake', 'Mister', '', '', '', NULL, '', '', '../public/images/avatar.png', 'admin@connactiv.com', NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE IF NOT EXISTS `user_activities`(
  `USER_ID` int(11) NOT NULL,
  `ACTIVITY_ID` int(11) NOT NULL,
  `LOW_LEVEL` int(11) NULL,
  `HIGH_LEVEL` int(11) NULL,
  `PREFERRED` int(11) NULL,
  `OWN_LEVEL` int(11) NULL,
  PRIMARY KEY (`USER_ID`,`ACTIVITY_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`USER_ID`, `ACTIVITY_ID`, `LOW_LEVEL`, `HIGH_LEVEL`, `PREFERRED`, `OWN_LEVEL`) 
VALUES(11, 3, 6, 9, 8, 8),
(11, 1, 2, 6, 4, 5),
(11, 4, NULL, NULL, NULL, NULL),
(11, 5, NULL, NULL, NULL, NULL),
(12, 6, NULL, NULL, NULL, NULL),
(12, 2, NULL, NULL, NULL, NULL),
(12, 8, NULL, NULL, NULL, NULL),
(12, 9, NULL, NULL, NULL, NULL),
(13, 1, NULL, NULL, NULL, NULL),
(13, 2, NULL, NULL, NULL, NULL);

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
(13, 2),
(13, 4),
(13, 3),
(14, 1),
(14, 5),
(11, 2),
(11, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
