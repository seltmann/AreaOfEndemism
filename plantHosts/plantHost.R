setwd("~/Desktop/Dropbox/area_of_endemismProject/code/endemismCodeKatja/plantHosts")

plantHosts <- read.table("plantHosts.tsv", header = TRUE, sep = "\t" ,fill = TRUE, stringsAsFactors = FALSE)

head(plantHosts)

scientificName <- paste(plantHosts$h_genus,plantHosts$h_species,sep=' ')

head(scientificName)

plantHosts <- cbind(plantHosts,scientificName)
plantHosts$scientificName
unique(plantHosts$rel_confidence)

#all unique plant names
uniquePlantHosts <- unique(plantHosts$scientificName)
head(uniquePlantHosts)
write.table(uniquePlantHosts,file = "uniquePlantHosts.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

#all unique plant names where rel_confidence is low
PlantHostsLow <- subset(plantHosts, plantHosts$rel_confidence == 'LOW')
head(PlantHostsLow)
uniquePlantHostsLow<- unique(PlantHostsLow$scientificName)
head(uniquePlantHostsLow)
write.table(uniquePlantHostsLOW,file = "uniquePlantHostsLow.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

#all unique plant names where rel_confidence is high
PlantHostsHIGH <- subset(plantHosts, plantHosts$rel_confidence == 'HIGH')
head(PlantHostsHIGH)
uniquePlantHostsHIGH<- unique(PlantHostsHIGH$scientificName)
head(uniquePlantHostsHIGH)
write.table(uniquePlantHostsHIGH,file = "uniquePlantHostsHIGH.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

#all unique plant names where rel_confidence is medium
PlantHostsMEDIUM <- subset(plantHosts, plantHosts$rel_confidence == 'MEDIUM')
head(PlantHostsMEDIUM)
uniquePlantHostsMEDIUM<- unique(PlantHostsMEDIUM$scientificName)
head(uniquePlantHostsMEDIUM)
write.table(uniquePlantHostsMEDIUM,file = "uniquePlantHostsMEDIUM.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

#all unique plant names where rel_confidence is medium
PlantHostsMEDIUMHIGH <- subset(plantHosts, plantHosts$rel_confidence == 'MEDIUM_HIGH')
head(PlantHostsMEDIUMHIGH)
uniquePlantHostsMEDIUMHIGH<- unique(PlantHostsMEDIUMHIGH$scientificName)
head(uniquePlantHostsMEDIUMHIGH)
write.table(uniquePlantHostsMEDIUMHIGH,file = "uniquePlantHostsMEDIUMHIGH.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

help(write.table)
