-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 03:40 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gardenvillas_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `notification_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `timestamp`, `notification_sent`) VALUES
(1, 'Payment of Monthly Dues', 'Kindly check your inbox to see if your payment is up to date.', '2023-06-28 14:26:01', 0),
(2, 'Tank Cleaning', 'We would like to inform you that we will have a tank cleaning at June 25 2023, therefore there will be no water from 10:00 AM to 2:00 PM. ', '2023-06-28 14:26:01', 0),
(3, 'General Assembly', 'General Assembly for Homeowners', '2023-06-28 14:26:01', 0),
(7, 'General Assembly', 'Please come and join to our general assembly.', '2023-08-01 08:14:34', 0),
(8, 'Tank Cleaning', 'Kindly go to the covered court for the meeting with the Balibago waters.', '2023-08-12 06:00:39', 0);

-- --------------------------------------------------------

--
-- Table structure for table `approved_users`
--

CREATE TABLE `approved_users` (
  `resident_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `house_ownership_type` varchar(255) NOT NULL,
  `block` int(3) NOT NULL,
  `lot` int(3) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `verification_status` enum('Pending','Verified') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `approved_users`
--

INSERT INTO `approved_users` (`resident_id`, `name`, `house_ownership_type`, `block`, `lot`, `street`, `email`, `password`, `verification_code`, `profile_image`, `status`, `verification_status`) VALUES
(7, 'Carl Leonard Bantatua', 'owner', 14, 12, 'ECLIPSE', 'lbantatua42@gmail.com', '$2y$10$GXZnyvZfTbPpIL2amw0Tiunvc6B0tiBKE7xRWPFTwCdu026OTnMYa', '548474', NULL, 'Approved', 'Pending'),
(11, 'Robbie Boco', 'owner', 10, 4, 'STARBURST', 'robbieboco@gmail.com', '$2y$10$LOnFvNT5TbC6kruPsLVwZOy5OiU/nfHYkTIvfhoU2iW80PkF3.v3S', '678100', NULL, 'Approved', 'Pending'),
(15, 'KD Lebron', 'owner', 2, 42, 'ECLIPSE', 'leonardcarl27@gmail.com', '$2y$10$63nc5Ji5QsvCF87rMe2AcOAH.01oyTxgaDNA6.T0eCzr9epRKHLYC', '757004', NULL, 'Approved', 'Pending'),
(16, 'Janniyah Myren Glorioso', 'owner', 1, 4, 'ASTEROID', 'jessicaglorioso18@gmail.com', '$2y$10$QTb7Tb8V.K9lStjqZhuJxe56Vl5rvKxwkm9dA7yLRZrk3FcNXg2au', '617056', NULL, 'Approved', 'Pending'),
(18, 'Carl Bantatua', 'owner', 2, 2, 'CONSTELLATION', 'carlleonardbantatua@gmail.com', '$2y$10$UGaD/ISSw3ZIkAArC5s38eCx/yLfGnoVNbiSQ9iFffmsM4HASSiRO', '325705', NULL, 'Approved', 'Pending'),
(19, 'Jessica', 'owner', 1, 4, 'ANDROMEDA', 'jessicamyrdithglorioso@gmail.com', '$2y$10$X3FxKiOy3Ws5h0vjEJuQG.K8eyXyQDSDftmytVS9WT.gbWsN1Zte.', '411777', NULL, 'Approved', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `Venue` varchar(13) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','disapproved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `resident_id`, `Venue`, `start_date`, `end_date`, `start_time`, `end_time`, `title`, `description`, `status`) VALUES
(72, 11, 'Covered Court', '2023-08-01', '2023-08-01', '12:15 AM', '01:15 AM', 'scas', 'car', 'approved'),
(73, 11, 'Covered Court', '2023-08-01', '2023-08-03', '01:18 AM', '01:24 AM', 'sad', 'sad', 'approved'),
(74, 15, 'Covered Court', '2023-08-01', '2023-08-01', '01:27 AM', '02:32 AM', 's', 'das', 'approved'),
(75, 15, 'Covered Court', '2023-08-01', '2023-08-01', '02:33 AM', '03:33 AM', 'dsaddas', 'sad', 'approved'),
(76, 7, 'Covered Court', '2023-08-03', '2023-08-03', '01:45 AM', '07:50 AM', 'sadasdas', 'dasdasdasd', 'approved'),
(77, 18, 'Covered Court', '2023-08-01', '2023-08-01', '04:00 PM', '05:00 PM', 'Basketball', 'Liga', 'pending'),
(78, 11, 'Covered Court', '2023-08-12', '2023-08-12', '04:00 PM', '07:00 PM', 'Liga', 'Basketball', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `content`) VALUES
(1, 'General Assembly', 'We will be having a General Assembly other information in the incoming will be announce in the following weeks.');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pending_cashpayment`
--

CREATE TABLE `pending_cashpayment` (
  `id` int(11) NOT NULL,
  `resident_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_term` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pending_cashpayment`
