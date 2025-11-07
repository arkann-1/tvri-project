-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2025 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `ID` int(11) NOT NULL,
  `divisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`ID`, `divisi`) VALUES
(1, 'Multiplexing '),
(2, 'Pengendalian Mutu dan Standarisasi Transmisi'),
(3, 'Teknologi Transmisi'),
(4, 'NMS'),
(5, 'Monitoring, Evaluasi, dan pelaporan Multipleksing'),
(6, 'jaringan transmisi');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_karyawan`
--

CREATE TABLE `jadwal_karyawan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(50) NOT NULL,
  `jam` varchar(50) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `lokasi` enum('Senayan','Joglo') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_karyawan`
--

INSERT INTO `jadwal_karyawan` (`id`, `tanggal`, `shift`, `jam`, `id_pegawai`, `lokasi`, `created_at`) VALUES
(1, '2025-11-01', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(2, '2025-11-01', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(3, '2025-11-01', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(4, '2025-11-01', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(5, '2025-11-01', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(6, '2025-11-01', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(7, '2025-11-02', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(8, '2025-11-02', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(9, '2025-11-02', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(10, '2025-11-02', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(11, '2025-11-02', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(12, '2025-11-02', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(13, '2025-11-03', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(14, '2025-11-03', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(15, '2025-11-03', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(16, '2025-11-03', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(17, '2025-11-03', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(18, '2025-11-03', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(19, '2025-11-04', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(20, '2025-11-04', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(21, '2025-11-04', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(22, '2025-11-04', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(23, '2025-11-04', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(24, '2025-11-04', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(25, '2025-11-05', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(26, '2025-11-05', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(27, '2025-11-05', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(28, '2025-11-05', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(29, '2025-11-05', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(30, '2025-11-05', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(31, '2025-11-06', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(32, '2025-11-06', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(33, '2025-11-06', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(34, '2025-11-06', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(35, '2025-11-06', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(36, '2025-11-06', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(37, '2025-11-07', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(38, '2025-11-07', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(39, '2025-11-07', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(40, '2025-11-07', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(41, '2025-11-07', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(42, '2025-11-07', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(43, '2025-11-08', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(44, '2025-11-08', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(45, '2025-11-08', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(46, '2025-11-08', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(47, '2025-11-08', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(48, '2025-11-08', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(49, '2025-11-09', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(50, '2025-11-09', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(51, '2025-11-09', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(52, '2025-11-09', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(53, '2025-11-09', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(54, '2025-11-09', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(55, '2025-11-10', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(56, '2025-11-10', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(57, '2025-11-10', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(58, '2025-11-10', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(59, '2025-11-10', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(60, '2025-11-10', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(61, '2025-11-11', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(62, '2025-11-11', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(63, '2025-11-11', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(64, '2025-11-11', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(65, '2025-11-11', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(66, '2025-11-11', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(67, '2025-11-12', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(68, '2025-11-12', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(69, '2025-11-12', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(70, '2025-11-12', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(71, '2025-11-12', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(72, '2025-11-12', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(73, '2025-11-13', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(74, '2025-11-13', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(75, '2025-11-13', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(76, '2025-11-13', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(77, '2025-11-13', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(78, '2025-11-13', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(79, '2025-11-14', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(80, '2025-11-14', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(81, '2025-11-14', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(82, '2025-11-14', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(83, '2025-11-14', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(84, '2025-11-14', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(85, '2025-11-15', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(86, '2025-11-15', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(87, '2025-11-15', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(88, '2025-11-15', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(89, '2025-11-15', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(90, '2025-11-15', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(91, '2025-11-16', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(92, '2025-11-16', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(93, '2025-11-16', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(94, '2025-11-16', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(95, '2025-11-16', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(96, '2025-11-16', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(97, '2025-11-17', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(98, '2025-11-17', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(99, '2025-11-17', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(100, '2025-11-17', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(101, '2025-11-17', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(102, '2025-11-17', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(103, '2025-11-18', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(104, '2025-11-18', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(105, '2025-11-18', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(106, '2025-11-18', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(107, '2025-11-18', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(108, '2025-11-18', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(109, '2025-11-19', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(110, '2025-11-19', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(111, '2025-11-19', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(112, '2025-11-19', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(113, '2025-11-19', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(114, '2025-11-19', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(115, '2025-11-20', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(116, '2025-11-20', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(117, '2025-11-20', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(118, '2025-11-20', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(119, '2025-11-20', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(120, '2025-11-20', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(121, '2025-11-21', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(122, '2025-11-21', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(123, '2025-11-21', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(124, '2025-11-21', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(125, '2025-11-21', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(126, '2025-11-21', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(127, '2025-11-22', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(128, '2025-11-22', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(129, '2025-11-22', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(130, '2025-11-22', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(131, '2025-11-22', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(132, '2025-11-22', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(133, '2025-11-23', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(134, '2025-11-23', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(135, '2025-11-23', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(136, '2025-11-23', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(137, '2025-11-23', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(138, '2025-11-23', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(139, '2025-11-24', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(140, '2025-11-24', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(141, '2025-11-24', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(142, '2025-11-24', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(143, '2025-11-24', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(144, '2025-11-24', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(145, '2025-11-25', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(146, '2025-11-25', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(147, '2025-11-25', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(148, '2025-11-25', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(149, '2025-11-25', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(150, '2025-11-25', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(151, '2025-11-26', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(152, '2025-11-26', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(153, '2025-11-26', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(154, '2025-11-26', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(155, '2025-11-26', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(156, '2025-11-26', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(157, '2025-11-27', '1', '00:00 - 08:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(158, '2025-11-27', '1', '00:00 - 08:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(159, '2025-11-27', '2', '08:00 - 16:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(160, '2025-11-27', '2', '08:00 - 16:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(161, '2025-11-27', '3', '16:00 - 00:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(162, '2025-11-27', '3', '16:00 - 00:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(163, '2025-11-28', '1', '00:00 - 08:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(164, '2025-11-28', '1', '00:00 - 08:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(165, '2025-11-28', '2', '08:00 - 16:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(166, '2025-11-28', '2', '08:00 - 16:00', 2, 'Senayan', '2025-11-05 07:49:51'),
(167, '2025-11-28', '3', '16:00 - 00:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(168, '2025-11-28', '3', '16:00 - 00:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(169, '2025-11-29', '1', '00:00 - 08:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(170, '2025-11-29', '1', '00:00 - 08:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(171, '2025-11-29', '2', '08:00 - 16:00', 10, 'Senayan', '2025-11-05 07:49:51'),
(172, '2025-11-29', '2', '08:00 - 16:00', 6, 'Senayan', '2025-11-05 07:49:51'),
(173, '2025-11-29', '3', '16:00 - 00:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(174, '2025-11-29', '3', '16:00 - 00:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(175, '2025-11-30', '1', '00:00 - 08:00', 13, 'Senayan', '2025-11-05 07:49:51'),
(176, '2025-11-30', '1', '00:00 - 08:00', 8, 'Senayan', '2025-11-05 07:49:51'),
(177, '2025-11-30', '2', '08:00 - 16:00', 7, 'Senayan', '2025-11-05 07:49:51'),
(178, '2025-11-30', '2', '08:00 - 16:00', 4, 'Senayan', '2025-11-05 07:49:51'),
(179, '2025-11-30', '3', '16:00 - 00:00', 12, 'Senayan', '2025-11-05 07:49:51'),
(180, '2025-11-30', '3', '16:00 - 00:00', 2, 'Senayan', '2025-11-05 07:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `liputan`
--

CREATE TABLE `liputan` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(255) NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `surat_tugas` varchar(255) DEFAULT NULL,
  `id_pegawai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liputan`
--

INSERT INTO `liputan` (`id`, `tanggal`, `lokasi`, `jenis_kegiatan`, `surat_tugas`, `id_pegawai`) VALUES
(10, '2025-11-04', 'Gedung DPR', 'Penyambutan Presiden Brazil', NULL, 21);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nip` bigint(25) NOT NULL,
  `id_divisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `nip`, `id_divisi`) VALUES
(1, 'Adi Subarkah', 197002221991031003, 2),
(2, 'Feyzi Rafsanjani', 199309082025211015, 2),
(3, 'Taufiq', 198702082022211007, 3),
(4, 'Eka Saputra', 199412162025211028, 6),
(5, 'Nurjaya Asih', 1968020619992031002, 3),
(6, 'Andi Romario', 199503112025211023, 3),
(7, 'Dhimas Ardito P', 198505052022211033, 6),
(8, 'Harun Cahyo Utomo', 199911082024211001, 2),
(9, 'Yhoni Yanuantoro', 197201222014091001, 3),
(10, 'Ade Febrian R', 200102022025211003, 6),
(11, 'M. Prasetiyo Utomo', 197605182023211005, 6),
(12, 'Fauzy Heryansyah', 1997080222025211015, 6),
(13, 'Gempur Sapari', 199108132025211039, 6),
(14, 'Kevin Fajar Kusuma', 100020003000, 2),
(15, 'Jati Kusumawardani', 198909062025042001, 5),
(16, 'Yanuar Mayor', 199001182025041002, 3),
(17, 'Koko Yanto Simamora', 199001212025041001, 4),
(18, 'Yusuf Abdul Majidnur', 199203232025041001, 1),
(19, 'Muhammad Iqbal Maulana', 199309042025041002, 2),
(20, 'Randy Dhanu Rahardja', 199403092025041002, 3),
(21, 'Ahmad Yusuf Ali Shofi', 199403292025041001, 4),
(22, 'Hindrya Meidina Fresty', 199605232025042003, 1),
(23, 'Aditya Pradana ', 199702082025041002, 2),
(24, 'Iqbaldi Pramadhan', 199812132025041002, 3),
(25, 'Mochammad Irsyad Hawari', 200007232025041002, 4),
(26, 'Fajar Lutfi Saldian', 200007252025041004, 1),
(27, 'Syam Sabila Saroh', 200011202025042004, 2),
(28, 'Nurul Annisa', 200012112025042001, 4),
(29, 'Rini Beatrix Laurentzia', 200112142025042001, 1),
(30, 'Muhammad Ivan Fadila', 200509072025042001, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas') DEFAULT 'petugas',
  `pegawai_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `pegawai_id`) VALUES
(1, '197002221991031003', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 1),
(2, '199309082025211015', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 2),
(3, '198702082022211007', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 3),
(4, '199412162025211028', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 4),
(5, '1968020619992031002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 5),
(6, '199503112025211023', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 6),
(7, '198505052022211033', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 7),
(8, '199911082024211001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 8),
(9, '197201222014091001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 9),
(10, '200102022025211003', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 10),
(11, '197605182023211005', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 11),
(12, '1997080222025211015', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 12),
(13, '199108132025211039', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 13),
(14, '100020003000', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 14),
(15, '198909062025042001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 15),
(16, '199001182025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 16),
(17, '199001212025041001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 17),
(18, '199203232025041001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 18),
(19, '199309042025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 19),
(20, '199403092025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 20),
(21, '199403292025041001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 21),
(22, '199605232025042003', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 22),
(23, '199702082025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 23),
(24, '199812132025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 24),
(25, '200007232025041002', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 25),
(26, '200007252025041004', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 26),
(27, '200011202025042004', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 27),
(28, '200012112025042001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 28),
(29, '200112142025042001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 29),
(30, '200509072025042001', '$2y$10$uR4pR3sFF8Ek36gTaE/OjOM1q2nL69QBxb9uLqhTr3xyYDhj0fYa6', 'petugas', 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `jadwal_karyawan`
--
ALTER TABLE `jadwal_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `liputan`
--
ALTER TABLE `liputan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_divisi` (`id_divisi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `pegawai_id` (`pegawai_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jadwal_karyawan`
--
ALTER TABLE `jadwal_karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `liputan`
--
ALTER TABLE `liputan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_karyawan`
--
ALTER TABLE `jadwal_karyawan`
  ADD CONSTRAINT `jadwal_karyawan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`);

--
-- Constraints for table `liputan`
--
ALTER TABLE `liputan`
  ADD CONSTRAINT `liputan_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
