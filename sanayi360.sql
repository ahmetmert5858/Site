-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 01 Ara 2024, 13:13:57
-- Sunucu sürümü: 8.3.0
-- PHP Sürümü: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `sanayi360`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `yorum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dükkan_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`id`, `kullanici_adi`, `yorum`, `created_at`, `dükkan_id`) VALUES
(86, 'deneme', 'm  mvh', '2024-11-30 13:16:51', 13),
(84, 'deneme', 'hjvhvhvh', '2024-11-30 13:16:32', 15),
(85, 'deneme', 'hhbhbkjkhbkh', '2024-11-30 13:16:42', 14),
(83, 'deneme', 'kj  jvhv', '2024-11-30 13:16:23', 16),
(82, 'deneme', 'kbjvhjbh', '2024-11-30 13:16:14', 17),
(81, 'deneme', 'nhjhkbh', '2024-11-30 13:16:04', 18),
(80, 'deneme', 'h vvhvjh', '2024-11-30 13:15:53', 19),
(79, 'deneme', 'm m vv ', '2024-11-30 13:15:38', 20),
(78, 'deneme', ' hjh  h', '2024-11-30 13:15:22', 21),
(77, 'deneme', 'hvbv', '2024-11-30 13:15:07', 23),
(76, 'deneme', 'gvgvg ', '2024-11-30 13:14:55', 24),
(75, 'deneme', 'gghgc', '2024-11-30 13:14:45', 26),
(74, 'deneme', 'bggbg', '2024-11-30 13:14:32', 29),
(68, 'deneme', 'b bb ', '2024-11-30 13:13:22', 35),
(69, 'deneme', 'tyffy', '2024-11-30 13:13:32', 34),
(70, 'deneme', 'fttf', '2024-11-30 13:13:50', 33),
(71, 'deneme', 'byyyg', '2024-11-30 13:13:59', 32),
(72, 'deneme', 'kjbgbgbg', '2024-11-30 13:14:10', 31),
(73, 'deneme', 'ubggu', '2024-11-30 13:14:23', 30),
(63, 'deneme', 'sj', '2024-11-29 18:56:26', 39),
(64, 'deneme', 'jbbj', '2024-11-30 13:12:16', 39),
(65, 'deneme', 'bhh', '2024-11-30 13:12:28', 38),
(66, 'deneme', 'fcf', '2024-11-30 13:12:54', 37),
(67, 'deneme', 'hv v', '2024-11-30 13:13:12', 36),
(62, 'deneme', 'fdıdfhhıdf', '2024-11-29 18:55:57', 31),
(61, 'deneme', 'deneme yorumu', '2024-11-27 07:18:38', 5),
(60, 'deneme', 'deneme 12', '2024-11-26 12:48:30', 12),
(59, 'deneme', 'deneme2', '2024-11-26 12:48:05', 2),
(58, 'deneme', 'deneme', '2024-11-26 12:47:45', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dükkanlar`
--

