from urllib.request import urlretrieve as download
import re
import numpy as np
import pandas as pd
import math
import os

URL = "http://sandbox.fsi.uni-tuebingen.de/~marc/vorlesungssammler/vorlesungen.txt"
ROOT = os.path.join(".")
DATA = os.path.join(ROOT, "data")
OUTPUT = os.path.join(ROOT, "output")

FILE_PATH = os.path.join(DATA, "vorlesungen.txt")

# Create directories if they don't exist yet
if not os.path.isdir(DATA):
    os.makedirs(DATA)
if not os.path.isdir(OUTPUT):
    os.makedirs(OUTPUT)

# Download file from Sandbox
download(URL, FILE_PATH)

# Load file to pandas DataFrame
vorlesungen = pd.read_csv(FILE_PATH, sep=";")

# Extract Ids of lectures
ids = [id_ for id_ in [re.findall(r'\d+', link) for link in vorlesungen.Url if link]]
ids = [item for sublist in ids for item in sublist]
vorlesungen["Ids"] = ids

# Moduls and identifiers
bachelor = [("Pflichtmodul Philosophie", "pphilobsc"),
            ("Pflichtmodul Linguistik", "plingubsc"),
            ("Wahlpflichtmodul Informatik", "wpinfobsc"),
            ("Wahlpflichtmodul Kognitionswissenschaft", "wpkognibsc")]

master = [("Kognitive Informatik", "koginfmsc"),
          ("Kognitive Neurowissenschaft", "kogneuromsc"),
          ("Kognitionspsychologie", "kogpsychmsc"),
          ("Linguistik und Philosophie", "koglingmsc")]

# Calculate frequencies of submissions
with open(os.path.join(DATA, "frequencies.csv"), "w") as f:
    f.write("modulname,abschluss,frequency\n")
    print("Anzahl Bachelorveranstaltungen nach Bereich:")
    for name, bereich in bachelor:
        frequency = len(set(vorlesungen[vorlesungen.Bereich == bereich].Ids))
        f.write("{},{},{}\n".format(name, "bachelor", frequency))
        print("    {}: {}".format(name, frequency))
    print()
    print("Anzahl Masterveranstaltungen nach Bereich:")
    for name, bereich in master:
        frequency = len(set(vorlesungen[vorlesungen.Bereich == bereich].Ids))
        f.write("{},{},{}\n".format(name, "master", frequency))
        print("    {}: {}".format(name, frequency))
    print()


def veranstaltungen_to_text(abschluss):
    """
    Generates a text output of all lectures

    Args:
        abschluss: list of tuble of (name, identifier)
    Return:
        file_text: text to be written into a file
    """
    file_text = ""
    for name, bereich in abschluss:
        print("Processing lectures for {}".format(name))
        ids_ = set(vorlesungen[vorlesungen.Bereich == bereich].Ids)
        if len(ids_) == 0:
            continue
        file_text += "### {}:\n".format(name)
        # file_text += "-" * (len(name) + 1) + "\n"
        for id_ in ids_:
            vorlesungen_modul = vorlesungen[vorlesungen.Bereich == bereich]
            vorlesung = vorlesungen_modul[vorlesungen_modul.Ids == id_]
            file_text += "#### {}\n".format(list(vorlesung.Titel)[0])
            file_text += "**Dozent:** {}  \n\n".format(list(vorlesung.Dozent)[0])
            file_text += "**Campus:** [{}]({})  \n\n".format(list(vorlesung.Url)[0], list(vorlesung.Url)[0])
            comments = [comment for comment in vorlesung.Bemerkung if isinstance(comment, str)]
            if len(comments) != 0:
                file_text += "**Bemerkungen:**  \n\n"
                for comment in vorlesung.Bemerkung:
                    if isinstance(comment, str):
                        file_text +="> {}  \n\n".format(comment)
            file_text += "\n"
    return file_text


with open(os.path.join(OUTPUT, "liste.md"), "w") as f:
    f.write("# Veranstaltungen SoSe 2017\n")
    f.write("![](output/frequency.png)  \n\n")
    # Generate list for bachelor lectures
    print("Processing lectures for bachelor")
    f.write("## Bachelor  \n")
    # f.write("=================================\n")
    f.write("\n")
    f.write(veranstaltungen_to_text(bachelor))
    print("List for bachelor modules generated and saved in {}.".format(os.path.join(OUTPUT, "liste.md")))

    # Generate list for master lectures
    print("Processing lectures for master")
    f.write("## Master  \n")
    # f.write("===============================\n")
    f.write("\n")
    f.write(veranstaltungen_to_text(master))
    print("List for master modules generated and saved in {}.".format(os.path.join(OUTPUT, "liste.md")))
