-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 02:36 PM
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
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `check_in_date`, `check_out_date`, `total_price`, `booking_status`) VALUES
(21, 1, 1, '2024-02-13', '2024-02-15', 100.00, 'Confirmed'),
(22, 2, 2, '2024-02-13', '2024-02-15', 150.00, 'Confirmed'),
(23, 3, 3, '2024-02-14', '2024-02-16', 300.00, 'Confirmed'),
(24, 4, 4, '2024-02-14', '2024-02-16', 110.00, 'Confirmed'),
(25, 5, 6, '2024-02-13', '2024-02-15', 100.00, 'Confirmed'),
(26, 6, 7, '2024-02-13', '2024-02-15', 170.00, 'Confirmed'),
(27, 7, 8, '2024-02-14', '2024-02-16', 600.00, 'Confirmed'),
(28, 8, 9, '2024-02-14', '2024-02-16', 150.00, 'Confirmed'),
(29, 9, 10, '2024-02-13', '2024-02-15', 120.00, 'Confirmed'),
(30, 10, 11, '2024-02-13', '2024-02-15', 130.00, 'Confirmed'),
(31, 1, 2, '2024-06-01', '2024-06-05', 300.00, 'Confirmed'),
(32, 6, 3, '2024-06-05', '2024-06-07', 300.00, 'Confirmed'),
(33, 9, 5, '2024-06-10', '2024-06-13', 600.00, 'Confirmed'),
(34, 4, 6, '2024-07-01', '2024-07-05', 200.00, 'Confirmed'),
(35, 2, 7, '2024-08-02', '2024-08-06', 340.00, 'Confirmed'),
(36, 1, 5, '2024-12-29', '2025-01-02', 800.00, 'Confirmed'),
(37, 2, 8, '2024-12-30', '2025-01-01', 600.00, 'Pending'),
(38, 4, 12, '2024-12-31', '2025-01-02', 180.00, 'Pending'),
(39, 7, 15, '2024-12-30', '2025-01-01', 550.00, 'Pending'),
(40, 8, 14, '2024-12-30', '2025-01-02', 210.00, 'Pending'),
(41, 6, 7, '2024-12-30', '2025-01-01', 170.00, 'Pending'),
(42, 1, 10, '2024-11-28', '2024-12-01', 180.00, 'Confirmed'),
(43, 3, 10, '2024-12-03', '2024-12-04', 60.00, 'Confirmed'),
(45, 1, 10, '2024-11-12', '2024-11-14', 120.00, 'Confirmed'),
(46, 1, 1, '2024-11-26', '2024-11-28', 100.00, 'Cancelled'),
(47, 1, 1, '2024-12-04', '2024-12-05', 50.00, 'Cancelled'),
(48, 1, 1, '2024-12-06', '2024-12-07', 50.00, 'Confirmed'),
(49, 1, 2, '2024-12-08', '2024-12-09', 75.00, 'Cancelled'),
(50, 1, 2, '2024-12-19', '2024-12-07', 900.00, 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `question`, `answer`) VALUES
(1, 'Hello', 'Hi! How can I help you today?'),
(2, 'What is your name?', 'I am a chatbot created to assist you.'),
(3, 'How are you?', 'I am just a program, but I am functioning as expected!'),
(10, 'How do I book a room?', 'You can book a room by logging into your account, navigating to the \"Rooms\" section, and selecting your preferred room and dates.'),
(11, 'What payment methods are accepted?', 'We accept credit cards, bank transfers, and cash.'),
(12, 'Are pets allowed in the hotel?', 'Unfortunately, pets are not allowed in the hotel.'),
(13, 'Are there any promos?', 'We currently have a 20% discount for Bookings reserved from 3rd of January 2025 to 5th of January 2025');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_date` date NOT NULL DEFAULT curdate(),
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','credit_card','bank_transfer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `payment_date`, `amount_paid`, `payment_method`) VALUES
(1, 21, '2024-02-13', 100.00, 'credit_card'),
(2, 22, '2024-02-14', 150.00, 'credit_card'),
(3, 23, '2024-02-14', 300.00, 'cash'),
(4, 24, '2024-02-15', 110.00, 'bank_transfer'),
(5, 25, '2024-02-13', 100.00, 'credit_card'),
(6, 26, '2024-02-13', 170.00, 'cash'),
(7, 27, '2024-02-14', 600.00, 'credit_card'),
(8, 28, '2024-02-14', 150.00, 'bank_transfer'),
(9, 29, '2024-02-13', 120.00, 'cash'),
(10, 30, '2024-02-13', 130.00, 'credit_card'),
(11, 31, '2024-06-01', 300.00, 'cash'),
(12, 32, '2024-06-05', 300.00, 'credit_card'),
(13, 33, '2024-06-10', 600.00, 'credit_card'),
(14, 34, '2024-07-01', 200.00, 'cash'),
(15, 35, '2024-08-02', 340.00, 'credit_card'),
(16, 36, '2024-12-29', 800.00, 'credit_card'),
(17, 42, '2024-11-27', 180.00, 'credit_card'),
(18, 43, '2024-11-27', 60.00, 'bank_transfer'),
(19, 45, '2024-11-28', 120.00, 'credit_card'),
(20, 48, '2024-12-06', 50.00, 'cash'),
(21, 50, '2024-12-06', 900.00, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `room_type` enum('Single','Double','Suite') NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `availability` enum('YES','NO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_type`, `price_per_night`, `availability`) VALUES
(1, '101', 'Single', 50.00, 'NO'),
(2, '102', 'Double', 75.00, 'NO'),
(3, '103', 'Suite', 150.00, 'YES'),
(4, '104', 'Single', 55.00, 'YES'),
(5, '105', 'Suite', 200.00, 'YES'),
(6, '201', 'Single', 50.00, 'YES'),
(7, '202', 'Double', 85.00, 'NO'),
(8, '203', 'Suite', 300.00, 'NO'),
(9, '204', 'Double', 75.00, 'YES'),
(10, '205', 'Single', 60.00, 'NO'),
(11, '301', 'Single', 65.00, 'YES'),
(12, '302', 'Double', 90.00, 'NO'),
(13, '303', 'Suite', 250.00, 'YES'),
(14, '304', 'Single', 70.00, 'NO'),
(15, '305', 'Suite', 275.00, 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('pengguna','admin','manager') DEFAULT 'pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `level`) VALUES
(1, 'Terizla', 'terizla@gmail.com', '$2y$10$mkEjRunytUUnGrop5a92Mu6JWptH9NGLAnJ/sB1b850pHNSIzCB3K', 'pengguna'),
(2, 'Pupus', 'pupus@gmail.com', '$2y$10$TXZXdlSaVXggQXY6C8c/J.MhSLh2KyZNn7Ll/bM1TDqTB5vKwfKPe', 'pengguna'),
(3, 'Sabine', 'sabine@gmail.com', '$2y$10$78khTjhS0MW3x5B5ruSRFu7z3IVrFE1ZWXqFeDUvyXG15TD8a3sGG', 'pengguna'),
(4, 'Gatot', 'gatot@gmail.com', '$2y$10$.ilMtp/OSZt5h0ht4rnD4OYY33uzOT1T4XiIAtillqnAbXbNSfKeW', 'pengguna'),
(5, 'Khaleed', 'khaleed@gmail.com', '$2y$10$rE7n1bmBY4MoW/nsEuXqbOTgpaGStwnUw2KaPp6mPIq6TdfY/2SEO', 'pengguna'),
(6, 'Capybara', 'capybara@gmail.com', '$2y$10$.1fzzx8YY6wiVDRHP2buKOYp/jcUnBXwHZT6llJxS4JCVFXiqRLxS', 'pengguna'),
(7, 'Dino Softek', 'nailong@gmail.com', '$2y$10$xfQZyZhZvikL49gZ6flQheUZ6Bhy610gCFXNc6hsMWJkiZmJj.Wlu', 'pengguna'),
(8, 'Mewtwo', 'mewtwo@gmail.com', '$2y$10$noCK3xV4pPRG7MWwJbvLGuOx93KBmhZoDx.9KM5gQfr.VPWr0peIu', 'pengguna'),
(9, 'Kai Cenat', 'kai@gmail.com', '$2y$10$7fDk7VNvQLmeuriQW50w6O2LjkeavVV5qQRamF3ANtt0Wgo4siDZC', 'pengguna'),
(10, 'Perro Pedro', 'perro@gmail.com', '$2y$10$gCfLy3QW0782sHIh.F7nqOE6LTbhecmseAVszHFQvWq7cqwcvGr5y', 'admin'),
(11, 'admin', 'admin@gmail.com', '$2y$10$8beVF0SPHvEIkv9gk98uuOPhZwgVgQqqCaMzzQgjB.rDEePOJuddO', 'admin'),
(12, 'Alvin', 'alvin@gmail.com', '$2y$10$95YAOjOkfH7MoXdjFVIGeeEvFsdrbd2aB7du9khGXfmvi8VDPnrFO', 'manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
