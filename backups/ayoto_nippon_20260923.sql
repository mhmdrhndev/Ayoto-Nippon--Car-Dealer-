-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ayoto_nippon
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_model_model_id_index` (`model`,`model_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,3,'verifikasi terima','Order',4,'SPK SPK-2026-0003 Deal, invoice INV-2026-0001','2026-09-23 12:18:58','2026-09-23 12:18:58'),(2,4,'upload BAST','Order',4,'BAST SPK SPK-2026-0003 diunggah.','2026-09-23 12:19:38','2026-09-23 12:19:38'),(3,4,'ubah harga','PriceList',1,'OTR Rp 255.000.000 menjadi Rp 254.000.000','2026-09-23 12:19:56','2026-09-23 12:19:56');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bank_accounts`
--

DROP TABLE IF EXISTS `bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint(20) unsigned NOT NULL,
  `bank` varchar(255) NOT NULL,
  `no_rek` varchar(255) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_accounts_branch_id_foreign` (`branch_id`),
  CONSTRAINT `bank_accounts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bank_accounts`
--

LOCK TABLES `bank_accounts` WRITE;
/*!40000 ALTER TABLE `bank_accounts` DISABLE KEYS */;
INSERT INTO `bank_accounts` VALUES (1,1,'BCA','123000101','PT Ayoto Nippon',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,2,'BCA','123000102','PT Ayoto Nippon',1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `maps_url` varchar(255) DEFAULT NULL,
  `booking_fee` bigint(20) unsigned NOT NULL DEFAULT 5000000,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branches_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'JKT-01','Ayoto Nippon Jakarta','Jl. Contoh Raya No. 1, Jakarta','0210000001',NULL,5000000,1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'BDG-01','Ayoto Nippon Bandung','Jl. Contoh No. 2, Bandung','0220000002',NULL,5000000,1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Toyota','toyota',NULL,1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'Honda','honda',NULL,1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0','i:3;',1790165948),('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1790165948;',1790165948);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_models`
--

DROP TABLE IF EXISTS `car_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_models_slug_unique` (`slug`),
  KEY `car_models_brand_id_foreign` (`brand_id`),
  CONSTRAINT `car_models_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_models`
--