DROP TABLE IF EXISTS `dükkanlar`;
CREATE TABLE IF NOT EXISTS `dükkanlar` (
  `dükkan_id` int NOT NULL AUTO_INCREMENT,
  `dükkan_ismi` varchar(255) NOT NULL,
  `aciklama` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `kategori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dükkan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `dükkanlar`
--

INSERT INTO `dükkanlar` (`dükkan_id`, `dükkan_ismi`, `aciklama`, `created_at`, `kategori`) VALUES
(1, 'Cmy Motor Yenileme', 'Motor yenileme hizmetleri sunan dükkan.', '2024-11-19 16:35:31', 'Motor Yenileme'),
(2, 'Hasan Egzoz', 'Egzoz sistemleri tamiri ve değişimi hizmeti vermektedir.', '2024-11-17 15:35:31', 'Egzoz'),
(3, 'Kar Oto Klima', 'Oto klima bakım ve onarımı hizmeti.', '2024-11-17 14:41:31', 'Klima'),
(4, 'Maslakland Otomotiv', 'Otomotiv sektöründe geniş hizmet yelpazesi.', '2024-11-17 18:27:31', 'Otomotiv'),
(5, 'Maslak Mekanik', 'Araç mekanik tamir hizmetleri sunan dükkan.', '2024-11-17 18:17:31', 'Otomotiv'),
(6, 'Maslak Oto Döşeme', 'Otomobil döşeme ve iç mekan tamiri.', '2024-11-17 18:35:31', 'Otomotiv'),
(7, 'Maslak Oto Göçük', 'Oto göçük düzeltme ve hasar giderme hizmetleri.', '2024-11-17 14:43:31', 'Oto Göçük'),
(8, 'Maslak Oto Lastik Rotbalans', 'Lastik rotbalans ve bakım hizmetleri.', '2024-11-17 15:49:31', 'Göçük Düzeltme'),
(9, 'Maslak Oto Şanzıman', 'Şanzıman tamiri ve bakımı sunan dükkan.', '2024-11-17 17:54:31', 'Egzoz'),
(10, 'Maslak Turbo', 'Turbo tamiri ve bakımı hizmeti vermektedir.', '2024-11-17 18:35:31', 'Egzoz'),
(11, 'MK Oto Ekspertiz', 'Oto ekspertiz hizmetleri.', '2024-11-17 12:52:31', 'Oto Ekspertiz'),
(12, 'Pdrc Göçük Düzeltme', 'Göçük düzeltme ve onarım hizmetleri.', '2024-11-17 18:35:31', 'Göçük Düzeltme'),
(13, 'Akts Motor', 'Motor yenileme hizmeti sunan dükkan.', '2024-11-29 18:49:54', 'Motor Yenileme'),
(14, 'Ahmet Motor', 'Motor tamir ve bakım hizmeti sunmaktadır.', '2024-11-29 18:49:54', 'Motor Yenileme'),
(15, 'Akademi Ekspertiz', 'Araç ekspertiz hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Oto Ekspertiz'),
(16, 'Ak Egzoz', 'Egzoz tamiri ve bakım hizmetleri.', '2024-11-29 18:49:54', 'Egzoz'),
(17, 'Altay Klima', 'Klima bakım ve onarım hizmeti sunmaktadır.', '2024-11-29 18:49:54', 'Klima'),
(18, 'Bey Motor', 'Motor yenileme ve tamir hizmeti.', '2024-11-29 18:49:54', 'Motor Yenileme'),
(19, 'Detay Ekspertiz', 'Ekspertiz işlemleri yapmaktadır.', '2024-11-29 18:49:54', 'Oto Ekspertiz'),
(20, 'Elite Göçük', 'Oto göçük düzeltme hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Göçük Düzeltme'),
(21, 'Golden Ekspertiz', 'Ekspertiz hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Oto Ekspertiz'),
(22, 'Gözde Göçük', 'Araç göçük düzeltme hizmeti.', '2024-11-29 18:49:54', 'Göçük Düzeltme'),
(23, 'Güneş Otomotiv', 'Otomotiv sektörü için tamir ve bakım.', '2024-11-29 18:49:54', 'Otomotiv'),
(24, 'Güven Otomotiv', 'Tamir ve mekanik hizmetleri.', '2024-11-29 18:49:54', 'Mekanik'),
(25, 'Hızlı Otomotiv', 'Hızlı bakım ve tamir hizmeti.', '2024-11-29 18:49:54', 'Otomotiv'),
(26, 'İlhan Motor', 'Motor tamir ve bakım hizmetleri.', '2024-11-29 18:49:54', 'Motor Yenileme'),
(27, 'Kocabaş Egzoz', 'Egzoz sistemleri tamiri.', '2024-11-29 18:49:54', 'Egzoz'),
(28, 'Master Göçük', 'Oto göçük düzeltme hizmetleri.', '2024-11-29 18:49:54', 'Göçük Düzeltme'),
(29, 'Mega Egzoz', 'Egzoz tamiri ve değişimi hizmeti.', '2024-11-29 18:49:54', 'Egzoz'),
(30, 'Net Ekspertiz', 'Araç ekspertiz hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Ekspertiz'),
(31, 'Nova Göçük', 'Oto göçük düzeltme ve hasar giderme hizmetleri.', '2024-11-29 18:49:54', 'Göçük Düzeltme'),
(32, 'Onur Klima', 'Klima tamir ve bakım hizmetleri.', '2024-11-29 18:49:54', 'Klima'),
(33, 'Prestij Klima', 'Klima bakım ve onarım hizmeti.', '2024-11-29 18:49:54', 'Klima'),
(34, 'Serin Klima', 'Araç klimaları için bakım hizmetleri.', '2024-11-29 18:49:54', 'Klima'),
(35, 'Usta Egzoz', 'Egzoz tamiri ve bakım hizmeti.', '2024-11-29 18:49:54', 'Egzoz'),
(36, 'Uzman Ekspertiz', 'Ekspertiz hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Ekspertiz'),
(37, 'VIP Ekspertiz', 'Araç ekspertiz hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Ekspertiz'),
(38, 'Yıldız Göçük', 'Araç göçük düzeltme hizmetleri sunmaktadır.', '2024-11-29 18:49:54', 'Göçük Düzeltme'),
(39, 'Yıldız Otomotiv', 'Otomotiv tamir ve bakım hizmetleri.', '2024-11-29 18:49:54', 'Otomotiv');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` enum('admin','dukkan_sahibi','kullanici') DEFAULT 'kullanici',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kullanici_adi` (`kullanici_adi`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`, `rol`) VALUES
(1, 'deneme', 'deneme', 'kullanici'),
(9, 'deneme3', 'deneme3', 'kullanici'),
(2, 'denememre', 'deneme', 'kullanici'),
(8, 'deneme2', 'deneme2', 'kullanici'),
(3, 'admindeneme', 'admindeneme', 'admin'),
(4, 'dükkansahibideneme', 'dükkansahibideneme', 'dukkan_sahibi'),
(11, 'deneme7', '123', 'kullanici'),
(10, 'deneme4', 'deneme3', 'kullanici'),
(12, 'dd', 'dd', 'kullanici');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(255) NOT NULL,
  `dükkan_id` int NOT NULL,
  `hiz` int NOT NULL,
  `fiyat` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `ratings`
