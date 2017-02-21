dat <- read.csv("data/frequencies.csv")

# Plot Bachelor
pdf("output/bachelor.pdf")
barplot(dat[dat$abschluss == "bachelor",]$frequency, main="Wünsche Bachelor nach Modul")
axis(1, labels=c("Philospohie", "Linguistik", "Informatik", "Kognitionswissenschaft"), at=c(.7,1.9,3.1,4.3))
dev.off()

pdf("output/master.pdf")
barplot(dat[dat$abschluss == "master",]$frequency, main="Wünsche Master nach Modul")
axis(1, labels=c("Informatik", "Neurowissenschaft", "Psychologie", "Linguistik und Philosophie"), at=c(.7,1.9,3.1,4.3))
dev.off()
