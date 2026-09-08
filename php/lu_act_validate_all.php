<?php
//$_REQUEST['data'] = "pk_cp_act_2558.110:2,pk_bc20_act_2532.2:1,pk_bc15_act_2529.7:3,pk_en_act_2553.43:2,pk_patong_lu_act_2548.5:2";
//$_REQUEST['index'] = "B001001";
//$_REQUEST['xy'] = "10947019.48856417, 883707.7902814166";
//$_REQUEST['data'] = "pk_cp_act_2558.111:3_1:16,pk_bc20_act_2532.5:3:,pk_en_act_2560.493:2_bc20:";

//echo $_REQUEST['data'];

if(isset($_REQUEST['data']) && isset($_REQUEST['xy'])){

$data = $_REQUEST['data'];
$index = "all";

$xy_3857 = $_REQUEST['xy'];

if ($data != ""){

$map = array();
$zone = array();

foreach (explode(",", $data) as $value){
  $mz = explode(":", $value);
  array_push($map, explode(".", $mz[0])[0]);
  array_push($zone,$mz[1]);
}

include('connect.php');

// loging process
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
// load functions
include_once("utill.php");

$xy = $_REQUEST['xy'];
$remote_ip = get_client_ip();
// find OS 

$user_os        =   getOS();
$user_browser   =   getBrowser();

$datetime = date("Y-m-d H:i:s");
$utc = new DateTime($datetime, new DateTimeZone('UTC'));
$utc->setTimezone(new DateTimeZone('Asia/Bangkok'));
$time_stamp = $utc->format('Y-m-d H:i:s');

$strSQL = "INSERT INTO `validate_logs` (`time_stamp`, `ip`, `os`, `browser`, `coor_xy`, `build_up_index`) VALUES ('".$time_stamp."', '".$remote_ip."', '".$user_os."', '".$user_browser."', '".$xy."', '".$index."')";
$objQuery = mysqli_query($link, $strSQL);


// validate process
// start query

$strSQL = "SELECT `indexID`, `oper_prod_name_sub` FROM all_index ";
$objQuery = mysqli_query($link, $strSQL);
$result_index = mysqli_fetch_all($objQuery);

function fetchResultArray($array, $key){
	$result = array();
	for($i = 0; $i < sizeof($array); $i++){
		if(substr($array[$i][0],0,1) == $key){
			array_push($result,$array[$i]);
		}
	}
	return $result;
}



$enval = $cpval = $bc20val = $bc15val = $muval = 1;

              
/*==Environment=============================================================================================================================================================================*/
         
if(in_array("pk_en_act_2560",$map)){
	$key = array_search("pk_en_act_2560",$map);	
	$strSQL = "SELECT `indexID`, `zone_".$zone[$key]."` FROM `en_validate_matrix`";
	$objQuery = mysqli_query($link, $strSQL);
	$result_en = mysqli_fetch_all($objQuery);
}

/*===CityPlan================================================================================================================================================================================*/
            
if(in_array("pk_cp_act_2558",$map)){
	$key = array_search("pk_cp_act_2558",$map);	
	$strSQL = "SELECT `indexID`, `zone_".$zone[$key]."` FROM `cp_validate_matrix`";
	$objQuery = mysqli_query($link, $strSQL);
	$result_cp = mysqli_fetch_all($objQuery);   
}               
               
    /*===BuildingControl20==========================================================================================================================================================================*/

if(in_array("pk_bc20_act_2532",$map)){
	$key = array_search("pk_bc20_act_2532",$map);	
	$strSQL = "SELECT `indexID`, `zone_".$zone[$key]."` FROM `bc20_validate_matrix`";
	$objQuery = mysqli_query($link, $strSQL);
	$result_bc20 = mysqli_fetch_all($objQuery);
}
    /*===BuildingControl15======================================================================================================================================================================================*/


if(in_array("pk_bc15_act_2529",$map)){
	$key = array_search("pk_bc15_act_2529",$map);	
	$strSQL = "SELECT `indexID`, `zone_".$zone[$key]."` FROM `bc15_validate_matrix`";
	$objQuery = mysqli_query($link, $strSQL);
	$result_bc15 = mysqli_fetch_all($objQuery);
}

    /*===MunicipalPathong=================================================================================================================================================================================================*/

if(in_array("pk_patong_lu_act_2548",$map)){
	$key = array_search("pk_patong_lu_act_2548",$map);	
	$strSQL = "SELECT `indexID`, `zone_".$zone[$key]."` FROM `pt_validate_matrix`";
	$objQuery = mysqli_query($link, $strSQL);
	$result_pt = mysqli_fetch_all($objQuery);
}


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>ตรวจสอบสิ่งปลูกสร้าง</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<!-- Fontawesome Icon font -->
<link rel="stylesheet" href="../css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<style type="text/css">

	div.container {
		margin-top: 10px;
	}
	div#time-range-container {
		padding : 10px 0 0px 0;
	}
	div#time-range-container {
		width : 300px;
	}
	#map-containner{
		width: 600px;
	}
	#map-canvas {
		width: 100%;
		height: 680px;
	}
	#validate-count, #evaluation-count{
		font-size : 30px;
	}
	#validate-num, #evaluation-num{
		font-size : 60px;
		color : red;
	}
	.rank-header{
		font-size : 25px;	
	}

