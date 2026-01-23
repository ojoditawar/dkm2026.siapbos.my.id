-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.2.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table dkm.anggarans
CREATE TABLE IF NOT EXISTS `anggarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun_id` bigint unsigned NOT NULL,
  `level1_id` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level2_id` bigint unsigned DEFAULT NULL,
  `level3_id` bigint unsigned NOT NULL,
  `sumber_dana_id` bigint unsigned DEFAULT NULL,
  `sub_dana_id` bigint unsigned NOT NULL,
  `uraian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(10,2) DEFAULT '0.00',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_items` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `anggarans_tahun_id_level3_id_sub_dana_id_unique` (`tahun_id`,`level3_id`,`sub_dana_id`),
  KEY `anggarans_level3_id_foreign` (`level3_id`),
  KEY `anggarans_sub_dana_id_foreign` (`sub_dana_id`),
  KEY `anggarans_level1_id_foreign` (`level1_id`),
  KEY `anggarans_level2_id_foreign` (`level2_id`),
  KEY `anggarans_sumber_dana_id_foreign` (`sumber_dana_id`),
  CONSTRAINT `anggarans_level1_id_foreign` FOREIGN KEY (`level1_id`) REFERENCES `level1s` (`akun1`) ON DELETE CASCADE,
  CONSTRAINT `anggarans_level2_id_foreign` FOREIGN KEY (`level2_id`) REFERENCES `level2s` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggarans_level3_id_foreign` FOREIGN KEY (`level3_id`) REFERENCES `level3s` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggarans_sub_dana_id_foreign` FOREIGN KEY (`sub_dana_id`) REFERENCES `sub_danas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggarans_sumber_dana_id_foreign` FOREIGN KEY (`sumber_dana_id`) REFERENCES `sumber_danas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggarans_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahuns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.anggarans: ~0 rows (approximately)
INSERT INTO `anggarans` (`id`, `tahun_id`, `level1_id`, `level2_id`, `level3_id`, `sumber_dana_id`, `sub_dana_id`, `uraian`, `jumlah`, `keterangan`, `detail_items`, `created_at`, `updated_at`) VALUES
	(1, 1, '4', 5, 5, 1, 1, 'Pendapatan dari Kotak Amal Masjid', 0.00, NULL, NULL, '2025-11-15 19:45:34', '2025-11-15 19:45:34'),
	(2, 1, '5', 6, 6, 1, 1, 'Pembayaran Honor Imam bulan tahun 2025', 0.00, NULL, NULL, '2025-11-15 23:58:24', '2025-11-15 23:59:20');

-- Dumping structure for table dkm.anggaran_detail_items
CREATE TABLE IF NOT EXISTS `anggaran_detail_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `anggaran_id` bigint unsigned NOT NULL,
  `uraian_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `anggaran_detail_items_anggaran_id_index` (`anggaran_id`),
  CONSTRAINT `anggaran_detail_items_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggarans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.anggaran_detail_items: ~2 rows (approximately)
INSERT INTO `anggaran_detail_items` (`id`, `anggaran_id`, `uraian_detail`, `jumlah`, `satuan`, `harga`, `total`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Kotak Amal Sholat Jumat', 53, 'hari', 4500000.00, 238500000.00, '2025-11-15 19:45:34', '2025-11-15 19:45:34'),
	(2, 2, 'Honor Imam', 12, 'bulan', 4000000.00, 48000000.00, '2025-11-15 23:58:24', '2025-11-15 23:58:24');

-- Dumping structure for table dkm.asnafs
CREATE TABLE IF NOT EXISTS `asnafs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.asnafs: ~8 rows (approximately)
INSERT INTO `asnafs` (`id`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'Fakir', 'Orang yang sangat miskin, tidak memiliki harta dan tidak mampu bekerja atau mencari nafkah.', '2025-11-15 01:40:14', '2025-11-15 01:40:14'),
	(2, 'Miskin', 'Orang yang kurang mampu, punya penghasilan tapi tidak cukup untuk memenuhi kebutuhan pokok sehari-hari.', '2025-11-15 01:40:30', '2025-11-15 01:40:30'),
	(3, 'Amil', 'Petugas pengelola zakat (pengumpul, pencatat, penyalur) yang berhak mendapat bagian sebagai imbalan kerja.', '2025-11-15 01:40:51', '2025-11-15 01:40:51'),
	(4, 'Mualaf', 'Orang yang baru masuk Islam atau sedang condong ke Islam, diberi zakat untuk memperkuat iman dan menarik hati.', '2025-11-15 01:41:06', '2025-11-15 01:41:06'),
	(5, 'Riqab', 'Budak atau hamba sahaya yang ingin memerdekakan diri (dulu), kini diartikan sebagai pembebasan dari perbudakan modern (misal: korban perdagangan manusia).', '2025-11-15 01:41:23', '2025-11-15 01:41:23'),
	(6, 'Gharimin', 'Orang yang terlilit utang untuk kebutuhan yang halal dan mendesak, tidak mampu membayar.', '2025-11-15 01:41:39', '2025-11-15 01:41:39'),
	(7, 'Fi Sabilillah', 'Orang yang berjuang di jalan Allah, seperti dakwah, pendidikan Islam, jihad (perjuangan suci), atau kegiatan sosial keagamaan.', '2025-11-15 01:41:57', '2025-11-15 01:41:57'),
	(8, 'Ibnu Sabil', 'Musafir atau orang dalam perjalanan yang kehabisan bekal, meskipun kaya di negerinya.', '2025-11-15 01:42:15', '2025-11-15 01:42:15');

