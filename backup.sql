-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: neuroattend
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meeting_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `attendances_meeting_id_foreign` (`meeting_id`),
  KEY `attendances_user_id_foreign` (`user_id`),
  KEY `attendances_created_by_foreign` (`created_by`),
  CONSTRAINT `attendances_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `attendances_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`),
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,2,1,1,NULL,1,'2025-03-04 23:58:39','2025-03-05 00:25:27'),(2,1,1,1,1,NULL,1,'2025-03-05 00:14:57','2025-03-05 00:15:10');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_types`
--

DROP TABLE IF EXISTS `meeting_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_types`
--

LOCK TABLES `meeting_types` WRITE;
/*!40000 ALTER TABLE `meeting_types` DISABLE KEYS */;
INSERT INTO `meeting_types` VALUES (2,1,'Team Meeting','Internal meeting for team updates and planning.',1,'2025-02-26 08:29:20','2025-03-03 22:09:47'),(3,1,'Wilfrido Almache','asdsadsadasdsaddd',1,'2025-03-03 22:09:31','2025-03-03 22:34:22'),(4,1,'pruebasX1','Esta esuna prueba dt dfd dddddd ffff sas',1,'2025-03-03 22:14:22','2025-03-03 22:36:35');
/*!40000 ALTER TABLE `meeting_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meetings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint unsigned NOT NULL,
  `organization_id` bigint unsigned NOT NULL,
  `meeting_type_id` bigint unsigned NOT NULL,
  `datetime` datetime NOT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `meetings_organization_id_foreign` (`organization_id`),
  KEY `meetings_meeting_type_id_foreign` (`meeting_type_id`),
  KEY `meetings_created_by_foreign` (`created_by`),
  CONSTRAINT `meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `meetings_meeting_type_id_foreign` FOREIGN KEY (`meeting_type_id`) REFERENCES `meeting_types` (`id`),
  CONSTRAINT `meetings_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
INSERT INTO `meetings` VALUES (1,1,6,2,'2025-03-08 06:00:00','qwewqewq','qweqww',1,'2025-03-04 01:13:32','2025-03-04 01:22:46');
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_02_25_011433_create_organizations_table',1),(5,'2025_02_25_011928_create_roles_table',1),(6,'2025_02_26_005938_create_meeting_types_table',1),(7,'2025_02_26_005938_create_meetings_table',1),(8,'2025_02_26_012059_create_attendances_table',1),(9,'2025_02_26_013316_modify_users_table',1),(10,'2025_03_04_004820_update_meetings_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `representative` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` smallint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (6,1,'Wilfrido Almache','Francisco de Olnos E924','qweqwewqewq','12321213213','walmache@gmail.com','Nueva',1,'2025-02-27 03:09:51','2025-03-04 01:48:37'),(7,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','2322323','walmache@gmail.com','123123213213123',1,'2025-02-27 03:10:03','2025-02-27 05:48:51'),(9,1,'Wilfrido Almache','Francisco de Olnos E924','werwerewr','123454','walmache@gmail.com0','etas su',1,'2025-02-27 04:24:37','2025-02-27 06:29:32'),(10,1,'utrau','asdsd','yo mismo dd','2322323','walmache@gmail.com0','sadsadsa',1,'2025-02-27 04:24:57','2025-03-04 01:48:17'),(11,1,'Wilfrido Almache','Francisco de Olnos E924','asdadasdsads asdasdsad','123213213213','walmache@gmail.com','qweqwewqe',1,'2025-02-27 06:19:46','2025-02-27 06:34:39'),(12,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','323232','walmache@gmail.com','qwewqeqwewq',1,'2025-02-27 06:20:02','2025-02-27 06:30:59'),(13,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','323232','walmache@gmail.com','qwewqeqwewqe',1,'2025-02-27 06:20:18','2025-03-02 23:20:56'),(14,1,'Wilfrido Almache','Francisco de Olnos E924','repre','2322323','walmache@gmail.com0','qweqweqweqw',1,'2025-02-27 06:20:34','2025-02-27 06:20:34'),(15,1,'Wilfrido Almache','Francisco de Olnos E924','repre','2322323','walmache@gmail.com0','qweqweq',1,'2025-02-27 06:20:45','2025-02-27 06:50:51'),(16,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','323232','walmache@gmail.com','qweqwewqewq',1,'2025-02-27 06:21:27','2025-02-27 06:21:27'),(17,1,'Wilfrido Almache','Francisco de Olnos E924','repre','323232','walmache@gmail.com',NULL,1,'2025-02-27 06:21:37','2025-02-27 06:21:37'),(18,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','323232','walmache@gmail.com','qweqwewqewqe',1,'2025-02-27 06:21:52','2025-02-27 06:36:39'),(19,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com','sdfsfsdfdsfdsf',1,'2025-02-28 05:37:12','2025-02-28 05:37:12'),(20,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com','esta es la ultimoa',1,'2025-02-28 21:13:36','2025-02-28 21:13:36'),(21,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,1,'2025-02-28 21:15:16','2025-02-28 21:15:16'),(22,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,1,'2025-02-28 21:15:54','2025-02-28 21:15:54'),(23,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,1,'2025-02-28 22:10:48','2025-02-28 22:10:48'),(24,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com','dasdasdasdsad',1,'2025-02-28 22:17:57','2025-02-28 22:17:57'),(25,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','usuario@dominio.com','asdasdasdasdsa',1,'2025-02-28 22:36:32','2025-02-28 22:36:32'),(26,1,'Wilfrido Almache','Francisco de Olnos E924','yo mismo','2322323','walmache@gmail.com','dsfsdfdsfds',1,'2025-02-28 22:37:38','2025-02-28 22:37:38'),(27,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,1,'2025-02-28 22:43:42','2025-02-28 22:43:42'),(28,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,1,'2025-02-28 22:44:56','2025-02-28 22:44:56'),(29,1,'Wilfrido Almache','Francisco de Olnos E924','Innovatech Solutions Global Transformando Ideas en Realidad con Tecnología de Vanguardia y Estrateg','2322323','walmache@gmail.com',NULL,0,'2025-02-28 22:45:29','2025-03-04 01:26:10'),(30,1,'Organizacion11','En la casa mismo','Elmismodeayer','232323','mail@telco.net','Estas son las observaciones de esta organización erere',1,'2025-03-04 01:02:50','2025-03-04 01:42:57'),(31,1,'Nueva','Organización','desde el form','33221122','nueva@admin.com','Esta es una nueva organización',1,'2025-03-04 01:19:53','2025-03-04 01:30:54');
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `roles1`
--

DROP TABLE IF EXISTS `roles1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles1` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles1`
--

LOCK TABLES `roles1` WRITE;
/*!40000 ALTER TABLE `roles1` DISABLE KEYS */;
INSERT INTO `roles1` VALUES (1,'Administrator',NULL,1,'2025-02-26 08:29:20','2025-02-26 08:29:20'),(2,'Moderator',NULL,1,'2025-02-26 08:29:20','2025-02-26 08:29:20'),(3,'User',NULL,1,'2025-02-26 08:29:20','2025-02-26 08:29:20');
/*!40000 ALTER TABLE `roles1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('ja1kEtl6UOM8FFQJn95hefQ0JOXg2IHNsDtk5ZSG',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTGxsOUpiYWZRdDc4U21tQWl1aVg5QXBNcUxqYTR4bjB4eEVjTjRGZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vbmV1cm9hdHRlbmQubG9jYWw6ODAwMC9hZG1pbi9tZWV0aW5ncyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzQxMDg3Mjg1O319',1741087285),('N707ZxBHVlSOmJZ5LwBFqcDxOPOaRjfQKlw5Y8nK',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVXdzcG84SE93bEtIb1duV1UyZXFYOGw1M2NERkZNS3hKM1Zldnl2eCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ5OiJodHRwOi8vbmV1cm9hdHRlbmQubG9jYWw6ODAwMC9hZG1pbi9vcmdhbml6YXRpb25zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NDExMzQzNzc7fX0=',1741134562);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` bigint unsigned DEFAULT NULL,
  `role_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identification` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_login_unique` (`login`),
  KEY `users_organization_id_foreign` (`organization_id`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles1` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,NULL,3,'Usuario','1234567890','usuario@dominio.com','123-456-7890','default.jpg',1,1,'usuario',NULL,'$2y$12$fZxpG3w7k54uSB1JHH4NOeYuYKQaGnqXrwLkns8CyElFUjFuqFete','EnNckxBuhX3l7f9MJDvuGgDBDYY4nnHx8B5fEq2NR8DEu88lhlYhocDo6lrr','2025-02-26 08:33:02','2025-02-26 08:33:02'),(2,7,3,'Wilfrido Almache','1711884617','walmache@gmail.com','444444','/tmp/phptebKJw',1,1,'walmache',NULL,'$2y$12$ueLBLYpCiVsQycmRcnGftu.Y7cQdlOKyrqQiLe3vNt5dP5clfbQfm',NULL,'2025-03-04 20:57:30','2025-03-04 20:57:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-04 19:44:20
