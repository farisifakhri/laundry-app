-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2026 at 12:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(100) NOT NULL,
  `id_jenis_layanan` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_order` varchar(100) NOT NULL,
  `tanggal_cuci` datetime NOT NULL,
  `tanggal_gosok` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `tanggal_pengambilan` datetime NOT NULL,
  `subtotal` int(11) NOT NULL,
  `updated_by_cuci` int(11) NOT NULL,
  `updated_by_name_cuci` varchar(100) NOT NULL,
  `updated_by_gosok` int(11) NOT NULL,
  `updated_by_name_gosok` varchar(100) NOT NULL,
  `updated_by_selesai` int(11) NOT NULL,
  `updated_by_name_selesai` varchar(100) NOT NULL,
  `updated_by_pengembalian` int(11) NOT NULL,
  `updated_by_name_pengembalian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_jenis_layanan`, `qty`, `status_order`, `tanggal_cuci`, `tanggal_gosok`, `tanggal_selesai`, `tanggal_pengambilan`, `subtotal`, `updated_by_cuci`, `updated_by_name_cuci`, `updated_by_gosok`, `updated_by_name_gosok`, `updated_by_selesai`, `updated_by_name_selesai`, `updated_by_pengembalian`, `updated_by_name_pengembalian`) VALUES
(1, '123456', 2, 2, 'proses', '2025-11-04 07:07:00', '2025-11-04 14:19:03', '2025-11-04 14:19:03', '2025-11-04 14:19:03', 0, 1, 'rayhan', 0, '', 0, '', 0, ''),
(5, '2025-11-05-3-2417', 4, 6, 'proses', '0000-00-00 00:00:00', '2025-11-05 16:53:39', '2025-11-05 16:53:45', '2025-11-05 16:53:47', 30000, 0, '', 1, 'Admin', 1, 'Admin', 1, 'Admin'),
(6, '2025-11-05-3-2417', 2, 7, 'selesai', '2025-11-05 16:54:21', '2025-11-05 16:55:53', '2025-11-05 16:56:28', '2025-11-05 16:56:40', 45500, 1, 'Admin', 1, 'Admin', 1, 'Admin', 1, 'Admin'),
(7, '2025-11-06-3-3436', 4, 4, 'proses', '0000-00-00 00:00:00', '2025-11-06 09:20:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 20000, 0, '', 1, 'Admin', 0, '', 0, ''),
(8, '2025-11-06-3-3436', 2, 2, 'proses', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 13000, 0, '', 0, '', 0, '', 0, ''),
(9, '2025-11-06-3-1389', 2, 4, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 26000, 0, '', 0, '', 0, '', 0, ''),
(10, '2025-11-06-3-8884', 2, 4, 'proses', '2025-11-06 15:01:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 26000, 1, 'Admin', 0, '', 0, '', 0, ''),
(11, '2025-11-06-3-8884', 3, 6, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 30000, 0, '', 0, '', 0, '', 0, ''),
(12, '2026-01-01-6-6280', 4, 6, 'proses', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 30000, 0, '', 0, '', 0, '', 0, ''),
(13, '2026-01-01-6-6280', 3, 7, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 35000, 0, '', 0, '', 0, '', 0, ''),
(14, '2026-01-02-7-3440', 6, 1, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-02 20:42:48', '0000-00-00 00:00:00', 10000, 0, '', 0, '', 4, 'Administrator', 0, ''),
(15, '2026-01-02-8-4513', 5, 1, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-02 20:42:42', '0000-00-00 00:00:00', 6000, 0, '', 0, '', 4, 'Administrator', 0, ''),
(16, '2026-01-02-9-2454', 4, 1, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-02 20:42:36', '0000-00-00 00:00:00', 5000, 0, '', 0, '', 4, 'Administrator', 0, ''),
(17, '2026-01-02-9-7780', 3, 1, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-02 20:42:31', '0000-00-00 00:00:00', 5000, 0, '', 0, '', 4, 'Administrator', 0, ''),
(18, '2026-01-02-8-9469', 6, 1, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-02 22:20:53', '0000-00-00 00:00:00', 10000, 0, '', 0, '', 4, 'Administrator', 0, ''),
(19, '2026-01-07-8-507', 3, 10, 'selesai', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2026-01-07 08:46:45', '0000-00-00 00:00:00', 50000, 0, '', 0, '', 4, 'Administrator', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_layanan`
--