--

INSERT INTO `pending_cashpayment` (`id`, `resident_name`, `amount`, `payment_term`, `payment_date`, `payment_time`) VALUES
(1, 'carl', '300.00', 'quarterly', '2023-06-19', '18:50:16'),
(2, 'carl', '100.00', 'monthly', '2023-06-19', '19:07:48'),
(3, 'carl', '100.00', 'monthly', '2023-06-19', '19:11:30'),
(4, 'carl', '100.00', 'monthly', '2023-06-19', '19:14:02'),
(5, 'carl', '300.00', 'quarterly', '2023-06-19', '19:14:23'),
(6, 'carl', '100.00', 'monthly', '2023-06-19', '19:23:39'),
(7, 'carl', '100.00', 'monthly', '2023-06-22', '23:10:02'),
(8, 'carl', '100.00', 'monthly', '2023-06-22', '23:28:46'),
(9, 'carl', '100.00', 'monthly', '2023-06-22', '23:41:03'),
(10, 'carl', '300.00', 'quarterly', '2023-06-22', '23:42:02'),
(11, 'carl', '100.00', 'monthly', '2023-06-22', '23:45:42'),
(12, 'carl', '100.00', 'monthly', '2023-06-22', '23:47:11'),
(13, 'Abigail', '100.00', 'monthly', '2023-06-23', '08:42:23'),
(14, 'Carl Leonard Bantatua', '100.00', 'monthly', '2023-06-30', '22:48:38'),
(15, 'Carl Leonard Bantatua', '300.00', 'quarterly', '2023-07-01', '00:18:08'),
(16, 'Carl Leonard Bantatua', '100.00', 'monthly', '2023-07-01', '00:24:45'),
(17, 'Carl Leonard Bantatua', '100.00', 'monthly', '2023-07-01', '00:40:48'),
(18, 'Carl Leonard Bantatua', '100.00', 'monthly', '2023-07-01', '00:53:15'),
(19, 'Carl Leonard Bantatua', '100.00', 'monthly', '2023-07-01', '00:53:21'),
(20, 'Carl Leonard Bantatua', '300.00', 'quarterly', '2023-07-01', '00:54:12'),
(21, 'Carl Leonard Bantatua', '1200.00', 'yearly', '2023-07-01', '16:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `pending_gcashpayment`
--

CREATE TABLE `pending_gcashpayment` (
  `payment_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_term` varchar(50) NOT NULL,
  `payment_coverage` date NOT NULL,
  `payment_image` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_end_date` date NOT NULL,
  `payment_time` time NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pending_gcashpayment`
--

INSERT INTO `pending_gcashpayment` (`payment_id`, `resident_id`, `amount`, `payment_term`, `payment_coverage`, `payment_image`, `payment_date`, `payment_end_date`, `payment_time`, `status`) VALUES
(2, 11, '100.00', 'monthly', '0000-00-00', '64c7c4362c1b4_1690813494.png', '2023-07-31', '2023-02-01', '22:24:54', 'pending'),
(3, 11, '100.00', 'monthly', '0000-00-00', '64c7c5ccf2245_1690813900.png', '2023-07-31', '2023-03-01', '22:31:40', 'pending'),
(4, 11, '300.00', 'quarterly', '0000-00-00', '64c7cb962106c_1690815382.png', '2023-07-31', '2023-06-01', '22:56:22', 'pending'),
(5, 11, '100.00', 'monthly', '0000-00-00', '64c7d09e420d4_1690816670.jpg', '2023-07-31', '2023-07-01', '23:17:50', 'pending'),
(9, 15, '100.00', 'monthly', '0000-00-00', '64c7ee2aca9e5_1690824234.pdf', '2023-08-01', '2023-02-01', '01:23:54', 'pending'),
(10, 15, '100.00', 'monthly', '0000-00-00', '64c7eea67ead7_1690824358.pdf', '2023-08-01', '2023-03-01', '01:25:58', 'pending'),
(11, 7, '100.00', 'monthly', '0000-00-00', '64c7f3099183b_1690825481.png', '2023-08-01', '2023-02-01', '01:44:41', 'pending'),
(12, 16, '100.00', 'monthly', '0000-00-00', '64c85f3400f36_1690853172.jpg', '2023-08-01', '2023-02-01', '09:26:12', 'pending'),
(13, 11, '100.00', 'monthly', '0000-00-00', '64c867d773298_1690855383.png', '2023-08-01', '2023-08-01', '10:03:03', 'pending'),
(14, 11, '100.00', 'monthly', '0000-00-00', '64c88273446b8_1690862195.png', '2023-08-01', '2023-09-01', '11:56:35', 'pending'),
(15, 11, '100.00', 'monthly', '0000-00-00', '64c8830aa84e2_1690862346.png', '2023-08-01', '2023-10-01', '11:59:06', 'pending'),
(16, 18, '100.00', 'monthly', '0000-00-00', '64c8be3f5e8fe_1690877503.png', '2023-08-01', '2023-02-01', '16:11:43', 'pending'),
(17, 11, '300.00', 'quarterly', '0000-00-00', '64d71eba29796_1691819706.png', '2023-08-12', '2024-01-01', '13:55:06', 'pending'),
(18, 11, '100.00', 'monthly', '0000-00-00', '64d71ed6c3747_1691819734.png', '2023-08-12', '2024-02-01', '13:55:34', 'pending'),
(19, 11, '100.00', 'monthly', '0000-00-00', '64da273966a01_1692018489.jpg', '2023-08-14', '2024-03-01', '21:08:09', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `block` varchar(255) DEFAULT NULL,
  `lot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rejected_users`
--

CREATE TABLE `rejected_users` (
  `resident_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `house_ownership_type` varchar(255) NOT NULL,
  `block` varchar(255) NOT NULL,
  `lot` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) NOT NULL,
  `status` varchar(12) NOT NULL,
  `verification_status` enum('Pending','Verified') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rejected_users`
--

INSERT INTO `rejected_users` (`resident_id`, `name`, `house_ownership_type`, `block`, `lot`, `street`, `email`, `password`, `profile_image`, `verification_code`, `status`, `verification_status`) VALUES
(10, 'Abigail Reyes Anore', 'owner', '14', '12', NULL, 'leonardcarl27@gmail.com', '$2y$10$ZjPjMbIGeTt9OeDrbuRjF.J6VwGZpMiTF9g.DtfkqVPqNXPyLzTU6', NULL, '', 'Rejected', 'Pending'),
(14, 'Roronoa Zoro', 'owner', '31', '1', 'ATMOSPHERE', 'leonarcarl27@gmail.com', '$2y$10$TjkXWkDbX1j1ElofedubyeVpqgIinKJy/XwkzBnPeY9zrIcl0qiou', NULL, '', 'Rejected', 'Pending'),
(17, 'Joesary Nantes', 'owner', '14', '23', 'CADILLAC', 'Nantesjoesary@gmail.com', '$2y$10$/rnlWIR.BMzO/PLq0lO1C.sl5ehRBT7P8A17UD/gg6UTdisIX.bU2', NULL, '', 'Rejected', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phase` varchar(255) NOT NULL,
  `block` varchar(10) NOT NULL,
  `lot` varchar(10) NOT NULL,
  `street` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) NOT NULL,
  `contactnumber` varchar(20) NOT NULL,
  `maritalstatus` varchar(20) NOT NULL,
  `citizenship` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`id`, `lastname`, `firstname`, `middlename`, `gender`, `phase`, `block`, `lot`, `street`, `birthdate`, `age`, `contactnumber`, `maritalstatus`, `citizenship`) VALUES
(3, 'Reyes', 'Oliver', 'Alexander', 'Male', '5', '33', '11', 'Orion Road', '1994-06-05', 27, '+639444555666', 'Single', 'Filipino'),
(4, 'Perez', 'Emily', 'Ava', 'Female', '5', '34', '28', 'Centaurus Avenue', '1989-12-20', 32, '+639999111222', 'Married', 'Filipino'),
(5, 'Sanchez', 'William', 'Jacob', 'Male', '5', '35', '15', 'Andromeda Street', '1991-10-15', 30, '+639888999000', 'Divorced', 'Filipino'),
(6, 'Gomez', 'Ava', 'Mia', 'Female', '5', '36', '27', 'Pegasus Lane', '1995-03-30', 26, '+639777888999', 'Single', 'Filipino'),
(7, 'Torres', 'Alexander', 'Benjamin', 'Male', '5', '37', '8', 'Orion Road', '1988-09-10', 33, '+639555666777', 'Married', 'Filipino'),
(8, 'Flores', 'Mia', 'Sophia', 'Female', '5', '38', '21', 'Centaurus Avenue', '1993-05-25', 28, '+639333444555', 'Widowed', 'Filipino'),
(9, 'Rivera', 'Elijah', 'Daniel', 'Male', '5', '39', '16', 'Pegasus Lane', '1990-12-30', 31, '+639666777888', 'Single', 'Filipino'),
(10, 'Gutierrez', 'Sophia', 'Emily', 'Female', '5', '40', '23', 'Andromeda Street', '1996-08-15', 25, '+639444555666', 'Married', 'Filipino'),
(11, 'Ramos', 'Michael', 'David', 'Male', '5', '41', '10', 'Orion Road', '1992-02-20', 29, '+639777888999', 'Single', 'Filipino'),
(12, 'Gonzales', 'Charlotte', 'Emma', 'Female', '5', '42', '26', 'Centaurus Avenue', '1986-07-05', 35, '+639999111222', 'Divorced', 'Filipino'),
(13, 'Santos', 'Ethan', 'William', 'Male', '5', '43', '7', 'Pegasus Lane', '1993-11-20', 28, '+639888999000', 'Married', 'Filipino'),
(14, 'Torres', 'Mia', 'Isabella', 'Female', '5', '44', '19', 'Andromeda Street', '1989-01-15', 32, '+639555666777', 'Single', 'Filipino'),
(15, 'Castillo', 'Benjamin', 'Alexander', 'Male', '5', '45', '24', 'Orion Road', '1995-06-30', 26, '+639777888999', 'Married', 'Filipino'),
(16, 'Chavez', 'Ava', 'Sophia', 'Female', '5', '46', '9', 'Centaurus Avenue', '1991-09-10', 30, '+639333444555', 'Single', 'Filipino'),
(17, 'Gomez', 'Daniel', 'Oliver', 'Male', '5', '47', '22', 'Pegasus Lane', '1994-04-25', 27, '+639666777888', 'Married', 'Filipino'),
(18, 'Fernandez', 'Emily', 'Mia', 'Female', '5', '48', '17', 'Andromeda Street', '1990-10-30', 31, '+639444555666', 'Single', 'Filipino'),
(19, 'Vargas', 'Alexander', 'William', 'Male', '5', '49', '6', 'Orion Road', '1993-06-15', 28, '+639777888999', 'Divorced', 'Filipino'),
(20, 'Perez', 'Sofia', 'Emma', 'Female', '5', '50', '25', 'Centaurus Avenue', '1995-01-20', 26, '+639999111222', 'Married', 'Filipino'),
(21, 'Hernandez', 'Jacob', 'Elijah', 'Male', '5', '1', '2', 'Pegasus Lane', '1992-07-05', 29, '+639888999000', 'Single', 'Filipino'),
(22, 'Ramirez', 'Mia', 'Charlotte', 'Female', '5', '2', '14', 'Andromeda Street', '1990-12-20', 31, '+639555666777', 'Widowed', 'Filipino'),
(23, 'Sanchez', 'David', 'Daniel', 'Male', '5', '3', '29', 'Orion Road', '1996-03-10', 25, '+639777888999', 'Married', 'Filipino'),
(24, 'Cruz', 'Sophia', 'Emily', 'Female', '5', '4', '3', 'Centaurus Avenue', '1988-08-25', 33, '+639444555666', 'Single', 'Filipino'),
(25, 'Torres', 'Benjamin', 'Alexander', 'Male', '5', '5', '20', 'Pegasus Lane', '1991-01-10', 30, '+639777888999', 'Married', 'Filipino'),
(26, 'Gutierrez', 'Emma', 'Mia', 'Female', '5', '6', '13', 'Andromeda Street', '1994-06-05', 27, '+639888999000', 'Single', 'Filipino'),
(27, 'Flores', 'Daniel', 'Oliver', 'Male', '5', '7', '30', 'Orion Road', '1989-11-20', 32, '+639666777888', 'Divorced', 'Filipino'),
(28, 'Ramos', 'Emily', 'Ava', 'Female', '5', '8', '4', 'Centaurus Avenue', '1993-08-15', 28, '+639555666777', 'Married', 'Filipino'),
(29, 'Gonzales', 'William', 'Jacob', 'Male', '5', '9', '12', 'Pegasus Lane', '1990-03-30', 31, '+639444555666', 'Single', 'Filipino'),
(30, 'Santos', 'Mia', 'Sophia', 'Female', '5', '10', '1', 'Andromeda Street', '1995-10-15', 26, '+639777888999', 'Married', 'Filipino'),
(31, 'Castillo', 'Elijah', 'Daniel', 'Male', '5', '11', '5', 'Orion Road', '1992-05-25', 29, '+639333444555', 'Single', 'Filipino'),
(32, 'Chavez', 'Charlotte', 'Emma', 'Female', '5', '12', '30', 'Centaurus Avenue', '1986-12-30', 35, '+639666777888', 'Divorced', 'Filipino'),
(33, 'Gomez', 'Sophia', 'Emily', 'Male', '5', '13', '6', 'Pegasus Lane', '1993-07-05', 28, '+639555666777', 'Married', 'Filipino'),
(34, 'Fernandez', 'Michael', 'David', 'Female', '5', '14', '24', 'Andromeda Street', '1988-02-20', 33, '+639777888999', 'Single', 'Filipino'),
(35, 'Vargas', 'Ethan', 'William', 'Male', '5', '15', '17', 'Orion Road', '1993-07-30', 28, '+639444555666', 'Widowed', 'Filipino'),
(36, 'Perez', 'Mia', 'Sophia', 'Female', '5', '16', '28', 'Centaurus Avenue', '1996-01-15', 25, '+639888999000', 'Married', 'Filipino'),
(37, 'Hernandez', 'Alexander', 'Benjamin', 'Male', '5', '17', '9', 'Pegasus Lane', '1991-02-10', 30, '+639777888999', 'Single', 'Filipino'),
(38, 'Ramirez', 'Mia', 'Charlotte', 'Female', '5', '18', '22', 'Andromeda Street', '1994-07-05', 27, '+639666777888', 'Married', 'Filipino'),
(39, 'Sanchez', 'Daniel', 'Oliver', 'Male', '5', '19', '11', 'Orion Road', '1989-12-20', 32, '+639555666777', 'Single', 'Filipino'),
(40, 'Cruz', 'Sophia', 'Emily', 'Female', '5', '20', '27', 'Centaurus Avenue', '1991-10-15', 30, '+639444555666', 'Married', 'Filipino'),
(41, 'Torres', 'Benjamin', 'Alexander', 'Male', '5', '21', '15', 'Pegasus Lane', '1992-11-10', 29, '+639777888999', 'Married', 'Filipino'),
(42, 'Gutierrez', 'Emma', 'Mia', 'Female', '5', '22', '10', 'Andromeda Street', '1995-04-25', 26, '+639888999000', 'Single', 'Filipino'),
(43, 'Flores', 'Daniel', 'Oliver', 'Male', '5', '23', '19', 'Orion Road', '1990-09-10', 31, '+639666777888', 'Divorced', 'Filipino'),
(44, 'Ramos', 'Emily', 'Ava', 'Female', '5', '24', '3', 'Centaurus Avenue', '1993-02-15', 28, '+639555666777', 'Married', 'Filipino'),
(45, 'Gonzales', 'William', 'Jacob', 'Male', '5', '25', '16', 'Pegasus Lane', '1988-07-30', 33, '+639444555666', 'Single', 'Filipino'),
(46, 'Santos', 'Mia', 'Sophia', 'Female', '5', '26', '23', 'Andromeda Street', '1991-04-05', 30, '+639777888999', 'Married', 'Filipino'),
(47, 'Castillo', 'Elijah', 'Daniel', 'Male', '5', '27', '7', 'Orion Road', '1994-09-20', 27, '+639333444555', 'Single', 'Filipino'),
(48, 'Chavez', 'Charlotte', 'Emma', 'Female', '5', '28', '26', 'Centaurus Avenue', '1989-06-15', 32, '+639666777888', 'Divorced', 'Filipino'),
(49, 'Gomez', 'Sophia', 'Emily', 'Male', '5', '29', '2', 'Pegasus Lane', '1992-01-30', 29, '+639555666777', 'Married', 'Filipino'),
(50, 'Fernandez', 'Michael', 'David', 'Female', '5', '30', '21', 'Andromeda Street', '1995-08-15', 26, '+639777888999', 'Single', 'Filipino'),
(51, 'Vargas', 'Ethan', 'William', 'Male', '5', '1', '8', 'Orion Road', '1990-03-10', 31, '+639444555666', 'Widowed', 'Filipino'),
(52, 'Perez', 'Mia', 'Sophia', 'Female', '5', '2', '18', 'Centaurus Avenue', '1995-10-25', 26, '+639888999000', 'Married', 'Filipino'),
(53, 'Hernandez', 'Alexander', 'Benjamin', 'Male', '5', '3', '5', 'Pegasus Lane', '1991-05-10', 30, '+639777888999', 'Single', 'Filipino'),
(54, 'Ramirez', 'Mia', 'Charlotte', 'Female', '5', '4', '14', 'Andromeda Street', '1994-12-05', 27, '+639666777888', 'Married', 'Filipino'),
(55, 'Sanchez', 'Daniel', 'Oliver', 'Male', '5', '5', '25', 'Orion Road', '1988-09-20', 33, '+639555666777', 'Single', 'Filipino'),
(56, 'Cruz', 'Sophia', 'Emily', 'Female', '5', '6', '9', 'Centaurus Avenue', '1991-06-15', 30, '+639444555666', 'Married', 'Filipino'),
(57, 'Torres', 'Benjamin', 'Alexander', 'Male', '5', '7', '24', 'Pegasus Lane', '1993-11-10', 28, '+639777888999', 'Married', 'Filipino'),
(58, 'Gutierrez', 'Emma', 'Mia', 'Female', '5', '8', '1', 'Andromeda Street', '1996-04-25', 25, '+639888999000', 'Single', 'Filipino'),
(59, 'Flores', 'Daniel', 'Oliver', 'Male', '5', '9', '13', 'Orion Road', '1991-09-10', 30, '+639666777888', 'Divorced', 'Filipino'),
(60, 'Ramos', 'Emily', 'Ava', 'Female', '5', '10', '4', 'Centaurus Avenue', '1994-02-15', 27, '+639555666777', 'Married', 'Filipino'),
(61, 'Gonzales', 'William', 'Jacob', 'Male', '5', '11', '17', 'Pegasus Lane', '1988-07-30', 33, '+639444555666', 'Single', 'Filipino'),
(62, 'Santos', 'Mia', 'Sophia', 'Female', '5', '12', '30', 'Andromeda Street', '1991-04-05', 30, '+639777888999', 'Married', 'Filipino'),
(63, 'Castillo', 'Elijah', 'Daniel', 'Male', '5', '13', '12', 'Orion Road', '1994-09-20', 27, '+639333444555', 'Single', 'Filipino'),
(64, 'Chavez', 'Charlotte', 'Emma', 'Female', '5', '14', '6', 'Centaurus Avenue', '1989-06-15', 32, '+639666777888', 'Divorced', 'Filipino'),
(65, 'Gomez', 'Sophia', 'Emily', 'Male', '5', '15', '24', 'Pegasus Lane', '1992-01-30', 29, '+639555666777', 'Married', 'Filipino'),
(66, 'Fernandez', 'Michael', 'David', 'Female', '5', '16', '17', 'Andromeda Street', '1995-08-15', 26, '+639777888999', 'Single', 'Filipino'),
(67, 'Vargas', 'Ethan', 'William', 'Male', '5', '17', '9', 'Orion Road', '1990-03-10', 31, '+639444555666', 'Widowed', 'Filipino'),
(68, 'Perez', 'Mia', 'Sophia', 'Female', '5', '18', '20', 'Centaurus Avenue', '1995-10-25', 26, '+639888999000', 'Married', 'Filipino'),
(69, 'Hernandez', 'Alexander', 'Benjamin', 'Male', '5', '19', '7', 'Pegasus Lane', '1991-05-10', 30, '+639777888999', 'Single', 'Filipino'),
(70, 'Ramirez', 'Mia', 'Charlotte', 'Female', '5', '20', '15', 'Andromeda Street', '1994-12-05', 27, '+639666777888', 'Married', 'Filipino'),
(71, 'Sanchez', 'Daniel', 'Oliver', 'Male', '5', '21', '11', 'Orion Road', '1988-09-20', 33, '+639555666777', 'Single', 'Filipino'),
(72, 'Cruz', 'Sophia', 'Emily', 'Female', '5', '22', '28', 'Centaurus Avenue', '1991-06-15', 30, '+639444555666', 'Married', 'Filipino'),
(73, 'Torres', 'Benjamin', 'Alexander', 'Male', '5', '23', '26', 'Pegasus Lane', '1993-11-10', 28, '+639777888999', 'Married', 'Filipino'),
(74, 'Gutierrez', 'Emma', 'Mia', 'Female', '5', '24', '3', 'Andromeda Street', '1996-04-25', 25, '+639888999000', 'Single', 'Filipino'),
(75, 'Flores', 'Daniel', 'Oliver', 'Male', '5', '25', '16', 'Orion Road', '1991-09-10', 30, '+639666777888', 'Divorced', 'Filipino'),
(76, 'Ramos', 'Emily', 'Ava', 'Female', '5', '26', '7', 'Centaurus Avenue', '1994-02-15', 27, '+639555666777', 'Married', 'Filipino'),
(77, 'Gonzales', 'William', 'Jacob', 'Male', '5', '27', '24', 'Pegasus Lane', '1988-07-30', 33, '+639444555666', 'Single', 'Filipino'),
(78, 'Santos', 'Mia', 'Sophia', 'Female', '5', '28', '9', 'Andromeda Street', '1991-04-05', 30, '+639777888999', 'Married', 'Filipino'),
(79, 'Castillo', 'Elijah', 'Daniel', 'Male', '5', '29', '2', 'Orion Road', '1994-09-20', 27, '+639333444555', 'Single', 'Filipino'),
(80, 'Chavez', 'Charlotte', 'Emma', 'Female', '5', '30', '20', 'Centaurus Avenue', '1989-06-15', 32, '+639666777888', 'Divorced', 'Filipino'),
(81, 'Boco', 'Robbie', 'Deguzman', 'Male', '5', '8', '2', 'STARBURST', '2001-01-22', 22, '09123456789', 'Married', 'Filipino');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `username`, `password`, `role`) VALUES
(1, 'president', 'president', 'president'),
(3, 'secretary', 'secretary', 'secretary'),
(4, 'vice', 'vice', 'vicepresident');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `venue` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `title`, `description`, `start_datetime`, `end_datetime`, `user_id`, `venue`) VALUES
(3, 'event 1', 'event 1', '2023-06-09 11:00:00', '2023-06-09 12:00:00', 5, 'Clubhouse'),
(4, 'carl', 'carl', '2023-06-09 08:56:00', '2023-06-09 08:56:00', 5, 'Clubhouse'),
(5, 'carl', 'carl', '2023-06-09 12:01:00', '2023-06-09 14:00:00', 5, 'Clubhouse'),
(6, 'carl', 'carl', '2023-06-09 08:59:00', '2023-06-09 12:59:00', 11, 'Covered Cour'),
(7, 'sad', 'sad', '2023-06-10 09:14:00', '2023-06-11 09:14:00', 11, 'Covered Cour'),
(8, 'Event ayi', 'Catering', '2023-06-13 08:56:00', '2023-06-13 10:23:00', 22, 'Clubhouse'),
(9, 'Basketball', 'Tournament', '2023-06-23 12:00:00', '2023-06-23 17:00:00', 25, 'Covered Cour'),
(10, 'Party', 'JS', '2023-06-23 12:00:00', '2023-06-23 20:00:00', 25, 'Covered Cour'),
(11, 'Court', 'Court', '2023-06-24 10:00:00', '2023-06-24 14:00:00', 26, 'Covered Cour');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `house_ownership_type` varchar(255) NOT NULL,
  `block` int(3) NOT NULL,
  `lot` int(3) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `verification_code` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `verification_status` enum('Pending','Verified') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approved_users`
--
ALTER TABLE `approved_users`
  ADD PRIMARY KEY (`resident_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_cashpayment`
--
ALTER TABLE `pending_cashpayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_gcashpayment`
--
ALTER TABLE `pending_gcashpayment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `rejected_users`
--
ALTER TABLE `rejected_users`
  ADD PRIMARY KEY (`resident_id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `approved_users`
--
ALTER TABLE `approved_users`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_cashpayment`
--
ALTER TABLE `pending_cashpayment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pending_gcashpayment`
--
ALTER TABLE `pending_gcashpayment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rejected_users`
--
ALTER TABLE `rejected_users`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pending_gcashpayment`
--
ALTER TABLE `pending_gcashpayment`
  ADD CONSTRAINT `pending_gcashpayment_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `approved_users` (`resident_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
