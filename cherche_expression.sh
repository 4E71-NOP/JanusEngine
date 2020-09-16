#!/bin/bash
clear
ARGV1=$1
LISTECIBLES=(modules version_actuelle websites-data)

for REPERTOIRE in "${LISTECIBLES[@]}"
do
	echo -e "\n\e[46m\e[1mRecherche:"$ARGV1" dans "$REPERTOIRE"\e[21m\e[49m\e[39m"
	grep -Ganrsl $ARGV1 --exclude-dir="vrs_20*" --exclude-dir="__help__ aide__ayuda__" --exclude-dir="graph" --exclude-dir="download" --exclude="*.jpg" --exclude="*.gif" --exclude="*.png" * | grep $REPERTOIRE"/"
done

DATE=`date`
echo -e "\n\e[37m"$DATE
echo -e "fin\e[49m\e[39m"

