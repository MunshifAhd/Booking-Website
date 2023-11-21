-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2022 at 11:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wings`
--
CREATE DATABASE IF NOT EXISTS `wings` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wings`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `password`) VALUES
('admin123', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` varchar(50) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `book_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `no_of_occupants` int(11) NOT NULL,
  `booking_status` varchar(50) NOT NULL,
  `customer_id` varchar(50) NOT NULL,
  `villa_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `check_in`, `check_out`, `book_date`, `no_of_occupants`, `booking_status`, `customer_id`, `villa_id`) VALUES
('bk-000001', '2022-08-05', '2022-08-09', '2022-08-30 03:05:51', 2, 'BOOKED', 'cus-000001', NULL),
('bk-000002', '2022-08-03', '2022-08-04', '2022-08-30 03:08:27', 8, 'BOOKED', 'cus-000002', 'villa-02'),
('bk-000003', '2022-08-06', '2022-08-07', '2022-08-30 03:11:33', 2, 'COMPLETED', 'cus-000003', NULL),
('bk-000004', '2022-08-06', '2022-08-13', '2022-08-30 03:55:33', 1, 'CHECKED_IN', 'cus-000004', NULL),
('bk-000005', '2022-09-22', '2022-09-23', '2022-08-30 08:01:17', 12, 'BOOKED', 'cus-000005', NULL),
('bk-000006', '2022-09-03', '2022-09-04', '2022-08-30 08:28:47', 2, 'BOOKED', 'cus-000005', 'villa-02'),
('bk-000007', '2022-09-09', '2022-09-10', '2022-08-30 08:29:23', 3, 'BOOKED', 'cus-000005', 'villa-02');

-- --------------------------------------------------------

--
-- Table structure for table `booking_room`
--

CREATE TABLE `booking_room` (
  `booking_id` varchar(50) NOT NULL,
  `room_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_room`
--

INSERT INTO `booking_room` (`booking_id`, `room_id`) VALUES
('bk-000001', 'maw-room-02'),
('bk-000003', 'ram-room-01'),
('bk-000004', 'ram-room-02'),
('bk-000005', 'maw-room-02');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` varchar(50) NOT NULL,
  `branch_name` varchar(50) NOT NULL,
  `branch_description` varchar(255) NOT NULL,
  `branch_phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_description`, `branch_phone_number`) VALUES
('br-01', 'Mawanella', 'This is the branch located in Mawanalla on E-67, Colombo-Kandy Road', '0721231233'),
('br-02', 'Rambukkana', 'This is the branch located in Rambukkana on E-57, Rambukkana-Kurunegala Road', '0771231231'),
('br-03', 'Galle', 'This is the branch located in Galle on A-106, Galle-Matara Road near beach', '0721231234'),
('br-04', 'Kandy', 'This is the branch located in Kandy on B-67, Colombo-Kandy Road', '0721222312');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` varchar(50) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_nic` varchar(50) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_phone_number` varchar(15) NOT NULL,
  `customer_type` varchar(50) NOT NULL,
  `customer_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_email`, `customer_nic`, `customer_address`, `customer_phone_number`, `customer_type`, `customer_password`) VALUES
('cus-000001', 'Janith', 'Janith@gmail.com', '21312312323', 'Kegalle', '2222222', 'SINGLE_CUSTOMER', ''),
('cus-000002', 'Indika', 'Indika@gmail.com', '21312312111', 'Kegalle', '2131231221', 'SINGLE_CUSTOMER', ''),
('cus-000003', 'Sadeek', 'sadeek@mailinator.com', '543532235', 'Kegalle', '547457457', 'SINGLE_CUSTOMER', ''),
('cus-000004', 'Hayden Houston', 'fyvamosef@mailinator.com', 'Debitis non inventor', 'In excepteur natus v', 'Dolorem cum nem', 'SINGLE_CUSTOMER', ''),
('cus-000005', 'Fasal Mohammadh', 'Fasal@gmail.com', '23010010120', 'Rambukkana', '0781233210', 'SINGLE_CUSTOMER', '123123'),
('cus-000006', 'Dale Giles', 'vecyg@mailinator.com', '123312132131', 'Aut distinctio Est', '1321242421', 'SINGLE_CUSTOMER', 'Pa$$w0rd!');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `addition` double NOT NULL,
  `payment` double NOT NULL,
  `creditcard_number` varchar(50) NOT NULL,
  `expiry` varchar(10) NOT NULL,
  `cvn` varchar(5) NOT NULL,
  `booking_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `type`, `date`, `addition`, `payment`, `creditcard_number`, `expiry`, `cvn`, `booking_id`) VALUES
