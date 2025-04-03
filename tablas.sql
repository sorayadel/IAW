-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: sallepresencia
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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

CREATE DATABASE IF NOT EXISTS sallepresencia COLLATE 'utf8mb4_general_ci' ;

USE sallepresencia;

--
-- Table structure for table `fichadas`
--

DROP TABLE IF EXISTS `fichadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fichadas` (
  `id_fichada` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fichada_inicio_1` datetime DEFAULT NULL,
  `fichada_fin_1` datetime DEFAULT NULL,
  `fichada_inicio_2` datetime DEFAULT NULL,
  `fichada_fin_2` datetime DEFAULT NULL,
  `fichada_inicio_3` datetime DEFAULT NULL,
  `fichada_fin_3` datetime DEFAULT NULL,
  `fichada_inicio_4` datetime DEFAULT NULL,
  `fichada_fin_4` datetime DEFAULT NULL,
  `tiempo` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id_fichada`),
  KEY `fichadas_usuarios_FK` (`id_usuario`),
  CONSTRAINT `fichadas_usuarios_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fichadas`
--

LOCK TABLES `fichadas` WRITE;
/*!40000 ALTER TABLE `fichadas` DISABLE KEYS */;
INSERT INTO `fichadas` VALUES (1,10,'2025-03-31','0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00),(2,10,'2025-03-31','0000-00-00 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00),(3,13,'2025-04-01','2020-12-14 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00),(4,13,'2025-04-01','2020-12-14 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00);
/*!40000 ALTER TABLE `fichadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historico_fichadas`
--

DROP TABLE IF EXISTS `historico_fichadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_fichadas` (
  `id_historico_fichadas` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `procesada` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_historico_fichadas`),
  KEY `historico_fichadas_usuarios_FK` (`id_usuario`),
  CONSTRAINT `historico_fichadas_usuarios_FK` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_fichadas`
--

LOCK TABLES `historico_fichadas` WRITE;
/*!40000 ALTER TABLE `historico_fichadas` DISABLE KEYS */;
INSERT INTO `historico_fichadas` VALUES (1,1,'2025-04-01 20:50:58',0),(2,1,'2025-04-01 21:03:49',0),(3,1,'2025-04-01 21:05:22',0),(4,1,'2025-04-01 21:10:38',0),(5,1,'2025-04-02 16:49:05',0),(6,1,'2025-04-02 19:30:00',0),(7,1,'2025-04-03 11:12:31',0),(8,10,'2025-04-03 11:31:08',0),(9,10,'2025-04-03 18:59:03',0),(10,10,'2025-04-03 19:21:57',0),(11,1,'2025-04-03 12:12:31',0),(12,1,'2025-04-03 13:12:31',0),(13,1,'2025-04-03 14:12:31',0);
/*!40000 ALTER TABLE `historico_fichadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(145) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `horas` int(11) NOT NULL,
  `rol` varchar(5) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Soraya ','soraya.delreal.carrasco@gmail.com','202cb962ac59075b964b07152d234b70','01',8,'admin'),(10,'Jose ','jose@yo.com','202cb962ac59075b964b07152d234b70','02',8,'user'),(11,'David','david@yo.com','202cb962ac59075b964b07152d234b70','03',8,'user'),(13,'pepe','pepe@pepe.pepe','202cb962ac59075b964b07152d234b70','04',8,'user');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sallepresencia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-03 22:12:26
