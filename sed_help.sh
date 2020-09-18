#/bin/sh 
echo "--------------------------------------------------------------------------------"
echo sed -i 's/old-text/new-text/g' input.txt
echo "--------------------------------------------------------------------------------"
ARGV1=$1
ARGV1=$2
DATE_JOUR=`date "+%Y%m%d-%Hh%M"`
FILE_LIST=`grep -Grsl $1 --exclude-dir=current *`

STR="s/"$1"/"$2"/g"
echo $STR

for FILE in $FILE_LIST 
do 
    echo "replacing " $1 " with " $2 " in " $FILE "..."
    sed -i $STR $FILE
done
echo "--------------------------------------------------------------------------------"
echo ""
echo ""
echo ""
echo ""
echo ""