--

INSERT INTO `ratings` (`id`, `kullanici_adi`, `dükkan_id`, `hiz`, `fiyat`, `created_at`) VALUES
(50, 'deneme', 38, 2, 2, '2024-11-30 13:12:25'),
(51, 'deneme', 37, 2, 3, '2024-11-30 13:12:52'),
(52, 'deneme', 36, 2, 2, '2024-11-30 13:13:10'),
(53, 'deneme', 35, 3, 2, '2024-11-30 13:13:19'),
(54, 'deneme', 34, 2, 3, '2024-11-30 13:13:29'),
(55, 'deneme', 33, 4, 4, '2024-11-30 13:13:47'),
(56, 'deneme', 32, 4, 1, '2024-11-30 13:13:57'),
(57, 'deneme', 31, 1, 4, '2024-11-30 13:14:07'),
(58, 'deneme', 30, 2, 3, '2024-11-30 13:14:20'),
(59, 'deneme', 29, 3, 3, '2024-11-30 13:14:29'),
(60, 'deneme', 26, 5, 5, '2024-11-30 13:14:42'),
(61, 'deneme', 24, 1, 1, '2024-11-30 13:14:52'),
(62, 'deneme', 23, 3, 3, '2024-11-30 13:15:02'),
(63, 'deneme', 21, 3, 3, '2024-11-30 13:15:19'),
(64, 'deneme', 21, 3, 3, '2024-11-30 13:15:30'),
(65, 'deneme', 20, 4, 3, '2024-11-30 13:15:36'),
(66, 'deneme', 19, 5, 5, '2024-11-30 13:15:49'),
(44, 'deneme', 1, 5, 5, '2024-11-26 12:46:36'),
(45, 'deneme', 2, 5, 5, '2024-11-26 12:48:10'),
(46, 'deneme', 12, 5, 5, '2024-11-26 12:48:25'),
(47, 'deneme', 31, 2, 3, '2024-11-29 18:55:52'),
(48, 'deneme', 39, 2, 2, '2024-11-29 18:56:21'),
(49, 'deneme', 39, 3, 2, '2024-11-30 13:12:14'),
(67, 'deneme', 18, 5, 2, '2024-11-30 13:16:01'),
(68, 'deneme', 17, 2, 2, '2024-11-30 13:16:11'),
(69, 'deneme', 16, 2, 3, '2024-11-30 13:16:20'),
(70, 'deneme', 15, 3, 4, '2024-11-30 13:16:29'),
(71, 'deneme', 14, 3, 2, '2024-11-30 13:16:39'),
(72, 'deneme', 13, 3, 4, '2024-11-30 13:16:48'),
(73, 'deneme', 12, 4, 2, '2024-11-30 13:17:01');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
