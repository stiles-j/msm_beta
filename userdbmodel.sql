-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: users
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Current Database: `users`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `users` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `users`;

--
-- Table structure for table `ClassesTaken`
--

DROP TABLE IF EXISTS `ClassesTaken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ClassesTaken` (
  `MemberNumber` decimal(9,3) NOT NULL,
  `ClassName` text,
  `DateTaken` date DEFAULT NULL,
  KEY `MemberNumber` (`MemberNumber`),
  KEY `DateTaken` (`DateTaken`),
  FULLTEXT KEY `ClassName` (`ClassName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ClassesTaken`
--

LOCK TABLES `ClassesTaken` WRITE;
/*!40000 ALTER TABLE `ClassesTaken` DISABLE KEYS */;
INSERT INTO `ClassesTaken` VALUES (12.000,'Basic Woodworking Safety','2016-01-12'),(12.000,'Basic Skirt Making','2016-01-09'),(14.000,'Basic Tool Safety','2016-05-01'),(14.000,'Basic Arduino','2016-05-15'),(14.000,'Basic Soldering','2016-05-01'),(14.000,'Basic Woodworking','2016-04-15'),(12.000,'Basic Soldering','2016-05-15'),(11.000,'Basic Electrionics','2016-08-11'),(15.000,'Basic Woodworking Safety','2016-08-11');
/*!40000 ALTER TABLE `ClassesTaken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DonationHistory`
--

DROP TABLE IF EXISTS `DonationHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DonationHistory` (
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Amount` decimal(9,2) DEFAULT NULL,
  `MemberNumber` decimal(9,3) NOT NULL,
  KEY `MemberNumber` (`MemberNumber`),
  KEY `Date` (`Date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DonationHistory`
--

LOCK TABLES `DonationHistory` WRITE;
/*!40000 ALTER TABLE `DonationHistory` DISABLE KEYS */;
INSERT INTO `DonationHistory` VALUES ('2016-01-10 08:00:00',20.00,12.000),('2016-05-15 07:00:00',25.00,14.000),('2016-05-16 00:00:43',28.00,12.000),('2016-05-15 23:58:58',15.00,12.000),('2016-05-15 23:57:56',7.00,12.000),('2016-05-15 23:57:01',25.00,12.000),('2016-05-15 23:48:50',15.00,12.000),('2016-05-15 23:53:51',50.00,12.000),('2016-05-16 00:06:28',50.00,13.000),('2016-05-16 02:09:28',25.00,12.000),('2016-05-16 04:25:26',30.00,12.000),('2016-08-11 21:08:05',50.00,11.000),('2016-08-11 21:14:37',50.00,14.000),('2016-08-11 21:16:00',100.00,15.000);
/*!40000 ALTER TABLE `DonationHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LoginHistory`
--

DROP TABLE IF EXISTS `LoginHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LoginHistory` (
  `LoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MemberNumber` decimal(9,3) NOT NULL,
  `LogoutTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`LoginTime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LoginHistory`
--

LOCK TABLES `LoginHistory` WRITE;
/*!40000 ALTER TABLE `LoginHistory` DISABLE KEYS */;
INSERT INTO `LoginHistory` VALUES ('2016-05-13 22:39:52',11.000,'2016-08-11 21:17:45'),('2016-05-13 23:16:15',12.000,'2016-08-11 21:14:02'),('2016-05-13 23:16:52',13.000,'2016-06-07 18:18:06'),('2016-05-15 00:00:03',12.000,'0000-00-00 00:00:00'),('2016-05-14 04:22:43',11.000,'0000-00-00 00:00:00'),('2016-05-14 04:22:57',12.000,'0000-00-00 00:00:00'),('2016-05-15 00:47:01',12.000,'0000-00-00 00:00:00'),('2016-05-15 00:47:09',13.000,'0000-00-00 00:00:00'),('2016-05-15 04:17:00',14.000,'2016-08-11 21:18:15'),('2016-05-15 18:48:06',12.000,'0000-00-00 00:00:00'),('2016-05-15 21:14:11',12.000,'0000-00-00 00:00:00'),('2016-05-15 22:36:17',11.000,'0000-00-00 00:00:00'),('2016-05-15 23:55:52',13.000,'0000-00-00 00:00:00'),('2016-05-16 02:09:18',12.000,'0000-00-00 00:00:00'),('2016-05-16 04:13:14',14.000,'0000-00-00 00:00:00'),('2016-05-16 04:21:19',12.000,'0000-00-00 00:00:00'),('2016-05-16 17:55:49',14.000,'0000-00-00 00:00:00'),('2016-05-16 18:48:29',14.000,'0000-00-00 00:00:00'),('2016-05-16 22:14:50',12.000,'0000-00-00 00:00:00'),('2016-05-16 22:57:32',14.000,'0000-00-00 00:00:00'),('2016-05-17 01:02:44',14.000,'0000-00-00 00:00:00'),('2016-06-07 18:12:45',14.000,'0000-00-00 00:00:00'),('2016-06-07 18:12:52',12.000,'0000-00-00 00:00:00'),('2016-06-07 18:12:56',11.000,'0000-00-00 00:00:00'),('2016-06-07 18:12:59',13.000,'0000-00-00 00:00:00'),('2016-06-07 18:17:37',14.000,'0000-00-00 00:00:00'),('2016-06-07 18:17:54',11.000,'0000-00-00 00:00:00'),('2016-06-07 18:17:58',13.000,'0000-00-00 00:00:00'),('2016-06-07 18:18:00',12.000,'0000-00-00 00:00:00'),('2016-08-11 21:07:26',12.000,'0000-00-00 00:00:00'),('2016-08-11 21:07:44',11.000,'0000-00-00 00:00:00'),('2016-08-11 21:08:16',14.000,'0000-00-00 00:00:00'),('2016-08-11 21:13:22',11.000,'0000-00-00 00:00:00'),('2016-08-11 21:13:30',12.000,'0000-00-00 00:00:00'),('2016-08-11 21:13:39',14.000,'0000-00-00 00:00:00'),('2016-08-11 21:16:09',15.000,'2016-08-11 21:16:43');
/*!40000 ALTER TABLE `LoginHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ManagerNotes`
--

DROP TABLE IF EXISTS `ManagerNotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ManagerNotes` (
  `NoteTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Note` text,
  `MemberNumber` decimal(9,3) NOT NULL,
  KEY `MemberNumber` (`MemberNumber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ManagerNotes`
--

LOCK TABLES `ManagerNotes` WRITE;
/*!40000 ALTER TABLE `ManagerNotes` DISABLE KEYS */;
INSERT INTO `ManagerNotes` VALUES ('2016-01-12 02:00:00','Stayed late to help clean up space after show',12.000),('2016-05-09 17:21:38','Helped clean up after soldering class',11.000),('2016-05-09 21:30:26','Training to teach soldering class',11.000),('2016-05-16 04:14:42','Building SpaceManager system as a donation to the Creator Space',14.000),('2016-05-10 04:52:55','Taught soldering class',11.000),('2016-05-16 04:26:14','Joined planning committee for fall cosplay party',12.000),('2016-08-11 21:09:38','Left glasses in textile area on last visit',12.000),('2016-08-11 21:14:23','Stayed late to clean up space',12.000),('2016-08-11 21:17:27','Left safety glasses behind.  Put in lost and found until he picks up.',15.000);
/*!40000 ALTER TABLE `ManagerNotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Profile`
--

DROP TABLE IF EXISTS `Profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Profile` (
  `Waiver` mediumblob,
  `FirstName` varchar(20) DEFAULT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `JoinDate` date DEFAULT NULL,
  `Address` text,
  `HomePhone` varchar(20) DEFAULT NULL,
  `CellPhone` varchar(20) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `EmergencyContact` text,
  `MedicalProvider` text,
  `ReferredBy` varchar(40) DEFAULT NULL,
  `MemberReferrals` text,
  `MemberNumber` decimal(9,3) NOT NULL,
  `Picture` text,
  `Level` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`MemberNumber`),
  KEY `MemberNumber` (`MemberNumber`),
  KEY `FirstName` (`FirstName`),
  KEY `LastName` (`LastName`),
  KEY `Level` (`Level`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Profile`
--

LOCK TABLES `Profile` WRITE;
/*!40000 ALTER TABLE `Profile` DISABLE KEYS */;
INSERT INTO `Profile` VALUES (NULL,'John','Doe','1950-05-05','2016-01-10','123 Sessame St, Murrieta, Ca 92563','951-555-1111','951-555-2222','john@yahoo.com','Jan Doe, 951-555-1234',NULL,NULL,NULL,11.000,NULL,'Gold'),(NULL,'Tessa','Smith','2000-05-05','2016-01-09','123 Sessame St, Murrieta, Ca 92563','951-555-3333','951-555-4444','tessa@gmail.com','Mary Smith, 951-555-5678',NULL,NULL,NULL,12.000,'images/tessa.jpg','Standard'),(NULL,'Justice','Stiles','1975-10-30','2016-05-13','29820 Circinus St','9518133469','9518169300','jsgrimheart@gmail.com','Kristin Stiles 858-229-0903','','Tessa Smith',NULL,14.000,'images/14.000.png','Gold'),(NULL,'John','Doe','1985-05-01','2016-08-11','123 Main St','619-555-1212','951-555-2232','johnD@gmail.com','Jane Doe','','Tessa Smith',NULL,15.000,'images/15.jpg','Silver'),(NULL,'Larry','Lamma','1963-07-14','2016-01-05','129 Plain Rd, Temecula, Ca 92554','951-555-5555','951-555-6666','larry@rocketmail.com','June Ward, 951-555-9012',NULL,NULL,NULL,13.000,NULL,'Silver');
/*!40000 ALTER TABLE `Profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ResourcesUsed`
--

DROP TABLE IF EXISTS `ResourcesUsed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ResourcesUsed` (
  `MemberNumber` decimal(9,3) NOT NULL DEFAULT '0.000',
  `Resources` text,
  KEY `Resources` (`Resources`(40)),
  KEY `MemberNumber` (`MemberNumber`),
  FULLTEXT KEY `Resources_2` (`Resources`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ResourcesUsed`
--

LOCK TABLES `ResourcesUsed` WRITE;
/*!40000 ALTER TABLE `ResourcesUsed` DISABLE KEYS */;
/*!40000 ALTER TABLE `ResourcesUsed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SafetyCerts`
--

DROP TABLE IF EXISTS `SafetyCerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SafetyCerts` (
  `MemberNumber` decimal(9,3) NOT NULL DEFAULT '0.000',
  `CertName` text,
  `DateReceived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `MemberNumber` (`MemberNumber`),
  KEY `DateReceived` (`DateReceived`),
  FULLTEXT KEY `CertName` (`CertName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SafetyCerts`
--

LOCK TABLES `SafetyCerts` WRITE;
/*!40000 ALTER TABLE `SafetyCerts` DISABLE KEYS */;
INSERT INTO `SafetyCerts` VALUES (12.000,'Table Saw','2016-01-05 08:00:00'),(14.000,'Soldering','2016-05-16 23:02:25'),(15.000,'All Woodworking Equipment','2016-08-11 21:16:22');
/*!40000 ALTER TABLE `SafetyCerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VolunteeringHistory`
--

DROP TABLE IF EXISTS `VolunteeringHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `VolunteeringHistory` (
  `EventDate` date DEFAULT NULL,
  `Event` text,
  `MemberNumber` decimal(9,3) NOT NULL,
  KEY `MemberNumber` (`MemberNumber`),
  KEY `EventDate` (`EventDate`),
  FULLTEXT KEY `Event` (`Event`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VolunteeringHistory`
--

LOCK TABLES `VolunteeringHistory` WRITE;
/*!40000 ALTER TABLE `VolunteeringHistory` DISABLE KEYS */;
INSERT INTO `VolunteeringHistory` VALUES ('2016-01-11','Cosplay Show',12.000),('2016-05-16','Taught Basic PHP class',14.000),('2016-01-05','Worked Cosplay show',14.000);
/*!40000 ALTER TABLE `VolunteeringHistory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-20 13:56:58
