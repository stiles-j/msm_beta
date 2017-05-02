-- MySQL dump 10.13  Distrib 5.5.55, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: members
-- ------------------------------------------------------
-- Server version	5.5.55-0ubuntu0.14.04.1

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
-- Temporary table structure for view `ALL_ENROLLMENTS`
--

DROP TABLE IF EXISTS `ALL_ENROLLMENTS`;
/*!50001 DROP VIEW IF EXISTS `ALL_ENROLLMENTS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `ALL_ENROLLMENTS` (
  `MemberID` tinyint NOT NULL,
  `ReferenceNumber` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `Date` tinyint NOT NULL,
  `PaymentReferenceNumber` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
INSERT INTO `CERTIFICATION` VALUES ('Audio Studio Technician','Can Use Recording Studio'),('Basic Power Tool Safety',NULL),('Blacksmith','NULL'),('Metal Casting',NULL),('Soldering',NULL),('Table Saw Safety',NULL),('Welding Safety',NULL);
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
  `ClassDate` datetime DEFAULT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`ClassReferenceNumber`),
  KEY `CourseID` (`CourseID`),
  CONSTRAINT `CLASS_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CLASS`
--

LOCK TABLES `CLASS` WRITE;
/*!40000 ALTER TABLE `CLASS` DISABLE KEYS */;
INSERT INTO `CLASS` VALUES (1,'2017-01-20 00:00:00',1),(2,'2017-01-15 00:00:00',2),(3,'2016-12-15 00:00:00',1),(4,'2017-02-05 00:00:00',1),(5,'2017-01-22 00:00:00',2),(6,'2017-01-28 00:00:00',2),(7,'2017-01-28 00:00:00',3),(8,'2017-02-04 00:00:00',3),(9,'2017-02-15 00:00:00',3),(11,'2017-02-19 00:00:00',1),(12,'2017-03-04 00:00:00',2),(13,'2017-02-18 19:00:00',1),(14,'2017-03-06 17:00:00',10),(20,'2017-03-15 18:00:00',2),(21,'2017-04-15 18:30:00',13),(23,'2017-04-10 18:00:00',10),(34,'2017-04-10 15:30:00',10);
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
INSERT INTO `CLASS_ENROLLMENT` VALUES (51,4,NULL),(34,1,23),(34,2,24),(34,4,29),(17,4,30),(17,6,40),(17,7,41),(34,8,42),(17,9,43),(34,13,47);
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
INSERT INTO `CLASS_TAKEN` VALUES (1,17,10),(2,34,11),(2,51,12),(6,17,77),(7,17,77),(4,51,80),(4,34,81),(8,34,81),(4,17,82),(9,17,87);
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
INSERT INTO `CLASS_VOLUNTEER` VALUES (1,17,5),(1,34,6),(2,51,7),(2,17,8),(5,68,49),(5,34,50),(6,68,72),(4,17,82),(9,17,87);
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
  `Duration` time DEFAULT NULL,
  PRIMARY KEY (`CourseID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE`
--

LOCK TABLES `COURSE` WRITE;
/*!40000 ALTER TABLE `COURSE` DISABLE KEYS */;
INSERT INTO `COURSE` VALUES (1,'Basic Arduino','',15.00,30.00,'02:00:00'),(2,'Intro to Linux','',0.00,5.00,'02:30:00'),(3,'Basic Welding Safety',NULL,20.00,40.00,'03:30:00'),(10,'Basic Soldering','Allows access to the soldering equipment',5.00,10.00,'02:00:00'),(11,'Metalworking Master Class','The big one',50.00,100.00,'08:00:00'),(12,'Classical Flamenco Guitar','',50.00,100.00,'01:00:00'),(13,'Intermediate Arduino','',15.00,30.00,'02:30:00'),(14,'Basic Woodworking ','Basic cuts, joints, and safety',25.00,50.00,'05:00:00');
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
INSERT INTO `COURSE_CERTIFICATION` VALUES (11,'Blacksmith'),(11,'Metal Casting'),(10,'Soldering'),(14,'Table Saw Safety'),(3,'Welding Safety'),(11,'Welding Safety');
/*!40000 ALTER TABLE `COURSE_CERTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `COURSE_FACILITY`
--

DROP TABLE IF EXISTS `COURSE_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `COURSE_FACILITY` (
  `CourseID` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  PRIMARY KEY (`CourseID`,`FacilityID`),
  KEY `FacilityID` (`FacilityID`),
  CONSTRAINT `COURSE_FACILITY_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `COURSE` (`CourseID`),
  CONSTRAINT `COURSE_FACILITY_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `COURSE_FACILITY`
--

LOCK TABLES `COURSE_FACILITY` WRITE;
/*!40000 ALTER TABLE `COURSE_FACILITY` DISABLE KEYS */;
INSERT INTO `COURSE_FACILITY` VALUES (14,1),(2,5),(10,11),(10,12),(10,13),(10,14);
/*!40000 ALTER TABLE `COURSE_FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `COURSE_FACILITY_WITH_NAME`
--

DROP TABLE IF EXISTS `COURSE_FACILITY_WITH_NAME`;
/*!50001 DROP VIEW IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `COURSE_FACILITY_WITH_NAME` (
  `CourseID` tinyint NOT NULL,
  `FacilityID` tinyint NOT NULL,
  `FacilityName` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `EVENT`
--

DROP TABLE IF EXISTS `EVENT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT` (
  `EventReferenceNumber` int(11) NOT NULL AUTO_INCREMENT,
  `EventDate` datetime DEFAULT NULL,
  `EventName` varchar(50) NOT NULL,
  `EventDescription` text,
  `EventMemberFee` decimal(6,2) DEFAULT NULL,
  `EventNonMemberFee` decimal(6,2) DEFAULT NULL,
  `Duration` time DEFAULT NULL,
  PRIMARY KEY (`EventReferenceNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT`
--

LOCK TABLES `EVENT` WRITE;
/*!40000 ALTER TABLE `EVENT` DISABLE KEYS */;
INSERT INTO `EVENT` VALUES (1,'2017-02-01 00:00:00','Cosplay Fest 17',NULL,15.00,30.00,NULL),(2,'2017-02-14 00:00:00','My Nerdy Valentine',NULL,10.00,20.00,NULL),(3,'2016-12-24 00:00:00','Steampunk Yule Ball',NULL,NULL,NULL,NULL),(4,'2017-02-28 00:00:00','Steampunk Maker Faire',NULL,0.00,5.00,NULL),(5,'2017-01-22 00:00:00','January Planning Meeting',NULL,0.00,0.00,NULL),(6,'2017-01-28 00:00:00','Physics for Electronics Seminar',NULL,10.00,20.00,NULL),(7,'2017-03-02 00:00:00','Spring Hackathon',NULL,25.00,50.00,'16:30:00'),(8,'2017-03-11 13:00:00','Maker Race',NULL,0.00,10.00,'06:00:00');
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
-- Table structure for table `EVENT_FACILITY`
--

DROP TABLE IF EXISTS `EVENT_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EVENT_FACILITY` (
  `EventReferenceNumber` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  PRIMARY KEY (`EventReferenceNumber`,`FacilityID`),
  KEY `FacilityID` (`FacilityID`),
  CONSTRAINT `EVENT_FACILITY_ibfk_1` FOREIGN KEY (`EventReferenceNumber`) REFERENCES `EVENT` (`EventReferenceNumber`),
  CONSTRAINT `EVENT_FACILITY_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EVENT_FACILITY`
--

LOCK TABLES `EVENT_FACILITY` WRITE;
/*!40000 ALTER TABLE `EVENT_FACILITY` DISABLE KEYS */;
INSERT INTO `EVENT_FACILITY` VALUES (7,5);
/*!40000 ALTER TABLE `EVENT_FACILITY` ENABLE KEYS */;
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
-- Table structure for table `FACILITY`
--

DROP TABLE IF EXISTS `FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FACILITY` (
  `FacilityID` int(11) NOT NULL AUTO_INCREMENT,
  `FacilityName` varchar(50) DEFAULT NULL,
  `FacilityDescription` text,
  PRIMARY KEY (`FacilityID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FACILITY`
--

LOCK TABLES `FACILITY` WRITE;
/*!40000 ALTER TABLE `FACILITY` DISABLE KEYS */;
INSERT INTO `FACILITY` VALUES (1,'Table Saw 1','SawStop Cabinet Saw'),(2,'Sweing Station 1','Singer 800'),(3,'Sweing Station 2','Singer 800'),(4,'Sweing Station 3','Singer 650'),(5,'Classroom 1','20 seat capacity, contains Linux workstations'),(9,'Linux Workstation 1','Ubuntu'),(10,'Textile Area','Upstairs sewing/crafting area'),(11,'Soldering Station 1',''),(12,'Soldering Station 2',''),(13,'Soldering Station 3',''),(14,'Soldering Station 4',''),(15,'Linux Workstation 2',''),(16,'Linux Workstation 3',''),(17,'Linux Workstation 4',''),(18,'Linux Workstation 5',''),(19,'Linux Workstation 6',''),(20,'Electronics Lab','Contains electronics tools and parts'),(21,'Soldering Bench','Holds soldering stations');
/*!40000 ALTER TABLE `FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `FACILITY_SCHEDULE`
--

DROP TABLE IF EXISTS `FACILITY_SCHEDULE`;
/*!50001 DROP VIEW IF EXISTS `FACILITY_SCHEDULE`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `FACILITY_SCHEDULE` (
  `ReferenceNumber` tinyint NOT NULL,
  `StartTime` tinyint NOT NULL,
  `EndTime` tinyint NOT NULL,
  `FacilityID` tinyint NOT NULL,
  `Type` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LOGIN`
--

LOCK TABLES `LOGIN` WRITE;
/*!40000 ALTER TABLE `LOGIN` DISABLE KEYS */;
INSERT INTO `LOGIN` VALUES (1,17,'2017-01-09 21:22:22','2017-01-09 21:28:22'),(2,51,'2017-01-09 21:22:28','2017-01-09 21:24:02'),(3,34,'2017-01-09 21:22:38','2017-01-09 21:28:31'),(4,51,'2017-01-09 21:24:42','2017-01-09 21:25:06'),(5,17,'2017-01-10 00:48:14','0000-00-00 00:00:00'),(6,34,'2017-01-10 00:48:31','0000-00-00 00:00:00'),(7,51,'2017-01-10 18:28:08','0000-00-00 00:00:00'),(8,17,'2017-01-10 18:28:18','0000-00-00 00:00:00'),(9,34,'2017-01-10 19:55:58','0000-00-00 00:00:00'),(10,17,'2017-01-10 21:20:06','0000-00-00 00:00:00'),(11,34,'2017-01-10 21:20:13','0000-00-00 00:00:00'),(12,51,'2017-01-10 21:20:19','0000-00-00 00:00:00'),(13,17,'2017-01-10 21:50:59','0000-00-00 00:00:00'),(14,17,'2017-01-11 05:28:24','0000-00-00 00:00:00'),(15,34,'2017-01-11 05:28:36','0000-00-00 00:00:00'),(16,51,'2017-01-11 05:28:43','0000-00-00 00:00:00'),(17,51,'2017-01-11 18:33:40','0000-00-00 00:00:00'),(18,17,'2017-01-11 20:05:57','2017-01-11 20:08:32'),(20,68,'2017-01-12 00:19:35','2017-01-12 03:13:52'),(21,17,'2017-01-12 19:18:26','2017-01-12 20:58:30'),(22,34,'2017-01-12 19:18:44','2017-01-12 20:58:35'),(23,17,'2017-01-14 05:22:02','0000-00-00 00:00:00'),(24,17,'2017-01-14 18:52:01','0000-00-00 00:00:00'),(25,34,'2017-01-14 20:57:08','0000-00-00 00:00:00'),(26,51,'2017-01-14 21:22:17','0000-00-00 00:00:00'),(27,34,'2017-01-14 21:33:03','0000-00-00 00:00:00'),(28,17,'2017-01-14 21:37:04','2017-01-14 21:37:32'),(29,34,'2017-01-14 22:25:42','0000-00-00 00:00:00'),(30,17,'2017-01-14 23:31:26','0000-00-00 00:00:00'),(31,51,'2017-01-15 00:23:55','0000-00-00 00:00:00'),(32,17,'2017-01-15 00:30:07','0000-00-00 00:00:00'),(33,51,'2017-01-15 02:42:36','0000-00-00 00:00:00'),(34,17,'2017-01-15 02:56:26','0000-00-00 00:00:00'),(35,34,'2017-01-15 19:53:00','0000-00-00 00:00:00'),(36,17,'2017-01-15 20:01:23','0000-00-00 00:00:00'),(37,51,'2017-01-15 20:01:54','0000-00-00 00:00:00'),(38,34,'2017-01-15 21:17:16','0000-00-00 00:00:00'),(39,34,'2017-01-15 22:29:44','0000-00-00 00:00:00'),(40,17,'2017-01-16 06:40:35','0000-00-00 00:00:00'),(41,17,'2017-01-22 18:51:23','0000-00-00 00:00:00'),(42,17,'2017-01-22 21:36:50','0000-00-00 00:00:00'),(43,51,'2017-01-22 21:38:06','0000-00-00 00:00:00'),(44,51,'2017-01-22 22:13:07','0000-00-00 00:00:00'),(45,17,'2017-01-22 22:49:43','0000-00-00 00:00:00'),(46,34,'2017-01-22 22:49:47','0000-00-00 00:00:00'),(47,68,'2017-01-22 22:50:49','0000-00-00 00:00:00'),(48,17,'2017-01-23 01:08:16','0000-00-00 00:00:00'),(49,68,'2017-01-23 05:58:46','0000-00-00 00:00:00'),(50,34,'2017-01-23 07:05:35','0000-00-00 00:00:00'),(51,17,'2017-01-23 07:06:45','0000-00-00 00:00:00'),(52,51,'2017-01-23 18:46:38','0000-00-00 00:00:00'),(53,51,'2017-01-23 18:46:45','0000-00-00 00:00:00'),(54,51,'2017-01-23 18:46:52','0000-00-00 00:00:00'),(55,51,'2017-01-23 18:46:56','2017-01-23 18:47:27'),(56,51,'2017-01-23 18:48:41','2017-01-23 18:48:46'),(57,34,'2017-01-23 18:49:44','0000-00-00 00:00:00'),(58,17,'2017-01-23 18:52:07','2017-01-23 18:53:31'),(59,17,'2017-01-23 19:38:10','2017-01-23 19:43:31'),(60,34,'2017-01-23 19:38:18','2017-01-23 19:43:21'),(61,51,'2017-01-23 19:38:21','2017-01-23 19:43:34'),(62,68,'2017-01-23 19:38:25','2017-01-23 19:43:27'),(63,34,'2017-01-23 19:46:24','0000-00-00 00:00:00'),(64,17,'2017-01-23 19:47:49','2017-01-23 19:49:10'),(65,68,'2017-01-23 19:50:02','0000-00-00 00:00:00'),(66,17,'2017-01-27 20:13:10','2017-01-27 20:13:33'),(67,17,'2017-01-27 21:03:40','2017-01-27 21:03:52'),(68,17,'2017-01-27 21:12:07','2017-01-27 21:12:13'),(69,17,'2017-01-27 21:30:18','2017-01-27 21:30:37'),(70,68,'2017-01-27 21:43:16','0000-00-00 00:00:00'),(71,51,'2017-01-28 02:53:56','0000-00-00 00:00:00'),(72,68,'2017-01-28 20:27:50','2017-01-28 20:29:35'),(73,68,'2017-01-28 21:58:07','0000-00-00 00:00:00'),(74,17,'2017-01-28 22:36:13','0000-00-00 00:00:00'),(75,34,'2017-01-29 02:43:13','2017-01-29 07:08:29'),(76,51,'2017-01-29 02:43:18','2017-01-29 07:08:24'),(77,17,'2017-01-29 05:57:55','2017-01-29 07:08:14'),(78,0,'2017-01-29 07:08:43','2017-01-29 07:08:49'),(79,17,'2017-02-03 21:01:46','2017-02-04 00:17:13'),(80,51,'2017-02-04 23:06:32','2017-02-06 04:39:41'),(81,34,'2017-02-05 00:43:19','2017-02-05 00:43:23'),(82,17,'2017-02-06 04:39:30','0000-00-00 00:00:00'),(83,68,'2017-02-10 20:49:38','0000-00-00 00:00:00'),(84,51,'2017-02-10 20:49:42','0000-00-00 00:00:00'),(85,34,'2017-02-11 20:54:01','0000-00-00 00:00:00'),(86,68,'2017-02-11 21:06:02','0000-00-00 00:00:00'),(87,17,'2017-02-11 22:53:45','0000-00-00 00:00:00'),(88,34,'2017-02-12 04:47:29','2017-02-12 04:54:10'),(89,51,'2017-02-12 04:47:51','2017-02-12 04:54:16'),(90,17,'2017-02-12 04:54:21','2017-02-12 05:10:21'),(91,68,'2017-02-12 05:09:38','2017-02-12 05:10:27'),(92,68,'2017-02-12 05:19:58','2017-02-12 05:20:24'),(93,34,'2017-02-12 05:20:13','2017-02-12 05:20:31'),(94,17,'2017-02-12 05:21:02','2017-02-12 05:21:41'),(95,51,'2017-02-12 05:21:14','2017-02-12 05:21:24'),(96,34,'2017-02-12 05:30:56','2017-02-12 05:31:05'),(97,68,'2017-02-12 05:31:01','2017-02-12 05:31:20'),(98,17,'2017-02-12 05:31:13','2017-02-12 05:32:02'),(99,51,'2017-02-12 05:31:34','2017-02-12 05:32:30'),(100,34,'2017-02-12 05:34:59','2017-02-12 05:35:18'),(101,51,'2017-02-12 05:35:02','2017-02-12 05:35:09'),(102,17,'2017-02-12 05:48:27','2017-02-12 05:48:46'),(103,68,'2017-02-12 05:48:31','2017-02-12 05:48:38'),(104,34,'2017-02-12 05:49:28','2017-02-12 05:55:13'),(105,51,'2017-02-12 05:49:32','2017-02-12 05:54:51'),(106,17,'2017-02-12 05:55:09','2017-02-12 05:55:35'),(107,68,'2017-02-12 05:55:31','2017-02-12 05:55:45'),(108,34,'2017-02-12 06:16:31','2017-02-12 06:38:54'),(109,17,'2017-02-12 06:37:33','2017-02-12 06:38:11'),(110,68,'2017-02-12 06:39:13','2017-02-12 06:46:22'),(111,51,'2017-02-12 06:46:16','2017-02-12 06:46:35'),(112,17,'2017-02-16 21:51:15','0000-00-00 00:00:00'),(113,34,'2017-02-16 22:14:28','0000-00-00 00:00:00'),(114,51,'2017-02-16 22:20:00','0000-00-00 00:00:00'),(115,68,'2017-02-16 22:20:19','0000-00-00 00:00:00'),(116,34,'2017-02-17 04:45:24','2017-02-17 07:16:41'),(117,68,'2017-02-17 06:38:42','2017-02-17 07:16:52'),(118,17,'2017-02-17 06:38:51','2017-02-17 07:16:36'),(119,51,'2017-02-17 07:15:21','2017-02-17 07:16:46'),(120,34,'2017-02-19 00:18:07','0000-00-00 00:00:00'),(121,34,'2017-02-20 00:12:42','0000-00-00 00:00:00'),(122,34,'2017-02-20 00:28:35','0000-00-00 00:00:00'),(123,51,'2017-03-10 20:15:44','0000-00-00 00:00:00'),(124,34,'2017-03-11 04:46:18','0000-00-00 00:00:00'),(125,51,'2017-03-13 20:22:26','2017-03-13 20:22:30'),(126,51,'2017-03-14 19:36:16','2017-03-14 20:54:13'),(127,17,'2017-03-14 21:19:09','0000-00-00 00:00:00'),(128,68,'2017-03-15 20:25:46','0000-00-00 00:00:00'),(129,17,'2017-03-15 21:30:57','0000-00-00 00:00:00'),(130,68,'2017-03-17 21:09:30','0000-00-00 00:00:00');
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
INSERT INTO `MEMBER` VALUES (0,'Nemo','Nemo',NULL,'2017-01-11 19:47:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL),(17,'Bob','Smith','2000-01-01','2017-01-05 21:13:36','123 Main St','San Diego','Ca','92027','6195551212','6195551313','bob@bobcorp.com','Lisa Smith 6195551313',0,'images/17.jpg','Non-Member'),(34,'Sue','Smith','1980-01-01','2017-01-05 21:15:40','55 abc','San Diego','Ca','92023','6195550123','6195550145','sue@earthlink.net','Joe Jones 6195553131',0,'images/34.jpg','Standard'),(51,'John','Jones','1975-01-01','2017-01-05 21:18:33','55 abc','San Diego','Ca','92023','6195553456','6195556789','John@yahoo.com','Sue Smith 6195550123',34,'images/51.jpeg','Voting'),(68,'James','Madison','1938-01-01','2017-01-11 20:23:25','255 First St.','La Mesa','CA','92025','6195553333','6195554444','jim@history.gov','Dolly Madison 6195555555',0,'images/68.jpg','Voting');
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
INSERT INTO `MEMBER_CERTIFICATION` VALUES (17,'Audio Studio Technician'),(51,'Audio Studio Technician'),(51,'Basic Power Tool Safety'),(17,'Blacksmith'),(34,'Metal Casting'),(17,'Soldering'),(34,'Table Saw Safety'),(51,'Table Saw Safety'),(17,'Welding Safety'),(34,'Welding Safety'),(51,'Welding Safety'),(68,'Welding Safety');
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
INSERT INTO `NOTES` VALUES ('2017-01-11 19:02:19',51,'This is a test note.'),('2017-01-12 01:51:27',68,'This is another test note.'),('2017-01-15 19:55:34',34,'Testing the note entry system.  Yet again.'),('2017-01-15 20:01:45',17,'Does this note suffer from the same anomaly seen before?'),('2017-01-15 20:07:52',51,'Second test note to test stacking'),('2017-01-15 20:08:10',51,'Third test note to test window expansion'),('2017-01-16 06:40:56',17,'regarding payment 28: Repayment for broken saw blade'),('2017-01-23 18:54:15',51,'Left safety glasses by table saw.  They are being held in the lost and found.'),('2017-01-23 19:49:35',17,'Left safety glasses by table saw.  They are waiting for him in lost and found.'),('2017-01-27 21:34:47',17,'Test to see if the note entry system is broken.'),('2017-02-11 23:42:09',17,'regarding payment 44: Refund for Welding Safety class on 2/11/17'),('2017-02-12 05:49:54',51,'Test note to see if I borked the system.');
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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PAYMENT`
--

LOCK TABLES `PAYMENT` WRITE;
/*!40000 ALTER TABLE `PAYMENT` DISABLE KEYS */;
INSERT INTO `PAYMENT` VALUES (1,'2017-01-11 05:33:05',17,20.00,NULL),(3,'2017-01-11 19:01:57',51,50.00,NULL),(4,'2017-01-12 19:57:09',17,30.00,NULL),(5,'2017-01-15 02:44:01',51,25.00,''),(6,'2017-01-15 02:46:30',51,15.00,'event'),(7,'2017-01-15 02:47:22',51,5.00,'class'),(8,'2017-01-15 02:47:48',51,30.00,''),(9,'2017-01-15 02:54:07',51,25.00,'class'),(10,'2017-01-15 02:54:24',51,10.00,'event'),(11,'2017-01-15 02:54:40',51,30.00,'dues'),(12,'2017-01-15 02:54:55',51,300.00,'donation'),(13,'2017-01-15 02:55:27',51,27.00,'merchandise'),(14,'2017-01-15 02:56:07',51,22.00,'other'),(15,'2017-01-15 02:56:38',17,20.00,'event'),(16,'2017-01-15 03:01:44',17,32.00,'other'),(17,'2017-01-15 03:09:19',17,27.50,'merchandise'),(23,'2017-01-15 22:57:15',34,25.00,'class'),(24,'2017-01-16 06:20:17',34,5.00,'class'),(25,'2017-01-16 06:21:28',34,10.00,'event'),(26,'2017-01-16 06:22:48',34,10.00,'event'),(27,'2017-01-16 06:26:14',34,40.00,'dues'),(28,'2017-01-16 06:40:56',17,52.80,'other'),(29,'2017-01-23 18:51:13',34,25.00,'class'),(30,'2017-01-23 18:52:23',17,50.00,'class'),(31,'2017-01-23 19:38:38',68,15.00,'event'),(32,'2017-01-23 19:47:36',34,25.00,'class'),(33,'2017-01-23 19:48:03',17,50.00,'class'),(34,'2017-01-23 19:48:22',34,15.00,'event'),(35,'2017-01-28 03:02:12',51,0.00,'event'),(36,'2017-01-28 03:08:39',51,0.00,'event'),(37,'2017-01-28 03:16:52',51,40.00,'dues'),(38,'2017-01-28 03:17:05',51,10.00,'event'),(39,'2017-01-28 04:02:59',51,-10.00,'event'),(40,'2017-01-29 05:59:51',17,10.00,'class'),(41,'2017-01-29 06:45:48',17,40.00,'class'),(42,'2017-02-05 01:21:59',34,20.00,'class'),(43,'2017-02-11 23:08:11',17,40.00,'class'),(44,'2017-02-11 23:42:08',17,50.00,'other'),(45,'2017-02-12 00:21:09',17,20.00,'dues'),(46,'2017-02-16 22:53:22',34,40.00,'dues'),(47,'2017-02-19 00:18:30',34,25.00,'class'),(48,'2017-03-14 21:17:52',51,40.00,'dues');
/*!40000 ALTER TABLE `PAYMENT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `PAYMENT_WITH_NAME`
--

DROP TABLE IF EXISTS `PAYMENT_WITH_NAME`;
/*!50001 DROP VIEW IF EXISTS `PAYMENT_WITH_NAME`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `PAYMENT_WITH_NAME` (
  `PaymentReferenceNumber` tinyint NOT NULL,
  `PaymentDate` tinyint NOT NULL,
  `MemberID` tinyint NOT NULL,
  `Amount` tinyint NOT NULL,
  `Reason` tinyint NOT NULL,
  `Name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

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
-- Table structure for table `SUB_FACILITY`
--

DROP TABLE IF EXISTS `SUB_FACILITY`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SUB_FACILITY` (
  `PrimaryFacilityID` int(11) NOT NULL,
  `SubFacilityID` int(11) NOT NULL,
  PRIMARY KEY (`PrimaryFacilityID`,`SubFacilityID`),
  KEY `SubFacilityID` (`SubFacilityID`),
  CONSTRAINT `SUB_FACILITY_ibfk_1` FOREIGN KEY (`PrimaryFacilityID`) REFERENCES `FACILITY` (`FacilityID`),
  CONSTRAINT `SUB_FACILITY_ibfk_2` FOREIGN KEY (`SubFacilityID`) REFERENCES `FACILITY` (`FacilityID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SUB_FACILITY`
--

LOCK TABLES `SUB_FACILITY` WRITE;
/*!40000 ALTER TABLE `SUB_FACILITY` DISABLE KEYS */;
INSERT INTO `SUB_FACILITY` VALUES (10,2),(10,3),(10,4),(5,9),(21,11),(21,12),(21,13),(21,14),(5,15),(5,16),(5,17),(5,18),(5,19),(20,21);
/*!40000 ALTER TABLE `SUB_FACILITY` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Final view structure for view `ALL_ENROLLMENTS`
--

/*!50001 DROP TABLE IF EXISTS `ALL_ENROLLMENTS`*/;
/*!50001 DROP VIEW IF EXISTS `ALL_ENROLLMENTS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ALL_ENROLLMENTS` AS select `A`.`MemberID` AS `MemberID`,`B`.`ClassReferenceNumber` AS `ReferenceNumber`,`C`.`CourseName` AS `Name`,`B`.`ClassDate` AS `Date`,`A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,'CLASS' AS `Type` from ((`CLASS_ENROLLMENT` `A` join `CLASS` `B`) join `COURSE` `C`) where ((`A`.`ClassReferenceNumber` = `B`.`ClassReferenceNumber`) and (`B`.`CourseID` = `C`.`CourseID`)) union select `A`.`MemberID` AS `MemberID`,`B`.`EventReferenceNumber` AS `ReferenceNumber`,`B`.`EventName` AS `Name`,`B`.`EventDate` AS `Date`,`A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,'EVENT' AS `Type` from (`EVENT_ENROLLMENT` `A` join `EVENT` `B`) where (`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `COURSE_FACILITY_WITH_NAME`
--

/*!50001 DROP TABLE IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `COURSE_FACILITY_WITH_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `COURSE_FACILITY_WITH_NAME` AS select `A`.`CourseID` AS `CourseID`,`A`.`FacilityID` AS `FacilityID`,`B`.`FacilityName` AS `FacilityName` from (`COURSE_FACILITY` `A` join `FACILITY` `B` on((`A`.`FacilityID` = `B`.`FacilityID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `FACILITY_SCHEDULE`
--

/*!50001 DROP TABLE IF EXISTS `FACILITY_SCHEDULE`*/;
/*!50001 DROP VIEW IF EXISTS `FACILITY_SCHEDULE`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `FACILITY_SCHEDULE` AS select `A`.`ClassReferenceNumber` AS `ReferenceNumber`,`A`.`ClassDate` AS `StartTime`,addtime(`A`.`ClassDate`,`B`.`Duration`) AS `EndTime`,`C`.`FacilityID` AS `FacilityID`,'CLASS' AS `Type` from ((`CLASS` `A` join `COURSE` `B` on((`A`.`CourseID` = `B`.`CourseID`))) join `COURSE_FACILITY` `C` on((`B`.`CourseID` = `C`.`CourseID`))) union select `A`.`EventReferenceNumber` AS `ReferenceNumber`,`A`.`EventDate` AS `StartTime`,addtime(`A`.`EventDate`,`A`.`Duration`) AS `EndTime`,`B`.`FacilityID` AS `FacilityID`,'EVENT' AS `Type` from (`EVENT` `A` join `EVENT_FACILITY` `B` on((`A`.`EventReferenceNumber` = `B`.`EventReferenceNumber`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

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
-- Final view structure for view `PAYMENT_WITH_NAME`
--

/*!50001 DROP TABLE IF EXISTS `PAYMENT_WITH_NAME`*/;
/*!50001 DROP VIEW IF EXISTS `PAYMENT_WITH_NAME`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `PAYMENT_WITH_NAME` AS select `A`.`PaymentReferenceNumber` AS `PaymentReferenceNumber`,`A`.`PaymentDate` AS `PaymentDate`,`A`.`MemberID` AS `MemberID`,`A`.`Amount` AS `Amount`,`A`.`Reason` AS `Reason`,`B`.`Name` AS `Name` from (`PAYMENT` `A` left join `ALL_ENROLLMENTS` `B` on((`B`.`PaymentReferenceNumber` = `A`.`PaymentReferenceNumber`))) */;
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

-- Dump completed on 2017-05-02 12:03:44
