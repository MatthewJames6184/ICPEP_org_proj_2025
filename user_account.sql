-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 23, 2025 at 04:09 PM
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
  `full_name` varchar(250) NOT NULL,
  `year_level` varchar(10) NOT NULL,
  `section` varchar(100) NOT NULL,
  `address` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`student_number`, `birthday`, `email`, `password`, `full_name`, `year_level`, `section`, `address`) VALUES
(2022102659, '2004-12-06', 'jamesmatthew@gmail.com', '03b50ccdfbec3f5ae03385f674776913', 'James dadadd', '3rd Year', 'CpE3A', 'Navarro St. Cutcot'),
(2022102675, '2004-12-06', 'jamesmatthew@gmail.com', 'a53aa7c19e9eb7fbe5f0eeddc13eabee', 'HAHA salvadore', '1st Year', 'CpE-3D', '0935 NAVARRO ST.'),
(2022102681, '2004-12-06', 'jamesmatthew@gmail.com', 'a53aa7c19e9eb7fbe5f0eeddc13eabee', 'James Matthew B. Arias', '4th Year', 'CpE-3A', '0935 Navarro St.'),
(2022102683, '2004-12-06', 'jamesmatthew@gmail.com', '0a754fd2076bae16ec29dd54adba7343', 'James dadadd', '3rd Year', 'CpE3A', 'Navarro St. Cutcot'),
(2022102688, '2004-12-06', 'jamesmatthew@gmail.com', '08b124932ed17eaf3f1067561b9204ac', 'James dadad', '3rd Year', 'CpE3A', 'Navarro St. Cutcot');

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