LOCK TABLES `car_models` WRITE;
/*!40000 ALTER TABLE `car_models` DISABLE KEYS */;
INSERT INTO `car_models` VALUES (1,1,'Avanza','avanza','MPV 7 penumpang',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,2,'Brio','brio','City car 5 penumpang',1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `car_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode_hex` varchar(255) DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--

LOCK TABLES `colors` WRITE;
/*!40000 ALTER TABLE `colors` DISABLE KEYS */;
INSERT INTO `colors` VALUES (1,'Putih','#FFFFFF',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'Hitam','#16181D',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(3,'Silver','#C0C0C0',1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipe` enum('halaman','berita') NOT NULL,
  `slug` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contents_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contents`
--

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;
INSERT INTO `contents` VALUES (1,'halaman','tentang-kami','Tentang Kami','PT Ayoto Nippon adalah dealer mobil dengan dua cabang di Jakarta dan Bandung.\n\nLayanan kami: penjualan unit baru, tukar tambah, test drive, servis berkala, dan sparepart asli.',1,'2026-09-23 12:11:19','2026-09-23 12:11:19');
/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` char(16) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `ktp_path` varchar(255) DEFAULT NULL,
  `kk_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,2,'Cust Satu','1234567890123456','081234567890','Jl Uji No 1','ktp/8EcW8xxKAkeaDldNteELqKZjLI5hhoyA6OpBbS4P.png',NULL,'2026-09-23 12:04:54','2026-09-23 12:04:54'),(2,NULL,'Tamu Uji','9999888877776666','081111111111','Jl Tamu 2',NULL,NULL,'2026-09-23 12:05:07','2026-09-23 12:05:07'),(3,NULL,'Servis Uji','5555666677778888','083333333333','Jl Servis 3',NULL,NULL,'2026-09-23 12:11:50','2026-09-23 12:11:50'),(4,NULL,'Slot 1','9000000000000001','084444444441','Jl Slot 1',NULL,NULL,'2026-09-23 12:11:51','2026-09-23 12:11:51'),(5,NULL,'Slot 2','9000000000000002','084444444442','Jl Slot 2',NULL,NULL,'2026-09-23 12:11:52','2026-09-23 12:11:52'),(6,NULL,'Slot 3','9000000000000003','084444444443','Jl Slot 3',NULL,NULL,'2026-09-23 12:11:52','2026-09-23 12:11:52'),(7,NULL,'Slot 4','9000000000000004','084444444444','Jl Slot 4',NULL,NULL,'2026-09-23 12:11:53','2026-09-23 12:11:53'),(8,NULL,'Tukar Uji','1111222233334444','082222222222','Jl Tukar 1',NULL,NULL,'2026-09-23 12:12:34','2026-09-23 12:12:34');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_inv` varchar(255) NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `total` bigint(20) unsigned NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_no_inv_unique` (`no_inv`),
  KEY `invoices_order_id_foreign` (`order_id`),
  CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'INV-2026-0001',4,243000000,'invoices/INV-2026-0001.pdf','2026-09-23 12:18:58','2026-09-23 12:18:58');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lead_followups`
--

DROP TABLE IF EXISTS `lead_followups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lead_followups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint(20) unsigned NOT NULL,
  `sales_id` bigint(20) unsigned DEFAULT NULL,
  `catatan` text NOT NULL,
  `next_reminder` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_followups_lead_id_foreign` (`lead_id`),
  KEY `lead_followups_sales_id_foreign` (`sales_id`),
  CONSTRAINT `lead_followups_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lead_followups_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lead_followups`
--

LOCK TABLES `lead_followups` WRITE;
/*!40000 ALTER TABLE `lead_followups` DISABLE KEYS */;
/*!40000 ALTER TABLE `lead_followups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned DEFAULT NULL,
  `sales_id` bigint(20) unsigned DEFAULT NULL,
  `sumber` enum('Web','WA','Showroom') NOT NULL DEFAULT 'Web',
  `status` enum('Baru','Dihubungi','TestDrive','SPK','Deal','Batal') NOT NULL DEFAULT 'Baru',
  `kebutuhan_text` text DEFAULT NULL,
  `followup_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_customer_id_foreign` (`customer_id`),
  KEY `leads_sales_id_foreign` (`sales_id`),
  KEY `leads_status_sales_id_index` (`status`,`sales_id`),
  CONSTRAINT `leads_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leads_sales_id_foreign` FOREIGN KEY (`sales_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (1,1,NULL,'Web','Deal','SPK SPK-2026-0001 untuk Toyota Avanza 1.5 G CVT (VINJKT0000000001)',NULL,'2026-09-23 12:04:54','2026-09-23 12:05:48'),(2,NULL,NULL,'Web','Baru','Simulasi: Toyota Avanza 1.5 G CVT, OTR Rp 255.000.000, DP Rp 60.000.000, tenor 24 bln, Mandiri Tunas, estimasi Rp 9.018.750/bln',NULL,'2026-09-23 12:05:06','2026-09-23 12:05:06'),(3,2,NULL,'Web','TestDrive','Test drive Avanza 1.3 E MT di Ayoto Nippon Jakarta, jadwal 01 Oct 2026 10:00',NULL,'2026-09-23 12:05:07','2026-09-23 12:05:07'),(4,NULL,NULL,'Web','Baru','Pesan sparepart Oli Mesin 10W-40 di Ayoto Nippon Jakarta, harga Rp 185.000',NULL,'2026-09-23 12:11:56','2026-09-23 12:11:56'),(5,8,NULL,'Web','Baru','Trade-in Lama X tahun 2015, KM 80000',NULL,'2026-09-23 12:12:34','2026-09-23 12:12:34'),(6,1,NULL,'Web','Deal','SPK SPK-2026-0003 untuk Honda Brio RS CVT (VINBDG0000000001)',NULL,'2026-09-23 12:18:08','2026-09-23 12:18:58');
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leasing_partners`
--

DROP TABLE IF EXISTS `leasing_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leasing_partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `dp_min_persen` tinyint(3) unsigned NOT NULL DEFAULT 20,
  `tenor_list` varchar(255) NOT NULL DEFAULT '12,24,36,48',
  `bunga_dasar` decimal(5,2) NOT NULL DEFAULT 0.00,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leasing_partners`
--

LOCK TABLES `leasing_partners` WRITE;
/*!40000 ALTER TABLE `leasing_partners` DISABLE KEYS */;
INSERT INTO `leasing_partners` VALUES (1,'Mandiri Tunas',NULL,20,'12,24,36,48',5.50,1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'BCA Finance',NULL,20,'12,24,36,48',5.50,1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(3,'Adira',NULL,20,'12,24,36,48',5.50,1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `leasing_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_23_184836_create_permission_tables',1),(5,'2026_09_23_190101_create_branches_table',1),(6,'2026_09_23_190102_create_bank_accounts_table',1),(7,'2026_09_23_190103_add_branch_to_users_table',1),(8,'2026_09_23_190104_create_customers_table',1),(9,'2026_09_23_190105_create_brands_table',1),(10,'2026_09_23_190106_create_car_models_table',1),(11,'2026_09_23_190107_create_variants_table',1),(12,'2026_09_23_190108_create_colors_table',1),(13,'2026_09_23_190109_create_units_table',1),(14,'2026_09_23_190110_create_price_lists_table',1),(15,'2026_09_23_190111_create_leasing_partners_table',1),(16,'2026_09_23_191201_add_booking_fee_to_branches_table',2),(17,'2026_09_23_191202_create_leads_table',2),(18,'2026_09_23_191203_create_lead_followups_table',2),(19,'2026_09_23_191204_create_test_drives_table',2),(20,'2026_09_23_191205_create_orders_table',2),(21,'2026_09_23_192301_create_spareparts_table',3),(22,'2026_09_23_192302_create_trade_ins_table',3),(23,'2026_09_23_192303_create_service_bookings_table',3),(24,'2026_09_23_192304_create_service_details_table',3),(25,'2026_09_23_192305_create_promos_table',3),(26,'2026_09_23_192306_create_contents_table',3),(27,'2026_09_23_193401_create_invoices_table',4),(28,'2026_09_23_193402_create_activity_logs_table',4),(29,'2026_09_23_193403_add_bast_path_to_orders_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(3,'App\\Models\\User',4),(4,'App\\Models\\User',3),(5,'App\\Models\\User',5),(6,'App\\Models\\User',6),(7,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_spk` varchar(255) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `unit_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `metode` enum('Cash','Kredit','TradeIn') NOT NULL,
  `leasing_id` bigint(20) unsigned DEFAULT NULL,
  `dp_rencana` bigint(20) unsigned NOT NULL DEFAULT 0,
  `tenor` smallint(5) unsigned DEFAULT NULL,
  `angsuran_estimasi` bigint(20) unsigned DEFAULT NULL,
  `booking_fee` bigint(20) unsigned NOT NULL,
  `status` enum('MenungguBayar','MenungguVerifikasi','Deal','Ditolak','Expired','Batal') NOT NULL DEFAULT 'MenungguBayar',
  `deadline_at` datetime NOT NULL,
  `bukti_path` varchar(255) DEFAULT NULL,
  `bast_path` varchar(255) DEFAULT NULL,
  `verified_by` bigint(20) unsigned DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `tolak_alasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_no_spk_unique` (`no_spk`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_unit_id_foreign` (`unit_id`),
  KEY `orders_branch_id_foreign` (`branch_id`),
  KEY `orders_leasing_id_foreign` (`leasing_id`),
  KEY `orders_verified_by_foreign` (`verified_by`),
  KEY `orders_status_deadline_at_index` (`status`,`deadline_at`),
  CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_leasing_id_foreign` FOREIGN KEY (`leasing_id`) REFERENCES `leasing_partners` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'SPK-2026-0001',1,1,1,'Cash',NULL,0,NULL,NULL,5000000,'Deal','2026-09-24 19:04:54','bukti/xIwPMJfhRjPUPE01CjZ4m9VIJHycQUlDELwYBIec.png',NULL,3,'2026-09-23 19:05:48',NULL,'2026-09-23 12:04:54','2026-09-23 12:05:48'),(2,'SPK-2026-0002',1,2,1,'Cash',NULL,0,NULL,NULL,5000000,'Expired','2026-09-20 10:00:00',NULL,NULL,NULL,NULL,NULL,'2026-09-23 12:05:54','2026-09-23 12:05:55'),(4,'SPK-2026-0003',1,3,2,'Cash',NULL,0,NULL,NULL,5000000,'Deal','2026-09-24 19:18:08','bukti/y4lSNJvaRiU7W2HiuN9DaMgOEA9Bpgy0lcg2zl9a.png','bast/F3X8AaK9CD1U0JoiBOsVzEu5CYBhMJXTNk43fanz.png',3,'2026-09-23 19:18:58',NULL,'2026-09-23 12:18:08','2026-09-23 12:19:38');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price_lists`
--

DROP TABLE IF EXISTS `price_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `variant_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `otr` bigint(20) unsigned NOT NULL,
  `bbn` bigint(20) unsigned NOT NULL DEFAULT 0,
  `diskon` bigint(20) unsigned NOT NULL DEFAULT 0,
  `berlaku_dari` date DEFAULT NULL,
  `berlaku_sampai` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `price_lists_variant_id_branch_id_unique` (`variant_id`,`branch_id`),
  KEY `price_lists_branch_id_foreign` (`branch_id`),
  CONSTRAINT `price_lists_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `price_lists_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_lists`
--

LOCK TABLES `price_lists` WRITE;
/*!40000 ALTER TABLE `price_lists` DISABLE KEYS */;
INSERT INTO `price_lists` VALUES (1,1,1,254000000,0,1000000,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 12:19:56'),(2,2,1,235000000,0,0,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(3,3,1,243000000,0,0,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(4,1,2,255000000,0,0,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(5,2,2,235000000,0,0,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(6,3,2,243000000,0,0,NULL,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `price_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promos`
--

DROP TABLE IF EXISTS `promos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `mulai` date NOT NULL,
  `selesai` date NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promos_slug_unique` (`slug`),
  KEY `promos_branch_id_foreign` (`branch_id`),
  CONSTRAINT `promos_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promos`
--

LOCK TABLES `promos` WRITE;
/*!40000 ALTER TABLE `promos` DISABLE KEYS */;
INSERT INTO `promos` VALUES (1,NULL,'DP Ringan Semua Cabang','dp-ringan-oktober-2026',NULL,'Uang muka mulai 15% untuk pengajuan SPK bulan ini.','2026-09-01','2026-10-31',1,'2026-09-23 12:11:19','2026-09-23 12:11:19');
/*!40000 ALTER TABLE `promos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'pimpinan','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(3,'admin-cabang','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(4,'sales','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(5,'service-advisor','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(6,'mekanik','web','2026-09-23 11:50:50','2026-09-23 11:50:50'),(7,'customer','web','2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_bookings`
--

DROP TABLE IF EXISTS `service_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `no_svc` varchar(255) NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `nopol` varchar(255) NOT NULL,
  `vin` varchar(255) DEFAULT NULL,
  `km` int(10) unsigned NOT NULL,
  `keluhan` text NOT NULL,
  `jadwal` datetime NOT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Dikerjakan','Selesai','Batal') NOT NULL DEFAULT 'Menunggu',
  `estimasi_biaya` bigint(20) unsigned NOT NULL DEFAULT 0,
  `mekanik_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_bookings_no_svc_unique` (`no_svc`),
  KEY `service_bookings_customer_id_foreign` (`customer_id`),
  KEY `service_bookings_mekanik_id_foreign` (`mekanik_id`),
  KEY `service_bookings_branch_id_jadwal_index` (`branch_id`,`jadwal`),
  CONSTRAINT `service_bookings_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_bookings_mekanik_id_foreign` FOREIGN KEY (`mekanik_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_bookings`
--

LOCK TABLES `service_bookings` WRITE;
/*!40000 ALTER TABLE `service_bookings` DISABLE KEYS */;
INSERT INTO `service_bookings` VALUES (1,'SVC-2026-0001',3,1,'B1234XYZ',NULL,50000,'Rem bunyi','2026-10-05 09:00:00','Selesai',500000,6,'2026-09-23 12:11:50','2026-09-23 12:12:09'),(3,'SVC-2026-0003',5,1,'B9992XX',NULL,10000,'Uji slot','2026-10-05 09:30:00','Menunggu',0,NULL,'2026-09-23 12:11:52','2026-09-23 12:11:52'),(4,'SVC-2026-0004',6,1,'B9993XX',NULL,10000,'Uji slot','2026-10-05 09:30:00','Menunggu',0,NULL,'2026-09-23 12:11:52','2026-09-23 12:11:52'),(5,'SVC-2026-0005',7,1,'B9994XX',NULL,10000,'Uji slot','2026-10-05 09:30:00','Menunggu',0,NULL,'2026-09-23 12:11:53','2026-09-23 12:11:53');
/*!40000 ALTER TABLE `service_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_details`
--

DROP TABLE IF EXISTS `service_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_booking_id` bigint(20) unsigned NOT NULL,
  `jenis` enum('Pekerjaan','Sparepart') NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `qty` int(10) unsigned NOT NULL DEFAULT 1,
  `harga_satuan` bigint(20) unsigned NOT NULL DEFAULT 0,
  `subtotal` bigint(20) unsigned NOT NULL DEFAULT 0,
  `sparepart_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_details_service_booking_id_foreign` (`service_booking_id`),
  KEY `service_details_sparepart_id_foreign` (`sparepart_id`),
  CONSTRAINT `service_details_service_booking_id_foreign` FOREIGN KEY (`service_booking_id`) REFERENCES `service_bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_details_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spareparts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_details`
--

LOCK TABLES `service_details` WRITE;
/*!40000 ALTER TABLE `service_details` DISABLE KEYS */;
INSERT INTO `service_details` VALUES (1,1,'Pekerjaan','Tune up',1,350000,350000,NULL,'2026-09-23 12:12:08','2026-09-23 12:12:08'),(2,1,'Sparepart','Oli Mesin 10W-40',2,185000,370000,1,'2026-09-23 12:12:09','2026-09-23 12:12:09');
/*!40000 ALTER TABLE `service_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('234qagxSSWp7XSNCfzZ7X1plVDZmbvK1qn5Y9LIk',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoibUhjZlZJN0FMMFlnQTBNN01xMWZ2eHBUUjlyeDZ6ZGRXMG9OdEhCRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nP3RyYW5zbWlzaT1NVCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164364),('2caEvtqG56hudQ4I07bn27ggayt7Eyh9UOfbYCgl',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWhNOGRzSlJlYkVMclZKUnY4WnJtUU9KZzFRZ0JVSDBCWEY5WWlYRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYWJhbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1790165517),('2wikTfP7Lv9KmnIGJEU5vH5YOiUN26vxJtTc0XqZ',2,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoick1ubjltNGRTZVYwZWRydGNWUHMxaWVwUG56Z05XeEppUlg4d1BtTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvU1BLLTIwMjYtMDAwMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1790165100),('44beUyWjWlvM64lIMAp08CH1dSYCIyIYmIgMNkpV',2,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieVY2OTFnMDd1TXFremJGdmhPQ1ZBTDlsbWdmOURoQzVwWHJHZXRDZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1790165936),('6FsFLm7pPdQnIMiPVb5RCf1zpreKsruf7sSTBQ3h',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGM4WkluQ1V4N2FJb2FiMzFhQUR6WHVwV0FDeThnUlBYZTFIbDJoSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXJ2aXMtYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790165509),('A1ybZIKyUJ0ggvJv6ZS9KH1VYrBWg21FQITlTmJr',3,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTjdZWU04N3NhUTNvajZOTFJyelIyTmFHOGhQbmFaa0lYblRtekEweiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92ZXJpZnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdWtzZXMiO31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo2OiJzdWtzZXMiO3M6Mzk6IlZlcmlmaWthc2kgU1BLIFNQSy0yMDI2LTAwMDEgdGVyc2ltcGFuLiI7fQ==',1790165148),('ABQ7GPEY0r6LJu2XVJjNKWd6JPW9BLvctIGilxhq',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY1Vqa05rQ29OWXBlZVVjTGtobEMwT1ZyWEVJZVJ2eEtSYmtob0VxRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3ZlcmlmeSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdmVyaWZ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790165998),('ADQp0jPMiy4DO5rZRs5w7TrqQIyy9HWWV8BX8v5b',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiajRsT0pJcVpWTk9sWTg5VklnZzR2ajl3R3JXTzVPMTU4NXlrV29jTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92ZXJpZnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdmVyaWZ5Ijt9fQ==',1790165073),('DXLytGOx0weSXyHy2U5V8C12Bfs4vaDt9TqXXjaI',3,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidmxhOUZoUDNiMjBDSVVkU21sT2tvWVN6N3htRk9ydFY0VUZlbmdjTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92ZXJpZnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdWtzZXMiO31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo2OiJzdWtzZXMiO3M6Mzk6IlZlcmlmaWthc2kgU1BLIFNQSy0yMDI2LTAwMDMgdGVyc2ltcGFuLiI7fQ==',1790165939),('dYS66x09I1TFKnftFHVllpAvTwGTAng2R9BVXN9m',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnlleFE3R3hrdEx1U0FZNGNyNU1lN1VNN1ZYOU1ZNTVlWGhia2NMRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164324),('EbD7ogcJNE7baOsmtfhsYh4mwLpJ11IvgQe67ZxT',4,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2VyaGFJZ0Zpd0NaM2txcGlSVWpoVmFFaDhCRVh0M3BJUjUxNkxTdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sZWFkcy8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9',1790165170),('fBHynsWqq1hsgVYImdc7ocDUUZLignmmHi9x13g1',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibEVXSjZvZW5IUzVjWHk3UDFqbURjYUpOSWFLN0FnU2tURWkzRnZnbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFkZS1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790165507),('FcEYt3Kv7JbivMhA8zVf6U0RAkvyNkSuPFkhk9m5',2,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoicHFEMHU3VVZsRDdzTlJsVEVKZzBQdjV2UGdzRWdkMXFEZ3ZTd0taVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvU1BLLTIwMjYtMDAwMyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjE6e2k6MDtzOjY6InN1a3NlcyI7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjY6InN1a3NlcyI7czo0NToiQnVrdGkgZGl0ZXJpbWEgZGFuIG1lbnVuZ2d1IHZlcmlmaWthc2kgYWRtaW4uIjt9',1790165889),('H8xU95YjtbkxwyRzkxWFDdAfRVEG1Zx0OsppqdRn',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkEzNFJrOFhkN3NUUFQ3NnJqUG94dU5KQ3dKMG5ZWkZNakpwY3h0UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZXN0LWRyaXZlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790165077),('IAb0LnV5m0XxKKgUlBzWlGdeKtMpfDZmuhKQrkbK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3NNbGZ3OHFEQkNvT3BHd2FjYmVkTnJYUVd2SmZrRVV0cExlUGNqdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790164331),('ICxDPv0pmJFL1wMgqL158VcjS8ptj5QRka1Z3tnQ',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUW1aZVdYOFhYUjRRam10Q09RSXBNU1pRRE5GeE0xOVplM1NPb0I4SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvU1BLLTIwMjYtMDAwMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvY3JlYXRlIjt9fQ==',1790165070),('Iijta3q17kHiizdxtXEZL2BIHFM5bKibxYJ4vSiZ',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmZzZ3J2UjRrV2RkdEdKc0Z0U2lIeTRFdXlEbkc0eFVEVWtwb01ueCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9tbyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790165517),('iRX1SCG0wqCJTtwj6ankiMJXQlTswFaQu3hU6IPr',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0hBQ0pLNkhmVWFCSUMzSU1RWGcwbWRRT2xmUWtsdjNoaEVOMkdkYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790164325),('jeWC9ORqL28wDYYs6QZjI3XfZKLDW5qWDVVe6uXC',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTJuWHZXaWV6V0FzRldNMmJiYzZ2cXBjbVFrakJzejNmYzBIWWFESSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790165519),('kHd6xAfdgKbqeV03WGlUKH5WJIXwGbQ2zEYkqGMx',3,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicHVBNHJ5YmVFTWg1MUJwSWlGakpEU3d3aHJCNTRQQU5oSHZwVE9HQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9',1790165998),('KhNQcFAm0QU3r4vG7dFOzMCbIWw2x4a7J3XJsZDo',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoib21JOFZRMVFsd2JBTGRMQ01POG9wR0tuVTRiSnMzNUY3WmVlbFRmdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nP2NhYmFuZz1CREctMDEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1790164364),('lFUAG57pAcvPwnukUcluy9KWikvhlSPWXmrYDt4u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSjFxUTZVOWlsREVseXRGck9xTnprZ2c3UjRQQVA2UTNKOWFoZ2tpUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164904),('LSnNrjtY5RcxBto7Jlaq96cMBZgQd2NG2vmfIfbp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVhaNVNMbnlCSmpRWkFkYjRmWHBsUFlCTjZOOEtKdDI5QndaM2pGMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=',1790165897),('lwGR2vo0S2Q5eyyZ6MlV5YfstTatvyFbfrqzAIBO',4,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMWpoSktIWXRtZndWaGZJNEZQTnEzbHNvdVhLdUJMSUFwN1ZMYzVpQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90cmFkZS1pbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdWtzZXMiO31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo2OiJzdWtzZXMiO3M6Mjc6IlN0YXR1cyB0cmFkZS1pbiBkaXBlcmJhcnVpLiI7fQ==',1790165565),('mnFdAMQh274DB3PR6KA9pIA5IJ8NiG8LcOnrEmo9',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTR3VlRiU05GTUp4Z1J3ell1WXNMcUxkNExxZnp4SFRwYkdxaHY1aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGFyZXBhcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdWtzZXMiO31zOjM6Im5ldyI7YTowOnt9fXM6Njoic3Vrc2VzIjtzOjU4OiJQZXNhbmFuIGRpdGVydXNrYW4uIFNhbGVzIHNwYXJlcGFydCBha2FuIG1lbmdodWJ1bmdpIEFuZGEuIjt9',1790165516),('Mp0gKa6kJwZm1RH2xfB7OSSI0pQ9CM9iAWmgzPZP',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSkoxcjd0YUNKaWZZakszRkdvd3RyRHlidE1kNUUySGR2N1BibTk5SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGFyZXBhcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1790165515),('MxhMjU2j9vMUjhSWcN6TNveXlhtt09IBPN3I0Djx',4,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTHVTV1lTaUtXazBuWURZUkRCaEZHNFJvSkdORHBubjRQNFE0Y0o0NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcmljZS1saXN0cy8xL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo2OiJzdWtzZXMiO31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7czo2OiJzdWtzZXMiO3M6MjY6IkhhcmdhIGJlcmhhc2lsIGRpcGVyYmFydWkuIjt9',1790165996),('nf6lYEqHBIIPzNHSYhsqM4WwkVp6TkQy5AGNoC14',4,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiblJVOExkc1BubGVHc21qQmQwNTJnSkxhRk1JbnpKQkdlZXhLWWJseCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zcGsvU1BLLTIwMjYtMDAwMyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjE6e2k6MDtzOjY6InN1a3NlcyI7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDtzOjY6InN1a3NlcyI7czoyODoiQkFTVCBzZXJhaCB0ZXJpbWEgdGVyc2ltcGFuLiI7fQ==',1790165978),('O3qgbr0BbNZvjhzLO3g9RL45myrD9GkYq88XLQMn',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHl3cmJ3R0dudDI3QXVVejgwOXVoT09PbE5lUW5zemFJVXFLZHpQbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nP2JyYW5kPWhvbmRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790164332),('O7WfLopwvPEdwLjn9fwflcn8P4fTesq8NIMvSSDM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnVXa3RYcVRtNzBuQ3NlRWtJUVhTcEpHeW04VkdhSDdqcmlONjkyQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nP3E9eHl6LXRpZGFrLWFkYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164365),('OiJIsTod6Xcje496vDwRg383lfbdsOnOuHxsIdwJ',4,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWmFmbWY4eGliWWpmNk40NEp6S1oyb2NCTDEwV011NkxpU2llY2NJVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuL3Blbmp1YWxhbi9leHBvcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1790165943),('pcTAXldTotLJKnuHlO900uGdPwMKZBCuZl1MeySp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTBVZUhYaW9mZTdkTU1nbjJmZXdUclpRUG9kRkdFTkZaUk52MTQ0ZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tb2JpbC9icmlvLXJzLWN2dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164332),('ptOnTPv81pZZh7YXUhxddO5bNRIyKQy9T3foTdSg',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUxLbmlHMlZSNzV1NDB6NDVXazI5QUpxd1czNmlkbzZGeGRBN2p0bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFkZS1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjE6e2k6MDtzOjY6InN1a3NlcyI7fXM6MzoibmV3IjthOjA6e319czo2OiJzdWtzZXMiO3M6NzA6IlBlbmdhanVhbiB0cmFkZS1pbiBkaXRlcmltYS4gVGltIGthbWkgYWthbiBtZW5naHVidW5naSB1bnR1ayBpbnNwZWtzaS4iO30=',1790165554),('QGEQY74gy2Ej4EpLQSh6XtGi3gupBbXr5G7xweBl',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYU9naFpxY3E5TkYxbG9VQXh6aVdlckV3YmZDR0RDc1ZDU2ZYcTRQUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3ZlcmlmeSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdmVyaWZ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790165131),('qlptLlR8HeMbtP9FgFKqHwArxbdx6UxnYFcgEAkN',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzNXeEJ3SGZaNDI1ZXo0cFBnWlhObkl6dXJmb0M3NE8ya3ZLWHQ3WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRhbG9nP2JyYW5kPWhvbmRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790164364),('r6bBkK1RAm3tJ2dg001F9ASuitr3BKWDkkBsGsKH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW5zaFdTbFRXUkxBQjN5VWxSZjV2M2Rsd3E4Q3BRWEhuV2Rqa1czZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tb2JpbC9hdmFuemEtMS01LWctY3Z0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1790164325),('RWaOihFo9US8Tm2ZWFxBoSfgFXydeH09nzx5KYVa',NULL,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidUJLWHJVZjFzS1J2WXkyWDM0VFVuSkZIYjhzd3JhQzB0Ym1JMEQyOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFkZS1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjI6e2k6MDtzOjEwOiJfb2xkX2lucHV0IjtpOjE7czo2OiJlcnJvcnMiO31zOjM6Im5ldyI7YTowOnt9fXM6MTA6Il9vbGRfaW5wdXQiO2E6ODp7czo2OiJfdG9rZW4iO3M6NDA6InVCS1hyVWYxc0tSdll5MlgzNFRVbkpGSGI4c3dyYUMwdGJtSTBEMjkiO3M6NDoibmFtYSI7czo5OiJUdWthciBVamkiO3M6MzoibmlrIjtzOjE2OiIxMTExMjIyMjMzMzM0NDQ0IjtzOjQ6InRlbHAiO3M6MTI6IjA4MjIyMjIyMjIyMiI7czo2OiJhbGFtYXQiO3M6MTA6IkpsIFR1a2FyIDEiO3M6OToibWVya190aXBlIjtzOjY6IkxhbWEgWCI7czo1OiJ0YWh1biI7czo0OiIyMDE1IjtzOjI6ImttIjtzOjU6IjgwMDAwIjt9czo2OiJlcnJvcnMiO086MzE6IklsbHVtaW5hdGVcU3VwcG9ydFxWaWV3RXJyb3JCYWciOjE6e3M6NzoiACoAYmFncyI7YToxOntzOjc6ImRlZmF1bHQiO086Mjk6IklsbHVtaW5hdGVcU3VwcG9ydFxNZXNzYWdlQmFnIjoyOntzOjExOiIAKgBtZXNzYWdlcyI7YToxOntzOjQ6ImZvdG8iO2E6Mjp7aTowO3M6MTY6InZhbGlkYXRpb24uYXJyYXkiO2k6MTtzOjIwOiJ2YWxpZGF0aW9uLm1heC5hcnJheSI7fX1zOjk6IgAqAGZvcm1hdCI7czo4OiI6bWVzc2FnZSI7fX19fQ==',1790165545),('SRWJ658zeCfBIwrjvCdFwAWVmJKgjGhcHhRwsgyO',3,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNTkyaUt2aUlvUmQ3ZFZSajR3N2lPSk5mRHIwd0ZjZWZRcWwyMHN5WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==',1790165890),('uyOb1mlMJhPFGFhLXilN0Aro3OOmCnnXDqWjMFGc',4,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiem1rOEhmOFIyaTNLTkxVYmRXTzlWa1NERUtacThGdEwwSFNSZ0VubSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90cmFkZS1pbnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1790165522),('VwKyvfk19LyFoXfgken6iWHIES5s5DO8dudBjJUY',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnlZZmZwM09mOEhhMkRsUnpRVWxwZG01em9FcHBRVW4zTkUxZFRLOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmZvL3RlbnRhbmcta2FtaSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790165518),('VXJ1Wjkpb7856HmMcVAr7eciqP5i4dhwvQc2eNs3',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN1AzMWkza29VUEZKY3dpMHNQUG5YWE9NTFlFT2ZrNUNCcTlaa3JDTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZXN0LWRyaXZlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MTp7aTowO3M6Njoic3Vrc2VzIjt9czozOiJuZXciO2E6MDp7fX1zOjY6InN1a3NlcyI7czo2ODoiUGVuZ2FqdWFuIHRlc3QgZHJpdmUgZGl0ZXJpbWEuIFNhbGVzIGthbWkgYWthbiBtZW5nb25maXJtYXNpIGphZHdhbC4iO30=',1790165107),('W8g20u0XzYby5Ws2iJpAOKQztzTF2xVGZK57XWxo',3,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWWp2Y0R6WERVWHIxWVhiMUVscnBnSXpoSTkyRFk2dVFwNWdyTDVoaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92ZXJpZnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=',1790165104),('WbOjp8yij3WW6kbqOOXyRx1x7e4IGTfxhuYmzHTZ',5,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaVhvWno4RXZnU1JwUnlBbnY2R1NnQ2JxSGk3UDhCUk5PWHpXRTdIWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zZXJ2aWNlcy8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MTp7aTowO3M6Njoic3Vrc2VzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O3M6Njoic3Vrc2VzIjtzOjI1OiJTdGF0dXMgc2VydmlzIGRpcGVyYmFydWkuIjt9',1790165529),('WisbljawdwdSsaYcksdUg4mneUubow7F3NbzMAnA',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMG1NR1JIUW1uRmF4MFQ1R3AzU3oxenRiVEFVOURkaXFhMFg4SjhHMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164903),('z3nTQMJuAl6X9wfKPUa7qzKJrksoIVz0Ba5JazuO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-GB) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoibllpcjV1VkRINXFqVXhienpEYVo4SUUxSG9LNWFZMExrMlRiZEhDMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1790164334),('Zf6K37mBpzxIf2qducmBueZypLVrBUPwAOynmCEU',4,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVGQ3UWNuN0JDTUd6bTdhV1k0SEhyMWtBZ2lDbU9lVjllWHA1UHpzdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sYXBvcmFuL3Blbmp1YWxhbi9leHBvcnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1790165902);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spareparts`
--

DROP TABLE IF EXISTS `spareparts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spareparts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` bigint(20) unsigned NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) unsigned NOT NULL DEFAULT 0,
  `stok` int(10) unsigned NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spareparts_branch_id_foreign` (`branch_id`),
  CONSTRAINT `spareparts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spareparts`
--

LOCK TABLES `spareparts` WRITE;
/*!40000 ALTER TABLE `spareparts` DISABLE KEYS */;
INSERT INTO `spareparts` VALUES (1,1,'OLI-10W40','Oli Mesin 10W-40',185000,22,1,'2026-09-23 12:11:19','2026-09-23 12:12:09'),(2,1,'FLT-OLI','Filter Oli',75000,40,1,'2026-09-23 12:11:19','2026-09-23 12:11:19'),(3,2,'OLI-10W40','Oli Mesin 10W-40',185000,24,1,'2026-09-23 12:11:19','2026-09-23 12:11:19'),(4,2,'FLT-OLI','Filter Oli',75000,40,1,'2026-09-23 12:11:19','2026-09-23 12:11:19');
/*!40000 ALTER TABLE `spareparts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_drives`
--

DROP TABLE IF EXISTS `test_drives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_drives` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `variant_id` bigint(20) unsigned DEFAULT NULL,
  `jadwal` datetime NOT NULL,
  `status` enum('Menunggu','Dikonfirmasi','Hadir','Batal') NOT NULL DEFAULT 'Menunggu',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_drives_customer_id_foreign` (`customer_id`),
  KEY `test_drives_branch_id_foreign` (`branch_id`),
  KEY `test_drives_variant_id_foreign` (`variant_id`),
  CONSTRAINT `test_drives_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_drives_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `test_drives_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_drives`
--

LOCK TABLES `test_drives` WRITE;
/*!40000 ALTER TABLE `test_drives` DISABLE KEYS */;
INSERT INTO `test_drives` VALUES (1,2,1,2,'2026-10-01 10:00:00','Menunggu',NULL,'2026-09-23 12:05:07','2026-09-23 12:05:07');
/*!40000 ALTER TABLE `test_drives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trade_ins`
--

DROP TABLE IF EXISTS `trade_ins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trade_ins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `merk_tipe` varchar(255) NOT NULL,
  `tahun` smallint(5) unsigned NOT NULL,
  `km` int(10) unsigned NOT NULL,
  `foto_paths` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`foto_paths`)),
  `status` enum('Diajukan','Inspeksi','Ditawar','Deal','Ditolak') NOT NULL DEFAULT 'Diajukan',
  `harga_penawaran` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trade_ins_customer_id_foreign` (`customer_id`),
  KEY `trade_ins_order_id_foreign` (`order_id`),
  CONSTRAINT `trade_ins_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trade_ins_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_ins`
--

LOCK TABLES `trade_ins` WRITE;
/*!40000 ALTER TABLE `trade_ins` DISABLE KEYS */;
INSERT INTO `trade_ins` VALUES (1,8,NULL,'Lama X',2015,80000,'[\"trade-in\\/eEF4XcZajHHH8RubK7MzD0aQtTxAUfSCR88xLNjU.png\"]','Ditawar',95000000,'2026-09-23 12:12:34','2026-09-23 12:12:45');
/*!40000 ALTER TABLE `trade_ins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vin` varchar(255) NOT NULL,
  `variant_id` bigint(20) unsigned NOT NULL,
  `color_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `status` enum('Tersedia','Dipesan','Terjual') NOT NULL DEFAULT 'Tersedia',
  `tahun_rakit` smallint(5) unsigned NOT NULL,
  `harga` bigint(20) unsigned NOT NULL,
  `foto_utama` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `units_vin_unique` (`vin`),
  KEY `units_variant_id_foreign` (`variant_id`),
  KEY `units_color_id_foreign` (`color_id`),
  KEY `units_branch_id_foreign` (`branch_id`),
  KEY `units_status_branch_id_index` (`status`,`branch_id`),
  CONSTRAINT `units_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `units_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  CONSTRAINT `units_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'VINJKT0000000001',1,1,1,'Terjual',2026,255000000,NULL,'2026-09-23 11:50:50','2026-09-23 12:05:48'),(2,'VINJKT0000000002',2,2,1,'Tersedia',2026,235000000,NULL,'2026-09-23 11:50:50','2026-09-23 12:05:55'),(3,'VINBDG0000000001',3,3,2,'Terjual',2026,243000000,NULL,'2026-09-23 11:50:50','2026-09-23 12:18:58'),(4,'VINBDG0000000002',1,2,2,'Tersedia',2026,255000000,NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `branch_id` bigint(20) unsigned DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_branch_id_foreign` (`branch_id`),
  CONSTRAINT `users_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Superadmin','admin@ayotonippon.local',NULL,NULL,NULL,'$2y$12$kvmH3Zevfkie6KpbkxX4HO9ykGCi1qoTjCmwaoR2.A/f4PJ/vzeny',NULL,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,'Cust Satu','cust1@example.com',NULL,NULL,NULL,'$2y$12$xvgR2Yk4hUUGLlPm8MxeT.k6bIipXbOC0SKNoEg5IDrvKicg43rua',NULL,'2026-09-23 12:03:40','2026-09-23 12:03:40'),(3,'Sales Satu','sales1@example.com',1,NULL,NULL,'$2y$12$TzwM5qyz6VBg0ccFClxEZOnuSln0HPgf4VYsAikcZ8X3VfBH0Imn.',NULL,'2026-09-23 12:03:40','2026-09-23 12:03:40'),(4,'Admin Cabang','admcab1@example.com',1,NULL,NULL,'$2y$12$nToiIgSL1KFw11Erl9zCpub8XaGanrT926G25eowaSB7CrDnvhrPy',NULL,'2026-09-23 12:03:40','2026-09-23 12:03:40'),(5,'SA Satu','sa1@example.com',1,NULL,NULL,'$2y$12$r9pjg1voYWXjoP.QF/wT1OeM482LMkf5EUTHQJfvfPm5yGgXFNahy',NULL,'2026-09-23 12:11:46','2026-09-23 12:11:46'),(6,'Mekanik Satu','mek1@example.com',1,NULL,NULL,'$2y$12$5x0cKhH1.bAAtGbXokjsWO3DPKXz6sv4UKutu1rLthnGVlKRwWKH.',NULL,'2026-09-23 12:11:46','2026-09-23 12:11:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `car_model_id` bigint(20) unsigned NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `transmisi` enum('MT','AT','CVT') NOT NULL,
  `bbm` varchar(255) NOT NULL,
  `spesifikasi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`spesifikasi`)),
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variants_slug_unique` (`slug`),
  KEY `variants_car_model_id_foreign` (`car_model_id`),
  CONSTRAINT `variants_car_model_id_foreign` FOREIGN KEY (`car_model_id`) REFERENCES `car_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

LOCK TABLES `variants` WRITE;
/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
INSERT INTO `variants` VALUES (1,1,'1.5 G CVT','avanza-1-5-g-cvt','CVT','Bensin','{\"kursi\":7,\"mesin\":\"1496 cc\"}',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(2,1,'1.3 E MT','avanza-1-3-e-mt','MT','Bensin','{\"kursi\":7,\"mesin\":\"1329 cc\"}',1,'2026-09-23 11:50:50','2026-09-23 11:50:50'),(3,2,'RS CVT','brio-rs-cvt','CVT','Bensin','{\"kursi\":5,\"mesin\":\"1199 cc\"}',1,'2026-09-23 11:50:50','2026-09-23 11:50:50');
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-23 19:20:05
