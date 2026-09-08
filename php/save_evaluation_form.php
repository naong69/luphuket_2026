<?php

if(isset($_REQUEST['group'])){

include('connect.php');

$group = $_REQUEST['group'];
$q1 = $_REQUEST['q1'];
$q2 = $_REQUEST['q2'];
$q3 = $_REQUEST['q3'];
$q4 = $_REQUEST['q4'];

$datetime = date("Y-m-d H:i:s");
$utc = new DateTime($datetime, new DateTimeZone('UTC'));
$utc->setTimezone(new DateTimeZone('Asia/Bangkok'));
$time_stamp = $utc->format('Y-m-d H:i:s');

$strSQL = "INSERT INTO `evaluation` (`group`, `q1`, `q2`, `q3`, `q4`, `time_stamp`) VALUES (".$group.",".$q1.",".$q2.",".$q3.",".$q4.",'".$time_stamp."')";
$objQuery = mysqli_query($link, $strSQL);
//$objResult = mysqli_fetch_array($objQuery);

mysqli_close($link);
}
?>