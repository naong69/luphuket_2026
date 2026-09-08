<?php

if(isset($_REQUEST['email'])){

include('connect.php');

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$subject = $_REQUEST['subject'];
$message = $_REQUEST['message'];

$datetime = date("Y-m-d H:i:s");
$utc = new DateTime($datetime, new DateTimeZone('UTC'));
$utc->setTimezone(new DateTimeZone('Asia/Bangkok'));
$time_stamp = $utc->format('Y-m-d H:i:s');

$strSQL = "INSERT INTO `feedbacks` (`name`, `email`, `subject`, `message`, `time_stamp`) VALUES ('".$name."','".$email."','".$subject."','".$message."','".$time_stamp."')";
$objQuery = mysqli_query($link, $strSQL);
//$objResult = mysqli_fetch_array($objQuery);

mysqli_close($link);
}
	
?>