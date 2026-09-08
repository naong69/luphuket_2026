<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

// start query

$colorArray = array("#FF6384", "#983ef2", "#f44242", "#36A2EB", "#3ef27a","#FFCE56", "#ff8000", "#ffff00" ,"#ff4000", "#40ff00", "#bf00ff");

if(isset($_REQUEST['time'])){
	
	$time = $_REQUEST['time'];

	// get user group
	$user_count = "";
	$user_color = "";
	$user_label = "";

	$sql = "SELECT `group` AS g, count(*) AS count FROM `evaluation` GROUP BY `group` ";

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$user_count = $user_count.$row[1].",";
			
			if($row[0] == 0) {
				$user_label = $user_label.'"ไม่ระบุ",';
				$user_color = $user_color.'"#FF6384",';
			}
			if($row[0] == 1) {
				$user_label = $user_label.'"ประชาชนทั้วไป",';
				$user_color = $user_color.'"#983ef2",';
			}
			if($row[0] == 2) {
				$user_label = $user_label.'"ภาคเอกชน",';
				$user_color = $user_color.'"#f44242",';
			}
			if($row[0] == 3) {
				$user_label = $user_label.'"เจ้าหน้าที่รัฐ",';
				$user_color = $user_color.'"#36A2EB",';
			}
			
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$user_count = substr($user_count,0,-1);
	$user_count = "[".$user_count."]";
	$user_color = substr($user_color,0,-1);
	$user_color = "[".$user_color."]";
	$user_label = substr($user_label,0,-1);
	$user_label = "[".$user_label."]";
	$json_str_user = '{"count" : '.$user_count.', "color" : '.$user_color.', "label" : '.$user_label.'}';


	// get rank1
	$rank1_count = "";
	$rank1_color = "";
	$rank1_label = "";

	$sql = "SELECT `q1` AS g, count(*) AS count FROM `evaluation` GROUP BY `q1` ";

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$rank1_count = $rank1_count.$row[1].",";
			
			if($row[0] == 0) {
				$rank1_label = $rank1_label.'"ไม่ระบุ",';
				$rank1_color = $rank1_color.'"#FF6384",';
			}
			if($row[0] == 1) {
				$rank1_label = $rank1_label.'"น้อยที่สุด",';
				$rank1_color = $rank1_color.'"#983ef2",';
			}
			if($row[0] == 2) {
				$rank1_label = $rank1_label.'"น้อย",';
				$rank1_color = $rank1_color.'"#f44242",';
			}
			if($row[0] == 3) {
				$rank1_label = $rank1_label.'"ปานกลาง",';
				$rank1_color = $rank1_color.'"#36A2EB",';
			}
			if($row[0] == 4) {
				$rank1_label = $rank1_label.'"มาก",';
				$rank1_color = $rank1_color.'"#3ef27a",';
			}
			if($row[0] == 5) {
				$rank1_label = $rank1_label.'"มากที่สุด",';
				$rank1_color = $rank1_color.'"#FFCE56",';
			}
			
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$rank1_count = substr($rank1_count,0,-1);
	$rank1_count = "[".$rank1_count."]";
	$rank1_color = substr($rank1_color,0,-1);
	$rank1_color = "[".$rank1_color."]";
	$rank1_label = substr($rank1_label,0,-1);
	$rank1_label = "[".$rank1_label."]";
	$json_str_rank1 = '{"count" : '.$rank1_count.', "color" : '.$rank1_color.', "label" : '.$rank1_label.'}';
	
	
	// get rank2
	$rank2_count = "";
	$rank2_color = "";
	$rank2_label = "";

	$sql = "SELECT `q2` AS g, count(*) AS count FROM `evaluation` GROUP BY `q2` ";

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$rank2_count = $rank2_count.$row[1].",";
			
			if($row[0] == 0) {
				$rank2_label = $rank2_label.'"ไม่ระบุ",';
				$rank2_color = $rank2_color.'"#FF6384",';
			}
			if($row[0] == 1) {
				$rank2_label = $rank2_label.'"น้อยที่สุด",';
				$rank2_color = $rank2_color.'"#983ef2",';
			}
			if($row[0] == 2) {
				$rank2_label = $rank2_label.'"น้อย",';
				$rank2_color = $rank2_color.'"#f44242",';
			}
			if($row[0] == 3) {
				$rank2_label = $rank2_label.'"ปานกลาง",';
				$rank2_color = $rank2_color.'"#36A2EB",';
			}
			if($row[0] == 4) {
				$rank2_label = $rank2_label.'"มาก",';
				$rank2_color = $rank2_color.'"#3ef27a",';
			}
			if($row[0] == 5) {
				$rank2_label = $rank2_label.'"มากที่สุด",';
				$rank2_color = $rank2_color.'"#FFCE56",';
			}
			
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$rank2_count = substr($rank2_count,0,-1);
	$rank2_count = "[".$rank2_count."]";
	$rank2_color = substr($rank2_color,0,-1);
	$rank2_color = "[".$rank2_color."]";
	$rank2_label = substr($rank2_label,0,-1);
	$rank2_label = "[".$rank2_label."]";
	$json_str_rank2 = '{"count" : '.$rank2_count.', "color" : '.$rank2_color.', "label" : '.$rank2_label.'}';
	

	// get rank3
	$rank3_count = "";
	$rank3_color = "";
	$rank3_label = "";

	$sql = "SELECT `q3` AS g, count(*) AS count FROM `evaluation` GROUP BY `q3` ";

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$rank3_count = $rank3_count.$row[1].",";
			
			if($row[0] == 0) {
				$rank3_label = $rank3_label.'"ไม่ระบุ",';
				$rank3_color = $rank3_color.'"#FF6384",';
			}
			if($row[0] == 1) {
				$rank3_label = $rank3_label.'"น้อยที่สุด",';
				$rank3_color = $rank3_color.'"#983ef2",';
			}
			if($row[0] == 2) {
				$rank3_label = $rank3_label.'"น้อย",';
				$rank3_color = $rank3_color.'"#f44242",';
			}
			if($row[0] == 3) {
				$rank3_label = $rank3_label.'"ปานกลาง",';
				$rank3_color = $rank3_color.'"#36A2EB",';
			}
			if($row[0] == 4) {
				$rank3_label = $rank3_label.'"มาก",';
				$rank3_color = $rank3_color.'"#3ef27a",';
			}
			if($row[0] == 5) {
				$rank3_label = $rank3_label.'"มากที่สุด",';
				$rank3_color = $rank3_color.'"#FFCE56",';
			}
			
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$rank3_count = substr($rank3_count,0,-1);
	$rank3_count = "[".$rank3_count."]";
	$rank3_color = substr($rank3_color,0,-1);
	$rank3_color = "[".$rank3_color."]";
	$rank3_label = substr($rank3_label,0,-1);
	$rank3_label = "[".$rank3_label."]";
	$json_str_rank3 = '{"count" : '.$rank3_count.', "color" : '.$rank3_color.', "label" : '.$rank3_label.'}';
	

	// get rank4
	$rank4_count = "";
	$rank4_color = "";
	$rank4_label = "";

	$sql = "SELECT `q4` AS g, count(*) AS count FROM `evaluation` GROUP BY `q4` ";

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$rank4_count = $rank4_count.$row[1].",";
			
			if($row[0] == 0) {
				$rank4_label = $rank4_label.'"ไม่ระบุ",';
				$rank4_color = $rank4_color.'"#FF6384",';
			}
			if($row[0] == 1) {
				$rank4_label = $rank4_label.'"น้อยที่สุด",';
				$rank4_color = $rank4_color.'"#983ef2",';
			}
			if($row[0] == 2) {
				$rank4_label = $rank4_label.'"น้อย",';
				$rank4_color = $rank4_color.'"#f44242",';
			}
			if($row[0] == 3) {
				$rank4_label = $rank4_label.'"ปานกลาง",';
				$rank4_color = $rank4_color.'"#36A2EB",';
			}
			if($row[0] == 4) {
				$rank4_label = $rank4_label.'"มาก",';
				$rank4_color = $rank4_color.'"#3ef27a",';
			}
			if($row[0] == 5) {
				$rank4_label = $rank4_label.'"มากที่สุด",';
				$rank4_color = $rank4_color.'"#FFCE56",';
			}
			
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$rank4_count = substr($rank4_count,0,-1);
	$rank4_count = "[".$rank4_count."]";
	$rank4_color = substr($rank4_color,0,-1);
	$rank4_color = "[".$rank4_color."]";
	$rank4_label = substr($rank4_label,0,-1);
	$rank4_label = "[".$rank4_label."]";
	$json_str_rank4 = '{"count" : '.$rank4_count.', "color" : '.$rank4_color.', "label" : '.$rank4_label.'}';

	echo '{"group" : '.$json_str_user.', "rank1" : '.$json_str_rank1.', "rank2" : '.$json_str_rank2.', "rank3" : '.$json_str_rank3.', "rank4" : '.$json_str_rank4.'}';

	
}

mysqli_close($link);
}
?>
