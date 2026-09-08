<?php
include('connect.php');

$json_str = "";
	$sql = "SELECT `build_up_index`, count(*) as C FROM `validate_logs` WHERE `build_up_index` != 'All' GROUP BY `build_up_index`ORDER BY C DESC LIMIT 10";
	if ($result=mysqli_query($link,$sql)){
	  // Fetch one and one row
	  while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{ "indexID":"'.$row[0].'","count":"'.$row[1].'"},';
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
