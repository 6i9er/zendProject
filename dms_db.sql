-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2016 at 01:20 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `reg_date` varchar(255) NOT NULL,
  `is_visible` int(1) NOT NULL,
  `is_locked` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `reg_date`, `is_visible`, `is_locked`) VALUES
(1, 'Sports', '', 0, 0),
(2, 'Films', '', 1, 0),
(3, 'Series', '', 0, 0),
(4, 'Courses', '', 1, 0),
(5, ',s', '2016-04-22 05:06:10pm', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `u_id`, `thread_id`, `comment`, `date`, `time`) VALUES
(1, 1, 1, 'hajshdj  ahsbdhbja  ajshdbjas d kasbdbhbhajd', '13-12-1989', '05:03:am'),
(2, 1, 1, 'asdasd', '', ''),
(5, 1, 3, 'ytytyuty', '', ''),
(7, 1, 2, 'Fuck Test', '23 - 04 - 2016', '07:11:07am'),
(8, 4, 5, 'askdml', '23 - 04 - 2016', '10:50:46pm'),
(9, 1, 5, 'sss', '23 - 04 - 2016', '10:52:59pm');

-- --------------------------------------------------------

--
-- Table structure for table `msgs`
--

CREATE TABLE IF NOT EXISTS `msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailfrom` varchar(200) NOT NULL,
  `mailto` varchar(200) NOT NULL,
  `msgbody` varchar(255) NOT NULL,
  `date` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `msgs`
--

INSERT INTO `msgs` (`id`, `mailfrom`, `mailto`, `msgbody`, `date`) VALUES
(1, 'eng.mina23@gmail.com', 'eng.mina23@gmail.com', 'auasbdadsi', ''),
(3, 'eng.mina23@gmail.com', 'eng.mina23@gmail.com', 'asdhkahdk', '2016-04-24 12:49:57pm');

-- --------------------------------------------------------

--
-- Table structure for table `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `reg_date` varchar(255) NOT NULL,
  `is_visible` int(1) NOT NULL,
  `is_locked` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `subcat`
--

INSERT INTO `subcat` (`id`, `cat_id`, `name`, `reg_date`, `is_visible`, `is_locked`) VALUES
(1, 1, 'Arabic', '13 -12 - 1989', 0, 0),
(2, 3, 'Football', '25 - 2 - 2011', 1, 0),
(3, 1, 'English', '20-4-2016', 1, 1),
(4, 1, 'UBUNTU Lovers', '22 - 04 - 2016', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `topic` text NOT NULL,
  `is_fixed` int(1) NOT NULL,
  `downloads` varchar(255) NOT NULL,
  `is_closed` int(1) NOT NULL,
  `video` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `cat_id`, `u_id`, `title`, `topic`, `is_fixed`, `downloads`, `is_closed`, `video`, `date`, `time`, `picture`) VALUES
(1, 1, 1, 'Title 1', '<html>\n<head>\n	<title></title>\n</head>\n<body>\n<p>&nbsp; ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lglv&nbsp;</p>\n\n<p>&nbsp;</p>\n\n<p>&nbsp; ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lglv&nbsp;</p>\n\n<p>&nbsp; ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lgl&nbsp;ashdb&nbsp; doa sdf&nbsp; as[f dkja s f asldfnjia sfd&nbsp; msadlfk jksdfg smmd;lglv&nbsp;</p>\n</body>\n</html>\n', 0, '', 0, '', '13-12-1989', '', '1.jpg'),
(2, 1, 3, 'Title 2', '', 0, '', 0, '', '', '', ''),
(3, 2, 1, 'title ', '', 0, '', 1, '', '', '', ''),
(4, 1, 1, 'title2', '', 0, '', 0, '', '', '', ''),
(5, 2, 1, 'asd', '', 1, '', 0, '', '', '', ''),
(6, 3, 1, 'test 1', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>Test 1</p>\r\n</body>\r\n</html>\r\n', 0, '', 0, '', '23 - 04 - 2016', '11:10:46pm', NULL),
(7, 2, 1, 'title 33', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>this titlee 3</p>\r\n</body>\r\n</html>\r\n', 0, '', 1, '', '23 - 04 - 2016', '11:11:07pm', NULL),
(8, 3, 1, 'Title Number 1', '<html>\r\n<head>\r\n	<title></title>\r\n</head>\r\n<body>\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align: center;">Hello All</p>\r\n\r\n<p>This is The Final Test On Our Web Site</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p style="text-align: right;">Mina AMir</p>\r\n\r\n<p style="text-align: right;">6i9er</p>\r\n\r\n<p>&nbsp;</p>\r\n</body>\r\n</html>\r\n', 0, '', 0, 'bJDBj8KuPso', '24 - 04 - 2016', '08:05:56am', 'Screenshot from 2016-02-02 04:52:55.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `prof_pic` varchar(255) DEFAULT NULL,
  `gender` int(1) NOT NULL,
  `country` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `type` int(1) NOT NULL,
  `is_blocked` int(1) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `last_forget` varchar(255) NOT NULL,
  `reg_date` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mail`, `password`, `prof_pic`, `gender`, `country`, `signature`, `type`, `is_blocked`, `last_login`, `last_forget`, `reg_date`) VALUES
(1, 'Mina Amir', 'eng.mina23@gmail.com', '70d313fbbb5c1f24da7e30f1c0341659', '', 1, 'ksa', 'This Is My Time', 1, 0, '24 - 04 - 2016', '', '19 - 04 - 2016'),
(2, ' Mohammed Ali ', 'ali@gmail.com', '25f9e794323b453885f5181f1b624d0b', '', 1, 'france', 'ccc', 2, 1, '', '', '19 - 04 - 2016'),
(3, 'ayad', 'ayad@gmail.com', '4297f44b13955235245b2497399d7a93', '', 1, 'egypt', 'ayad . 5orm', 2, 0, '', '', '19 - 04 - 2016'),
(4, 'Sara', 'm@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'New Lab Test.png', 2, 'egypt', 'ssssa', 2, 0, '24 - 04 - 2016', '', '19 - 04 - 2016'),
(5, 'Dhalia', 'ki@gmail.com', '4297f44b13955235245b2497399d7a93', '3.png', 2, 'egypt', 'Signature', 2, 0, '', '', '19 - 04 - 2016'),
(7, '0a00000a0a', 'eng.mina23000@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', 1, 'egypt', 'dad', 2, 0, '', '', '23 - 04 - 2016'),
(8, '0a00000a0a', 'eng.mina22@gmail.com', '4297f44b13955235245b2497399d7a93', '', 1, 'egypt', 'asd', 2, 0, '', '', '23 - 04 - 2016'),
(9, '0a00000a0a', 'm15@gmail.com', '1d1b55daca8497285f4e299f2f765290', NULL, 1, 'egypt', 'asd', 2, 0, '', '', '23 - 04 - 2016');

-- --------------------------------------------------------

--
-- Table structure for table `websettings`
--

CREATE TABLE IF NOT EXISTS `websettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `websettings`
--

INSERT INTO `websettings` (`id`, `key`, `value`) VALUES
(1, 'status', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
