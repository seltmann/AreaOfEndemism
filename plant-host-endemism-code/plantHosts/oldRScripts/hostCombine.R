setwd("~/Desktop/Dropbox/NEWareaOfEndemism/code/endemismCodeKatja/plantHosts/rawPlantData/output/")

###===================

hostplants <- read.delim("concatPlantHostsNotUnique.tsv", header = TRUE, stringsAsFactors = FALSE, sep = "\t", quote = "\"")

help(read.delim)
head(hostplants)

allHosts <- hostplants[c("coreid","dwc.catalogNumber","dwc.locality","dwc.decimalLatitude","dwc.decimalLongitude","dwc.country","dwc.stateProvince","dwc.county","dwc.municipality","dwc.coordinateUncertaintyInMeters","dwc.verbatimLocality","dwc.georeferenceRemarks","dwc.establishmentMeans","dwc.eventDate","dwc.higherClassification","dwc.family","dwc.genus","dwc.specificEpithet","dwc.infraspecificEpithet","dwc.scientificName")]

colnames(allHosts) <- c("id","catalogNumber","Locality", "Latitude", "Longitude", "Country", "State_Province", "County", "Municipality","coordinateUncertaintyInMeters","verbatimLocality","georeferenceRemarks","establishmentMeans","eventDate","higherClassification","family","genus","specificEpithet","infraspecificEpithet","scientificName")

write.table(host_unique, file="rawPlantData/output/concatPlantHostsUniqueNA.tsv", sep="\t", append = TRUE ,row.names = FALSE,col.names = FALSE)

# Subsets dataframe by desired country
latrev_subset <- subset(hostplants, (Country %in% c("UNITED STATES","United States","Mexico","Estados Unidos","U. S. A.","Canada","Canadá","México","United States of America","U.S.A","USA","U.S.A.","CANADA","Arizona","USa")))

# Creates a dataframe of unique localities
uniquehostplants <- read.delim("rawPlantData/output/concatPlantHostsUnique.tsv", header = TRUE, stringsAsFactors = FALSE, fill = TRUE)

#host_unique <- unique(hostplants$Country)
uniquerecords <- unique(latrev_subset)

write.table(uniquerecords, file="concatPlantHostsUNIQUENA.tsv", sep="\t", append = FALSE ,row.names = FALSE,col.names = TRUE,quote = FALSE)

#head(host_unique)
help(write.table)