</style>
<script src="js/proj4.js"></script>
</head>
<body>
<div class="container">
	<div role="tabpanel">
	<div class="text-center">
	<h3>ผลการตรวจสอบ</h3>
	<b>พิกัด: </b><span id="latlon"></span><br>
	<div><span style="color:red;">ผลการตรวจสอบดังกล่าวอยู่ในช่วงการพัฒนาระบบ ซึ่งไม่สามารถนำไปใช้อ้างอิงทางกฎหมายได้</span></div>
	<br/>
	
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab">
       	<li role="presentation"><a href="#B" aria-controls="settings" role="tab" data-toggle="tab">อาคารพาณิชย์</a></li>
	  	<li role="presentation"><a href="#L" aria-controls="settings" role="tab" data-toggle="tab">อาคารที่อยู่อาศัย</a></li>
	  	<li role="presentation"><a href="#P" aria-controls="settings" role="tab" data-toggle="tab">อาคารสาธารณะ</a></li>
	  	<li role="presentation"><a href="#G" aria-controls="settings" role="tab" data-toggle="tab">อาคารเกี่ยวกับน้ำมันและก๊าซ</a></li>
	  	<li role="presentation"><a href="#I" aria-controls="settings" role="tab" data-toggle="tab">สาธารนูปโภค</a></li>
		<li role="presentation"><a href="#F" aria-controls="settings" role="tab" data-toggle="tab">โรงงาน</a></li>
	</ul>

    <!-- Tab panes -->
    <div class="tab-content">
		
		<div class="tab-pane active" id="B" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'B')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'B')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'B')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'B')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'B')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'B')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'B')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'B')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
		
		<div class="tab-pane" id="L" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง1</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'L')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'L')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'L')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'L')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'L')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'L')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'L')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'L')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
		
		<div class="tab-pane" id="P" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'P')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'P')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'P')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'P')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'P')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'P')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'P')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'P')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
		
		<div class= "tab-pane" id="G" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'G')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'G')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'G')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'G')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'G')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'G')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'G')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'G')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
		
		<div class= "tab-pane" id="I" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'I')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'I')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'I')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'I')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'I')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'I')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'I')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'I')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
		
		<div class= "tab-pane" id="F" >
			<div align="center">
				<table class="table table-hover legend-table text-center">
					<tr>
						<th width="30%" class="text-center">สิ่งปลูกสร้าง</th>
						<th width="14%" class="text-center">ประกาศสิ่งแวดล้อม (๒๕๖๐)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๑๕ (๒๕๒๙)</th>
						<th width="14%" class="text-center">กฎหมายควบคุมอาคาร ฉบับที่ ๒๐ (๒๕๓๒)</th>
						<th width="14%" class="text-center">กฎหมายผังเมืองรวม (๒๕๕๘)</th>
						<th width="14%" class="text-center">เทศบัญญัติเทศบาลเมืองป่าตอง (๒๕๔๘)</th>
					</tr>
					<?php
	for ( $i = 0; $i < sizeof(fetchResultArray($result_en, 'F')); $i++) {

	?>
				<tr>
						<td class="text-left"><a href="lu_act_validate.php?data=<?php echo $data?>&index=<?php echo fetchResultArray($result_index, 'F')[$i][0]; ?>&xy=<?php echo $xy_3857; ?>&all=true"><?php echo fetchResultArray($result_index, 'F')[$i][1]; ?></a></td>
						<td class="text-center"><?php if(in_array("pk_en_act_2560",$map)){ if(fetchResultArray($result_en, 'F')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc15_act_2529",$map)){ if(fetchResultArray($result_bc15, 'F')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_bc20_act_2532",$map)){ if(fetchResultArray($result_bc20, 'F')[$i][1] == 1){ echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_cp_act_2558",$map)){ if(fetchResultArray($result_cp, 'F')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
						<td class="text-center"><?php if(in_array("pk_patong_lu_act_2548",$map)){ if(fetchResultArray($result_pt, 'F')[$i][1] == 1) {echo "<i class='fa fa-check fa-2x' style='color:green'></i>"; } else { echo "<i class='fa fa fa-times fa-2x' style='color:red'></i>"; } } else { echo "<i class='fa fa-minus fa-2x'></i>"; } ?></td>
					</tr>
	<?php
	}
	?>
				</table>
			</div>
		</div>
    </div>
  </div>
</div>						
</body>

<script>
	

    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })   
	
	// convert lat lon
    xy_4326 = coorConvert("<?php echo $xy_3857 ?>");
    $('#latlon').append('<a href="'+xy_4326[1]+'" target="_blank">'+xy_4326[0]+'</a>')
        
    function coorConvert(coorxy){

		proj4.defs([
		  [
			'EPSG:3857',
			'+proj=merc +lon_0=0 +k=1 +x_0=0 +y_0=0 +a=6378137 +b=6378137 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs '
		  ],[
			'EPSG:32647',
			'+proj=utm +zone=47 +ellps=WGS84 +datum=WGS84 +units=m +no_defs'
		  ],[
			'EPSG:4326',
			'+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs'
		  ]
		]);
		
		// re-coordinate
		xy = coorxy.split(",");
		latLon = proj4('EPSG:3857', 'EPSG:4326',[xy[0],xy[1]])

		url = "https://maps.google.com/maps?z=12&t=k&q="+latLon[1]+","+latLon[0]
			
		return [latLon,url]
		
	}


</script>
</html>

<?php
	
}


} // if isset

?>
