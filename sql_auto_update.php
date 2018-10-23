<?php

$host="localhost";
$user="mog";
$passwd="123456";
$dB="my_db";
$table="switch";

$z=array();
$value=array();

$opt=$_GET['opt'];
$id=$_GET['id'];
$tOn=$_GET['tOn'];
$tOff=$_GET['tOff'];
$tOn2=$_GET['tOn2'];
$tOff2=$_GET['tOff2'];
$Day=$_GET['Day'];
$DayOLD=$_GET['DayOLD'];
$Day2=$_GET['Day2'];
$Day2OLD=$_GET['Day2OLD'];

/*
echo "id=$id<br>";
echo "opt=$opt<br>";
echo "tOn=$tOn<br>";
echo "tOFf=$tOff<br>";
echo "tOn2=$tOn2<br>";
echo "tOFf2=$tOff2<br>";
echo "Day=$Day<br>";
echo "Day2=$Day2<br>";
echo "Day=$Day<br>";
echo "Day2=$Day2<br>";
*/

$con=mysqli_connect($host,$user,$passwd,$dB) or die('Could not connect: ' . mysqli_error($con));

mysqli_select_db($con,$dB);

if($opt==0)
$sql = "UPDATE $table SET auto_en=0 WHERE id='$id'";
else if($opt==1)
$sql = "UPDATE $table SET auto_en=1,auto_on='$tOn',auto_off='$tOff',auto_day='$Day' WHERE id='$id'";
else if($opt==2)
$sql = "UPDATE $table SET auto_en=1,auto_en2=1,auto_on='$tOn',auto_off='$tOff',auto_day='$Day',auto_on2='$tOn2',auto_off2='$tOff2',auto_day2='$Day2' WHERE id='$id'";
else if($opt==3)
$sql = "UPDATE $table SET auto_en2=0 WHERE id='$id'";
else if($opt==4)
$sql = "UPDATE $table SET auto_en=0,auto_en2=0 WHERE id='$id'";

if (mysqli_query($con, $sql)) {
    echo "Record updated successfully\n";
} else {
    echo "Error updating record: " . mysqli_error($con);
}



mysqli_close($con);

?>
