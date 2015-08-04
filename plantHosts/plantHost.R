setwd("~/Desktop/Dropbox/area_of_endemismProject/code/endemismCodeKatja/plantHosts")

plantHosts <- read.table("plantHosts.tsv", header = TRUE, sep = "\t" ,fill = TRUE, stringsAsFactors = FALSE)

head(plantHosts)

scientificName <- paste(plantHosts$h_genus,plantHosts$h_species,sep=' ')

head(scientificName)

plantHosts <- cbind(plantHosts,scientificName)
plantHosts$scientificName

#all unique plant names
uniquePlantHosts <- unique(plantHosts$scientificName)
head(uniquePlantHosts)
write.table(uniquePlantHosts,file = "uniquePlantHosts.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

#all unique plant names where rel_confidence is not low
PlantHostsNotLow <- subset(plantHosts, plantHosts$rel_confidence != 'LOW')
head(PlantHostsNotLow)
uniquePlantHostsNotLow <- unique(PlantHostsNotLow$scientificName)
head(uniquePlantHostsNotLow)
write.table(uniquePlantHostsNotLow,file = "uniquePlantHostsNotLow.tsv", sep = "\t",col.names = FALSE, append = FALSE, quote = FALSE, row.names = FALSE)

help(write.table)
