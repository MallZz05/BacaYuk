-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 02:20 AM
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
-- Database: `bacayuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `BukuID` int(11) NOT NULL,
  `Judul` varchar(255) NOT NULL,
  `Penulis` varchar(255) NOT NULL,
  `Penerbit` varchar(255) NOT NULL,
  `TahunTerbit` int(4) NOT NULL,
  `Gambar` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `Halaman` int(11) NOT NULL DEFAULT 0,
  `Konten` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`BukuID`, `Judul`, `Penulis`, `Penerbit`, `TahunTerbit`, `Gambar`, `Halaman`, `Konten`) VALUES
(1, 'Atomic Habits', 'James Clear', 'Gramedia', 2018, 'atomic_habits.jpg', 12, '<h3>Atomic Habits</h3><p>Buku ini mengajarkan bahwa perubahan besar berasal dari kebiasaan kecil. James Clear memperkenalkan 4 hukum sederhana untuk membangun kebiasaan baik dan menghilangkan yang buruk.</p>'),
(2, 'Negeri Para Bedebah', 'Tere Liye', 'Republika', 2012, 'negeri_para_bedebah.jpg', 8, '<h3>Negeri Para Bedebah</h3><p>Novel ini mengisahkan perjalanan empat mahasiswa Indonesia yang merantau ke Amerika untuk menuntut ilmu.</p>'),
(3, 'Algoritma Pemograman', 'Johan Kurniawan', 'Informatika', 2020, 'algoritma_pemrograman.jpg', 16, '<h3>Algoritma pemograman</h3><p>Buku ini adalah panduan fundamental untuk memahami logika di balik pemrograman komputer.</p>'),
(4, 'Harry Potter', 'J.K. Rowling', 'Gramedia', 2000, 'harry_potter.jpg', 10, '<h3>Harry Potter</h3><p>Mengisahkan tentang seorang anak yatim piatu, Harry Potter, yang mengetahui bahwa dia adalah penyihir.</p>'),
(5, 'Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 'filosofi_teras.jpg', 12, '<h3>Filosofi Teras</h3><p>Henry Manampiring menghadirkan filsafat Stoa dengan cara yang sangat relevan dan mudah dipahami untuk kehidupan modern.</p>'),
(6, 'Laskar pelangi', 'Andrea Hirata', 'Bentang pustaka', 2017, 'laskar_pelangi.jpg', 18, '<h3>Laskar pelangi</h3><p>Novel legendaris karya Andrea Hirata ini mengisahkan perjalanan hangat dan mengharukan 10 anak dari keluarga sederhana di Belitung. Mereka menimba ilmu di SD Muhammadiyah, sebuah sekolah yang sederhana namun kaya akan nilai-nilai kehidupan, di bawah bimbingan dua guru yang luar biasa, Pak Harfan dan Bu Mus.\r\n\r\nDi tengah keterbatasan ekonomi, novel ini memotret dengan indah tentang arti persahabatan, kegigihan mengejar mimpi, dan kekuatan pendidikan sebagai alat perubahan. Latar Belitung yang indah menjadi saksi bisu dari perjuangan mereka yang penuh tawa dan air mata.\r\n\r\n\"Laskar Pelangi\" bukan sekadar sebuah cerita; ia adalah sebuah inspirasi yang telah menggerakkan hati jutaan pembaca di Indonesia, mengajarkan bahwa kekayaan sejati terletak pada kekayaan hati dan ilmu pengetahuan.</p>laskar_pelangi.jpg'),
(7, 'Psychology of Money', 'Morgan Housel', 'Gramedia', 2020, 'pyschology_of_money.jpg', 14, '<h3>Psychology of Money</h3><p>Buku ini bukan tentang cara menjadi kaya, tapi tentang cara berpikir soal uang.</p>'),
(8, 'Sejarah Dunia', 'Ernest Gombrich', 'Kepustakaan Populer Gramedia', 2005, 'sejarah_dunia.jpg', 20, '<h3>sejarah sunia yang Singkat</h3><p>Ernest Gombrich menyajikan perjalanan panjang sejarah umat manusia, dari zaman prasejarah hingga era atom.</p>'),
(9, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 'Gramedia', 2000, 'rich_dad_poor_dad.jpg', 12, '<h3>Rich Dad Poor Dad</h3><p>Buku ini menantang kebijaksanaan tradisional tentang uang. Robert Kiyosaki menceritakan pelajaran yang dia pelajari dari ayahnya.</p>'),
(10, 'Web Dasar', 'Budi Raharjo', 'Informatika', 2019, 'web_dasar.jpg', 10, '<h3>Web Dasar</h3><p>Buku ini adalah titik awal yang sempurna bagi siapa pun yang ingin belajar membuat website.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `koleksipribadi`
--

CREATE TABLE `koleksipribadi` (
  `KoleksiID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `TanggalDitambahkan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `PeminjamanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `TanggalPeminjaman` date NOT NULL,
  `TanggalPengembalian` date DEFAULT NULL,
  `StatusPeminjaman` enum('Dipinjam','Dikembalikan') NOT NULL DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ulasanbuku`
--

CREATE TABLE `ulasanbuku` (
  `UlasanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `Ulasan` text NOT NULL,
  `Rating` int(1) NOT NULL,
  `Tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Role` enum('admin','petugas','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Password`, `Email`, `NamaLengkap`, `Role`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@perpursin.com', 'Admin Perpursin', 'admin'),
(2, 'petugas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'petugas@perpursin.com', 'Petugas Perpursin', 'petugas'),
(3, 'anggota', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'anggota@perpursin.com', 'Anggota Perpursin', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`BukuID`);

--
-- Indexes for table `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD PRIMARY KEY (`KoleksiID`),
  ADD UNIQUE KEY `unique_user_book` (`UserID`,`BukuID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`PeminjamanID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indexes for table `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD PRIMARY KEY (`UlasanID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BukuID` (`BukuID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `BukuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  MODIFY `KoleksiID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `PeminjamanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  MODIFY `UlasanID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `koleksipribadi`
--
ALTER TABLE `koleksipribadi`
  ADD CONSTRAINT `koleksipribadi_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `koleksipribadi_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ulasanbuku`
--
ALTER TABLE `ulasanbuku`
  ADD CONSTRAINT `ulasanbuku_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ulasanbuku_ibfk_2` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
