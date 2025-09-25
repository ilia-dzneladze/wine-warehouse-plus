-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: WineWarehousePlus
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `amberwine`
--

DROP TABLE IF EXISTS `amberwine`;
/*!50001 DROP VIEW IF EXISTS `amberwine`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `amberwine` AS SELECT 
 1 AS `wine_id`,
 1 AS `wine_name`,
 1 AS `country`,
 1 AS `unit_price`,
 1 AS `natural_status`,
 1 AS `fermentation_vessel`,
 1 AS `harvest_year`,
 1 AS `carbonation_g_L`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `business_entity`
--

DROP TABLE IF EXISTS `business_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `business_entity` (
  `business_entity_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_customer` tinyint(1) NOT NULL DEFAULT '0',
  `is_winemaker` tinyint(1) NOT NULL DEFAULT '0',
  `loyalty_points` int DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`business_entity_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_entity`
--

LOCK TABLES `business_entity` WRITE;
/*!40000 ALTER TABLE `business_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `card`
--

DROP TABLE IF EXISTS `card`;
/*!50001 DROP VIEW IF EXISTS `card`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `card` AS SELECT 
 1 AS `payment_type_id`,
 1 AS `bank`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `order_line`
--

DROP TABLE IF EXISTS `order_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_line` (
  `order_line_id` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `unit_price` decimal(6,2) NOT NULL,
  `wine_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  PRIMARY KEY (`order_line_id`),
  KEY `wine_id` (`wine_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`wine_id`) REFERENCES `wine` (`wine_id`),
  CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_line`
--

LOCK TABLES `order_line` WRITE;
/*!40000 ALTER TABLE `order_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_line` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `order_line_purchase`
--

DROP TABLE IF EXISTS `order_line_purchase`;
/*!50001 DROP VIEW IF EXISTS `order_line_purchase`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `order_line_purchase` AS SELECT 
 1 AS `order_line_id`,
 1 AS `quantity`,
 1 AS `unit_price`,
 1 AS `wine_id`,
 1 AS `order_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `order_line_sale`
--

DROP TABLE IF EXISTS `order_line_sale`;
/*!50001 DROP VIEW IF EXISTS `order_line_sale`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `order_line_sale` AS SELECT 
 1 AS `order_line_id`,
 1 AS `quantity`,
 1 AS `unit_price`,
 1 AS `wine_id`,
 1 AS `order_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_date` date DEFAULT NULL,
  `order_status` enum('placed','packed','shipped','delivered') NOT NULL,
  `expected_delivery_date` date DEFAULT NULL,
  `is_sale` tinyint(1) NOT NULL DEFAULT '0',
  `is_purchase` tinyint(1) NOT NULL DEFAULT '0',
  `payment_type_id` int DEFAULT NULL,
  `business_entity_id` int DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `payment_type_id` (`payment_type_id`),
  KEY `business_entity_id` (`business_entity_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`payment_type_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`business_entity_id`) REFERENCES `business_entity` (`business_entity_id`),
  CONSTRAINT `chk_sale_purchase` CHECK ((((`is_sale` = 1) and (`is_purchase` = 0)) or ((`is_sale` = 0) and (`is_purchase` = 1))))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_type`
--

DROP TABLE IF EXISTS `payment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_type` (
  `payment_type_id` int NOT NULL AUTO_INCREMENT,
  `bank` varchar(50) DEFAULT NULL,
  `is_card` tinyint(1) NOT NULL DEFAULT '0',
  `is_wire` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payment_type_id`),
  CONSTRAINT `chk_pay_type` CHECK ((((`is_card` = 1) and (`is_wire` = 0)) or ((`is_card` = 0) and (`is_wire` = 1))))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_type`
--

LOCK TABLES `payment_type` WRITE;
/*!40000 ALTER TABLE `payment_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `purchase`
--

DROP TABLE IF EXISTS `purchase`;
/*!50001 DROP VIEW IF EXISTS `purchase`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `purchase` AS SELECT 
 1 AS `order_id`,
 1 AS `order_date`,
 1 AS `order_status`,
 1 AS `expected_delivery_date`,
 1 AS `payment_type_id`,
 1 AS `business_entity_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `redwine`
--

DROP TABLE IF EXISTS `redwine`;
/*!50001 DROP VIEW IF EXISTS `redwine`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `redwine` AS SELECT 
 1 AS `wine_id`,
 1 AS `wine_name`,
 1 AS `country`,
 1 AS `unit_price`,
 1 AS `natural_status`,
 1 AS `fermentation_vessel`,
 1 AS `harvest_year`,
 1 AS `tannin_level_mg_L`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `sale`
--

DROP TABLE IF EXISTS `sale`;
/*!50001 DROP VIEW IF EXISTS `sale`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `sale` AS SELECT 
 1 AS `order_id`,
 1 AS `order_date`,
 1 AS `order_status`,
 1 AS `expected_delivery_date`,
 1 AS `payment_type_id`,
 1 AS `business_entity_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `sparklingwine`
--

DROP TABLE IF EXISTS `sparklingwine`;
/*!50001 DROP VIEW IF EXISTS `sparklingwine`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `sparklingwine` AS SELECT 
 1 AS `wine_id`,
 1 AS `wine_name`,
 1 AS `country`,
 1 AS `unit_price`,
 1 AS `natural_status`,
 1 AS `fermentation_vessel`,
 1 AS `harvest_year`,
 1 AS `carbonation_g_L`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `whitewine`
--

DROP TABLE IF EXISTS `whitewine`;
/*!50001 DROP VIEW IF EXISTS `whitewine`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `whitewine` AS SELECT 
 1 AS `wine_id`,
 1 AS `wine_name`,
 1 AS `country`,
 1 AS `unit_price`,
 1 AS `natural_status`,
 1 AS `fermentation_vessel`,
 1 AS `harvest_year`,
 1 AS `total_acidity_g_L`,
 1 AS `serving_temperature_C`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wine`
--

DROP TABLE IF EXISTS `wine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wine` (
  `wine_id` int NOT NULL AUTO_INCREMENT,
  `wine_name` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `unit_price` decimal(6,2) DEFAULT NULL,
  `natural_status` enum('conventional','sustainable','organic/bio','biodynamic','natural') NOT NULL,
  `fermentation_vessel` enum('stainless_steel','oak_barrel','wooden_vat','concrete_tank','qvevri') NOT NULL,
  `harvest_year` int DEFAULT NULL,
  `is_whitewine` tinyint(1) NOT NULL DEFAULT '0',
  `is_redwine` tinyint(1) NOT NULL DEFAULT '0',
  `is_amberwine` tinyint(1) NOT NULL DEFAULT '0',
  `is_sparklingwine` tinyint(1) NOT NULL DEFAULT '0',
  `total_acidity_g_L` int DEFAULT NULL,
  `serving_temperature_C` int DEFAULT NULL,
  `tannin_level_mg_L` int DEFAULT NULL,
  `skin_contact_duration_days` int DEFAULT NULL,
  `carbonation_g_L` int DEFAULT NULL,
  `notes` varchar(400) DEFAULT NULL,
  `business_entity_id` int DEFAULT NULL,
  PRIMARY KEY (`wine_id`),
  KEY `business_entity_id` (`business_entity_id`),
  CONSTRAINT `wine_ibfk_1` FOREIGN KEY (`business_entity_id`) REFERENCES `business_entity` (`business_entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wine`
--

LOCK TABLES `wine` WRITE;
/*!40000 ALTER TABLE `wine` DISABLE KEYS */;
/*!40000 ALTER TABLE `wine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `wire`
--

DROP TABLE IF EXISTS `wire`;
/*!50001 DROP VIEW IF EXISTS `wire`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `wire` AS SELECT 
 1 AS `payment_type_id`,
 1 AS `bank`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `amberwine`
--

/*!50001 DROP VIEW IF EXISTS `amberwine`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `amberwine` AS select `wine`.`wine_id` AS `wine_id`,`wine`.`wine_name` AS `wine_name`,`wine`.`country` AS `country`,`wine`.`unit_price` AS `unit_price`,`wine`.`natural_status` AS `natural_status`,`wine`.`fermentation_vessel` AS `fermentation_vessel`,`wine`.`harvest_year` AS `harvest_year`,`wine`.`carbonation_g_L` AS `carbonation_g_L` from `wine` where (`wine`.`is_amberwine` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `card`
--

/*!50001 DROP VIEW IF EXISTS `card`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `card` AS select `payment_type`.`payment_type_id` AS `payment_type_id`,`payment_type`.`bank` AS `bank` from `payment_type` where (`payment_type`.`is_card` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_line_purchase`
--

/*!50001 DROP VIEW IF EXISTS `order_line_purchase`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_line_purchase` AS select `ol`.`order_line_id` AS `order_line_id`,`ol`.`quantity` AS `quantity`,`ol`.`unit_price` AS `unit_price`,`ol`.`wine_id` AS `wine_id`,`ol`.`order_id` AS `order_id` from (`order_line` `ol` join `orders` `o`) where ((`ol`.`order_id` = `o`.`order_id`) and (`o`.`is_purchase` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `order_line_sale`
--

/*!50001 DROP VIEW IF EXISTS `order_line_sale`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `order_line_sale` AS select `ol`.`order_line_id` AS `order_line_id`,`ol`.`quantity` AS `quantity`,`ol`.`unit_price` AS `unit_price`,`ol`.`wine_id` AS `wine_id`,`ol`.`order_id` AS `order_id` from (`order_line` `ol` join `orders` `o`) where ((`ol`.`order_id` = `o`.`order_id`) and (`o`.`is_sale` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `purchase`
--

/*!50001 DROP VIEW IF EXISTS `purchase`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `purchase` AS select `orders`.`order_id` AS `order_id`,`orders`.`order_date` AS `order_date`,`orders`.`order_status` AS `order_status`,`orders`.`expected_delivery_date` AS `expected_delivery_date`,`orders`.`payment_type_id` AS `payment_type_id`,`orders`.`business_entity_id` AS `business_entity_id` from `orders` where (`orders`.`is_purchase` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `redwine`
--

/*!50001 DROP VIEW IF EXISTS `redwine`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `redwine` AS select `wine`.`wine_id` AS `wine_id`,`wine`.`wine_name` AS `wine_name`,`wine`.`country` AS `country`,`wine`.`unit_price` AS `unit_price`,`wine`.`natural_status` AS `natural_status`,`wine`.`fermentation_vessel` AS `fermentation_vessel`,`wine`.`harvest_year` AS `harvest_year`,`wine`.`tannin_level_mg_L` AS `tannin_level_mg_L` from `wine` where (`wine`.`is_redwine` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `sale`
--

/*!50001 DROP VIEW IF EXISTS `sale`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `sale` AS select `orders`.`order_id` AS `order_id`,`orders`.`order_date` AS `order_date`,`orders`.`order_status` AS `order_status`,`orders`.`expected_delivery_date` AS `expected_delivery_date`,`orders`.`payment_type_id` AS `payment_type_id`,`orders`.`business_entity_id` AS `business_entity_id` from `orders` where (`orders`.`is_sale` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `sparklingwine`
--

/*!50001 DROP VIEW IF EXISTS `sparklingwine`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `sparklingwine` AS select `wine`.`wine_id` AS `wine_id`,`wine`.`wine_name` AS `wine_name`,`wine`.`country` AS `country`,`wine`.`unit_price` AS `unit_price`,`wine`.`natural_status` AS `natural_status`,`wine`.`fermentation_vessel` AS `fermentation_vessel`,`wine`.`harvest_year` AS `harvest_year`,`wine`.`carbonation_g_L` AS `carbonation_g_L` from `wine` where (`wine`.`is_sparklingwine` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `whitewine`
--

/*!50001 DROP VIEW IF EXISTS `whitewine`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `whitewine` AS select `wine`.`wine_id` AS `wine_id`,`wine`.`wine_name` AS `wine_name`,`wine`.`country` AS `country`,`wine`.`unit_price` AS `unit_price`,`wine`.`natural_status` AS `natural_status`,`wine`.`fermentation_vessel` AS `fermentation_vessel`,`wine`.`harvest_year` AS `harvest_year`,`wine`.`total_acidity_g_L` AS `total_acidity_g_L`,`wine`.`serving_temperature_C` AS `serving_temperature_C` from `wine` where (`wine`.`is_whitewine` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wire`
--

/*!50001 DROP VIEW IF EXISTS `wire`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`workbench`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `wire` AS select `payment_type`.`payment_type_id` AS `payment_type_id`,`payment_type`.`bank` AS `bank` from `payment_type` where (`payment_type`.`is_wire` = 1) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-25 21:59:12
