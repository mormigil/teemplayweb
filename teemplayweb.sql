-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 08, 2013 at 03:17 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teemplayweb`
--
CREATE DATABASE IF NOT EXISTS `teemplayweb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `teemplayweb`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `idea` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `idea` (`idea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE IF NOT EXISTS `ideas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `title` varchar(140) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `description` mediumtext NOT NULL,
  `genre` varchar(30) NOT NULL,
  `votes` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `stage` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FOREIGN` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `userid`, `title`, `tweet`, `description`, `genre`, `votes`, `time`, `stage`) VALUES
(1, 6, 'asdf', 'asdf', 'Describe your game here', 'asdf', 23, 1378497058, 0),
(2, 6, 'secondgame', 'this game will be awesomekthx', 'so lots of text goes here i think or something\nso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or something', 'woooooot', 24, 1378839302, 0),
(3, 6, 'steve''s game', 'awesome moba esque building game', 'build stuff and win awesome things', 'awesome', 5, 1378839353, 0);

-- --------------------------------------------------------

--
-- Table structure for table `influence`
--

CREATE TABLE IF NOT EXISTS `influence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ideaid` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` mediumtext NOT NULL,
  `pics_ref` varchar(128) NOT NULL,
  `votes` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`userid`),
  UNIQUE KEY `idea` (`ideaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `level` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `votes` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `level`, `description`, `votes`, `email`) VALUES
(1, 'first', 'awesomepass', 11, '1000dkdkdksafsdf$id, $username, $password, $level, $description, $votes, $salt, $email', 24, 'a@2.com'),
(2, 'bob', 'paasss', 1, '10', 24, 'ankh579@yahoo.com'),
(3, 'mormigil', 'fireforge5', 1, '', 24, 'ankh579@yahoo.com'),
(4, 'mormigil', 'fireforge5', 1, '', 24, 'ankh579@yahoo.com'),
(5, 'mormigil', '828bffe71ef561122ed90c292b57de03fd9aa60566e00c1be682588b60338369036fa36581464ef83b5ef086a8e7657b7a5cbedec455cb00f6bf7cde3431f34f', 1, '', 24, 'ankh579@yahoo.com'),
(6, 'ankhar', '$2a$08$RSCt8syNK4X/ZtfxUICyueGXM5ZTtTS6ICjCngRSyq1jv44UnjImm', 1, '', 30, 'ankh579@yahoo.com'),
(7, 'ankhar', '$2a$08$a1D.8ZFa2E1GVb9/H9mHZ.p4s0n4X1hjBrPZVu/Hydg6/8..Yijuu', 1, '', 24, 'ankh579@yahoo.com'),
(8, 'ankhar', '$2a$08$r6yZiOuh8BI15dihhj.2nexNWQZzrSYFu2iPCn7TwVDKs3m4GsH26', 1, '', 24, 'ankh579@yahoo.com'),
(9, 'ankhar', '$2a$08$T1F/KIGnLcgaeFv7cqr34eIuWe4XV2XaGxcc.9p5lZm0Py8m5G9Yu', 1, '', 24, 'ankh579@yahoo.com'),
(10, 'ankhar', '$2a$08$KCgfJYilefSCDyG0aC0RaeshBWnd2gz8ly3lCtYvm0o1OgREOrlPC', 1, '', 24, 'ankh579@yahoo.com'),
(11, 'ankhar', '$2a$08$z54.i3s.SVJHflpj5WZoHOkiqBctr9ryf8icox0IPgJ0xBK7HrePu', 1, '', 24, 'ankh579@yahoo.com'),
(13, 'ankhar', '$2a$08$1cCag3Fxb3K6FCXPsYAV0OynK4Vgjp7gm52Y/mjTYXpYhxZlT.m5u', 1, '', 24, 'ankh579@yahoo.com'),
(15, 'mormigil', '$2a$08$7BbGhGkLwmmmVqYIVIUzXeQ80sn0nlLP4jFex9i3smS4ovAtKTkF.', 1, '', 24, 'ankh579@yahoo.com'),
(16, 'mormigil', '$2a$08$gfNbTVbSUgU0BDBpQu3xR..aYW7Gu7andlpE0fg7ltj6QoHRmZ71i', 1, '', 24, 'ankh579@yahoo.com'),
(17, 'mormigil', '$2a$08$njJGhxkDUMLL0ndbhcOrU.TMoKSWp9t3Am9AIPPq5xSrYK7p4P82a', 1, '', 24, 'ankh579@yahoo.com'),
(18, 'mormigil', '$2a$08$A8qVr1DVCvP8X4iSIwSGfet8VlrF8dnQaB9d96NrqlmRUJo1D8w1e', 1, '', 24, 'ankh579@yahoo.com'),
(19, 'a', '$2a$08$6pEpkYeBBsn9hr1NraUwc.V5nTGSigbgYcBYQcJ/jTsOd/HpF/r3q', 1, '', 24, 'ankh579@yahoo.com'),
(20, 'b', '$2a$08$wMYRo3lLp8.LUs1rHhKH/.o0MsqEeSJ5FMmv4MdWLNjkCTSffxW9G', 1, '', 24, 'ankh579@yahoo.com'),
(21, 'c', '$2a$08$xTAWwp5RwthVpvNaVbXl8Om8DJKStifx6Niql1WwSh6ACdWPqcvCS', 1, '', 24, 'ankh579@yahoo.com'),
(22, 'd', '$2a$08$ytml5E8w2y2tMC/dWsPEmuRpt8RqUJaST68AoIvuBrcTNUGhIsDgO', 1, '', 24, 'ankh579@yahoo.com'),
(23, 'd', '$2a$08$lXk1VMEl3UNBn1zQD8GM7OjgC5eA9zxWGAAb0AfSIcsPz4FgKYdYa', 1, '', 24, 'ankh579@yahoo.com'),
(24, 'e', '$2a$08$AxwV7v8u/3vErYWrbSyBjuOym6am4cpsJfqCdqySyf8kxQDCOKrAO', 1, '', 24, 'ankh579@yahoo.com'),
(25, 'f', '$2a$08$vSmvxs40hF4H3UZ9rFt6CupqIIM4xGRRx4CubheCq7R79/hK/DkNu', 1, '', 24, 'ankh579@yahoo.com'),
(26, 'g', '$2a$08$fgAMUvHgv2AgeNLBpvpH.OXKLIMebZE6Nlr80.DvyVDPyKUiWphxG', 1, '', 24, 'ankh579@yahoo.com'),
(27, 'z', '$2a$08$sEBPh9pzEPTtUZh18YNRX.aptct3EcSwUwIEZvyvL16TUH3cwyKi.', 1, '', 24, 'ankh579@yahoo.com'),
(28, 'steven', '$2a$08$uxiF5..Ln3bBd7JhZJ0RC.CCIecnVTAT/o/CsvC9yQjoAaPe.llhO', 1, '', 24, 'steve@teemplay.com');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ideaid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_key` (`userid`),
  KEY `idea` (`ideaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `ideaid`, `userid`) VALUES
(1, 1, 6),
(15, 2, 6),
(16, 2, 6),
(17, 2, 6),
(18, 2, 6),
(19, 2, 6),
(20, 2, 6),
(21, 2, 6),
(22, 2, 6),
(23, 2, 6),
(24, 2, 6),
(25, 2, 6),
(26, 2, 6),
(27, 2, 6),
(28, 2, 6),
(29, 2, 6),
(30, 2, 6),
(31, 2, 6),
(32, 2, 6),
(33, 2, 6),
(34, 2, 6),
(35, 2, 6),
(36, 2, 6),
(37, 2, 6),
(38, 2, 6),
(39, 3, 6),
(40, 3, 6),
(41, 3, 6),
(42, 3, 6),
(43, 3, 6);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comm_idea_fk` FOREIGN KEY (`idea`) REFERENCES `ideas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comm_user_fk` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ideas`
--
ALTER TABLE `ideas`
  ADD CONSTRAINT `idea_user_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `influence`
--
ALTER TABLE `influence`
  ADD CONSTRAINT `inf_idea_fk` FOREIGN KEY (`ideaid`) REFERENCES `ideas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inf_user_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_idea_fk` FOREIGN KEY (`ideaid`) REFERENCES `ideas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_user_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
