-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 09:49 AM
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
-- Database: `hm_hotels`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `room_id` int(11) NOT NULL,
  `guests` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `status` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `booking_type` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `name`, `email`, `contact`, `address`, `gender`, `room_id`, `guests`, `total_price`, `status`, `code`, `check_in`, `check_out`, `booking_type`, `paid_at`, `created_at`) VALUES
(85, 8, NULL, '', NULL, NULL, NULL, 49, 1, 24000, 'canceled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:21:30'),
(86, 8, NULL, '', NULL, NULL, NULL, 50, 1, 24000, 'canceled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:22:21'),
(87, 8, NULL, '', NULL, NULL, NULL, 51, 1, 24000, 'canceled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:24:36'),
(88, 8, NULL, '', NULL, NULL, NULL, 52, 1, 24000, 'canceled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:00:34'),
(89, 8, NULL, '', NULL, NULL, NULL, 53, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:25:28'),
(90, 8, NULL, '', NULL, NULL, NULL, 54, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:36:50'),
(91, 8, NULL, '', NULL, NULL, NULL, 55, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:37:03'),
(92, 8, NULL, '', NULL, NULL, NULL, 56, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:37:12'),
(93, 8, NULL, '', NULL, NULL, NULL, 57, 1, 24000, 'complete', 'CP70F8', '2024-12-13 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-13 11:32:29', '2024-12-13 03:32:29'),
(94, 8, NULL, '', NULL, NULL, NULL, 58, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:42:39'),
(95, 8, NULL, '', NULL, NULL, NULL, 59, 1, 24000, 'complete', 'JEILFW', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 11:54:11', '2024-12-10 03:54:11'),
(96, 8, NULL, '', NULL, NULL, NULL, 60, 1, 24000, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:44:00'),
(97, 8, NULL, '', NULL, NULL, NULL, 61, 1, 24000, 'complete', 'F9HQVA', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 11:53:08', '2024-12-10 03:53:08'),
(98, 8, NULL, '', NULL, NULL, NULL, 62, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(99, 8, NULL, '', NULL, NULL, NULL, 63, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(100, 8, NULL, '', NULL, NULL, NULL, 64, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(101, 8, NULL, '', NULL, NULL, NULL, 65, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(102, 8, NULL, '', NULL, NULL, NULL, 66, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(103, 8, NULL, '', NULL, NULL, NULL, 67, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(104, 8, NULL, '', NULL, NULL, NULL, 68, 1, 24000, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:38:34'),
(105, 8, NULL, '', NULL, NULL, NULL, 49, 1, 12000, 'complete', 'FJJV6X', '2024-12-31 00:00:00', '2024-11-01 00:00:00', NULL, '2024-12-10 12:36:33', '2024-12-10 04:36:33'),
(106, 8, NULL, '', NULL, NULL, NULL, 58, 1, 1200, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:49:20'),
(107, 8, NULL, '', NULL, NULL, NULL, 60, 1, 2400, 'complete', 'XMDNTT', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 11:52:37', '2024-12-10 03:52:37'),
(108, 8, NULL, '', NULL, NULL, NULL, 59, 1, 1200, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 03:54:25'),
(109, 8, NULL, '', NULL, NULL, NULL, 60, 1, 1200, 'complete', 'WTSBJ1', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 12:23:18', '2024-12-10 04:23:18'),
(110, 8, NULL, '', NULL, NULL, NULL, 61, 1, 1200, 'complete', 'ZJEIWX', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 12:23:34', '2024-12-10 04:23:34'),
(111, 8, NULL, '', NULL, NULL, NULL, 60, 1, 1200, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:23:52'),
(112, 8, NULL, '', NULL, NULL, NULL, 61, 1, 2400, 'pending', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:24:16'),
(113, 8, NULL, '', NULL, NULL, NULL, 53, 1, 6000, 'complete', '4DHFB0', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 12:36:00', '2024-12-10 04:36:00'),
(114, 8, NULL, '', NULL, NULL, NULL, 53, 1, 4800, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:38:14'),
(115, 8, NULL, '', NULL, NULL, NULL, 54, 1, 4800, 'cancelled', '', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-10 04:38:18'),
(116, 8, NULL, '', NULL, NULL, NULL, 55, 1, 4800, 'complete', 'IIMI5N', '2024-12-25 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-10 12:39:13', '2024-12-10 04:39:13'),
(117, 8, NULL, '', NULL, NULL, NULL, 56, 1, 4800, 'checked_in', 'UYNCDI', '2024-12-13 00:00:00', '2024-12-31 00:00:00', NULL, NULL, '2024-12-13 08:08:32'),
(118, 9, NULL, '', NULL, NULL, NULL, 53, 2, 400, 'approved', 'CN16Y1', '2024-12-28 00:00:00', '2024-12-30 00:00:00', NULL, NULL, '2024-12-11 09:31:32'),
(119, 0, 'justine', '', 'justine@gmail.com', NULL, NULL, 50, 0, 200, 'complete', 'PRBS5A', '2025-02-14 00:00:00', '2025-02-15 00:00:00', NULL, '2024-12-11 14:38:32', '2024-12-11 06:38:32'),
(120, 8, NULL, '', NULL, NULL, NULL, 49, 1, 200, 'checked_out', 'WVX916', '2024-12-09 00:00:00', '2025-01-02 00:00:00', NULL, NULL, '2024-12-13 06:44:47'),
(121, 8, NULL, '', NULL, NULL, NULL, 54, 1, 1200, 'complete', 'GCBHSS', '2024-12-11 00:00:00', '2024-12-31 00:00:00', NULL, '2024-12-13 11:47:39', '2024-12-13 03:47:39'),
(122, 8, NULL, '', NULL, NULL, NULL, 89, 2, 3000, 'pending', '', '2024-12-13 00:00:00', '2024-12-14 00:00:00', NULL, NULL, '2024-12-13 03:22:36'),
(123, 8, NULL, '', NULL, NULL, NULL, 90, 2, 3000, 'checked_in', 'LDNQO6', '2024-12-13 00:00:00', '2024-12-14 00:00:00', NULL, NULL, '2024-12-13 08:09:29'),
(124, 8, NULL, '', NULL, NULL, NULL, 91, 2, 3000, 'pending', '', '2024-12-13 00:00:00', '2024-12-14 00:00:00', NULL, NULL, '2024-12-13 03:22:36'),
(125, 11, NULL, '', NULL, NULL, NULL, 49, 2, 200, 'approved', 'X0WUDX', '2025-02-14 00:00:00', '2025-02-15 00:00:00', NULL, NULL, '2024-12-13 03:27:01'),
(126, NULL, 'sixto tumulak', '', '0923232', NULL, 'male', 69, 2, 2000, 'approved', 'B8DH74', '2024-12-14 14:52:53', '2024-12-12 00:00:00', 'reservation', NULL, '2024-12-13 06:52:57'),
(127, NULL, 'TEST ', '', '09123456789', NULL, 'female', 50, 3, 400, 'complete', 'I1X6UQ', '2024-12-13 14:52:34', '2025-01-04 00:00:00', 'walk_in', '2024-12-13 15:17:34', '2024-12-13 07:17:34'),
(128, NULL, 'TEST ', '', '09123456789', NULL, 'female', 51, 3, 400, 'pending', 'KY52ZL', '0000-00-00 00:00:00', '2025-01-04 00:00:00', 'walk_in', NULL, '2024-12-13 06:02:15'),
(129, NULL, 'TEST ', '', '09123456789', NULL, 'female', 52, 3, 400, 'cancelled', '', '0000-00-00 00:00:00', '2025-01-04 00:00:00', 'walk_in', NULL, '2024-12-13 07:10:05'),
(130, 8, NULL, '', NULL, NULL, NULL, 70, 3, 4000, 'cancelled', 'EKPJW0', '2024-12-06 00:00:00', '2024-12-08 00:00:00', 'book', NULL, '2024-12-13 07:09:39'),
(131, NULL, 'Reserve', '', '0923232', NULL, 'male', 53, 3, 200, 'pending', 'YQOND1', '0000-00-00 00:00:00', '2024-12-15 00:00:00', 'reserve', NULL, '2024-12-13 06:16:09'),
(132, NULL, 'DOUBLE DELUXE', '', '4334343', NULL, 'male', 69, 2, 6000, 'checked_out', 'HW965Q', '0000-00-00 00:00:00', '2024-12-18 00:00:00', 'walk_in', NULL, '2024-12-13 06:47:50'),
(133, NULL, 'mariz mante', '', '09123456789', 'buagsong', 'male', 70, 3, 2000, 'complete', 'OL097M', '2024-12-13 14:21:00', '2024-12-15 00:00:00', 'walk_in', '2024-12-13 15:11:05', '2024-12-13 07:11:05'),
(134, NULL, 'user wit email', 'email@email.com', '0923423423', 'user wit email', 'male', 49, 3, 600, 'approved', 'V8RDDE', '2025-01-10 15:50:00', '2025-01-14 00:00:00', 'walk_in', NULL, '2024-12-13 07:51:12'),
(135, NULL, 'user wit email', 'email@email.com', '0923423423', 'user wit email', 'male', 50, 3, 600, 'approved', 'UDRMMZ', '2025-01-10 15:50:00', '2025-01-14 00:00:00', 'walk_in', NULL, '2024-12-13 07:51:12'),
(136, NULL, 'tyler creator', 'tyler@gmail.com', '09423423432', 'buagsong', 'male', 71, 3, 4000, 'complete', 'R2ZN1N', '2024-12-13 15:52:00', '2024-12-16 00:00:00', 'reserve', '2024-12-13 15:52:52', '2024-12-13 07:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `booking_rooms`
--

CREATE TABLE `booking_rooms` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_submissions`
--

CREATE TABLE `contact_submissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_submissions`
--

INSERT INTO `contact_submissions` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'sixto', 'sixto@email.com', 'annyeong', '2024-12-13 08:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `emp_login`
--

CREATE TABLE `emp_login` (
  `empid` int(100) NOT NULL,
  `Emp_Email` varchar(50) NOT NULL,
  `Emp_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_login`
--

INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(1, 'Admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `description`, `photo`) VALUES
(1, 'Swimming POol', 'asdasld lakd, nadw', '169A2532-scaled-720x720.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `NoofRoom` int(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `noofdays` int(30) NOT NULL,
  `roomtotal` double(8,2) NOT NULL,
  `bedtotal` double(8,2) NOT NULL,
  `meal` varchar(30) NOT NULL,
  `mealtotal` double(8,2) NOT NULL,
  `finaltotal` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `Name`, `Email`, `RoomType`, `Bed`, `NoofRoom`, `cin`, `cout`, `noofdays`, `roomtotal`, `bedtotal`, `meal`, `mealtotal`, `finaltotal`) VALUES
(41, 'Tushar pankhaniya', 'pankhaniyatushar9@gmail.com', 'Single Room', 'Single', 1, '2022-11-09', '2022-11-10', 1, 1000.00, 10.00, 'Room only', 0.00, 1010.00);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `bedding` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `type`, `bedding`) VALUES
(4, 'Superior Room', 'Single'),
(6, 'Superior Room', 'Triple'),
(7, 'Superior Room', 'Quad'),
(8, 'Deluxe Room', 'Single'),
(9, 'Deluxe Room', 'Double'),
(10, 'Deluxe Room', 'Triple'),
(11, 'Guest House', 'Single'),
(12, 'Guest House', 'Double'),
(13, 'Guest House', 'Triple'),
(14, 'Guest House', 'Quad'),
(16, 'Superior Room', 'Double'),
(20, 'Single Room', 'Single'),
(22, 'Superior Room', 'Single'),
(23, 'Deluxe Room', 'Single'),
(24, 'Deluxe Room', 'Triple'),
(27, 'Guest House', 'Double'),
(30, 'Deluxe Room', 'Single');

-- --------------------------------------------------------

--
-- Table structure for table `roombook`
--

CREATE TABLE `roombook` (
  `id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Country` varchar(30) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `RoomType` varchar(30) NOT NULL,
  `Bed` varchar(30) NOT NULL,
  `Meal` varchar(30) NOT NULL,
  `NoofRoom` varchar(30) NOT NULL,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `nodays` int(50) NOT NULL,
  `stat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roombook`
--

INSERT INTO `roombook` (`id`, `Name`, `Email`, `Country`, `Phone`, `RoomType`, `Bed`, `Meal`, `NoofRoom`, `cin`, `cout`, `nodays`, `stat`) VALUES
(41, 'Tushar pankhaniya', 'pankhaniyatushar9@gmail.com', 'India', '9313346569', 'Single Room', 'Single', 'Room only', '1', '2022-11-09', '2022-11-10', 1, 'Confirm');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `images` text NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cleanliness_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `images`, `room_type`, `price`, `capacity`, `amenities`, `description`, `created_at`, `name`, `room_number`, `status`, `cleanliness_status`) VALUES
(49, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:47:30', 'Deluxe Room', '3001', 'vacant', 'clean'),
(50, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:47:22', 'Deluxe Room', '3002', 'vacant', 'clean'),
(51, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3003', 'vacant', 'clean'),
(52, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3004', 'vacant', 'clean'),
(53, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3005', 'vacant', 'clean'),
(54, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3006', 'vacant', 'clean'),
(55, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3007', 'vacant', 'clean'),
(56, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 08:08:32', 'Deluxe Room', '3008', 'vacant', 'occupied'),
(57, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3009', 'not available', 'clean'),
(58, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3010', 'vacant', 'clean'),
(59, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3011', 'vacant', 'clean'),
(60, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3012', 'vacant', 'clean'),
(61, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3013', 'vacant', 'clean'),
(62, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3014', 'vacant', 'clean'),
(63, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3015', 'vacant', 'clean'),
(64, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3016', 'vacant', 'clean'),
(65, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3017', 'vacant', 'clean'),
(66, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3018', 'vacant', 'clean'),
(67, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3019', 'vacant', 'clean'),
(68, '../uploads/1733796301_1733130918_couch.jpg,../uploads/1733796301_1733130918_cr.jpg,../uploads/1733796301_1733130918_kitchen.jpg,../uploads/1733796301_1733130918_room.jpg,../uploads/1733796301_1733130918_shower.jpg', 'Deluxe', 200, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolo', '2024-12-13 06:41:40', 'Deluxe Room', '3020', 'vacant', 'clean'),
(69, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:50:52', 'Superior', '6021', 'vacant', 'clean'),
(70, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:47:41', 'Superior', '6022', 'vacant', 'clean'),
(71, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 07:52:50', 'Superior', '6023', 'vacant', 'dirty'),
(72, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6024', 'vacant', 'clean'),
(73, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6025', 'vacant', 'clean'),
(74, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6026', 'vacant', 'clean'),
(75, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6027', 'vacant', 'clean'),
(76, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6028', 'vacant', 'clean'),
(77, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6029', 'vacant', 'clean'),
(78, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6030', 'vacant', 'clean'),
(79, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6031', 'vacant', 'clean'),
(80, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6032', 'vacant', 'clean'),
(81, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6033', 'vacant', 'clean'),
(82, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6034', 'vacant', 'clean'),
(83, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6035', 'vacant', 'clean'),
(84, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6036', 'vacant', 'clean'),
(85, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6037', 'vacant', 'clean');
INSERT INTO `rooms` (`id`, `images`, `room_type`, `price`, `capacity`, `amenities`, `description`, `created_at`, `name`, `room_number`, `status`, `cleanliness_status`) VALUES
(86, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6038', 'vacant', 'clean'),
(87, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6039', 'vacant', 'clean'),
(88, '../uploads/1734057252_78ded000-61ea-468c-8ca7-034e296fd7e0.jpg,../uploads/1734057252_1731c4e9-6fed-4f6e-9835-c632cd76da2d.jpg,../uploads/1734057252_2213eb9a-97d7-4579-af7b-61cf4bca671e.jpg,../uploads/1734057252_65626d1d-ec8c-4bcf-8e2f-0b562eea58b6.jpg,../uploads/1734057252_03801207-bdab-45dc-96a2-468feb1650df (1).jpg', 'Superior', 2000, 5, '🛏️ Sleeping Arrangements\r\nQueen-sized or King-sized bed with premium linens\r\nExtra pillows and blankets for added comfort\r\n🚿 Bathroom Amenities\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner, toothbrush set)\r\nHairdryer for your convenience\r\nClean towels and cozy bathrobes\r\n📺 Entertainment and Connectivity\r\nFlat-screen TV with cable or satellite channels\r\nFree high-speed Wi-Fi for seamless internet access\r\n📞 Telephone for local and international calls\r\n🌬️ Room Features\r\nAir conditioning with individual climate control\r\nWork desk with a chair for productivity\r\nFull-length mirror for dressing\r\n🛋️ Seating area with a lounge chair or sofa\r\nSpacious closet with hangers\r\nIn-room safe for valuables', 'The Superior Room offers a queen-sized or king-sized bed with premium linens, extra pillows, and blankets for ultimate comfort. It features a private bathroom equipped with a hot and cold shower, complimentary toiletries, a hairdryer, clean towels, and bathrobes. Guests can enjoy entertainment through a flat-screen TV with cable or satellite channels and stay connected with free high-speed Wi-Fi. The room includes air conditioning with individual climate control, a work desk with a chair, a full-length mirror, and a spacious closet with hangers. ', '2024-12-13 06:41:40', 'Superior', '6040', 'vacant', 'clean'),
(89, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9041', 'vacant', 'clean'),
(90, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 08:09:29', 'STANDARD ROOM', '9042', 'vacant', 'occupied'),
(91, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9043', 'vacant', 'clean'),
(92, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9044', 'vacant', 'clean'),
(93, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9045', 'vacant', 'clean'),
(94, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9046', 'vacant', 'clean'),
(95, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9047', 'vacant', 'clean'),
(96, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9048', 'vacant', 'clean'),
(97, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9049', 'vacant', 'clean'),
(98, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9050', 'vacant', 'clean'),
(99, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9051', 'vacant', 'clean'),
(100, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9052', 'vacant', 'clean'),
(101, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9053', 'vacant', 'clean'),
(102, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9054', 'vacant', 'clean'),
(103, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9055', 'vacant', 'clean'),
(104, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9056', 'vacant', 'clean'),
(105, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9057', 'vacant', 'clean'),
(106, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9058', 'vacant', 'clean'),
(107, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9059', 'vacant', 'clean'),
(108, '../uploads/1734057530_1dcbb1e5-3988-45ac-9a21-1dd7fe695eae.jpg,../uploads/1734057530_8ec862ee-20e3-4260-8d59-1bf44ea743d0.jpg,../uploads/1734057530_976bbdca-476d-45bc-8e9a-1f8db228f765.jpg,../uploads/1734057530_03801207-bdab-45dc-96a2-468feb1650df.jpg,../uploads/1734057530_e0885fce-68f5-4741-b782-80541a60fe0a.jpg', 'Standard', 1000, 2, '🛏️ Sleeping Arrangements\r\n\r\nComfortable double or twin bed with fresh linens\r\nExtra pillows and blankets\r\n🚿 Bathroom\r\n\r\nPrivate bathroom with hot and cold shower\r\nComplimentary toiletries (soap, shampoo, conditioner)\r\nClean towels\r\n📺 Entertainment and Connectivity\r\n\r\nFlat-screen TV with basic cable or local channels\r\nFree Wi-Fi access\r\n🌬️ Room Features\r\n\r\nAir conditioning or ceiling fan\r\nBasic wardrobe or closet with hangers\r\nSmall work desk or table with a chair', 'The Standard Room is designed to provide a comfortable and practical stay for guests. It features a cozy double or twin bed with fresh linens, ensuring a restful sleep. The private bathroom comes equipped with a hot and cold shower, complimentary toiletries, and clean towels for your convenience. Stay entertained with a flat-screen TV offering basic cable or local channels, and enjoy free Wi-Fi access for seamless connectivity.\r\n\r\nThe room includes essential features like air conditioning or a ceiling fan, a basic wardrobe with hangers, and a small work desk or table with a chair. Refreshments such as complimentary bottled water and coffee and tea-making facilities are provided for your convenience. ', '2024-12-13 06:41:40', 'STANDARD ROOM', '9060', 'vacant', 'clean');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`UserID`, `Username`, `Email`, `Password`) VALUES
(1, 'Tushar Pankhaniya', 'tusharpankhaniya2202@gmail.com', '123'),
(7, 'joren', 'joren@email.com', 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `work` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `work`) VALUES
(1, 'Tushar pankhaniya', 'Manager'),
(3, 'rohit patel', 'Cook'),
(4, 'Dipak', 'Cook'),
(5, 'tirth', 'Helper'),
(6, 'mohan', 'Helper'),
(7, 'shyam', 'cleaner'),
(8, 'rohan', 'weighter'),
(9, 'hiren', 'weighter'),
(10, 'nikunj', 'weighter'),
(11, 'rekha', 'Cook');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `age`, `birthdate`, `address`, `phone_number`, `password`, `gender`, `role`) VALUES
(3, 'john@doe.com', 'john', 'doe', NULL, NULL, NULL, NULL, '$2y$10$mZR48NqcxsCBgx7GrlfMzOhvJJxNlpoY8KYlYNr/4S19uwaqXsxK2', NULL, 'user'),
(4, 'admin@email.com', 'admin', 'admin', NULL, NULL, NULL, NULL, '$2y$10$yrIIXmFjNc4azDyeNIuZkemo2s/OtX3yCrwcO.9Tv0TGJvBw5YJkG', NULL, 'admin'),
(5, 'front@desk.com', 'Chaewon', 'last_name', NULL, NULL, NULL, NULL, '$2y$10$hJGGKf5tkOFe9xaDwEj/B.I4bgPbHEy7pjKtvHgK7Lc2/J0gpoTKy', NULL, 'front_desk'),
(6, 'house@keeping.com', 'Jane', 'last_name', NULL, NULL, NULL, NULL, '$2y$10$t2f4eynxlm.gv.MMG3ppaOv7wplH/yhk3m7nZcWYL7WGO1T5jhuAW', NULL, 'house_keeping'),
(7, 'liltecca@email.com', 'Lil', 'Tecca', 23, '2024-12-25', 'liltecca', '09123456798', '$2y$10$e9Pp3Ji86HsiPQkoRMioLuRyrua8ZZxKDAUL/b41/6kFBmkQHy8Oa', 'female', 'user'),
(8, 'thirdy@gmail.com', 'thirdy', 'tumulak', 23, '2001-11-21', 'gun ob', '09078818126', '$2y$10$K9y.J7KEo/TawKw8d4AF2uM6exe4FEZ0wkRLSdyt8JufJz9P5nZiW', 'male', 'user'),
(9, 'mae@gmail.com', 'mae', 'canz', 20, '2000-02-10', 'humayhumay', '09992234682', '$2y$10$3MjYYw8McibVYo2sEZh.Y.FXFZEZrt53jJ4Ybm42EfHbyKZSHJMxW', 'female', 'user'),
(10, 'yiell@gmail.com', 'yiell', 'andales', NULL, '1999-02-12', 'bangbang', '09876543212', '$2y$10$UXlD8/4jyj58vsK9D1kpmOqHVgGWrkqG3muRNlS4bx91DTV8ttWru', 'male', 'user'),
(11, 'james@gmail.com', 'james', 'yagonia', 21, '2024-11-21', 'catarman', '1251254200', '$2y$10$s4v3JVZvbx3q2ocZBvmZwO9NV3/fw51HsYI5.R2bDXiOt.BOKHhf.', 'male', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_rooms`
--
ALTER TABLE `booking_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_login`
--
ALTER TABLE `emp_login`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `booking_rooms`
--
ALTER TABLE `booking_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_submissions`
--
ALTER TABLE `contact_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `emp_login`
--
ALTER TABLE `emp_login`
  MODIFY `empid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
