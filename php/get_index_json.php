<?php
include('connect.php');

$json_str = "";
	$sql = "SELECT * FROM `all_index`";
	if ($result=mysqli_query($link,$sql)){
	  // Fetch one and one row
	  while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{ "indexID":"'.$row[0].'",
								 "category_index":"'.$row[1].'",
								 "category_name":"'.$row[2].'",
								 "group_index":"'.$row[3].'",
								 "group_name_sub":"'.$row[4].'",
								 "group_name":"'.$row[5].'",
								 "oper_prod_index":"'.$row[6].'",
								 "oper_prod_name_sub":"'.$row[7].'",
								 "oper_prod_name":"'.$row[8].'",
								 "oper_prod_name_dec":"'.$row[9].'"
								},';
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
