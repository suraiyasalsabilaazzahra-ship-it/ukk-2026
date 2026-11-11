-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2026 at 02:49 PM
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
(1, '198001012005011001', 'Fitri Fauziah, S.T', 'fitri@gmail.com', 1, 1, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(2, '198001012005011002', 'Aan Andriana, S.T', 'Aan@gmail.com', 1, 2, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(3, '198001012005011003', 'Fahrullah, S.Pd', 'Fahrullah@gmail.com', 1, 3, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(4, '198001012005011004', 'Dheny Darajatul Hasani, S.Pd.', 'dheny@gmail.com', 1, 4, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(5, '198001012005011005', 'Ratnaningsih Hatil Aeni, S.Pd.', 'ratna@gmail.com', 1, 5, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(6, '198001012005011006', 'Frasetio', 'Frasetio@gmail.com', 1, 6, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(7, '198001012005011007', 'Rizkia Fahira, S.Pd', 'rizkia@gmail.com', 1, 7, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(8, '198001012005011008', 'Dra. Tintin Noerhayati', 'dra@gmail.com', 1, 8, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(9, '198001012005011009', 'Risna Andriyani, S.Pd', 'risna@gmail.com', 1, 9, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(10, '198001012005011010', 'Alvira Sofwatunnisa, S.Pd', 'alvira@gmail.com', 1, 10, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(11, '198001012005011011', 'Ilma Amalia, S.Pd', 'IIma@gmail.com', 1, 11, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(12, '198001012005011012', 'Senny Indayani, S.Pd', 'senny@gmail.com', 1, 12, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(13, '198001012005011013', 'Yusrin Noer Sabrina, S.Pd', 'yusrin@gmail.com', 1, 13, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(14, '198001012005011014', 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'lilis@gmail.com', 1, 14, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(15, '198001012005011015', ' Yusi Luthfiani, S.Sos.I', 'yusi@gmail.com', 1, 15, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(16, '198001012005011016', 'Aanisah Putri Nur Aini, S.Pd', 'anisah@gmail.com', 1, 16, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(17, '198001012005011017', 'Isni Nur Fitriani, S.Pd', 'Isni@gmail.com', 1, 17, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(18, '198001012005011018', 'Eli Rosliah, S.Pd', 'eli@gmail.com', 1, 18, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(19, '198001012005011019', 'Aldi Maulana, S.Pd', 'aldi@gmail.com', 1, 19, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(20, '198001012005011020', 'Mira Dwi Rahmawati, S.Ag', 'mira@gmail.com', 1, 20, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(21, '198001012005011021', 'Ucu Muhammad Khoer N, S.Pd', 'ucu@gmail.com', 1, 21, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(22, '198001012005011022', 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneu@gmail.com', 1, 22, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(23, '198001012005011023', 'Ari Sandriana, S.Kom', 'ari@gmail.com', 1, 23, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(24, '198001012005011024', 'Feri Rahmawan, S.Pd', 'feri@gmail.com', 1, 24, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(25, '198001012005011025', 'Rendy Ichsan Kusumah, S.T', 'rendy@gmail.com', 1, 25, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(26, '198001012005011026', 'Asep Taufiq Hidayat, S.Kom', 'taufiq@gmail.com', 1, 26, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(27, '198001012005011027', 'Arif Kusmawan, S.Pd', 'arif@gmail.com', 1, 27, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(28, '198001012005011028', 'Chandra Aditya Yusuf, S.Pd', 'chandra@gmail.com', 1, 28, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(29, '198001012005011029', 'Ai Wahidah, S.Ag', 'wahidah@gmail.com', 1, 29, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(30, '198001012005011030', ' Erna Suryani, S.Pd', 'erna@gmail.com', 1, 30, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(31, '198001012005011031', 'Sandi Mulyana, S.Pd', 'sandi@gmail.com', 1, 31, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(32, '198001012005011032', 'Ogi Gaosun Gias, S.Pd.I', 'ogi@gmail.com', 1, 32, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(33, '198001012005011033', 'Ansor Muhajir, S.T', 'ansor@gmail.com', 1, 33, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(34, '198001012005011034', 'Wiwid Yulianti, S.Pd', 'wiwid@gmail.com', 1, 34, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(35, '198001012005011035', 'Syeni Suswarini, S.Pd', 'syeni@gmail.com', 1, 35, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(36, '198001012005011036', ' Helmi Ali Akbar, S.Pd.I', 'helmi@gmail.com', 1, 36, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(37, '198001012005011037', 'Drs. Muhamad Ali', 'Ali@gmail.com', 1, 37, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(38, '198001012005011038', 'Idah Mahmudah, S.Pd', 'Idah@gmail.com', 1, 38, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(39, '198001012005011039', 'Ida Farida, S. Pd', 'Ida@gmail.com', 1, 39, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(40, '198001012005011040', 'Dedi Kardiman, S.Pd', 'Dedi@gmail.com', 1, 40, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(41, '198001012005011041', 'Opik', 'Opik@gmail.com', 1, 41, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(42, '198001012005011042', 'H. Encep Maemun, S.T., M.Pd', 'Encep@gmail.com', 1, 42, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(43, '198001012005011043', ' Asep Bastaman', 'Asep@gmail.com', 1, 43, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(44, '198001012005011044', 'Drs. Heri', 'Heri@gmail.com', 1, 44, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(45, '198001012005011045', 'Drs. Ahmad Nur Mukhlis', 'Ahmad@gmail.com', 1, 45, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(46, '198001012005011046', ' Uca Musa Yusenda, S.Pd', 'Uca@gmail.com', 1, 46, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(47, '198001012005011047', 'Dody Jaenudin, S.Pd.', 'Dody@gmail.com', 1, 47, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(48, '198001012005011048', 'Maya Permata Endah, S. Pd', 'Maya@gmail.com', 1, 48, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(49, '198001012005011049', 'Ai Nuryaidah, S.Pd', 'Ai@gmail.com', 1, 49, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(50, '198001012005011050', 'Wawan Kurniawan S.Pd. I', 'Wawan@gmail.com', 1, 50, '2026-09-23 03:40:51', '2026-09-23 03:40:51'),
(51, '927392738273213717', 'Nida Aulia, S.Pd', 'nida@gmail.com', 1, 51, '2026-11-05 02:56:01', '2026-11-05 02:56:01'),
(52, '232424353564657475', 'Sri Nurrizki Putri Krisnadi, S.Pd', 'sri@gmail.com', 1, 52, '2026-11-05 02:56:36', '2026-11-05 02:56:36'),
(53, '923979217834927489', 'Riesy Putri Navia, S.Kom', 'riesy@gmail.com', 1, 53, '2026-11-05 02:57:07', '2026-11-05 02:57:07'),
(54, '908593859823958239', 'Rurry Febriani Maryadi, S.Pd', 'rury@gmail.com', 1, 54, '2026-11-05 02:57:29', '2026-11-05 02:57:29'),
(55, '056909856989689394', 'Irvan Rizal, S.Pd', 'irvan@gmail.com', 1, 55, '2026-11-05 02:57:57', '2026-11-05 02:57:57');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `wali_kelas_id` int(11) DEFAULT 0,
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

INSERT INTO `t_kelas` (`id`, `wali_kelas_id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 0, 'X RPL 1', 'X', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, 0, 'X RPL 2', 'X', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, 0, 'XI RPL 1', 'XI', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, 0, 'XI RPL 2', 'XI', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, 0, 'XII RPL 1', 'XII', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, 19, 'XII RPL 2', 'XII', 'RPL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, 0, 'X TKJ 1', 'X', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, 0, 'X TKJ 2', 'X', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, 0, 'XI TKJ 1', 'XI', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, 0, 'XI TKJ 2', 'XI', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, 0, 'XII TKJ 1', 'XII', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, 0, 'XII TKJ 2', 'XII', 'TKJ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, 0, 'X MM 1', 'X', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, 0, 'X MM 2', 'X', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, 0, 'XI MM 1', 'XI', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, 0, 'XI MM 2', 'XI', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, 0, 'XII MM 1', 'XII', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, 0, 'XII MM 2', 'XII', 'MM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, 0, 'X AKL 1', 'X', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, 0, 'X AKL 2', 'X', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, 0, 'XI AKL 1', 'XI', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, 0, 'XI AKL 2', 'XI', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, 0, 'XII AKL 1', 'XII', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, 0, 'XII AKL 2', 'XII', 'AKL', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, 0, 'X OTKP 1', 'X', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, 0, 'X OTKP 2', 'X', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, 0, 'XI OTKP 1', 'XI', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, 0, 'XI OTKP 2', 'XI', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, 0, 'XII OTKP 1', 'XII', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, 0, 'XII OTKP 2', 'XII', 'OTKP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, 0, 'X BDP 1', 'X', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, 0, 'X BDP 2', 'X', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, 0, 'XI BDP 1', 'XI', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, 0, 'XI BDP 2', 'XI', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, 0, 'XII BDP 1', 'XII', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, 0, 'XII BDP 2', 'XII', 'BDP', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, 0, 'X TKR 1', 'X', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, 0, 'X TKR 2', 'X', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, 0, 'XI TKR 1', 'XI', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, 0, 'XI TKR 2', 'XI', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, 0, 'XII TKR 1', 'XII', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, 0, 'XII TKR 2', 'XII', 'TKR', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, 0, 'X TBSM 1', 'X', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, 0, 'X TBSM 2', 'X', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, 0, 'XI TBSM 1', 'XI', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, 0, 'XI TBSM 2', 'XI', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, 0, 'XII TBSM 1', 'XII', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, 0, 'XII TBSM 2', 'X', 'TBSM', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, 0, 'X DKV 1', 'X', 'DKV', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, 0, 'X DKV 2', 'X', 'DKV', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(51, 33, 'X RPL1', 'X', 'RPL', 0, '2026-11-04 00:32:42', '2026-11-04 00:32:42'),
(53, 9, 'XII TKR 3', 'XII', 'TKR', 0, '2026-11-09 13:31:35', '2026-11-09 13:31:35');

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

--
-- Dumping data for table `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 26, 31, '0000-00-00', '0000-00-00', 1, '2026-11-04 01:35:21', '2026-11-04 01:35:21'),
(2, 51, 26, 6, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:05:38', '2026-11-09 13:05:38'),
(7, 50, 26, 19, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:11:19', '2026-11-09 13:11:19'),
(37, 16, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:32:42', '2026-11-09 13:32:42'),
(38, 15, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:33:08', '2026-11-09 13:33:08'),
(39, 14, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:33:49', '2026-11-09 13:33:49'),
(40, 13, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:34:16', '2026-11-09 13:34:16'),
(41, 12, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:34:39', '2026-11-09 13:34:39'),
(42, 11, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:35:05', '2026-11-09 13:35:05'),
(43, 10, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:35:30', '2026-11-09 13:35:30'),
(44, 9, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:35:50', '2026-11-09 13:35:50'),
(45, 8, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:36:17', '2026-11-09 13:36:17'),
(46, 7, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:36:37', '2026-11-09 13:36:37'),
(47, 6, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:37:01', '2026-11-09 13:37:01'),
(48, 5, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:37:23', '2026-11-09 13:37:23'),
(49, 4, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:37:49', '2026-11-09 13:37:49'),
(50, 3, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:38:13', '2026-11-09 13:38:13'),
(51, 2, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:38:47', '2026-11-09 13:38:47'),
(52, 52, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:39:31', '2026-11-09 13:39:31'),
(53, 53, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:40:27', '2026-11-09 13:40:27'),
(54, 54, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:41:03', '2026-11-09 13:41:03'),
(55, 55, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:41:33', '2026-11-09 13:41:33'),
(56, 56, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:42:05', '2026-11-09 13:42:05'),
(57, 57, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:42:34', '2026-11-09 13:42:34'),
(58, 58, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:43:09', '2026-11-09 13:43:09'),
(59, 59, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:43:37', '2026-11-09 13:43:37'),
(60, 60, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:44:12', '2026-11-09 13:44:12'),
(61, 61, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:44:40', '2026-11-09 13:44:40'),
(62, 62, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:45:08', '2026-11-09 13:45:08'),
(63, 63, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:45:35', '2026-11-09 13:45:35'),
(64, 64, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:46:07', '2026-11-09 13:46:07'),
(65, 65, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:46:40', '2026-11-09 13:46:40'),
(66, 66, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:47:11', '2026-11-09 13:47:11'),
(67, 67, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:47:42', '2026-11-09 13:47:42'),
(68, 68, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:48:11', '2026-11-09 13:48:11'),
(69, 69, 26, 53, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:48:39', '2026-11-09 13:48:39');

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
  `siswa_id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(20) NOT NULL,
  `poin` int(11) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `siswa_id`, `pelanggaran_kategori_id`, `poin`, `tanggal`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(11, 'Kategori 11', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 11', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, 'Kategori 12', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 12', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, 'Kategori 13', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 13', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, 'Kategori 14', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 14', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, 'Kategori 15', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 15', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, 'Kategori 16', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 16', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, 'Kategori 17', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 17', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, 'Kategori 18', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 18', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, 'Kategori 19', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 19', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, 'Kategori 20', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 20', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, 'Kategori 21', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 21', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, 'Kategori 22', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 22', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, 'Kategori 23', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 23', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, 'Kategori 24', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 24', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, 'Kategori 25', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 25', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, 'Kategori 26', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 26', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, 'Kategori 27', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 27', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, 'Kategori 28', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 28', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, 'Kategori 29', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 29', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, 'Kategori 30', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 30', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, 'Kategori 31', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 31', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, 'Kategori 32', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 32', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, 'Kategori 33', 0, 0, 0, '2026-11-04 09:58:13', 'Deskripsi Kategori Pelanggaran 33', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, 'Memalsukan tanda tangan orang tua/wali atau guru', 0, 0, 55, '2026-11-11 11:15:31', 'Memalsukan tanda tangan orang tua/wali atau guru', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, 'Membawa senjata tajam atau barang terlarang', 0, 0, 100, '2026-11-11 11:15:14', 'Membawa senjata tajam atau barang terlarang', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, 'Mencuri barang milik teman, guru, atau sekolah', 0, 0, 85, '2026-11-11 11:14:58', 'Mencuri barang milik teman, guru, atau sekolah di lingkungan sekolah', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, 'Berkelahi / melakukan tindakan kekerasan / perundungan', 0, 0, 80, '2026-11-11 11:14:33', 'Berkelahi / melakukan tindakan kekerasan / perundungan', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, 'Merokok atau membawa vape di lingkungan sekolah', 0, 0, 60, '2026-11-11 11:14:08', 'Merokok di lingkungan sekolah', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, 'Membawa atau menggunakan gawai/HP saat jam pelajaran', 0, 0, 35, '2026-11-11 11:13:47', 'memainkan hp / gawai saat pembelajaran sedang berlangsung', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, 'Membuat keributan saat KBM berlangsung', 0, 0, 25, '2026-11-11 11:13:16', 'Membuat keributan saat kegiatan belajar mengajar dan menggangu', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, 'Membuang sampah sembarangan / merusak fasilitas ringan', 0, 0, 30, '2026-11-11 11:12:29', 'membuang sampah sembarangan di lingkungan sekolah dan merusak fasilitas sekolah', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, 'Tidak mengikuti kegiatan upacara sekolah wajib', 0, 0, 20, '2026-11-11 11:11:33', 'Tidak mengikuti upcara ', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, 'Membolos / keluar sekolah saat jam pelajaran', 0, 0, 25, '2026-11-05 07:35:58', 'membolos / keluar kelas sebelum mata pelajaran selesai', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, 'Masuk kelas/ruangan tanpa izin guru', 0, 0, 15, '2026-11-05 07:34:46', 'Masuk kelas / ruangan tanpa izin guru', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, 'Rambut / Kuku tidak rapi', 0, 0, 10, '2026-11-05 07:34:09', 'Tidak memotong kuku dan merapikan rambut(gondrong)', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, 'Tidak memakai atribut upacara', 0, 0, 10, '2026-11-05 07:31:14', 'Tidak memakai dasi, topi, hingga ikat pinggang', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, 'Atribut seragam tidak lengkap / tidak sesuai', 0, 0, 10, '2026-11-04 09:58:13', 'Tidak memakai dasi', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(51, 'Terlambat datang ke sekolah', 0, 0, 5, '2026-11-04 09:58:13', 'terlambat 10 menit', 0, '2026-11-04 02:15:35', '2026-11-04 02:15:35'),
(52, 'Melakukan perundungan ', 0, 0, 120, '2026-11-05 08:08:42', 'Melakukan perundungan verbal / non verbal terhadap individu', 0, '2026-11-05 01:08:42', '2026-11-05 01:08:42');

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

--
-- Dumping data for table `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(0, NULL, 59, ' Rasya Abdul Basith', 53, 'XII TKR 3', NULL, 'Terlambat datang ke sekolah', 51, NULL, 'Aldi Maulana, S.Pd', '2026-11-11', 'terlambat 10 menit', 5, 'Menunggu 45 menit di luar kelas sebelum masuk', 'Aktif', '2026-11-11 04:04:32', '2026-11-11 04:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `kelas` varchar(50) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
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

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `kelas`, `kelas_id`, `jurusan`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '20230001', '0051234001', 'Ahmad Dani', 'X BDP 1', 31, 'BDP', 'L', '2006-05-12', 'Jl. Merdeka No. 1', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, '20230002', '0051234002', 'Iqbal Muharrom', 'XII TKR 3', 53, 'TKR', 'L', '2006-08-22', 'Jl. Mawar No. 2', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, '20230003', '0051234003', 'Hilman Sohibul Kiyam', 'XII TKR 3', 53, 'TKR', 'L', '2006-02-14', 'Jl. Melati No. 3', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, '20230004', '0051234004', 'Hiban Sa\'ban', 'XII TKR 3', 53, 'TKR', 'L', '2006-04-11', 'Jl. Anggrek No. 4', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, '20230005', '0051234005', 'Guntur Muhamad Azril', 'XII TKR 3', 53, 'TKR', 'L', '2006-09-09', 'Jl. Dahlia No. 5', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, '20230006', '0051234006', 'Fatir Rizky', 'XII TKR 3', 53, 'TKR', 'L', '2006-07-30', 'Jl. Flamboyan No. 6', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, '20230007', '0051234007', 'Faiz Fauzan Abdurahman', 'XII TKR 3', 53, 'TKR', 'L', '2006-05-08', 'Jl. Kenanga No. 7', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, '20230008', '0051234008', 'Evan Rasendriya', 'XII TKR 3', 53, 'TKR', 'L', '2006-06-15', 'Jl. Kamboja No. 8', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, '20230009', '0051234009', 'Ergi Zulvian Razvi', 'XII TKR 3', 53, 'TKR', 'L', '2006-10-10', 'Jl. Tulip No. 9', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, '20230010', '0051234010', 'Dimas Anugrah Pranatama', 'XII TKR 3', 53, 'TKR', 'L', '2006-08-03', 'Jl. Lotus No. 10', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, '20230011', '0051234011', 'Diki Saputra', 'XII TKR 3', 53, 'TKR', 'L', '2006-08-02', 'Jl. Melati No. 11', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, '20230012', '0051234012', 'Dika Aditya', 'XII TKR 3', 53, 'TKR', 'L', '2006-08-26', 'Jl. Dahlia No. 12', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, '20230013', '0051234013', 'Dawam Ariasa Putra', 'XII TKR 3', 53, 'TKR', 'L', '2006-08-05', 'Jl. Sakura No. 13', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, '20230014', '0051234014', 'Agis Pratama', 'XII TKR 3', 53, 'TKR', 'L', '2006-11-18', 'Jl. Mawar No. 14', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, '20230015', '0051234015', 'Afep Saepul Hidayah', 'XII TKR 3', 53, 'TKR', 'L', '2006-01-01', 'Jl. Anggrek No. 15', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, '20230016', '0051234016', 'Adam Lasmana Nugraha', 'XII TKR 3', 53, 'TKR', 'L', '2006-10-15', 'Jl. Garam No. 16', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, '20230017', '0051234017', 'Zacky Ripaldi Suryadi Putra', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-09-02', 'Jl. Gajah No. 17', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, '20230018', '0051234018', 'Windi Meliana', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-02-17', 'Jl. Andara No. 18', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, '20230019', '0051234019', 'SHEYNA PUSPITA RAMADANI', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-11-15', 'Jl. Sunda No. 19', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, '20230020', '0051234020', 'Sheila Aulia Rahma', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-12-07', 'Jl. Melati No. 20', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, '20230021', '0051234021', 'Rismi Heliyanti', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-12-23', 'Jl. Pelajar No. 21', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, '20230022', '0051234022', 'RASYA REZA MURSYIDA AL-MURTADHO', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-03-24', 'Jl. Pemuda No. 22', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, '20230023', '0051234023', 'RAISYA SAFINATUN NAJAH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-02-26', 'Jl. Pahlawan No. 23', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, '20230024', '0051234024', 'PEBRI PEBRIANSYAH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-03-26', 'Jl. Kartini No. 24', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, '20230025', '0051234025', 'NENG RIA SRI RAMADANI', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-06-09', 'Jl. Sudirman No. 25', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, '20230026', '0051234026', 'Najma Aribah Butsainah', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-04-27', 'Jl. MH Thamrin No. 26', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, '20230027', '0051234027', 'NAILA IMELDA', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-01-27', 'Tasimalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, '20230028', '0051234028', 'MUHAMMAD SALWAN ZHAHRA', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-02-28', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, '20230029', '0051234029', 'MUHAMMAD RIZKY', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-03-29', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, '20230030', '0051234030', 'Muhammad Fahri Razib', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-04-30', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, '20230031', '0051234031', 'Muhamad Rasya Dzikri Ramadhan', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-01', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, '20230032', '0051234032', 'MUHAMAD IRSYAD FADILAH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-02', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, '20230033', '0051234033', 'MUHAMAD FARDAN NURDIANSYAH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-03', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, '20230034', '0051234034', 'KEISYA AULIA', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-05-04', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, '20230035', '0051234035', 'JEMY MUHAMMAD RAFSANZANY', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-05', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, '20230036', '0051234036', 'Ivan Gunawan', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-06', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, '20230037', '0051234037', 'HAIKAL ADIKA', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-07', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, '20230038', '0051234038', 'Ghinaa Haniifah Robbaani', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-05-08', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, '20230039', '0051234039', 'FARDHAN KHOERULLAH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-09', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, '20230040', '0051234040', 'FAJRI RUKMΜΑΝΑ', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-10', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, '20230041', '0051234041', 'FAJAR FIRRIZKI', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-11', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, '20230042', '0051234042', 'FAHMI IBRAHIM', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-12', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, '20230043', '0051234043', 'Fadil Nurhakim', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-13', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, '20230044', '0051234044', 'DZIKRI RIDHWANULLOH', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-14', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, '20230045', '0051234045', 'DEWI ISLAMMIATI', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-05-15', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, '20230046', '0051234046', 'DENI WAHYUDI', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-16', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, '20230047', '0051234047', 'Dara Azkadia Naifa', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-05-17', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(48, '20230048', '0051234048', 'AUSTIN SYAHRI', 'XII TKJ 3', 52, 'TKJ', 'P', '2006-05-18', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(49, '20230049', '0051234049', 'Aldi Fahri Ramdani', 'XII TKJ 3', 52, 'TKJ', 'L', '2006-05-19', 'Tasikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(50, '20230050', '0051234050', 'Luna Maya', 'X AKL 1', 19, 'AKL', 'P', '2006-05-20', 'TAsikmalaya', 1, '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(51, '2939229079', '2849028408', 'Suraiya Salsabila Az-Zahra', 'XII RPL 2', 6, 'RPL', 'P', '0000-00-00', 'Kawalu', 1, '2026-11-04 01:03:37', '2026-11-04 01:03:37'),
(52, '9568934856', '3840384083', 'Iqbal Muharrom', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:39:31', '2026-11-09 13:39:31'),
(53, '4859893485', '3985430985', 'Izaz Syakir', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:40:27', '2026-11-09 13:40:27'),
(54, '9859234759', '0395808450', 'Moch Faizal Gilang Permana', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:41:03', '2026-11-09 13:41:03'),
(55, '2340932849', '0329403924', 'Muhamad Rizky Gozali', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:41:32', '2026-11-09 13:41:32'),
(56, '9485694836', '4985034858', 'Muhammad Rikman Nulhakim', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:42:05', '2026-11-09 13:42:05'),
(57, '9845943856', '0354032850', 'Muhammad Siddiq Ibrahim Sobari', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:42:34', '2026-11-09 13:42:34'),
(58, '0569059094', '0560540690', 'Nizar Suryana', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:43:08', '2026-11-09 13:43:08'),
(59, '2342536573', '7878568732', ' Rasya Abdul Basith', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:43:37', '2026-11-09 13:43:37'),
(60, '0950239502', '0697069709', 'Rausan Vikri', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:44:12', '2026-11-09 13:44:12'),
(61, '9485934869', '0596057954', 'Revaldi Nurwansah', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:44:40', '2026-11-09 13:44:40'),
(62, '9847584756', '9384938598', 'Revan Rudiansah', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalya', 1, '2026-11-09 13:45:08', '2026-11-09 13:45:08'),
(63, '0569054870', '9860958609', 'Rizki Raditya', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:45:35', '2026-11-09 13:45:35'),
(64, '0958690548', '0596054067', 'Roby Orie Al Rasya', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:46:07', '2026-11-09 13:46:07'),
(65, '5860958460', '0504835843', 'Ruly Rudiansah', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya\r\n', 1, '2026-11-09 13:46:40', '2026-11-09 13:46:40'),
(66, '5680954868', '4056834086', 'Syahdan Rasdani', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:47:11', '2026-11-09 13:47:11'),
(67, '9845948594', '0496034806', 'Taba Haerul Salim', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:47:42', '2026-11-09 13:47:42'),
(68, '9875467439', '9609605860', 'Tirta Nur Zamzam', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:48:11', '2026-11-09 13:48:11'),
(69, '5647657658', '0596059406', 'Zilhad Ayalthuhaq', 'XII TKR 3', 53, 'TKR', 'L', '0000-00-00', 'Tasikmalaya', 1, '2026-11-09 13:48:39', '2026-11-09 13:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, '2001/2002', '2001-07-15', '2002-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(2, '2002/2003', '2002-07-15', '2003-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(3, '2003/2004', '2003-07-15', '2004-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(4, '2004/2005', '2004-07-15', '2005-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(5, '2005/2006', '2005-07-15', '2006-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(6, '2006/2007', '2006-07-15', '2007-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(7, '2007/2008', '2007-07-15', '2008-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(8, '2008/2009', '2008-07-15', '2009-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(9, '2009/2010', '2009-07-15', '2010-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(10, '2010/2011', '2010-07-15', '2011-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(11, '2011/2012', '2011-07-15', '2012-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(12, '2012/2013', '2012-07-15', '2013-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(13, '2013/2014', '2013-07-15', '2014-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(14, '2014/2015', '2014-07-15', '2015-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(15, '2015/2016', '2015-07-15', '2016-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(16, '2016/2017', '2016-07-15', '2017-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(17, '2017/2018', '2017-07-15', '2018-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(18, '2018/2019', '2018-07-15', '2019-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(19, '2019/2020', '2019-07-15', '2020-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(20, '2020/2021', '2020-07-15', '2021-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(21, '2021/2022', '2021-07-15', '2022-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(22, '2022/2023', '2022-07-15', '2023-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(23, '2023/2024', '2023-07-15', '2024-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(24, '2024/2025', '2024-07-15', '2025-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(25, '2025/2026', '2025-07-15', '2026-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(26, '2026/2027', '2026-07-15', '2027-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(27, '2027/2028', '2027-07-15', '2028-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(28, '2028/2029', '2028-07-15', '2029-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(29, '2029/2030', '2029-07-15', '2030-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(30, '2030/2031', '2030-07-15', '2031-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(31, '2031/2032', '2031-07-15', '2032-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(32, '2032/2033', '2032-07-15', '2033-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(33, '2033/2034', '2033-07-15', '2034-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(34, '2034/2035', '2034-07-15', '2035-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(35, '2035/2036', '2035-07-15', '2036-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(36, '2036/2037', '2036-07-15', '2037-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(37, '2037/2038', '2037-07-15', '2038-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(38, '2038/2039', '2038-07-15', '2039-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(39, '2039/2040', '2039-07-15', '2040-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(40, '2040/2041', '2040-07-15', '2041-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(41, '2041/2042', '2041-07-15', '2042-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(42, '2042/2043', '2042-07-15', '2043-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(43, '2043/2044', '2043-07-15', '2044-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(44, '2044/2045', '2044-07-15', '2045-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(45, '2045/2046', '2045-07-15', '2046-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(46, '2046/2047', '2046-07-15', '2047-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34'),
(47, '2047/2048', '2047-07-15', '2048-06-20', 'Tidak Aktif', '2026-09-23 03:02:34', '2026-09-23 03:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `t_tindakan`
--

CREATE TABLE `t_tindakan` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `pelanggaran_siswa_id` int(11) DEFAULT NULL,
  `bentuk_tindakan` text DEFAULT NULL,
  `tanggal_tindakan` date DEFAULT NULL,
  `status_penyelesaian` varchar(50) DEFAULT 'Diproses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_tindakan`
--

INSERT INTO `t_tindakan` (`id`, `siswa_id`, `pelanggaran_siswa_id`, `bentuk_tindakan`, `tanggal_tindakan`, `status_penyelesaian`) VALUES
(1, 59, 0, 'Menunggu 45 menit di luar kelas sebelum masuk', '2026-11-11', 'Diproses');

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
(1, 'Fitri Fauziah, S.T', 'fitri@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'admin', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(2, 'Aan Andriana, S.T', 'Aan@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(3, 'Fahrullah, S.Pd', 'Fahrullah@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(4, 'Dheny Darajatul Hasani, S.Pd.', 'dheny@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(5, 'Ratnaningsih Hatil Aeni, S.Pd.', 'ratna@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(6, 'Frasetio', 'Frasetio@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(7, 'Rizkia Fahira, S.Pd', 'rizkia@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(8, 'Dra. Tintin Noerhayati', 'dra@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(9, 'Risna Andriyani, S.Pd', 'risna@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(10, 'Alvira Sofwatunnisa, S.Pd', 'alvira@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(11, 'Ilma Amalia, S.Pd', 'IIma@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(12, 'Senny Indayani, S.Pd', 'senny@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(13, 'Yusrin Noer Sabrina, S.Pd', 'yusrin@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(14, 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'lilis@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(15, ' Yusi Luthfiani, S.Sos.I', 'yusi@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(16, 'Aanisah Putri Nur Aini, S.Pd', 'anisah@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(17, 'Isni Nur Fitriani, S.Pd', 'Isni@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(18, 'Eli Rosliah, S.Pd', 'eli@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(19, 'Aldi Maulana, S.Pd', 'aldi@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(20, 'Mira Dwi Rahmawati, S.Ag', 'mira@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(21, 'Ucu Muhammad Khoer N, S.Pd', 'ucu@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(22, 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneu@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(23, 'Ari Sandriana, S.Kom', 'ari@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(24, 'Feri Rahmawan, S.Pd', 'feri@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(25, 'Rendy Ichsan Kusumah, S.T', 'rendy@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(26, 'Asep Taufiq Hidayat, S.Kom', 'taufiq@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(27, 'Arif Kusmawan, S.Pd', 'arif@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(28, 'Chandra Aditya Yusuf, S.Pd', 'chandra@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'guru', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(29, 'Ai Wahidah, S.Ag', 'wahidah@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(30, ' Erna Suryani, S.Pd', 'erna@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(31, 'Sandi Mulyana, S.Pd', 'sandi@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(32, 'Ogi Gaosun Gias, S.Pd.I', 'ogi@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(33, 'Ansor Muhajir, S.T', 'ansor@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(34, 'Wiwid Yulianti, S.Pd', 'wiwid@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(35, 'Syeni Suswarini, S.Pd', 'syeni@gmail.com', '2026-09-23 03:25:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(36, ' Helmi Ali Akbar, S.Pd.I', 'helmi@gmail.com', '2026-09-23 03:25:38', '$2y$10$pGcNAvYK0yDGH8iLQ1zGWuEfVZ6zooP6NNP8998gZMPK.lYn48Yby', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(37, 'Drs. Muhamad Ali', 'Ali@gmail.com', '2026-09-23 03:25:38', '$2y$10$3/1TY7pomoDhXIsYHr/SnuaE6kY9FaXV.a8Mvivpp4gs8pYz4KDuG', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(38, 'Idah Mahmudah, S.Pd', 'Idah@gmail.com', '2026-09-23 03:25:38', '$2y$10$.sAWlYi6fkiujo2hkRqDIuwwV1MwGZ2lUknQvVGFiazKmEpRuCgwi', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(39, 'Ida Farida, S. Pd', 'Ida@gmail.com', '2026-09-23 03:25:38', '$2y$10$4m36didJMoVLPiAvKiCscesl2wS/zN7pvCtKiKXyEcV.2nVX6jHqu', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(40, 'Dedi Kardiman, S.Pd', 'Dedi@gmail.com', '2026-09-23 03:25:38', '$2y$10$.dVe3zPX2YezrW0mIdWoY.5R9Io91yKXWGBBCTsn05BDSXwiRGX7C', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(41, 'Opik', 'Opik@gmail.com', '2026-09-23 03:25:38', '$2y$10$2HUd6AJTGOtdX5AVX4jjnuGaJMbQ3o.RnEQhlrCur620lmdyx3BSG', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(42, 'H. Encep Maemun, S.T., M.Pd', 'Encep@gmail.com', '2026-09-23 03:25:38', '$2y$10$iM/mZML01D2.k5Hw2z8rA.t5zp3zWt5Bgbj1ORHBFjwsh8EzylPOu', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(43, ' Asep Bastaman', 'Asep@gmail.com', '2026-09-23 03:25:38', '$2y$10$6PQjyN7KjVgDz.vkmYZ83upDmdrTVUSvYjZa8p6aV8o48BIl0TMv2', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(44, 'Drs. Heri', 'Heri@gmail.com', '2026-09-23 03:25:38', '$2y$10$y7hydlpb6IrYzW2wZWut7ux3OIjKGYFdME3Awr34T3lgYVWzmvrXe', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(45, 'Drs. Ahmad Nur Mukhlis', 'Ahmad@gmail.com', '2026-09-23 03:25:38', '$2y$10$Sm6VJJuEwayzWss9xM2Fzuv3sIRmzHbrv3x73JSSP777Up0SFhN4u', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(46, ' Uca Musa Yusenda, S.Pd', 'Uca@gmail.com', '2026-09-23 03:25:38', '$2y$10$fMxxBdpgauuLbQyJ1dckkO4biSUfbeE6IniTqSvYTnU5tr0YrRQIG', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(47, 'Dody Jaenudin, S.Pd.', 'Dody@gmail.com', '2026-09-23 03:25:38', '$2y$10$iSiMXrPWpdmA2lFUT6oX4.idX6H7Tcc54lMYfBS/m3yFOO6VOWK3y', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(48, 'Maya Permata Endah, S. Pd', 'Maya@gmail.com', '2026-09-23 03:25:38', '$2y$10$e8/.6Er38keNsYmSt2F/meu9FtJ4muCkDhtx16UHCO47AuG.6DHuq', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(49, 'Ai Nuryaidah, S.Pd', 'Ai@gmail.com', '2026-09-23 03:25:38', '$2y$10$0M65LHJGHcMveiILW5sEDuuEnqlAROT48esBx7yAhNi40Xsm62yyW', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(50, 'Wawan Kurniawan S.Pd. I', 'Wawan@gmail.com', '2026-09-23 03:25:38', '$2y$10$51jrLdj0Nb.ixNz1GgjAHO5o9LvU0P/Ztf3IHx5VdzDJOYDDYD2Di', NULL, 'siswa', '2026-09-23 03:25:38', '2026-09-23 03:25:38'),
(51, 'Nida Aulia, S.Pd', 'nida@gmail.com', '2026-11-05 02:56:01', '$2y$10$0/ERgHbdPZfDpHA/QAL6SOEQYW0Awbt/pRCqhLwgRyttcMBcJ6Mxu', NULL, 'Guru', '2026-11-05 02:56:01', '2026-11-05 02:56:01'),
(52, 'Sri Nurrizki Putri Krisnadi, S.Pd', 'sri@gmail.com', '2026-11-05 02:56:36', '$2y$10$h0vssuFvHwzzVFiwppy3A.WsAs8mlHjOTWXrh5pbvtRBmsTs3T5uy', NULL, 'Guru', '2026-11-05 02:56:36', '2026-11-05 02:56:36'),
(53, 'Riesy Putri Navia, S.Kom', 'riesy@gmail.com', '2026-11-05 02:57:07', '$2y$10$/Bn8azz0o3UUKjn/huzE5.SIX3VZtBENUbvKU0o/O8sAdX0u7nJP6', NULL, 'Guru', '2026-11-05 02:57:07', '2026-11-05 02:57:07'),
(54, 'Rurry Febriani Maryadi, S.Pd', 'rury@gmail.com', '2026-11-05 02:57:29', '$2y$10$rTchGz858QPHEbXNmatHDuAqCwwYORw72SAtjUmE/tJp/uwMpxCSG', NULL, 'Guru', '2026-11-05 02:57:29', '2026-11-05 02:57:29'),
(55, 'Irvan Rizal, S.Pd', 'irvan@gmail.com', '2026-11-05 02:57:57', '$2y$10$t10iGnJXeXvKSmiRb7WeAuHgs.Q3iV9NQkKCZuXO4.WIzJfYqPetK', NULL, 'Guru', '2026-11-05 02:57:57', '2026-11-05 02:57:57');

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
-- Dumping data for table `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 26, 19, 9, '0000-00-00', '0000-00-00', 1, '2026-11-04 02:32:10', '2026-11-04 02:32:10'),
(2, 26, 51, 33, '0000-00-00', '0000-00-00', 1, '2026-11-09 12:43:43', '2026-11-09 12:43:43'),
(3, 26, 53, 9, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:31:35', '2026-11-09 13:31:35'),
(4, 26, 6, 19, '0000-00-00', '0000-00-00', 1, '2026-11-09 13:32:16', '2026-11-09 13:32:16');

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
-- Indexes for table `t_tindakan`
--
ALTER TABLE `t_tindakan`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `t_tindakan`
--
ALTER TABLE `t_tindakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

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
