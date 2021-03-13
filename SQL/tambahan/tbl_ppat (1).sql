-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 13, 2021 at 06:38 AM
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
-- Table structure for table `tbl_ppat`
--

CREATE TABLE `tbl_ppat` (
  `id_ppat` int NOT NULL,
  `no_urut` varchar(200) NOT NULL,
  `no_akta` varchar(200) NOT NULL,
  `tanggal_akta` date NOT NULL,
  `bentuk_hukum` varchar(200) NOT NULL,
  `pihak1` varchar(200) NOT NULL,
  `pihak2` varchar(200) NOT NULL,
  `nomor_hak` varchar(200) NOT NULL,
  `letak_bangunan` varchar(200) NOT NULL,
  `luas_tanah` varchar(200) NOT NULL,
  `luas_bangunan` varchar(200) NOT NULL,
  `harga_transaksi` varchar(200) NOT NULL,
  `nop_tahun` varchar(200) NOT NULL,
  `nilai_njop` varchar(200) DEFAULT NULL,
  `tanggal_ssp` date DEFAULT NULL,
  `nilai_ssp` varchar(200) NOT NULL,
  `tanggal_ssb` date DEFAULT NULL,
  `nilai_ssb` varchar(200) DEFAULT NULL,
  `keterangan` text,
  `tgl_masuk_bpn` date DEFAULT NULL,
  `tgl_selesai_bpn` date DEFAULT NULL,
  `tgl_penyerahan_clien` date DEFAULT NULL,
  `no_ktp` varchar(200) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `pas_foto` varchar(255) DEFAULT NULL,
  `foto_akad` varchar(255) DEFAULT NULL,
  `id_berkas` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_ppat`
--
ALTER TABLE `tbl_ppat`
  ADD PRIMARY KEY (`id_ppat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_ppat`
--
ALTER TABLE `tbl_ppat`
  MODIFY `id_ppat` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
