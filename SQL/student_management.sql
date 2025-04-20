-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 07:28 AM
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
-- Database: `student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` varchar(255) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `grade` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `roll` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `semester` int(255) DEFAULT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `major` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `roll`, `department`, `semester`, `shift`, `father_name`, `mother_name`, `address`, `number`, `file`, `time`, `dob`, `email`, `major`) VALUES
(34, 'Emon Hossain', '232-15-4535', 'CSE', 0, 'Morning', 'Abdur Rahman', 'Hawa', 'NOAKHALI', '01876542345', '1745203765_EMON.jpg', '2025-04-21 02:49:25', '2003-01-08', 'emon15-4535@diu.edu.bd', 'Software Engineering'),
(35, 'Emon Hossain', '232-15-4535', 'CSE', 0, 'Morning', 'Abdur Rahman', 'Hawa', 'NOAKHALI', '01876542345', '1745203776_EMON.jpg', '2025-04-21 02:49:36', '2003-01-08', 'emon15-4535@diu.edu.bd', 'Software Engineering'),
(36, 'MD AL AMIN AKASH', '213-15-4529', 'CSE', 3, 'Morning', 'roshidul', 'anzu', 'domar', '01951008871', '1745203965_RUPAK.jpg', '2025-04-21 02:52:45', '2025-04-20', 'alamin.cse@gmail.com', 'Software Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `c_password` varchar(200) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `c_password`, `photo`, `date`) VALUES
(17, 'MD AL AMIN AKASH', 'akash.alamin.cse@gmail.com', 'akash4529', 'akash4529', 'photo_2025-04-12_01-40-47.jpg', '2025-04-18 15:27:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
