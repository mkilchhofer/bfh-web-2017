-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 19, 2018 at 03:25 PM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mygear`
--

-- --------------------------------------------------------

--
-- Table structure for table `Appearance`
--

CREATE TABLE `Appearance` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Attachment`
--

CREATE TABLE `Attachment` (
  `id` int(11) NOT NULL,
  `typeId` int(11) NOT NULL,
  `gearId` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` mediumblob DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AttachmentType`
--

CREATE TABLE `AttachmentType` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Functioning`
--

CREATE TABLE `Functioning` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GearItem`
--

CREATE TABLE `GearItem` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currentOwnerId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `purchasePrice` decimal(8,2) NOT NULL,
  `purchaseDate` date NOT NULL,
  `purchasePlace` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Packaging`
--

CREATE TABLE `Packaging` (
  `id` int(11) NOT NULL,
  `title_en` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_de` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Sale`
--

CREATE TABLE `Sale` (
  `id` int(11) NOT NULL,
  `gearId` int(11) NOT NULL,
  `salesPrice` decimal(8,2) NOT NULL,
  `salesStart` datetime NOT NULL,
  `salesEnd` datetime NOT NULL,
  `appearanceId` int(11) NOT NULL,
  `functioningId` int(11) NOT NULL,
  `packagingId` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `userName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` int(11) NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrationDate` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Appearance`
--
ALTER TABLE `Appearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Attachment`
--
ALTER TABLE `Attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Attachment_gearId` (`gearId`),
  ADD KEY `FK_Attachment_typeId` (`typeId`);

--
-- Indexes for table `AttachmentType`
--
ALTER TABLE `AttachmentType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Functioning`
--
ALTER TABLE `Functioning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_GearItem_currentOwnerId` (`currentOwnerId`),
  ADD KEY `FK_GearItem_categoryId` (`categoryId`);

--
-- Indexes for table `Packaging`
--
ALTER TABLE `Packaging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Sale`
--
ALTER TABLE `Sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Sale_gearId` (`gearId`),
  ADD KEY `FK_Sale_appearanceId` (`appearanceId`),
  ADD KEY `FK_Sale_functioningId` (`functioningId`),
  ADD KEY `FK_Sale_packagingId` (`packagingId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Appearance`
--
ALTER TABLE `Appearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Attachment`
--
ALTER TABLE `Attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `AttachmentType`
--
ALTER TABLE `AttachmentType`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Functioning`
--
ALTER TABLE `Functioning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `GearItem`
--
ALTER TABLE `GearItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `Packaging`
--
ALTER TABLE `Packaging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Sale`
--
ALTER TABLE `Sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attachment`
--
ALTER TABLE `Attachment`
  ADD CONSTRAINT `FK_Attachment_gearId` FOREIGN KEY (`gearId`) REFERENCES `GearItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Attachment_typeId` FOREIGN KEY (`typeId`) REFERENCES `AttachmentType` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `GearItem`
--
ALTER TABLE `GearItem`
  ADD CONSTRAINT `FK_GearItem_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `Category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_GearItem_currentOwnerId` FOREIGN KEY (`currentOwnerId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Sale`
--
ALTER TABLE `Sale`
  ADD CONSTRAINT `FK_Sale_appearanceId` FOREIGN KEY (`appearanceId`) REFERENCES `Appearance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_functioningId` FOREIGN KEY (`functioningId`) REFERENCES `Functioning` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_Sale_gearId` FOREIGN KEY (`gearId`) REFERENCES `GearItem` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Sale_packagingId` FOREIGN KEY (`packagingId`) REFERENCES `Packaging` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
