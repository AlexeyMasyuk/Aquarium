-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2021 at 08:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_prj`
--

-- --------------------------------------------------------

--
-- Table structure for table `aa`
--

CREATE TABLE `aa` (
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `tempT` varchar(5) NOT NULL,
  `ph` varchar(5) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aa`
--

INSERT INTO `aa` (`time`, `tempT`, `ph`, `level`) VALUES
('2020-10-27 15:10:09', '23', '7.5', '500'),
('2020-10-27 15:10:31', '23', '7.4', '510'),
('2020-10-27 15:10:48', '24', '7.3', '500'),
('2020-11-09 14:08:43', '24', '7.5', '500'),
('2020-11-09 14:08:55', '25', '7.4', '505'),
('2020-11-09 14:09:07', '26', '7.3', '510'),
('2020-11-09 14:09:11', '26', '7.3', '510'),
('2020-11-09 14:09:20', '25', '7.4', '505'),
('2020-11-09 14:10:36', '24', '7.5', '510'),
('2020-11-09 14:10:54', '25', '7.4', '505'),
('2020-11-09 14:11:12', '26', '7.3', '500'),
('2020-11-09 14:11:27', '27', '7.2', '490'),
('2020-11-09 14:11:51', '26', '7.1', '500');

-- --------------------------------------------------------

--
-- Table structure for table `alex`
--

CREATE TABLE `alex` (
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `Temp` varchar(5) NOT NULL,
  `ph` varchar(5) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alex`
--

INSERT INTO `alex` (`time`, `Temp`, `ph`, `level`) VALUES
('2020-10-27 15:10:09', '23', '7.5', '500'),
('2020-10-27 15:10:31', '23', '7.4', '510'),
('2020-10-27 15:10:48', '24', '7.3', '500'),
('2020-11-09 14:08:43', '24', '7.5', '500'),
('2020-11-09 14:08:55', '25', '7.4', '505'),
('2020-11-09 14:09:07', '26', '7.3', '510'),
('2020-11-09 14:09:11', '26', '7.3', '510'),
('2020-11-09 14:09:20', '25', '7.4', '505'),
('2020-11-09 14:10:36', '24', '7.5', '510'),
('2020-11-09 14:10:54', '25', '7.4', '505'),
('2020-11-09 14:11:12', '26', '7.3', '500'),
('2020-11-09 14:11:27', '27', '7.2', '490'),
('2020-11-09 14:11:51', '26', '7.1', '500');

-- --------------------------------------------------------

--
-- Table structure for table `ddd`
--

CREATE TABLE `ddd` (
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `Temp` varchar(5) NOT NULL,
  `ph` varchar(5) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ddd`
--

INSERT INTO `ddd` (`time`, `Temp`, `ph`, `level`) VALUES
('2020-10-27 15:10:09', '23', '7.5', '500'),
('2020-10-27 15:10:31', '23', '7.4', '510'),
('2020-10-27 15:10:48', '24', '7.3', '500'),
('2020-11-09 14:08:43', '24', '7.5', '500'),
('2020-11-09 14:08:55', '25', '7.4', '505'),
('2020-11-09 14:09:07', '26', '7.3', '510'),
('2020-11-09 14:09:11', '26', '7.3', '510'),
('2020-11-09 14:09:20', '25', '7.4', '505'),
('2020-11-09 14:10:36', '24', '7.5', '510'),
('2020-11-09 14:10:54', '25', '7.4', '505'),
('2020-11-09 14:11:12', '26', '7.3', '500'),
('2020-11-09 14:11:27', '27', '7.2', '490'),
('2020-11-09 14:11:51', '26', '7.1', '500');

-- --------------------------------------------------------

--
-- Table structure for table `userpass`
--

CREATE TABLE `userpass` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(32) NOT NULL,
  `lastName` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tempHigh` varchar(5) NOT NULL,
  `tempLow` varchar(5) NOT NULL,
  `phHigh` varchar(5) NOT NULL,
  `phLow` varchar(5) NOT NULL,
  `feedAlert` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userpass`
--

INSERT INTO `userpass` (`username`, `password`, `firstName`, `lastName`, `email`, `tempHigh`, `tempLow`, `phHigh`, `phLow`, `feedAlert`) VALUES
('aa', '$2y$10$hQj4PnwuAiFr0hkL7FKvi.60BdBE9i8Y6nFqzfP/.syMhy/kuXUDG', 'aa', 'aa', 'aa@aa', '25', '24', '7.5', '7.2', ''),
('alex', '$2y$10$rlVl3/9MM1M8.WvctkesuOYL4Q8w3138I8kWYsld/N2W6j8uYsexG', 'FU', 'alexC', 'dds', '25', '23', '7.5', '6.5', '2 20:00 0'),
('ddd', '$2y$10$9s7Ewk9FI8NbbrMTjUDYfejPmkK.9oJJntpAbeUI5dItQCGa97K42', 'ddd', 'ddd', 'ddd@asd', '25', '23', '7.5', '6.5', '1 20:00 0'),
('ww', '$2y$10$Pk8XR0pBGyVY0ZhVkH5sK.WamkG.06eCurraCmaWOwSbmiQjuLkWq', 'ww', 'ww', 'ww@ww', '25', '23', '7.5', '6.5', '1 20:00 0'),
('yulia', '$2y$10$7ncWkIoASiQoYj/GBODo4OXKUcB7KingZ7KZ5j69qhzTVh8YJcoVS', 'yulia', 'yulia', 'yulia@yulia', '25', '', '8', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ww`
--

CREATE TABLE `ww` (
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `tempT` varchar(5) NOT NULL,
  `ph` varchar(5) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yulia`
--

CREATE TABLE `yulia` (
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `Temp` varchar(5) NOT NULL,
  `ph` varchar(5) NOT NULL,
  `level` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yulia`
--

INSERT INTO `yulia` (`time`, `Temp`, `ph`, `level`) VALUES
('2020-10-27 15:10:09', '23', '7.5', '500'),
('2020-10-27 15:10:31', '23', '7.4', '510'),
('2020-10-27 15:10:48', '24', '7.3', '500'),
('2020-11-09 14:08:43', '24', '7.5', '500'),
('2020-11-09 14:08:55', '25', '7.4', '505'),
('2020-11-09 14:09:07', '26', '7.3', '510'),
('2020-11-09 14:09:11', '26', '7.3', '510'),
('2020-11-09 14:09:20', '25', '7.4', '505'),
('2020-11-09 14:10:36', '24', '7.5', '510'),
('2020-11-09 14:10:54', '25', '7.4', '505'),
('2020-11-09 14:11:12', '26', '7.3', '500'),
('2020-11-09 14:11:27', '27', '7.2', '490'),
('2020-11-09 14:11:51', '26', '7.1', '500');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aa`
--
ALTER TABLE `aa`
  ADD PRIMARY KEY (`time`);

--
-- Indexes for table `alex`
--
ALTER TABLE `alex`
  ADD PRIMARY KEY (`time`);

--
-- Indexes for table `ddd`
--
ALTER TABLE `ddd`
  ADD PRIMARY KEY (`time`);

--
-- Indexes for table `userpass`
--
ALTER TABLE `userpass`
  ADD UNIQUE KEY `un` (`username`);

--
-- Indexes for table `ww`
--
ALTER TABLE `ww`
  ADD PRIMARY KEY (`time`);

--
-- Indexes for table `yulia`
--
ALTER TABLE `yulia`
  ADD PRIMARY KEY (`time`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
