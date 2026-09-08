<?php

if(isset($_REQUEST['login'])){
	if($_REQUEST['login']== 'secure'){
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin Back End</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
<script src="js/Chart.js"></script>
<script src="js/proj4.js"></script>
</head>
<body>
<div class="container">
	<div role="tabpanel">
	
	<div id="time-range-container" class="text-right">
		<div id="time-range-box" class="form-group">
			<select id="time-index" class="form-control">
				<option value="3">Last 3 days</option>
				<option value="7" selected>Last 7 days</option>
				<option value="30">Last 30 days</option>
				<option value="60">Last 60 days</option>
				<option value="90">Last 90 days</option>
				<option value="180">Last 180 days</option>
				<option value="270">Last 270 days</option>
				<option value="365">Last 365 days</option>
				<option value="730">Last 730 days</option>
				<option value="a">All</option>
			</select>
		</div>
	</div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab">
      <li role="presentation"><a href="#validate" aria-controls="settings" role="tab" data-toggle="tab">Summary of Validation</a></li>
	  <li role="presentation"><a href="#validate-logs" aria-controls="settings" role="tab" data-toggle="tab">Validation Logs</a></li>
	  <li role="presentation"><a href="#evaluation" aria-controls="settings" role="tab" data-toggle="tab">System Evaluation</a></li>
	  <li role="presentation"><a href="#feedback" aria-controls="settings" role="tab" data-toggle="tab">Feedback</a></li>
	</ul>

    <!-- Tab panes -->
    <div class="tab-content">
		
		<div class="tab-pane active" id="validate" >
			<div align="center">
				<h2>Summary</h2>
			</div>
			<div id="map-containner"  class="col-md-8">
				<div id="map-canvas"></div>
			</div>
			<div id="graph-container"  class="col-md-4" >
				<div style="width: 500px; height: 120px;" class="text-center validate-count-box">
					<span id="validate-count">validate <span id="validate-num"></span> times</span>
				</div>
				<div id="buildingCatChart-container" style="width: 500px; height: 400px;">
					<canvas id="buildingCatChart" width="350" height="225"></canvas>
				</div>
				<div id="osChart-container" style="width: 500px; height: 400px;">
					<canvas id="osChart" width="350" height="225"></canvas>
				</div>
				<div id="browserChart-container" style="width: 500px; height: 400px;">
					<canvas id="browserChart" width="350" height="225"></canvas>
				</div>
			</div>
		</div>
		
		<div class="tab-pane" id="validate-logs" >
			<div align="center">
				<h2>Logs</h2>
				<table class="table table-hover legend-table text-left" id="validate-logs-table">
					<tr>
						<th>#</th>
						<th>time</th>
						<th>os</th>
						<th>browser</th>
						<th>ip</th>
						<th>coor-xy</th>
						<th>building type</th>
					</tr>
				</table>
			</div>
		</div>
		
		<div class="tab-pane" id="evaluation" >
			<div align="center">
				<h2>System Evaluation</h2>
			</div>
			<div align="center" class="text-center">
				<span id="evaluation-count">evaluate <span id="evaluation-num"></span> times</span>
			</div>
			<div id="graph-container" align="center" >
				<div id="userGroupChart-container" style="width: 500px; height: 400px;">
					<canvas id="userGroupChart" width="350" height="225"></canvas>
				</div>
			</div>
			<div id="graph-container"  class="col-md-6" >
				<div class="text-center"><span class="rank-header">ความสะดวกในการใช้งานระบบตรวจสอบ</span></div>
				<div id="rank1Chart-container" style="width: 500px; height: 400px;">
					<canvas id="rank1Chart" width="350" height="225"></canvas>
				</div>
				<div class="text-center"><span class="rank-header">ประโยชน์ที่ได้รับจากระบบตรวจสอบ</span></div>
				<div id="rank3Chart-container" style="width: 500px; height: 400px;">
					<canvas id="rank3Chart" width="350" height="225"></canvas>
				</div>
			</div>
			<div id="graph-container"  class="col-md-6" >
				<div class="text-center"><span class="rank-header">ความถูกต้อง/ความน่าเชื่อถือของผลการตรวจสอบ</span></div>
				<div id="rank2Chart-container" style="width: 500px; height: 400px;">
					<canvas id="rank2Chart" width="350" height="225"></canvas>
				</div>
				<div class="text-center"><span class="rank-header">ความพึงพอใจโดยรวมของเว็บไซต์ระบบตรวจสอบ</span></div>
				<div id="rank4Chart-container" style="width: 500px; height: 400px;">
					<canvas id="rank4Chart" width="350" height="225"></canvas>
				</div>
			</div>
		</div>
		
		<div class= "tab-pane" id="feedback" >
			<div align="center">
				<h2>Message</h2>
				<table class="table table-hover legend-table text-left" id="message-table">
					<tr>
						<th>id</th>
						<th>name</th>
						<th>email</th>
						<th>subject</th>
						<th width="300px">message</th>
						<th>date-time</th>
					</tr>
				</table>
			</div>
		</div>
    </div>
  </div>
</div>						
</body>


<script>
	// initial graph and tabular
	// graph
	
	var buildingCatChart;
	var osChart;
	var browserChart;
	var userGroupChart;
	var rankChart;

	var cat_data = null;
	var cat_color = null;
	
	var os_data = null;
	var os_color = null;
	var os_label = null;
	
	var browser_data = null;
	var browser_color = null;
	var browser_label = null;
	
	var gmarkers = [];
	var map = null;
	$.post( "get_validate.php",{ time: $('#time-index').val() }, function (j){
		index_json_obj = $.parseJSON(j);
		
		//cat
		cat_data = index_json_obj["cat"].count;
		cat_color = index_json_obj["cat"].color;
		cat_label = index_json_obj["cat"].label;
		var catData = {
			labels: cat_label,
			datasets: [
				{
					data: cat_data,
					backgroundColor: cat_color,
					hoverBackgroundColor: cat_color
				}]
		};
		var ctx = document.getElementById("buildingCatChart");	
		buildingCatChart = new Chart(ctx, {
			type: 'pie',
			data: catData
		});	
		
		//os
		os_data = index_json_obj["os"].count;
		os_color = index_json_obj["os"].color;
		os_label = index_json_obj["os"].label;
		var osData = {
		labels: os_label,
		datasets: [
			{
				data: os_data,
				backgroundColor: os_color,
				hoverBackgroundColor: os_color
			}]
		};
		var ctx = document.getElementById("osChart");	
		osChart = new Chart(ctx, {
			type: 'doughnut',
			data: osData
		});
		
		//browser
		browser_data = index_json_obj["browser"].count;
		browser_color = index_json_obj["browser"].color;
		browser_label = index_json_obj["browser"].label;
		var browserData = {
		labels: browser_label,
		datasets: [
			{
				data: browser_data,
				backgroundColor: browser_color,
				hoverBackgroundColor: browser_color
			}]
		};
		var ctx = document.getElementById("browserChart");	
		browserChart = new Chart(ctx, {
			type: 'doughnut',
			data: browserData
		});
		
		
		// load google map
		initMap();
	});
	
	$.post( "get_evaluate.php",{ time: $('#time-index').val() }, function (j){
		index_json_obj = $.parseJSON(j);
		
		
		
		//user
		group_data = index_json_obj["group"].count;
		group_color = index_json_obj["group"].color;
		group_label = index_json_obj["group"].label;
		var groupData = {
			labels: group_label,
			datasets: [
				{
					data: group_data,
					backgroundColor: group_color,
					hoverBackgroundColor: group_color
				}]
		};
		var ctx = document.getElementById("userGroupChart");	
		userGroupChart = new Chart(ctx, {
			type: 'pie',
			data: groupData
		});	
		
		//count all
		var count = group_data[0]+group_data[1]+group_data[2]+group_data[3]
		$('#evaluation-num').empty();
		$('#evaluation-num').append(count);

		//rank1
		rank1_data = index_json_obj["rank1"].count;
		rank1_color = index_json_obj["rank1"].color;
		rank1_label = index_json_obj["rank1"].label;
		var rank1Data = {
			labels: rank1_label,
			datasets: [
				{
					data: rank1_data,
					backgroundColor: rank1_color,
					hoverBackgroundColor: rank1_color
				}]
		};
		var ctx = document.getElementById("rank1Chart");	
		rank1Chart = new Chart(ctx, {
			type: 'pie',
			data: rank1Data
		});	
		
		//rank2
		rank2_data = index_json_obj["rank2"].count;
		rank2_color = index_json_obj["rank2"].color;
		rank2_label = index_json_obj["rank2"].label;
		var rank2Data = {
			labels: rank2_label,
			datasets: [
				{
					data: rank2_data,
					backgroundColor: rank2_color,
					hoverBackgroundColor: rank2_color
				}]
		};
		var ctx = document.getElementById("rank2Chart");	
		rank2Chart = new Chart(ctx, {
			type: 'pie',
			data: rank2Data
		});
		
		//rank3
		rank3_data = index_json_obj["rank3"].count;
		rank3_color = index_json_obj["rank3"].color;
		rank3_label = index_json_obj["rank3"].label;
		var rank3Data = {
			labels: rank3_label,
			datasets: [
				{
					data: rank3_data,
					backgroundColor: rank3_color,
					hoverBackgroundColor: rank3_color
				}]
		};
		var ctx = document.getElementById("rank3Chart");	
		rank3Chart = new Chart(ctx, {
			type: 'pie',
			data: rank3Data
		});
		
		//rank4
		rank4_data = index_json_obj["rank4"].count;
		rank4_color = index_json_obj["rank4"].color;
		rank4_label = index_json_obj["rank4"].label;
		var rank4Data = {
			labels: rank4_label,
			datasets: [
				{
					data: rank4_data,
					backgroundColor: rank4_color,
					hoverBackgroundColor: rank4_color
				}]
		};
		var ctx = document.getElementById("rank4Chart");	
		rank4Chart = new Chart(ctx, {
			type: 'pie',
			data: rank4Data
		});
		
	});
	
	// tabular
	
	$.post( "get_validate_logs.php",{ time: $('#time-index').val() }, function (j){
		index_json_obj = $.parseJSON(j);
		i = 1;
		$.each(index_json_obj, function() {
			$('#validate-logs-table').append('<tr><td>'+i+'</td><td>'+this['time_stamp']+'</td><td>'+this['os']+'</td><td>'+this['browser']+'</td><td><a <a href="http://ipinfo.io/'+this['ip']+'/" target="_blank" >'+this['ip']+'</a></td><td><a href="#" onclick="showXYonGoogleMap(\''+this['coor_xy']+'\')">'+this['coor_xy']+'</a></td><td><span style="cursor: pointer;" title="'+this['category_name']+'/'+this['group_name_sub']+'/'+this['oper_prod_name_sub']+'">'+this['build_up_index']+'</span></td></tr>');
			i++;
		});
		$('#validate-num').empty();
		$('#validate-num').append(i-1);
	});

	$.post( "get_message.php",{ time: $('#time-index').val() }, function (j){
		index_json_obj = $.parseJSON(j);
		i = 1;
		$.each(index_json_obj, function() { 
			$('#message-table').append('<tr><td>'+i+'</td><td>'+this['name']+'</td><td>'+this['email']+'</td><td>'+this['subject']+'</td><td>'+this['message']+'</td><td>'+this['datetime']+'</td></tr>');
			i++;
		});
	});
	
    $('#myTab a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })   
	
	function removeMarkers(){ 
		for(i=0; i<gmarkers.length; i++){
			gmarkers[i].setMap(null);
		}
	}

	
	 
	// update grahp and tabular accoding to time
	$('#time-index').change(function() {
		//message update
		$.post( "get_message.php",{ time: $('#time-index').val() }, function (j){
			$('#message-table tr td').remove();
			index_json_obj = $.parseJSON(j);
			i = 1;
			$.each(index_json_obj, function() {
				$('#message-table').append('<tr><td>'+i+'</td><td>'+this['name']+'</td><td>'+this['email']+'</td><td>'+this['subject']+'</td><td>'+this['message']+'</td><td>'+this['datetime']+'</td></tr>');
				i++;
			});
		});
		//validate logs file update
		$.post( "get_validate_logs.php",{ time: $('#time-index').val() }, function (j){
			$('#validate-logs-table tr td').remove();
			index_json_obj = $.parseJSON(j);
			i = 1;
			$.each(index_json_obj, function() {
				ip = '"'+this['ip']+'"';
				$('#validate-logs-table').append('<tr><td>'+i+'</td><td>'+this['time_stamp']+'</td><td>'+this['os']+'</td><td>'+this['browser']+'</td><td><a href="http://ipinfo.io/'+this['ip']+'/" target="_blank">'+this['ip']+'</a></td><td><a href="#" onclick="showXYonGoogleMap(\''+this['coor_xy']+'\')">'+this['coor_xy']+'</a></td><td><span style="cursor: pointer;" title="'+this['category_name']+'/'+this['group_name_sub']+'/'+this['oper_prod_name_sub']+'">'+this['build_up_index']+'</span></td></tr>');
				i++;
			});
			$('#validate-num').empty();
			$('#validate-num').append(i-1);
		});
		
		
		$.post( "get_validate.php",{ time: $('#time-index').val() }, function (j){
			index_json_obj = $.parseJSON(j);
		// category update	
			cat_data = null;
			cat_color = null
			cat_data = index_json_obj["cat"].count;
			cat_color = index_json_obj["cat"].color;
			cat_label = index_json_obj["cat"].label;
			buildingCatChart.data.labels = cat_label;
			buildingCatChart.data.datasets[0] = {data: cat_data, backgroundColor: cat_color, hoverBackgroundColor: cat_color}
			buildingCatChart.update();
		// os update
			os_data = null;
			os_color = null;
			os_label = null;
			os_data = index_json_obj["os"].count;
			os_color = index_json_obj["os"].color;
			os_label = index_json_obj["os"].label;
			osChart.data.labels = os_label;
			osChart.data.datasets[0] = {data: os_data, backgroundColor: os_color, hoverBackgroundColor: os_color}
			osChart.update();
		// browser update
			browser_data = null;
			browser_color = null;
			browser_label = null;
			browser_data = index_json_obj["browser"].count;
			browser_color = index_json_obj["browser"].color;
			browser_label = index_json_obj["browser"].label;
			browserChart.data.labels = browser_label;
			browserChart.data.datasets[0] = {data: browser_data, backgroundColor: browser_color, hoverBackgroundColor: browser_color}
			browserChart.update();
		});
		
		// map update
		
		$.post( "get_validate_logs.php",{ time: $('#time-index').val() }, function (j){
			removeMarkers();
			index_json_obj = $.parseJSON(j);
			$.each(index_json_obj, function() {
				// re-coordinate
				xy = this['coor_xy'].split(",");
				latLong = proj4('EPSG:3857', 'EPSG:4326',[xy[0],xy[1]]);
				
				switch(this['build_up_index'].substr(0,1)){
				case 'B':
					color = "#FF6384";
					break;
				case 'F':
					color = "#983ef2";
					break;
				case 'G':
					color = "#f44242";
					break;
				case 'I':
					color = "#36A2EB";
					break;
				case 'L':
					color = "#3ef27a";
					break;
				case 'P':
					color = "#FFCE56";
					break;
				case 'a':
					color = "#ff8000";
					break;
				}

				var circle ={
					path: google.maps.SymbolPath.CIRCLE,
					fillColor: color,
					fillOpacity: .9,
					scale: 4.5,
					strokeColor: 'white',
					strokeWeight: 1
				};
				// Let's also add a marker while we're at it
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(latLong[1], latLong[0]),
					map: map,
					icon: circle,
					title: this['build_up_index']
				});
				
				// Push your newly created marker into the array:
				gmarkers.push(marker);
			});
		});
	});


	function initMap() {
	
		// Basic options for a simple Google Map
		// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions

		var myLatLng = new google.maps.LatLng(7.979732, 98.350139);

		var mapOptions = {
			zoom: 11,
			center: myLatLng,
			disableDefaultUI: false,
			scrollwheel: false,
			navigationControl: true,
			mapTypeControl: false,
			scaleControl: false,
			draggable: true,
		}
		


		// Get the HTML DOM element that will contain your map 
		// We are using a div with id="map" seen below in the <body>
		var mapElement = document.getElementById('map-canvas');

		// Create the Google Map using our element and options defined above
		map = new google.maps.Map(mapElement, mapOptions);
		
		// Create the DIV to hold the control and call the CenterControl()
        // constructor passing in this DIV.
        var centerControlDiv = document.createElement('div');
        var centerControl = new CenterControl(centerControlDiv, map);

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

		
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
		
		$.post( "get_validate_logs.php",{ time: $('#time-index').val() }, function (j){
			index_json_obj = $.parseJSON(j);
			
			$.each(index_json_obj, function() {
				// re-coordinate
				xy = this['coor_xy'].split(",");
				latLong = proj4('EPSG:3857', 'EPSG:4326',[xy[0],xy[1]]);
				
				switch(this['build_up_index'].substr(0,1)){
				case 'B':
					color = "#FF6384";
					break;
				case 'F':
					color = "#983ef2";
					break;
				case 'G':
					color = "#f44242";
					break;
				case 'I':
					color = "#36A2EB";
					break;
				case 'L':
					color = "#3ef27a";
					break;
				case 'P':
					color = "#FFCE56";
					break;
				case 'a':
					color = "#ff8000";
					break;
				}

				var circle ={
					path: google.maps.SymbolPath.CIRCLE,
					fillColor: color,
					fillOpacity: .9,
					scale: 4.5,
					strokeColor: 'white',
					strokeWeight: 1
				};
				// Let's also add a marker while we're at it
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(latLong[1], latLong[0]),
					map: map,
					icon: circle,
					title: this['build_up_index']
				});
				
				// Push your newly created marker into the array:
				gmarkers.push(marker);
				
			
			});
		});
		

		
	}
	
	function showXYonGoogleMap(coorxy){

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
		latLong = proj4('EPSG:3857', 'EPSG:4326',[xy[0],xy[1]])

		url = "https://maps.google.com/maps?z=12&t=k&q="+latLong[1]+","+latLong[0]
		//alert(url)
		window.open(url,'_blank');
		
	}

	function CenterControl(controlDiv, map) {

		// Set CSS for the control border.
		var controlUI = document.createElement('div');
		controlUI.style.backgroundColor = '#fff';
		controlUI.style.border = '2px solid #fff';
		controlUI.style.borderRadius = '3px';
		controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
		controlUI.style.cursor = 'pointer';
		controlUI.style.marginBottom = '22px';
		controlUI.style.textAlign = 'center';
		controlUI.title = 'Click to recenter the map';
		controlDiv.appendChild(controlUI);

		// Set CSS for the control interior.
		var controlText = document.createElement('div');
		controlText.style.color = 'rgb(25,25,25)';
		controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
		controlText.style.fontSize = '16px';
		controlText.style.lineHeight = '38px';
		controlText.style.paddingLeft = '5px';
		controlText.style.paddingRight = '5px';
		controlText.innerHTML = 'Center Map';
		controlUI.appendChild(controlText);

		// Setup the click event listeners: simply set the map to Chicago.
		controlUI.addEventListener('click', function() {
		  map.setCenter({lat: 7.979732, lng: 98.350139});
		  map.setZoom(11);
		});

	}

	
</script>
<!-- local key -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCur6MaPaTB5QKXNdN7N4JFJZoCBko9FC4&callback=initMap"></script>
</html>
<?php
	}
}
?>