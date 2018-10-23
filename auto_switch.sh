#!/bin/bash

gpio="/usr/local/bin/gpio"
user="mog";
pwd="123456";
db="my_db";
table="switch";

wPiD0=0
wPiD1=1
wPiD2=2
wPiD3=3
wPiA0=4
wPiA1=5
wPiA2=6
wPiTE=7


for var in {0..7}
do
        $gpio mode $var out;
done

$gpio write $wPiTE 1;

	while getopts i:v: opt
	do
		case $opt in
		  i)id=$OPTARG;;
		  v)val=$OPTARG;;
		  *)echo "Invalid arg";;
		esac
	done
	
	shift $((OPTIND - 1))

	if [[ -z $id ]]
	then
	echo "Please provide id value"
	exit 1;
	fi

	if [[ -z $val ]]
	then
	echo "Please provide value to overwrite"
	exit 1;
	fi

	mysql -D $db -u $user -p$pwd -se "update switch set value=$val where id=$id"
	read -r add <<< $(mysql -D $db -u $user -p$pwd -se "SELECT address FROM $table where id=$id")
#	echo "add=$add";
	bcd=`echo $(( ($add / 10 << 4) + ($add % 10) ))`
#	echo "bcd=$bcd";
	add0=`echo $(( ($bcd & 1) / 1 ))`;
	add1=`echo $(( ($bcd & 2) / 2 ))`;
	add2=`echo $(( ($bcd & 4) / 4 ))`;
#	echo "add0=$add0, add1=$add1,add2=$add2";
	$gpio write $wPiA0 $add0;
	$gpio write $wPiA1 $add1;
	$gpio write $wPiA2 $add2; 

	read -ra data <<< $(mysql -D $db -u $user -p$pwd -se "SELECT data FROM $table where address=$add")
	
	for d in "${data[@]}"; do
#		echo "data=$d";
		read -r value <<< $(mysql -D $db -u $user -p$pwd -se "SELECT value FROM $table where address=$add and data=$d")
#		echo "data=$d  value=$value"
		case $d in
			0) $gpio write $wPiD0 $value;;
			1) $gpio write $wPiD1 $value;;
			2) $gpio write $wPiD2 $value;;
			3) $gpio write $wPiD3 $value;;
			*) ;;
		esac	
	done
	$gpio write $wPiTE 0
	sleep 1
	$gpio write $wPiTE 1

	
      

exit 0
