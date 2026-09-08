<?php
if(isset($_REQUEST['time'])){
include('../php/connect.php');

// start query

$colorArray = array("#FF6384", "#983ef2", "#f44242", "#36A2EB", "#3ef27a","#FFCE56", "#ff8000", "#ffff00" ,"#ff4000", "#40ff00", "#bf00ff");

if(isset($_REQUEST['time'])){
	
	$time = $_REQUEST['time'];

	// get building cat count
	$B = $F = $G = $I = $L = $P = 0;
	$cat_count = "";
	$cat_color = "";
	$cat_label = "";
	if ($time == 'a') {
		$sql = "SELECT SUBSTRING(`build_up_index`, 1, 1) as type, COUNT(*)AS count FROM `validate_logs` GROUP BY SUBSTRING(`build_up_index`, 1, 1) ORDER by type";
	} else {
		$sql = "SELECT SUBSTRING(`build_up_index`, 1, 1) as type, COUNT(*)AS count FROM `validate_logs` WHERE `time_stamp` BETWEEN DATE_ADD(NOW(), INTERVAL -".$time." DAY) AND NOW() GROUP BY SUBSTRING(`build_up_index`, 1, 1) ORDER by type";
	}

	if ($result=mysqli_query($link,$sql)){
		while ($row=mysqli_fetch_row($result)){
			$cat_count = $cat_count.$row[1].",";
			
			if($row[0] == 'B') {
				$cat_label = $cat_label.'"อาคารพาณิช",';
				$cat_color = $cat_color.'"#FF6384",';
			}
			if($row[0] == 'F') {
				$cat_label = $cat_label.'"โรงงาน",';
				$cat_color = $cat_color.'"#983ef2",';
			}
			if($row[0] == 'G') {
				$cat_label = $cat_label.'"สถานที่เกี่ยวกับน้ำมันและก๊าซ",';
				$cat_color = $cat_color.'"#f44242",';
			}
			if($row[0] == 'I') {
				$cat_label = $cat_label.'"โครงสร้างพื้นฐาน",';
				$cat_color = $cat_color.'"#36A2EB",';
				}
			if($row[0] == 'L') {
				$cat_label = $cat_label.'"อาคารที่อยู่อาศัย",';
				$cat_color = $cat_color.'"#3ef27a",';
			}
			if($row[0] == 'P') {
				$cat_label = $cat_label.'"อาคารสาธารณะ",';
				$cat_color = $cat_color.'"#FFCE56",';
			}
			if($row[0] == 'a') {
				$cat_label = $cat_label.'"All",';
				$cat_color = $cat_color.'"#ff8000",';
			}
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$cat_count = substr($cat_count,0,-1);
	$cat_count = "[".$cat_count."]";
	$cat_color = substr($cat_color,0,-1);
	$cat_color = "[".$cat_color."]";
	$cat_label = substr($cat_label,0,-1);
	$cat_label = "[".$cat_label."]";
	$json_str_cat = '{"count" : '.$cat_count.', "color" : '.$cat_color.', "label" : '.$cat_label.'}';

	
	// get os count
	$os_count = "";
	$os_color = "";
	$os_label = "";
	if ($time == 'a') {
		$sql = "SELECT `os` as os, COUNT(*)AS count FROM `validate_logs` GROUP BY `os` ORDER by os";
	} else {
		$sql = "SELECT `os` as os, COUNT(*)AS count FROM `validate_logs` WHERE `time_stamp` BETWEEN DATE_ADD(CURDATE(), INTERVAL -".$time." DAY) AND CURDATE() GROUP BY `os` ORDER by os";
	}
	
	if ($result=mysqli_query($link,$sql)){
		$i=0;
		while ($row=mysqli_fetch_row($result)){
			$os_count = $os_count.$row[1].",";
			$os_color = $os_color.'"'.$colorArray[$i].'",';
			$os_label = $os_label.'"'.$row[0].'",';
			$i++;
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$os_count = substr($os_count,0,-1);
	$os_count = "[".$os_count."]";
	$os_color = substr($os_color,0,-1);
	$os_color = "[".$os_color."]";
	$os_label = substr($os_label,0,-1);
	$os_label = "[".$os_label."]";
	$json_str_os = '{"count" : '.$os_count.', "color" : '.$os_color.', "label" : '.$os_label.'}';
	
	// get browser count

	$browser_count = "";
	$browser_color = "";
	$browser_label = "";
	if ($time == 'a') {
		$sql = "SELECT `browser` as browser, COUNT(*)AS count FROM `validate_logs` GROUP BY `browser` ORDER by browser";
	} else {
		$sql = "SELECT `browser` as browser, COUNT(*)AS count FROM `validate_logs` WHERE `time_stamp` BETWEEN DATE_ADD(CURDATE(), INTERVAL -".$time." DAY) AND CURDATE() GROUP BY `browser` ORDER by browser";
	}

	if ($result=mysqli_query($link,$sql)){
		$i=0;
		while ($row=mysqli_fetch_row($result)){
			$browser_count = $browser_count.$row[1].",";
			$browser_color = $browser_color.'"'.$colorArray[$i].'",';
			$browser_label = $browser_label.'"'.$row[0].'",';
			$i++;
		}
	} 
	// Free result set
	mysqli_free_result($result);
	$browser_count = substr($browser_count,0,-1);
	$browser_count = "[".$browser_count."]";
	$browser_color = substr($browser_color,0,-1);
	$browser_color = "[".$browser_color."]";
	$browser_label = substr($browser_label,0,-1);
	$browser_label = "[".$browser_label."]";
	$json_str_browser = '{"count" : '.$browser_count.', "color" : '.$browser_color.', "label" : '.$browser_label.'}';

	echo '{"cat" : '.$json_str_cat.', "os" : '.$json_str_os.', "browser" : '.$json_str_browser.'}';

	
}

mysqli_close($link);
}
?>
