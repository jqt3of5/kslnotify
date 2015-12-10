CREATE DATABASE `kslnotify`

CREATE TABLE `notifications` (
   `guid` varchar(30) NOT NULL,
   `name` varchar(100) DEFAULT NULL,
   `email` varchar(100) DEFAULT NULL,
   `url` varchar(500) DEFAULT NULL,
   `owner` varchar(20) DEFAULT NULL,
   `createdDate` date DEFAULT NULL,
   PRIMARY KEY (`guid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1
 
CREATE TABLE `ads` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `guid` varchar(30) DEFAULT NULL,
   `title` varchar(100) DEFAULT NULL,
   `description` varchar(255) DEFAULT NULL,
   `price` decimal(13,2) DEFAULT NULL,
   `imgurl` varchar(100) DEFAULT NULL,
   `adurl` varchar(100) DEFAULT NULL,
   PRIMARY KEY (`id`),
   KEY `guid` (`guid`),
   CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`guid`) REFERENCES `notifications` (`guid`)
 ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1
 

