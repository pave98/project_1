-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 01, 2018 at 03:52 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rkc`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `eventType` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `time` datetime(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `eventType`, `description`, `location`, `time`) VALUES
(1, 'treeni', 'Perkeleessti', 'HelvetissÃ¤', '2018-11-30 13:00:00.000000'),
(2, 'peli', 'minÃ¤ olen testi', 'HelvetissÃ¤', '2018-11-15 15:15:00.000000'),
(3, 'treeni', 'Niko on GAY', 'Perse', '2018-11-23 11:44:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `user_type`, `password`, `email`, `firstName`, `lastName`, `description`) VALUES
(7, 'testi', 'user', '9627df7a4a5b849f67fce863e82adc71', 'testi@testi.testi', 'testi', 'testi', 'minÃ¤ olen testi'),
(6, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', 'admin', 'admin', 'admin'),
(8, 'SAATANA', 'user', '99995eee3f56185f956b12b5973d6386', 'tuomensaloessi@gmail.com', 'Essi', 'Tuomensalo', 'ESSI ON SAATANA'),
(9, 'pÃ¤Ã¤vÃ¶', 'admin', '9627df7a4a5b849f67fce863e82adc71', 'asdaskpdkaspdk@fmoafma.caas', 'pÃ¶rkkÃ¤', 'Perkele', 'Ã¤Ã¥Ã¶Ã¤Ã¥Ã¶Ã¤');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
