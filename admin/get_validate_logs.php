<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

$time = $_REQUEST['time'];
// start query
$json_str = "";

if($time == 'a'){
	$sql = "SELECT `validate_logs`.*, `all_index`.`category_name`, `all_index`.`group_name_sub`, `all_index`.`oper_prod_name_sub` FROM `validate_logs` LEFT JOIN `all_index` ON `validate_logs`.`build_up_index` = `all_index`.`indexID` ORDER BY `validate_logs`.`time_stamp` DESC";
} else {
	$sql = "SELECT `validate_logs`.*, `all_index`.`category_name`, `all_index`.`group_name_sub`, `all_index`.`oper_prod_name_sub` FROM `validate_logs` LEFT JOIN `all_index` ON `validate_logs`.`build_up_index` = `all_index`.`indexID` WHERE `validate_logs`.`time_stamp` BETWEEN DATE_ADD(NOW(), INTERVAL - ".$time." DAY) AND NOW() ORDER BY `validate_logs`.`time_stamp` DESC";
}

if ($result=mysqli_query($link,$sql)){
	while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"time_stamp":"'.$row[1].'","os":"'.$row[2].'","browser":"'.$row[3].'","ip":"'.$row[4].'","coor_xy":"'.$row[5].'","build_up_index":"'.$row[6].'","category_name":"'.$row[7].'","group_name_sub":"'.$row[8].'","oper_prod_name_sub":"'.$row[9].'"},';
	}
	// Free result set
	mysqli_free_result($result);
	
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
} else 

mysqli_close($link);
}
?>
