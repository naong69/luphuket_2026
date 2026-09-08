<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

$time = $_REQUEST['time'];
// start query
$json_str = "";

if($time == 'a'){
	$sql = "SELECT * FROM `feedbacks`";
} else {
	$sql = "SELECT * FROM `feedbacks` WHERE `time_stamp` BETWEEN DATE_ADD(NOW(), INTERVAL -".$time." DAY) AND NOW()";
} 
if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"id":"'.$row[0].'","name":"'.$row[1].'","email":"'.$row[2].'","subject":"'.$row[3].'","message":"'.str_replace(array("\n", "\r", '"'), ' ', $row[4]).'","datetime":"'.$row[5].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

mysqli_close($link);
}
?>
