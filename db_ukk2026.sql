-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 07:26 AM
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
-- Database: `db_ukk2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '198001012005011001', 'Admin Utama', 'admin@school.sch.id', 1, 1, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(2, '198001012005011002', 'Guru BK 1', 'bk1@school.sch.id', 1, 2, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(3, '198001012005011003', 'Guru BK 2', 'bk2@school.sch.id', 1, 3, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(4, '198001012005011004', 'Budi Santoso', 'budi.santoso@school.sch.id', 1, 4, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(5, '198001012005011005', 'Siti Aminah', 'siti.aminah@school.sch.id', 1, 5, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(6, '198001012005011006', 'Agus Setiawan', 'agus.setiawan@school.sch.id', 1, 6, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(7, '198001012005011007', 'Dewi Lestari', 'dewi.lestari@school.sch.id', 1, 7, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(8, '198001012005011008', 'Eko Prasetyo', 'eko.prasetyo@school.sch.id', 1, 8, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(9, '198001012005011009', 'Fitriani', 'fitriani@school.sch.id', 1, 9, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(10, '198001012005011010', 'Hendra Wijaya', 'hendra.wijaya@school.sch.id', 1, 10, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(11, '198001012005011011', 'Indah Permata', 'indah.permata@school.sch.id', 1, 11, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(12, '198001012005011012', 'Joko Widodo', 'joko.widodo@school.sch.id', 1, 12, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(13, '198001012005011013', 'Kurniawan', 'kurniawan@school.sch.id', 1, 13, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(14, '198001012005011014', 'Lestari Ayu', 'lestari.ayu@school.sch.id', 1, 14, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(15, '198001012005011015', 'M. Rizky', 'm.rizky@school.sch.id', 1, 15, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(16, '198001012005011016', 'Nur Hidayah', 'nur.hidayah@school.sch.id', 1, 16, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(17, '198001012005011017', 'Oktavia', 'oktavia@school.sch.id', 1, 17, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(18, '198001012005011018', 'Pratama', 'pratama@school.sch.id', 1, 18, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(19, '198001012005011019', 'Qori', 'qori@school.sch.id', 1, 19, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(20, '198001012005011020', 'Rahmat', 'rahmat@school.sch.id', 1, 20, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(21, '198001012005011021', 'Sari', 'sari@school.sch.id', 1, 21, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(22, '198001012005011022', 'Taufik', 'taufik@school.sch.id', 1, 22, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(23, '198001012005011023', 'Utami', 'utami@school.sch.id', 1, 23, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(24, '198001012005011024', 'Vina', 'vina@school.sch.id', 1, 24, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(25, '198001012005011025', 'Wahyu', 'wahyu@school.sch.id', 1, 25, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(26, '198001012005011026', 'Xavier', 'xavier@school.sch.id', 1, 26, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(27, '198001012005011027', 'Yuli', 'yuli@school.sch.id', 1, 27, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(28, '198001012005011028', 'Zainal', 'zainal@school.sch.id', 1, 28, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(29, '198001012005011029', 'Guru 29', 'guru29@school.sch.id', 1, 29, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(30, '198001012005011030', 'Guru 30', 'guru30@school.sch.id', 1, 30, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(31, '198001012005011031', 'Guru 31', 'guru31@school.sch.id', 1, 31, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(32, '198001012005011032', 'Guru 32', 'guru32@school.sch.id', 1, 32, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(33, '198001012005011033', 'Guru 33', 'guru33@school.sch.id', 1, 33, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(34, '198001012005011034', 'Guru 34', 'guru34@school.sch.id', 1, 34, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(35, '198001012005011035', 'Guru 35', 'guru35@school.sch.id', 1, 35, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(36, '198001012005011036', 'Guru 36', 'guru36@school.sch.id', 1, 36, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(37, '198001012005011037', 'Guru 37', 'guru37@school.sch.id', 1, 37, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(38, '198001012005011038', 'Guru 38', 'guru38@school.sch.id', 1, 38, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(39, '198001012005011039', 'Guru 39', 'guru39@school.sch.id', 1, 39, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(40, '198001012005011040', 'Guru 40', 'guru40@school.sch.id', 1, 40, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(41, '198001012005011041', 'Guru 41', 'guru41@school.sch.id', 1, 41, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(42, '198001012005011042', 'Guru 42', 'guru42@school.sch.id', 1, 42, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(43, '198001012005011043', 'Guru 43', 'guru43@school.sch.id', 1, 43, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(44, '198001012005011044', 'Guru 44', 'guru44@school.sch.id', 1, 44, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(45, '198001012005011045', 'Guru 45', 'guru45@school.sch.id', 1, 45, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(46, '198001012005011046', 'Guru 46', 'guru46@school.sch.id', 1, 46, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(47, '198001012005011047', 'Guru 47', 'guru47@school.sch.id', 1, 47, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(48, '198001012005011048', 'Guru 48', 'guru48@school.sch.id', 1, 48, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(49, '198001012005011049', 'Guru 49', 'guru49@school.sch.id', 1, 49, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(50, '198001012005011050', 'Guru 50', 'guru50@school.sch.id', 1, 50, '2026-09-23 03:40:51', '2026-09-23 03:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'X RPL 1', '10', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, 'X RPL 2', '10', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, 'XI RPL 1', '11', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, 'XI RPL 2', '11', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, 'XII RPL 1', '12', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, 'XII RPL 2', '12', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, 'X TKJ 1', '10', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, 'X TKJ 2', '10', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, 'XI TKJ 1', '11', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, 'XI TKJ 2', '11', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, 'XII TKJ 1', '12', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, 'XII TKJ 2', '12', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, 'X MM 1', '10', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, 'X MM 2', '10', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, 'XI MM 1', '11', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, 'XI MM 2', '11', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, 'XII MM 1', '12', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, 'XII MM 2', '12', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, 'X AKL 1', '10', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, 'X AKL 2', '10', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, 'XI AKL 1', '11', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, 'XI AKL 2', '11', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, 'XII AKL 1', '12', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, 'XII AKL 2', '12', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, 'X OTKP 1', '10', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, 'X OTKP 2', '10', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, 'XI OTKP 1', '11', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, 'XI OTKP 2', '11', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, 'XII OTKP 1', '12', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, 'XII OTKP 2', '12', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, 'X BDP 1', '10', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, 'X BDP 2', '10', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, 'XI BDP 1', '11', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, 'XI BDP 2', '11', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, 'XII BDP 1', '12', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, 'XII BDP 2', '12', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, 'X TKR 1', '10', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, 'X TKR 2', '10', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, 'XI TKR 1', '11', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, 'XI TKR 2', '11', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, 'XII TKR 1', '12', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, 'XII TKR 2', '12', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, 'X TBSM 1', '10', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, 'X TBSM 2', '10', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, 'XI TBSM 1', '11', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, 'XI TBSM 2', '11', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, 'XII TBSM 1', '12', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, 'XII TBSM 2', '12', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, 'X DKV 1', '10', 'DKV', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, 'X DKV 2', '10', 'DKV', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'PLG-001', 'Datang Terlambat < 15 Menit', 5, 'Siswa terlambat datang ke sekolah kurang dari 15 menit', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(2, 1, 'PLG-002', 'Datang Terlambat > 15 Menit', 10, 'Siswa terlambat datang lebih dari 15 menit', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(3, 1, 'PLG-003', 'Alpa / Tidak Hadir Tanpa Keterangan', 15, 'Siswa tidak masuk sekolah tanpa surat izin', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(4, 2, 'PLG-004', 'Atribut Seragam Tidak Lengkap', 5, 'Tidak memakai dasi/sabuk/kaos kaki sesuai ketentuan', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(5, 2, 'PLG-005', 'Seragam Tidak Sesuai Hari', 10, 'Memakai seragam yang salah pada hari jadwalnya', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(6, 2, 'PLG-006', 'Rambut Panjang / Tidak Rapi (Putra)', 10, 'Ukuran rambut melebihi batas ketentuan sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(7, 3, 'PLG-007', 'Meninggalkan Kelas Saat Jam Pelajaran', 15, 'Bolos kelas saat KBM berlangsung', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(8, 3, 'PLG-008', 'Tidak Mengumpulkan Tugas', 5, 'Tidak mengerjakan tugas dari guru mapel', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(9, 4, 'PLG-009', 'Berkata Kasar / Tidak Sopan', 10, 'Ucap kata tidak pantas di lingkungan sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(10, 5, 'PLG-010', 'Main Game Saat Jam Pelajaran', 10, 'Menggunakan HP untuk game tanpa izin guru', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(11, 6, 'PLG-011', 'Membuang Sampah Sembarangan', 5, 'Membuang sampah bukan pada tempatnya', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(12, 7, 'PLG-012', 'Membawa Rokok / Vape', 25, 'Ketahuan membawa rokok atau vape ke sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(13, 7, 'PLG-013', 'Merokok / Vape di Sekolah', 50, 'Merokok atau menggunakan vape di area sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(14, 9, 'PLG-014', 'Melakukan Bullying Verbal', 30, 'Melakukan perundungan secara lisan ke teman', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(15, 9, 'PLG-015', 'Melakukan Perkelahian', 75, 'Terlibat kontak fisik/berkelahi di sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(16, 8, 'PLG-016', 'Membawa Miras', 100, 'Membawa minuman keras ke sekolah', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(17, 1, 'PLG-017', 'Melompat Pagar Sekolah', 25, 'Kabur dari sekolah dengan memanjat pagar', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(18, 2, 'PLG-018', 'Memakai Perhiasan Berlebihan', 5, 'Siswa memakai perhiasan tidak wajar', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(19, 2, 'PLG-019', 'Mewarnai Rambut', 15, 'Mengecat rambut selain warna hitam', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(20, 6, 'PLG-020', 'Mencoret Fasilitas Sekolah', 20, 'Coret-coret meja, kursi, atau tembok', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(21, 1, 'PLG-021', 'Pelanggaran Poin 21', 5, 'Deskripsi pelanggaran 21', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(22, 2, 'PLG-022', 'Pelanggaran Poin 22', 10, 'Deskripsi pelanggaran 22', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(23, 3, 'PLG-023', 'Pelanggaran Poin 23', 15, 'Deskripsi pelanggaran 23', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(24, 4, 'PLG-024', 'Pelanggaran Poin 24', 20, 'Deskripsi pelanggaran 24', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(25, 5, 'PLG-025', 'Pelanggaran Poin 25', 25, 'Deskripsi pelanggaran 25', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(26, 6, 'PLG-026', 'Pelanggaran Poin 26', 30, 'Deskripsi pelanggaran 26', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(27, 7, 'PLG-027', 'Pelanggaran Poin 27', 35, 'Deskripsi pelanggaran 27', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(28, 8, 'PLG-028', 'Pelanggaran Poin 28', 40, 'Deskripsi pelanggaran 28', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(29, 9, 'PLG-029', 'Pelanggaran Poin 29', 45, 'Deskripsi pelanggaran 29', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(30, 10, 'PLG-030', 'Pelanggaran Poin 30', 50, 'Deskripsi pelanggaran 30', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(31, 11, 'PLG-031', 'Pelanggaran Poin 31', 5, 'Deskripsi pelanggaran 31', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(32, 12, 'PLG-032', 'Pelanggaran Poin 32', 10, 'Deskripsi pelanggaran 32', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(33, 13, 'PLG-033', 'Pelanggaran Poin 33', 15, 'Deskripsi pelanggaran 33', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(34, 14, 'PLG-034', 'Pelanggaran Poin 34', 20, 'Deskripsi pelanggaran 34', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(35, 15, 'PLG-035', 'Pelanggaran Poin 35', 25, 'Deskripsi pelanggaran 35', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(36, 16, 'PLG-036', 'Pelanggaran Poin 36', 30, 'Deskripsi pelanggaran 36', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(37, 17, 'PLG-037', 'Pelanggaran Poin 37', 35, 'Deskripsi pelanggaran 37', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(38, 18, 'PLG-038', 'Pelanggaran Poin 38', 40, 'Deskripsi pelanggaran 38', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(39, 19, 'PLG-039', 'Pelanggaran Poin 39', 45, 'Deskripsi pelanggaran 39', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(40, 20, 'PLG-040', 'Pelanggaran Poin 40', 50, 'Deskripsi pelanggaran 40', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(41, 21, 'PLG-041', 'Pelanggaran Poin 41', 5, 'Deskripsi pelanggaran 41', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(42, 22, 'PLG-042', 'Pelanggaran Poin 42', 10, 'Deskripsi pelanggaran 42', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(43, 23, 'PLG-043', 'Pelanggaran Poin 43', 15, 'Deskripsi pelanggaran 43', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(44, 24, 'PLG-044', 'Pelanggaran Poin 44', 20, 'Deskripsi pelanggaran 44', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(45, 25, 'PLG-045', 'Pelanggaran Poin 45', 25, 'Deskripsi pelanggaran 45', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(46, 26, 'PLG-046', 'Pelanggaran Poin 46', 30, 'Deskripsi pelanggaran 46', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(47, 27, 'PLG-047', 'Pelanggaran Poin 47', 35, 'Deskripsi pelanggaran 47', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(48, 28, 'PLG-048', 'Pelanggaran Poin 48', 40, 'Deskripsi pelanggaran 48', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(49, 29, 'PLG-049', 'Pelanggaran Poin 49', 45, 'Deskripsi pelanggaran 49', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52'),
(50, 30, 'PLG-050', 'Pelanggaran Poin 50', 50, 'Deskripsi pelanggaran 50', 1, '2026-09-23 03:40:52', '2026-09-23 03:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kerajinan', 'Pelanggaran terkait tingkat kehadiran dan keterlambatan', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, 'Kerapihan', 'Pelanggaran pakaian, seragam, dan penampilan fisik', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, 'Kedisiplinan', 'Pelanggaran aturan umum sekolah', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, 'Etika & Sopan Santun', 'Pelanggaran perilaku kepada guru/teman', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, 'Ketertiban', 'Pelanggaran ketenangan lingkungan belajar', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, 'Penggunaan Barang', 'Membawa/menggunakan barang terlarang di sekolah', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, 'Pelanggaran Berat', 'Tindakan pidana, rokok, miras, judi, narkoba', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, 'Kategori 8', 'Deskripsi Kategori Pelanggaran 8', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, 'Kategori 9', 'Deskripsi Kategori Pelanggaran 9', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, 'Kategori 10', 'Deskripsi Kategori Pelanggaran 10', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, 'Kategori 11', 'Deskripsi Kategori Pelanggaran 11', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, 'Kategori 12', 'Deskripsi Kategori Pelanggaran 12', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, 'Kategori 13', 'Deskripsi Kategori Pelanggaran 13', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, 'Kategori 14', 'Deskripsi Kategori Pelanggaran 14', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, 'Kategori 15', 'Deskripsi Kategori Pelanggaran 15', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, 'Kategori 16', 'Deskripsi Kategori Pelanggaran 16', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, 'Kategori 17', 'Deskripsi Kategori Pelanggaran 17', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, 'Kategori 18', 'Deskripsi Kategori Pelanggaran 18', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, 'Kategori 19', 'Deskripsi Kategori Pelanggaran 19', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, 'Kategori 20', 'Deskripsi Kategori Pelanggaran 20', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, 'Kategori 21', 'Deskripsi Kategori Pelanggaran 21', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, 'Kategori 22', 'Deskripsi Kategori Pelanggaran 22', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, 'Kategori 23', 'Deskripsi Kategori Pelanggaran 23', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, 'Kategori 24', 'Deskripsi Kategori Pelanggaran 24', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, 'Kategori 25', 'Deskripsi Kategori Pelanggaran 25', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, 'Kategori 26', 'Deskripsi Kategori Pelanggaran 26', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, 'Kategori 27', 'Deskripsi Kategori Pelanggaran 27', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, 'Kategori 28', 'Deskripsi Kategori Pelanggaran 28', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, 'Kategori 29', 'Deskripsi Kategori Pelanggaran 29', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, 'Kategori 30', 'Deskripsi Kategori Pelanggaran 30', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, 'Kategori 31', 'Deskripsi Kategori Pelanggaran 31', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, 'Kategori 32', 'Deskripsi Kategori Pelanggaran 32', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, 'Kategori 33', 'Deskripsi Kategori Pelanggaran 33', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, 'Kategori 34', 'Deskripsi Kategori Pelanggaran 34', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, 'Kategori 35', 'Deskripsi Kategori Pelanggaran 35', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, 'Kategori 36', 'Deskripsi Kategori Pelanggaran 36', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, 'Kategori 37', 'Deskripsi Kategori Pelanggaran 37', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, 'Kategori 38', 'Deskripsi Kategori Pelanggaran 38', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, 'Kategori 39', 'Deskripsi Kategori Pelanggaran 39', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, 'Kategori 40', 'Deskripsi Kategori Pelanggaran 40', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, 'Kategori 41', 'Deskripsi Kategori Pelanggaran 41', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, 'Kategori 42', 'Deskripsi Kategori Pelanggaran 42', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, 'Kategori 43', 'Deskripsi Kategori Pelanggaran 43', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, 'Kategori 44', 'Deskripsi Kategori Pelanggaran 44', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, 'Kategori 45', 'Deskripsi Kategori Pelanggaran 45', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, 'Kategori 46', 'Deskripsi Kategori Pelanggaran 46', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, 'Kategori 47', 'Deskripsi Kategori Pelanggaran 47', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, 'Kategori 48', 'Deskripsi Kategori Pelanggaran 48', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, 'Kategori 49', 'Deskripsi Kategori Pelanggaran 49', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, 'Kategori 50', 'Deskripsi Kategori Pelanggaran 50', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) DEFAULT NULL,
  `nama_pelanggaran` varchar(100) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '20230001', '0051234001', 'Ahmad Dani', 'L', '2006-05-12', 'Jl. Merdeka No. 1', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, '20230002', '0051234002', 'Bunga Citra', 'P', '2006-08-22', 'Jl. Mawar No. 2', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, '20230003', '0051234003', 'Cinta Laura', 'P', '2006-02-14', 'Jl. Melati No. 3', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, '20230004', '0051234004', 'Deni Sumargo', 'L', '2006-04-11', 'Jl. Anggrek No. 4', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, '20230005', '0051234005', 'Erlangga Putra', 'L', '2006-09-09', 'Jl. Dahlia No. 5', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, '20230006', '0051234006', 'Fatin Shidqia', 'P', '2006-07-30', 'Jl. Flamboyan No. 6', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, '20230007', '0051234007', 'Gading Marten', 'L', '2006-05-08', 'Jl. Kenanga No. 7', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, '20230008', '0051234008', 'Hesti Purwadinata', 'P', '2006-06-15', 'Jl. Kamboja No. 8', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, '20230009', '0051234009', 'Irfan Hakim', 'L', '2006-10-10', 'Jl. Tulip No. 9', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, '20230010', '0051234010', 'Jessica Mila', 'P', '2006-08-03', 'Jl. Lotus No. 10', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, '20230011', '0051234011', 'Kevin Sanjaya', 'L', '2006-08-02', 'Jl. Melati No. 11', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, '20230012', '0051234012', 'Luna Maya', 'P', '2006-08-26', 'Jl. Dahlia No. 12', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, '20230013', '0051234013', 'Marcell Darwin', 'L', '2006-08-05', 'Jl. Sakura No. 13', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, '20230014', '0051234014', 'Nabila Syakieb', 'P', '2006-11-18', 'Jl. Mawar No. 14', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, '20230015', '0051234015', 'Oeshman', 'L', '2006-01-01', 'Jl. Anggrek No. 15', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, '20230016', '0051234016', 'Prilly Latuconsina', 'P', '2006-10-15', 'Jl. Garam No. 16', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, '20230017', '0051234017', 'Qausar Harta', 'L', '2006-09-02', 'Jl. Gajah No. 17', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, '20230018', '0051234018', 'Raffi Ahmad', 'L', '2006-02-17', 'Jl. Andara No. 18', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, '20230019', '0051234019', 'Sule Sutisna', 'L', '2006-11-15', 'Jl. Sunda No. 19', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, '20230020', '0051234020', 'Titi Kamal', 'P', '2006-12-07', 'Jl. Melati No. 20', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, '20230021', '0051234021', 'Uus Rizky', 'L', '2006-12-23', 'Jl. Pelajar No. 21', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, '20230022', '0051234022', 'Vino G Bastian', 'L', '2006-03-24', 'Jl. Pemuda No. 22', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, '20230023', '0051234023', 'Wika Salim', 'P', '2006-02-26', 'Jl. Pahlawan No. 23', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, '20230024', '0051234024', 'Xiumin Rahmad', 'L', '2006-03-26', 'Jl. Kartini No. 24', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, '20230025', '0051234025', 'Yura Yunita', 'P', '2006-06-09', 'Jl. Sudirman No. 25', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, '20230026', '0051234026', 'Zaskia Gotik', 'P', '2006-04-27', 'Jl. MH Thamrin No. 26', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, '20230027', '0051234027', 'Siswa 27', 'L', '2006-01-27', 'Alamat Siswa 27', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, '20230028', '0051234028', 'Siswa 28', 'P', '2006-02-28', 'Alamat Siswa 28', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, '20230029', '0051234029', 'Siswa 29', 'L', '2006-03-29', 'Alamat Siswa 29', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, '20230030', '0051234030', 'Siswa 30', 'P', '2006-04-30', 'Alamat Siswa 30', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, '20230031', '0051234031', 'Siswa 31', 'L', '2006-05-01', 'Alamat Siswa 31', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, '20230032', '0051234032', 'Siswa 32', 'P', '2006-05-02', 'Alamat Siswa 32', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, '20230033', '0051234033', 'Siswa 33', 'L', '2006-05-03', 'Alamat Siswa 33', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, '20230034', '0051234034', 'Siswa 34', 'P', '2006-05-04', 'Alamat Siswa 34', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, '20230035', '0051234035', 'Siswa 35', 'L', '2006-05-05', 'Alamat Siswa 35', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, '20230036', '0051234036', 'Siswa 36', 'P', '2006-05-06', 'Alamat Siswa 36', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, '20230037', '0051234037', 'Siswa 37', 'L', '2006-05-07', 'Alamat Siswa 37', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, '20230038', '0051234038', 'Siswa 38', 'P', '2006-05-08', 'Alamat Siswa 38', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, '20230039', '0051234039', 'Siswa 39', 'L', '2006-05-09', 'Alamat Siswa 39', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, '20230040', '0051234040', 'Siswa 40', 'P', '2006-05-10', 'Alamat Siswa 40', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, '20230041', '0051234041', 'Siswa 41', 'L', '2006-05-11', 'Alamat Siswa 41', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, '20230042', '0051234042', 'Siswa 42', 'P', '2006-05-12', 'Alamat Siswa 42', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, '20230043', '0051234043', 'Siswa 43', 'L', '2006-05-13', 'Alamat Siswa 43', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, '20230044', '0051234044', 'Siswa 44', 'P', '2006-05-14', 'Alamat Siswa 44', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, '20230045', '0051234045', 'Siswa 45', 'L', '2006-05-15', 'Alamat Siswa 45', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, '20230046', '0051234046', 'Siswa 46', 'P', '2006-05-16', 'Alamat Siswa 46', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, '20230047', '0051234047', 'Siswa 47', 'L', '2006-05-17', 'Alamat Siswa 47', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, '20230048', '0051234048', 'Siswa 48', 'P', '2006-05-18', 'Alamat Siswa 48', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, '20230049', '0051234049', 'Siswa 49', 'L', '2006-05-19', 'Alamat Siswa 49', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, '20230050', '0051234050', 'Siswa 50', 'P', '2006-05-20', 'Alamat Siswa 50', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `updated_at`) VALUES
(1, '2001/2002', '2001-07-15', '2002-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, '2002/2003', '2002-07-15', '2003-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, '2003/2004', '2003-07-15', '2004-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, '2004/2005', '2004-07-15', '2005-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, '2005/2006', '2005-07-15', '2006-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, '2006/2007', '2006-07-15', '2007-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, '2007/2008', '2007-07-15', '2008-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, '2008/2009', '2008-07-15', '2009-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, '2009/2010', '2009-07-15', '2010-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, '2010/2011', '2010-07-15', '2011-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, '2011/2012', '2011-07-15', '2012-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, '2012/2013', '2012-07-15', '2013-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, '2013/2014', '2013-07-15', '2014-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, '2014/2015', '2014-07-15', '2015-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, '2015/2016', '2015-07-15', '2016-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, '2016/2017', '2016-07-15', '2017-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, '2017/2018', '2017-07-15', '2018-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, '2018/2019', '2018-07-15', '2019-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, '2019/2020', '2019-07-15', '2020-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, '2020/2021', '2020-07-15', '2021-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, '2021/2022', '2021-07-15', '2022-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, '2022/2023', '2022-07-15', '2023-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, '2023/2024', '2023-07-15', '2024-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, '2024/2025', '2024-07-15', '2025-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, '2025/2026', '2025-07-15', '2026-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, '2026/2027', '2026-07-15', '2027-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, '2027/2028', '2027-07-15', '2028-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, '2028/2029', '2028-07-15', '2029-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, '2029/2030', '2029-07-15', '2030-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, '2030/2031', '2030-07-15', '2031-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, '2031/2032', '2031-07-15', '2032-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, '2032/2033', '2032-07-15', '2033-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, '2033/2034', '2033-07-15', '2034-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, '2034/2035', '2034-07-15', '2035-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, '2035/2036', '2035-07-15', '2036-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, '2036/2037', '2036-07-15', '2037-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, '2037/2038', '2037-07-15', '2038-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, '2038/2039', '2038-07-15', '2039-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, '2039/2040', '2039-07-15', '2040-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, '2040/2041', '2040-07-15', '2041-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, '2041/2042', '2041-07-15', '2042-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, '2042/2043', '2042-07-15', '2043-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, '2043/2044', '2043-07-15', '2044-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, '2044/2045', '2044-07-15', '2045-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, '2045/2046', '2045-07-15', '2046-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, '2046/2047', '2046-07-15', '2047-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, '2047/2048', '2047-07-15', '2048-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, '2048/2049', '2048-07-15', '2049-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, '2049/2050', '2049-07-15', '2050-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, '2050/2051', '2050-07-15', '2051-06-20', '2026-09-23 03:02:34', '2026-09-23 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id`, `nama`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(2, 'Guru BK 1', 'bk1@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(3, 'Guru BK 2', 'bk2@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(4, 'Budi Santoso', 'budi.santoso@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(5, 'Siti Aminah', 'siti.aminah@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(6, 'Agus Setiawan', 'agus.setiawan@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(7, 'Dewi Lestari', 'dewi.lestari@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(8, 'Eko Prasetyo', 'eko.prasetyo@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(9, 'Fitriani', 'fitriani@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(10, 'Hendra Wijaya', 'hendra.wijaya@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(11, 'Indah Permata', 'indah.permata@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(12, 'Joko Widodo', 'joko.widodo@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(13, 'Kurniawan', 'kurniawan@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(14, 'Lestari Ayu', 'lestari.ayu@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(15, 'M. Rizky', 'm.rizky@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(16, 'Nur Hidayah', 'nur.hidayah@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(17, 'Oktavia', 'oktavia@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(18, 'Pratama', 'pratama@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(19, 'Qori', 'qori@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(20, 'Rahmat', 'rahmat@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(21, 'Sari', 'sari@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(22, 'Taufik', 'taufik@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(23, 'Utami', 'utami@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(24, 'Vina', 'vina@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(25, 'Wahyu', 'wahyu@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(26, 'Xavier', 'xavier@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(27, 'Yuli', 'yuli@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(28, 'Zainal', 'zainal@school.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(29, 'Ahmad Fadhil', 'fadhil@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(30, 'Bella Safira', 'bella@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(31, 'Candra Wijaya', 'candra@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(32, 'Dina Mariana', 'dina@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(33, 'Erlangga Putra', 'erlangga@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(34, 'Fani Rahmawati', 'fani@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(35, 'Gilang Ramadhan', 'gilang@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(36, 'Hana Nurul', 'hana@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(37, 'Irfan Hakim', 'irfan@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(38, 'Jessica Mila', 'jessica@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(39, 'Kevin Sanjaya', 'kevin@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(40, 'Lia Amalia', 'lia@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(41, 'M. Iqbal', 'iqbal@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(42, 'Nabila Putri', 'nabila@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(43, 'Oky Setiawan', 'oky@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(44, 'Putri Ayu', 'putri@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(45, 'Qabil Huda', 'qabil@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(46, 'Rian Ardianto', 'rian@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(47, 'Siska Kohl', 'siska@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(48, 'Tedi Permana', 'tedi@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(49, 'Umar Bakri', 'umar@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(50, 'Vina Panduwinata', 'vina.p@student.sch.id', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38');

-- --------------------------------------------------------

--
-- Table structure for table `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indexes for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `t_wali_kelas_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_3` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
