-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2020 at 03:00 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wartaberita1.0`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(7) NOT NULL,
  `no_induk` varchar(70) NOT NULL,
  `password` varchar(16) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `status` text NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto_profil` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `no_induk`, `password`, `nama`, `status`, `last_login`, `foto_profil`) VALUES
(4, '24010316140071', '12345', 'difa reynikha fatullah', 'Wartawan', '2020-10-15 00:00:00', 'download (1).jpg'),
(6, 'admin', 'admin', 'Dio Alfian', 'Admin', '2020-10-15 00:00:00', ''),
(7, '24010316140065', 'Sudrajad1234', 'Aditya ', 'Wartawan', '2019-07-02 00:00:00', 'avatar-placeholder.png'),
(8, '24010316140072', 'Sudrajad1234', 'Faris Ramadhan', 'Wartawan', '2019-07-03 23:09:31', 'avatar-placeholder.png'),
(9, '240103145133', '123456', 'Ewa Respati', 'Wartawan', '2019-07-04 10:18:52', 'avatar-placeholder.png');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Olahraga'),
(2, 'Musik'),
(3, 'Model dan Gaya'),
(4, 'Fotografi'),
(5, 'Otomotif'),
(6, 'Kuliner'),
(7, 'Wisata');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_posting` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `isi_komentar` varchar(50) NOT NULL,
  `tanggal_waktu_komentar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `id_anggota` int(11) NOT NULL,
  `id_posting` int(11) NOT NULL,
  `is_like` tinyint(4) NOT NULL DEFAULT '0',
  `is_dislike` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE `posting` (
  `id_posting` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(20) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `file_gambar` varchar(255) NOT NULL,
  `tanggal_posting` date NOT NULL,
  `no_induk` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posting`
--

INSERT INTO `posting` (`id_posting`, `id_kategori`, `judul`, `deskripsi`, `file_gambar`, `tanggal_posting`, `no_induk`) VALUES
(9, 2, 'Anies Wacanakan Park', 'Jakarta, CNN Indonesia -- Gubernur DKI Jakarta Anies Baswedan mewacanakan kebijakan wajib uji emisi ', 'tiger_artwork_hd.jpg', '2019-07-02', '24010316140065'),
(234, 2, 'Praktik Kerja Lapang', 'Dilansir dari lipi.go.id, sekitar 9ribu spesies tersebut adalah tanaman yang disinyalir punya khasit', 'masjid-agung-jawa-tengah-majt-semarang.jpg', '2019-07-04', '24010316140071'),
(236, 3, 'Praktik Kerja Lapang', 'ekitar 1200an siswa di Solo yang tidak mendapatkan Sekolah Negeri dalam PPDB 2019 ini bisa mencari s', 'masjid-agung-jawa-tengah-majt-semarang.jpg', '2019-07-04', '24010316140071');

-- --------------------------------------------------------

--
-- Table structure for table `posting_berita_foto`
--

CREATE TABLE `posting_berita_foto` (
  `id_berita_foto` int(11) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `tanggal_posting` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `no_induk` varchar(70) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posting_berita_foto`
--

INSERT INTO `posting_berita_foto` (`id_berita_foto`, `judul`, `tanggal_posting`, `no_induk`, `image`) VALUES
(1, 'Solobaru menjadi kota idaman', '2019-07-03 10:38:30', '24010316140071', '9231.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`no_induk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_posting` (`id_posting`) USING BTREE,
  ADD KEY `id_anggota` (`id_anggota`) USING BTREE;

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`id_anggota`,`id_posting`),
  ADD KEY `id_posting` (`id_posting`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`id_posting`);

--
-- Indexes for table `posting_berita_foto`
--
ALTER TABLE `posting_berita_foto`
  ADD PRIMARY KEY (`id_berita_foto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posting`
--
ALTER TABLE `posting`
  MODIFY `id_posting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `posting_berita_foto`
--
ALTER TABLE `posting_berita_foto`
  MODIFY `id_berita_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_posting`) REFERENCES `posting` (`id_posting`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`id_posting`) REFERENCES `posting` (`id_posting`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
