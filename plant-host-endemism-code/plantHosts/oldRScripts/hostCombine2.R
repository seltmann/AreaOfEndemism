setwd("~/Desktop/Dropbox/area_of_endemismProject/code/endemismCodeKatja/plantHosts")

hostplants <- read.csv("rawPlantData/output/occurrence_raw9.csv", header = TRUE, stringsAsFactors = FALSE,fill = TRUE)

#head(hostplants)
#help(read.csv)

allHosts <- hostplants[c("coreid","dwc.catalogNumber","dwc.locality","dwc.decimalLatitude","dwc.decimalLongitude","dwc.country","dwc.stateProvince","dwc.county","dwc.municipality","dwc.coordinateUncertaintyInMeters","dwc.verbatimLocality","dwc.georeferenceRemarks","dwc.eventDate","dwc.higherClassification","dwc.family","dwc.genus","dwc.specificEpithet","dwc.infraspecificEpithet","dwc.scientificName")]

colnames(allHosts) <- c("id","catalogNumber","Locality", "Latitude", "Longitude", "Country", "State_Province", "County", "Municipality","coordinateUncertaintyInMeters","verbatimLocality","georeferenceRemarks","eventDate","higherClassification","family","genus","specificEpithet","infraspecificEpithet","scientificName")

# Subsets dataframe by desired country
latrev_subset <- subset(allHosts, (Country %in% c("United States","Canada","Mexico")))

# Creates a dataframe of unique localities
host_unique <- unique(latrev_subset)
head(host_unique)

write.table(host_unique, file="rawPlantData/output/concatPlantHostsUnique.tsv", sep="\t", quote=FALSE,append = TRUE,col.names = FALSE)

help(write.table)