CREATE TABLE `jenis_layanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_by_name` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_layanan`
--

INSERT INTO `jenis_layanan` (`id`, `nama`, `harga`, `status`, `created_by`, `created_by_name`, `created_at`, `updated_by`, `updated_by_name`, `updated_at`) VALUES
(3, 'Cuci', 5000, 1, 0, '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00'),
(4, 'Gosok', 5000, 1, 0, '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00'),
(5, 'Cuci Gosok', 6000, 1, 4, 'Administrator', '2026-01-01 19:14:23', 4, 'Administrator', '2026-01-02 20:37:28');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_by_name` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `email`, `created_by`, `created_by_name`, `created_at`, `updated_by`, `updated_by_name`, `updated_at`) VALUES
(7, 'kezia', 'P', 'perum', '098725167368', 'kezia@gmail.com', 4, 'Administrator', '2026-01-02 20:35:04', 0, '', '0000-00-00 00:00:00'),
(8, 'dewi', 'P', 'sepatan', '089172636861', 'dewi@gmail.com', 4, 'Administrator', '2026-01-02 20:35:32', 0, '', '0000-00-00 00:00:00'),
(9, 'Riska Aulia', 'P', 'bugel', '089630982237', 'ra9010829@gmail.com', 4, 'Administrator', '2026-01-02 20:35:51', 4, 'Administrator', '2026-01-07 08:33:41'),
(10, 'SITI', 'P', 'Jl. Arya Wangsakara Rt 01 Rw 01 No.49', '089630982237', 'ra9010829@gmail.com', 4, 'Administrator', '2026-01-07 08:34:36', 0, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(100) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `metode_pembayaran` varchar(100) NOT NULL,
  `total` int(11) NOT NULL,
  `catatan_tambahan` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `metode_pembayaran`, `total`, `catatan_tambahan`, `created_by`, `created_by_name`, `created_at`) VALUES
('2026-01-02-7-3440', 7, 'Tunai', 10000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-02 20:38:34'),
('2026-01-02-8-4513', 8, 'Transfer', 6000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-02 20:39:08'),
('2026-01-02-8-9469', 8, 'Tunai', 10000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-02 21:56:50'),
('2026-01-02-9-2454', 9, 'E-Wallet', 5000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-02 20:39:24'),
('2026-01-02-9-7780', 9, 'E-Wallet', 5000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-02 20:40:08'),
('2026-01-07-8-507', 8, 'Tunai', 50000, 'Pakai Pewangi Rose', 4, 'Administrator', '2026-01-07 08:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_by_name` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`, `role`, `status`, `created_by`, `created_by_name`, `created_at`, `updated_by`, `updated_by_name`, `updated_at`) VALUES
(4, 'Administrator', 'administrator@mail.com', '$2y$10$P0gY/0r4ZJabD4rjw.OOdeZlPennB/ZhwXUjNmwPLFID6ACTl8m7S', 'admin', 1, 0, '', '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00'),
(6, 'test', 'rayhan.noerfikri@fli.co.id', '$2y$10$YDxSF4iiNIYHLJuAfVk/tesRKtb6wKrp6WGk3xvFoljv57qQh7oSS', 'owner', 0, 4, 'Administrator', '2025-11-06 14:57:23', 6, 'Administrator', '2025-11-06 14:59:12'),
(7, 'Owner', 'owner@mail.com', '$2y$10$P0gY/0r4ZJabD4rjw.OOdeZlPennB/ZhwXUjNmwPLFID6ACTl8m7S', 'owner', 1, 4, 'Administrator', '2025-11-06 15:35:07', 0, '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jenis_layanan`
--
ALTER TABLE `jenis_layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
