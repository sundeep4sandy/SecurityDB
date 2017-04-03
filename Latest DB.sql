-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2015 at 09:22 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `security`
--

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `Name` varchar(45) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `rolename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`Name`, `type`, `description`, `rolename`) VALUES
('grant', 'Account', 'Grant account privilege', 'role1'),
('Select', 'Relation', 'select privilege', 'role1');

-- --------------------------------------------------------

--
-- Table structure for table `rlnprv_roles_tbl`
--

CREATE TABLE IF NOT EXISTS `rlnprv_roles_tbl` (
  `privilegename` varchar(45) NOT NULL,
  `rolename` varchar(100) NOT NULL,
  `tablename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rlnprv_roles_tbl`
--

INSERT INTO `rlnprv_roles_tbl` (`privilegename`, `rolename`, `tablename`) VALUES
('Select', 'role1', 'Table1');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `Name` varchar(100) NOT NULL,
  `Description` varchar(345) DEFAULT NULL,
  `OwnerId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`Name`, `Description`, `OwnerId`) VALUES
('Table1', 'Table1', 1),
('Table2', 'Table2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `ID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `RoleName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`ID`, `Name`, `Phone`, `RoleName`) VALUES
(1, 'Sridhar', '817971', 'role1'),
(2, 'Mudassir', '87264', 'role1'),
(3, 'XYZ', '81797', 'role1'),
(4, 'lmn', '87654', 'role1'),
(5, 'pqr', '8765432', 'role1');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `RoleName` varchar(100) NOT NULL,
  `description` varchar(245) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`RoleName`, `description`) VALUES
('role1', 'sample text');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`Name`), ADD KEY `role_idx` (`rolename`);

--
-- Indexes for table `rlnprv_roles_tbl`
--
ALTER TABLE `rlnprv_roles_tbl`
  ADD PRIMARY KEY (`privilegename`,`rolename`,`tablename`), ADD KEY `prv_fk_idx` (`privilegename`), ADD KEY `role_fk_idx` (`rolename`), ADD KEY `tbl_fk_idx` (`tablename`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`Name`), ADD KEY `owner_idx` (`OwnerId`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`ID`), ADD KEY `role_idx` (`RoleName`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`RoleName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `privileges`
--
ALTER TABLE `privileges`
ADD CONSTRAINT `role_fk` FOREIGN KEY (`rolename`) REFERENCES `user_roles` (`RoleName`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rlnprv_roles_tbl`
--
ALTER TABLE `rlnprv_roles_tbl`
ADD CONSTRAINT `priv_fk` FOREIGN KEY (`privilegename`) REFERENCES `privileges` (`Name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `rln_fk` FOREIGN KEY (`privilegename`) REFERENCES `privileges` (`Name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `tbl_fk` FOREIGN KEY (`tablename`) REFERENCES `tables` (`Name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
ADD CONSTRAINT `owner` FOREIGN KEY (`OwnerId`) REFERENCES `user_accounts` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
ADD CONSTRAINT `role` FOREIGN KEY (`RoleName`) REFERENCES `user_roles` (`RoleName`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
