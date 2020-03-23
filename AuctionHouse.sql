-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2020 at 10:58 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AuctionHouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `AuctionDetail`
--

CREATE TABLE `AuctionDetail` (
  `current_owner` varchar(15) NOT NULL,
  `previous_owner` varchar(15) NOT NULL,
  `productId` int(11) NOT NULL,
  `amount_paid` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `auctionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuctionDetail`
--

INSERT INTO `AuctionDetail` (`current_owner`, `previous_owner`, `productId`, `amount_paid`, `date`, `auctionId`) VALUES
('reeshal', 'nawsheen', 57, 90010, '2019-12-20 14:01:03', 98),
('reeshal', 'nawsheen', 58, 101, '2020-03-15 09:53:11', 99),
('nawsheen', 'reeshal', 58, 29, '2020-03-15 09:56:59', 100);

-- --------------------------------------------------------

--
-- Table structure for table `Bidding`
--

CREATE TABLE `Bidding` (
  `username` varchar(15) NOT NULL,
  `productId` int(11) NOT NULL,
  `price_bidded` float NOT NULL,
  `time_bidded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Bidding`
--

INSERT INTO `Bidding` (`username`, `productId`, `price_bidded`, `time_bidded`) VALUES
('nawsheen', 53, 37, '2019-12-18 19:39:15'),
('nawsheen', 59, 21, '2020-03-15 07:38:55'),
('nawsheen', 60, 29, '2019-12-20 12:23:35'),
('reeshal', 59, 22, '2020-03-15 07:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryId`, `categoryName`) VALUES
(2, 'Art'),
(3, 'Books and magazines'),
(4, 'Cellphones'),
(5, 'Computers'),
(6, 'Clothes'),
(7, 'Jewellery and Watches'),
(8, 'Music'),
(9, 'Movies'),
(10, 'Health Care'),
(11, 'Vehicles');

-- --------------------------------------------------------

--
-- Table structure for table `Currency`
--

CREATE TABLE `Currency` (
  `currency` varchar(25) NOT NULL DEFAULT 'dollar',
  `conversion_rate` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Every conversion uses dollar as base';

--
-- Dumping data for table `Currency`
--

INSERT INTO `Currency` (`currency`, `conversion_rate`) VALUES
('Euro', 1.12),
('Mauritian Rupees', 0.027),
('Pound Sterling', 1.13),
('US Dollars', 1);

-- --------------------------------------------------------

--
-- Table structure for table `FAQ`
--

CREATE TABLE `FAQ` (
  `faqId` int(11) NOT NULL,
  `question` longtext NOT NULL,
  `answer` longtext NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `FAQ`
--

INSERT INTO `FAQ` (`faqId`, `question`, `answer`, `category`) VALUES
(1, 'How to sell goods?', 'Go to Products duhewkujfunoefh ervcre', 'selling'),
(7, 'efwrf', 'ewfd4wfg', 'wegtedmuewi xieji xjewoijxwo\r\n'),
(8, 'fcetger', 'gergreg', 'ergergre'),
(9, 'ferfrf', 'rfrfrfr', 'frfrfrr');

-- --------------------------------------------------------

--
-- Table structure for table `LoginHistory`
--

CREATE TABLE `LoginHistory` (
  `loginSessionNo` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `LoginHistory`
--

INSERT INTO `LoginHistory` (`loginSessionNo`, `login_time`, `username`) VALUES
(1, '2019-10-27 04:14:15', 'reeshal'),
(2, '2019-10-27 04:21:00', 'reeshal'),
(3, '2019-10-27 05:40:03', 'reeshal'),
(4, '2019-10-27 05:41:41', 'reeshal'),
(5, '2019-11-08 07:00:16', 'reeshal'),
(6, '2019-11-08 07:03:07', 'reeshal'),
(7, '2019-11-08 00:17:40', 'reeshal'),
(8, '2019-11-08 00:18:33', 'reeshal'),
(9, '2019-11-08 00:24:17', 'rishi'),
(10, '2019-11-08 00:26:20', 'rishi'),
(11, '2019-11-08 00:28:05', 'rishi'),
(12, '2019-11-08 00:28:23', 'reeshal'),
(13, '2019-11-08 00:33:01', 'reeshal'),
(14, '2019-11-08 00:35:35', 'rishi'),
(15, '2019-11-08 00:38:40', 'reeshal'),
(16, '2019-11-08 01:05:26', 'reeshal'),
(17, '2019-11-08 01:05:50', 'reeshal'),
(18, '2019-11-08 01:08:02', 'rishi'),
(19, '2019-11-08 01:46:28', 'reeshal'),
(20, '2019-11-08 01:51:08', 'reeshal'),
(21, '2019-11-08 01:58:56', 'reeshal'),
(22, '2019-11-08 03:53:16', 'reeshal'),
(23, '2019-11-08 04:10:05', 'reeshal'),
(24, '2019-11-08 04:14:52', 'reeshal'),
(25, '2019-11-09 07:18:25', 'reeshal'),
(26, '2019-11-09 07:21:57', 'nawsheen'),
(27, '2019-11-09 07:44:35', 'reeshal'),
(28, '2019-11-08 21:58:28', 'reeshal'),
(29, '2019-11-08 22:33:54', 'rishi'),
(30, '2019-11-08 22:37:45', 'reeshal'),
(31, '2019-11-08 22:38:02', 'nawsheen'),
(32, '2019-11-09 03:21:57', 'reeshal'),
(33, '2019-11-10 04:00:51', 'rishi'),
(34, '2019-11-10 04:02:40', 'reeshal'),
(35, '2019-11-10 06:07:29', 'nawsheen'),
(36, '2019-11-10 07:03:09', 'reeshal'),
(37, '2019-11-21 04:23:55', 'reeshal'),
(38, '2019-11-22 03:23:36', 'reeshal'),
(39, '2019-11-22 03:25:54', 'rishi'),
(40, '2019-11-22 03:47:54', 'nawsheen'),
(41, '2019-11-23 04:03:58', 'nawsheen'),
(42, '2019-11-23 04:31:13', 'reeshal'),
(43, '2019-11-23 04:41:39', 'rishi'),
(44, '2019-11-22 22:30:19', 'reeshal'),
(45, '2019-11-23 00:39:50', 'nawsheen'),
(46, '2019-11-23 04:22:12', 'reeshal'),
(47, '2019-11-25 02:45:39', 'reeshal'),
(48, '2019-11-25 02:46:11', 'nawsheen'),
(49, '2019-11-25 03:46:18', 'reeshal'),
(50, '2019-11-25 04:06:50', 'nawsheen'),
(51, '2019-11-26 03:06:46', 'nawsheen'),
(52, '2019-11-26 03:41:19', 'rishi'),
(53, '2019-11-25 22:25:12', 'nawsheen'),
(54, '2019-11-26 02:08:23', 'reeshal'),
(55, '2019-11-26 02:17:56', 'rishi'),
(56, '2019-11-26 02:41:42', 'nawsheen'),
(57, '2019-11-26 02:45:06', 'reeshalrittoo'),
(58, '2019-11-26 02:45:45', 'rishi'),
(59, '2019-11-26 02:47:00', 'nawsheen'),
(60, '2019-11-26 04:06:23', 'reeshal'),
(61, '2019-11-27 02:25:13', 'reeshalrittoo'),
(62, '2019-11-27 02:30:42', 'rishikesh'),
(63, '2019-11-27 02:49:23', 'nawsheen'),
(64, '2019-11-27 02:58:17', 'reeshalrittoo'),
(65, '2019-11-27 03:52:24', 'reeshalrittoo'),
(66, '2019-11-27 04:01:45', 'rishikesh'),
(67, '2019-11-27 04:03:21', 'rishikesh'),
(68, '2019-11-27 04:03:52', 'nawsheen'),
(69, '2019-11-27 05:37:56', 'reeshalrittoo'),
(70, '2019-11-27 05:38:27', 'reeshalrittoo'),
(71, '2019-11-27 06:01:06', 'rishikesh'),
(72, '2019-12-05 03:11:25', 'reeshalrittoo'),
(73, '2019-12-05 03:23:14', 'reeshal'),
(74, '2019-12-05 03:38:10', 'nawsheen'),
(75, '2019-12-05 03:39:49', 'reeshalrittoo'),
(76, '2019-12-05 07:32:48', 'reeshalrittoo'),
(77, '2019-12-05 07:34:07', 'rishi'),
(78, '2019-12-05 03:49:33', 'reeshalrittoo'),
(79, '2019-12-05 03:50:41', 'rishi'),
(80, '2019-12-18 01:21:46', 'reeshal'),
(81, '2019-12-18 01:59:58', 'reeshalrittoo'),
(82, '2019-12-18 02:37:12', 'nawsheen'),
(83, '2019-12-18 02:40:20', 'reeshal'),
(84, '2019-12-18 02:42:30', 'nawsheen'),
(85, '2019-12-18 03:47:09', 'nawsheen'),
(86, '2019-12-18 04:49:33', 'reeshal'),
(87, '2019-12-19 21:19:26', 'rishi'),
(88, '2019-12-19 21:23:17', 'nawsheen'),
(89, '2019-12-21 04:21:18', 'reeshal'),
(90, '2019-12-21 04:21:48', 'nawsheen'),
(91, '2019-12-21 04:54:49', 'reeshal'),
(92, '2019-12-21 05:09:51', 'reeshal'),
(93, '2019-12-21 05:12:53', 'reeshal'),
(94, '2019-12-21 05:17:09', 'reeshal'),
(95, '2019-12-21 05:21:09', 'reeshal'),
(96, '2019-12-21 06:40:17', 'reeshal'),
(97, '2019-12-21 07:54:10', 'reeshal'),
(98, '2019-12-21 07:57:28', 'reeshal'),
(99, '2019-12-21 07:57:50', 'reeshal'),
(100, '2020-01-19 07:49:03', 'reeshal'),
(101, '2020-01-18 21:26:49', 'nawsheen'),
(102, '2020-01-18 21:27:12', 'reeshal'),
(104, '2020-01-18 21:40:05', 'reeshal'),
(105, '2020-01-18 21:54:13', 'nawsheen'),
(106, '2020-01-18 23:32:29', 'rishi'),
(107, '2020-01-18 23:33:26', 'rishi'),
(108, '2020-01-18 23:34:40', 'rishi'),
(109, '2020-01-18 23:37:19', 'rishi'),
(110, '2020-01-19 00:02:04', 'rishi'),
(111, '2020-01-19 00:05:56', 'rishi'),
(112, '2020-01-19 00:07:27', 'rishi'),
(113, '2020-01-19 00:11:39', 'rishi'),
(114, '2020-01-19 00:12:54', 'rishi'),
(115, '2020-01-19 00:13:07', 'reeshal'),
(116, '2020-01-19 00:13:28', 'reeshal'),
(117, '2020-01-19 00:13:37', 'rishi'),
(118, '2020-01-19 02:11:23', 'reeshaladmin'),
(119, '2020-01-19 02:11:39', 'reeshaladmin'),
(120, '2020-01-19 02:23:25', 'nawsheen'),
(121, '2020-02-03 02:37:07', 'reeshaladmin'),
(122, '2020-02-03 03:39:31', 'reeshal'),
(123, '2020-02-04 04:20:36', 'reeshaladmin'),
(124, '2020-02-05 01:19:22', 'reeshal'),
(125, '2020-02-10 03:41:11', 'reeshal'),
(126, '2020-02-13 01:36:27', 'reeshaladmin'),
(127, '2020-02-13 01:40:16', 'reeshal'),
(128, '2020-02-15 03:54:52', 'reeshal'),
(129, '2020-02-16 01:39:17', 'reeshal'),
(130, '2020-02-16 06:51:00', 'reeshal'),
(131, '2020-02-16 08:09:43', 'reeshaladmin'),
(132, '2020-02-16 08:24:16', 'reeshaladmin'),
(133, '2020-02-15 21:19:42', 'reeshal'),
(134, '2020-02-15 21:37:54', 'reeshaladmin'),
(135, '2020-02-15 22:00:17', 'reeshaladmin'),
(136, '2020-02-15 22:21:47', 'reeshaladmin'),
(137, '2020-02-17 04:52:20', 'reeshal'),
(138, '2020-02-18 01:47:48', 'reeshaladmin'),
(139, '2020-02-18 01:54:10', 'reeshaladmin'),
(140, '2020-02-18 03:18:23', 'reeshaladmin'),
(141, '2020-03-15 04:29:51', 'reeshal'),
(142, '2020-03-15 04:34:06', 'reeshaladmin'),
(143, '2020-03-15 04:34:51', 'reeshal'),
(144, '2020-03-15 04:35:38', 'nawsheen'),
(145, '2020-03-15 04:44:59', 'reeshal'),
(146, '2020-03-15 04:47:10', 'reeshal'),
(147, '2020-03-15 04:48:51', 'reeshaladmin'),
(148, '2020-03-15 06:44:52', 'reeshal'),
(149, '2020-03-15 06:46:11', 'reeshal'),
(150, '2020-03-15 06:46:48', 'rishi'),
(151, '2020-03-15 06:47:19', 'rishikesh'),
(152, '2020-03-15 06:47:42', 'nawsheen'),
(153, '2020-03-15 06:48:13', 'reeshal'),
(154, '2020-03-15 06:49:09', 'nawsheen');

-- --------------------------------------------------------

--
-- Table structure for table `Problem`
--

CREATE TABLE `Problem` (
  `problemId` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `username` varchar(15) NOT NULL,
  `subject` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Problem`
--

INSERT INTO `Problem` (`problemId`, `description`, `username`, `subject`) VALUES
(9, 'sdgueidh eiodqededj owpsk sopksdoe cdh djkvdjndsl3985', 'nawsheen', 'shitty'),
(10, 'sdxshiou pdwdo iwo dis ck hskjd soid', 'nawsheen', 'pokopdc'),
(11, 'xegdyufgebwiu hiogh wirufh ewiohflekuwhvdj .cksdjvnushvliovhjcskvn dsivhfuvhufshv ldks vjsib', 'nawsheen', '48694guyws'),
(12, 'cmowmcopr,ovpwrkcoi ewiodcm;elokcio wedjcoke', 'reeshal', 'deuowhocijdwc'),
(13, 'jeipowkoxpcewl[lxe[d]c;e[lokcworvewcv', 'reeshal', 'dwsjwiodjiewjfioerwjf');

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `productId` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `start_price` float NOT NULL,
  `feedback` text DEFAULT NULL,
  `is_sold` tinyint(1) NOT NULL DEFAULT 0,
  `category` varchar(30) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration` int(11) NOT NULL,
  `current_owner` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`productId`, `name`, `description`, `start_price`, `feedback`, `is_sold`, `category`, `start_time`, `end_time`, `duration`, `current_owner`) VALUES
(53, 'food', 'revwrj iwocjl ioewj cioewj ciooruh eciujnewlkcjliw', 28, NULL, 0, 'Art', '2019-12-18 14:41:22', '2020-07-14 01:41:00', 5003, 'reeshal'),
(55, 'Blue skirt', 'Cotton Dress 100% lightweight', 35, NULL, 0, 'Clothes', '2019-12-20 09:15:07', '2020-07-15 20:15:00', 5003, 'reeshal'),
(57, 'Michelangelo', 'Medieval Painting', 630, NULL, 0, 'Art', '2020-03-15 04:36:44', '2020-04-21 09:36:00', 893, 'reeshal'),
(58, 'Lord of the Rings', 'books collection', 28, 'interesting book', 1, 'Books and Magazines', '2020-03-15 09:56:59', '2020-03-15 09:56:59', 19, 'nawsheen'),
(59, 'red bonnet', 'nigga wearing red bonnet', 18, NULL, 0, 'Clothes', '2019-12-20 09:20:14', '2020-07-15 20:20:00', 5003, 'rishi'),
(60, 'Monitor LCD', 'lcd 24inch screen', 16, NULL, 0, 'Computers', '2019-12-20 09:21:06', '2020-07-15 20:21:00', 5003, 'rishi');

-- --------------------------------------------------------

--
-- Table structure for table `ProductImage`
--

CREATE TABLE `ProductImage` (
  `imageId` int(11) NOT NULL,
  `prodId` int(11) NOT NULL,
  `imageName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ProductImage`
--

INSERT INTO `ProductImage` (`imageId`, `prodId`, `imageName`) VALUES
(40, 53, 'img_2.jpg'),
(42, 55, 'blue-skirts-0661.jpg'),
(44, 57, 'mich.jpg'),
(45, 58, 'lotr.jpg'),
(46, 59, 'person_2.jpg'),
(47, 60, 'external-content.duckduckgo.com.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ProductTag`
--

CREATE TABLE `ProductTag` (
  `tagID` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `product_tags` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ProductTag`
--

INSERT INTO `ProductTag` (`tagID`, `productId`, `product_tags`) VALUES
(92, 53, 'rfe'),
(93, 53, 'red'),
(94, 53, 'ge'),
(95, 53, 'rb'),
(96, 53, 'r'),
(101, 55, 'blue'),
(102, 55, 'skirt'),
(103, 55, 'beautiful'),
(104, 55, 'cloth'),
(106, 57, 'art'),
(107, 58, 'wow'),
(108, 58, 'great'),
(109, 59, 'red'),
(110, 59, 'cloth'),
(111, 60, 'monitor');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `username` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `currency` varchar(25) DEFAULT NULL,
  `soldNotif` text DEFAULT NULL,
  `feedbackNotif` text DEFAULT NULL,
  `accountType` varchar(10) NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`username`, `password`, `firstname`, `lastname`, `gender`, `email`, `address`, `dob`, `currency`, `soldNotif`, `feedbackNotif`, `accountType`) VALUES
('nawsheen', '$2y$10$TPB1J1On3zbDVa/wwrBVPO50gMdeKDxV8ckDhFt3wBsg6KbVKkMaS', 'eefwrgfw', 'efrfrw', 'female', 'ewfrwj@gmail.com', 'frwtggtw', '2019-11-26', 'Mauritian Rupees', '', '', 'normal'),
('reeshal', '$2y$10$ilC/c8QroEXV1pF6vc1pWe5/CuyG.LUnKB/FweNLsOpcttPb9hcF6', 'Reeshal', 'Rittoo', 'male', 'rreeshal@gmail.com', 'Morc Terracine Souillac', '1999-08-18', 'US Dollars', '', NULL, 'normal'),
('reeshaladmin', '$2y$10$/gwSFVncNkPuiKGJX3SH6ezAmcoN6d4pDLX/pkEbfgeYeELAblSQG', 'admin', 'admin', 'admin', 'rreeshal@gmail.com', 'admin', '2020-01-19', NULL, NULL, NULL, 'admin'),
('reeshalrittoo', '$2y$10$PwmJF3uRKWOpJIcF1QAhcObsF.Wl2lEg6JsqBoAswR5s8s3YMkaKm', 'Reeshal', 'Rittoo', 'male', 'rreeshal@gmail.com', 'Souillac', '1999-08-18', 'Mauritian Rupees', '', NULL, 'normal'),
('rishi', '$2y$10$C.od5.vUeb14oKzd/WnhzekRSdEk.BGsAQbhfnHS7AueRjfXlLpHq', 'rishi', 'rwf', 'male', 'wcwr@gmail.com', 'vrevt', '2019-11-26', 'Euro', '', NULL, 'admin'),
('rishikesh', '$2y$10$KKmG6JC8Ox/wIw1s1bWyGuf9z7KQhYGQiOWxoEHwCF9/dvixKBpQ.', 'rishikesh', 'doorgah', 'male', 's@gmail.com', 'sjh', '2019-11-14', 'US Dollars', '', NULL, 'normal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AuctionDetail`
--
ALTER TABLE `AuctionDetail`
  ADD PRIMARY KEY (`auctionId`),
  ADD KEY `fk_au_user` (`current_owner`),
  ADD KEY `fk_au_prevowner` (`previous_owner`),
  ADD KEY `fk_au_prod` (`productId`);

--
-- Indexes for table `Bidding`
--
ALTER TABLE `Bidding`
  ADD PRIMARY KEY (`username`,`productId`),
  ADD KEY `fk_bidding_product` (`productId`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `Currency`
--
ALTER TABLE `Currency`
  ADD PRIMARY KEY (`currency`);

--
-- Indexes for table `FAQ`
--
ALTER TABLE `FAQ`
  ADD PRIMARY KEY (`faqId`);

--
-- Indexes for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  ADD PRIMARY KEY (`loginSessionNo`),
  ADD KEY `fk_loginhis_users` (`username`);

--
-- Indexes for table `Problem`
--
ALTER TABLE `Problem`
  ADD PRIMARY KEY (`problemId`),
  ADD KEY `fk_loginhistory_users` (`username`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `fk_product_user_currentowner` (`current_owner`);

--
-- Indexes for table `ProductImage`
--
ALTER TABLE `ProductImage`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `fk_image` (`prodId`);

--
-- Indexes for table `ProductTag`
--
ALTER TABLE `ProductTag`
  ADD PRIMARY KEY (`tagID`),
  ADD KEY `fktags` (`productId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_user_currency` (`currency`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AuctionDetail`
--
ALTER TABLE `AuctionDetail`
  MODIFY `auctionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `FAQ`
--
ALTER TABLE `FAQ`
  MODIFY `faqId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  MODIFY `loginSessionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `Problem`
--
ALTER TABLE `Problem`
  MODIFY `problemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `ProductImage`
--
ALTER TABLE `ProductImage`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `ProductTag`
--
ALTER TABLE `ProductTag`
  MODIFY `tagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AuctionDetail`
--
ALTER TABLE `AuctionDetail`
  ADD CONSTRAINT `fk_au_prevowner` FOREIGN KEY (`previous_owner`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_au_prod` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_au_user` FOREIGN KEY (`current_owner`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Bidding`
--
ALTER TABLE `Bidding`
  ADD CONSTRAINT `fk_bidding_product` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bidding_user` FOREIGN KEY (`username`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  ADD CONSTRAINT `fk_loginhis_users` FOREIGN KEY (`username`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Problem`
--
ALTER TABLE `Problem`
  ADD CONSTRAINT `fk_loginhistory_users` FOREIGN KEY (`username`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `fk_product_user_currentowner` FOREIGN KEY (`current_owner`) REFERENCES `Users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductImage`
--
ALTER TABLE `ProductImage`
  ADD CONSTRAINT `fk_image` FOREIGN KEY (`prodId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ProductTag`
--
ALTER TABLE `ProductTag`
  ADD CONSTRAINT `fk_tags` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fktags` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_user_currency` FOREIGN KEY (`currency`) REFERENCES `Currency` (`currency`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
