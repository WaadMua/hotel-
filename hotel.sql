-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 03, 2025 at 03:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `active`) VALUES
(1, 'Rami', 'rami@admin.com', '123456789', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `RoomNumber` int(15) NOT NULL,
  `id` int(10) NOT NULL,
  `customerID` int(15) NOT NULL,
  `CheckInDate` date NOT NULL,
  `CheckOutDate` date NOT NULL,
  `NumberOfGuests` int(15) NOT NULL,
  `TotalPrice` varchar(15) NOT NULL,
  `BookingStatus` varchar(15) NOT NULL,
  `CreatedDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`RoomNumber`, `id`, `customerID`, `CheckInDate`, `CheckOutDate`, `NumberOfGuests`, `TotalPrice`, `BookingStatus`, `CreatedDate`) VALUES
(1, 1, 4, '2025-01-01', '2025-01-06', 3, '1000', 'Confirm', '2024-08-18 12:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(10) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_password` int(15) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_address` varchar(50) NOT NULL,
  `customer_phone` int(15) NOT NULL,
  `customer_nationality` varchar(15) NOT NULL,
  `identity_type` text NOT NULL,
  `proof_of_identity` varchar(15) NOT NULL,
  `customer_job` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `customer_password`, `customer_email`, `customer_address`, `customer_phone`, `customer_nationality`, `identity_type`, `proof_of_identity`, `customer_job`) VALUES
(3, 'ahmed', 123456789, 'ahmed@mail.com', 'ahmed', 12312312, 'sudan', 'passport', '12378132', 'jkwqkjeq'),
(4, 'abdelrhman', 123456789, 'moony@mail.com', 'om', 909090909, 'sudan', 'passport', 'P21318412', 'developer'),
(5, 'yassin', 12345678, 'ahmed_yass@gmail.com', 'om', 9128712, 'Sudanes', 'Passport', 'P1238712', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `customer pay`
--

CREATE TABLE `customer pay` (
  `customer ID` int(10) NOT NULL,
  `pay` varchar(15) NOT NULL,
  `Account number` int(15) NOT NULL,
  `Currency type` varchar(15) NOT NULL,
  `Amount` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(10) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `address` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`id`, `Name`, `address`) VALUES
(1, 'Westen hotel', 'kassala city'),
(2, 'new hotel', 'portSudan hotel');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `des` text NOT NULL,
  `price` text NOT NULL,
  `rate` int(11) NOT NULL,
  `image` text NOT NULL,
  `hotel_ID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `title`, `des`, `price`, `rate`, `image`, `hotel_ID`) VALUES
(1, 'single room', 'A cozy single room perfect for solo travelers, equipped with modern amenities.', '100.00', 5, 'Image/r20.jpg.jpg', 1),
(2, 'large single room', 'A spacious single room offering extra comfort and convenience.', '170.00', 5, 'Image/r18.jpg.jpg', 1),
(3, 'Double room', 'Ideal for couples or small families, featuring a comfortable double bed.', '200.00', 5, 'Image/r17.jpg.jpg', 1),
(4, 'single room', 'A premium single room with stunning views and top-tier facilities.', '230.00', 5, 'Image/r10.jpg.jpg', 2),
(5, 'single room', 'An elegant single room designed for a relaxing stay with all essentials.', '220.00', 5, 'Image/r15.jpg.jpg', 2),
(6, 'single room', 'A charming single room offering great value and a comfortable stay.', '200.00', 5, 'Image/r11.jpg.jpg', 1),
(7, 'single room', 'A budget-friendly single room with all the basic necessities.', '150.00', 5, 'Image/r7.jpg.jpg', 2),
(8, 'Double room', 'A luxurious double room with ample space and modern interiors.', '250.00', 5, 'Image/r9.jpg.jpg', 2),
(9, 'single room', 'A standard single room perfect for short stays and quick visits.', '100.00', 5, 'Image/r1.jpg.jpg', 2),
(10, 'Double room', 'A stylish double room equipped with premium facilities for a luxurious stay.', '230.00', 5, 'Image/r4.jpg.jpg', 2),
(11, 'Double room', 'A deluxe double room with contemporary design and excellent amenities.', '230.00', 5, 'Image/r13.jpg.jpg', 2),
(12, 'Double room', 'A beautifully furnished double room ideal for a comfortable and enjoyable stay.', '230.00', 5, 'Image/r19.jpg.jpg', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer pay`
--
ALTER TABLE `customer pay`
  ADD PRIMARY KEY (`customer ID`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_ID` (`hotel_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `hotel_key` FOREIGN KEY (`hotel_ID`) REFERENCES `hotel` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
