#  AreaOfEndemism Project

This is the repository of code associated with the publication: Areas of endemism in the Nearctic: a case study of 1,339 species of Miridae and their plant hosts. R.T. Schuh, M.D. Schwartz, C. Weirauch, K.C. Seltmann, M.A. Feist, P. Soltis, in prep. 2015-2016. The AOE project started in 2014 as part of a research data workshop during the tenure of the Tri-Trophic Database ADBC Thematic Collection Network project.

Please contact Katja C. Seltmann (enicospilus@gmail.com) @seltmann if you have any questions about the data and code in this repository.

##DESCRIPTION OF INCLUDED CODE 

##localityMatrix Folder
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
###map-bug-data folder
* MappingStateCheck.php:
* geoCheck.R: maps geocoordinates by state to help look for outlying data points.
stateCheck.txt:

##plantHosts Folder
###host-analysis Folder:
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
* forMatrixPlantRounded.txt:
* forMatrixNA5_RoundedTaxaList:
* decision_network_confidence_species.php: applies confidence interval to those insect/host relationships.
* host_network_species.php: finds relationship hypothesis between plants and plant bugs

###map-plant-data Folder:
* geoCheck.R
* stateCheck.txt

###plant-data-idigbio Folder:
* geoAPI.R: retrieves all of the plant data from iDigBio using genus and species fields that has coordinates. Then formats it by removing all unnecessary additional fields.
updates-planthosts-table.txt
updatesPlantHostsSynonyms.txt
plantHostsAllData_v2.txt:


##DESCRIPTION OF MySQL Database:
Based on the default parameters used in this analysis, the entire AOE database available through figshare (doi: 10.6084/m9.figshare.2060979), represents a subset of the AMNH instance of the AEC database, which includes additional tables to capture host plant data and host analysis.

1) Miridae subFamily(id) =Mirinae(id:8150), Orthotylinae(id:6294), Phylinae(id:6295), Deraeocorinae(id:8163) from AEC database sql.
2) geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
3) complete plant host analysis
4) cleaned plant host data

>Seltmann, K.C.. 2016. AOE analysis subset of the Arthropod Easy Capture (AEC) database. [Accessed: 06 Jan 2016]. figshare. doi: https://dx.doi.org/10.6084/m9.figshare.2060979



