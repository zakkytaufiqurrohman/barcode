-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 13, 2021 at 06:37 AM
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
-- Table structure for table `tbl_reporforium`
--

CREATE TABLE `tbl_reporforium` (
  `id_reporforium` int NOT NULL,
  `id_berkas` int NOT NULL,
  `nomor` int NOT NULL,
  `no_bulanan` int NOT NULL,
  `tanggal` date NOT NULL,
  `sifat_akta` varchar(100) NOT NULL,
  `berkas` varchar(100) NOT NULL,
  `sk_kemenhumkam` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_reporforium`
--
ALTER TABLE `tbl_reporforium`
  ADD PRIMARY KEY (`id_reporforium`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reporforium`
--
ALTER TABLE `tbl_reporforium`
  MODIFY `id_reporforium` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
