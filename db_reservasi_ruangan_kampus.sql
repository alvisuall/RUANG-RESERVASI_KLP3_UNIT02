-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 11:40 AM
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
-- Database: `db_reservasi_ruangan_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nim_nip` varchar(30) DEFAULT NULL,
  `jenis_pengguna` enum('mahasiswa','dosen','tendik','organisasi','umum') DEFAULT 'mahasiswa',
  `fakultas_unit` varchar(100) DEFAULT NULL,
  `prodi_bagian` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `nim_nip`, `jenis_pengguna`, `fakultas_unit`, `prodi_bagian`, `email`, `no_hp`, `alamat`, `created_at`) VALUES
(1, 'Ridwan Maulana', '20260001', 'mahasiswa', 'Fakultas Tarbiyah dan Keguruan', 'Pendidikan Teknologi Informasi', 'ridwan@student.ac.id', '081234567890', NULL, '2026-07-01 02:03:38'),
(2, 'Dr. Ahmad Zaini', '198701012020121001', 'dosen', 'Fakultas Sains dan Teknologi', 'Informatika', 'ahmad@kampus.ac.id', '082233445566', NULL, '2026-07-01 02:03:38'),
(3, 'HMPS PTI', 'ORG001', 'organisasi', 'Fakultas Tarbiyah dan Keguruan', 'Organisasi Mahasiswa', 'hmpspti@kampus.ac.id', '085277889900', NULL, '2026-07-01 02:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_ruangan`
--

CREATE TABLE `reservasi_ruangan` (
  `id_reservasi` int(11) NOT NULL,
  `kode_reservasi` varchar(30) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `email_pemesan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `tanggal_reservasi` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keperluan` varchar(150) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah_peserta` int(11) DEFAULT 1,
  `status_reservasi` enum('menunggu','disetujui','ditolak','selesai','dibatalkan') DEFAULT 'menunggu',
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasi_ruangan`
--

INSERT INTO `reservasi_ruangan` (`id_reservasi`, `kode_reservasi`, `id_ruangan`, `id_pengguna`, `nama_pemesan`, `email_pemesan`, `no_hp`, `tanggal_reservasi`, `jam_mulai`, `jam_selesai`, `keperluan`, `keterangan`, `jumlah_peserta`, `status_reservasi`, `catatan_admin`, `created_at`) VALUES
(1, 'RSV-2026-001', 1, 1, 'Ridwan Maulana', 'ridwan@student.ac.id', '081234567890', '2026-07-05', '08:00:00', '10:00:00', 'Diskusi Kelompok Mata Kuliah', 'Kegiatan diskusi mahasiswa semester 4', 25, 'disetujui', NULL, '2026-07-01 02:03:38'),
(2, 'RSV-2026-002', 2, 2, 'Dr. Ahmad Zaini', 'ahmad@kampus.ac.id', '082233445566', '2026-07-06', '09:00:00', '12:00:00', 'Praktikum Pemrograman Web', 'Kelas praktikum reguler', 30, 'menunggu', NULL, '2026-07-01 02:03:38'),
(3, 'RSV-2026-003', 3, 3, 'HMPS PTI', 'hmpspti@kampus.ac.id', '085277889900', '2026-07-10', '13:00:00', '16:00:00', 'Seminar Teknologi Pendidikan', 'Seminar terbuka mahasiswa', 180, 'disetujui', NULL, '2026-07-01 02:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `kode_ruangan` varchar(20) NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `gedung` varchar(100) NOT NULL,
  `lantai` varchar(20) DEFAULT NULL,
  `kapasitas` int(11) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `status_ruangan` enum('tersedia','perawatan','tidak_aktif') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `kode_ruangan`, `nama_ruangan`, `gedung`, `lantai`, `kapasitas`, `fasilitas`, `status_ruangan`, `created_at`) VALUES
(1, 'R-A101', 'Ruang Kuliah A101', 'Gedung A', '1', 40, 'AC, LCD Projector, Whiteboard, WiFi', 'tersedia', '2026-07-01 02:03:38'),
(2, 'LAB-PTI', 'Laboratorium Komputer PTI', 'Gedung Laboratorium', '2', 35, 'Komputer, AC, Projector, Internet, Sound System', 'tersedia', '2026-07-01 02:03:38'),
(3, 'AULA-01', 'Aula Utama Kampus', 'Gedung Rektorat', '1', 250, 'Panggung, Sound System, Projector, Kursi Seminar', 'tersedia', '2026-07-01 02:03:38'),
(4, 'R-B205', 'Ruang Seminar B205', 'Gedung B', '2', 60, 'AC, Smart TV, Whiteboard, WiFi', 'perawatan', '2026-07-01 02:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','petugas','pengguna') DEFAULT 'pengguna',
  `status_akun` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id_user`, `nama_lengkap`, `username`, `email`, `password_hash`, `role`, `status_akun`, `created_at`) VALUES
(1, 'Administrator Kampus', 'admin', 'admin@kampus.ac.id', '$2y$10$nlMBTWo5YZR46ndqzChD/uDhgOJ350.P17vZO.pmQpWJRvvBejleq', 'admin', 'aktif', '2026-07-01 02:03:38'),
(2, 'Petugas Sarpras', 'petugas', 'sarpras@kampus.ac.id', '$2y$10$8jVsyyHCl67.ZwY5Q30QEeNG92avAG0Fnhh/Z8vQhuzx..sLow4ni', 'petugas', 'aktif', '2026-07-01 02:03:38'),
(3, 'Mahasiswa Demo', 'mahasiswa', 'mahasiswa@kampus.ac.id', '$2y$10$MI.f/M/iSynEYs5fdaiLT.1.SDs/WR/5ig9Juq/XlDGNNKqIod6MW', 'pengguna', 'aktif', '2026-07-01 02:03:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `nim_nip` (`nim_nip`);

--
-- Indexes for table `reservasi_ruangan`
--
ALTER TABLE `reservasi_ruangan`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD UNIQUE KEY `kode_reservasi` (`kode_reservasi`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `idx_reservasi_tanggal` (`tanggal_reservasi`),
  ADD KEY `idx_reservasi_status` (`status_reservasi`),
  ADD KEY `idx_reservasi_ruangan` (`id_ruangan`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD UNIQUE KEY `kode_ruangan` (`kode_ruangan`),
  ADD KEY `idx_ruangan_nama` (`nama_ruangan`),
  ADD KEY `idx_ruangan_gedung` (`gedung`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservasi_ruangan`
--
ALTER TABLE `reservasi_ruangan`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservasi_ruangan`
--
ALTER TABLE `reservasi_ruangan`
  ADD CONSTRAINT `reservasi_ruangan_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservasi_ruangan_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
