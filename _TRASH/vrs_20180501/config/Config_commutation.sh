#!/bin/bash
clear
ARGV1=$1

LISTECIBLES=( 2 3 )

for NBR in "${LISTECIBLES[@]}"
do
	rm "site_"$NBR"_config_mwm.php"
	ln -s "site_"$NBR"_config_mwm("$ARGV1").php" "site_"$NBR"_config_mwm.php"
done

ls -al
DATE=`date`
echo -e "\n\e[37m"$DATE
echo -e "fin\e[49m\e[39m"

