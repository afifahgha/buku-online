-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 06:51 AM
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
-- Database: `buku_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kategori`, `judul_buku`, `penulis`, `penerbit`, `tahun_terbit`, `gambar`, `tanggal_input`) VALUES
(2, 1, 'Filosofi Teras', 'Henry Manampiring', 'Kompas Media Nusantara', '2018', 'Filosofi Teras_Henry Manampiring.jpg', '2025-11-27 17:01:15'),
(4, 3, 'Unseen World', 'Liz Moore', 'Amazon', '2016', 'Unseen World_Liz Moore.jpg', '2025-11-28 08:14:53'),
(5, 1, 'Cantik Itu Luka', 'Eka Kurniawan', 'Jendela', '2002', 'Cantik Itu Luka_Eka Kurniawan.jpg', '2025-11-28 08:16:08'),
(7, 3, 'The Secret Diary of Mona Hasan', 'Salma Hussain', 'Tundra', '2022', 'The Secret Diary of Mona Hasan_Salma Hussain.jpg', '2025-11-28 10:53:36'),
(8, 10, 'Madilog', 'Tan Malaka', 'Penerbit Widjaya', '1943', 'Madilog_Tan Malaka.jpg', '2025-11-28 11:24:46'),
(9, 1, 'Gadis Kretek', 'Ratih Kumala', 'Gramedia', '2012', 'Gadis Kretek_Ratih Kumala.jpg', '2025-11-28 11:26:25'),
(10, 3, 'House That Whispers', 'Lin Thompson', 'Brown Books for Young Readers', '2022', 'House That Whispers_Lin Thompson.jpg', '2025-11-28 11:28:07'),
(11, 1, 'Tentang Kamu', 'Tere Liye', 'Republika', '2016', 'Tentang Kamu_Tere Liye.jpg', '2025-11-28 11:29:03'),
(12, 3, 'Matilda', 'Roald Dahl', 'Gramedia', '1988', 'Matilda_Roald Dahl.jpg', '2025-11-28 11:30:24'),
(13, 1, 'Negeri di Ujung Tanduk', 'Tere Liye', 'Gramedia', '2013', 'Negeri di Ujung Tanduk_Tere Liye.jpg', '2025-11-28 11:46:23'),
(14, 1, 'Sepenggal Kisah Anak Rantau', 'Ahmad Fuadi', 'FALCOM', '2017', 'Sepenggal Kisah Anak Rantau_Ahmad Fuadi.jpg', '2025-11-28 11:47:57'),
(15, 10, 'Sejarah Raja-Raja Jawa', 'Sri Wintala Ahmad', 'Ragam Media', '2010', 'Sejarah Raja-Raja Jawa_Sri Wintala Ahmad.jpg', '2025-11-28 11:49:28'),
(16, 3, 'Rubah Serakah Pohon Ajaib', 'Lilis Krisnawati', 'Intar Pariwara', '2017', 'Rubah Serakah Pohon Ajaib_Lilis Krisnawati.jpg', '2025-11-28 11:50:53'),
(18, 3, 'Mihi di Pulau Kapuk', 'Endah Kurnia', 'Gramedia', '2017', 'Mihi di Pulau Kapuk_Endah Kurnia.jpg', '2025-11-28 11:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `tanggal_input` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tanggal_input`) VALUES
(1, 'Novel', '2025-11-27 16:11:21'),
(3, 'Buku Anak', '2025-11-27 16:11:21'),
(10, 'Buku Sejarah', '2025-11-28 11:20:26'),
(12, 'Horror', '2025-11-28 12:46:08'),
(13, 'Romance', '2025-11-28 12:46:18'),
(14, 'Action', '2025-11-28 12:46:26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'afifah', 'afifahgha@gmail.com', '$2y$10$Z3ygY2e1H845vlh4rbZNTup9Vvn7u3Rx1rCNLlSzQq3XvfgVr42Ti'),
(2, 'adelia', 'adelia@gmail.com', '$2y$10$emgoVRXabDQDeBhvc365tecYkIF35DoJJwr6OvtzcEeZNPBmAXg22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`) USING BTREE;

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
