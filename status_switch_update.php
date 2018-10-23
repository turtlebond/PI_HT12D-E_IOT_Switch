<?php

$host="localhost";
$user="mog";
$passwd="123456";
$dB="my_db";

$z=array();
$value=array();

$val=$_GET['val'];
$id=$_GET['id'];

$table="switch";


$con=mysqli_connect($host,$user,$passwd,$dB) or die('Could not connect: ' . mysqli_error($con));

mysqli_select_db($con,$dB);


$sql = "UPDATE $table SET value=$val WHERE id=$id";


if (mysqli_query($con, $sql)) {
    echo "Record updated successfully\n";
} else {
    echo "Error updating record: " . mysqli_error($con);
}

//get address from the database to set

$sql= "SELECT address FROM $table WHERE id=$id";
$result = mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);
$address=$row['address'];

//get the values for the data line 0-3
for ( $i=0; $i<4; $i++){
	$sql= "SELECT value FROM $table WHERE address=$address and data=$i";
	$result = mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	array_push($value,$row['value']);
}

mysqli_close($con);

//set corresponding pin number based on wiringPI
$TEpin=7;
$ADDpin0=4;
$ADDpin1=5;
$ADDpin2=6;
$DATApin0=0;
$DATApin1=1;
$DATApin2=2;
$DATApin3=3;

$bcd=(($address / 10) << 4) + ($address % 10) ;
$add0= ($bcd & 1) / 1;
$add1= ($bcd & 2) / 2;
$add2= ($bcd & 4) / 4;
//$add3= ($bcd & 8) / 8;
//$add4= ($bcd & 16) / 16;
//$add5= ($bcd & 32) / 32;
//$add6= ($bcd & 64) / 64;
//$add7= ($bcd & 128) / 128;


//set pins to output
exec("gpio mode $TEpin out");
exec("gpio mode $DATApin out");
exec("gpio mode $ADDpin0 out");
exec("gpio mode $ADDpin1 out");
exec("gpio mode $ADDpin2 out");

exec("gpio write $TEpin 1");

//set address
exec("gpio write $ADDpin2 $add2");
exec("gpio write $ADDpin1 $add1");
exec("gpio write $ADDpin0 $add0");

//set data
exec("gpio write $DATApin0 $value[0]");
exec("gpio write $DATApin1 $value[1]");
exec("gpio write $DATApin2 $value[2]");
exec("gpio write $DATApin3 $value[3]");

//enable trasnmission
exec("gpio write $TEpin 0");
sleep (1);

//disable transmission
exec("gpio write $TEpin 1");


?>

