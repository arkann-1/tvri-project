-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 05:16 AM
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
-- Database: `jadwal_karyawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_karyawan`
--

CREATE TABLE `jadwal_karyawan` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(50) NOT NULL,
  `jam` varchar(50) NOT NULL,
  `pekerjaan` varchar(150) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `lokasi` enum('Senayan','Joglo') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_karyawan`
--

INSERT INTO `jadwal_karyawan` (`id`, `nip`, `nama`, `tanggal`, `shift`, `jam`, `pekerjaan`, `file_path`, `lokasi`, `created_at`) VALUES
(1, 'EMP001', 'Andi Wijaya', '2025-09-02', 'Pagi', '04:22 - 06:22', 'Staff IT', '', 'Senayan', '2025-09-01 02:32:45'),
(3, 'EMP003', 'Citra Dewi', '2025-09-01', 'Malam', '07:22 - 21:22', 'Finance', '', 'Senayan', '2025-09-01 02:32:45'),
(4, 'EMP004', 'Dedi Kurniawan', '2025-09-02', 'Pagi', '05:22 - 07:23', 'Security', '', 'Senayan', '2025-09-01 02:32:45'),
(6, 'EMP006', 'Farah Ayu', '2025-09-02', 'Malam', '05:23 - 15:23', 'Marketing', '', 'Senayan', '2025-09-01 02:32:45'),
(21, '0000000', 'Andi Garcia', '2025-09-04', 'Pagi', '07:00 - 16:00', 'Tidur', '../uploads/1756980491_Example.jpg', 'Senayan', '2025-09-04 10:08:11'),
(22, '161616', 'Bbbbbb', '2025-09-06', 'Malam', '06:23 - 21:23', 'Marketing', '', 'Senayan', '2025-09-05 18:24:02'),
(23, '1111111', 'Lorem Ipsum H', '2025-09-06', 'Pagi', '04:44 - 15:44', 'Siaran', '', 'Senayan', '2025-09-05 18:44:58'),
(25, 'EMP021', 'Diana Putri', '2025-09-08', 'Pagi', '07:00 - 15:00', 'Staff IT', '', 'Senayan', '2025-09-08 03:12:54'),
(26, 'EMP022', 'Rizky Maulana', '2025-09-08', 'Siang', '13:00 - 21:00', 'Marketing', '', 'Joglo', '2025-09-08 03:12:54'),
(27, 'EMP023', 'Siti Aisyah', '2025-09-08', 'Malam', '21:00 - 06:00', 'Finance', '', 'Senayan', '2025-09-08 03:12:54'),
(28, 'EMP024', 'Ahmad Fauzi', '2025-09-08', 'Pagi', '08:00 - 16:00', 'Security', '', 'Joglo', '2025-09-08 03:12:54'),
(29, 'EMP025', 'Nina Oktavia', '2025-09-08', 'Siang', '12:00 - 20:00', 'Admin HRD', '', 'Senayan', '2025-09-08 03:12:54'),
(30, 'EMP026', 'Bagus Pratama', '2025-09-09', 'Pagi', '07:00 - 15:00', 'Driver', '', 'Joglo', '2025-09-08 03:12:54'),
(31, 'EMP027', 'Intan Cahya', '2025-09-09', 'Siang', '13:00 - 21:00', 'Operator Produksi', '', 'Senayan', '2025-09-08 03:12:54'),
(32, 'EMP028', 'Reza Saputra', '2025-09-09', 'Malam', '21:00 - 06:00', 'Staff IT', '', 'Senayan', '2025-09-08 03:12:54'),
(33, 'EMP029', 'Maria Ulfa', '2025-09-10', 'Pagi', '06:00 - 14:00', 'Admin Gudang', '', 'Joglo', '2025-09-08 03:12:54'),
(34, 'EMP030', 'Bima Aditya', '2025-09-10', 'Siang', '14:00 - 22:00', 'Finance', '', 'Senayan', '2025-09-08 03:12:54'),
(35, 'EMP031', 'Yuni Safitri', '2025-09-10', 'Malam', '22:00 - 07:00', 'Security', '', 'Joglo', '2025-09-08 03:12:54'),
(36, 'EMP032', 'Hendra Gunawan', '2025-09-11', 'Pagi', '07:00 - 15:00', 'Marketing', '', 'Senayan', '2025-09-08 03:12:54'),
(37, 'EMP033', 'Putri Lestari', '2025-09-11', 'Siang', '13:00 - 21:00', 'Admin HRD', '', 'Joglo', '2025-09-08 03:12:54'),
(38, 'EMP034', 'Agus Salim', '2025-09-11', 'Malam', '21:00 - 06:00', 'Driver', '', 'Senayan', '2025-09-08 03:12:54'),
(39, 'EMP035', 'Linda Rosita', '2025-09-12', 'Pagi', '06:30 - 14:30', 'Operator Produksi', '', 'Senayan', '2025-09-08 03:12:54'),
(40, 'EMP036', 'Doni Prasetyo', '2025-09-12', 'Siang', '14:00 - 22:00', 'Finance', '', 'Joglo', '2025-09-08 03:12:54'),
(41, 'EMP037', 'Mega Anggraini', '2025-09-12', 'Malam', '22:00 - 07:00', 'Marketing', '', 'Senayan', '2025-09-08 03:12:54'),
(42, 'EMP038', 'Yoga Pradana', '2025-09-13', 'Pagi', '07:00 - 15:00', 'Admin Gudang', '', 'Joglo', '2025-09-08 03:12:54'),
(43, 'EMP039', 'Clara Amelia', '2025-09-13', 'Siang', '13:00 - 21:00', 'Staff IT', '', 'Senayan', '2025-09-08 03:12:54'),
(44, 'EMP040', 'Rama Kurniawan', '2025-09-13', 'Malam', '21:00 - 06:00', 'Security', '', 'Joglo', '2025-09-08 03:12:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_karyawan`
--
ALTER TABLE `jadwal_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_karyawan`
--
ALTER TABLE `jadwal_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
