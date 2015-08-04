#Mapping of time series of all arthropod collecting events
#@seltmann

#May 1 2014


#check library
library(maps)
library(mapdata)

#clear new plot
plot.new()

#read in data
samps <- read.table("mapping/localitiesGraph.txt")
head(samps)
colnames(samps) <- c("long","lat")

#check data
head(samps$lat)

#write to pdf file
pdf(file='MiridaeState.pdf',height=10, width=10)

	map("worldHires","Canada", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE)  
	map("worldHires","Mexico", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
	map("worldHires","usa", col="gray90", xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE,add=TRUE)
	map("state", col="gray95", boundary = False, xlim = range(samps$lon), ylim = range(samps$lat),fill=TRUE, add=TRUE)
	box()

#loop through all unique taxon names and create a subset of lat/long data
for (x in unique(samps$state)) {
	samps.subset <- subset(samps, state == x)
	c = sample(colors(), 1) #random color
	points(samps.subset$lon, samps.subset$lat, pch=19, col=c
, cex=.3)
	}
	
#	points(samps$lon, samps$lat, pch=19, col = "blue", cex=.4)	# this will put all the points as blue, no matter what taxon
		
dev.off()
help(rect)


#simple lat/long scatter plot and check lat/long for north america

plot(samps)
subset(samps, samps$lat < 0)
subset(samps,samps$long > 0)
