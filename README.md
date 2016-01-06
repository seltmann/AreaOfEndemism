#  AreaOfEndemism Project
This is the repository of code associated with the publication: Areas of endemism in the Nearctic: a case study of 1,339 species of Miridae and their plant hosts. R.T. Schuh, M.D. Schwartz, C. Weirauch, K.C. Seltmann, M.A. Feist, P. Soltis, in prep. 2015-2016. The AOE project started in 2014 as part of a research data workshop during the tenure of the Tri-Trophic Database ADBC Thematic Collection Network project.

Author: Katja C. Seltmann (enicospilus@gmail.com) @seltmann if you have any questions about the data and scripts in this repository.

##DESCRIPTION OF INCLUDED CODE 
* matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
* host_network_genus.php: finds relationship hypothesis between plants and plant bugs
decision_network_confidence_species.php: applies confidence interval to those insect/host relationships.
geoAPI.R: retrieves all of the plant data from iDigBio using genus and species fields that has coordinates. Then formats it by removing all unnecessary additional fields.
geoCheck.R: maps geocoordinates by state to help look for outlying data points.

##DESCRIPTION OF INCLUDED DATASETS:
forMatrixNA5_Rounded.txt: file produced by the matrixOnlyLocalityRounded.php script. It is the initial output of plant bugs for analysis, formatted for NDM/VNDM software.



