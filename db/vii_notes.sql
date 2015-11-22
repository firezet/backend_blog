-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: vii
-- ------------------------------------------------------
-- Server version	5.6.26-log

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
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` date DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `article` varchar(12550) DEFAULT NULL,
  `author` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'2002-05-15','Нотатка 1','Нотатка містить коментарі.','admin'),(5,'2015-10-17','Нотатка 2','Ця нотатка без коментарів...(','viiper94'),(6,'2015-10-23','Lorem ipsum','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut minima quod dolores, non maiores! Nostrum commodi velit, officiis, voluptates, dolor at iusto distinctio veritatis omnis doloribus, repellendus ipsum nisi debitis!\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Aut minima quod dolores, non maiores! Nostrum commodi velit, officiis, voluptates, dolor at iusto distinctio veritatis omnis doloribus, repellendus ipsum nisi debitis!\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Aut minima quod dolores, non maiores! Nostrum commodi velit, officiis, voluptates, dolor at iusto distinctio veritatis omnis doloribus, repellendus ipsum nisi debitis!\r\n','viiper94'),(7,'2015-10-30','1','11','viiper94'),(8,'2015-10-30','2','22','viiper94'),(9,'2015-10-30','3','33','viiper94'),(10,'2015-10-30','4','44','viiper94'),(11,'2015-10-30','5','55','viiper94'),(12,'2015-10-30','6','66','viiper94'),(13,'2015-10-30','7','77','viiper94'),(14,'2015-10-30','8','88','viiper94'),(15,'2015-10-30','9','99','viiper94'),(16,'2015-10-30','10','100','viiper94'),(17,'2015-10-30','11','111','viiper94'),(18,'2015-10-30','12','122','viiper94'),(19,'2015-10-30','13','133','viiper94'),(20,'2015-10-30','14','144','viiper94'),(21,'2015-10-30','15','155','viiper94'),(22,'2015-10-30','16','166','viiper94'),(23,'2015-10-30','17','177','viiper94'),(27,'2015-10-30','Нотатка від адміна','8=D','viiper94'),(28,'2015-11-02','Нотатка від смертного юзера','((.))','viiper90');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-22 20:59:59
