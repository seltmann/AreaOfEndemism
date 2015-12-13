#  AreaOfEndemism Project
This is the repository of code for Area of Endemism project. The project started 2014, and is still in progress. Contact @seltmann if you have any questions about the data and scripts in this repository.

https://github.com/seltmann/AreaOfEndemism


##SCRIPTS USED TO PRODUCE DATASETS: 
matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded to three decimal points.
host_network_genus.php: finds relationship hypothesis between plants and plant bugs
decision_network_confidence_species.php: applies confidence interval to those insect/host relationships.
geoAPI.R: retrieves all of the plant data from iDigBio using genus and species fields that has coordinates. Then formats it by removing all unnecessary additional fields.
geoCheck.R: maps geocoordinates by state to help look for outlying data points.

##DESCRIPTION OF INCLUDED DATASETS:
forMatrixNA5_Rounded.txt: file produced by the matrixOnlyLocalityRounded.php script. It is the initial output of plant bugs for analysis, formatted for NDM/VNDM software.

##TODO/METHODS:
1) create Miridae locality matrix for >2-5 collecting events

2) get associated taxa for all N. American taxa in those subfamilies identified to species.
	* edited taxon names, Orthotyplus replaced Melanotrichus, and generate a unique dataset for insect names in >=5 [forMatrixNA5_RoundedTaxaList.txt]; updates to database are located in the mysqlUpdatesForDatabasePreTest.sql file.
	* build host_network_species table in AOE database using host_network.sql file
	* run host_network_species.php script
	* run decision_network_confidence_species.php on server
	* export host_network_species table for review. check associated taxa against iplant taxon name resolution service (http://tnrs.iplantcollaborative.org/TNRSapp.html) valid name database. Correct names in AEC [iterative]. And review with Michael & Toby.

4) query idigbio for those plant taxa and related EOL synonyms, removing ambiguous names

5) produce matrix results for plant taxa for >2-5 collecting events


##DATA LIMITS:
1.	- filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163)

2.	- geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
	
3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
	
4.	- two, three, four, and five, ten
	
5.	- insect determined to species

6. after limits working with 476547 specimen records in AEC

