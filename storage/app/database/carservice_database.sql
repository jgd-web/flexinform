-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Szerver verzió:               5.7.33 - MySQL Community Server (GPL)
-- Szerver OS:                   Win64
-- HeidiSQL Verzió:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Adatbázis struktúra mentése a carservice.
CREATE DATABASE IF NOT EXISTS `carservice` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `carservice`;

-- Struktúra mentése tábla carservice. cars
CREATE TABLE IF NOT EXISTS `cars` (
  `car_id` bigint(20) unsigned NOT NULL COMMENT 'ügyfél autójának azonosítója (ügyfelenként egyedi)',
  `client_id` bigint(20) unsigned NOT NULL COMMENT 'ügyfél egyedi azonosítója',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'szerviz alkalom (ügyfél és autójaként egyedi)',
  `registered` datetime NOT NULL COMMENT 'regisztrálás időpontja',
  `ownbrand` tinyint(3) unsigned NOT NULL COMMENT 'értéke 1 ha saját márkás, értéke 0 ha nem saját márkás',
  `accident` smallint(6) NOT NULL COMMENT 'balesetek száma',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `cars_car_id_client_id_unique` (`car_id`,`client_id`),
  KEY `cars_car_id_index` (`car_id`),
  KEY `cars_client_id_index` (`client_id`),
  CONSTRAINT `cars_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. clients
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ügyfél egyedi azonosítója',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ügyfél neve',
  `idcard` int(10) unsigned NOT NULL COMMENT 'okmányazonosítója',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63010 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. services
CREATE TABLE IF NOT EXISTS `services` (
  `client_id` bigint(20) unsigned NOT NULL COMMENT 'ügyfél egyedi azonosítója',
  `car_id` bigint(20) unsigned NOT NULL COMMENT 'ügyfél autójának azonosítója (ügyfelenként egyedi)',
  `lognumber` smallint(5) unsigned NOT NULL COMMENT 'szerviz alkalom (ügyfél és autójaként egyedi)',
  `event` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'esemény típusa',
  `eventtime` datetime DEFAULT NULL COMMENT 'esemény időpontja',
  `document_id` int(10) unsigned NOT NULL COMMENT 'munkanlap azonosítója',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `services_car_id_client_id_lognumber_unique` (`car_id`,`client_id`,`lognumber`),
  KEY `services_client_id_index` (`client_id`),
  KEY `services_car_id_index` (`car_id`),
  KEY `services_lognumber_index` (`lognumber`),
  KEY `services_document_id_index` (`document_id`),
  CONSTRAINT `services_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

-- Struktúra mentése tábla carservice. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Az adatok exportálása nem lett kiválasztva.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
