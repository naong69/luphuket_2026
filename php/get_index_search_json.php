<?php
include('connect.php');

$json_str = "";
	$sql = "SELECT `indexID`, `oper_prod_name_sub`,`group_name` FROM `all_index`";
	if ($result=mysqli_query($link,$sql)){
	  // Fetch one and one row
	  while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{ "indexID":"'.$row[0].'","oper_prod_name_sub":"'.$row[1].'","group_name":"'.$row[2].'"},';
	  }
	  // Free result set
	  mysqli_free_result($result);
	}
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;

/* close connection */
mysqli_close($link);
?>
