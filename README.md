#  AreaOfEndemism Project

This is the repository of code associated with the publication: Areas of endemism in the Nearctic: a case study of 1,339 species of Miridae and their plant hosts. R.T. Schuh, M.D. Schwartz, C. Weirauch, K.C. Seltmann, M.A. Feist, P. Soltis, in prep. 2015-2016. The AOE project started in 2014 as part of a research data workshop during the tenure of the Tri-Trophic Database ADBC Thematic Collection Network project.

Please contact Katja C. Seltmann (enicospilus@gmail.com) @seltmann if you have any questions about the data and code in this repository.

##Description of code and text files included in this repository

##localityMatrix folder
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.

##plantHosts folder
###host-analysis folder:
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
* forMatrixPlantRounded.txt: Resulting matrix for default dataset used in NDM/VNDM analyses
* forMatrixNA5_RoundedTaxaList: List of unique Miridae taxa included in default NDM/VNDM analysis. 
* decision_network_confidence_species.php: applies confidence interval to those insect/host relationships. Results from this analysis are entered in the AOE database/planthosts table.
* host_network_species.php: finds relationship hypothesis between plants and plant bugs. Results from this analysis are entered in the AOE database/planthosts table.

###plant-data-idigbio folder:
* geoAPI.R: retrieves all of the plant data from iDigBio using genus and species fields that has coordinates. Then formats it by removing all unnecessary additional fields.
* updates-planthosts-table.txt: Updates performed on the AEC MySQL database.
* updatesPlantHostsSynonyms.txt: Updates performed on the AEC MySQL database.
* plantHostsAllData_v2.txt: Text copy of data found in the AOE MySQL planthosts table.

##DESCRIPTION OF MySQL Database:
Based on the default parameters used in this analysis, the entire AOE database available through figshare (doi: 10.6084/m9.figshare.2060979), represents a subset of the AMNH instance of the AEC database. The AOE database includes only the cleaned, updated, and analyzed versions of the Miridae and host plant data.

Data Parameters and associated ids are:
* Miridae subFamily(id) =Mirinae(id:8150), Orthotylinae(id:6294), Phylinae(id:6295), Deraeocorinae(id:8163) from AEC database sql.
* geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)

>Seltmann, K.C.. 2016. AOE analysis subset of the Arthropod Easy Capture (AEC) database. [Accessed: 06 Jan 2016]. figshare. doi: https://dx.doi.org/10.6084/m9.figshare.2060979

>Seltmann, K.C.. 2016. AOE analysis software. [Accessed: 06 Jan 2016]. zendo. doi: https://dx.doi.org/10.5281/zenodo.44387



