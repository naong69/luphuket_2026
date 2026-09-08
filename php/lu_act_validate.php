<?php
//$_REQUEST['data'] = "pk_cp_act_2558.110:2,pk_bc20_act_2532.2:1,pk_bc15_act_2529.7:3,pk_en_act_2553.43:2,pk_patong_lu_act_2548.5:2";
//$_REQUEST['index'] = "B001001";
//$_REQUEST['xy'] = "10947019.48856417, 883707.7902814166";
//$_REQUEST['data'] = "pk_cp_act_2558.111:3_1:16,pk_bc20_act_2532.5:3:,pk_en_act_2560.493:2_bc20:";

//echo $_REQUEST['data'];

if(isset($_REQUEST['data'])&& isset($_REQUEST['index'])&& isset($_REQUEST['xy'])){

$data = $_REQUEST['data'];
$index = $_REQUEST['index'];
$index_cat = substr($index,0,1);

$xy_3857 = $_REQUEST['xy'];

if(isset($_REQUEST['all'])){
 	$all = true;
} else {
	$all = false;
}


if ($data != ""){

$map = array();
$zone = array();
$zone_ = array();

foreach (explode(",", $data) as $value){
  $mz = explode(":", $value);
  array_push($map, explode(".", $mz[0])[0]);
  array_push($zone,$mz[1]);
  if(strlen($mz[2]) > 0){
  	$z_ = explode("_", $mz[1])[0].".".$mz[2];
  } else {
  	$z_ = explode("_", $mz[1])[0];
  }
  //echo sizeof(explode("_", $mz[1]))."<br>";
  if(sizeof(explode("_", $mz[1]))==2) {
  	if(explode("_", $mz[1])[1] == "cp4")
  		$z_ = $z_." (ซ้อนทับกับโซน 4 : ที่ดินประเภทอุตสาหกรรมและคลังสินค้า ในกฏหมายผังเมืองรวม พ.ศ. ๒๕๕๘)";
  	if(explode("_", $mz[1])[1] == "cp5")
  		$z_ = $z_." (ซ้อนทับกับโซน 5 : ที่ดินประเภทอุตสาหกรรมเฉพาะกิจ ในกฏหมายผังเมืองรวม พ.ศ. ๒๕๕๘)";
  	if(explode("_", $mz[1])[1] == "bc15")
  		$z_ = $z_." (ซ้อนทับกับโซน ".$z_." ในกฏหมายควบคุมอาคาร ฉบับที่ ๑๕ (พ.ศ. ๒๕๒๙))";
  	if(explode("_", $mz[1])[1] == "bc20")
  		$z_ = $z_." (ซ้อนทับกับโซน ".$z_." ในกฏหมายควบคุมอาคาร ฉบับที่ ๒๐ (พ.ศ. ๒๕๓๒))";
  }
  array_push($zone_,$z_);
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

$strSQL = "SELECT * FROM all_index WHERE indexID = '".$index."' ";
$objQuery = mysqli_query($link, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

$cat_name = $objResult[2];
$group_name = $objResult[5];
$opr_name1 = $objResult[7];
$opr_name2 = $objResult[8];
$opr_name3 = $objResult[9];


$enval = $cpval = $bc20val = $bc15val = $muval = 1;


    /*==Environment=============================================================================================================================================================================*/
              
if(in_array("pk_en_act_2560",$map)){
	$key = array_search("pk_en_act_2560",$map);	
	
	//Validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `en_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enval = $objResult[0];
	
    //Exception
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_exception` as A WHERE indexID = '".$index."')";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enExcepRes = $objResult[0];
	
	//General Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_general_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enGenRes = $objResult[0];	
	
    //Factory Restriction
	if(substr($index,0,1)=='F'){
		$strSQL = "SELECT B.ex_re_dec FROM `en_factory_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_factory_type_1_restriction` as A WHERE indexID = '".$index."')";
		$objQuery = mysqli_query($link, $strSQL);
		$objResult = mysqli_fetch_array($objQuery);
		$enFacRes1 = $objResult[0];
		
		$strSQL = "SELECT B.ex_re_dec FROM `en_factory_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_factory_type_2_restriction` as A WHERE indexID = '".$index."')";
		$objQuery = mysqli_query($link, $strSQL);
		$objResult = mysqli_fetch_array($objQuery);
		$enFacRes2 = $objResult[0];

		$strSQL = "SELECT B.ex_re_dec FROM `en_factory_restriction_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_factory_type_3_restriction` as A WHERE indexID = '".$index."')";
		$objQuery = mysqli_query($link, $strSQL);
		$objResult = mysqli_fetch_array($objQuery);
		$enFacRes3 = $objResult[0];

	} else {
		$enFacRes1 = "-";
		$enFacRes2 = "-";
		$enFacRes3 = "-";
	}

	//Height Restriction1
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_height_restriction_1` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enHeightRes1 = $objResult[0];
	
	//Height Restriction2
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_height_restriction_2` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enHeightRes2 = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enAreaRes = $objResult[0];

    //Slope Restriction1
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_slope_restriction_1` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enSlopeRes1 = $objResult[0];
	
	//Slope Restriction2
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_slope_restriction_2` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enSlopeRes2 = $objResult[0];
	
	
	//EIA Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `en_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `en_eia_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $enEiaRes =  $objResult[0];

}


    /*===CityPlan================================================================================================================================================================================*/
            
if(in_array("pk_cp_act_2558",$map)){
	$key = array_search("pk_cp_act_2558",$map);	
	
	//Validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `cp_validate_matrix` as A WHERE indexID = '".$index."'";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpval = $objResult[0];

    //Exception
    $strSQL = "SELECT B.ex_re_dec FROM `cp_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_exception` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpExcepRes = $objResult[0];
	
    //General Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `cp_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_general_restriction` as A WHERE indexID = '".$index."')";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpGenRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `cp_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `cp_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $cpAreaRes = $objResult[0];


               
}               
               
    /*===BuildingControl20==========================================================================================================================================================================*/

if(in_array("pk_bc20_act_2532",$map)){
	$key = array_search("pk_bc20_act_2532",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `bc20_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20val = $objResult[0];
	
	//Exception
    $strSQL = "SELECT B.ex_re_dec FROM `bc20_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_exception` as A WHERE indexID = '".$index."')";  
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20ExcepRes = $objResult[0];
	
    //General Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc20_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_general_restriction` as A WHERE indexID = '".$index."')";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20GenRes = $objResult[0];

    //Height Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc20_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_height_restriction` as A WHERE indexID = '".$index."')";
        
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20HeightRes = $objResult[0];

    //Area Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc20_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc20_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc20AreaRes = $objResult[0];

    
    
}
    /*===BuildingControl15======================================================================================================================================================================================*/


if(in_array("pk_bc15_act_2529",$map)){
	$key = array_search("pk_bc15_act_2529",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `bc15_validate_matrix` as A WHERE indexID = '".$index."'";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15val = $objResult[0];
	
	//Exception
    $strSQL = "SELECT B.ex_re_dec FROM `bc15_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_exception` as A WHERE indexID = '".$index."')";  
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15ExcepRes = $objResult[0];
	
    //General Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc15_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_general_restriction` as A WHERE indexID = '".$index."')";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15GenRes = $objResult[0];

    //Height Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc15_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_height_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15HeightRes = $objResult[0];
    
    //Area Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `bc15_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `bc15_area_restriction` as A WHERE indexID = '".$index."')";
    $objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $bc15AreaRes = $objResult[0];
}

    /*===MunicipalPathong=================================================================================================================================================================================================*/

if(in_array("pk_patong_lu_act_2548",$map)){
	$key = array_search("pk_patong_lu_act_2548",$map);	
	
	// validate
	$strSQL = "SELECT A.zone_".$zone[$key]." FROM `pt_validate_matrix` as A WHERE indexID = '".$index."'";
	
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $ptval = $objResult[0];
	
    //Gen Restriction
    $strSQL = "SELECT B.ex_re_dec FROM `pt_ex_re_key` as B WHERE indexID IN (SELECT A.zone_".$zone[$key]." FROM `pt_general_restriction` as A WHERE indexID = '".$index."')";
	$objQuery = mysqli_query($link, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $ptGenRes = $objResult[0];

}


?>

<html>
<head>
<title>ตรวจสอบสิ่งปลูกสร้าง</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script src="../js/bootstrap.min.js"></script>
<script src="js/proj4.js"></script>
<style type="text/css">

	.result {
		font-size : 14px;
	}
	
	li span, dd span {
		font-size : 14px;
	}

	li span.val {
		font-weight : bold;
	}
	button span {
		font-size : 16px;
	}
	
	.container {
		height: 650px;
	}
	
	div .acts {
		text-align: center;
		cursor: pointer;
	}
	
	div .act-label {
		display: inline-block;
		font-size : 16px;
	}
	
	.subforms {
		overflow-x: visible;
		overflow-y: visible;
	}
	
	.back-button  {
    	float: right;
    	margin-right: 10px;
	}

</style>
</head>
<body>
<div class="container">
	<div align="center" class="result">
		<h3>ผลการตรวจสอบ: 
		<?php  
		 echo ($enval && $cpval && $bc20val && $bc15val && $muval)?  "<font color='green'><b>สร้างได้</b></font>": "<font color='red'><b>สร้างไม่ได้</b></font>";
		?>
		</h3>
		<?php
		if($all) echo '<div class="back-button"><a href="javascript:history.back()"><< กลับไป</a></div>';
		?>
		<div class="text-left">
		<b>พิกัด: </b><span id="latlon"></span><br>
		<b>กลุ่ม: </b><?php echo $cat_name?><br>
		<b>ประเภท: </b><?php echo $group_name?><br>
		<b>กิจการ: </b><?php echo $opr_name1?><br>
		<b>นิยาม: </b><?php echo $opr_name2?><br>
		<b>อ้างอิง: </b><?php echo $opr_name3?>
		</div>
		<br>
		<div><span style="color:red;">ผลการตรวจสอบดังกล่าวอยู่ในช่วงการพัฒนาระบบ ซึ่งไม่สามารถนำไปใช้อ้างอิงทางกฎหมายได้</span></div>
		<hr>
	</div>
	<div class="text-center result">ท่านสามารถดูรายละเอียดข้อกำหนดการใช้ประโยชน์ที่ดินตามแต่ละกฎหมายได้ โดยคลิกที่แถบข้างล่างนี้</div>
	<br>
	<?php  if(in_array("pk_en_act_2560",$map)){ 
		$key = array_search("pk_en_act_2560",$map);	
	?>
    <div class="span btn-block">
		<div class="acts alert <?php echo($enval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">ประกาศสิ่งแวดล้อม พ.ศ. ๒๕๖๐</div></div>
        <ul id="subforms1" class="subforums" style="padding: 7px 7px; list-style: none;">
        	<li><span><b>โซน:</b> <?php echo $zone_[$key] ?> </span> </li>
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($enval)? "<span style='color: green;'><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<?php if($enval == 1 || strlen($enExcepRes) != 1) { ?>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $enExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด</b></span>
				<dd><span><b>ข้อจำกัดทั่วไป:</b> <?php echo $enGenRes ?></span></dd>
				<?php if($index_cat == 'F'){?>
				<dd><span><b>โรงงานจำพวกที่ 1:</b> <?php echo $enFacRes1 ?></span></dd>
				<dd><span><b>โรงงานจำพวกที่ 2:</b> <?php echo $enFacRes2 ?></span></dd>
				<dd><span><b>โรงงานจำพวกที่ 3:</b> <?php echo $enFacRes3 ?></span></dd>
				<?php } ?>
				<dd><span><b>ความสูง:</b> <?php echo $enHeightRes1 ?></span></dd>
				<dd><span><b>:</b> <?php echo $enHeightRes2 ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $enAreaRes ?></span></dd>
				<dd><span><b>ความลาดชัน:</b> <?php echo $enSlopeRes1 ?></span></dd>
				<dd><span><b>:</b> <?php echo $enSlopeRes2 ?></span></dd>
				<dd><span><b>ผลกระทบสิ่งแวดล้อม:</b> <?php echo $enEiaRes ?></span></dd>
			</li>
			<?php } else { ?>
			<li><span><b>เนื่องจาก:</b>  การใช้ที่ดินสร้างสิ่งปลูกสร้างไม่สอดคล้องกับข้อกำหนดของประกาศกระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม พ.ศ.  ๒๕๕๓ </span> </li>
			<?php } ?>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_cp_act_2558",$map)){ 
		$key = array_search("pk_cp_act_2558",$map);	
	?>
     <div class="span btn-block">
        <div class="acts alert <?php echo($cpval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายผังเมืองรวม พ.ศ. ๒๕๕๘</div></div>
		<ul id="subforms2" class="subforums" style="padding: 7px 7px; list-style: none;">
			<li><span><b>โซน:</b> <?php echo $zone_[$key] ?> </span> </li>
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($cpval)? "<span style='color: green;'><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<?php if($cpval == 1 || strlen($cpExcepRes) != 1) { ?>
			<li><span><b>ข้อยกเว้น:</b> <?php echo $cpExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด</b></span>
				<dd><span><b>ข้อจำกัดทั่วไป:</b> <?php echo $cpGenRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $cpAreaRes ?></span></dd>
			</li>
			<?php } else { ?>
			<li><span><b>เนื่องจาก:</b> การใช้ที่ดินสร้างสิ่งปลูกสร้างไม่สอดคล้องตามกฎกระทรวงให้ใช้บังคับผังเมืองรวมจังหวัดภูเก็ต พ.ศ.  ๒๕๕๘ </span> </li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<?php  if(in_array("pk_bc20_act_2532",$map)){ 
		$key = array_search("pk_bc20_act_2532",$map);	
	?>
     <div class="span btn-block">
        <div class="acts alert <?php echo($bc20val)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายควบคุมอาคาร ฉบับที่ ๒๐ (พ.ศ. ๒๕๓๒)</div></div>
		<ul id="subforms3" class="subforums" style="padding: 7px 7px; list-style: none;">
			<li><span><b>โซน:</b> <?php echo $zone_[$key] ?> </span> </li>
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($bc20val)? "<span style='color: green;'><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<?php if($bc20val == 1 || strlen($bc20ExcepRes) != 1) { ?>
			<li><span><b>ข้อยกเว้น</b> <?php echo $bc20ExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด</b></span>
				<dd><span><b>ข้อจำกัดทั่วไป:</b> <?php echo $bc20GenRes ?></span></dd>
				<dd><span><b>ความสูง:</b> <?php echo $bc20HeightRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $bc20AreaRes ?></span></dd>
			</li>
			<?php } else { ?>
			<li><span><b>เนื่องจาก:</b> การใช้ที่ดินสร้างสิ่งปลูกสร้างไม่สอดคล้องตามกฎกระทรวง ฉบับที่ ๒๐ พ.ศ. ๒๕๓๒ ออกตามความในพระราชบัญญัติควบคุมอาคาร พ.ศ. ๒๕๒๒</span> </li>
			<?php } ?>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_bc15_act_2529",$map)){ 
		$key = array_search("pk_bc15_act_2529",$map);
	?>
     <div class="span btn-block">
        <div class="acts alert <?php echo($bc15val)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">กฏหมายควบคุมอาคาร  ฉบับที่ ๑๕ (พ.ศ. ๒๕๒๙) </div></div>
		<ul id="subforms4" class="subforums" style="padding: 10px 10px; list-style: none;">
			<li><span><b>โซน:</b> <?php echo $zone_[$key] ?> </span> </li>
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($bc15val)? "<span style='color: green;'><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<?php if($bc15val == 1 || strlen($bc15ExcepRes) != 1) { ?>
			<li><span><b>ข้อยกเว้น</b> <?php echo $bc15ExcepRes ?> </span> </li>
			<li><span><b>ข้อจำกัด</b></span>
				<dd><span><b>ข้อจำกัดทั่วไป:</b> <?php echo $bc15GenRes ?></span></dd>
				<dd><span><b>ความสูง:</b> <?php echo $bc15HeightRes ?></span></dd>
				<dd><span><b>พื้นที่:</b> <?php echo $bc15AreaRes ?></span></dd>
			</li>
			<?php } else { ?>
			<li><span><b>เนื่องจาก:</b> การใช้ที่ดินสร้างสิ่งปลูกสร้างไม่สอดคล้องตามกฎกระทรวง ฉบับที่ ๑๕ พ.ศ. ๒๕๒๙ ออกตามความในพระราชบัญญัติควบคุมอาคาร พ.ศ. ๒๕๒๒</span> </li>
			<?php } ?>
		</ul>
    </div>
	<?php } ?>
	<?php  if(in_array("pk_patong_lu_act_2548",$map)){ 
		$key = array_search("pk_patong_lu_act_2548",$map);
	?>
     <div class="span9 btn-block">
        <div class="acts alert <?php echo($muval)? "alert-success" : "alert-danger" ?>" role="alert"><div class="act-label">เทศบัญญัติเทศบาลเมืองป่าตอง พ.ศ. ๒๕๔๘</div></div>
		<ul id="subforms5" class="subforums" style="padding: 7px 7px; list-style: none;">
			<li><span><b>โซน:</b> <?php echo $zone_[$key] ?> </span> </li>
			<li><span class="val" >ผลการตรวจสอบ: </span> <?php echo($muval)? "<span style='color: green;'><b>สร้างได้</b></span>" : "<span style='color: red; font-size: 16px; '><b>สร้างไม่ได้</b></span>" ?></li>
			<?php if($ptval == 1 ) { ?>
			<li><span><b>ข้อจำกัด:</b> <?php echo $ptGenRes ?></span></span></li>
			<?php } else { ?>
			<li><span><b>เนื่องจาก:</b> การใช้ที่ดินสร้างสิ่งปลูกสร้างไม่สอดคล้องตามเทศบัญญัติเทศบาลเมืองป่าตอง พ.ศ. ๒๕๔๘</span> </li>
			<?php } ?>
		</ul>
    </div>
	<?php } ?>
</div>
<script>
    $(document).ready(function(){
        //init
        $("ul.subforums").hide();

        $("div .acts").click(function(){
			if($(this).parent().find("ul").is(":visible")){
				$(this).parent().find("ul").hide();
			} else {			
				$("ul.subforums").hide(); //hide all show ul
				$(this).parent().find("ul").toggle();
			}
        });
        
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
        
    });    
</script>
</body>
</html>
<?php

mysqli_free_result($objQuery);

mysqli_close($link);

} else { // if data != ""

?>
<html>
<head>
<title>ตรวจสอบสิ่งปลูกสร้าง</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script src="../js/bootstrap.min.js"></script>
<style type="text/css">
 h3 {
		color : red;
 }
</style>
</head>
<body>
<div class="container">
	<div align="center">
		<h3>พื้นที่ที่ตรวจสอบไม่อยู่ในพี้นที่ตามที่กำหนดในกฏหมายที่ระบบให้บริการตรวจสอบ</h3>
	</div>
	<div class="text-left">
		<h4>๑. ประกาศกระทรวงทรัพยากรธรรมชาติและสิ่งแวดล้อม ในบริเวณพื้นที่จังหวัดภูเก็ต พ.ศ. ๒๕๖๐</h4>
		<h4>๒. กฎกระทรวง ฉบับที่ ๑๕ (พ.ศ. ๒๕๒๙) ออกตามความในพระราชบัญญัติควบคุมอาคาร พ.ศ. ๒๕๒๒</h4>
		<h4>๓. กฎกระทรวง ฉบับที่ ๒๐ (พ.ศ. ๒๕๓๒) ออกตามความในพระราชบัญญัติควบคุมอาคาร พ.ศ. ๒๕๒๒</h4>
		<h4>๔. กฏกระทรวง ให้ใช้บังคับผังเมืองรวมจังหวัดภูเก็ต พ.ศ. ๒๕๕๔ และ พ.ศ. ๒๕๕๘</h4>
		<h4>๕. เทศบัญญัติเทศบาลเมืองป่าตอง เรื่องกำหนดบริเวณห้ามก่อสร้าง ดัดแปลง หรือเปลี่ยนการใช้อาคารในพื้นที่เทศบาลเมืองป่าตอง พ.ศ. ๒๕๔๘</h4>
	</div>
</div>
</body>

<?php
	
}


} // if isset

?>
