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
-- Table structure for table `tbl_kwitansi`
--

CREATE TABLE `tbl_kwitansi` (
  `id_kwitansi` int(11) NOT NULL,
  `nomor` varchar(200) NOT NULL,
  `tanggal` varchar(200) NOT NULL,
  `terima` varchar(200) NOT NULL,
  `catatan` varchar(200) NOT NULL,
  `penyetor` varchar(200) NOT NULL,
  `mengetahui` varchar(200) NOT NULL,
  `penerima` varchar(200) NOT NULL,
  `id_berkas` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kwitansi`
--

INSERT INTO `tbl_kwitansi` (`id_kwitansi`, `nomor`, `tanggal`, `terima`, `catatan`, `penyetor`, `mengetahui`, `penerima`, `id_berkas`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '2018-06-12', '1', '1', '1', '1', '1', 131, '2021-01-01 05:36:08', '2021-01-01 00:49:02', '2021-01-01 07:49:02'),
(14, 'testingdd', '2020-12-12', '1', '122', '1', '1', '1', 144, '2021-01-01 07:10:01', '2021-01-01 07:10:01', NULL),
(15, 'shjxfhnbsxrfh', '2020-12-12', '1', 'Et possimus tempore hic distinctio eligendi', '1', '1', '1', 145, '2021-01-01 08:00:29', '2021-01-01 08:00:29', NULL),
(16, 'dtj', '2020-12-12', '1', 'Et possimus tempore hic distinctio eligendi', '1', '1', '1', 146, '2021-01-01 08:01:18', '2021-01-01 08:01:18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_kwitansi`
--
ALTER TABLE `tbl_kwitansi`
  ADD PRIMARY KEY (`id_kwitansi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_kwitansi`
--
ALTER TABLE `tbl_kwitansi`
  MODIFY `id_kwitansi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
