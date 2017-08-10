CREATE DATABASE  IF NOT EXISTS `Aukcija` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `Aukcija`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 178.79.16.19    Database: Aukcija
-- ------------------------------------------------------
-- Server version	5.7.18

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
-- Table structure for table `Artikli`
--

DROP TABLE IF EXISTS `Artikli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Artikli` (
  `artikl_id` int(11) NOT NULL AUTO_INCREMENT,
  `artikl_naziv` varchar(128) COLLATE utf8_bin NOT NULL,
  `artikl_opis` varchar(128) COLLATE utf8_bin NOT NULL,
  `artikl_cena` double NOT NULL,
  `korisnik_email` varchar(512) CHARACTER SET utf8 NOT NULL,
  `artikl_kolicina` int(11) NOT NULL,
  PRIMARY KEY (`artikl_id`),
  KEY `korisnik_email` (`korisnik_email`),
  CONSTRAINT `fk_korisnik_email` FOREIGN KEY (`korisnik_email`) REFERENCES `Korisnici` (`korisnik_email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Artikli`
--

LOCK TABLES `Artikli` WRITE;
/*!40000 ALTER TABLE `Artikli` DISABLE KEYS */;
INSERT INTO `Artikli` VALUES (1,'Laptop','Lenovo Yoga 13 - Ultrabook',1300,'milos@mail.com',1),(2,'Mobilni telefon','HTC One X',100,'milos@mail.com',1),(3,'Lopta','Lopta za fucu',50,'marko@mail.com',5),(4,'KopaÄke','KopaÄke proizvoÄ‘aÄa &quot;Adidas&quot;, broj 43 ',100,'marko@mail.com',2),(5,'TaÅ¡na','TaÅ¡na proizvoÄ‘aÄa &quot;Prada&quot;',500,'katarina@mail.com',1),(6,'Lak za nokte','Lak crvene boje',10,'katarina@mail.com',5);
/*!40000 ALTER TABLE `Artikli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Korisnici`
--

DROP TABLE IF EXISTS `Korisnici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Korisnici` (
  `korisnik_id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik_fname` varchar(128) COLLATE utf8_bin NOT NULL,
  `korisnik_lname` varchar(128) COLLATE utf8_bin NOT NULL,
  `korisnik_email` varchar(512) CHARACTER SET utf8 NOT NULL,
  `korisnik_lozinka` varchar(512) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  KEY `korisnik_email` (`korisnik_email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Korisnici`
--

LOCK TABLES `Korisnici` WRITE;
/*!40000 ALTER TABLE `Korisnici` DISABLE KEYS */;
INSERT INTO `Korisnici` VALUES (1,'Nemanja','AndriÄ‡','admin@mail.com','2353639ac2cf5b3ace8159c44be7106b'),(2,'MiloÅ¡','SimiÄ‡','milos@mail.com','3c5ffb56865437caab88127d452807a0'),(3,'Marko','MarkoviÄ‡','marko@mail.com','cfd2c933a5ad84495a2e1d3421349009'),(4,'Katarina','DragiÄ‡','katarina@mail.com','f252e95d07eb41ce28bd5d44e3296021');
/*!40000 ALTER TABLE `Korisnici` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Korpa`
--

DROP TABLE IF EXISTS `Korpa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Korpa` (
  `korpa_id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik_email` varchar(512) NOT NULL,
  `artikl_id` int(11) NOT NULL,
  PRIMARY KEY (`korpa_id`),
  KEY `korisnik_email` (`korisnik_email`),
  KEY `artikl_id` (`artikl_id`),
  CONSTRAINT `fk1` FOREIGN KEY (`korisnik_email`) REFERENCES `Korisnici` (`korisnik_email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sk2` FOREIGN KEY (`artikl_id`) REFERENCES `Artikli` (`artikl_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Korpa`
--

LOCK TABLES `Korpa` WRITE;
/*!40000 ALTER TABLE `Korpa` DISABLE KEYS */;
INSERT INTO `Korpa` VALUES (1,'katarina@mail.com',4),(2,'marko@mail.com',6),(3,'milos@mail.com',3);
/*!40000 ALTER TABLE `Korpa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lista_zelja`
--

DROP TABLE IF EXISTS `Lista_zelja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lista_zelja` (
  `lista_zelja_id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik_email` varchar(512) NOT NULL,
  `artikl_id` int(11) NOT NULL,
  PRIMARY KEY (`lista_zelja_id`),
  KEY `artikl_id` (`artikl_id`),
  KEY `korisnik_email` (`korisnik_email`),
  CONSTRAINT `fk_Lista_zelja_1` FOREIGN KEY (`korisnik_email`) REFERENCES `Korisnici` (`korisnik_email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Lista_zelja_2` FOREIGN KEY (`artikl_id`) REFERENCES `Artikli` (`artikl_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lista_zelja`
--

LOCK TABLES `Lista_zelja` WRITE;
/*!40000 ALTER TABLE `Lista_zelja` DISABLE KEYS */;
INSERT INTO `Lista_zelja` VALUES (1,'katarina@mail.com',2),(2,'marko@mail.com',1),(3,'milos@mail.com',5);
/*!40000 ALTER TABLE `Lista_zelja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'Aukcija'
--

--
-- Dumping routines for database 'Aukcija'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-06  9:59:17