-- Dumping structure for table dkm.buktis
CREATE TABLE IF NOT EXISTS `buktis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `anggaran_id` bigint unsigned NOT NULL,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `penerima` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dana` bigint unsigned DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buktis_anggaran_id_foreign` (`anggaran_id`),
  KEY `buktis_dana_foreign` (`dana`),
  CONSTRAINT `buktis_anggaran_id_foreign` FOREIGN KEY (`anggaran_id`) REFERENCES `anggaran_detail_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buktis_dana_foreign` FOREIGN KEY (`dana`) REFERENCES `level3s` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.buktis: ~2 rows (approximately)
INSERT INTO `buktis` (`id`, `anggaran_id`, `nomor`, `tanggal`, `penerima`, `uraian`, `jumlah`, `dana`, `keterangan`, `file_bukti`, `kode`, `created_at`, `updated_at`) VALUES
	(1, 1, 'PEN-0001', '2025-11-16', 'Pak Wardi', 'Penerimaan kotak amal hari jumat ke-1', '2500000', 1, '-', NULL, NULL, '2025-11-15 19:48:35', '2025-11-16 08:11:21'),
	(2, 2, 'BEL-0001', '2025-11-16', 'Farhan', 'Pembayaran Honor Imam bulan Nopember 2025', '4000000', 2, NULL, NULL, NULL, '2025-11-15 23:59:48', '2025-11-16 08:20:47'),
	(3, 2, 'BEL-0002', '2025-11-21', 'Waldi, penyapu', 'Honor pembersih halaman masjid', '150000', 3, NULL, NULL, NULL, '2025-11-20 19:00:22', '2025-11-20 19:00:22');

-- Dumping structure for table dkm.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.cache: ~6 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('al_kautsar_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1763806176),
	('al_kautsar_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1763806176;', 1763806176),
	('laravel_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1763803280),
	('laravel_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1763803280;', 1763803280),
	('masjid_al_kautsar_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1763808072),
	('masjid_al_kautsar_cache_livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1763808072;', 1763808072);

-- Dumping structure for table dkm.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.cache_locks: ~0 rows (approximately)

-- Dumping structure for table dkm.detail_items
CREATE TABLE IF NOT EXISTS `detail_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.detail_items: ~0 rows (approximately)

-- Dumping structure for table dkm.detail_mutasis
CREATE TABLE IF NOT EXISTS `detail_mutasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mutasi_id` bigint unsigned NOT NULL,
  `level3_id` bigint unsigned NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_mutasis_mutasi_id_foreign` (`mutasi_id`),
  KEY `detail_mutasis_level3_id_foreign` (`level3_id`),
  CONSTRAINT `detail_mutasis_level3_id_foreign` FOREIGN KEY (`level3_id`) REFERENCES `level3s` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_mutasis_mutasi_id_foreign` FOREIGN KEY (`mutasi_id`) REFERENCES `mutasis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.detail_mutasis: ~4 rows (approximately)
INSERT INTO `detail_mutasis` (`id`, `mutasi_id`, `level3_id`, `jumlah`, `kolom`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '200000', 'D', '2025-11-19 18:20:30', '2025-11-19 18:22:38'),
	(2, 1, 1, '200000', 'K', '2025-11-19 18:22:30', '2025-11-19 18:22:30'),
	(3, 2, 2, '100000', 'D', '2025-11-20 04:39:34', '2025-11-20 04:39:34'),
	(4, 2, 1, '100000', 'K', '2025-11-20 04:40:50', '2025-11-20 04:40:50');

-- Dumping structure for table dkm.detil_asnafs
CREATE TABLE IF NOT EXISTS `detil_asnafs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `asnaf_id` bigint unsigned NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` enum('UMUM','SD','SMP','SMA','D1','D2','D3','D4','S1','S2','S3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UMUM',
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` decimal(10,2) DEFAULT NULL,
  `ktp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detil_asnafs_asnaf_id_foreign` (`asnaf_id`),
  CONSTRAINT `detil_asnafs_asnaf_id_foreign` FOREIGN KEY (`asnaf_id`) REFERENCES `asnafs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.detil_asnafs: ~9 rows (approximately)
INSERT INTO `detil_asnafs` (`id`, `asnaf_id`, `nama`, `jenis`, `alamat`, `hp`, `satuan`, `ktp`, `rekening`, `bank`, `foto`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Parman', 'UMUM', 'Griya Anggraini Blok A1', NULL, 300000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:34:03', '2025-11-15 03:34:03'),
	(2, 1, 'Suliyah', 'UMUM', 'Griya Anggraini Blok B1', NULL, 350000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:35:55', '2025-11-15 03:35:55'),
	(3, 1, 'Nabila', 'SD', 'Kampung Gudang', NULL, 250000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:37:12', '2025-11-15 03:37:12'),
	(4, 3, 'Farhan', 'UMUM', 'Masjid Al Kutsar', NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:40:53', '2025-11-15 03:40:53'),
	(5, 8, 'Amiruddin', 'UMUM', 'Kp Gudang', NULL, 400000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:41:33', '2025-11-15 03:41:33'),
	(6, 4, 'Ko Deny', 'UMUM', 'Griya Anggraini', NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:42:19', '2025-11-15 03:42:19'),
	(7, 5, 'Siti', 'UMUM', 'Kp Gudang Lio Baru', NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:42:48', '2025-11-15 03:42:48'),
	(8, 6, 'Asepuddin', 'UMUM', 'Kp. Tegal', NULL, 500000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:43:11', '2025-11-15 03:43:11'),
	(9, 8, 'Saman', 'UMUM', 'Kp. Aceh', NULL, 1500000.00, NULL, NULL, NULL, NULL, NULL, 0, '2025-11-15 03:44:08', '2025-11-15 03:44:08');

-- Dumping structure for table dkm.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table dkm.jamaahs
CREATE TABLE IF NOT EXISTS `jamaahs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telpon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` enum('PNS','Swasta','Wirausaha','Pensiunan','Lainnya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.jamaahs: ~0 rows (approximately)

-- Dumping structure for table dkm.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.jobs: ~0 rows (approximately)

-- Dumping structure for table dkm.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.job_batches: ~0 rows (approximately)

-- Dumping structure for table dkm.level1s
CREATE TABLE IF NOT EXISTS `level1s` (
  `akun1` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`akun1`),
  UNIQUE KEY `level1s_akun1_unique` (`akun1`),
  UNIQUE KEY `level1s_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.level1s: ~4 rows (approximately)
