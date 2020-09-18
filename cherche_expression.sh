#!/bin/bash
clear
# ARGV1=$1
TARGETS=(extensions modules current websites-data)

for T in "${TARGETS[@]}"
do
	echo -e "\n\e[46m\e[1mRecherche:\`"$1"\` dans "$T"\e[21m\e[49m\e[39m\e[m"
	grep -Grsl $1 \
		--exclude="*.jpg" \
		--exclude="*.gif" \
		--exclude="*.png" \
		$T
done

DATE=`date`
echo -e "\n\e[37m"$DATE
echo -e "fin\e[49m\e[39m\e[m"

#		--exclude-dir="vrs_2*" &&
#		--exclude-dir="__help__ aide__ayuda__" &&
#		--exclude="DeveloperDocs" &&
#		--exclude="extensions" &&
#		--exclude-dir="graph" &&
#		--exclude-dir="download" &&
# 		* | grep $T"/"
