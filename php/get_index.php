<?php
include('connect.php');

//$_POST['cat'] = 'L';
//$_POST['group'] = '001';
if(isset($_POST['cat']) && !isset($_POST['group'])){
	$json_str = "";
	$sql = "SELECT DISTINCT `group_index`, `group_name_sub` FROM `all_index` WHERE `category_index` = '".$_POST['cat']."'";
	if ($result=mysqli_query($link,$sql)){
	  // Fetch one and one row
	  while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"group_index":"'.$row[0].'","group_name_sub":"'.$row[1].'"},';
	  }
	  // Free result set
	  mysqli_free_result($result);
	}
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

if(isset($_POST['cat']) && isset($_POST['group'])){
	$json_str = "";
	$sql = "SELECT `indexID`, `oper_prod_index`, `oper_prod_name_sub` FROM `all_index` WHERE `group_index` = '".$_POST['group']."' AND `category_index` = '".$_POST['cat']."'";
	if ($result=mysqli_query($link,$sql)){
	  // Fetch one and one row
	  while ($row=mysqli_fetch_row($result)){
		$json_str = $json_str.'{"indexID":"'.$row[0].'","oper_prod_index":"'.$row[1].'","oper_prod_name_sub":"'.$row[2].'"},';
	  }
	  // Free result set
	  mysqli_free_result($result);
	}
	$json_str = substr($json_str, 0, -1);
	$json_str = '['.$json_str.']';
	echo $json_str;
}

/* close connection */
mysqli_close($link);
?>
