-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: localhost:3306
-- Generation Time: Nov 08, 2024 at 12:52 PM
-- Server version: 5.7.35
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Menggunakan charset dan collation utf8_general_ci
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 COLLATE utf8_general_ci */;

-- Database: `db_cake`
-- --------------------------------------------------------

-- Table structure for table `cakes`
CREATE TABLE `cakes` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL COLLATE utf8_general_ci,
  `stock` int NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `imgurl` varchar(255) DEFAULT NULL COLLATE utf8_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Table structure for table `category`
CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL COLLATE utf8_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Table structure for table `sales`
CREATE TABLE `sales` (
  `id` int NOT NULL,
  `cake_id` int NOT NULL,
  `quantity` int NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('cash', 'rek') NOT NULL COLLATE utf8_general_ci,
  `pembeli` varchar(255) DEFAULT NULL COLLATE utf8_general_ci,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cake_id` (`cake_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL COLLATE utf8_general_ci,
  `password` varchar(255) NOT NULL COLLATE utf8_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Menambahkan foreign key setelah tabel dibuat
ALTER TABLE `cakes`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `sales`
  ADD CONSTRAINT `fk_cake_id` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Hapus semua data INSERT kecuali `users`
-- Dumping data for table `users`
INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$TbJ2yAqgH4wsmilP5kLgA.7l7wYtwllV4hvrl7OniFA2Imvpgb7yK', '2024-11-06 04:53:50'),
(2, 'hassan', '$2y$10$7j0FgFlmA3Z3l92VL9E6A.6E4HLFf7ziVFSu4Jk2TDiDYPW9V6p4i', '2024-11-06 04:53:52');

COMMIT;
