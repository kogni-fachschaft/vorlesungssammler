default: html
list:
	python3 analyser.py
plot: 
	Rscript plot.R
	convert output/frequency.pdf output/frequency.png
html: list plot
	pandoc output/liste.md -o output/liste.html --template template/template.html --css template/template.css --self-contained --toc --toc-depth 2	

.PHONY: list plot default 
