-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 24, 2025 at 08:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icpep_web_dbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `student_number` int(32) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `year_level` varchar(10) NOT NULL,
  `section` varchar(100) NOT NULL,
  `has_voted` tinyint(1) DEFAULT 0,
  `otp_verification` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`student_number`, `birthday`, `email`, `password`, `first_name`, `last_name`, `year_level`, `section`, `has_voted`, `otp_verification`) VALUES
(2022102639, '2004-12-06', 'ariasjamesmatthew@gmail.com', '2048d574f6f7e4d710e411c0fc60ab77', 'James Matthew', 'Arias', '1st Year', 'CpE-3A', 0, ''),
(2022102659, '2004-12-06', 'jamesmatthew@gmail.com', '03b50ccdfbec3f5ae03385f674776913', 'James dadadd', '', '3rd Year', 'CpE3A', 0, ''),
(2022102675, '2004-12-06', 'jamesmatthew@gmail.com', 'a53aa7c19e9eb7fbe5f0eeddc13eabee', 'HAHA salvadore', '', '1st Year', 'CpE-3D', 0, ''),
(2022102681, '2004-12-06', 'arias.james18@gmail.com', '2048d574f6f7e4d710e411c0fc60ab77', 'James Matthew', '', '3rd Year', 'CpE-3A', 0, ''),
(2022102683, '2004-12-06', 'jamesmatthew@gmail.com', '0a754fd2076bae16ec29dd54adba7343', 'James dadadd', '', '3rd Year', 'CpE3A', 0, ''),
(2022102688, '2004-12-06', 'jamesmatthew@gmail.com', '08b124932ed17eaf3f1067561b9204ac', 'James dadad', '', '3rd Year', 'CpE3A', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`student_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
