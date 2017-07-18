-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2017 at 01:16 PM
-- Server version: 5.7.17
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gene`
--

-- --------------------------------------------------------

--
-- Table structure for table `datatypes`
--

CREATE TABLE `datatypes` (
  `typeid` int(11) NOT NULL,
  `typename` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `dated` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailtypes`
--

CREATE TABLE `detailtypes` (
  `detailid` int(11) NOT NULL,
  `detailname` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `fieldid` int(11) NOT NULL DEFAULT '0',
  `dated` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eventdates`
--

CREATE TABLE `eventdates` (
  `cid` int(11) NOT NULL DEFAULT '0',
  `dated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `etype` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `fid` int(11) NOT NULL DEFAULT '0',
  `field_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `dated` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hold_detailfields`
--

CREATE TABLE `hold_detailfields` (
  `detailid` int(11) NOT NULL DEFAULT '0',
  `fieldid` int(11) NOT NULL DEFAULT '0',
  `dated` date NOT NULL DEFAULT '0000-00-00',
  `ord` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `uid` int(11) NOT NULL DEFAULT '0',
  `ltype` int(11) NOT NULL DEFAULT '0',
  `dated` datetime DEFAULT '0000-00-00 00:00:00',
  `param` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marriages`
--

CREATE TABLE `marriages` (
  `husband_cid` int(11) NOT NULL DEFAULT '0',
  `wife_cid` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `mid` int(11) NOT NULL,
  `comments` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `dom` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mru`
--

CREATE TABLE `mru` (
  `cid` int(11) NOT NULL DEFAULT '0',
  `dated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `cid` int(11) NOT NULL,
  `firstname` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `father_cid` int(11) DEFAULT NULL,
  `mother_cid` int(11) DEFAULT NULL,
  `created` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `lastname` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `gender` tinyint(1) DEFAULT '1',
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `dob` datetime DEFAULT NULL,
  `dod` datetime DEFAULT NULL,
  `bPics` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `treepos` int(10) UNSIGNED NOT NULL DEFAULT '50',
  `isDead` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_res` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_off` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `father_root` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `updated` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pics`
--

CREATE TABLE `pics` (
  `pid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `width` int(11) NOT NULL DEFAULT '0',
  `height` int(11) NOT NULL DEFAULT '0',
  `comments` text CHARACTER SET latin1 NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `cid` int(11) NOT NULL DEFAULT '0',
  `father_tree` int(11) NOT NULL DEFAULT '0',
  `mother_tree` int(11) NOT NULL DEFAULT '0',
  `father_root` int(11) NOT NULL DEFAULT '0',
  `mother_root` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `YiiSession`
--

CREATE TABLE `YiiSession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datatypes`
--
ALTER TABLE `datatypes`
  ADD PRIMARY KEY (`typeid`);

--
-- Indexes for table `detailtypes`
--
ALTER TABLE `detailtypes`
  ADD PRIMARY KEY (`detailid`);

--
-- Indexes for table `eventdates`
--
ALTER TABLE `eventdates`
  ADD KEY `dated` (`dated`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dated` (`dated`),
  ADD KEY `date_sort` (`dated`);

--
-- Indexes for table `marriages`
--
ALTER TABLE `marriages`
  ADD PRIMARY KEY (`mid`),
  ADD UNIQUE KEY `husband_cid` (`husband_cid`,`wife_cid`),
  ADD KEY `wife_cid` (`wife_cid`);

--
-- Indexes for table `mru`
--
ALTER TABLE `mru`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `father_cid` (`father_cid`,`mother_cid`),
  ADD KEY `mother_cid` (`mother_cid`);

--
-- Indexes for table `pics`
--
ALTER TABLE `pics`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `unq` (`cid`,`name`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `YiiSession`
--
ALTER TABLE `YiiSession`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datatypes`
--
ALTER TABLE `datatypes`
  MODIFY `typeid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detailtypes`
--
ALTER TABLE `detailtypes`
  MODIFY `detailid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5908;
--
-- AUTO_INCREMENT for table `marriages`
--
ALTER TABLE `marriages`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;
--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1724;
--
-- AUTO_INCREMENT for table `pics`
--
ALTER TABLE `pics`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventdates`
--
ALTER TABLE `eventdates`
  ADD CONSTRAINT `eventdates_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `persons` (`cid`);

--
-- Constraints for table `marriages`
--
ALTER TABLE `marriages`
  ADD CONSTRAINT `marriages_ibfk_1` FOREIGN KEY (`husband_cid`) REFERENCES `persons` (`cid`),
  ADD CONSTRAINT `marriages_ibfk_2` FOREIGN KEY (`wife_cid`) REFERENCES `persons` (`cid`);

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`father_cid`) REFERENCES `persons` (`cid`),
  ADD CONSTRAINT `persons_ibfk_2` FOREIGN KEY (`mother_cid`) REFERENCES `persons` (`cid`);

--
-- Constraints for table `pics`
--
ALTER TABLE `pics`
  ADD CONSTRAINT `pics_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `persons` (`cid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