('p-000001', 'CARD', '0000-00-00', 0, 4000, '232323', '22/2222', '2332', 'bk-000001'),
('p-000002', 'CARD', '0000-00-00', 0, 16000, '212121', '22/2222', '222', 'bk-000002'),
('p-000003', 'CARD', '2022-08-30', 90, 3000, '22222222', '22/2222', '222', 'bk-000003'),
('p-000004', 'CARD', '0000-00-00', 0, 4000, '2323', '23/3223', '2323', 'bk-000004'),
('p-000005', 'CARD', '0000-00-00', 0, 4000, '12', '12', '21', 'bk-000005'),
('p-000006', '', '0000-00-00', 0, 16000, '', '', '', 'bk-000006'),
('p-000007', 'CARD', '0000-00-00', 0, 16000, '21', '123', '312', 'bk-000007');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `no_of_beds` int(11) NOT NULL,
  `occupancy` int(11) NOT NULL,
  `price` double NOT NULL,
  `img` varchar(255) NOT NULL,
  `branch_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `title`, `description`, `no_of_beds`, `occupancy`, `price`, `img`, `branch_id`) VALUES
('maw-room-01', 'Non-AC Room', 'Non AC room with one double bed capable for 2 people', 1, 2, 3000, 'Assets/Uploads/3451661821115non-ac.jpg', 'br-01'),
('maw-room-02', 'AC Room', 'AC room with one double bed capable for 2 people', 1, 2, 4000, 'Assets/Uploads/3691661821546non-ac.jpg', 'br-01'),
('ram-room-01', 'Non-AC Room', 'Non AC room with one double bed capable for 2 people', 1, 2, 3000, 'Assets/Uploads/5551661821579non-ac.jpg', 'br-02'),
('ram-room-02', 'AC Room', 'AC room with one double bed capable for 2 people', 1, 2, 4000, 'Assets/Uploads/8271661821629non-ac.jpg', 'br-02');

-- --------------------------------------------------------

--
-- Table structure for table `villa`
--

CREATE TABLE `villa` (
  `villa_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `no_of_beds` int(11) NOT NULL,
  `no_of_rooms` int(11) NOT NULL,
  `occupancy` int(11) NOT NULL,
  `price` double NOT NULL,
  `img` varchar(255) NOT NULL,
  `branch_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `villa`
--

INSERT INTO `villa` (`villa_id`, `title`, `description`, `no_of_beds`, `no_of_rooms`, `occupancy`, `price`, `img`, `branch_id`) VALUES
('villa-02', 'Villa Galle Beach', 'Villa new galle beach has facility to stay upto 8 person has 4 rooms each with an double bed and available with 2 bathrooms and 1 kitchen', 4, 4, 8, 16000, 'Assets/Uploads/9391661823048gal-beach-villa.jpg', 'br-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `villa_id` (`villa_id`);

--
-- Indexes for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD PRIMARY KEY (`booking_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`) USING BTREE,
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `villa`
--
ALTER TABLE `villa`
  ADD PRIMARY KEY (`villa_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`villa_id`) REFERENCES `villa` (`villa_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_room`
--
ALTER TABLE `booking_room`
  ADD CONSTRAINT `booking_room_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_room_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `villa`
--
ALTER TABLE `villa`
  ADD CONSTRAINT `villa_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
