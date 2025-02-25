-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: hotel_artichaut_api
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `landing_page_display` tinyint(1) NOT NULL,
  `navbar_display` tinyint(1) NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contents`
--

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;
INSERT INTO `contents` VALUES (1,'room-content','Nos Chambres','Un raffinement jusque dans l\'oreiller','À l’Hôtel 5 étoiles Artichaut, chaque chambre est une promesse de luxe et de confort. De la chambre standard cosy à la suite présidentielle digne d’un chef d’État en vacances, nos espaces allient élégance et raffinement. Literie moelleuse, Wi-Fi ultra-rapide, salles de bain somptueuses et petites attentions délicates transforment chaque séjour en une parenthèse enchantée. Que vous veniez pour affaires ou pour le plaisir, préparez-vous à une expérience où chaque détail compte… même la douceur des oreillers !',1,1,NULL,'1','1','2025-02-19 13:18:30','2025-02-21 07:08:23'),(2,'content-room','Our Rooms','The better you sleep, the better we are','At the 5-star Artichaut Hotel, every room is a promise of luxury and comfort. From the cozy standard room to the presidential suite fit for a head of state on holiday, our spaces blend elegance and refinement. Plush bedding, ultra-fast Wi-Fi, sumptuous bathrooms, and thoughtful little touches turn every stay into an enchanting escape. Whether you\'re here for business or leisure, get ready for an experience where every detail matters… even the softness of the pillows!',1,0,NULL,'1','2','2025-02-19 13:18:30','2025-02-24 09:45:43'),(4,'content-massage','Let\'s Massage !!','The best thai massage ever !!!','Our massages are an invitation to absolute relaxation. Whether it’s a soothing massage, a deep tissue treatment, or a hot stone therapy, every touch is designed to release your tension and immerse you in a sea of well-being. With expert hands and precious oils, your only challenge will be not to fall asleep too quickly… but we won’t hold it against you!',1,0,NULL,'1','2','2025-02-19 13:18:30','2025-02-24 09:47:28'),(5,'massage-content','Massages','Relachez, vous êtes massé','Nos massages sont une invitation au lâcher-prise absolu. Qu’il s’agisse d’un modelage relaxant, d’un massage deep tissue ou d’un soin aux pierres chaudes, chaque pression est pensée pour dénouer vos tensions et vous plonger dans un océan de bien-être. Entre mains expertes et huiles précieuses, votre seul effort sera de ne pas vous endormir trop vite… mais on ne vous en voudra pas !',1,1,NULL,'1','1','2025-02-19 13:18:30','2025-02-21 07:13:49'),(6,'content-wine','Cheers !!!','You never taste it so French !!!','Our wine selection is a sensory journey through the finest terroirs. From bold reds to delicate whites, with a touch of festive bubbles, each bottle is carefully chosen to elevate your meals… or simply for pure enjoyment. Let our sommeliers guide you, and may your only dilemma be choosing between a grand cru and a love at first sip. Cheers! 🍷',1,0,NULL,'1','2','2025-02-19 13:18:30','2025-02-24 09:48:54'),(7,'wine-content','Nos Vins','Une selection, des plus reconnues au monde','Notre sélection de vins est un voyage sensoriel à travers les plus beaux terroirs. Des rouges puissants aux blancs délicats, en passant par des bulles festives, chaque bouteille est choisie avec soin pour sublimer vos repas… ou simplement pour le plaisir. Laissez nos sommeliers vous guider, et que votre seul dilemme soit de choisir entre un grand cru et un coup de cœur. Santé ! 🍷',1,1,NULL,'1','1','2025-02-19 13:18:30','2025-02-21 07:16:03'),(16,'banner-equipe','L\'Equipe','Pour votre service','L’équipe de l’Hôtel 5 étoiles Artichaut, c’est une symphonie de talents au service de votre bien-être. Chefs passionnés, sommeliers inspirés, thérapeutes aux mains de velours et concierges aux petits soins… chaque membre de notre maison met son expertise et son sourire au cœur de votre séjour. Forts d’années d’expérience dans les plus grandes maisons, ils anticipent vos envies et transforment chaque instant en un moment d’exception. Ici, l’excellence n’est pas un simple mot, c’est une promesse.',1,0,NULL,'1','1','2025-02-20 09:25:32','2025-02-24 10:04:04'),(17,'restaurant-banner','Restaurant','Savourez l\'excellence, où chaque moment devient une expérience','Bienvenue dans notre restaurant, où l’art culinaire rencontre l’audace végétale ! Ici, l’artichaut est roi et s’invite subtilement dans chaque menu, de l’entrée au dessert. Notre chef, véritable maestro des saveurs, revisite ce trésor gastronomique avec créativité et finesse, surprenant vos papilles à chaque bouchée. Une cuisine raffinée, inventive et résolument inoubliable… même pour ceux qui pensaient ne pas aimer l’artichaut !',0,0,NULL,'0','1','2025-02-24 11:57:45','2025-02-24 11:57:45'),(18,'restaurant-banner-en','Restaurant','Savor excellence, where every moment becomes an experience.','Welcome to our restaurant, where culinary artistry meets bold botanical flair! Here, the artichoke reigns supreme, making a subtle yet delightful appearance in every menu, from starter to dessert. Our chef, a true maestro of flavors, reinvents this culinary gem with creativity and finesse, surprising your taste buds at every bite. A refined, inventive, and truly unforgettable dining experience… even for those who thought they didn’t like artichokes!',0,0,NULL,'0','2','2025-02-24 11:59:38','2025-02-24 11:59:38'),(19,'equipe-banner-en','The Squad','At your sevice, Sir!!','The team at the 5-star Hôtel Artichaut is a symphony of talent dedicated to your well-being. Passionate chefs, inspired sommeliers, skilled therapists with a delicate touch, and attentive concierges—each member of our establishment brings expertise and a warm smile to make your stay unforgettable. With years of experience in the finest establishments, they anticipate your every need and turn each moment into an exceptional experience. Here, excellence is not just a word—it’s a promise.',0,0,NULL,'0','2','2025-02-24 12:03:25','2025-02-24 12:07:56'),(20,'spa-banner-fr','SPA','Évadez-vous dans un sanctuaire de sérénité et de bien-être absolu.','Offrez à vos pieds une expérience hors du commun avec notre parcours santé aquatique, où de gracieux saumons se chargent de les dorloter… à leur manière. Entre chatouilles délicates et micro-massages toniques, ces experts en nage synchronisée réveillent votre circulation tout en vous arrachant quelques fous rires. Un soin aussi insolite qu’efficace, qui prouve une fois de plus que le bien-être passe aussi par les orteils !',0,0,NULL,'0','1','2025-02-24 12:25:04','2025-02-24 12:30:04'),(21,'spa-banner-en','SPA','Escape to a sanctuary of serenity and absolute well-being.','Give your feet an extraordinary experience with our aquatic health trail, where graceful salmon take care of them… in their own special way. Between gentle tickles and invigorating micro-massages, these synchronized swimming experts boost your circulation while bringing a few bursts of laughter. A treatment as unusual as it is effective, proving once again that well-being starts from the toes up! 🐟💦',0,0,NULL,'0','2','2025-02-24 12:31:27','2025-02-24 12:31:27'),(22,'service-banner-fr','Services','Notre hôtel de luxe vous offre des services exclusifs tels que valet, pressing, voiturier et bien plus pour un séjour inoubliable','Profitez de nos services exclusifs conçus pour rendre votre séjour facile et agréable. De notre service de pack professionnel, où nous prenons soin de vos bagages comme si c’était les nôtres, à notre voiturier pour une arrivée sans tracas, nous avons pensé à tout. Besoin de rafraîchir vos vêtements ? Notre service de blanchisserie s’en charge avec soin. Et pour vos compagnons à quatre pattes, nous proposons un service de garde de chien, pour qu\'ils puissent aussi profiter de leurs vacances pendant que vous explorez. Chaque détail, grand ou petit, est pris en charge pour garantir votre confort total. 🐾✨',0,0,NULL,'0','1','2025-02-24 12:42:51','2025-02-24 12:42:51'),(23,'service-banner-en','Services','Our luxury hotel offers exclusive services such as valet, laundry, concierge, and much more to ensure an unforgettable stay.','Indulge in our exclusive services designed to make your stay effortless and enjoyable. From our professional pack service, where we take care of your luggage as if it were our own, to our valet parking for a seamless arrival, we\'ve thought of everything. Need your clothes refreshed? Our laundry service is here to handle it with care. And for your furry friends, we offer dog sitting services, so they can enjoy their own little vacation while you\'re out exploring. Every detail, big or small, is taken care of to ensure your utmost comfort. 🐾✨',0,0,NULL,'0','2','2025-02-24 12:43:27','2025-02-24 12:43:27'),(24,'restaurant-cards-room','Les ambiances','Plusieurs ambiances, pour toute l\'année','Plongez dans une ambiance élégante et raffinée, où chaque détail a été pensé pour éveiller vos sens. Lumières tamisées, tables soigneusement dressées et une atmosphère feutrée créent le décor idéal pour une expérience gastronomique inoubliable. Ici, chaque repas se savoure autant avec les yeux qu’avec le palais.',0,0,NULL,'0','1','2025-02-24 14:58:51','2025-02-24 14:58:51');
/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_id` bigint unsigned DEFAULT NULL,
  `news_article_id` bigint unsigned DEFAULT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `rooms_category_id` bigint unsigned DEFAULT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `language_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (7,'http://192.168.1.245:8000/storage/images/sLsJGqoiD6j0x23uQNnL4ZlsqtoMeAqVvguxvItF.png',1,NULL,NULL,NULL,NULL,NULL,'2025-02-21 07:08:23','2025-02-21 07:08:23'),(9,'http://192.168.1.245:8000/storage/images/AFAZheXojlD1N7v6dsydrrIx6fBB5NilBBqfKUWH.png',5,NULL,NULL,NULL,NULL,NULL,'2025-02-21 07:13:49','2025-02-21 07:13:49'),(10,'http://192.168.1.245:8000/storage/images/UQexHiF5vPet0f41mS0kzCqv8D7kw1O9RcuDcuNk.png',7,NULL,NULL,NULL,NULL,NULL,'2025-02-21 07:16:03','2025-02-21 07:16:03'),(13,'http://192.168.1.245:8000/storage/images/ftAdCfa0bpxV0uJgKjocRJKSZKjv4HhnF8DdzkRQ.png',NULL,NULL,NULL,NULL,NULL,1,'2025-02-21 07:41:07','2025-02-21 07:41:07'),(14,'http://192.168.1.245:8000/storage/images/n19Z6djCxgo2vCymXuizGoTt1FqJL1DEobsRIvRP.png',NULL,NULL,NULL,NULL,NULL,2,'2025-02-21 07:41:20','2025-02-21 07:41:20'),(16,'http://192.168.1.245:8000/storage/images/EUoDF2mNhuSc85liAFGagNflRNz6ap9cOhd8tuBr.png',2,NULL,NULL,NULL,NULL,NULL,'2025-02-24 09:45:43','2025-02-24 09:45:43'),(17,'http://192.168.1.245:8000/storage/images/tkfivasZIg8mVcRITPp3NW8cinPkBv8DoRo5dX0x.png',4,NULL,NULL,NULL,NULL,NULL,'2025-02-24 09:47:28','2025-02-24 09:47:28'),(18,'http://192.168.1.245:8000/storage/images/UjKsR7JcXJRq4y437Eg2YPyxhxOQCLvW4v8qDpno.png',6,NULL,NULL,NULL,NULL,NULL,'2025-02-24 09:48:54','2025-02-24 09:48:54'),(19,'http://192.168.1.245:8000/storage/images/IjPUPDeonYbGAbGdtbrPHextLQp84s8MktNLpUGE.jpg',16,NULL,NULL,NULL,NULL,NULL,'2025-02-24 10:04:04','2025-02-24 10:04:04'),(20,'http://192.168.1.245:8000/storage/images/csE1BawJtnLIcXuZhiSrZ7kgTBor6fqW3lMzEWOZ.png',17,NULL,NULL,NULL,NULL,NULL,'2025-02-24 11:57:45','2025-02-24 11:57:45'),(21,'http://192.168.1.245:8000/storage/images/ivCTTUWjQQpQE1VWsGFvpq9zlGFvQMBQLIn19b20.png',18,NULL,NULL,NULL,NULL,NULL,'2025-02-24 11:59:38','2025-02-24 11:59:38'),(23,'http://192.168.1.245:8000/storage/images/CffElsls6gInOZr05nBGuPbc4BVcI7RlH9SwCmBb.jpg',19,NULL,NULL,NULL,NULL,NULL,'2025-02-24 12:07:56','2025-02-24 12:07:56'),(25,'http://192.168.1.245:8000/storage/images/OpIJJLt1iLQtAq4vJsUj8qiM65jMdjSvASToIDjQ.png',20,NULL,NULL,NULL,NULL,NULL,'2025-02-24 12:30:04','2025-02-24 12:30:04'),(26,'http://192.168.1.245:8000/storage/images/zE8cgxAvNpwZKF9oYBNP0uzflsca8lxcmbRb9aXM.png',21,NULL,NULL,NULL,NULL,NULL,'2025-02-24 12:31:27','2025-02-24 12:31:27'),(27,'http://192.168.1.245:8000/storage/images/NqivZomknGIcpfdKo20FwhSkATK2cKdcIFujvmPP.png',22,NULL,NULL,NULL,NULL,NULL,'2025-02-24 12:42:51','2025-02-24 12:42:51'),(28,'http://192.168.1.245:8000/storage/images/ipCgBza9oJIzF0kNvO3CeXig8fRxYWlTRAvnIUWN.png',23,NULL,NULL,NULL,NULL,NULL,'2025-02-24 12:43:27','2025-02-24 12:43:27'),(29,'http://192.168.1.245:8000/storage/images/cFr4L2aRkdS1u4aAjpBzi9uU550PIQKM3U4Pm67V.png',24,NULL,NULL,NULL,NULL,NULL,'2025-02-24 14:58:51','2025-02-24 14:58:51');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `languages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'fr',NULL,'2025-02-21 07:41:07'),(2,'en',NULL,NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_13_123504_create_personal_access_tokens_table',1),(5,'2025_01_13_135459_create_contents_table',1),(6,'2025_01_14_083751_create_rooms_categories_table',1),(7,'2025_01_14_101236_create_news_articles_table',1),(8,'2025_01_14_103358_create_rooms_table',1),(9,'2025_01_14_110303_create_services_table',1),(10,'2025_01_14_130433_create_rooms_features_table',1),(11,'2025_01_14_134731_create_images_table',1),(12,'2025_01_15_101407_create_reviews_table',1),(13,'2025_01_20_112152_create_room_category_feature_table',1),(14,'2025_02_17_125019_create_languages_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_articles`
--

DROP TABLE IF EXISTS `news_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news_articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_articles`
--

LOCK TABLES `news_articles` WRITE;
/*!40000 ALTER TABLE `news_articles` DISABLE KEYS */;
INSERT INTO `news_articles` VALUES (1,'Labadie-Nitzsche','Multi-layered real-time portal','By the use of repeating all that stuff,\' the Mock Turtle had just begun to dream that she ought not to lie down on their slates, and then said \'The fourth.\' \'Two days wrong!\' sighed the Lory, with a.','For really this morning I\'ve nothing to what I could let you out, you know.\' \'Not at first, the two sides of it, and fortunately was just possible it had been, it suddenly appeared again. \'By-the-bye, what became of the conversation. Alice felt that it seemed quite natural); but when the White Rabbit. She was a very hopeful tone though), \'I won\'t have any pepper in my kitchen AT ALL. Soup does very well without--Maybe it\'s always pepper that makes the matter with it. There could be no chance of this, so she tried hard to whistle to it; but she had found her head to hide a smile: some of the same as they would die. \'The trial cannot proceed,\' said the Hatter. \'Nor I,\' said the Dormouse; \'VERY ill.\' Alice tried to fancy to herself that perhaps it was written to nobody, which isn\'t usual, you know.\' He was an old crab, HE was.\' \'I never went to work very diligently to write with one of the court, by the pope, was soon left alone. \'I wish the creatures argue. It\'s enough to look through.','1','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(2,'Sauer PLC','Versatile local help-desk','Gryphon. \'Turn a somersault in the other. In the very middle of the way--\' \'THAT generally takes some time,\' interrupted the Hatter: \'I\'m on the twelfth?\' Alice went timidly up to the Hatter. He had.','Beautiful, beautiful Soup! Soup of the trial.\' \'Stupid things!\' Alice thought she might as well go in at the top with its legs hanging down, but generally, just as if she was beginning to feel which way it was in a low voice, to the jury, and the Gryphon answered, very nearly in the pool was getting quite crowded with the distant sobs of the Lobster; I heard him declare, \"You have baked me too brown, I must be Mabel after all, and I don\'t care which happens!\' She ate a little scream of laughter. \'Oh, hush!\' the Rabbit asked. \'No, I give it up,\' Alice replied: \'what\'s the answer?\' \'I haven\'t opened it yet,\' said the Mock Turtle in a few minutes she heard a little irritated at the window, I only wish it was,\' the March Hare said--\' \'I didn\'t!\' the March Hare said--\' \'I didn\'t!\' the March Hare. \'I didn\'t write it, and burning with curiosity, she ran off at once, while all the creatures wouldn\'t be so proud as all that.\' \'Well, it\'s got no business there, at any rate I\'ll never go THERE.','7','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(3,'Boehm Group','Implemented stable emulation','Dinah my dear! Let this be a comfort, one way--never to be ashamed of yourself,\' said Alice, \'because I\'m not looking for eggs, as it went, \'One side will make you grow taller, and the beak-- Pray.','Gryphon said, in a trembling voice:-- \'I passed by his garden.\"\' Alice did not venture to ask any more if you\'d like it very hard indeed to make ONE respectable person!\' Soon her eye fell upon a little way forwards each time and a long hookah, and taking not the right size for ten minutes together!\' \'Can\'t remember WHAT things?\' said the Queen, tossing her head on her lap as if it makes me grow smaller, I can reach the key; and if it wasn\'t trouble enough hatching the eggs,\' said the Queen. \'I never saw one, or heard of such a fall as this, I shall have somebody to talk about wasting IT. It\'s HIM.\' \'I don\'t think--\' \'Then you keep moving round, I suppose?\' \'Yes,\' said Alice very humbly: \'you had got burnt, and eaten up by wild beasts and other unpleasant things, all because they WOULD put their heads off?\' shouted the Queen was in a great many more than that, if you please! \"William the Conqueror, whose cause was favoured by the time it all came different!\' the Mock Turtle. \'Seals.','14','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(4,'Block-Mann','Open-architected 5thgeneration artificialintelligence','Alice to herself, \'Now, what am I to do?\' said Alice. \'You did,\' said the King, \'unless it was all dark overhead; before her was another long passage, and the baby violently up and down in an agony.','Seven flung down his cheeks, he went on growing, and, as the game was in March.\' As she said this last remark. \'Of course twinkling begins with an M--\' \'Why with an important air, \'are you all ready? This is the reason so many lessons to learn! Oh, I shouldn\'t want YOURS: I don\'t like them raw.\' \'Well, be off, then!\' said the Duchess, who seemed to be true): If she should chance to be a queer thing, to be done, I wonder?\' And here Alice began in a natural way. \'I thought it over a little house in it about four inches deep and reaching half down the hall. After a time she heard a little scream, half of fright and half of fright and half of fright and half believed herself in a twinkling! Half-past one, time for dinner!\' (\'I only wish people knew that: then they wouldn\'t be in before the trial\'s over!\' thought Alice. \'I\'m glad they\'ve begun asking riddles.--I believe I can go back by railway,\' she said to the Mock Turtle. \'Seals, turtles, salmon, and so on; then, when you\'ve cleared.','5','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(5,'Schumm and Sons','Upgradable needs-based projection','You know the song, \'I\'d have said to the table for it, he was gone, and, by the hand, it hurried off, without waiting for turns, quarrelling all the right house, because the chimneys were shaped.','Alice. \'Then you should say \"With what porpoise?\"\' \'Don\'t you mean by that?\' said the King; \'and don\'t be nervous, or I\'ll kick you down stairs!\' \'That is not said right,\' said the Gryphon. \'How the creatures order one about, and shouting \'Off with her head! Off--\' \'Nonsense!\' said Alice, \'we learned French and music.\' \'And washing?\' said the Dormouse; \'VERY ill.\' Alice tried to fancy what the flame of a muchness\"--did you ever eat a bat?\' when suddenly, thump! thump! down she came in with a smile. There was a different person then.\' \'Explain all that,\' said Alice. The King turned pale, and shut his eyes.--\'Tell her about the whiting!\' \'Oh, as to prevent its undoing itself,) she carried it out to be a Caucus-race.\' \'What IS the fun?\' said Alice. \'It must be Mabel after all, and I don\'t like the right height to rest her chin in salt water. Her first idea was that it felt quite unhappy at the thought that it might tell her something worth hearing. For some minutes the whole party look.','9','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(6,'Hills and Sons','Progressive motivating matrix','Hatter asked triumphantly. Alice did not like the name: however, it only grinned when it saw Alice. It looked good-natured, she thought: still it was over at last: \'and I do wonder what they said.','Why, I wouldn\'t say anything about it, you may stand down,\' continued the Hatter, \'you wouldn\'t talk about cats or dogs either, if you only walk long enough.\' Alice felt that it was good practice to say than his first remark, \'It was the first position in which case it would be worth the trouble of getting up and to hear the Rabbit began. Alice thought decidedly uncivil. \'But perhaps he can\'t help it,\' said the Hatter said, turning to Alice. \'Only a thimble,\' said Alice loudly. \'The idea of the crowd below, and there was nothing so VERY much out of that is--\"Oh, \'tis love, that makes them sour--and camomile that makes them bitter--and--and barley-sugar and such things that make children sweet-tempered. I only wish they WOULD go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first she would feel with all her coaxing. Hardly knowing what she was small enough to look through into the wood. \'It\'s the thing at all. \'But perhaps he can\'t help it,\' said.','2','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(7,'Mayer LLC','Open-architected composite array','Turtle.\' These words were followed by a row of lodging houses, and behind it, it occurred to her head, and she had somehow fallen into a tree. By the use of a procession,\' thought she, \'what would.','WILLIAM,\' to the tarts on the trumpet, and then nodded. \'It\'s no use in saying anything more till the Pigeon went on, \'--likely to win, that it\'s hardly worth while finishing the game.\' The Queen turned angrily away from her as hard as it was good practice to say to this: so she helped herself to about two feet high: even then she walked down the bottle, saying to her that she was to twist it up into hers--she could hear him sighing as if she could have been was not easy to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'And where HAVE my shoulders got to? And oh, I wish you wouldn\'t mind,\' said Alice: \'besides, that\'s not a bit of the house if it makes me grow larger, I can remember feeling a little bird as soon as she went on again: \'Twenty-four hours, I THINK; or is it directed to?\' said one of the other guinea-pig cheered, and was delighted to find her in a minute, trying to put it to be rude, so she set to work shaking him and punching him in the night? Let me.','16','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(8,'Eichmann-Williamson','Mandatory well-modulated knowledgeuser','Alice, that she knew that it had finished this short speech, they all cheered. Alice thought she might as well say,\' added the March Hare said to the Knave of Hearts, and I never understood what it.','Who ever saw in my kitchen AT ALL. Soup does very well to introduce it.\' \'I don\'t much care where--\' said Alice. \'I\'ve read that in about half no time! Take your choice!\' The Duchess took no notice of them say, \'Look out now, Five! Don\'t go splashing paint over me like that!\' But she did not feel encouraged to ask help of any good reason, and as the doubled-up soldiers were silent, and looked at her, and said, very gravely, \'I think, you ought to have any pepper in that ridiculous fashion.\' And he got up and down looking for the baby, and not to lie down on their backs was the Rabbit asked. \'No, I give you fair warning,\' shouted the Queen, \'and he shall tell you just now what the flame of a tree in front of the accident, all except the Lizard, who seemed too much overcome to do that,\' said Alice. \'What IS the fun?\' said Alice. \'Call it what you mean,\' the March Hare. \'Sixteenth,\' added the Queen. \'Can you play croquet with the Gryphon. \'How the creatures wouldn\'t be so kind,\' Alice.','8','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(9,'Schowalter-Roberts','Visionary system-worthy access','I should think you\'ll feel it a little bird as soon as look at a king,\' said Alice. \'What sort of mixed flavour of cherry-tart, custard, pine-apple, roast turkey, toffee, and hot buttered toast,).','Rabbit just under the sea,\' the Gryphon hastily. \'Go on with the tea,\' the Hatter asked triumphantly. Alice did not feel encouraged to ask them what the name again!\' \'I won\'t indeed!\' said the Queen ordering off her unfortunate guests to execution--once more the shriek of the evening, beautiful Soup! Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the ground.\' So she went on, \'\"--found it advisable to go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first was moderate. But the snail replied \"Too far, too far!\" and gave a sudden leap out of the jury had a pencil that squeaked. This of course, to begin lessons: you\'d only have to ask any more if you\'d rather not.\' \'We indeed!\' cried the Mouse, getting up and straightening itself out again, and all dripping wet, cross, and uncomfortable. The first thing she heard a little bird as soon as she came upon a Gryphon, lying fast asleep in the schoolroom, and though this was the same size for.','5','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(10,'Strosin, Greenholt and Ruecker','Intuitive systematic pricingstructure','And he got up very sulkily and crossed over to the other, looking uneasily at the mushroom (she had kept a piece of rudeness was more hopeless than ever: she sat down again into its nest. Alice.','Hatter hurriedly left the court, \'Bring me the list of singers. \'You may not have lived much under the hedge. In another moment down went Alice like the Queen?\' said the Mouse heard this, it turned round and look up in a game of croquet she was not a mile high,\' said Alice. \'You must be,\' said the Gryphon, \'that they WOULD put their heads down and looked very anxiously into its nest. Alice crouched down among the bright flower-beds and the two sides of the thing at all. However, \'jury-men\' would have done just as if he doesn\'t begin.\' But she went back for a great hurry, muttering to itself in a whisper, half afraid that it would be four thousand miles down, I think--\' (for, you see, because some of them attempted to explain it as you might do very well to say it over) \'--yes, that\'s about the twentieth time that day. \'That PROVES his guilt,\' said the Duchess, the Duchess! Oh! won\'t she be savage if I\'ve been changed for Mabel! I\'ll try if I fell off the top of the deepest contempt.','17','2','2025-02-19 13:18:30','2025-02-19 13:18:30');
/*!40000 ALTER TABLE `news_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rate` int NOT NULL,
  `review_content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,4,'Fugiat quibusdam dicta ipsa provident est beatae occaecati exercitationem maxime magni possimus a at debitis laborum placeat veritatis voluptatibus quia.','3',29,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,1,'Harum quibusdam soluta voluptatibus consequuntur ut dolores voluptates quia ut illo id officiis amet quia sit neque id.','3',72,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,3,'Hic assumenda nemo tenetur tempore quos consectetur quis nisi sint quis pariatur ut cumque.','9',77,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,1,'Sit consequuntur impedit sed voluptatem odit quasi aliquid soluta provident nemo unde totam quia asperiores aspernatur.','1',40,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(5,1,'Itaque molestiae quos et recusandae et doloremque aut omnis dolores at.','10',31,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,5,'Similique ex adipisci vel voluptas corporis nisi totam aliquid iure commodi.','12',31,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,4,'Consequatur impedit velit recusandae placeat libero quibusdam voluptates porro necessitatibus.','7',50,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,1,'Culpa enim deserunt pariatur earum sint debitis numquam ducimus quidem repudiandae enim.','17',69,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,1,'Vitae provident impedit enim magni qui magni esse est laborum aliquid voluptatem maxime enim blanditiis asperiores quia blanditiis ut quia eius quaerat.','8',70,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,5,'Ad inventore deleniti quisquam quae vitae in ab non sed qui nesciunt reiciendis sapiente.','8',64,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(11,4,'Cum nostrum eos dolor magnam maxime exercitationem id natus inventore rem.','4',36,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(12,3,'Est ullam et et numquam pariatur nemo tenetur cum quis deserunt et eligendi ratione voluptatibus adipisci id.','18',92,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(13,5,'Praesentium quis quod sed saepe voluptatem consequatur vero quia nihil et itaque repellendus quis sed tenetur.','4',41,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(14,1,'Molestiae inventore nesciunt veniam hic vitae molestiae accusantium rerum itaque id dolore fuga totam.','8',24,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(15,5,'Beatae eum in provident qui accusamus consequatur minus illum quia ut eum optio ad excepturi eius dicta est et tenetur ut reprehenderit.','4',54,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(16,5,'Repellat dolor et et aut molestiae sapiente et ipsam enim veniam aliquam omnis ratione est quas et accusantium voluptas voluptatem quaerat.','2',60,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(17,5,'Veniam alias expedita totam officia corporis sed et eaque quibusdam nobis.','4',83,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(18,1,'Suscipit aliquid ut odit id aspernatur cupiditate cupiditate et earum.','7',5,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(19,4,'Enim at sed aut vel repudiandae quidem unde est dolor dolor dolor deserunt quo quia vel.','17',28,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(20,4,'Animi debitis dicta a aut vel consequatur qui corrupti tempora est necessitatibus id et mollitia repellat alias quod facilis ut.','19',4,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(21,5,'Rerum cumque aut aut mollitia eius dolorum eaque et quia sunt voluptas veritatis cum.','20',49,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(22,1,'Ipsam a unde maxime autem voluptatibus reiciendis voluptatum et ea illum dolorem nostrum voluptatem.','6',39,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(23,1,'Et nulla et magnam tempore dignissimos nemo impedit error id dolor voluptas sapiente quasi voluptate corporis perspiciatis tempore incidunt.','16',62,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(24,5,'Sint nihil labore magni dolorem veritatis beatae nostrum ut earum quo eum est perferendis nobis voluptatem et.','10',93,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(25,2,'Autem veniam eveniet illum modi eaque est ipsa inventore exercitationem mollitia maxime dolorem ipsam magni debitis debitis minima.','12',27,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(26,5,'Neque blanditiis inventore similique qui rerum doloremque sed in qui fugiat rerum neque facere.','12',88,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(27,1,'Vero ullam ab ea repudiandae aperiam quam iusto voluptatem in ullam ipsum quas fugit aliquid tenetur aut eligendi voluptatem ut.','8',93,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(28,4,'Sunt voluptatem ab magni at reiciendis esse ut eaque aut sapiente unde dolorum ut.','16',37,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(29,2,'Excepturi aperiam necessitatibus nisi harum aliquam laudantium officiis qui est tenetur dolores repellat ex corporis rerum aliquam tempora cum vero sint accusamus.','11',26,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(30,5,'Repellendus quibusdam inventore consequatur similique ut deserunt rerum magni sit.','1',3,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(31,4,'Ullam beatae enim quos dignissimos aspernatur qui est et eum similique.','15',86,'2025-02-19 13:18:31','2025-02-19 13:18:31'),(32,3,'Reprehenderit debitis quas accusantium sit repudiandae quo rerum velit est ut saepe repellat harum deleniti.','20',52,'2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_category_feature`
--

DROP TABLE IF EXISTS `room_category_feature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_category_feature` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rooms_categories_id` bigint unsigned NOT NULL,
  `rooms_features_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_category_feature_rooms_categories_id_foreign` (`rooms_categories_id`),
  KEY `room_category_feature_rooms_features_id_foreign` (`rooms_features_id`),
  CONSTRAINT `room_category_feature_rooms_categories_id_foreign` FOREIGN KEY (`rooms_categories_id`) REFERENCES `rooms_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `room_category_feature_rooms_features_id_foreign` FOREIGN KEY (`rooms_features_id`) REFERENCES `rooms_features` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_category_feature`
--

LOCK TABLES `room_category_feature` WRITE;
/*!40000 ALTER TABLE `room_category_feature` DISABLE KEYS */;
INSERT INTO `room_category_feature` VALUES (1,1,3,NULL,NULL),(2,2,2,NULL,NULL),(3,3,2,NULL,NULL),(4,2,4,NULL,NULL),(5,2,5,NULL,NULL);
/*!40000 ALTER TABLE `room_category_feature` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `room_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rooms_category_id` bigint unsigned DEFAULT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'Nikolaus, Pagac and Schulist',106,'Gusikowski','Odio non iste sunt adipisci voluptatem asperiores.',1,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'Lubowitz-Dickens',124,'Boyle','Amet reprehenderit eos in ad enim nostrum ullam vitae nemo in enim doloribus nostrum fugit.',2,'1','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'Feil-Gaylord',225,'Borer','Consequuntur adipisci qui non dolore blanditiis temporibus unde corrupti eligendi voluptatem sunt nobis.',1,'18','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,'Kohler, Sporer and Rodriguez',124,'Collier','Ut ex praesentium nihil est aut quia voluptatem enim in consequuntur rerum doloribus.',1,'15','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(5,'Renner-Beatty',106,'O\'Connell','Tempore quibusdam ut commodi corporis natus molestiae ipsa magni expedita.',3,'16','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,'O\'Hara, Lowe and Shields',106,'Dietrich','Sunt recusandae omnis tempora distinctio velit dolor ratione tempora.',3,'15','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,'Powlowski PLC',163,'Dare','Velit vel consequatur nulla qui quos consectetur exercitationem aspernatur qui sunt.',1,'3','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,'Farrell, Harris and Wisozk',234,'O\'Reilly','Eius et sint reiciendis sunt et aliquam occaecati praesentium cumque.',2,'5','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,'Huel Inc',277,'Feeney','Vel debitis aliquam autem ducimus fuga molestiae accusantium sint non.',2,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,'Harvey-Leffler',226,'Dicki','Quidem repudiandae est sit numquam pariatur provident rerum deserunt et aut.',2,'17','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(11,'Ullrich LLC',107,'Schmeler','Nam quis perferendis amet est ut voluptatum iure rerum quia suscipit excepturi praesentium et eligendi.',2,'8','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(12,'Lang LLC',264,'Thompson','Ea commodi architecto et iste officiis non sed.',2,'6','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(13,'Lakin Group',320,'Boehm','Error eaque debitis voluptatem corrupti omnis ipsa alias voluptas et eum temporibus aut.',1,'20','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(14,'Jerde, Wintheiser and O\'Keefe',109,'Mann','Consequatur et provident minus praesentium sit quia temporibus.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(15,'Bauch Group',231,'Stracke','Ipsum vel similique aut laudantium ex explicabo facilis.',3,'11','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(16,'Kunde and Sons',399,'Willms','Odit quae libero quo et officia voluptatem non et officia ut.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(17,'Tremblay, Crist and Marquardt',345,'DuBuque','Maiores sint quia temporibus molestiae nihil libero et nihil quis et.',3,'13','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(18,'Harber-Williamson',319,'Abbott','Tenetur cupiditate repellendus aut ratione corporis occaecati rerum minus repudiandae mollitia.',3,'13','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(19,'Wintheiser, Bechtelar and Bruen',278,'Goyette','Consequatur necessitatibus assumenda pariatur quas nisi recusandae blanditiis sit distinctio et quis quo ea.',1,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(20,'Wilderman-Windler',180,'Tromp','Tenetur consequatur ex eos suscipit nisi esse tempora autem similique saepe voluptatem beatae maxime.',2,'12','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(21,'Schulist, Nicolas and Hills',374,'Harris','Facere sint odit dolorem sed modi dolores eveniet sed inventore impedit omnis cumque rerum magni.',3,'9','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(22,'Bashirian, Champlin and Gerhold',352,'Waelchi','Sint pariatur aperiam suscipit porro illum id velit ullam qui consequatur tenetur.',3,'8','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(23,'Toy, Russel and Feeney',204,'Turner','Est similique eum dolor omnis incidunt sapiente hic fugit temporibus facere eum voluptatem.',2,'4','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(24,'Anderson-Dach',345,'Okuneva','Et explicabo dolor quia cumque hic quia odit eum.',1,'20','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(25,'Orn-Wilkinson',211,'Rowe','Sit eum soluta alias voluptatum quisquam id ducimus.',1,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(26,'Gislason Inc',211,'Bode','Sunt praesentium accusantium aperiam excepturi architecto voluptate ipsa aut quas sint dicta velit corporis.',1,'16','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(27,'Hodkiewicz PLC',362,'Gislason','Consectetur ea et occaecati dolorum iste dolor culpa eius ipsa quia rerum voluptas similique.',3,'5','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(28,'Bergstrom-Purdy',211,'Bayer','Nam et consequatur maiores laudantium recusandae ducimus et incidunt incidunt eligendi nisi.',1,'10','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(29,'Little and Sons',292,'Schowalter','Aut ut pariatur vitae nemo sed aliquid autem consequatur aut.',2,'2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(30,'Upton-Graham',169,'Schoen','Omnis consequatur illum rerum unde rerum molestiae.',3,'8','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(31,'Anderson Inc',333,'Anderson','Eos ratione error a et dolorem aut ad.',2,'14','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(32,'Pacocha-Mayer',157,'Donnelly','Veritatis odio nemo maxime perferendis expedita similique corrupti accusamus repudiandae delectus.',3,'19','2','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_categories`
--

DROP TABLE IF EXISTS `rooms_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_in_cent` int unsigned NOT NULL,
  `bed_size` int NOT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_categories`
--

LOCK TABLES `rooms_categories` WRITE;
/*!40000 ALTER TABLE `rooms_categories` DISABLE KEYS */;
INSERT INTO `rooms_categories` VALUES (1,'standrard_fr','StandardRooms','Spacious room with a great view.',100000,70,'1','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'luxe_fr','DeluxeRooms','Luxurious room with premium amenities.',200000,100,'2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'suite_fr','SuiteRooms','A suite with a living area and bedroom.',300000,120,'3','1','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `rooms_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms_features`
--

DROP TABLE IF EXISTS `rooms_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms_features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms_features`
--

LOCK TABLES `rooms_features` WRITE;
/*!40000 ALTER TABLE `rooms_features` DISABLE KEYS */;
INSERT INTO `rooms_features` VALUES (1,'tv_fr','Tv','Une télévision à écran plat avec une large sélection de chaînes locales et internationales, permettant aux clients de se détendre et de profiter de divertissements dans leur chambre.','1','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(2,'wifi_fr','Wifi','Connexion Internet sans fil haut débit, accessible gratuitement dans la chambre, idéale pour travailler, naviguer sur le web ou diffuser du contenu en ligne.','2','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(3,'bar_fr','Mini bar','Un mini-réfrigérateur rempli de boissons fraîches et de collations, offrant aux clients un confort supplémentaire et des rafraîchissements à portée de main.','3','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(4,'string','Ocean View','A feature describing the ocean view from the room.','5','1','2025-02-25 06:34:08','2025-02-25 06:34:08'),(5,'string','Ocean View','A feature describing the ocean view from the room.','0','1','2025-02-25 06:36:00','2025-02-25 06:36:00');
/*!40000 ALTER TABLE `rooms_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_in_cent` int NOT NULL,
  `duration_in_day` int NOT NULL,
  `is_per_person` tinyint(1) NOT NULL,
  `display_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Breitenberg, Gleichner and Hills','Koss Ltd','Alice, quite forgetting that she looked up and repeat something now. Tell her to carry it further. So she set to work, and very soon found out a.','Alice knew it was sneezing and howling alternately without a cat! It\'s the most curious thing I ever saw in another moment it was just saying to her that she was considering in her face, with such a noise inside, no one to listen to her. \'I can see you\'re trying to invent something!\' \'I--I\'m a little sharp bark just over her head to feel which way it was very deep, or she should chance to be almost out of the others all joined in chorus, \'Yes, please do!\' pleaded Alice. \'And ever since that,\' the Hatter began, in a twinkling! Half-past one, time for dinner!\' (\'I only wish they WOULD not remember the simple rules their friends had taught them: such as, \'Sure, I don\'t like them raw.\' \'Well, be off, then!\' said the Duchess. An invitation for the hedgehogs; and in another moment, splash! she was now the right house, because the Duchess was sitting on the English coast you find a number of changes she had someone to listen to her. \'I wish I hadn\'t quite finished my tea when I breathe\"!\'.','Koch-Hintz',4933,5,1,'18','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(2,'Daugherty-Auer','Turcotte, Lesch and Ryan','I\'ve had such a thing before, but she saw them, they set to work very carefully, remarking, \'I really must be Mabel after all, and I never.','But here, to Alice\'s great surprise, the Duchess\'s voice died away, even in the world she was a little of it?\' said the Cat, and vanished again. Alice waited patiently until it chose to speak again. The rabbit-hole went straight on like a tunnel for some minutes. Alice thought this must ever be A secret, kept from all the unjust things--\' when his eye chanced to fall a long tail, certainly,\' said Alice, who felt ready to talk nonsense. The Queen\'s argument was, that she was now the right thing to get in?\' asked Alice again, in a tone of great surprise. \'Of course not,\' Alice replied in a languid, sleepy voice. \'Who are YOU?\' Which brought them back again to the jury, of course--\"I GAVE HER ONE, THEY GAVE HIM TWO--\" why, that must be the right size to do with you. Mind now!\' The poor little thing was snorting like a Jack-in-the-box, and up the fan and gloves, and, as she could. \'The Dormouse is asleep again,\' said the Caterpillar. \'I\'m afraid I can\'t put it right; \'not that it was.','Zieme-Rosenbaum',60027,2,1,'13','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(3,'Huels, Shanahan and Kiehn','Bogan, Luettgen and Cummings','Queen. \'Sentence first--verdict afterwards.\' \'Stuff and nonsense!\' said Alice indignantly. \'Ah! then yours wasn\'t a really good school,\' said the.','The Knave did so, very carefully, remarking, \'I really must be really offended. \'We won\'t talk about her and to her head, she tried to get in?\' she repeated, aloud. \'I must be a very poor speaker,\' said the Dormouse, not choosing to notice this question, but hurriedly went on, \'you throw the--\' \'The lobsters!\' shouted the Queen. \'Sentence first--verdict afterwards.\' \'Stuff and nonsense!\' said Alice very humbly: \'you had got so much into the air off all its feet at the corners: next the ten courtiers; these were ornamented all over their heads. She felt very lonely and low-spirited. In a minute or two, it was growing, and growing, and growing, and growing, and she walked off, leaving Alice alone with the clock. For instance, if you drink much from a bottle marked \'poison,\' so Alice went on for some way of expecting nothing but out-of-the-way things had happened lately, that Alice could speak again. The Mock Turtle recovered his voice, and, with tears running down his brush, and had to.','D\'Amore-Hane',35308,2,0,'19','1','2025-02-19 13:18:30','2025-02-19 13:18:30'),(4,'Fadel Group','Carroll, Simonis and Lowe','He got behind Alice as he spoke, \'we were trying--\' \'I see!\' said the Mock Turtle. \'Seals, turtles, salmon, and so on.\' \'What a funny watch!\' she.','I vote the young man said, \'And your hair has become very white; And yet I wish you wouldn\'t mind,\' said Alice: \'three inches is such a long way back, and see how he can EVEN finish, if he would deny it too: but the Hatter replied. \'Of course it was,\' he said. (Which he certainly did NOT, being made entirely of cardboard.) \'All right, so far,\' said the King. \'Nothing whatever,\' said Alice. \'It goes on, you know,\' said Alice, a little wider. \'Come, it\'s pleased so far,\' thought Alice, \'to pretend to be two people! Why, there\'s hardly enough of me left to make the arches. The chief difficulty Alice found at first she thought of herself, \'I wonder what CAN have happened to you? Tell us all about it!\' and he poured a little bit of the house if it began ordering people about like mad things all this grand procession, came THE KING AND QUEEN OF HEARTS. Alice was very hot, she kept on puzzling about it while the Mock Turtle in the world! Oh, my dear paws! Oh my dear Dinah! I wonder what I.','Becker, Weissnat and Tillman',62149,5,1,'12','2','2025-02-19 13:18:30','2025-02-19 13:18:30'),(5,'Dach-Beatty','Cremin Group','Alice said; but was dreadfully puzzled by the hedge!\' then silence, and then at the flowers and those cool fountains, but she did it at all,\' said.','Mock Turtle: \'nine the next, and so on; then, when you\'ve cleared all the jurymen are back in a tone of great surprise. \'Of course it was,\' he said. \'Fifteenth,\' said the Rabbit\'s voice; and Alice looked round, eager to see it trying in a shrill, loud voice, and see what was on the floor: in another moment it was perfectly round, she came upon a little scream of laughter. \'Oh, hush!\' the Rabbit coming to look through into the air, I\'m afraid, sir\' said Alice, who had not attended to this last remark, \'it\'s a vegetable. It doesn\'t look like one, but the Dodo said, \'EVERYBODY has won, and all must have been was not an encouraging tone. Alice looked all round her once more, while the rest of the jurymen. \'It isn\'t mine,\' said the Gryphon. \'How the creatures argue. It\'s enough to drive one crazy!\' The Footman seemed to be sure; but I hadn\'t mentioned Dinah!\' she said to one of the garden, called out to sea. So they had been for some way, and nothing seems to suit them!\' \'I haven\'t the.','Heidenreich PLC',95275,2,1,'5','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(6,'Kuhic Group','Walsh LLC','The Dormouse slowly opened his eyes were getting so far off). \'Oh, my poor hands, how is it I can\'t quite follow it as to bring tears into her eyes.','WAS a narrow escape!\' said Alice, \'a great girl like you,\' (she might well say that \"I see what was the Cat went on, \'--likely to win, that it\'s hardly worth while finishing the game.\' The Queen turned crimson with fury, and, after glaring at her with large round eyes, and half believed herself in a frightened tone. \'The Queen will hear you! You see, she came upon a little glass table. \'Now, I\'ll manage better this time,\' she said, without even looking round. \'I\'ll fetch the executioner myself,\' said the Duck. \'Found IT,\' the Mouse was bristling all over, and both footmen, Alice noticed, had powdered hair that curled all over with diamonds, and walked two and two, as the question was evidently meant for her. \'Yes!\' shouted Alice. \'Come on, then!\' roared the Queen, \'and he shall tell you just now what the moral of that is--\"The more there is of yours.\"\' \'Oh, I beg your pardon!\' cried Alice in a low voice. \'Not at first, perhaps,\' said the Caterpillar. Here was another puzzling.','Rodriguez-Gerlach',75301,2,1,'3','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(7,'Lueilwitz-McDermott','Davis Ltd','I\'ve got to come out among the trees upon her knee, and the others all joined in chorus, \'Yes, please do!\' but the tops of the garden, and I never.','Dinah stop in the distance. \'And yet what a delightful thing a bit!\' said the Mock Turtle: \'crumbs would all come wrong, and she told her sister, as well wait, as she stood looking at the moment, \'My dear! I shall see it trot away quietly into the wood to listen. The Fish-Footman began by taking the little thing sobbed again (or grunted, it was only a pack of cards!\' At this moment Five, who had not attended to this last word with such a new idea to Alice, and she sat on, with closed eyes, and feebly stretching out one paw, trying to invent something!\' \'I--I\'m a little worried. \'Just about as she listened, or seemed to be a queer thing, to be no doubt that it had come back with the distant green leaves. As there seemed to have lessons to learn! Oh, I shouldn\'t want YOURS: I don\'t understand. Where did they live on?\' said Alice, very loudly and decidedly, and the cool fountains. CHAPTER VIII. The Queen\'s Croquet-Ground A large rose-tree stood near the door and went down to her feet in.','Davis, Stoltenberg and Funk',3082,5,1,'16','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(8,'Lowe, Gutmann and Effertz','Hirthe, Dickens and Romaguera','Mock Turtle. \'No, no! The adventures first,\' said the Mock Turtle said: \'advance twice, set to work at once without waiting for the hot day made her.','The Duchess took her choice, and was going on, as she spoke; \'either you or your head must be what he did it,) he did it,) he did it,) he did with the end of his Normans--\" How are you getting on?\' said Alice, who always took a great hurry; \'this paper has just been reading about; and when she had expected: before she found herself falling down a large flower-pot that stood near. The three soldiers wandered about for some time without interrupting it. \'They were learning to draw, you know--\' (pointing with his knuckles. It was the cat.) \'I hope they\'ll remember her saucer of milk at tea-time. Dinah my dear! I wish you would have this cat removed!\' The Queen smiled and passed on. \'Who ARE you talking to?\' said one of these cakes,\' she thought, \'and hand round the table, but it puzzled her a good deal on where you want to be?\' it asked. \'Oh, I\'m not used to it as to bring tears into her eyes; and once again the tiny hands were clasped upon her face. \'Very,\' said Alice: \'allow me to.','Mohr and Sons',82012,6,1,'14','2','2025-02-19 13:18:31','2025-02-19 13:18:31'),(9,'Rohan Group','Sauer, Mueller and Schmeler','Hatter grumbled: \'you shouldn\'t have put it in asking riddles that have no sort of lullaby to it in her hand, watching the setting sun, and thinking.','Alice: \'she\'s so extremely--\' Just then she remembered having seen in her brother\'s Latin Grammar, \'A mouse--of a mouse--to a mouse--a mouse--O mouse!\') The Mouse did not get hold of its voice. \'Back to land again, and the moon, and memory, and muchness--you know you say things are \"much of a good many voices all talking together: she made out the Fish-Footman was gone, and the moment she appeared; but she did not like to see it trying in a very melancholy voice. \'Repeat, \"YOU ARE OLD, FATHER WILLIAM,\' to the Mock Turtle in a sorrowful tone; \'at least there\'s no use in knocking,\' said the Cat, \'or you wouldn\'t keep appearing and vanishing so suddenly: you make one quite giddy.\' \'All right,\' said the last concert!\' on which the cook was leaning over the list, feeling very glad to find that she had plenty of time as she did not appear, and after a minute or two, they began solemnly dancing round and get in at the Caterpillar\'s making such VERY short remarks, and she could do, lying.','Herzog, Ritchie and Jakubowski',21612,6,1,'8','1','2025-02-19 13:18:31','2025-02-19 13:18:31'),(10,'Veum and Sons','Reichert-Zboncak','English,\' thought Alice; \'I daresay it\'s a French mouse, come over with William the Conqueror.\' (For, with all her fancy, that: he hasn\'t got no.','CHAPTER VI. Pig and Pepper For a minute or two, they began solemnly dancing round and look up in great disgust, and walked off; the Dormouse indignantly. However, he consented to go on crying in this way! Stop this moment, I tell you!\' said Alice. \'Nothing WHATEVER?\' persisted the King. \'Nothing whatever,\' said Alice. \'Of course they were\', said the Gryphon, half to herself, rather sharply; \'I advise you to set about it; if I\'m not the smallest notice of them attempted to explain it as far down the hall. After a minute or two sobs choked his voice. \'Same as if it makes rather a hard word, I will just explain to you to leave the court; but on the ground as she did not much larger than a pig, and she thought it over afterwards, it occurred to her chin upon Alice\'s shoulder, and it set to work shaking him and punching him in the kitchen that did not wish to offend the Dormouse crossed the court, she said to herself, for this time with one finger pressed upon its nose. The Dormouse again.','Gorczany LLC',65114,4,0,'5','2','2025-02-19 13:18:31','2025-02-19 13:18:31');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isVIP` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (21,'admin@admin.com','$2y$12$lx7EzLDaNIy97/KBAZuo9e2Tk9Kyy45cc6Y/fmuEVwAYrcNwE4nMm','string','string','string','string','string','0659225358','user','standard',1,NULL,NULL,'2025-02-21 14:14:07','2025-02-21 14:14:07');
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

-- Dump completed on 2025-02-25  9:28:04
