-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2021 at 09:05 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

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
-- Table structure for table `tbl_uraian`
--

CREATE TABLE `tbl_uraian` (
  `id_uraian` int(11) NOT NULL,
  `id_kwitansi` int(11) NOT NULL,
  `uraian` varchar(200) NOT NULL,
  `jumlah` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_uraian`
--

INSERT INTO `tbl_uraian` (`id_uraian`, `id_kwitansi`, `uraian`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '1', '1', '2021-01-01 05:36:08', '2021-01-01 00:49:02', '2021-01-01 07:49:02'),
(2, 14, 'uraian 1', 'jml 1', '2021-01-01 07:10:01', '2021-01-01 07:10:01', NULL),
(3, 14, 'ur 2', 'jm 2', '2021-01-01 07:10:01', '2021-01-01 07:10:01', NULL),
(4, 15, 'uraian 1', 'jml 1', '2021-01-01 08:00:29', '2021-01-01 08:00:29', NULL),
(5, 15, '3434', '4566', '2021-01-01 08:00:29', '2021-01-01 08:00:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_uraian`
--
ALTER TABLE `tbl_uraian`
  ADD PRIMARY KEY (`id_uraian`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_uraian`
--
ALTER TABLE `tbl_uraian`
  MODIFY `id_uraian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
