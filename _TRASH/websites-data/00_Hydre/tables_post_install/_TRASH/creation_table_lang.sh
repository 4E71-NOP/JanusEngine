#!/bin/bash
#
# Ce script va fabriquer les fichiers nécessaires pour la création des tables SQL pour la localisation
# Vous n'avez pas besoin d'utiliser ce script à moins d'être un développeur MWM
# La commande CP est utilisée pour palier les problemes d'empaquetage et pour être plus compatible avec les systèmes non unix (& unixlike)
#
# This script will make the necessairy file the engine needs to create the SQL table for localization.
# You don't need to use it unless you're a MWM developper
# The CP command is used to lower some problems like packaging and to be more compatible with non unix systems (& unixlike). 
#

clear

ARGV1=$1
LISTECIBLES=( aar abk ave afr aka amh arg ara asm ava aym aze bak bel bul -- bis bam ben bod bre bos cat che cha cos cre ces chu chv cym dan deu div dzo ewe ell eng epo spa est eus fas ful fin fij fao fra fry gle gla glg grn guj glv hau heb hin hmo hrv hat hun hye her ina ind ile ibo iii ipk ido isl ita iku jpn jav kat kon kik kua kaz kal khm kan kor kau kas kur kom cor kir lat ltz lug lim lin lao lit lub lav mlg mah mri mkd mal mon mol mar msa mlt mya nau nob nde nep ndo nld nno nor nbl nav nya oci oji orm ori oss pan pli pol pus por que rcf roh run ron rus kin san srd snd sme sag hbs sin slk slv smo sna som sqi srp ssw sot sun swe swa tam tel tgk tha tir tuk tgl tsn ton tur tso tat twi tah uig ukr urd uzb ven vie vol wln wol xho yid yor zha zho zul )
#LISTECIBLES=( aar abk -- )

cd tables_creation
rm tl_*.sql
cd ..
for FICHIER in "${LISTECIBLES[@]}"
do
	cp -v tl__uni.sql tables_creation/tl_$FICHIER.sql
done

date
echo "fin"
