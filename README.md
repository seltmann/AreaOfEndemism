#  AreaOfEndemism

Code for Area of Endemism project. Started 2014, updated July 2015.
https://github.com/seltmann/AreaOfEndemism

##INCLUDED FOLDERS:


##USED INCLUDED SCRIPTS: 
endemism.php: query the AEC database for taxa and localities of interest.
matrixOnlyLocality.php: formats interested localities and taxa from AEC in matrix format
matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded.
host_network_genus.php: confidence of associated taxa with host plants
geoCheck.R: maps geocoordinates by state

##TODO/METHODS:
1) create Miridae matrix for >5 collecting events
	- Graph and correct lat/long coordinates of events.
2) get associated taxa for all N. American taxa in those subfamilies identified to species.
3) check associated taxa against iplant taxon name resolution service (http://tnrs.iplantcollaborative.org/TNRSapp.html) valid name database. Correct names in AEC.
4) query idigbio for those plant taxa and related EOL synonyms, removing ambiguous names
5) produce matrix results for plant taxa for >2-5 collecting events
6) create Apidae matrix for >2-5 collecting events from AEC bee project

##DATA LIMITS:
1.	- filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163)

2.	- geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
	
3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
	
4.	- two, three, four, and five, ten
	
5.	- insect determined to species


