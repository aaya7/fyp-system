-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 06:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `customerName` varchar(100) NOT NULL,
  `customerCategory` varchar(10) DEFAULT NULL,
  `customerFaculty` varchar(25) DEFAULT NULL,
  `customerCourse` varchar(25) DEFAULT NULL,
  `customerAddress` varchar(100) DEFAULT NULL,
  `customerPnum` varchar(20) DEFAULT NULL,
  `customerEmail` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `customerName`, `customerCategory`, `customerFaculty`, `customerCourse`, `customerAddress`, `customerPnum`, `customerEmail`, `password`, `token`) VALUES
(2022017389, 'Mark Davis', 'student', 'FA', 'AC120', 'No 19, Gamma A, UiTM Tapah', '011-82649374', 'mark@gmail.com', '@918nww', NULL),
(2022063691, 'Damia Natasha', 'student', 'FA', 'AC120', 'No 2, Beta 7, UiTM Tapah', '011-65832874', 'mia@gmail.com', '@918nww', NULL),
(2022090738, 'Ahmad Badrul', 'staff', 'KPPIM', '', 'Bilik 6, Blok B, Bangunan Pensyarah, UiTM Tapah', '018-4388943', 'bad@gmail.com', 'abc192', NULL),
(2022100817, 'Aliff Ismail', 'student', 'FA', 'AC151', 'No 11, Alpha 3, UiTM Tapah', '017-9920638', 'aliff@gmail.com', 'njkd9299', NULL),
(2022193891, 'Olivia Garcia', 'staff', 'FA', '', 'Bilik 9, Blok B, Bangunan Pensyarah, UiTM Tapah', '019-7364883', 'olivia@gmail.com', 'njkd9299', NULL),
(2022202982, 'Chris Wilson', 'student', 'KPPIM', 'CS110', 'No 5, Alpha 5, UiTM Tapah', '017-9837474', 'chris@gmail.com', '172*sh', NULL),
(2022250825, 'Mysara Dian', 'student', 'KPPIM', 'CS110', 'No 25, Gamma B, UiTM Tapah', '018-9927643', 'dian@gmail.com', '172*sh', NULL),
(2022502887, 'Sophia Rodriguez', 'student', 'KPPIM', 'CS112', 'No 6, Gamma B, UiTM Tapah', '012-9928633', 'sophia@gmail.com', '26g2j@', NULL),
(2022738202, 'John Doe', 'student', 'KPPIM', 'CS230', 'No 7, Alpha 9, UiTM Tapah', '011-93739287', 'john@gmail.com', '123456', NULL),
(2022738646, 'Nur Sarah', 'student', 'KPPIM', 'CS111', 'No 3, Beta 9, UiTM Tapah', '012-8377294', 'sarah@gmail.com', '123456', NULL),
(2022787493, 'user', 'student', 'KPPIM', 'CS230', 'No 447, Jalan 18, Taman Universiti Wallagonia, Tapah Road, Perak', '019-4439323', 'user@gmail.com', 'user', NULL),
(2022945710, 'Bob Johnson', 'staff', 'FSG', '', 'Bilik 2, Blok A, Bangunan Pensyarah, UiTM Tapah', '013-9848790', 'bob@gmail.com', 'abc192', NULL),
(2023049384, 'Emma Brown', 'staff', 'KPPIM', '', 'Bilik 7, Kompleks Pentadbiran, UiTM Tapah', '018-4573883', 'emma@gmail.com', '829wjw', NULL),
(2023094726, 'Alice Smith', 'student', 'FA', 'AC110', 'No 16, Gamma B, UiTM Tapah', '019-4720280', 'alice@gmail.com', '123abc', NULL),
(2023529039, 'Azim Farhan', 'student', 'KPPIM', 'CS230', 'No 31, Gamma A, UiTM Tapah', '013-6639854', 'azim@gmail.com', '829wjw', NULL),
(2023672892, 'Sarah Miller', 'staff', 'FSG', '', 'No 8, Beta 12, UiTM Tapah', '011-92466478', 'sarah@gmail.com', '92undu2', NULL),
(2023692823, 'Danish Ilhan', 'staff', 'FSG', '', 'Bilik 11, Kompleks Pentadbiran, UiTM Tapah', '019-7378945', 'ilhan@gmail.com', '92undu2', NULL),
(2023718383, 'Alia Uamirah', 'student', 'FA', 'AC110', 'No 10, Beta 4, UiTM Tapah', '013-9837792', 'alia@gmail.com', '123abc', NULL),
(2023937382, 'Michael Lee', 'student', 'FSG', 'AS120', 'No 1, Gamma A, UiTM Tapah', '011-73669277', 'michael@gmail.com', '0293jhf@', NULL),
(2023937470, 'Richard Sam', 'student', 'KPPIM', 'CS143', 'No 8, Alpha 7, UiTM Tapah', '019-8937648', 'sam@gmail.com', '0293jhf@', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
