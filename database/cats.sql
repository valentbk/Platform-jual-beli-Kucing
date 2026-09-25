-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2026 at 09:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cats`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori_ras`
--

CREATE TABLE `kategori_ras` (
  `id_ras` int(11) NOT NULL,
  `nama_ras` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_ras`
--

INSERT INTO `kategori_ras` (`id_ras`, `nama_ras`) VALUES
(1, 'Persian'),
(2, 'Maine Coon'),
(3, 'British Shorthair'),
(5, 'domestik/Kampung');

-- --------------------------------------------------------

--
-- Table structure for table `kucing`
--

CREATE TABLE `kucing` (
  `id_kucing` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `id_ras` int(11) NOT NULL,
  `nama_kucing` varchar(100) NOT NULL,
  `jenis_kelamin` enum('J','B') NOT NULL,
  `umur_bulan` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_kucing` text DEFAULT NULL,
  `file_kesehatan` text DEFAULT NULL,
  `status_validasi` enum('P','V','D') DEFAULT 'P',
  `status_jual` enum('TS','TJ') DEFAULT 'TS',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kucing`
--

INSERT INTO `kucing` (`id_kucing`, `id_penjual`, `id_ras`, `nama_kucing`, `jenis_kelamin`, `umur_bulan`, `harga`, `deskripsi`, `foto_kucing`, `file_kesehatan`, `status_validasi`, `status_jual`, `created_at`) VALUES
(23, 2, 1, 'Manaf', 'J', 8, 6000000, 'bulunya lembut,bagus dan berkilau', NULL, '1790233373_Buku Kesehatan Kucing - Leo.pdf', 'P', 'TS', '2026-09-24 07:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `penarikan_dana`
--

CREATE TABLE `penarikan_dana` (
  `id_penarikan` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `id_rek_penjual` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `tanggal_pengajuan` datetime DEFAULT current_timestamp(),
  `bukti_transfer_admin` varchar(255) DEFAULT NULL,
  `status_penarikan` enum('Pending','Diproses','Sukses','Ditolak') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penarikan_dana`
--

INSERT INTO `penarikan_dana` (`id_penarikan`, `id_penjual`, `id_rek_penjual`, `nominal`, `tanggal_pengajuan`, `bukti_transfer_admin`, `status_penarikan`) VALUES
(1, 2, 1, 2000000, '2026-09-24 10:56:12', NULL, 'Ditolak'),
(2, 2, 1, 100000, '2026-09-24 11:07:39', '1790223325_images (1).jpeg', 'Sukses'),
(3, 2, 1, 2000000, '2026-09-24 11:20:45', NULL, 'Ditolak'),
(4, 2, 1, 1500000, '2026-09-24 11:21:57', '1790223746_images (1).jpeg', 'Sukses');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_admin`
--

CREATE TABLE `rekening_admin` (
  `id_rek_admin` int(11) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening_admin`
--

INSERT INTO `rekening_admin` (`id_rek_admin`, `nama_bank`, `no_rekening`, `atas_nama`) VALUES
(1, 'BCA', '1234567890', 'PT Aplikasi Kucing PKL'),
(3, 'BRI', '085780051258', 'Valent Bintang Kautsar');

-- --------------------------------------------------------

--
-- Table structure for table `rekening_penjual`
--

CREATE TABLE `rekening_penjual` (
  `id_rek_penjual` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `atas_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening_penjual`
--

INSERT INTO `rekening_penjual` (`id_rek_penjual`, `id_penjual`, `nama_bank`, `no_rekening`, `atas_nama`) VALUES
(1, 2, 'BRI', '12345678', 'kimko'),
(2, 2, 'BCA', '987654321', 'toto');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pembeli` int(11) NOT NULL,
  `id_kucing` int(11) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT current_timestamp(),
  `harga_kucing` int(11) NOT NULL,
  `biaya_admin` int(11) DEFAULT 0,
  `total_bayar` int(11) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status_transaksi` enum('Belum Bayar','Verifikasi Pembayaran','Diproses','Dikirim','Selesai','Batal') DEFAULT 'Belum Bayar',
  `no_resi_pengiriman` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('A','PJ','PB') NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pin` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `no_hp`, `alamat`, `created_at`, `pin`) VALUES
(1, 'Super Admin', 'admin@kucing.com', '8cb2237d0679ca88db6464eac60da96345513964', 'A', '08123456789', 'Kantor Admin', '2026-09-21 07:46:20', '123'),
(2, 'penjual1', 'penjual1@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'PJ', '085780051251', 'kalteng', '2026-09-21 08:32:39', '123'),
(3, 'pembeli1', 'pembeli1@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'PB', '085780051252', 'kalbar', '2026-09-21 08:32:39', '123'),
(4, 'jamal', 'jamal@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'A', '123456789', 'pwt', '2026-09-21 10:24:10', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori_ras`
--
ALTER TABLE `kategori_ras`
  ADD PRIMARY KEY (`id_ras`);

--
-- Indexes for table `kucing`
--
ALTER TABLE `kucing`
  ADD PRIMARY KEY (`id_kucing`),
  ADD KEY `id_penjual` (`id_penjual`),
  ADD KEY `id_ras` (`id_ras`);

--
-- Indexes for table `penarikan_dana`
--
ALTER TABLE `penarikan_dana`
  ADD PRIMARY KEY (`id_penarikan`),
  ADD KEY `id_penjual` (`id_penjual`),
  ADD KEY `id_rek_penjual` (`id_rek_penjual`);

--
-- Indexes for table `rekening_admin`
--
ALTER TABLE `rekening_admin`
  ADD PRIMARY KEY (`id_rek_admin`);

--
-- Indexes for table `rekening_penjual`
--
ALTER TABLE `rekening_penjual`
  ADD PRIMARY KEY (`id_rek_penjual`),
  ADD KEY `id_penjual` (`id_penjual`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pembeli` (`id_pembeli`),
  ADD KEY `id_kucing` (`id_kucing`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori_ras`
--
ALTER TABLE `kategori_ras`
  MODIFY `id_ras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kucing`
--
ALTER TABLE `kucing`
  MODIFY `id_kucing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `penarikan_dana`
--
ALTER TABLE `penarikan_dana`
  MODIFY `id_penarikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rekening_admin`
--
ALTER TABLE `rekening_admin`
  MODIFY `id_rek_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rekening_penjual`
--
ALTER TABLE `rekening_penjual`
  MODIFY `id_rek_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penarikan_dana`
--
ALTER TABLE `penarikan_dana`
  ADD CONSTRAINT `penarikan_dana_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `penarikan_dana_ibfk_2` FOREIGN KEY (`id_rek_penjual`) REFERENCES `rekening_penjual` (`id_rek_penjual`) ON DELETE CASCADE;

--
-- Constraints for table `rekening_penjual`
--
ALTER TABLE `rekening_penjual`
  ADD CONSTRAINT `rekening_penjual_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
