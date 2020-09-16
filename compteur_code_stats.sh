#!/bin/sh
clear
> compteurs.txt
echo "Répertoire current"
find current/ -name "*.php" -exec wc -l '{}' \; >> compteurs.txt
echo "Répertoire modules"
find modules/ -name "*.php" -exec wc -l '{}' \; >> compteurs.txt
echo "Répertoire extensions"
find extensions/ -name "*.php" -exec wc -l '{}' \; >> compteurs.txt
echo "Répertoire Website-datas"
find websites-data/ -name "*.php" -exec wc -l '{}' \; >> compteurs.txt
echo "Répertoire Stylesheets"
find stylesheets/ -name "*.php" -exec wc -l '{}' \; >> compteurs.txt
total=`cat compteurs.txt | awk '{sum +=$1} END {print sum}'` 
echo "Nombre de ligne : $total"
