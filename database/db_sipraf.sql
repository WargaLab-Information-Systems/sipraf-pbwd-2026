<<<<<<< HEAD
CREATE TABLE users_table (

    id INT PRIMARY KEY AUTO_INCREMENT,

    username VARCHAR(100),

    email VARCHAR(100)

);

CREATE TABLE facility (

    id INT PRIMARY KEY AUTO_INCREMENT,

    facility_name VARCHAR(100)

);

CREATE TABLE reservation (

    id INT PRIMARY KEY AUTO_INCREMENT,

    reservation_date DATE,

    facility_name VARCHAR(100)

);

CREATE TABLE approval (

    id INT PRIMARY KEY AUTO_INCREMENT,

    status VARCHAR(50)

);

INSERT INTO users_table(username, email)
VALUES
('sultan', 'sultan@gmail.com'),
('admin', 'admin@gmail.com');

INSERT INTO facility(facility_name)
VALUES
('Aula'),
('Ruang Meeting'),
('Lab Komputer');

INSERT INTO reservation(reservation_date, facility_name)
VALUES
('2026-05-20', 'Aula'),
('2026-05-21', 'Ruang Meeting'),
('2026-05-22', 'Lab Komputer');

INSERT INTO approval(status)
VALUES
('Approved'),
('Pending');
=======
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2026 at 12:37 PM
-- Server version: 9.6.0
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sipraf`
CREATE DATABASE IF NOT EXISTS db_sipraf;
USE db_sipraf;
-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` int NOT NULL,
  `reservation_id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` enum('disetujui','ditolak') NOT NULL,
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id`, `reservation_id`, `user_id`, `status`, `notes`, `created_at`) VALUES
(1, 2, 5, 'disetujui', 'Disetujui, kembalikan fasilitas tepat waktu.', '2026-05-19 12:35:26'),
(2, 4, 3, 'ditolak', 'Tidak memenuhi prosedur peminjaman.', '2026-05-19 12:35:26'),
(3, 5, 3, 'disetujui', 'Jadwal tersedia, silakan gunakan fasilitas.', '2026-05-19 12:35:26'),
(4, 6, 3, 'disetujui', 'Jadwal tersedia, silakan gunakan fasilitas.', '2026-05-19 12:35:26'),
(5, 8, 2, 'disetujui', 'Disetujui, harap jaga kebersihan ruangan.', '2026-05-19 12:35:26'),
(6, 11, 5, 'ditolak', 'Tidak memenuhi prosedur peminjaman.', '2026-05-19 12:35:26'),
(7, 14, 6, 'disetujui', 'Pengajuan memenuhi syarat, disetujui.', '2026-05-19 12:35:26'),
(8, 15, 6, 'disetujui', 'Disetujui, kembalikan fasilitas tepat waktu.', '2026-05-19 12:35:26'),
(9, 16, 3, 'ditolak', 'Fasilitas sudah dipesan oleh pihak lain.', '2026-05-19 12:35:26'),
(10, 19, 6, 'ditolak', 'Tidak memenuhi prosedur peminjaman.', '2026-05-19 12:35:26'),
(11, 20, 3, 'disetujui', 'Disetujui, koordinasi dengan pengelola gedung.', '2026-05-19 12:35:26'),
(12, 21, 4, 'disetujui', 'Disetujui, koordinasi dengan pengelola gedung.', '2026-05-19 12:35:26'),
(13, 22, 5, 'disetujui', 'Disetujui, koordinasi dengan pengelola gedung.', '2026-05-19 12:35:26'),
(14, 23, 3, 'ditolak', 'Jadwal bentrok dengan kegiatan lain.', '2026-05-19 12:35:26'),
(15, 24, 5, 'disetujui', 'Fasilitas tersedia pada waktu yang diminta.', '2026-05-19 12:35:26'),
(16, 25, 3, 'disetujui', 'Disetujui, koordinasi dengan pengelola gedung.', '2026-05-19 12:35:26'),
(17, 26, 6, 'ditolak', 'Pengajuan tidak disertai keterangan yang jelas.', '2026-05-19 12:35:26'),
(18, 27, 2, 'disetujui', 'Fasilitas tersedia pada waktu yang diminta.', '2026-05-19 12:35:26'),
(19, 28, 6, 'disetujui', 'Fasilitas tersedia pada waktu yang diminta.', '2026-05-19 12:35:26'),
(20, 30, 2, 'ditolak', 'Fasilitas sudah dipesan oleh pihak lain.', '2026-05-19 12:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `kategori` enum('lab','ruang','barang') NOT NULL,
  `kapasitas` int DEFAULT '0',
  `deskripsi` text,
  `status` enum('tersedia','dipinjam') DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `kategori`, `kapasitas`, `deskripsi`, `status`, `created_at`) VALUES
(1, 'RKBF 204', 'ruang', 40, 'Ruang kelas lantai 2 gedung B Fakultas', 'tersedia', '2026-05-19 12:29:19'),
(2, 'RKBF 307', 'ruang', 40, 'Ruang kelas lantai 3 gedung B Fakultas', 'tersedia', '2026-05-19 12:29:19'),
(3, 'RKBF 308', 'ruang', 40, 'Ruang kelas lantai 3 gedung B Fakultas', 'tersedia', '2026-05-19 12:29:19'),
(4, 'RKBF 407', 'ruang', 40, 'Ruang kelas lantai 4 gedung B Fakultas', 'tersedia', '2026-05-19 12:29:19'),
(5, 'RKBF 408', 'ruang', 40, 'Ruang kelas lantai 4 gedung B Fakultas', 'tersedia', '2026-05-19 12:29:19'),
(6, 'Lab BIS', 'lab', 30, 'Laboratorium Bisnis dan Sistem Informasi', 'tersedia', '2026-05-19 12:29:19'),
(7, 'Lab TI', 'lab', 30, 'Laboratorium Teknologi Informasi', 'tersedia', '2026-05-19 12:29:19'),
(8, 'Proyektor 01', 'barang', 1, 'Proyektor portable unit 01', 'tersedia', '2026-05-19 12:29:19'),
(9, 'Proyektor 02', 'barang', 1, 'Proyektor portable unit 02', 'tersedia', '2026-05-19 12:29:19'),
(10, 'Switch 01', 'barang', 1, 'Network switch manageable unit 01', 'tersedia', '2026-05-19 12:29:19'),
(11, 'Switch 02', 'barang', 1, 'Network switch manageable unit 02', 'tersedia', '2026-05-19 12:29:19'),
(12, 'Router 01', 'barang', 1, 'Router jaringan unit 01', 'tersedia', '2026-05-19 12:29:19'),
(13, 'Router 02', 'barang', 1, 'Router jaringan unit 02', 'tersedia', '2026-05-19 12:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `facility_id` int NOT NULL,
  `notes` text,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('diajukan','disetujui','ditolak','dibatalkan') DEFAULT 'diajukan',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `facility_id`, `notes`, `tanggal`, `jam_mulai`, `jam_selesai`, `status`, `created_at`) VALUES
(1, 7, 1, 'Pertemuan organisasi mahasiswa', '2026-05-24', '11:00:00', '13:00:00', 'diajukan', '2026-05-19 12:31:58'),
(2, 8, 12, 'Praktikum mata kuliah jaringan', '2026-05-04', '15:00:00', '17:00:00', 'disetujui', '2026-05-19 12:31:58'),
(3, 10, 1, 'Pertemuan organisasi mahasiswa', '2026-05-01', '07:00:00', '09:00:00', 'diajukan', '2026-05-19 12:31:58'),
(4, 11, 10, 'Pertemuan organisasi mahasiswa', '2026-05-01', '15:00:00', '17:00:00', 'ditolak', '2026-05-19 12:31:58'),
(5, 11, 7, 'Persiapan lomba IT', '2026-05-08', '13:00:00', '15:00:00', 'disetujui', '2026-05-19 12:31:58'),
(6, 7, 13, 'Seminar mini jurusan', '2026-05-26', '09:00:00', '11:00:00', 'disetujui', '2026-05-19 12:31:58'),
(7, 9, 3, 'Praktikum mata kuliah jaringan', '2026-05-07', '11:00:00', '13:00:00', 'diajukan', '2026-05-19 12:31:58'),
(8, 10, 2, 'Persiapan lomba IT', '2026-05-12', '11:00:00', '13:00:00', 'disetujui', '2026-05-19 12:31:58'),
(9, 7, 12, 'Praktikum mata kuliah jaringan', '2026-05-15', '15:00:00', '17:00:00', 'dibatalkan', '2026-05-19 12:31:58'),
(10, 10, 2, 'Persiapan lomba IT', '2026-05-18', '11:00:00', '13:00:00', 'dibatalkan', '2026-05-19 12:31:58'),
(11, 9, 10, 'Rapat koordinasi kepanitiaan', '2026-05-07', '07:00:00', '09:00:00', 'ditolak', '2026-05-19 12:31:58'),
(12, 8, 13, 'Pertemuan organisasi mahasiswa', '2026-05-10', '07:00:00', '09:00:00', 'dibatalkan', '2026-05-19 12:31:58'),
(13, 7, 7, 'Latihan debat mahasiswa', '2026-05-09', '13:00:00', '15:00:00', 'diajukan', '2026-05-19 12:31:58'),
(14, 9, 6, 'Praktikum mata kuliah jaringan', '2026-05-07', '11:00:00', '13:00:00', 'disetujui', '2026-05-19 12:31:58'),
(15, 8, 9, 'Diskusi kelompok tugas akhir', '2026-05-24', '09:00:00', '11:00:00', 'disetujui', '2026-05-19 12:31:58'),
(16, 10, 5, 'Pertemuan organisasi mahasiswa', '2026-05-30', '15:00:00', '17:00:00', 'ditolak', '2026-05-19 12:31:58'),
(17, 9, 13, 'Pertemuan organisasi mahasiswa', '2026-05-25', '07:00:00', '09:00:00', 'dibatalkan', '2026-05-19 12:31:58'),
(18, 7, 13, 'Presentasi proyek semester', '2026-05-11', '13:00:00', '15:00:00', 'diajukan', '2026-05-19 12:31:58'),
(19, 8, 10, 'Pertemuan organisasi mahasiswa', '2026-05-29', '11:00:00', '13:00:00', 'ditolak', '2026-05-19 12:31:58'),
(20, 10, 7, 'Diskusi kelompok tugas akhir', '2026-05-29', '13:00:00', '15:00:00', 'disetujui', '2026-05-19 12:31:58'),
(21, 8, 4, 'Ujian praktikum susulan', '2026-05-24', '15:00:00', '17:00:00', 'disetujui', '2026-05-19 12:31:58'),
(22, 11, 7, 'Seminar mini jurusan', '2026-05-29', '15:00:00', '17:00:00', 'disetujui', '2026-05-19 12:31:58'),
(23, 8, 3, 'Praktikum mata kuliah jaringan', '2026-05-17', '13:00:00', '15:00:00', 'ditolak', '2026-05-19 12:31:58'),
(24, 7, 2, 'Seminar mini jurusan', '2026-05-05', '09:00:00', '11:00:00', 'disetujui', '2026-05-19 12:31:58'),
(25, 7, 7, 'Workshop pemrograman', '2026-05-13', '15:00:00', '17:00:00', 'disetujui', '2026-05-19 12:31:58'),
(26, 9, 9, 'Praktikum mata kuliah jaringan', '2026-05-28', '07:00:00', '09:00:00', 'ditolak', '2026-05-19 12:31:58'),
(27, 11, 13, 'Praktikum mata kuliah jaringan', '2026-05-09', '11:00:00', '13:00:00', 'disetujui', '2026-05-19 12:31:58'),
(28, 10, 3, 'Presentasi proyek semester', '2026-05-15', '07:00:00', '09:00:00', 'disetujui', '2026-05-19 12:31:58'),
(29, 8, 9, 'Presentasi proyek semester', '2026-05-30', '07:00:00', '09:00:00', 'dibatalkan', '2026-05-19 12:31:58'),
(30, 11, 10, 'Latihan debat mahasiswa', '2026-05-07', '09:00:00', '11:00:00', 'ditolak', '2026-05-19 12:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','supervisor','borrower') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `foto`, `created_at`) VALUES
(1, 'Admin SIPRAF', 'admin@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'admin', NULL, '2026-05-19 12:25:47'),
(2, 'Reza Firmansyah', 'reza.firmansyah@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'supervisor', NULL, '2026-05-19 12:25:47'),
(3, 'Dewi Kusuma', 'dewi.kusuma@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'supervisor', NULL, '2026-05-19 12:25:47'),
(4, 'Hendra Saputra', 'hendra.saputra@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'supervisor', NULL, '2026-05-19 12:25:47'),
(5, 'Siti Rahayu', 'siti.rahayu@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'supervisor', NULL, '2026-05-19 12:25:47'),
(6, 'Bagas Wicaksono', 'bagas.wicaksono@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'supervisor', NULL, '2026-05-19 12:25:47'),
(7, 'Fajar Nugroho', 'fajar.nugroho@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'borrower', NULL, '2026-05-19 12:25:47'),
(8, 'Anisa Putri', 'anisa.putri@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'borrower', NULL, '2026-05-19 12:25:47'),
(9, 'Dimas Ardiansyah', 'dimas.ardiansyah@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'borrower', NULL, '2026-05-19 12:25:47'),
(10, 'Laila Maharani', 'laila.maharani@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'borrower', NULL, '2026-05-19 12:25:47'),
(11, 'Rizky Pratama', 'rizky.pratama@sipraf.com', 'da0cc0d2a8e07b7fb902836e5a415c54', 'borrower', NULL, '2026-05-19 12:25:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `approvals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> origin/main
