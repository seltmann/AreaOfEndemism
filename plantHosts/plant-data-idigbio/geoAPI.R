#grabs all idigbio specimen records based on a list of genus and species names
#kseltmann (enicospilus@gmail.com) August 2015

#had to download mac binaries and install from desktop to get to work
#install.packages("devtools")
#install_github("idigbio/ridigbio")
#install.packages("ridigbio")

library(devtools)
library(ridigbio)


#get a tab delimited list of names
setwd("~/Desktop/Dropbox/NEWareaOfEndemism/code/endemismCodeKatja/plantHosts/rawDatasetsV2")

hostplants <- read.delim("../plantHostsMissingData.tsv", header = FALSE, stringsAsFactors = FALSE, sep = "\t", quote = "\"")
hostplants <- unique(hostplants)
nrow(hostplants)
hostplants <- cbind(hostplants,1:nrow(hostplants))
colnames(hostplants) <- c("genus","specificepithet","id")
head(hostplants)

#creates separate spreadsheet for all genus species in tab delimited list
for (x in hostplants$id){
subsetHosts <- subset(hostplants, id == x)
g <- subsetHosts$genus
sE <- subsetHosts$specificepithet

query <- list(genus=g,specificepithet=sE,geopoint=list(type="exists"))
  df <- idig_search_records(rq=query,fields="all")

#no georeference remarks? or establishmentMeans?
allHosts <- df[c("uuid","institutioncode","catalognumber","locality","geopoint.lat","geopoint.lon","country","stateprovince","county","municipality","coordinateuncertainty","family","genus","specificepithet","infraspecificepithet","scientificname")]

colnames(allHosts) <- c("coreid","institutioncode","catalogNumber","locality", "decimalLatitude", "decimalLongitude", "country", "stateProvince", "county", "municipality","coordinateUncertaintyInMeters","family","genus","specificEpithet","infraspecificEpithet","scientificName")

title <- paste(g,"_",sE,'.tsv',sep="")

#create a separate file for each genus/species
write.table(allHosts, file=title, sep="\t", append = FALSE , row.names = FALSE, col.names = FALSE, qmethod = "double")

#create one giant file
write.table(allHosts, file="all.tsv", sep="\t", append = TRUE , row.names = FALSE, col.names = FALSE)
}

#insert into mysql database using load data all.tsv

#################################
#################################


## information below about the idigbio api and ridigbio
#https://github.com/cran/ridigbio

#returns all searchable fields
idig_meta_fields()

#find all functions in package
lsp <- function(package, all.names = FALSE, pattern) 
{
  package <- deparse(substitute(package))
  ls(
    pos = paste("package", package, sep = ":"), 
    all.names = all.names, 
    pattern = pattern
  )
}

lsp(ridigbio)
