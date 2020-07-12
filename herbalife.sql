-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 22 Mei 2020 pada 09.41
-- Versi Server: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `herbalife`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `password`, `username`, `firstname`, `lastname`, `address`, `telp`, `image`) VALUES
(6, '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `analisis`
--

CREATE TABLE `analisis` (
  `fk_id_users` int(11) NOT NULL,
  `id_analisis` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `usia` float NOT NULL,
  `tinggi` float NOT NULL,
  `berat_badan` float NOT NULL,
  `lemak_tubuh` float NOT NULL,
  `kadar_air` float NOT NULL,
  `massa_otot` float NOT NULL,
  `postur_tubuh` float NOT NULL,
  `bmr_kalori` float NOT NULL,
  `usia_sel` float NOT NULL,
  `massa_tulang` float NOT NULL,
  `lemak_perut` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `analisis`
--

INSERT INTO `analisis` (`fk_id_users`, `id_analisis`, `nama`, `usia`, `tinggi`, `berat_badan`, `lemak_tubuh`, `kadar_air`, `massa_otot`, `postur_tubuh`, `bmr_kalori`, `usia_sel`, `massa_tulang`, `lemak_perut`) VALUES
(0, 1, 'Fanina', 22, 158, 51, 20, 34, 34, 5, 8, 9, 1, 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(10) NOT NULL,
  `fk_id_user` int(10) NOT NULL,
  `fk_id_produk` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id_paket` int(100) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `keterangan_paket` varchar(100) NOT NULL,
  `manfaat_paket` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id_paket`, `nama_paket`, `keterangan_paket`, `manfaat_paket`, `image`) VALUES
(1, 'Paket Turun BB', 'Menurunkan BB', 'Ideal Sehat', 'Shake8.jpg'),
(2, 'Paket Naik BB', 'MANTAP', 'Menaikkan BB', 'ppp1.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(10) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kode_produk` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kode_produk`, `keterangan`, `image`) VALUES
(13, 'Formula 1 Nutritional Shake Mix', '001', 'menyediakan semua yang Anda butuhkan dalam makanan sehat yang seimbang serta tinggi akan serat dan n', 'SHAKE1.jpg'),
(14, 'Herbal Aloe Concentrate', '002', 'Mendukung pencernaan yang sehat, Meringankan gangguan pencernaan, Memberi rasa nyaman di dalam perut', 'Aloe.jpg'),
(15, 'Nrg Tea', '003', 'Isi kembali tenaga Anda dengan teh campuran guarana, pekoe jeruk, dan kulit lemon ini. Kafein yang d', 'nrg.jpg'),
(16, 'Personalized Protein Powder ', '004', 'produk protein berkualitas tinggi serta bebas lemak yang mendukung program weight management dan men', 'ppp.jpg'),
(17, 'Mixed Fiber', '005', 'Sebagai sumber serat baik yang dapat membantu memelihara sistem pencernaan Anda', 'mixed.jpg'),
(18, 'Herbal Tea Concentrate ', '006', 'Meningkatkan energi. Rendah lemak dan karbohidrat. Tepat untuk melengkapi program penurunan berat ba', 'thermo.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `firstname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usia` int(10) NOT NULL,
  `telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fk_id_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_users`, `firstname`, `lastname`, `address`, `usia`, `telp`, `username`, `password`, `image`, `fk_id_level`) VALUES
(1, 'Fanina Meidina', 'ww', 'Jl. Soekarno Hatta', 0, '098765432123', 'fanina', '9413d86bc4a569e30d31e44a0cdeb9b8', '', 0),
(2, 'Muhammad', 'Robbi', 'Bojonegoro', 0, '098765432123', 'robet', '86ec96d8d22e0bbc3ca9a10ecea5bdc1', '21.JPG', 0),
(4, 'Zuli', 'Anah', 'Malang', 52, '098765432123', 'zuli', '3b711d959316d5442aed0b62630aebce', '3a1.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `analisis`
--
ALTER TABLE `analisis`
  ADD PRIMARY KEY (`id_analisis`),
  ADD KEY `fk_id_users` (`fk_id_users`),
  ADD KEY `fk_id_users_2` (`fk_id_users`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD KEY `fk_id_level` (`fk_id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `analisis`
--
ALTER TABLE `analisis`
  MODIFY `id_analisis` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
