dat <- read.csv("data/frequencies.csv")

pdf("output/frequency.pdf", width=10, height=4)
par(mfrow=c(1,2), oma=c(0,0,2,0))

# Plot Bachelor
barplot(dat[dat$abschluss == "bachelor",]$frequency, 
        main="Bachelor", 
        axes=FALSE, 
        ylim=c(0, 1.2 * max(dat$frequency)), 
        cex.lab=.7, 
        cex.main=.8)
axis(2, 
     cex.axis=.5)
mtext("Anzahl",side=2, line=2, cex=.7)
axis(1, 
     labels=c("Philospohie", "Linguistik", "Informatik", "Kognitionswissenschaft"),
     at=c(.7,1.9,3.1,4.3), 
     cex.axis=.5)
mtext("Modul",side=1, line=2, cex=.7)
box()

#Plot Master
barplot(dat[dat$abschluss == "master",]$frequency, 
        main="Master", 
        axes=FALSE, 
        ylim=c(0, 1.2 * max(dat$frequency)), 
        cex.lab=.7, 
        cex.main=.8)
axis(2, 
     cex.axis=.5)
mtext("Anzahl",side=2, line=2, cex=.7)
axis(1, 
     labels=c("Informatik", "Neurowissenschaft", "Psychologie", "Linguistik und Philosophie"), 
     at=c(.7,1.9,3.1,4.3), 
     cex.axis=.5)
mtext("Modul",side=1, line=2, cex=.7)
box()

title("\nAnzahl Wünsche nach Studiengang und Modul", 
      outer = TRUE )
mtext(format(Sys.Date(), 
      format="(Stand: %d.%m.%Y)"),
      side=3,line=-1.3, 
      outer=TRUE, 
      cex=.8)

dev.off()
