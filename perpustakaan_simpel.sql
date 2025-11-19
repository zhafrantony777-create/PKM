-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2025 pada 04.04
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_simpel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `rak` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `pengarang`, `rak`, `stok`) VALUES
(1, 'Dasar-Dasar Pemrograman Web', 'Budi Hartono', 'A1', 10),
(2, 'Sejarah Dunia yang Disembunyikan', 'Jonathan Black', 'C3', 5),
(3, 'Filosofi Teras: Hidup Tenang Tanpa Drama', 'Henry Manampiring', 'B2', 8),
(4, 'Algoritma dan Struktur Data', 'Rinaldi Munir', 'A1', 15),
(5, 'Kumpulan Cerpen: Matahari Senja', 'Dewi Lestari', 'D1', 7),
(6, 'bunga pelangi', 'adit', 'Dongeng', 1),
(7, 'bunga cntik', 'josep', 'novel', 0),
(8, 'penjara super', 'bruno', 'novel', 1),
(9, 'Jaringan Komputer', 'Sena', '12', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operator`
--

CREATE TABLE `operator` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `operator`
--

INSERT INTO `operator` (`id`, `username`, `password`) VALUES
(1, 'admin123', '$2y$10$R2vEukwzHQ6KqejuNibqUudhnaZqNVrLshC6Qudw1Za7SXFvcYX92');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas` varchar(100) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `rak` varchar(50) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL DEFAULT curdate(),
  `tenggat` date NOT NULL,
  `dikembalikan` enum('ya','tidak') NOT NULL DEFAULT 'tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `nis`, `nama`, `kelas`, `id_buku`, `judul`, `rak`, `tanggal_pinjam`, `tenggat`, `dikembalikan`) VALUES
(1, '', 'aditya sabana', 'XII', 1, 'Dasar-Dasar Pemrograman Web', 'A1', '2025-11-14', '2025-11-21', 'ya'),
(2, '', 'limhgd', 'X1', 7, 'bunga cntik', 'novel', '2025-11-14', '2025-11-21', 'ya'),
(3, '', 'bruno', 'XII', 7, 'bunga cntik', 'novel', '2025-11-15', '2025-11-22', 'tidak'),
(4, '', 'brunowell', 'XII', 4, 'Algoritma dan Struktur Data', 'A1', '2025-11-15', '2025-11-22', 'ya'),
(5, '', 'jamaludin', 'X1', 6, 'bunga pelangi', 'Dongeng', '2025-11-17', '2025-11-24', 'ya'),
(6, '', 'jamaludin', 'X1', 1, 'Contoh Buku A', 'A1', '2025-11-17', '2025-11-24', 'ya'),
(12, '', 'asari', 'X1', 4, 'Algoritma dan Struktur Data', 'A1', '2025-11-17', '2025-11-24', 'tidak'),
(14, '', 'elisa', 'X1', 4, 'Algoritma dan Struktur Data', 'A1', '2025-11-17', '2025-11-24', 'tidak'),
(15, '', 'gaby', 'X1', 7, 'bunga cntik', 'novel', '2025-11-17', '2025-11-24', 'tidak'),
(16, '', 'talip', 'X1', 6, 'bunga pelangi', 'Dongeng', '2025-11-17', '2025-11-24', 'tidak'),
(17, '', 'Adi Kurnia Sena', 'RPL', 4, 'Algoritma dan Struktur Data', 'A1', '2025-11-18', '2025-11-25', 'ya');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `operator`
--
ALTER TABLE `operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
