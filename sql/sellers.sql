-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 06:46 PM
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
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `sellerID` int(11) NOT NULL,
  `sellerName` varchar(100) NOT NULL,
  `sellerCategory` varchar(10) DEFAULT NULL,
  `sellerFaculty` varchar(25) DEFAULT NULL,
  `sellerCourse` varchar(25) DEFAULT NULL,
  `sellerAddress` varchar(100) DEFAULT NULL,
  `sellerPnum` varchar(20) DEFAULT NULL,
  `sellerEmail` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `shopName` varchar(100) DEFAULT NULL,
  `shopCreated` date DEFAULT curdate(),
  `shopCategory` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`sellerID`, `sellerName`, `sellerCategory`, `sellerFaculty`, `sellerCourse`, `sellerAddress`, `sellerPnum`, `sellerEmail`, `password`, `token`, `shopName`, `shopCreated`, `shopCategory`) VALUES
(2021038205, 'Jane Smith', 'student', 'FA', 'AC120', 'No 9, Beta 6, UiTM Tapah', '011-30298772', 'jane@gmail.com', 'pass456word', NULL, 'selfStyle', '2023-11-07', 'Fashion'),
(2021754264, 'William Smith', 'student', 'KPPIM', 'CS110', 'No 5, Alpha 4, UiTM Tapah', '018-8821661', 'william@gmail.com', 'willPass', NULL, 'Fastationery', '2023-11-07', 'Stationery'),
(2021875773, 'Eva Kim', 'student', 'FA', 'AC11O', 'No 10, Beta 11, UiTM Tapah', '018-4279811', 'eva@gmail.com', 'password5678', NULL, 'evePreloved', '2023-11-07', 'Preloved'),
(2021990298, 'David Matthew', 'staff', '', '', 'Campus Mart, UiTM Tapah', '011-92873921', 'david@gmail.com', 'davidPass', NULL, 'Campus Mart', '2023-11-07', 'Basic Needs'),
(2022138219, 'Scarlett Johnson', 'student', 'FA', 'AC151', 'No 19, Gamma B, UiTM Tapah', '012-5482752', 'scarlett@gmail.com', 'securePWD', NULL, 'beYOUty', '2023-11-07', 'Health & Beauty'),
(2022337985, 'Olivia Rodrigo', 'student', 'FSG', 'AS120', 'No 365, Jalan 16, Taman Universiti Wallagonia, Tapah Road, Perak', '011-98837932', 'olivia@gmail.com', 'olivia456', NULL, 'LOVEurBODY', '2023-11-07', 'Health & Beauty'),
(2022499439, 'Sam Lee', 'student', 'KPPIM', 'CS143', 'No 4, Gamma A, UiTM Tapah', '017-7720911', 'lee@gmail.com', 'pass1234', NULL, 'Eximius Regiment Brassband Club', '2023-11-07', 'Online Ticketing'),
(2023298487, 'Sophie Wilson', 'student', 'KPPIM', 'CS230', 'No 448, Jalan 18, Taman Universiti Wallagonia, Tapah Road, Perak', '019-8825342', 'sophie@gmail.com', 'sophie123', NULL, 'Foodie.co', '2023-11-07', 'Food'),
(2023338838, 'Jeniffer Ang', 'student', 'KPPIM', 'CS230', 'No 446, Jalan 18, Taman Universiti Wallagonia, Tapah Road, Perak', '013-9827737', 'angg@gmail.com', 'password123', NULL, 'fashionThingy', '2023-11-07', 'Fashion'),
(2023530198, 'Michael Taylor', 'staff', '', '', 'eBook Store, UiTM Tapah', '012-0672922', 'michael@gmail.com', 'mikePassword', NULL, 'eBookStore', '2023-11-07', ' Books');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`sellerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
