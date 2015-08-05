#  AreaOfEndemism

Code for Area of Endemism project. Started 2014, updated July 2015.

https://github.com/seltmann/AreaOfEndemism

##INCLUDED FOLDERS:
mapping - to check geo coordinates for both insect and plant data
plantHosts - confidences of associated plant hosts from AEC
localityMatrix - creation of data matrix for software
old - archive (will be deleted)

##INCLUDED SCRIPTS: 
endemism.php: query the AEC database for taxa and localities of interest.
matrixOnlyLocality.php: formats interested localities and taxa from AEC in matrix format
matrixOnlyLocalityRounded.php: formats interested localities and taxa from AEC in matrix format, rounded.
host_network_genus.php: confidence of associated taxa with host plants

##TODO/METHODS:
1) create Miridae matrix for >2-5 collecting events
	- Graph and correct lat/long coordinates of events. Should we include hawaii and canada?
2) get associated taxa for all N. American taxa in those subfamilies identified to species.
3) check associated taxa against iplant taxon name resolution service (http://tnrs.iplantcollaborative.org/TNRSapp.html) valid name database. Correct names in AEC.
4) query idigbio for those taxa
5) produce matrix results for plant taxa

##DATA LIMITS:
1.	- filters: SubFamily = Mirinae(id:8150),Orthotylinae(id:6294),Phylinae(id:6295),Deraeocorinae(id:8163)

2.	- geographic range: North America Country.UID = Canada(id:2),Mexico(id:8),USA(id:11)
	
3.	- secondary geographic filters: StateProv.StateProvUID = Arizona(id:4),Nevada(id:45),California(id:10),Baja California(id:6),Baja California Norte(id:7),Baja California Sur(id:8),Sonora(id:79)
	
4.	- two, three, four, and five or more unique localities per species
	
5.	- insect determined to species


####++++++++++++++++++++++++++++++++++++++++++
ADDITIONAL ANALYSIS IDEAS:
1) Find the California Floristic Provence shape file and limit known taxa based on that geography
2) Use endemic plant list from Harrison, Susan "Plant and Animal Endemism in California" to compare with known results
3) Identify several restoration habitats (ie vernal pools) and apply same criteria
4) Summarize endemic genera of insects based on endemic plant list
5) Summarize known mediterranean climate species (genera) in world geography
6) NatureServ hotspot map?
7) plot species/actual evapotranspiration
8) shape file of central valley?
