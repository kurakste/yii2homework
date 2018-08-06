-- MySQL dump 10.16  Distrib 10.2.13-MariaDB, for osx10.13 (x86_64)
--
-- Host: localhost    Database: foo
-- ------------------------------------------------------
-- Server version	5.7.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `eventid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES (12,34,10),(16,35,10),(18,35,11),(21,37,10),(22,37,11),(23,38,10),(24,38,11),(25,39,10),(26,39,11),(44,40,10),(47,30,11),(48,36,10),(49,36,11);
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT ' Имя',
  `start_at` timestamp NULL DEFAULT NULL COMMENT 'Время начало.',
  `end_at` timestamp NULL DEFAULT NULL COMMENT 'Время окончания.',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время создания.',
  `updater_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время последнего изменения.',
  `uid` int(11) unsigned NOT NULL COMMENT ' Идентификатор пользователя',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `event_to_user` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (30,'Новая заметка +','2018-12-30 21:00:00','2018-12-20 15:00:00','2018-08-05 18:16:04','2018-08-05 18:16:04',11),(35,'Игорь создал событие.','2018-12-20 15:00:00','2018-12-20 15:00:00','2018-08-05 18:48:59','2018-08-05 18:48:59',10),(36,'Еще одна заметка.','2018-12-31 15:00:00','2003-12-20 15:00:00','2018-08-06 16:29:23','2018-08-06 16:29:23',11),(37,'Еще одна заметка.','2018-11-30 21:00:00','2012-12-20 14:00:00','2018-08-06 16:51:30','2018-08-06 16:51:30',11),(39,'Еще одна заметка.','2018-12-11 21:00:00','2018-12-12 21:00:00','2018-08-06 16:53:37','2018-08-06 16:53:37',11),(40,'Старая','2018-05-31 21:00:00','2018-06-01 21:00:00','2018-08-06 19:24:36','2018-08-06 19:24:36',11);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `passwordhash` varchar(255) DEFAULT NULL,
  `accesstoken` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'igor','$2y$13$Wy7PCWEGzakA9XvXNoI0hO2FZgjDZjE.6j9omWWDwR.H.ZBg1HWKy','2fq6DTbFgZUivl_Sf06zPldepIyz0J4a'),(11,'sergey','$2y$13$.vuF/WL8aZsxG5AHYdD2zOnjxzhet0QXa.HT0NpSx0ECyf3f4bHkm','F5diJRlRES2KC9YrJmepNcTgNa5VIkt1'),(12,'igor','$2y$13$.G/x9AdOkoc5oiCBqVCZOeiCwsStGegjhmVKL57ZTzmBFEpkTtaTa','XSzv9EkDwqlGMlHs2gEEoIoglM6Obfl8');
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

-- Dump completed on 2018-08-06 22:33:33
