-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2013 at 02:36 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teemplay_web`
--

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
-- Table structure for table `emaillist`
--

CREATE TABLE IF NOT EXISTS `emaillist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `emaillist`
--

INSERT INTO `emaillist` (`id`, `email`) VALUES
(3, 'ankh579@hotmail.com'),
(1, 'ankh579@yahoo.com'),
(23, 'ankh579@yes.com'),
(27, 'josephine@willis.com'),
(26, 'sdfa@123.com'),
(24, 'steve@teemplay.com'),
(15, 'willis@hotmail.com'),
(19, 'willis@teemplay.cam'),
(22, 'willis@teemplay.cim'),
(2, 'willis@teemplay.com');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE IF NOT EXISTS `favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `inspirationid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `inspirationid` (`inspirationid`),
  KEY `userid` (`userid`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `userid`, `title`, `tweet`, `description`, `genre`, `votes`, `time`, `stage`) VALUES
(1, 6, 'asdf', 'asdf', 'Describe your game here', 'asdf', 23, 1378497058, 3),
(2, 6, 'secondgame', 'this game will be awesomekthx', 'so lots of text goes here i think or something\nso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or somethingso lots of text goes here i think or something', 'woooooot', 24, 1378839302, 3),
(3, 6, 'steve''s game', 'awesome moba esque building game', 'build stuff and win awesome things', 'awesome', 5, 1378839353, 3),
(4, 6, 'testing ideas', 'On voting and how it works or doesn''t', 'Hopefully it does but man describe your game here needs to be placeholder textDescribe your game here', 'true true', 1, 1381515529, 1),
(5, 6, 'New Idea', 'This idea is an awesome game', 'so this is where you would describe the game extra length would be cut off though', 'rts', 0, 1382556421, 0);

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
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`userid`),
  KEY `idea` (`ideaid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `influence`
--

INSERT INTO `influence` (`id`, `userid`, `ideaid`, `title`, `description`, `pics_ref`, `votes`, `type`, `time`) VALUES
(1, 6, 1, 'New story levle idea', 'Give a description of your addition here awesome super awesome game', 'yoyuds.cz.sa', 0, '5', 1381772706),
(6, 6, 1, 'New story levle idea', 'Give a description of your addition here awesome super awesome game', 'yoyuds.cz.sa', 1, '5', 1381773026),
(7, 6, 1, 'Different influence idea', 'A new awesome description for game 1.5\nA new awesome description for game 1.5A new awesome description for game 1.5A new awesome description for game 1.5A new awesome description for game 1.5A new awesome description for game 1.5', 'dfkadjsflk', 1, '5', 1381773085),
(8, 6, 2, 'new piece of content', 'This will revolutionize game 2 you just wait.', '..dkdk', 0, '1', 1382548060),
(9, 6, 2, 'just smid', 'sdsdfasdffGive a description of your addition here', 'dsklafj', 0, '1', 1382548119);

-- --------------------------------------------------------

--
-- Table structure for table `inspirations`
--

CREATE TABLE IF NOT EXISTS `inspirations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `title` varchar(127) NOT NULL,
  `tweet` varchar(140) NOT NULL,
  `description` mediumtext NOT NULL,
  `url` mediumtext NOT NULL,
  `votes` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `pic` mediumtext NOT NULL,
  `vid` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `inspirations`
--

INSERT INTO `inspirations` (`id`, `userid`, `title`, `tweet`, `description`, `url`, `votes`, `time`, `pic`, `vid`) VALUES
(1, 6, 'new ideas', 'are awesome', 'Describe your game here', 'to be used', 2, 1384281379, 'go here', 'yayay'),
(2, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384545647, '', ''),
(3, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384545700, '', ''),
(4, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384545718, '', ''),
(5, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384545752, '', ''),
(6, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384545819, '', ''),
(7, 6, 'adf', 'adsf', 'Describe your game here', 'fasdf', 0, 1384549844, 'blackcleaveroplololol.PNG', ''),
(8, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384555867, '', 'safas'),
(9, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384555949, '', 'safas'),
(10, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384555997, '', 'safas'),
(11, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556020, 'Array', 'safas'),
(12, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556289, 'Array', 'safas'),
(13, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556313, 'Array', 'safas'),
(14, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556357, 'Array', 'safas'),
(15, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556379, 'Array', 'safas'),
(16, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556409, 'Array', 'safas'),
(17, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556429, '42ef5d5b31f1b7295648f0facdb29857blackcleaveroplololol.PNG', 'safas'),
(18, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556527, '42ef5d5b31f1b7295648f0facdb29857blackcleaveroplololol.PNG', 'safas'),
(19, 6, 'dsafds', 'asdfsadf', 'Describe your game hedsafre', 'sadfsad', 0, 1384556585, '42ef5d5b31f1b7295648f0facdb29857blackcleaveroplololol.PNG', 'safas');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `level`, `description`, `votes`, `email`) VALUES
(1, 'first', 'awesomepass', 11, '1000dkdkdksafsdf$id, $username, $password, $level, $description, $votes, $salt, $email', 24, 'a@2.com'),
(2, 'bob', 'paasss', 1, '10', 24, 'ankh579@yahoo.com'),
(3, 'mormigil', 'fireforge5', 1, '', 24, 'ankh579@yahoo.com'),
(4, 'mormigil', 'fireforge5', 1, '', 24, 'ankh579@yahoo.com'),
(5, 'mormigil', '828bffe71ef561122ed90c292b57de03fd9aa60566e00c1be682588b60338369036fa36581464ef83b5ef086a8e7657b7a5cbedec455cb00f6bf7cde3431f34f', 1, '', 24, 'ankh579@yahoo.com'),
(6, 'ankhar', '$2a$08$RSCt8syNK4X/ZtfxUICyueGXM5ZTtTS6ICjCngRSyq1jv44UnjImm', 1, '', 32, 'ankh579@yahoo.com'),
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
(28, 'steven', '$2a$08$uxiF5..Ln3bBd7JhZJ0RC.CCIecnVTAT/o/CsvC9yQjoAaPe.llhO', 1, '', 24, 'steve@teemplay.com'),
(29, 'morm123', '$2a$08$Msxi4OygtyyKp3Ffmnv8hOGtdxmoVxh5onqb40SeP0TEFJC/oIPsa', 1, '', 0, 'ankh579@yahoo.com'),
(30, 'morm1234', '$2a$08$IUI3h/ZEF3wi.RDT0zCr/ORaYNcZC24B4o1FBaTTJbxO6/SpF0MdG', 1, '', 0, 'ankh579@yahoo.com'),
(31, 'morm12345', '$2a$08$MuKhEQpLe7ffY/HJnYnTlueG75pL.nLDUAFmDiVx.E8I.wezUXBOe', 1, '', 0, 'ankh579@yahoo.com'),
(32, 'morm123456', '$2a$08$Rfg6nCzY/.6gO.PEyLhZzOtOizWj3hleMmgBgeBkKDDZqY9Rt8jDC', 1, '', 0, 'ankh579@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkedid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_key` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `linkedid`, `userid`, `type`) VALUES
(1, 1, 6, 0),
(15, 2, 6, 0),
(16, 2, 6, 0),
(17, 2, 6, 0),
(18, 2, 6, 0),
(19, 2, 6, 0),
(20, 2, 6, 0),
(21, 2, 6, 0),
(22, 2, 6, 0),
(23, 2, 6, 0),
(24, 2, 6, 0),
(25, 2, 6, 0),
(26, 2, 6, 0),
(27, 2, 6, 0),
(28, 2, 6, 0),
(29, 2, 6, 0),
(30, 2, 6, 0),
(31, 2, 6, 0),
(32, 2, 6, 0),
(33, 2, 6, 0),
(34, 2, 6, 0),
(35, 2, 6, 0),
(36, 2, 6, 0),
(37, 2, 6, 0),
(38, 2, 6, 0),
(39, 3, 6, 0),
(40, 3, 6, 0),
(41, 3, 6, 0),
(42, 3, 6, 0),
(43, 3, 6, 0),
(44, 4, 6, 0),
(45, 1, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vote_influence`
--

CREATE TABLE IF NOT EXISTS `vote_influence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `influenceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_key` (`userid`),
  KEY `influence_key` (`influenceid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vote_influence`
--

INSERT INTO `vote_influence` (`id`, `influenceid`, `userid`) VALUES
(1, 7, 6),
(2, 6, 6);

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
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`inspirationid`) REFERENCES `inspirations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `inspirations`
--
ALTER TABLE `inspirations`
  ADD CONSTRAINT `inspirations_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_user_fk` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
