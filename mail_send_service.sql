-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2021 at 03:36 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mail_send_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `Id` int(11) NOT NULL,
  `Card_number` varchar(255) NOT NULL,
  `Credit` double NOT NULL,
  `Cvc_number` varchar(255) DEFAULT NULL,
  `Valid_from` varchar(100) DEFAULT NULL,
  `Valid_till` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Gender` text NOT NULL,
  `Merchant_Password` varchar(255) NOT NULL,
  `m_status` varchar(11) DEFAULT NULL,
  `Image` blob DEFAULT NULL,
  `Balance` int(11) NOT NULL,
  `Create_at` time NOT NULL,
  `Current_at` time NOT NULL,
  `Token` varchar(255) DEFAULT NULL,
  `Card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`Id`, `Name`, `Email`, `Gender`, `Merchant_Password`, `m_status`, `Image`, `Balance`, `Create_at`, `Current_at`, `Token`, `Card_id`) VALUES
(0, 'Muhammad Usama', 'm.usamayounas669@gmail.com', 'Male', 'C123456789', NULL, NULL, 0, '00:00:00', '00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `Id` int(11) NOT NULL,
  `Mail_from` varchar(255) NOT NULL,
  `Mail_to` varchar(255) NOT NULL,
  `Mail_cc` varchar(255) DEFAULT NULL,
  `Mail_bcc` varchar(255) DEFAULT NULL,
  `Subject` varchar(300) DEFAULT NULL,
  `Body` varchar(1000) DEFAULT NULL,
  `Merchant_id` int(11) DEFAULT NULL,
  `Response_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `Id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `error` varchar(255) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `secondary_user`
--

CREATE TABLE `secondary_user` (
  `Id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `User_password` varchar(255) NOT NULL,
  `Email_permission` tinyint(1) DEFAULT NULL,
  `List_view_permission` tinyint(1) DEFAULT NULL,
  `Payment_permission` tinyint(1) DEFAULT NULL,
  `Forget_password_permission` tinyint(1) DEFAULT NULL,
  `Login_permission` tinyint(1) DEFAULT NULL,
  `Token` varchar(255) DEFAULT NULL,
  `Merchant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Token` (`Token`),
  ADD UNIQUE KEY `Card_id` (`Card_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Response_id` (`Response_id`),
  ADD KEY `Merchant_id` (`Merchant_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Token` (`Token`),
  ADD KEY `Merchant_id` (`Merchant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secondary_user`
--
ALTER TABLE `secondary_user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `merchant`
--
ALTER TABLE `merchant`
  ADD CONSTRAINT `merchant_ibfk_1` FOREIGN KEY (`Card_id`) REFERENCES `card` (`Id`) ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`Merchant_id`) REFERENCES `merchant` (`Id`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`Response_id`) REFERENCES `response` (`Id`);

--
-- Constraints for table `secondary_user`
--
ALTER TABLE `secondary_user`
  ADD CONSTRAINT `secondary_user_ibfk_1` FOREIGN KEY (`Merchant_id`) REFERENCES `merchant` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
