-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2019 at 09:31 AM
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
(2, '2019-10-27 04:21:00', 'reeshal');

-- --------------------------------------------------------

--
-- Table structure for table `Problem`
--

CREATE TABLE `Problem` (
  `problemId` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `username` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

INSERT INTO `Product` (`productId`, `name`, `description`, `start_price`, `feedback`, `is_sold`, `category`, `start_time`, `duration`, `current_owner`) VALUES
(9, 'Person 1', 'sexy', 89, NULL, 0, 'Art', '2019-10-26 06:55:14', 12, 'reeshal'),
(10, 'person 2', 'qwqd', 7, NULL, 0, 'Art', '2019-10-26 06:55:43', 36, 'reeshal'),
(11, 'person 3', 'ijiobygy', 100, NULL, 0, 'Books and Magazines', '2019-10-26 06:56:08', 8, 'reeshal'),
(12, 'person 4', 'wdewf', 12, NULL, 0, 'Computers', '2019-10-26 06:56:33', 4, 'reeshal'),
(13, 'person 5', 'swxcervw f g', 120, NULL, 0, 'Jewellery and Watches', '2019-10-26 06:57:31', 32, 'reeshal'),
(14, 'red', 'wcrcrw', 23, NULL, 0, 'Movies', '2019-10-26 16:04:16', 1, 'reeshal'),
(15, 'red', 'edef', 23, NULL, 0, 'Movies', '2019-10-26 16:05:08', 1, 'reeshal'),
(16, 'dwcec', 'wew', 34, NULL, 0, 'Health Care', '2019-10-26 16:05:33', 1, 'reeshal');

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
(7, 9, 'person_1.jpg'),
(8, 10, 'person_2.jpg'),
(9, 11, 'person_3.jpg'),
(10, 12, 'person_4.jpg'),
(11, 13, 'person_5.jpg'),
(12, 14, 'img_1.jpg'),
(13, 15, 'img_3.jpg'),
(14, 16, 'stars-space-planet-galaxy-wallpaper-preview.jpg');

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
(17, 9, 'pretty'),
(18, 9, 'oh'),
(19, 10, 'efe'),
(20, 10, 'etgrw'),
(21, 10, 'getef'),
(22, 11, 'nhngj'),
(23, 11, 'uktuthrtb'),
(24, 13, 'wde'),
(25, 13, 'rfef'),
(26, 14, 'red'),
(27, 15, 'ece'),
(28, 15, 'e'),
(29, 16, 'red');

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
  `currency` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`username`, `password`, `firstname`, `lastname`, `gender`, `email`, `address`, `dob`, `currency`) VALUES
('reeshal', '$2y$10$ilC/c8QroEXV1pF6vc1pWe5/CuyG.LUnKB/FweNLsOpcttPb9hcF6', 'Reeshal', 'Rittoo', 'male', 'rreeshal@gmail.com', 'Morc Terracine Souillac', '1999-08-18', 'US Dollars');

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
-- Indexes for table `Currency`
--
ALTER TABLE `Currency`
  ADD PRIMARY KEY (`currency`);

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
  ADD KEY `fk_tags` (`productId`);

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
  MODIFY `auctionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `LoginHistory`
--
ALTER TABLE `LoginHistory`
  MODIFY `loginSessionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ProductImage`
--
ALTER TABLE `ProductImage`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ProductTag`
--
ALTER TABLE `ProductTag`
  MODIFY `tagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  ADD CONSTRAINT `fk_tags` FOREIGN KEY (`productId`) REFERENCES `Product` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_user_currency` FOREIGN KEY (`currency`) REFERENCES `Currency` (`currency`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
