#/bin/sh 
echo "--------------------------------------------------------------------------------"
echo sed -i 's/old-text/new-text/g' input.txt
echo "--------------------------------------------------------------------------------"

ARGV1=$1
ARGV1=$2
DATE_JOUR=`date "+%Y%m%d-%Hh%M"`
FILE_LIST=`grep -Grsl $1 *`
echo $FILE_LIST

for FILE in $FILE_LIST 
do 
    echo "->" $FILE " " $DATE_JOUR
done