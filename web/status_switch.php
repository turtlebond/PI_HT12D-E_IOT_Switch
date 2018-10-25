<?php

$host="localhost";
$user="mog";
$passwd="123456";
$dB="my_db";

$z=array();
$val=$_GET['val'];
$table="switch";


$con=mysqli_connect($host,$user,$passwd,$dB) or die('Could not connect: ' . mysqli_error($con));


mysqli_select_db($con,$dB);


$sql="SELECT $val FROM $table";
$result = mysqli_query($con,$sql);

$num_rows = mysqli_num_rows($result);
array_push($z,$num_rows);


while($row = mysqli_fetch_array($result)){ 
if ($val == "description,id,auto_en,auto_on,auto_off,auto_en2,auto_on2,auto_off2,auto_day,auto_day2")
	array_push($z,$row['description'],$row['id'],$row['auto_en'],$row['auto_on'],$row['auto_off'],$row['auto_en2'],$row['auto_on2'],$row['auto_off2'],$row['auto_day'],$row['auto_day2']);
elseif ($val=="id,value,description,enable")
	array_push($z,$row['id'],$row['value'],$row['description'],$row['enable']);
	//$z[]=$row['name'];
	//$z[]=$row['value'];
}

echo json_encode($z);

mysqli_free_result($result);

mysqli_close($con);

?>

