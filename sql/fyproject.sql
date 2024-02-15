-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2023 at 02:22 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `adminName` varchar(100) NOT NULL,
  `adminDepartment` varchar(10) DEFAULT NULL,
  `adminPnum` varchar(20) DEFAULT NULL,
  `adminEmail` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminDepartment`, `adminPnum`, `adminEmail`, `password`, `token`) VALUES
(123, 'admin', 'KPPIM', '019-4439325', 'admin@gmail.com', 'admin', NULL),
(124, 'superadmin', 'FSG', '011-39288022', 'superadmin@gmail.com', 'superadmin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `cartQuantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discountID` int(11) NOT NULL,
  `discountName` varchar(50) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discountID`, `discountName`, `discount_percent`) VALUES
(1, 'NODISCOUNT', 0),
(5, 'DISCOUNT5%', 5),
(10, 'DISCOUNT10%', 10),
(15, 'DISCOUNT15%', 15),
(20, 'DISCOUNT20%', 20),
(25, 'DISCOUNT25%', 25),
(30, 'DISCOUNT30%', 30),
(35, 'DISCOUNT35%', 35),
(40, 'DISCOUNT40%', 40),
(45, 'DISCOUNT45%', 45),
(50, 'DISCOUNT50%', 50);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `order_date` date DEFAULT curdate(),
  `cod_date` date DEFAULT NULL,
  `productID` int(11) DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `statusID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `product_mandate` date DEFAULT NULL,
  `product_expdate` date DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `productStatus` varchar(15) DEFAULT NULL,
  `sellerID` int(11) DEFAULT NULL,
  `discountID` int(11) DEFAULT NULL,
  `productAddDate` date DEFAULT curdate(),
  `productPrice` decimal(7,2) NOT NULL,
  `productImg` text DEFAULT NULL,
  `productDesc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `product_mandate`, `product_expdate`, `productQuantity`, `productStatus`, `sellerID`, `discountID`, `productAddDate`, `productPrice`, `productImg`, `productDesc`) VALUES
(4, 'Antabax Body Soap', '2022-08-03', '2024-02-05', 27, 'Available', 2022337985, 10, '2023-11-08', 5.50, '../pic/Products/antabax.jpeg', '<ul><b>About Antabax</b><br><br><li>Antabax is a reliable antibacterial soap that offers thorough cleanliness and protection against germs.</li><br><li>Its unique formula ensures effective elimination of bacteria, providing a refreshing and hygienic experience after each use.</li><br><li>Antabax caters to diverse preferences, offering various scents and formulations to suit individual needs for cleanliness and antibacterial care.</li></ul>\r\n'),
(5, 'Pepperidge Cookies', '2022-11-17', '2024-11-15', 35, 'Available', 2023298487, 1, '2023-11-09', 10.90, '../pic/Products/cookies.jpeg', '<ul><b>About Pepperidge Cookies</b><br><br>\r\n<li>Pepperidge Cookies are a delightful range of baked treats, offering a variety of flavors and textures to please every palate.</li><br>\r\n<li>From the classic sweetness of the Milano to the rich indulgence of the Sausalito, each Pepperidge cookie brings a unique and satisfying taste experience.</li><br>\r\n<li>The Pepperidge Cookies collection caters to a wide array of preferences, ensuring there\'s a perfect cookie for every craving, whether for a simple snack or an elegant dessert.</li></ul>\r\n'),
(6, 'Corntoz', '2023-11-08', '2024-09-21', 51, 'Available', 2021990298, 1, '2023-11-09', 1.00, '../pic/Products/corntoz.jpeg', '<ul><b>About Corntoz</b><br><br>\r\n<li>Corntoz is a popular corn snack with a crunchy texture and savory flavors, available in various colors, each representing a distinct taste profile.</li><br>\r\n<li>The yellow variant typically offers a zesty cheese flavor, the green version embodies a tangy lime taste, and the red variation presents a spicy chili sensation.</li><br>\r\n<li>Each color variation of Corntoz provides a unique and enjoyable snacking experience, appealing to different flavor preferences.</li></ul>'),
(7, 'White Dress', NULL, NULL, 2, 'Available', 2021038205, 15, '2023-11-09', 30.00, '../pic/Products/dress.jpg', '<ul><b>White Dress</b><br><br>\r\n<li>The white dress is crafted from soft and breathable cotton material, offering comfort and a classic, timeless look suitable for various occasions.</li><br>\r\n<li>Available in a range of sizes from XS to XXXL, this dress ensures a flattering fit for a diverse range of body types, accommodating individuals from petite to plus sizes.</li><br>\r\n<li>With its elegant simplicity and inclusive sizing options, this white cotton dress provides a versatile wardrobe staple suitable for different preferences and body shapes.</li></ul>'),
(8, 'Drinks', '2023-05-18', '2025-12-12', 22, 'Available', 2021990298, 1, '2023-11-09', 2.80, '../pic/Products/drinks.jpeg', '<ul><b>Drinks</b><br><br>\r\n<li>Comes in three types of brands with various of flavors.</li><br>\r\n<li>Coca-Cola is a classic carbonated soft drink recognized for its signature sweet and effervescent flavor, enjoyed worldwide.</li><br>\r\n<li>Fanta is a fruity and vibrant carbonated beverage known for its array of flavors, offering a refreshing and diverse taste experience.</li><br>\r\n<li>Sprite is a lemon-lime flavored carbonated drink cherished for its crisp and tangy taste, often recognized for its clear, caffeine-free formulation.</li><br>\r\n'),
(9, 'Emina Face Wash', '2023-07-20', '2025-05-24', 5, 'Available', 2022138219, 1, '2023-11-09', 20.00, '../pic/Products/emina.jpeg', '<ul><b>Emina Face Wash Bright Stuff</b><br><br>\r\n<li>The Emina Face Wash Bright Stuff is specifically formulated for acne-prone skin, aiming to brighten and clarify the complexion.</li><br>\r\n<li>Enriched with ingredients targeting acne concerns, this face wash helps to effectively cleanse and manage skin imperfections.</li><br>\r\n<li>With its focus on brightening and its suitability for acne-prone skin, the Emina Face Wash Bright Stuff offers a reliable skincare solution for various skin types.</li></ul>\r\n');

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

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusID` int(11) NOT NULL,
  `status_statement` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discountID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `sellerID` (`sellerID`),
  ADD KEY `discountID` (`discountID`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`sellerID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`statusID`) REFERENCES `status` (`statusID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `sellers` (`sellerID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`discountID`) REFERENCES `discounts` (`discountID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
