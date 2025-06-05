-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 02:00 PM
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
-- Database: `gbite_query`
--

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `quantity` int(100) NOT NULL,
  `id_chart` int(11) NOT NULL,
  `id_makanan` int(11) DEFAULT NULL,
  `id_login` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chart`
--

INSERT INTO `chart` (`quantity`, `id_chart`, `id_makanan`, `id_login`) VALUES
(10, 1, 20, 19);

-- --------------------------------------------------------

--
-- Table structure for table `login_gbite`
--

CREATE TABLE `login_gbite` (
  `Username` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `id_login` int(11) NOT NULL,
  `email_login` varchar(100) NOT NULL,
  `no_telp` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_gbite`
--

INSERT INTO `login_gbite` (`Username`, `Password`, `id_login`, `email_login`, `no_telp`, `status`) VALUES
('ijah', 'ijah', 15, 'eli@gmail.com', 3265, 'user'),
('jessi', 'blup', 16, 'jesijes@gmail.com', 3737, 'user'),
('saya', 'saya', 17, 'saya@gmail.com', 2147483647, 'admin'),
('Aliezzar', '123', 19, 'aliezzar42@gmail.com', 2147483647, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `makanan`
--

CREATE TABLE `makanan` (
  `Nama_makanan` text NOT NULL,
  `Harga_makanan` int(225) NOT NULL,
  `id_makanan` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `Maps` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makanan`
--

INSERT INTO `makanan` (`Nama_makanan`, `Harga_makanan`, `id_makanan`, `deskripsi`, `foto`, `Maps`) VALUES
('Takoyaki', 13, 16, 'Takoyaki adalah camilan khas Jepang berbentuk bola-bola kecil yang renyah di luar dan lembut di dalam, berisi potongan gurita segar, daun bawang, dan jahe merah yang menggugah selera. Disajikan dengan siraman saus takoyaki yang gurih manis, taburan bonito flakes (ikan kering serut), dan mayones lembut, setiap gigitan takoyaki menghadirkan perpaduan rasa yang lezat dan autentik. Cocok dinikmati kapan saja, takoyaki kami dikemas higienis dan siap disantap—praktis untuk Anda yang ingin mencicipi cita rasa Jepang tanpa harus keluar rumah.', 'takoyaki.jpg', 'Gading fajar'),
('Seblak', 20000, 17, 'Seblak adalah makanan khas Bandung yang terkenal dengan cita rasa pedas gurih dan aroma kencur yang khas. Terbuat dari kerupuk basah yang dimasak bersama aneka topping seperti bakso, sosis, makaroni, telur, dan sayuran segar, seblak kami menawarkan sensasi kenyal dan pedas yang bikin nagih. Cocok untuk pencinta makanan berkuah pedas, seblak ini dikemas praktis dan higienis, siap dinikmati kapan saja untuk memuaskan selera Anda akan kuliner nusantara yang menggugah selera.', 'seblak.jpg', 'Gambar'),
('Donat', 5000, 18, 'Donat kami adalah camilan manis yang lembut dan empuk dengan tekstur yang ringan dan mengembang sempurna. Dibuat dari bahan-bahan berkualitas, donat ini hadir dengan berbagai topping menggoda seperti cokelat leleh, keju parut, meses, hingga gula halus yang klasik. Cocok dinikmati sebagai teman minum kopi atau camilan santai bersama keluarga, donat kami dikemas higienis dan siap memanjakan lidah Anda dengan rasa manis yang pas dan tampilan yang menggugah selera.', 'donat.jpg', 'Gading fajar'),
('Baso Aci', 20000, 19, 'Baso aci adalah camilan khas Garut yang digemari karena teksturnya yang kenyal dan rasa kuah pedas gurih yang menggoda. Terbuat dari tepung aci berkualitas, disajikan dengan isian lengkap seperti siomay kering, cuanki, pilus cikur, dan tambahan cabai serta jeruk limau untuk sensasi segar dan pedas yang nendang. Cocok untuk pencinta makanan berkuah pedas dan praktis, baso aci kami dikemas higienis dan siap disantap kapan saja untuk menghangatkan hari Anda.', 'basoaci.jpg', 'Gading fajar'),
('Dimsum', 20000, 20, 'Dimsum mentai adalah perpaduan sempurna antara dimsum lembut yang diisi daging ayam atau udang pilihan, dengan saus mentai creamy khas Jepang yang gurih dan sedikit pedas. Sausnya yang meleleh di atas dimsum menambah cita rasa yang kaya dan menggugah selera di setiap suapan. Cocok dinikmati sebagai camilan premium atau hidangan spesial, dimsum mentai kami dikemas higienis, praktis, dan siap dinikmati kapan saja untuk pengalaman kuliner yang istimewa.', 'dimsummentai.jpg', 'Gading fajar'),
('Pancong', 50, 21, 'Kue pancong adalah jajanan tradisional yang terbuat dari campuran kelapa parut segar, tepung beras, dan santan, menghasilkan tekstur renyah di luar namun lembut dan gurih di dalam. Dipanggang dengan cetakan khas, kue ini memiliki aroma kelapa yang harum dan rasa yang otentik, cocok dinikmati hangat-hangat. Kue pancong kami hadir dengan berbagai topping kekinian seperti cokelat, keju, dan susu kental manis, menjadikannya camilan sempurna untuk segala suasana.', 'pancong.jpg', 'Gading Fajar'),
('Gohyong', 15000, 22, 'Gohyong adalah hidangan khas Peranakan yang terbuat dari daging cincang, udang, dan rempah pilihan yang dibungkus dengan lapisan kembang tahu, lalu digoreng hingga renyah keemasan. Rasanya gurih dan sedikit manis, dengan aroma rempah yang khas dan menggugah selera. Cocok disajikan dengan saus cocolan khas atau nasi hangat, gohyong kami dikemas higienis dan siap disantap sebagai lauk spesial atau camilan lezat yang memuaskan.', 'gohyong.jpg', 'Gading fajar'),
('Burger bangor', 35, 23, 'Burger Bangor adalah burger kekinian yang dikenal dengan roti bun lembut dan isian daging sapi tebal yang juicy, dimasak sempurna dengan bumbu khas yang kaya rasa. Dipadukan dengan saus spesial Bangor yang gurih dan sedikit manis, ditambah keju leleh, sayuran segar, dan topping melimpah, menciptakan sensasi rasa yang memanjakan lidah. Cocok untuk penggemar burger sejati, Burger Bangor kami dikemas praktis dan higienis, siap jadi pilihan santapan lezat kapan saja.', 'burger.jpg', 'Gding fajar');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `total_kuantitas_makanan` int(225) NOT NULL,
  `sub_total_makanan` int(225) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `jam_ambil` time(6) NOT NULL,
  `catatan` varchar(255) NOT NULL,
  `id_chart` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(255) NOT NULL,
  `ulasan` varchar(255) NOT NULL,
  `bintang` int(255) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_makanan` int(11) DEFAULT NULL,
  `id_pemesanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chart`
--
ALTER TABLE `chart`
  ADD PRIMARY KEY (`id_chart`),
  ADD KEY `id_makanan` (`id_makanan`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `login_gbite`
--
ALTER TABLE `login_gbite`
  ADD PRIMARY KEY (`id_login`);

--
-- Indexes for table `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id_makanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_login` (`id_login`),
  ADD KEY `id_chart` (`id_chart`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id_makanan` (`id_makanan`),
  ADD KEY `id_login_2` (`id_login`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chart`
--
ALTER TABLE `chart`
  MODIFY `id_chart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_gbite`
--
ALTER TABLE `login_gbite`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `makanan`
--
ALTER TABLE `makanan`
  MODIFY `id_makanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chart`
--
ALTER TABLE `chart`
  ADD CONSTRAINT `chart_ibfk_1` FOREIGN KEY (`id_makanan`) REFERENCES `makanan` (`id_makanan`),
  ADD CONSTRAINT `chart_ibfk_3` FOREIGN KEY (`id_login`) REFERENCES `login_gbite` (`id_login`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login_gbite` (`id_login`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id_login`) REFERENCES `login_gbite` (`id_login`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`id_makanan`) REFERENCES `makanan` (`id_makanan`),
  ADD CONSTRAINT `rating_ibfk_3` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
