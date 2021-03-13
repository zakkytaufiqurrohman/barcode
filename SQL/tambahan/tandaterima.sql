-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 13, 2021 at 06:39 AM
-- Server version: 8.0.22
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barcodea_psi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tandaterima`
--

CREATE TABLE `tandaterima` (
  `id_tandaterima` int NOT NULL,
  `terima` varchar(200) NOT NULL,
  `berupa` varchar(200) NOT NULL,
  `keperluan` varchar(200) NOT NULL,
  `tanggal` varchar(200) NOT NULL,
  `penerima` varchar(100) NOT NULL,
  `penyerah` varchar(100) NOT NULL,
  `id_berkas` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tandaterima`
--
ALTER TABLE `tandaterima`
  ADD PRIMARY KEY (`id_tandaterima`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tandaterima`
--
ALTER TABLE `tandaterima`
  MODIFY `id_tandaterima` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
