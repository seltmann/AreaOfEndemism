#Mapping of time series of all arthropod collecting events
#@seltmann
library(maps)
library(mapdata)
setwd("/Users/Irene/desktop/dropbox/NEWareaOfEndemism/code/endemismCodeKatja/plantHosts/map")
rm(list=ls())
help(mapdata)
??mapdata


#read in data
samps<- read.table("stateCheck.txt", header = TRUE, sep = "\t" ,fill = TRUE, stringsAsFactors = FALSE)


head(samps)

colnames(samps) <- c("country", "state", "lat", "long")

#check data
head(samps$lat)

#clear new plot
plot.new()

#write to pdf file
pdf(file='PlantStateMap.pdf',height=10, width=10)

	map("worldHires","Canada", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE)  
	map("worldHires","Mexico", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
	map("worldHires","usa", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
	map("state", col="gray95", boundary = False, xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE, add=TRUE)
	box()

#loop through all unique taxon names and create a subset of lat/long data
for (x in unique(samps$state)) {
  samps.subset <- subset(samps, state == x)
  points(samps.subset$lon, samps.subset$lat, pch=19, col=rainbow(1)
         , cex=.3)
	}
	
#	points(samps$lon, samps$lat, pch=19, col = "blue", cex=.4)	# this will put all the points as blue, no matter what taxon
		
dev.off()
help(rainbow)

for (x in unique(samps$state)) {
  samps.subset <- subset(samps, state == x)
  
  pdf(file=paste(x,'.pdf',sep=""),height=10, width=10)
  map("worldHires","Canada", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE)  
  map("worldHires","Mexico", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
  map("worldHires","usa", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
  map("state", col="gray95", boundary = False, xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE, add=TRUE)
  box()
  #c = sample(colors(), 1) #random color
  points(samps.subset$lon, samps.subset$lat, pch=19, col="red"
         , cex=.3)
  
  dev.off()
}
help(map)

#simple lat/long scatter plot and check lat/long for north america

plot(samps)
subset(samps, samps$lat < 0)
subset(samps,samps$long > 0)

#=============================
#Clusters by state
attach(samps)
plot(samps$long,samps$lat)
