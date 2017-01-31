-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: members
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Table structure for table `CERTIFICATION`
--

DROP TABLE IF EXISTS `CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CERTIFICATION` (
  `CertName` varchar(50) NOT NULL,
  `Description` text,
  PRIMARY KEY (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CERTIFICATION`
--

LOCK TABLES `CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `CERTIFICATION` DISABLE KEYS */;
INSERT INTO `CERTIFICATION` VALUES ('Audio Studio Technician',NULL),('Basic Power Tool Safety',NULL),('Soldering',NULL),('Table Saw Safety',NULL),('Welding Safety',NULL);
/*!40000 ALTER TABLE `CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS`
--

DROP TABLE IF EXISTS `CLASS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS` (
  `ClassReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `ClassDate` date DEFAULT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`ClassReferenceNumber`),
  KEY `CourseID` (`CourseID`),
  CONSTRAINT `CLASS_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS`
--

LOCK TABLES `CLASS` WRITE;
/*!40000 ALTER TABLE `CLASS` DISABLE KEYS */;
INSERT INTO `CLASS` VALUES (1,'2017-01-20',1),(2,'2017-01-15',2),(3,'2016-12-15',1),(4,'2017-02-05',1),(5,'2017-01-22',2),(6,'2017-01-28',2),(7,'2017-01-28',3);
/*!40000 ALTER TABLE `CLASS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS_ENROLLMENT`
--

DROP TABLE IF EXISTS `CLASS_ENROLLMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_ENROLLMENT` (
  `MemberID` int(11) NOT NULL,
  `ClassReferenceNumber` int(11) NOT NULL,
  `PaymentReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`ClassReferenceNumber`),
  KEY `ClassReferenceNumber` (`ClassReferenceNumber`),
  KEY `PaymentReferenceNumber` (`PaymentReferenceNumber`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_2` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_ENROLLMENT_ibfk_3` FOREIGN KEY (`PaymentReferenceNumber`) REFERENCES `PAYMENT` (`PaymentReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_ENROLLMENT`
--

LOCK TABLES `CLASS_ENROLLMENT` WRITE;
/*!40000 ALTER TABLE `CLASS_ENROLLMENT` DISABLE KEYS */;
INSERT INTO `CLASS_ENROLLMENT` VALUES (51,4,NULL),(34,1,23),(34,2,24),(34,4,29),(17,4,30),(17,6,40),(17,7,41);
/*!40000 ALTER TABLE `CLASS_ENROLLMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS_TAKEN`
--

DROP TABLE IF EXISTS `CLASS_TAKEN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_TAKEN` (
  `ClassReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`ClassReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `CLASS_TAKEN_ibfk_1` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_TAKEN_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_TAKEN_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_TAKEN`
--

LOCK TABLES `CLASS_TAKEN` WRITE;
/*!40000 ALTER TABLE `CLASS_TAKEN` DISABLE KEYS */;
INSERT INTO `CLASS_TAKEN` VALUES (1,17,10),(2,34,11),(2,51,12),(6,17,77),(7,17,77);
/*!40000 ALTER TABLE `CLASS_TAKEN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CLASS_VOLUNTEER`
--

DROP TABLE IF EXISTS `CLASS_VOLUNTEER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CLASS_VOLUNTEER` (
  `ClassReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`ClassReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_1` FOREIGN KEY (`ClassReferenceNumber`) REFERENCES `CLASS` (`ClassReferenceNumber`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `CLASS_VOLUNTEER_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS_VOLUNTEER`
--

LOCK TABLES `CLASS_VOLUNTEER` WRITE;
/*!40000 ALTER TABLE `CLASS_VOLUNTEER` DISABLE KEYS */;
INSERT INTO `CLASS_VOLUNTEER` VALUES (1,17,5),(1,34,6),(2,51,7),(2,17,8),(5,68,49),(5,34,50),(6,68,72);
/*!40000 ALTER TABLE `CLASS_VOLUNTEER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COURSE`
--

DROP TABLE IF EXISTS `COURSE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(50) NOT NULL,
  `CourseDescription` text,
  `CourseMemberFee` decimal(6,2) DEFAULT NULL,
  `CourseNonMemberFee` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE`
--

LOCK TABLES `COURSE` WRITE;
/*!40000 ALTER TABLE `COURSE` DISABLE KEYS */;
INSERT INTO `COURSE` VALUES (1,'Basic Arduino',NULL,25.00,50.00),(2,'Intro to Linux',NULL,5.00,10.00),(3,'Basic Welding Safety',NULL,20.00,40.00);
/*!40000 ALTER TABLE `COURSE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COURSE_CERTIFICATION`
--

DROP TABLE IF EXISTS `COURSE_CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE_CERTIFICATION` (
  `CourseID` int(11) NOT NULL,
  `CertName` varchar(50) NOT NULL,
  PRIMARY KEY (`CourseID`,`CertName`),
  KEY `CertName` (`CertName`),
  CONSTRAINT `COURSE_CERTIFICATION_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`),
  CONSTRAINT `COURSE_CERTIFICATION_ibfk_2` FOREIGN KEY (`CertName`) REFERENCES `CERTIFICATION` (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE_CERTIFICATION`
--

LOCK TABLES `COURSE_CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `COURSE_CERTIFICATION` DISABLE KEYS */;
INSERT INTO `COURSE_CERTIFICATION` VALUES (3,'Welding Safety');
/*!40000 ALTER TABLE `COURSE_CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT`
--

DROP TABLE IF EXISTS `EVENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT` (
  `EventReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `EventDate` date DEFAULT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` text,
  `EventMemberFee` decimal(6,2) DEFAULT NULL,
  `EventNonMemberFee` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT`
--

LOCK TABLES `EVENT` WRITE;
/*!40000 ALTER TABLE `EVENT` DISABLE KEYS */;
INSERT INTO `EVENT` VALUES (1,'2017-02-01','Cosplay Fest 17',NULL,15.00,30.00),(2,'2017-02-14','My Nerdy Valentine',NULL,10.00,20.00),(3,'2016-12-24','Steampunk Yule Ball',NULL,NULL,NULL),(4,'2017-02-28','Steampunk Maker Faire',NULL,0.00,5.00),(5,'2017-01-22','January Planning Meeting',NULL,0.00,0.00),(6,'2017-01-28','Physics for Electronics Seminar',NULL,10.00,20.00);
/*!40000 ALTER TABLE `EVENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_ATTENDED`
--

DROP TABLE IF EXISTS `EVENT_ATTENDED`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_ATTENDED` (
  `EventReferenceNumber` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_1` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_2` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_ATTENDED_ibfk_3` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_ATTENDED`
--

LOCK TABLES `EVENT_ATTENDED` WRITE;
/*!40000 ALTER TABLE `EVENT_ATTENDED` DISABLE KEYS */;
/*!40000 ALTER TABLE `EVENT_ATTENDED` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_ENROLLMENT`
--

DROP TABLE IF EXISTS `EVENT_ENROLLMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_ENROLLMENT` (
  `MemberID` int(11) NOT NULL,
  `EventReferenceNumber` int(11) NOT NULL,
  `PaymentReferenceNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`EventReferenceNumber`),
  KEY `EventReferenceNumber` (`EventReferenceNumber`),
  KEY `PaymentReferenceNumber` (`PaymentReferenceNumber`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_2` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_ENROLLMENT_ibfk_3` FOREIGN KEY (`PaymentReferenceNumber`) REFERENCES `PAYMENT` (`PaymentReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_ENROLLMENT`
--

LOCK TABLES `EVENT_ENROLLMENT` WRITE;
/*!40000 ALTER TABLE `EVENT_ENROLLMENT` DISABLE KEYS */;
INSERT INTO `EVENT_ENROLLMENT` VALUES (17,3,NULL),(34,2,26),(68,1,31),(34,1,34),(51,4,36),(51,2,38);
/*!40000 ALTER TABLE `EVENT_ENROLLMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EVENT_VOLUNTEER`
--

DROP TABLE IF EXISTS `EVENT_VOLUNTEER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_VOLUNTEER` (
  `MemberID` int(11) NOT NULL,
  `LoginReferenceNumber` int(11) NOT NULL,
  `EventReferenceNumber` int(11) NOT NULL,
  `Role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`MemberID`,`EventReferenceNumber`),
  KEY `LoginReferenceNumber` (`LoginReferenceNumber`),
  KEY `EventReferenceNumber` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_2` FOREIGN KEY (`LoginReferenceNumber`) REFERENCES `LOGIN` (`LoginReferenceNumber`),
  CONSTRAINT `EVENT_VOLUNTEER_ibfk_3` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_VOLUNTEER`
--

LOCK TABLES `EVENT_VOLUNTEER` WRITE;
/*!40000 ALTER TABLE `EVENT_VOLUNTEER` DISABLE KEYS */;
INSERT INTO `EVENT_VOLUNTEER` VALUES (17,1,1,NULL),(34,9,1,NULL),(34,3,2,NULL),(34,50,5,NULL),(51,2,1,NULL),(51,4,2,NULL),(68,49,5,NULL),(68,72,6,NULL);
/*!40000 ALTER TABLE `EVENT_VOLUNTEER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LOGIN`
--

DROP TABLE IF EXISTS `LOGIN`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LOGIN` (
  `LoginReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `MemberID` int(11) NOT NULL,
  `LoginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LogoutTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`LoginReferenceNumber`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `LOGIN_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LOGIN`
--

LOCK TABLES `LOGIN` WRITE;
/*!40000 ALTER TABLE `LOGIN` DISABLE KEYS */;
INSERT INTO `LOGIN` VALUES (1,17,'2017-01-09 21:22:22','2017-01-09 21:28:22'),(2,51,'2017-01-09 21:22:28','2017-01-09 21:24:02'),(3,34,'2017-01-09 21:22:38','2017-01-09 21:28:31'),(4,51,'2017-01-09 21:24:42','2017-01-09 21:25:06'),(5,17,'2017-01-10 00:48:14','0000-00-00 00:00:00'),(6,34,'2017-01-10 00:48:31','0000-00-00 00:00:00'),(7,51,'2017-01-10 18:28:08','0000-00-00 00:00:00'),(8,17,'2017-01-10 18:28:18','0000-00-00 00:00:00'),(9,34,'2017-01-10 19:55:58','0000-00-00 00:00:00'),(10,17,'2017-01-10 21:20:06','0000-00-00 00:00:00'),(11,34,'2017-01-10 21:20:13','0000-00-00 00:00:00'),(12,51,'2017-01-10 21:20:19','0000-00-00 00:00:00'),(13,17,'2017-01-10 21:50:59','0000-00-00 00:00:00'),(14,17,'2017-01-11 05:28:24','0000-00-00 00:00:00'),(15,34,'2017-01-11 05:28:36','0000-00-00 00:00:00'),(16,51,'2017-01-11 05:28:43','0000-00-00 00:00:00'),(17,51,'2017-01-11 18:33:40','0000-00-00 00:00:00'),(18,17,'2017-01-11 20:05:57','2017-01-11 20:08:32'),(20,68,'2017-01-12 00:19:35','2017-01-12 03:13:52'),(21,17,'2017-01-12 19:18:26','2017-01-12 20:58:30'),(22,34,'2017-01-12 19:18:44','2017-01-12 20:58:35'),(23,17,'2017-01-14 05:22:02','0000-00-00 00:00:00'),(24,17,'2017-01-14 18:52:01','0000-00-00 00:00:00'),(25,34,'2017-01-14 20:57:08','0000-00-00 00:00:00'),(26,51,'2017-01-14 21:22:17','0000-00-00 00:00:00'),(27,34,'2017-01-14 21:33:03','0000-00-00 00:00:00'),(28,17,'2017-01-14 21:37:04','2017-01-14 21:37:32'),(29,34,'2017-01-14 22:25:42','0000-00-00 00:00:00'),(30,17,'2017-01-14 23:31:26','0000-00-00 00:00:00'),(31,51,'2017-01-15 00:23:55','0000-00-00 00:00:00'),(32,17,'2017-01-15 00:30:07','0000-00-00 00:00:00'),(33,51,'2017-01-15 02:42:36','0000-00-00 00:00:00'),(34,17,'2017-01-15 02:56:26','0000-00-00 00:00:00'),(35,34,'2017-01-15 19:53:00','0000-00-00 00:00:00'),(36,17,'2017-01-15 20:01:23','0000-00-00 00:00:00'),(37,51,'2017-01-15 20:01:54','0000-00-00 00:00:00'),(38,34,'2017-01-15 21:17:16','0000-00-00 00:00:00'),(39,34,'2017-01-15 22:29:44','0000-00-00 00:00:00'),(40,17,'2017-01-16 06:40:35','0000-00-00 00:00:00'),(41,17,'2017-01-22 18:51:23','0000-00-00 00:00:00'),(42,17,'2017-01-22 21:36:50','0000-00-00 00:00:00'),(43,51,'2017-01-22 21:38:06','0000-00-00 00:00:00'),(44,51,'2017-01-22 22:13:07','0000-00-00 00:00:00'),(45,17,'2017-01-22 22:49:43','0000-00-00 00:00:00'),(46,34,'2017-01-22 22:49:47','0000-00-00 00:00:00'),(47,68,'2017-01-22 22:50:49','0000-00-00 00:00:00'),(48,17,'2017-01-23 01:08:16','0000-00-00 00:00:00'),(49,68,'2017-01-23 05:58:46','0000-00-00 00:00:00'),(50,34,'2017-01-23 07:05:35','0000-00-00 00:00:00'),(51,17,'2017-01-23 07:06:45','0000-00-00 00:00:00'),(52,51,'2017-01-23 18:46:38','0000-00-00 00:00:00'),(53,51,'2017-01-23 18:46:45','0000-00-00 00:00:00'),(54,51,'2017-01-23 18:46:52','0000-00-00 00:00:00'),(55,51,'2017-01-23 18:46:56','2017-01-23 18:47:27'),(56,51,'2017-01-23 18:48:41','2017-01-23 18:48:46'),(57,34,'2017-01-23 18:49:44','0000-00-00 00:00:00'),(58,17,'2017-01-23 18:52:07','2017-01-23 18:53:31'),(59,17,'2017-01-23 19:38:10','2017-01-23 19:43:31'),(60,34,'2017-01-23 19:38:18','2017-01-23 19:43:21'),(61,51,'2017-01-23 19:38:21','2017-01-23 19:43:34'),(62,68,'2017-01-23 19:38:25','2017-01-23 19:43:27'),(63,34,'2017-01-23 19:46:24','0000-00-00 00:00:00'),(64,17,'2017-01-23 19:47:49','2017-01-23 19:49:10'),(65,68,'2017-01-23 19:50:02','0000-00-00 00:00:00'),(66,17,'2017-01-27 20:13:10','2017-01-27 20:13:33'),(67,17,'2017-01-27 21:03:40','2017-01-27 21:03:52'),(68,17,'2017-01-27 21:12:07','2017-01-27 21:12:13'),(69,17,'2017-01-27 21:30:18','2017-01-27 21:30:37'),(70,68,'2017-01-27 21:43:16','0000-00-00 00:00:00'),(71,51,'2017-01-28 02:53:56','0000-00-00 00:00:00'),(72,68,'2017-01-28 20:27:50','2017-01-28 20:29:35'),(73,68,'2017-01-28 21:58:07','0000-00-00 00:00:00'),(74,17,'2017-01-28 22:36:13','0000-00-00 00:00:00'),(75,34,'2017-01-29 02:43:13','2017-01-29 07:08:29'),(76,51,'2017-01-29 02:43:18','2017-01-29 07:08:24'),(77,17,'2017-01-29 05:57:55','2017-01-29 07:08:14'),(78,0,'2017-01-29 07:08:43','2017-01-29 07:08:49');
/*!40000 ALTER TABLE `LOGIN` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEMBER`
--

DROP TABLE IF EXISTS `MEMBER`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBER` (
  `MemberID` int(11) NOT NULL,
  `FirstName` varchar(30) DEFAULT NULL,
  `LastName` varchar(30) DEFAULT NULL,
  `BirthDate` date DEFAULT NULL,
  `JoinDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StreetAddress` varchar(50) DEFAULT NULL,
  `City` varchar(20) DEFAULT NULL,
  `State` varchar(20) DEFAULT NULL,
  `Zip` varchar(15) DEFAULT NULL,
  `HomePhone` char(12) DEFAULT NULL,
  `CellPhone` char(12) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `EmergencyContact` varchar(100) DEFAULT NULL,
  `ReferredBy` int(11) DEFAULT NULL,
  `Picture` varchar(100) DEFAULT NULL,
  `MembershipType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`MemberID`),
  UNIQUE KEY `MemberID` (`MemberID`),
  KEY `ReferredBy` (`ReferredBy`),
  CONSTRAINT `MEMBER_ibfk_1` FOREIGN KEY (`ReferredBy`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEMBER`
--

LOCK TABLES `MEMBER` WRITE;
/*!40000 ALTER TABLE `MEMBER` DISABLE KEYS */;
INSERT INTO `MEMBER` VALUES (0,'Nemo','Nemo',NULL,'2017-01-11 19:47:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),(17,'Bob','Smith','2000-01-01','2017-01-05 21:13:36','123 Main St','San Diego','Ca','92027','6195551212','6195551313','bob@bobcorp.com','Lisa Smith 6195551313',0,'images/17.jpg','Non-Member'),(34,'Sue','Smith','1980-01-01','2017-01-05 21:15:40','55 abc','San Diego','Ca','92023','6195550123','6195550145','sue@earthlink.net','Joe Jones 6195553131',0,'images/34.jpg','Standard'),(51,'John','Jones','1975-01-01','2017-01-05 21:18:33','55 abc','San Diego','Ca','92023','6195553456','6195556789','John@yahoo.com','Sue Smith 6195550123',34,'images/51.jpeg','Voting'),(68,'James','Madison','1960-01-01','2017-01-11 20:23:25','255 First St.','La Mesa','CA','92025','6195553333','6195554444','jim@history.gov','Dolly Madison 6195555555',0,'images/68.jpg','Voting');
/*!40000 ALTER TABLE `MEMBER` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `MEMBER_CERTIFICATION`
--

DROP TABLE IF EXISTS `MEMBER_CERTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MEMBER_CERTIFICATION` (
  `MemberID` int(11) NOT NULL,
  `CertName` varchar(50) NOT NULL,
  PRIMARY KEY (`MemberID`,`CertName`),
  KEY `CertName` (`CertName`),
  CONSTRAINT `MEMBER_CERTIFICATION_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`),
  CONSTRAINT `MEMBER_CERTIFICATION_ibfk_2` FOREIGN KEY (`CertName`) REFERENCES `CERTIFICATION` (`CertName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MEMBER_CERTIFICATION`
--

LOCK TABLES `MEMBER_CERTIFICATION` WRITE;
/*!40000 ALTER TABLE `MEMBER_CERTIFICATION` DISABLE KEYS */;
INSERT INTO `MEMBER_CERTIFICATION` VALUES (17,'Audio Studio Technician'),(51,'Basic Power Tool Safety'),(17,'Soldering'),(34,'Table Saw Safety'),(51,'Table Saw Safety'),(17,'Welding Safety'),(51,'Welding Safety'),(68,'Welding Safety');
/*!40000 ALTER TABLE `MEMBER_CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `MEMBER_CLASS_HISTORY`
--

DROP TABLE IF EXISTS `MEMBER_CLASS_HISTORY`;
/*!50001 DROP VIEW IF EXISTS `MEMBER_CLASS_HISTORY`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `MEMBER_CLASS_HISTORY` (
  `MemberID` tinyint NOT NULL,
  `CourseName` tinyint NOT NULL,
  `ClassDate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `NOTES`
--

DROP TABLE IF EXISTS `NOTES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NOTES` (
  `NoteTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MemberID` int(11) NOT NULL,
  `NoteText` text,
  PRIMARY KEY (`NoteTime`,`MemberID`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `NOTES_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `NOTES`
--

LOCK TABLES `NOTES` WRITE;
/*!40000 ALTER TABLE `NOTES` DISABLE KEYS */;
INSERT INTO `NOTES` VALUES ('2017-01-11 19:02:19',51,'This is a test note.'),('2017-01-12 01:51:27',68,'This is another test note.'),('2017-01-15 19:55:34',34,'Testing the note entry system.  Yet again.'),('2017-01-15 20:01:45',17,'Does this note suffer from the same anomaly seen before?'),('2017-01-15 20:07:52',51,'Second test note to test stacking'),('2017-01-15 20:08:10',51,'Third test note to test window expansion'),('2017-01-16 06:40:56',17,'regarding payment 28: Repayment for broken saw blade'),('2017-01-23 18:54:15',51,'Left safety glasses by table saw.  They are being held in the lost and found.'),('2017-01-23 19:49:35',17,'Left safety glasses by table saw.  They are waiting for him in lost and found.'),('2017-01-27 21:34:47',17,'Test to see if the note entry system is broken.');
/*!40000 ALTER TABLE `NOTES` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PAYMENT`
--

DROP TABLE IF EXISTS `PAYMENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PAYMENT` (
  `PaymentReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `PaymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MemberID` int(11) NOT NULL,
  `Amount` decimal(8,2) NOT NULL,
  `Reason` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PaymentReferenceNumber`),
  KEY `MemberID` (`MemberID`),
  CONSTRAINT `PAYMENT_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `MEMBER` (`MemberID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PAYMENT`
--

LOCK TABLES `PAYMENT` WRITE;
/*!40000 ALTER TABLE `PAYMENT` DISABLE KEYS */;
INSERT INTO `PAYMENT` VALUES (1,'2017-01-11 05:33:05',17,20.00,NULL),(3,'2017-01-11 19:01:57',51,50.00,NULL),(4,'2017-01-12 19:57:09',17,30.00,NULL),(5,'2017-01-15 02:44:01',51,25.00,''),(6,'2017-01-15 02:46:30',51,15.00,'event'),(7,'2017-01-15 02:47:22',51,5.00,'class'),(8,'2017-01-15 02:47:48',51,30.00,''),(9,'2017-01-15 02:54:07',51,25.00,'class'),(10,'2017-01-15 02:54:24',51,10.00,'event'),(11,'2017-01-15 02:54:40',51,30.00,'dues'),(12,'2017-01-15 02:54:55',51,300.00,'donation'),(13,'2017-01-15 02:55:27',51,27.00,'merchandise'),(14,'2017-01-15 02:56:07',51,22.00,'other'),(15,'2017-01-15 02:56:38',17,20.00,'event'),(16,'2017-01-15 03:01:44',17,32.00,'other'),(17,'2017-01-15 03:09:19',17,27.50,'merchandise'),(23,'2017-01-15 22:57:15',34,25.00,'class'),(24,'2017-01-16 06:20:17',34,5.00,'class'),(25,'2017-01-16 06:21:28',34,10.00,'event'),(26,'2017-01-16 06:22:48',34,10.00,'event'),(27,'2017-01-16 06:26:14',34,40.00,'dues'),(28,'2017-01-16 06:40:56',17,52.80,'other'),(29,'2017-01-23 18:51:13',34,25.00,'class'),(30,'2017-01-23 18:52:23',17,50.00,'class'),(31,'2017-01-23 19:38:38',68,15.00,'event'),(32,'2017-01-23 19:47:36',34,25.00,'class'),(33,'2017-01-23 19:48:03',17,50.00,'class'),(34,'2017-01-23 19:48:22',34,15.00,'event'),(35,'2017-01-28 03:02:12',51,0.00,'event'),(36,'2017-01-28 03:08:39',51,0.00,'event'),(37,'2017-01-28 03:16:52',51,40.00,'dues'),(38,'2017-01-28 03:17:05',51,10.00,'event'),(39,'2017-01-28 04:02:59',51,-10.00,'event'),(40,'2017-01-29 05:59:51',17,10.00,'class'),(41,'2017-01-29 06:45:48',17,40.00,'class');
/*!40000 ALTER TABLE `PAYMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `PENDING_ALL`
--

DROP TABLE IF EXISTS `PENDING_ALL`;
/*!50001 DROP VIEW IF EXISTS `PENDING_ALL`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_ALL` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_CLASSES`
--

DROP TABLE IF EXISTS `PENDING_CLASSES`;
/*!50001 DROP VIEW IF EXISTS `PENDING_CLASSES`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_CLASSES` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_ENROLLMENTS`
--

DROP TABLE IF EXISTS `PENDING_ENROLLMENTS`;
/*!50001 DROP VIEW IF EXISTS `PENDING_ENROLLMENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_ENROLLMENTS` (
  `MemberID` tinyint NOT NULL,
  `ReferenceNumber` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `PENDING_EVENTS`
--

DROP TABLE IF EXISTS `PENDING_EVENTS`;
/*!50001 DROP VIEW IF EXISTS `PENDING_EVENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PENDING_EVENTS` (
  `ReferenceNumber` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `MemberFee` tinyint NOT NULL,
  `NonMemberFee` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `VOLUNTEER_HISTORY`
--

DROP TABLE IF EXISTS `VOLUNTEER_HISTORY`;
/*!50001 DROP VIEW IF EXISTS `VOLUNTEER_HISTORY`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `VOLUNTEER_HISTORY` (
  `MemberID` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `Name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `MEMBER_CLASS_HISTORY`
--

/*!50001 DROP TABLE IF EXISTS `MEMBER_CLASS_HISTORY`*/;
/*!50001 DROP VIEW IF EXISTS `MEMBER_CLASS_HISTORY`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `MEMBER_CLASS_HISTORY` AS select `A`.`MemberID` AS `MemberID`,`B`.`CourseName` AS `CourseName`,`C`.`ClassDate` AS `ClassDate` from ((`CLASS_TAKEN` `A` join `COURSE` `B`) join `CLASS` `C`) where ((`A`.`ClassReferenceNumber` = `C`.`ClassReferenceNumber`) and (`C`.`CourseID` = `B`.`CourseID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_ALL`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_ALL`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_ALL`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_ALL` AS select `PENDING_CLASSES`.`ReferenceNumber` AS `ReferenceNumber`,`PENDING_CLASSES`.`Date` AS `Date`,`PENDING_CLASSES`.`Name` AS `Name`,`PENDING_CLASSES`.`MemberFee` AS `MemberFee`,`PENDING_CLASSES`.`NonMemberFee` AS `NonMemberFee`,'CLASS' AS `Type` from `PENDING_CLASSES` union select `PENDING_EVENTS`.`ReferenceNumber` AS `ReferenceNumber`,`PENDING_EVENTS`.`Date` AS `Date`,`PENDING_EVENTS`.`Name` AS `Name`,`PENDING_EVENTS`.`MemberFee` AS `MemberFee`,`PENDING_EVENTS`.`NonMemberFee` AS `NonMemberFee`,'EVENT' AS `Type` from `PENDING_EVENTS` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_CLASSES`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_CLASSES`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_CLASSES`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_CLASSES` AS select `A`.`ClassReferenceNumber` AS `ReferenceNumber`,`A`.`ClassDate` AS `Date`,`B`.`CourseName` AS `Name`,`B`.`CourseMemberFee` AS `MemberFee`,`B`.`CourseNonMemberFee` AS `NonMemberFee` from (`CLASS` `A` join `COURSE` `B`) where ((`A`.`CourseID` = `B`.`CourseID`) and (`A`.`ClassDate` >= curdate())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_ENROLLMENTS`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_ENROLLMENTS`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_ENROLLMENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_ENROLLMENTS` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassReferenceNumber` AS `ReferenceNumber`,`C`.`CourseName` AS `Name`,`B`.`ClassDate` AS `Date`,'CLASS' AS `Type` from ((`CLASS_ENROLLMENT` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`) and (`B`.`ClassDate` >= curdate())) union select `A`.`MemberID` AS `MemberID`,`B`.`EventReferenceNumber` AS `ReferenceNumber`,`B`.`EventName` AS `Name`,`B`.`EventDate` AS `Date`,'EVENT' AS `Type` from (`EVENT_ENROLLMENT` `A` join `EVENT` `B`) where ((`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) and (`B`.`EventDate` >= curdate())) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `PENDING_EVENTS`
--

/*!50001 DROP TABLE IF EXISTS `PENDING_EVENTS`*/;
/*!50001 DROP VIEW IF EXISTS `PENDING_EVENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PENDING_EVENTS` AS select `EVENT`.`EventReferenceNumber` AS `ReferenceNumber`,`EVENT`.`EventDate` AS `Date`,`EVENT`.`EventName` AS `Name`,`EVENT`.`EventMemberFee` AS `MemberFee`,`EVENT`.`EventNonMemberFee` AS `NonMemberFee` from `EVENT` where (`EVENT`.`EventDate` >= curdate()) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `VOLUNTEER_HISTORY`
--

/*!50001 DROP TABLE IF EXISTS `VOLUNTEER_HISTORY`*/;
/*!50001 DROP VIEW IF EXISTS `VOLUNTEER_HISTORY`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `VOLUNTEER_HISTORY` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassDate` AS `Date`,`C`.`CourseName` AS `Name` from ((`CLASS_VOLUNTEER` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`)) union select `A`.`MemberID` AS `MemberID`,`B`.`EventDate` AS `Date`,`B`.`EventName` AS `Name` from (`EVENT_VOLUNTEER` `A` join `EVENT` `B`) where (`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) */;
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

-- Dump completed on 2017-01-31 15:18:03
