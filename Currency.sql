-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2020 at 03:36 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

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
-- Table structure for table `Currency`
--

CREATE TABLE `Currency` (
  `currency` varchar(50) NOT NULL DEFAULT 'dollar',
  `conversion_rate` float NOT NULL,
  `code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Every conversion uses dollar as base';

--
-- Dumping data for table `Currency`
--

INSERT INTO `Currency` (`currency`, `conversion_rate`, `code`) VALUES
('Afghan afghani', 76.1502, 'AFN'),
('Albanian lek', 116.227, 'ALL'),
('Algerian Dinar', 126.639, 'DZD'),
('Angolan kwanza', 556.587, 'AOA'),
('Argentine Peso', 65.0401, 'ARS'),
('Armenia Dram', 499.639, 'AMD'),
('Aruban florin', 1.80921, 'AWG'),
('Australian Dollar', 1.61008, 'AUD'),
('Azerbaijan Manat', 1.69618, 'AZN'),
('Bahamian Dollar', 0.998636, 'BSD'),
('Bahrain Dinar', 0.37642, 'BHD'),
('Bangladeshi taka', 84.4467, 'BDT'),
('Barbadian Dollar', 2.00164, 'BBD'),
('Belarussian Ruble', 2.52429, 'BYN'),
('Belize dollar', 1.99895, 'BZD'),
('Bolivian Boliviano', 6.87593, 'BOB'),
('Bosnia and Herzegovina convertible mark', 1.81947, 'BAM'),
('Botswana Pula', 12.1199, 'BWP'),
('Brazilian Real', 5.1746, 'BRL'),
('Brunei Dollar', 1.42853, 'BND'),
('Bulgarian Lev', 1.79895, 'BGN'),
('Canadian Dollar', 1.40346, 'CAD'),
('Cape Verde escudo', 102.818, 'CVE'),
('Central African CFA Franc', 614.153, 'XAF'),
('CFP Franc', 109.853, 'XPF'),
('Chilean Peso', 842.894, 'CLP'),
('Chinese Yuan', 7.06495, 'CNY'),
('Comoro franc', 442.766, 'KMF'),
('Costa Rican Colón', 572.031, 'CRC'),
('Croatian Kuna', 7.01169, 'HRK'),
('Cuban peso', 0.998636, 'CUP'),
('Czech Koruna', 24.9437, 'CZK'),
('Danish Krone', 6.86557, 'DKK'),
('Djiboutian franc', 177.929, 'DJF'),
('Dominican Peso', 54.0026, 'DOP'),
('East Caribbean Dollar', 2.70555, 'XCD'),
('Egyptian Pound', 15.7485, 'EGP'),
('Eritrean nakfa', 15.07, 'ERN'),
('Ethiopian birr', 32.6125, 'ETB'),
('Euro', 1.12, 'EUR'),
('Fiji Dollar', 2.28596, 'FJD'),
('Gambian dalasi', 51.2196, 'GMD'),
('Georgian lari', 3.20694, 'GEL'),
('Ghanaian Cedi', 5.76595, 'GHS'),
('Gibraltar pound', 0.811603, 'GIP'),
('Guatemalan Quetzal', 7.71608, 'GTQ'),
('Guyanese dollar', 208.866, 'GYD'),
('Haitian gourde', 95.3059, 'HTG'),
('Honduran Lempira', 24.8033, 'HNL'),
('Hong Kong Dollar', 7.75334, 'HKD'),
('Hungarian Forint', 329.391, 'HUF'),
('Icelandic Krona', 143.333, 'ISK'),
('Indian Rupee', 76.2409, 'INR'),
('Israeli New Sheqel', 3.59267, 'ILS'),
('Jamaican Dollar', 135.094, 'JMD'),
('Japanese Yen', 108.871, 'JPY'),
('Jordanian Dinar', 0.708865, 'JOD'),
('Kazakhstani Tenge', 433.061, 'KZT'),
('Kenyan shilling', 106.59, 'KES'),
('Kuwaiti Dinar', 0.309235, 'KWD'),
('Kyrgyzstan Som', 84.5619, 'KGS'),
('Lesotho loti', 18.3813, 'LSL'),
('Liberian dollar', 199.732, 'LRD'),
('Libyan Dinar', 1.4061, 'LYD'),
('Macanese pataca', 7.9847, 'MOP'),
('Macedonian denar', 56.7745, 'MKD'),
('Malawian kwacha', 736.096, 'MWK'),
('Malaysian Ringgit', 4.34033, 'MYR'),
('Maldivian rufiyaa', 15.4493, 'MVR'),
('Mauritanian ouguiya', 37.8802, 'MRU'),
('Mauritian Rupee', 39.5993, 'MUR'),
('Mexican Peso', 24.1473, 'MXN'),
('Moldova Lei', 18.3388, 'MDL'),
('Moroccan Dirham', 10.1207, 'MAD'),
('Mozambican metical', 67.6564, 'MZN'),
('Namibian dollar', 18.3813, 'NAD'),
('Nepalese Rupee', 121.855, 'NPR'),
('Neth. Antillean Guilder', 1.78905, 'ANG'),
('New Taiwan Dollar', 30.0972, 'TWD'),
('New Turkmenistan Manat', 3.49063, 'TMT'),
('New Zealand Dollar', 1.67113, 'NZD'),
('Nicaraguan Córdoba', 33.9157, 'NIO'),
('Nigerian Naira', 360.398, 'NGN'),
('Norwegian Krone', 10.2751, 'NOK'),
('Omani Rial', 0.384822, 'OMR'),
('Pakistani Rupee', 167.635, 'PKR'),
('Panamanian Balboa', 0.998636, 'PAB'),
('Papua New Guinean kina', 3.44045, 'PGK'),
('Peruvian Nuevo Sol', 3.35888, 'PEN'),
('Philippine Peso', 50.5175, 'PHP'),
('Polish Zloty', 4.17743, 'PLN'),
('Pound Sterling', 1.13, ''),
('Qatari Rial', 3.63909, 'QAR'),
('Romanian New Leu', 4.44543, 'RON'),
('Russian Rouble', 75.2949, 'RUB'),
('Rwandan franc', 951.756, 'RWF'),
('Salvadoran colon', 8.74953, 'SVC'),
('Samoan tala', 2.78832, 'WST'),
('São Tomé and Príncipe Dobra', 22.7612, 'STN'),
('Saudi Riyal', 3.7559, 'SAR'),
('Serbian Dinar', 107.236, 'RSD'),
('Seychelles rupee', 14.6934, 'SCR'),
('Singapore Dollar', 1.42649, 'SGD'),
('Solomon Islands dollar', 8.30066, 'SBD'),
('Somali shilling', 578.172, 'SOS'),
('South African Rand', 18.1715, 'ZAR'),
('South Sudanese pound', 159.737, 'SSP'),
('Sri Lanka Rupee', 193.403, 'LKR'),
('Sudanese pound', 55.144, 'SDG'),
('Surinamese dollar', 7.47163, 'SRD'),
('Swazi lilangeni', 18.3813, 'SZL'),
('Swedish Krona', 10.061, 'SEK'),
('Swiss Franc', 0.971168, 'CHF'),
('Syrian pound', 515.358, 'SYP'),
('Tajikistan Ruble', 10.2179, 'TJS'),
('Thai Baht', 32.7849, 'THB'),
('Trinidad Tobago Dollar', 6.7536, 'TTD'),
('Tunisian Dinar', 2.86508, 'TND'),
('Turkish Lira', 6.77578, 'TRY'),
('U.A.E Dirham', 3.67013, 'AED'),
('U.K. Pound Sterling', 0.807145, 'GBP'),
('Ukrainian Hryvnia', 27.2403, 'UAH'),
('Uruguayan Peso', 43.4257, 'UYU'),
('US Dollar', 1, 'USD'),
('Vanuatu vatu', 122.467, 'VUV'),
('West African CFA Franc', 613.349, 'XOF'),
('Yemeni rial', 249.874, 'YER'),
('Zambian kwacha', 18.9832, 'ZMW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Currency`
--
ALTER TABLE `Currency`
  ADD PRIMARY KEY (`currency`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
