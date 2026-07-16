-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2026 at 09:39 AM
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
-- Database: `db_tiket_bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_berita`
--

CREATE TABLE `tabel_berita` (
  `id_berita` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_berita`
--

INSERT INTO `tabel_berita` (`id_berita`, `judul`, `isi`, `tanggal`) VALUES
(3, 'LIBUR SEMESTER', '15 JULI MULAI LIBUR', '2026-07-06'),
(4, 'Penyesuaian Jadwal Menjelang Libur Nasional', 'Sehubungan dengan momen libur nasional mendatang, PO Trans Bus menyesuaikan jadwal keberangkatan agar penumpang tetap nyaman. Harap cek jadwal terbaru melalui menu Rute.', '2026-07-01'),
(5, 'Kampanye Kebersihan Armada', 'Semua armada kami menjalani protokol kebersihan ekstra setiap hari. Penumpang diminta untuk tetap menjaga kebersihan selama perjalanan demi kenyamanan bersama.', '2026-06-20'),
(6, 'Promo Tiket Persahabatan', 'Dapatkan diskon khusus 15% untuk pemesanan kelompok 4 orang ke atas selama periode promo. Syarat dan ketentuan berlaku.', '2026-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_bus`
--

CREATE TABLE `tabel_bus` (
  `id_bus` int(11) NOT NULL,
  `nama_bus` varchar(50) NOT NULL,
  `kelas` varchar(30) NOT NULL,
  `kapasitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_bus`
--

INSERT INTO `tabel_bus` (`id_bus`, `nama_bus`, `kelas`, `kapasitas`) VALUES
(1, 'Trans Luxury 01', 'Eksekutif', 32),
(2, 'Bumi Lancar 05', 'Bisnis', 40),
(4, 'BSI CILEDUG', 'Ekonomi', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pelanggan`
--

CREATE TABLE `tabel_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_pelanggan`
--

INSERT INTO `tabel_pelanggan` (`id_pelanggan`, `nama_lengkap`, `email`, `password`, `no_telepon`, `dibuat_pada`) VALUES
(1, 'nabil', '123@gmail.com', '$2y$10$6uQ3ttdx91ogQo94knO02O/bEpse0wP4nPMadX7JkXeq3KMPaywtW', '01234567890', '2026-06-30 13:52:17'),
(2, 'nabil', 'mari@gmail.com', '$2y$10$spVNGaTlbUButn.u7wYt7e4J2fGaFQorNOts7ARsl2.aijR9u4zX2', '123', '2026-06-30 18:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pesanan`
--

CREATE TABLE `tabel_pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_rute` int(11) NOT NULL,
  `tanggal_berangkat` date NOT NULL,
  `jumlah_kursi` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_pesanan` varchar(50) DEFAULT 'Menunggu Pembayaran',
  `waktu_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_pesanan`
--

INSERT INTO `tabel_pesanan` (`id_pesanan`, `id_pelanggan`, `id_rute`, `tanggal_berangkat`, `jumlah_kursi`, `total_harga`, `status_pesanan`, `waktu_pesan`) VALUES
(1, 1, 1, '2026-06-30', 1, 350000, 'Menunggu Pembayaran', '2026-06-30 14:17:29'),
(2, 1, 3, '2026-06-30', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 14:23:59'),
(3, 1, 3, '2026-06-30', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 14:24:07'),
(4, 1, 3, '2026-06-30', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 14:27:48'),
(5, 1, 3, '2026-06-30', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 14:31:30'),
(6, 1, 3, '2026-06-30', 1, 3500, 'Batal', '2026-06-30 14:31:42'),
(7, 1, 3, '2026-06-30', 1, 3500, 'Lunas', '2026-06-30 14:33:58'),
(8, 1, 3, '2026-06-30', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 14:43:34'),
(9, 2, 3, '2026-07-01', 1, 3500, 'Menunggu Pembayaran', '2026-06-30 18:15:59'),
(10, 2, 3, '2026-07-01', 1, 3500, 'Lunas', '2026-06-30 18:16:07'),
(11, 1, 3, '2026-07-01', 1, 3500, 'Menunggu Pembayaran', '2026-07-01 16:06:10'),
(12, 1, 3, '2026-07-07', 1, 3500, 'Menunggu Pembayaran', '2026-07-07 15:50:07'),
(13, 1, 3, '2026-07-07', 1, 3500, 'Menunggu Pembayaran', '2026-07-07 16:28:29'),
(14, 1, 1, '2026-07-07', 1, 350000, 'Menunggu Pembayaran', '2026-07-07 16:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_profile`
--

CREATE TABLE `tabel_profile` (
  `id` int(11) NOT NULL,
  `nama_pt` varchar(100) NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_profile`
--

INSERT INTO `tabel_profile` (`id`, `nama_pt`, `visi`, `misi`, `deskripsi`) VALUES
(1, 'ADMIN BIS KECE ANTAR KAMPUS', 'Membuat Website Sederhana Untuk Pemesanan Tiket Bis Antar Kampus', '1. Memberikan pelayanan prima secara konsisten.\r\n2. Meremajakan armada bus secara berkala.\r\n3. Mengutamakan keselamatan penumpang.', 'PO. Trans Maju Jaya adalah perusahaan otobus terkemuka yang bergerak di bidang transportasi Antar Kota Antar Provinsi (AKAP). Kami melayani berbagai rute strategis dengan armada bus modern berfasilitas lengkap.');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_rute`
--

CREATE TABLE `tabel_rute` (
  `id_rute` int(11) NOT NULL,
  `asal` varchar(50) NOT NULL,
  `tujuan` varchar(50) NOT NULL,
  `jam` time DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `id_bus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_rute`
--

INSERT INTO `tabel_rute` (`id_rute`, `asal`, `tujuan`, `jam`, `harga`, `id_bus`) VALUES
(1, 'Jakarta', 'Surabaya', '01:58:00', 350000, 1),
(2, 'Jakarta', 'Yogyakarta', NULL, 3000000, NULL),
(3, 'BINTARO', 'CILEDUG', NULL, 3500, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_testimoni`
--

CREATE TABLE `tabel_testimoni` (
  `id_testi` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `komentar` text NOT NULL,
  `rating` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `balasan_admin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_testimoni`
--

INSERT INTO `tabel_testimoni` (`id_testi`, `nama_user`, `komentar`, `rating`, `tgl`, `status`, `balasan_admin`) VALUES
(1, 'Budi Santoso', 'Busnya sangat bersih, tepat waktu, dan sopirnya mengemudi dengan sangat aman!', 5, NULL, 'aktif', NULL),
(2, 'Siti Aminah', 'Pelayanan admin di terminal ramah, suspensi bus empuk jadi nyaman buat tidur.', 4, NULL, 'aktif', NULL),
(3, 'nabil', 'keren\r\n', 5, NULL, 'aktif', NULL),
(4, 'nabil', '123', 5, '2026-07-07', 'Pending', NULL),
(5, 'nabil', '12', 5, '2026-07-07', 'Aktif', 'we');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_user`
--

CREATE TABLE `tabel_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_user`
--

INSERT INTO `tabel_user` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator Utama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `tabel_bus`
--
ALTER TABLE `tabel_bus`
  ADD PRIMARY KEY (`id_bus`);

--
-- Indexes for table `tabel_pelanggan`
--
ALTER TABLE `tabel_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tabel_pesanan`
--
ALTER TABLE `tabel_pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `tabel_profile`
--
ALTER TABLE `tabel_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabel_rute`
--
ALTER TABLE `tabel_rute`
  ADD PRIMARY KEY (`id_rute`);

--
-- Indexes for table `tabel_testimoni`
--
ALTER TABLE `tabel_testimoni`
  ADD PRIMARY KEY (`id_testi`);

--
-- Indexes for table `tabel_user`
--
ALTER TABLE `tabel_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_berita`
--
ALTER TABLE `tabel_berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tabel_bus`
--
ALTER TABLE `tabel_bus`
  MODIFY `id_bus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tabel_pelanggan`
--
ALTER TABLE `tabel_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tabel_pesanan`
--
ALTER TABLE `tabel_pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tabel_rute`
--
ALTER TABLE `tabel_rute`
  MODIFY `id_rute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tabel_testimoni`
--
ALTER TABLE `tabel_testimoni`
  MODIFY `id_testi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tabel_user`
--
ALTER TABLE `tabel_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
