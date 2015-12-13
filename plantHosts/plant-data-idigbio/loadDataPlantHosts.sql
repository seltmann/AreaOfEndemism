#load data for iDigBio planthost data into temp database

LOAD DATA
LOCAL INFILE "all.tsv"
REPLACE INTO TABLE planthosts
FIELDS TERMINATED BY '\t' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
(coreid,institutioncode,catalogNumber,locality,@decimalLatitude,@decimalLongitude,country,stateProvince,county,municipality,@coordinateUncertaintyInMeters,family,genus,specificEpithet,infraspecificEpithet,scientificName)
SET coordinateUncertaintyInMeters = IF(@coordinateUncertaintyInMeters='0',NULL,@coordinateUncertaintyInMeters),
decimalLongitude = IF(@decimalLongitude='0',NULL,@decimalLongitude),
decimalLatitude = IF(@decimalLatitude='0',NULL,@decimalLatitude);


#create and drop table statements for cooresponding load data
DROP TABLE IF EXISTS `planthosts`;

CREATE TABLE `planthosts` (
  `coreid` varchar(255) DEFAULT NULL,
  `institutioncode` varchar(255) DEFAULT NULL,
  `catalogNumber` varchar(255) DEFAULT NULL,
  `locality` text,
  `decimalLatitude` double DEFAULT NULL,
  `decimalLongitude` double DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `stateProvince` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `coordinateUncertaintyInMeters` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `genus` varchar(255) DEFAULT NULL,
  `specificEpithet` varchar(255) DEFAULT NULL,
  `infraspecificEpithet` varchar(255) DEFAULT NULL,
  `scientificName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
