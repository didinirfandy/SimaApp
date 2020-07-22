-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jul 2020 pada 18.10
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asetdb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_user`
--

CREATE TABLE `app_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_pegawai` varchar(60) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `ktp` varchar(20) NOT NULL,
  `role` enum('1','2','3') DEFAULT NULL COMMENT '1=Aset;2=Wakasek;3=Kepsek',
  `genre` enum('1','2') DEFAULT NULL COMMENT '1=Laki-laki;2=Perempuan',
  `tgl` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `valid` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `app_user`
--

INSERT INTO `app_user` (`user_id`, `username`, `password`, `nama_pegawai`, `nik`, `ktp`, `role`, `genre`, `tgl`, `status`, `valid`, `image`) VALUES
(1, 'Aset', 'e10adc3949ba59abbe56e057f20f883e', 'Bagian Aset', 'P12323', '1235789123123124123', '1', '1', '2020-07-07 23:01:32', 1, 1, 'default_laki.png'),
(2, 'Wakasek', 'e10adc3949ba59abbe56e057f20f883e', 'Wakasek Sarana', '123th23', '321638201080009', '2', '2', '2020-06-14 18:42:03', 0, 1, 'default_cewe.png'),
(3, 'Kepsek', 'e10adc3949ba59abbe56e057f20f883e', 'Kepala Sekolah', '123th23', '321638201080009', '3', '2', '2020-06-14 18:40:44', 0, 1, 'default_cewe.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `app_user`
--
ALTER TABLE `app_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `app_user`
--
ALTER TABLE `app_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