INSERT INTO `level1s` (`akun1`, `nama`, `slug`, `keterangan`, `created_at`, `updated_at`) VALUES
	('1', 'Kas', 'kas', NULL, '2025-11-14 21:36:23', '2025-11-14 21:36:23'),
	('2', 'Utang', 'utang', NULL, '2025-11-14 21:36:41', '2025-11-14 21:36:41'),
	('3', 'Ekuitas', 'ekuitas', NULL, '2025-11-14 21:36:54', '2025-11-14 21:36:54'),
	('4', 'Pendapatan', 'pendapatan', NULL, '2025-11-14 21:37:08', '2025-11-14 21:37:08'),
	('5', 'Belanja', 'belanja', NULL, '2025-11-14 21:37:19', '2025-11-14 21:37:19');

-- Dumping structure for table dkm.level2s
CREATE TABLE IF NOT EXISTS `level2s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `akun1` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun2` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `indek` (`akun1`,`akun2`),
  UNIQUE KEY `level2s_slug_unique` (`slug`),
  CONSTRAINT `level2s_akun1_foreign` FOREIGN KEY (`akun1`) REFERENCES `level1s` (`akun1`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.level2s: ~5 rows (approximately)
INSERT INTO `level2s` (`id`, `akun1`, `akun2`, `nama`, `slug`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, '1', '01', 'Kas Tunai', 'kas-tunai', NULL, '2025-11-14 23:06:04', '2025-11-14 23:06:04'),
	(2, '1', '02', 'Kas di Bank', 'kas-di-bank', NULL, '2025-11-14 23:30:46', '2025-11-14 23:30:46'),
	(3, '2', '01', 'Utang Jangka Pendek', 'utang-jangka-pendek', NULL, '2025-11-15 00:31:30', '2025-11-15 00:31:30'),
	(5, '4', '01', 'Infaq dan Sodaqoh', 'infaq-dan-sodaqoh', 'Akun ini untuk pencatatan kas masuk yang berasal dari Infag dan Sodaqoh', '2025-11-15 17:42:57', '2025-11-15 17:47:21'),
	(6, '5', '01', 'Belanja Honor', 'belanja-honor', NULL, '2025-11-15 23:50:35', '2025-11-15 23:50:35'),
	(7, '5', '02', 'Belanja Langganan Daya dan Jasa', 'belanja-langganan-daya-dan-jasa', 'Untuk Pemabayaran Listrik  dan Internet', '2025-11-15 23:51:54', '2025-11-15 23:51:54'),
	(8, '4', '02', 'Pendapatan ZIS', 'pendapatan-zis', NULL, '2025-11-22 06:22:51', '2025-11-22 06:22:51');

-- Dumping structure for table dkm.level3s
CREATE TABLE IF NOT EXISTS `level3s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `level2_id` bigint unsigned NOT NULL,
  `akun1` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun2` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akun3` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level3s_slug_unique` (`slug`),
  UNIQUE KEY `level3s_akun1_akun2_akun3_unique` (`akun1`,`akun2`,`akun3`),
  KEY `level3s_level2_id_foreign` (`level2_id`),
  CONSTRAINT `level3s_level2_id_foreign` FOREIGN KEY (`level2_id`) REFERENCES `level2s` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.level3s: ~9 rows (approximately)
INSERT INTO `level3s` (`id`, `level2_id`, `akun1`, `akun2`, `akun3`, `nama`, `slug`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 1, '9', NULL, '01', 'Kas Umum', 'kas-umum', NULL, '2025-11-15 00:16:07', '2025-11-15 00:16:07'),
	(2, 2, '9', NULL, '01', 'Bank Syariah Indonesi - 1230007890', 'bank-syariah-indonesi-1230007890', NULL, '2025-11-15 00:19:19', '2025-11-15 00:19:19'),
	(3, 1, '9', NULL, '02', 'Kas Kecil - Pak Wardi', 'kas-kecil-pak-wardi', NULL, '2025-11-15 00:37:25', '2025-11-15 00:37:25'),
	(4, 1, '9', NULL, '03', 'Kas Kecil - Pak Lutfi', 'kas-kecil-pak-lutfi', NULL, '2025-11-15 01:37:40', '2025-11-15 01:37:40'),
	(5, 5, '9', NULL, '01', 'Infaq dan Sodaqoh', 'infaq-dan-sodaqoh', NULL, '2025-11-15 18:24:47', '2025-11-15 19:33:08'),
	(6, 6, NULL, NULL, '01', 'Honor Imam Masjid', 'honor-imam-masjid', NULL, '2025-11-15 23:54:34', '2025-11-15 23:54:34'),
	(7, 6, NULL, NULL, '02', 'Honor Muadzin', 'honor-muadzin', NULL, '2025-11-15 23:54:51', '2025-11-15 23:54:51'),
	(8, 1, NULL, NULL, '04', 'Kas Tunai Dana ZIZ', 'kas-tunai-dana-ziz', 'Akun  untuk pencatatan penerimaan kas yang bersumber dari Dana ZIZ yang di simpan di Brankas', '2025-11-16 19:19:40', '2025-11-16 19:22:39'),
	(9, 2, NULL, NULL, '02', 'Bank Syariah Indonesi - 1230007890-Dana ZIZ', 'bank-syariah-indonesi-1230007890-dana-ziz', 'Akun  untuk pencatatan penerimaan kas masuk dari Dana ZIZ yang di simpan di Rekening Bank', '2025-11-16 19:21:56', '2025-11-16 19:21:56'),
	(10, 8, NULL, NULL, '01', 'Zakat', 'zakat', NULL, '2025-11-22 06:23:56', '2025-11-22 06:23:56'),
	(11, 8, NULL, NULL, '02', 'Zakat Mal', 'zakat-mal', NULL, '2025-11-22 06:24:15', '2025-11-22 06:24:15');

-- Dumping structure for table dkm.mappings
CREATE TABLE IF NOT EXISTS `mappings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akun` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolom` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.mappings: ~0 rows (approximately)

-- Dumping structure for table dkm.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.migrations: ~36 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_09_22_145432_add_two_factor_columns_to_users_table', 1),
	(5, '2025_10_24_103322_create_tahuns_table', 1),
	(6, '2025_10_24_104421_create_sumber_danas_table', 1),
	(7, '2025_10_24_104629_create_sub_danas_table', 1),
	(8, '2025_10_24_210401_create_strukturs_table', 1),
	(9, '2025_10_24_210753_create_tugas_table', 1),
	(10, '2025_10_27_065910_create_penguruses_table', 1),
	(11, '2025_10_27_071337_create_jamaahs_table', 1),
	(12, '2025_10_28_023407_create_mappings_table', 1),
	(13, '2025_10_28_094103_create_level1s_table', 1),
	(14, '2025_10_28_104526_create_level2s_table', 1),
	(15, '2025_10_29_094010_create_level3s_table', 1),
	(16, '2025_10_31_103508_create_anggarans_table', 1),
	(17, '2025_10_31_204302_add_level_columns_to_anggarans_table', 1),
	(18, '2025_11_01_095559_add_detail_items_to_anggarans_table', 1),
	(19, '2025_11_02_113550_create_detail_items_table', 1),
	(20, '2025_11_02_113558_create_anggaran_detail_items_table', 1),
	(21, '2025_11_02_113836_migrate_detail_items_from_json_to_table', 1),
	(22, '2025_11_02_114458_add_default_to_total_in_anggaran_detail_items', 1),
	(23, '2025_11_10_000346_create_buktis_table', 1),
	(24, '2025_11_11_074706_create_asnafs_table', 1),
	(25, '2025_11_11_080132_create_detil_asnafs_table', 1),
	(26, '2025_11_13_120007_create_salur_zakats_table', 1),
	(27, '2025_11_14_060350_add_satuan_to_detil_asnafs_table', 1),
	(28, '2025_11_14_201314_create_saldos_table', 2),
	(29, '2025_11_15_070458_modify_level3s_foreign_key', 3),
	(30, '2025_11_16_064730_add_penerima_to_buktis_table', 4),
	(31, '2025_11_16_114354_add_tahun_id_to_saldos_table', 5),
	(32, '2025_11_16_150745_add_dana_to_buktis_table', 6),
	(35, '2025_11_18_210037_add_nomor_to_salur_zakats_table', 7),
	(36, '2025_11_18_233343_create_salur_zakat_details_table', 8),
	(37, '2025_11_18_233535_remove_fields_from_salur_zakats_table', 9),
	(38, '2025_11_19_074642_create_mutasis_table', 10),
	(40, '2025_11_19_094943_create_detail_mutasis_table', 11);

-- Dumping structure for table dkm.mutasis
CREATE TABLE IF NOT EXISTS `mutasis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.mutasis: ~1 rows (approximately)
INSERT INTO `mutasis` (`id`, `nomor`, `tanggal`, `uraian`, `kolom`, `file_bukti`, `kode`, `created_at`, `updated_at`) VALUES
	(1, 'MUT-0001', '2025-11-19', 'Penyetoran Uang ke Bank', NULL, NULL, 1, '2025-11-19 15:19:00', '2025-11-20 03:58:35'),
	(2, 'MUT-0002', '2025-11-20', 'Penyetoran Uang Ke Bank BSI', NULL, NULL, 1, '2025-11-20 04:39:04', '2025-11-20 04:39:04');

-- Dumping structure for table dkm.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table dkm.penguruses
CREATE TABLE IF NOT EXISTS `penguruses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `struktur_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penguruses_struktur_id_foreign` (`struktur_id`),
  CONSTRAINT `penguruses_struktur_id_foreign` FOREIGN KEY (`struktur_id`) REFERENCES `strukturs` (`kode`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.penguruses: ~3 rows (approximately)
INSERT INTO `penguruses` (`id`, `tahun`, `struktur_id`, `nama`, `status`, `foto`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, '2025', 'AA', 'Jauhar Rafid', 1, NULL, NULL, '2025-11-16 21:23:09', '2025-11-16 21:23:09'),
	(2, '2025', 'AC', 'Iskandar', 1, NULL, 'Sekretaris 1', '2025-11-16 21:24:30', '2025-11-16 21:25:40'),
	(3, '2025', 'AB', 'Azhar', 1, NULL, 'Wakil Ketua 1', '2025-11-16 21:25:06', '2025-11-16 21:26:22');

-- Dumping structure for table dkm.saldos
CREATE TABLE IF NOT EXISTS `saldos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun_id` bigint unsigned NOT NULL,
  `akun1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level2_id` bigint unsigned NOT NULL,
  `level3_id` bigint unsigned NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rekening` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT '0.00',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saldos_akun1_foreign` (`akun1`),
  KEY `saldos_level2_id_foreign` (`level2_id`),
  KEY `saldos_level3_id_foreign` (`level3_id`),
  KEY `saldos_tahun_id_foreign` (`tahun_id`),
  CONSTRAINT `saldos_akun1_foreign` FOREIGN KEY (`akun1`) REFERENCES `level1s` (`akun1`) ON DELETE CASCADE,
  CONSTRAINT `saldos_level2_id_foreign` FOREIGN KEY (`level2_id`) REFERENCES `level2s` (`id`) ON DELETE CASCADE,
  CONSTRAINT `saldos_level3_id_foreign` FOREIGN KEY (`level3_id`) REFERENCES `level3s` (`id`) ON DELETE CASCADE,
  CONSTRAINT `saldos_tahun_id_foreign` FOREIGN KEY (`tahun_id`) REFERENCES `tahuns` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.saldos: ~4 rows (approximately)
INSERT INTO `saldos` (`id`, `tahun_id`, `akun1`, `level2_id`, `level3_id`, `bank`, `rekening`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 1, '1', 1, 1, '-', '-', 35000000.00, 'Pencatatan Jumlah Saldo Awal Pada Setiap Awal Tahun', '2025-11-16 04:57:01', '2025-11-16 04:57:01'),
	(2, 1, '1', 2, 2, 'Bank Syariah Indonesia', '1230007890', 50000000.00, NULL, '2025-11-16 07:38:17', '2025-11-16 07:38:17'),
	(3, 1, '1', 1, 3, '-', '-', 2500000.00, NULL, '2025-11-16 08:49:42', '2025-11-16 08:49:42'),
	(4, 1, '1', 1, 4, '-', '-', 300000.00, NULL, '2025-11-16 08:50:05', '2025-11-16 08:50:05');

-- Dumping structure for table dkm.salur_zakats
CREATE TABLE IF NOT EXISTS `salur_zakats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.salur_zakats: ~1 rows (approximately)
INSERT INTO `salur_zakats` (`id`, `nomor`, `tanggal`, `jenis`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'SZ-2025-11-0001', '2025-11-19', 'BEASISWA', 'Penyaluran bantuan Bea Siswa dari Dana ZIZ sesuai daftar terlampir', 1, '2025-11-18 16:31:46', '2025-11-18 18:28:06');

-- Dumping structure for table dkm.salur_zakat_details
CREATE TABLE IF NOT EXISTS `salur_zakat_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `salur_zakat_id` bigint unsigned NOT NULL,
  `detil_asnaf_id` bigint unsigned NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satuan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salur_zakat_details_salur_zakat_id_foreign` (`salur_zakat_id`),
  KEY `salur_zakat_details_detil_asnaf_id_foreign` (`detil_asnaf_id`),
  CONSTRAINT `salur_zakat_details_detil_asnaf_id_foreign` FOREIGN KEY (`detil_asnaf_id`) REFERENCES `detil_asnafs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `salur_zakat_details_salur_zakat_id_foreign` FOREIGN KEY (`salur_zakat_id`) REFERENCES `salur_zakats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.salur_zakat_details: ~0 rows (approximately)
INSERT INTO `salur_zakat_details` (`id`, `salur_zakat_id`, `detil_asnaf_id`, `jenis`, `satuan`, `alamat`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, 'SD', 250000.00, 'Kampung Gudang', NULL, '2025-11-18 16:40:51', '2025-11-18 16:40:51');

-- Dumping structure for table dkm.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('Qr3Q29N4pOKC1BAZKv3GBL1G42FVk1Zz2DX819Wt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IkdleVNyMDFoU0Z0aEg4UTBpV280U1ZtOU1PN1Q5a3dSNXFCUWh0aDgiO3M6MzoidXJsIjthOjA6e31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2RrbS9idWt0aXMiO3M6NToicm91dGUiO3M6MzU6ImZpbGFtZW50LmRrbS5yZXNvdXJjZXMuYnVrdGlzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJDJiNzl4eEdDSVhmY0pOdFNKcjV0NU9JWjBFM2UySHVUOVFHQm9BYkxVTmFtdm5FNE1EYjVHIjtzOjY6InRhYmxlcyI7YToxNTp7czo0MDoiZDNlNTlmMzM3NGQwMjk4ZWI3NGYwZWU3N2E1YTczZmNfY29sdW1ucyI7YTo1OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoia29kZSI7czo1OiJsYWJlbCI7czo0OiJLb2RlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjQ6Ik5hbWEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI0YWQwMGE5ZjAwNzYwNTU3ODM0MDczODg1NzI0MjczY19jb2x1bW5zIjthOjExOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImxldmVsMS5uYW1hIjtzOjU6ImxhYmVsIjtzOjQ6IkFrdW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJsZXZlbDIubmFtYSI7czo1OiJsYWJlbCI7czoxMzoiS2Vsb21wb2sgQWt1biI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImxldmVsMy5uYW1hIjtzOjU6ImxhYmVsIjtzOjEwOiJKZW5pcyBBa3VuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoic3VtYmVyX2RhbmEubmFtYSI7czo1OiJsYWJlbCI7czoxMToiU3VtYmVyIGRhbmEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJzdWJfZGFuYS5uYW1hIjtzOjU6ImxhYmVsIjtzOjg6IlN1YiBkYW5hIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJqdW1sYWgiO3M6NToibGFiZWwiO3M6MTE6Ikp1bWxhaCBQYWd1IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJyZWFsaXNhc2kiO3M6NToibGFiZWwiO3M6OToiUmVhbGlzYXNpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyMDoicGVyc2VudGFzZV9yZWFsaXNhc2kiO3M6NToibGFiZWwiO3M6MTE6IiUgUmVhbGlzYXNpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoic2lzYV9hbmdnYXJhbiI7czo1OiJsYWJlbCI7czoxMzoiU2lzYSBBbmdnYXJhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjk7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjEwO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImFiODFiOThiNjRiMDRjZDA5OWUxMDg3ZjIyM2U5MTAxX2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRhaHVuIjtzOjU6ImxhYmVsIjtzOjU6IlRhaHVuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoic3RydWt0dXIubmFtYSI7czo1OiJsYWJlbCI7czo4OiJTdHJ1a3R1ciI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo0OiJOYW1hIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJmb3RvIjtzOjU6ImxhYmVsIjtzOjQ6IkZvdG8iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiIzYTZiNzk2NWQzMmE2OTU4MzMwMGFhZDRhYWFjODdiZF9jb2x1bW5zIjthOjQ6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMzoic3RydWt0dXJfa29kZSI7czo1OiJsYWJlbCI7czoxMzoiU3RydWt0dXIga29kZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoidXJhaWFuIjtzOjU6ImxhYmVsIjtzOjY6IlVyYWlhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiZmI3MDk3NTk4ZjQ4Yzg4MDk4MTQ4NDVlODMwMzA3NWVfY29sdW1ucyI7YTo2OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiYWt1bjEiO3M6NToibGFiZWwiO3M6NToiQWt1bjEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NDoiTmFtYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoic2x1ZyI7czo1OiJsYWJlbCI7czo0OiJTbHVnIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoia2V0ZXJhbmdhbiI7czo1OiJsYWJlbCI7czoxMDoiS2V0ZXJhbmdhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiOGI3MmIyNDBhNjU4MzM1M2ZhYzkyYmI5YTAyNWViYzdfY29sdW1ucyI7YTo3OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImxldmVsMS5uYW1hIjtzOjU6ImxhYmVsIjtzOjY6IkxldmVsMSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiYWt1bjIiO3M6NToibGFiZWwiO3M6NToiQWt1bjIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NDoiTmFtYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoic2x1ZyI7czo1OiJsYWJlbCI7czo0OiJTbHVnIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoia2V0ZXJhbmdhbiI7czo1OiJsYWJlbCI7czoxMDoiS2V0ZXJhbmdhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiZDNiOGFjMDk2MmQ4MDA3YjAxOTk2MGFhYzlmMjQ3MjJfY29sdW1ucyI7YTo1OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoia29kZSI7czo1OiJsYWJlbCI7czo0OiJLb2RlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1hIjtzOjU6ImxhYmVsIjtzOjQ6Ik5hbWEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiJlNDI2NjQ1MzgyMmRmOTlmYjYyNDU3ZjIwNzFkN2QwYl9jb2x1bW5zIjthOjg6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxODoibGV2ZWwyLmxldmVsMS5uYW1hIjtzOjU6ImxhYmVsIjtzOjEyOiJBa3VuIExldmVsIDEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJsZXZlbDIubmFtYSI7czo1OiJsYWJlbCI7czoxMjoiQWt1biBMZXZlbCAyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJha3VuMyI7czo1OiJsYWJlbCI7czo1OiJBa3VuMyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo0OiJOYW1hIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJzbHVnIjtzOjU6ImxhYmVsIjtzOjQ6IlNsdWciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiIyYjM2N2JkMWJhNWU0ODIzMzkxYjQyZmUwMjQ2YTUzM19jb2x1bW5zIjthOjEwOntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtYSI7czo1OiJsYWJlbCI7czo0OiJOYW1hIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbGFtYXQiO3M6NToibGFiZWwiO3M6NjoiQWxhbWF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJ0ZWxwb24iO3M6NToibGFiZWwiO3M6NjoiVGVscG9uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJlbWFpbCI7czo1OiJsYWJlbCI7czoxMzoiRW1haWwgYWRkcmVzcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToicGVrZXJqYWFuIjtzOjU6ImxhYmVsIjtzOjk6IlBla2VyamFhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Njoic3RhdHVzIjtzOjU6ImxhYmVsIjtzOjY6IlN0YXR1cyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoiZm90byI7czo1OiJsYWJlbCI7czo0OiJGb3RvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoia2V0ZXJhbmdhbiI7czo1OiJsYWJlbCI7czoxMDoiS2V0ZXJhbmdhbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjk7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiOWViOGYwZGY4MDYwYjgwN2I5Yzk1YTMzOGFlMmFmMzdfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6InRhaHVuLnRhaHVuIjtzOjU6ImxhYmVsIjtzOjU6IlRhaHVuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJha3VuMSI7czo1OiJsYWJlbCI7czo0OiJBa3VuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToibGV2ZWwyLm5hbWEiO3M6NToibGFiZWwiO3M6MTM6IktlbG9tcG9rIEFrdW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJsZXZlbDMubmFtYSI7czo1OiJsYWJlbCI7czoxMDoiSmVuaXMgQWt1biI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoiYmFuayI7czo1OiJsYWJlbCI7czo0OiJCYW5rIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo4OiJyZWtlbmluZyI7czo1OiJsYWJlbCI7czoxMjoiTm8uIFJla2VuaW5nIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJqdW1sYWgiO3M6NToibGFiZWwiO3M6MTI6Ikp1bWxhaCBTYWxkbyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiODFkNjhhMjBmZmUyNmVjNWU4NDgyNzk2NzAxMjNlNGFfY29sdW1ucyI7YToxMDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6Im5vbW9yIjtzOjU6ImxhYmVsIjtzOjU6Ik5vbW9yIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo3OiJ0YW5nZ2FsIjtzOjU6ImxhYmVsIjtzOjc6IlRhbmdnYWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6InBlbmVyaW1hIjtzOjU6ImxhYmVsIjtzOjg6IlBlbmVyaW1hIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InVyYWlhbiI7czo1OiJsYWJlbCI7czo2OiJVcmFpYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6Imp1bWxhaCI7czo1OiJsYWJlbCI7czo2OiJKdW1sYWgiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiZmlsZV9idWt0aSI7czo1OiJsYWJlbCI7czoxMDoiRmlsZSBidWt0aSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6ImRhbmFMZXZlbDMubmFtYSI7czo1OiJsYWJlbCI7czoxMToiU3VtYmVyIERhbmEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo5O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6IjM3NzVjNzRhMzY5MTFmNmYyN2ZjOWE4N2UxMDUzOWY2X2NvbHVtbnMiO2E6Nzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6Im5vbW9yIjtzOjU6ImxhYmVsIjtzOjU6Ik5vbW9yIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo3OiJ0YW5nZ2FsIjtzOjU6ImxhYmVsIjtzOjc6IlRhbmdnYWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6InVyYWlhbiI7czo1OiJsYWJlbCI7czo2OiJVcmFpYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJmaWxlX2J1a3RpIjtzOjU6ImxhYmVsIjtzOjEwOiJGaWxlIGJ1a3RpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJrb2RlIjtzOjU6ImxhYmVsIjtzOjQ6IktvZGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImM2MDExYjI5NmNlMGEyMmFhMDhkZWNmNDYzMzk1MTRmX2NvbHVtbnMiO2E6NDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NDoiTmFtYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImtldGVyYW5nYW4iO3M6NToibGFiZWwiO3M6MTA6IktldGVyYW5nYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6IjczYTUyNjI2YThiOTU3ZDI3NGI2YjJmZDcyYzQ3OWIzX2NvbHVtbnMiO2E6MTQ6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiYXNuYWYubmFtYSI7czo1OiJsYWJlbCI7czoxMToiSmVuaXMgQXNuYWYiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWEiO3M6NToibGFiZWwiO3M6NDoiTmFtYSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiamVuaXMiO3M6NToibGFiZWwiO3M6NToiSmVuaXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImFsYW1hdCI7czo1OiJsYWJlbCI7czo2OiJBbGFtYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6ImhwIjtzOjU6ImxhYmVsIjtzOjI6IkhwIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzYXR1YW4iO3M6NToibGFiZWwiO3M6MTU6Ikp1bWxhaCBTYW50dW5hbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mzoia3RwIjtzOjU6ImxhYmVsIjtzOjM6Ikt0cCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6ODoicmVrZW5pbmciO3M6NToibGFiZWwiO3M6ODoiUmVrZW5pbmciO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImJhbmsiO3M6NToibGFiZWwiO3M6NDoiQmFuayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjk7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoiZm90byI7czo1OiJsYWJlbCI7czo0OiJGb3RvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImtldGVyYW5nYW4iO3M6NToibGFiZWwiO3M6MTA6IktldGVyYW5nYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxMTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjEzO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6IjhiZTBhNzIyOGMwODM4NjQ5ZTJlMGY0YTdmY2MzZmM2X2NvbHVtbnMiO2E6OTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6InRhbmdnYWwiO3M6NToibGFiZWwiO3M6NzoiVGFuZ2dhbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToibm9tb3IiO3M6NToibGFiZWwiO3M6NToiTm9tb3IiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI6ImlkIjtzOjU6ImxhYmVsIjtzOjg6IkxhbXBpcmFuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJqZW5pcyI7czo1OiJsYWJlbCI7czo1OiJKZW5pcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTg6ImRldGFpbHNfc3VtX3NhdHVhbiI7czo1OiJsYWJlbCI7czo2OiJKdW1sYWgiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJrZXRlcmFuZ2FuIjtzOjU6ImxhYmVsIjtzOjEwOiJLZXRlcmFuZ2FuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJzdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX19czoxMjoibGV2ZWwyX2FrdW4xIjtpOjQ7czo4OiJmaWxhbWVudCI7YTowOnt9czoxMToibGFzdF9zYXR1YW4iO3M6NjoiMjUwMDAwIjt9', 1763819436),
	('rAxEiu3K0bL9nNz15pYOdhBKRC5M8jcBQfhZViif', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOTFxZEZtaXdtakNpbTRuWlpseGxXRFBpV3pReXNNMkw5UDVsdTVQMCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2RrbS9idWt0aXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2RrbS9sb2dpbiI7czo1OiJyb3V0ZSI7czoyMzoiZmlsYW1lbnQuZGttLmF1dGgubG9naW4iO319', 1763858674);

-- Dumping structure for table dkm.strukturs
CREATE TABLE IF NOT EXISTS `strukturs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `strukturs_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.strukturs: ~5 rows (approximately)
INSERT INTO `strukturs` (`id`, `kode`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 'AA', 'Ketua DKM', NULL, '2025-11-16 20:55:48', '2025-11-16 20:56:24'),
	(2, 'AB', 'Wakil Ketua DKM', NULL, '2025-11-16 20:56:46', '2025-11-16 20:56:46'),
	(3, 'AC', 'Sekretaris', NULL, '2025-11-16 20:57:32', '2025-11-16 20:57:32'),
	(4, 'BA', 'Seksi Dakwah', NULL, '2025-11-16 21:27:41', '2025-11-16 21:27:41'),
	(5, 'BB', 'Seksi Hari Besar', NULL, '2025-11-16 21:27:55', '2025-11-16 21:27:55');

-- Dumping structure for table dkm.sub_danas
CREATE TABLE IF NOT EXISTS `sub_danas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sumber` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_danas_sumber_sub_unique` (`sumber`,`sub`),
  UNIQUE KEY `sub_danas_nama_unique` (`nama`),
  CONSTRAINT `sub_danas_sumber_foreign` FOREIGN KEY (`sumber`) REFERENCES `sumber_danas` (`kode`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.sub_danas: ~1 rows (approximately)
INSERT INTO `sub_danas` (`id`, `sumber`, `sub`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, '01', '01', 'Infaq dan Sodaqoh', NULL, '2025-11-15 19:03:54', '2025-11-15 19:06:06');

-- Dumping structure for table dkm.sumber_danas
CREATE TABLE IF NOT EXISTS `sumber_danas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sumber_danas_kode_unique` (`kode`),
  UNIQUE KEY `sumber_danas_nama_unique` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.sumber_danas: ~0 rows (approximately)
INSERT INTO `sumber_danas` (`id`, `kode`, `nama`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, '01', 'Infaq dan Sodaqoh', 'Pendapatan dari Infaq dan Sodaqoh baik melalui kotak amal maupun pemberian langsung dari jamaah', '2025-11-15 19:02:49', '2025-11-15 19:02:49');

-- Dumping structure for table dkm.tahuns
CREATE TABLE IF NOT EXISTS `tahuns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tahun` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tahuns_tahun_unique` (`tahun`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.tahuns: ~2 rows (approximately)
INSERT INTO `tahuns` (`id`, `tahun`, `keterangan`, `aktif`, `created_at`, `updated_at`) VALUES
	(1, '2025', 'Data ini akan digunakan untuk membedakan data untuk cetak laporan sesuai dengan periode tahun tersebut', 1, '2025-11-15 16:40:55', '2025-11-15 16:40:55'),
	(2, '2024', NULL, 1, '2025-11-16 08:48:32', '2025-11-16 08:48:32');

-- Dumping structure for table dkm.tugas
CREATE TABLE IF NOT EXISTS `tugas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `struktur_kode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `2` (`struktur_kode`),
  CONSTRAINT `2` FOREIGN KEY (`struktur_kode`) REFERENCES `strukturs` (`kode`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.tugas: ~2 rows (approximately)
INSERT INTO `tugas` (`id`, `struktur_kode`, `uraian`, `created_at`, `updated_at`) VALUES
	(1, 'AA', '<p class="lexical__paragraph" dir="ltr"><span style="white-space: pre-wrap;">- Memimpin</span></p>', '2025-11-16 21:19:59', '2025-11-16 21:19:59'),
	(2, 'AC', '<p class="lexical__paragraph" dir="ltr"><span style="white-space: pre-wrap;">- Membantu Ketua DKM</span></p>', '2025-11-16 21:20:22', '2025-11-16 21:20:22'),
	(4, 'AB', '<p class="lexical__paragraph" dir="ltr"><span style="white-space: pre-wrap;">- Mewakili Ketua DKM</span></p>', '2025-11-16 21:21:43', '2025-11-16 21:21:43');

-- Dumping structure for table dkm.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dkm.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$2b79xxGCIXfcJNtSJr5t5OIZ0E3e2HuT9QGBoAbLUNamvnE4MDb5G', NULL, NULL, NULL, NULL, '2025-11-14 21:35:43', '2025-11-14 21:35:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
