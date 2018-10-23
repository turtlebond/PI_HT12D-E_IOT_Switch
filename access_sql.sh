#!/bin/bash
#used for intialize the signal as in db after restart

user="mog";
pwd="123456";
db="my_db";
table="switch";

gpio="/usr/local/bin/gpio"

wPiD0=0
wPiD1=1
wPiD2=2
wPiD3=3
wPiA0=4
wPiA1=5
wPiA2=6
wPiTE=7

_adds=;
length=0

for var in {0..7}
do
        $gpio mode $var out;
done

#$gpio write $wPiTE 1;

function write_pin() {
	bcd=`echo $(( ($1 / 10 << 4) + ($1 % 10) ))`
	add0=`echo $(( ($bcd & 1) / 1 ))`;
	add1=`echo $(( ($bcd & 2) / 2 ))`;
	add2=`echo $(( ($bcd & 4) / 4 ))`;
#	echo "add=$1,bcd=$bcd,add0=$add0, add1=$add1,add2=$add2";
	$gpio write $wPiA0 $add0;
	$gpio write $wPiA1 $add1;
	$gpio write $wPiA2 $add2; 

	read -ra data <<< $(mysql -D $db -u $user -p$pwd -se "SELECT data FROM $table where address=$add")
	for d in "${data[@]}"; do
		read -r value <<< $(mysql -D $db -u $user -p$pwd -se "SELECT value FROM $table where address=$add and data=$d")
#		echo "data=$d,value=$value"
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

}

read -ra adds <<< $(mysql -D $db -u $user -p$pwd -se "SELECT address FROM $table")
for add in "${adds[@]}"; do
#	echo "add=$add"	
	add_found=0
	if [ -z "$_adds" ] 
	then
		_adds[0]=$add
		write_pin $add
		
	else 
		for z in "${_adds[@]}"; do
			if [ "$z" -eq "$add" ] 
			then
				add_found=1
			fi				
		done

		if [ $add_found != 1 ]
		then
			length=${#_adds[@]}
			_adds[$length]=$add
			write_pin $add	
		fi
	fi

done




exit 0
