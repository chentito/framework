-- MySQL dump 10.13  Distrib 5.5.61, for Win64 (AMD64)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.5.61

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
-- Table structure for table `sistema_administradores`
--

DROP TABLE IF EXISTS `sistema_administradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistema_administradores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `perfil` int(11) NOT NULL,
  `fechaAlta` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_administradores`
--

LOCK TABLES `sistema_administradores` WRITE;
/*!40000 ALTER TABLE `sistema_administradores` DISABLE KEYS */;
INSERT INTO `sistema_administradores` VALUES (1,'Carlos Vicente Reyes Salazar','cvreyes','c5eab7bb0ec6c80e2a249d83b25fe514','cvreyes@mexagon.net',31,1,'0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `sistema_administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistema_sesiones`
--

DROP TABLE IF EXISTS `sistema_sesiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistema_sesiones` (
  `session_id` varchar(32) CHARACTER SET latin1 NOT NULL,
  `session_data` text CHARACTER SET latin1 NOT NULL,
  `session_expiration` int(11) NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `EliminaSesion` (`session_expiration`),
  KEY `ActualizaSesion` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistema_sesiones`
--

LOCK TABLES `sistema_sesiones` WRITE;
/*!40000 ALTER TABLE `sistema_sesiones` DISABLE KEYS */;
INSERT INTO `sistema_sesiones` VALUES ('dp8mk34gicrtc5aiiq62s3sf7d','tipoAcceso|s:15:\"administradores\";sesion|b:1;usuario|s:7:\"cvreyes\";idUsuario|s:1:\"1\";nombreUsuario|s:28:\"Carlos Vicente Reyes Salazar\";perfil|s:1:\"1\";procesID|i:4148847;',1539844142);
/*!40000 ALTER TABLE `sistema_sesiones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-17 17:54:58
