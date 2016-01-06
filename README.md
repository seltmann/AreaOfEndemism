#  AreaOfEndemism Project

This is the repository of code associated with the publication: Areas of endemism in the Nearctic: a case study of 1,339 species of Miridae and their plant hosts. R.T. Schuh, M.D. Schwartz, C. Weirauch, K.C. Seltmann, M.A. Feist, P. Soltis, in prep. 2015-2016. The AOE project started in 2014 as part of a research data workshop during the tenure of the Tri-Trophic Database ADBC Thematic Collection Network project.

Please contact Katja C. Seltmann (enicospilus@gmail.com) @seltmann if you have any questions about the data and code in this repository.

##DESCRIPTION OF INCLUDED CODE 

#localityMatrix Folder
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.

#map-bug-data folder
* MappingStateCheck.php:
* geoCheck.R: maps geocoordinates by state to help look for outlying data points.
stateCheck.txt:

#plantHosts Folder
#host-analysis Folder:
host_network_species.php:
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
* host_network_genus.php: finds relationship hypothesis between plants and plant bugs
* decision_network_confidence_species.php: applies confidence interval to those insect/host relationships.
* forMatrixNA5_RoundedTaxaList.txt

#map-plant-data Folder:
* geoCheck.R
* stateCheck.txt

#plant-data-idigbio Folder:
* geoAPI.R: retrieves all of the plant data from iDigBio using genus and species fields that has coordinates. Then formats it by removing all unnecessary additional fields.
updates-planthosts.table.txt
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.


##DESCRIPTION OF INCLUDED MySQL:
Based on the default parameters used in this analysis, the AOE database (/database/AOE_12132015.sql) represents a subset of the AMNH instance of the AEC database, which includes additional tables to capture host plant data and host analysis.

1) Miridae subFamily(id) =Mirinae(id:8150), Orthotylinae(id:6294), Phylinae(id:6295), Deraeocorinae(id:8163) from AEC database sql.
2) geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
3) complete plant host analysis
4) cleaned plant host data




