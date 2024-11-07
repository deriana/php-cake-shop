-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2024 at 07:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cake`
--

-- --------------------------------------------------------

--
-- Table structure for table `cakes`
--

CREATE TABLE `cakes` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `imgurl` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category` enum('Kue Balok','Kue Bolu','Kue Lapis Talas','Brownies') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cakes`
--

INSERT INTO `cakes` (`id`, `name`, `stock`, `price`, `imgurl`, `created_at`, `updated_at`, `category`) VALUES
(8, '123', 110, 20.00, 'assets/cakeImg/flutter.png', '2024-11-05 02:34:56', '2024-11-07 03:48:38', 'Kue Balok'),
(9, 'bambang subroto', 10, 25.00, 'assets/cakeImg/Frieren (1).jpeg', '2024-11-05 10:11:15', '2024-11-05 11:53:17', 'Kue Balok'),
(10, 'TEST', 100, 200.00, 'assets/cakeImg/OIP (1).jpg', '2024-11-05 10:12:51', '2024-11-05 10:12:51', 'Kue Balok'),
(11, 'Test132', 10, 9.00, 'assets/cakeImg/464296901_1084413043366143_2666140367591480106_n.jpg', '2024-11-05 10:14:44', '2024-11-05 10:32:18', 'Kue Balok'),
(14, '13', 32, 123.00, 'assets/cakeImg/flutter.png', '2024-11-05 11:31:25', '2024-11-05 11:31:25', 'Kue Balok'),
(15, 'Jeanne', 3, 20.00, 'assets/cakeImg/_10a70d6c-e946-4c9f-bbb6-287ad94d6ca6.jpeg', '2024-11-05 12:29:31', '2024-11-06 00:22:13', 'Kue Balok'),
(16, 'nigga', 90, 10.00, 'assets/cakeImg/7725825.jpg', '2024-11-05 12:31:26', '2024-11-05 15:41:21', 'Kue Lapis Talas'),
(17, 'test', 3, 10.00, 'assets/cakeImg/aigis.jpg', '2024-11-05 15:39:55', '2024-11-06 15:11:37', 'Brownies'),
(18, 'Amelia', 30, 20.00, 'assets/cakeImg/GYGUk9hasAALEua.jpeg', '2024-11-05 16:59:11', '2024-11-05 17:01:39', 'Kue Balok'),
(19, 'bus', 20, 20.00, 'assets/cakeImg/Gambar Desain Media Sosial Demokrasi Hari Internasional _ PSD Unduhan Gratis - Pikbest.jpg', '2024-11-06 14:50:18', '2024-11-06 14:50:18', 'Kue Balok'),
(20, 'Ali', 20, 5.00, 'assets/cakeImg/Prabowo Presiden Indonesia Maju.jpg', '2024-11-07 03:13:05', '2024-11-07 03:13:05', 'Kue Balok'),
(22, 'puding coklat pak hambali', 6868, 69.00, 'assets/cakeImg/JerriGame.png', '2024-11-07 06:42:52', '2024-11-07 07:36:12', 'Kue Balok'),
(23, 'Puding Aseli Mas Rusdi', 50, 20.00, 'assets/cakeImg/icon.png', '2024-11-07 07:35:37', '2024-11-07 07:35:53', 'Kue Bolu');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `cake_id` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','rek') NOT NULL,
  `pembeli` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `cake_id`, `quantity`, `discount`, `total_price`, `payment_method`, `pembeli`, `created_at`) VALUES
(12, 18, 20, 200.00, 200.00, 'rek', 'Deryana', '2024-11-05'),
(13, 15, 2, 0.00, 40.00, 'rek', 'Jawa', '2024-11-06'),
(14, 17, 2, 0.00, 20.00, 'cash', '', '2024-11-06'),
(15, 8, 13, 52.00, 208.00, 'rek', 'Ahmad', '2024-11-07'),
(16, 22, 1, 34.50, 34.50, 'rek', 'Arya', '2024-11-07'),
(17, 22, 100, 6900.00, 0.00, 'cash', 'Arya', '2024-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(8, 'admin', '$2y$10$z.kY1loOLUiW2vqicYcHhuec7VglCl0JxTf7Xv9GRXdblfvQowjnS', '2024-11-05 16:47:10'),
(10, 'jeanne', '$2y$10$a7VMoJGGm578Vmpr1RvQF..K9IFwWx./7PzPOViYCuMn5CH30kVbe', '2024-11-06 00:35:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cakes`
--
ALTER TABLE `cakes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cake_id` (`cake_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cakes`
--
ALTER TABLE `cakes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
