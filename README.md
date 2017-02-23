# Vorlesungssammler

Ein in PHP-geschriebenes Skript zum sammeln der Veranstaltungen, welche für den Studiengang Kognitionswissenschaft importiert werden sollen.

### Benutzung
Im Ordner `www/` befindet sich ein php-Skript `index.php`, welches entsprechend auf einem Server platziert werden muss.  

Im Ordner `auswertung/` befindet sich ein Python-Skript `analyser.py` welches aus den eingereichten Veranstaltungen eine Markdown Datei und eine CSV Datei mit den Häufigkeiten generiert. Mit dem R Skript `plot.R` lassen sich diese Häufigkeiten grafisch darstellen. Es besteht außerdem die Möglichkeit aus der Markdown Datei mittels `pandoc` eine HTML Datei zu erzeugen. Dazu sollte man allerdings ein Template benutzen.

Hierzu kann man beispielsweise ein [fertiges Template](https://github.com/tonyblundell/pandoc-bootstrap-template) verwenden. Der einfachste Weg ist das Repository in den Ordner auswertung zu clonen:
```
git clone path/to/repository auswertung/template
```
Um alle Funktionen des Makefiles nutzen zu können muss man die Pakete `pandoc`, `imagemagick`, `r-base` und `python3` installiert haben. Falls man diese noch nicht installiert hat, kann man sie mittels
```
sudo apt-get install pandoc imagemagick r-base python3
```
installieren. Anschließend kann man im Ordner `auswertung/` mit den Befehlen `make list`, `make plot`, `make html`, die Markdown Datei, den Plot oder die HTML Datei erzeugen.
