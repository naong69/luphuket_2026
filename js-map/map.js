var extent = [-13884991, 2870341, -7455066, 6338219];
var center = [10947620, 890723];
//var phuket_extent = [10913000, 916000, 10970000, 810000];
var phuket_extent = ol.proj.transformExtent([98.002, 7.255, 98.550, 8.228], 'EPSG:4326', 'EPSG:3857');

// This dummy layer tells Google Maps to switch to its default map type
var googleLayerHybrid = new olgm.layer.Google({
	mapTypeId: google.maps.MapTypeId.HYBRID
});

var googleLayerRoadmap = new olgm.layer.Google({
	mapTypeId: google.maps.MapTypeId.ROADMAP,
	visible: false
});

// boundary, water, road, power line maps
/*
var tileWMSLayer_Pk_Boundary  =  new ol.layer.Tile({
  extent: [-13884991, 2870341, -7455066, 6338219],
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			LAYERS: 'phuket_lu_law:pk_admin_boundary'},
	serverType: 'geoserver'
  }),
  visible: true
});

var tileWMSLayer_Pk_Road  =  new ol.layer.Tile({
  extent: [-13884991, 2870341, -7455066, 6338219],
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			LAYERS: 'phuket_lu_law:pk_road_for_lu_check'},
	serverType: 'geoserver'
  }),
  visible: true
});
tileWMSLayer_Pk_Road.setOpacity(0.4)

var tileWMSLayer_Pk_Water  =  new ol.layer.Tile({
  extent: [-13884991, 2870341, -7455066, 6338219],
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			LAYERS: 'phuket_lu_law:pk_water_body_for_lu_check'},
	serverType: 'geoserver'
  }),
  visible: true
});
tileWMSLayer_Pk_Water.setOpacity(0.4)
*/

var tileWMSLayer_Pk_Boundary  =  new ol.layer.Tile({
  extent: phuket_extent,
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			LAYERS: 'phuket_lu_law:pk_admin_boundary'},
	serverType: 'geoserver'
  }),
  visible: true
});

var tileWMSLayer_Pk_Public_Area  =  new ol.layer.Tile({
  extent: phuket_extent,
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			 'LAYERS': 'phuket_lu_law:pk_public_area',
			 'TILED': true},
	serverType: 'geoserver'
  }),
  visible: true
});
tileWMSLayer_Pk_Public_Area.setOpacity(0.5)

// laws map
var tileWMSLayer_Pk_Envi_2560  =  new ol.layer.Tile({
  extent: phuket_extent,
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
	params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1', 
			 'LAYERS': 'phuket_lu_law:pk_en_act_2560',
			 'TILED': true},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Envi_2560.setOpacity(0.4)

var tileWMSLayer_Pk_Bc_15  =  new ol.layer.Tile({
  extent: phuket_extent,
  source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
		  params: {'FORMAT': 'image/png',
				   'VERSION': '1.1.1',  
				 'LAYERS': 'phuket_lu_law:pk_bc15_act_2529',
				 'TILED': true},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Bc_15.setOpacity(0.4)

var tileWMSLayer_Pk_Bc_20  =  new ol.layer.Tile({
  extent: phuket_extent,
   source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
		  params: {'FORMAT': 'image/png',
				   'VERSION': '1.1.1',  
				   'LAYERS': 'phuket_lu_law:pk_bc20_act_2532',
				   'TILED': true},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Bc_20.setOpacity(0.4)

var tileWMSLayer_Pk_Cp_2558  =  new ol.layer.Tile({
  extent: phuket_extent,
   source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
		  params: {'FORMAT': 'image/png',
				   'VERSION': '1.1.1',  
				   'LAYERS': 'phuket_lu_law:pk_cp_act_2558',
				   'TILED': true},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Cp_2558.setOpacity(0.4)

var tileWMSLayer_Pk_Patong_Lu_Act_2548  =  new ol.layer.Tile({
  extent: phuket_extent,
   source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
		  params: {'FORMAT': 'image/png',
				   'VERSION': '1.1.1',  
				LAYERS: 'phuket_lu_law:pk_patong_lu_act_2548'},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Patong_Lu_Act_2548.setOpacity(0.4)

var tileWMSLayer_Pk_Slope  =  new ol.layer.Tile({
  extent: phuket_extent,
   source: new ol.source.TileWMS({
    url: 'http://52.77.120.244:8080/geoserver/phuket_lu_law/wms',
		  params: {'FORMAT': 'image/png',
				   'VERSION': '1.1.1',  
				LAYERS: 'phuket_lu_law:pk_slope_dem5m'},
    serverType: 'geoserver'
  }),
  visible: false
});
tileWMSLayer_Pk_Slope.setOpacity(0.4)


// DOL 
var url_ = "";
var d = new Date();
var random_server = d.getTime();
random_server = random_server % 4;

if (random_server == 0) { url_ = 'http://110.164.49.72:8081/geoserver/WMSDOL/wms?' }
if (random_server == 1) { url_ = 'http://110.164.49.76:8081/geoserver/WMSDOL/wms?'; }
if (random_server == 2) { url_ = 'http://110.164.49.72:8081/geoserver/WMSDOL/wms?'; }
if (random_server == 3) { url_ = 'http://110.164.49.76:8081/geoserver/WMSDOL/wms?'; }

console.log("final: "+url_);
//http://125.25.43.70:8081/
var tileWMSLayer_WMSDOL  =  new ol.layer.Tile({
  extent: phuket_extent,
  source: new ol.source.TileWMS({
    url: url_ ,
    params: {'FORMAT': 'image/png',
			 'VERSION': '1.1.1',
			 'SRS': 'EPSG:4326', 
			 'LAYERS': 'WMSDOL:MV_SPARCEL_47',
			 'WIDTH': '256',
			 'HEIGHT': '256',
			 'TILED': true},
	serverType: 'geoserver'
  }),
  visible: false
});


//create home button control
/**
* Define a namespace for the application.
*/
window.app = {};
var app = window.app;
//
// Define home control.
//
/**
* @constructor
* @extends {ol.control.Control}
* @param {Object=} opt_options Control options.
*/

app.HomeControl = function(opt_options) {

	var options = opt_options || {};

	var button = document.createElement('button');
	button.innerHTML = 'H';

	var this_ = this;
	var handleHomeControl = function() {
	  this_.getMap().getView().setCenter(center);
	  this_.getMap().getView().setZoom(11);
	  tileWMSLayer_Pk_Boundary.setVisible(true);
	  //tileWMSLayer_Pk_Water.setVisible(true);
	  //tileWMSLayer_Pk_Road.setVisible(true);
	  //tileWMSLayer_Pk_Powerline.setVisible(true);
	  tileWMSLayer_Pk_Public_Area.setVisible(true);
	  tileWMSLayer_Pk_Envi_2560.setVisible(false);
	  tileWMSLayer_Pk_Cp_2558.setVisible(false);
	  tileWMSLayer_Pk_Bc_15.setVisible(false);
	  tileWMSLayer_Pk_Bc_20.setVisible(false);
	  tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
	  tileWMSLayer_Pk_Slope.setVisible(false);
	  //tileWMSLayer_WMSDOL.setVisible(false);
	  vectorLayer.setVisible(false);
	  
	  lawmap_ = "";
	  $(".legend-box").hide();
	  $("#legend-phuket").show()
	};
	
	
	button.addEventListener('click', handleHomeControl, false);
	button.addEventListener('touchstart', handleHomeControl, false);

	var element = document.createElement('div');
	element.className = 'home-button ol-unselectable ol-control';
	element.title = 'กลับไปที่ตำแหน่งเริ่มต้น';
	element.appendChild(button);

	ol.control.Control.call(this, {
	  element: element,
	  target: options.target
	});

};
ol.inherits(app.HomeControl, ol.control.Control);


// create marker

var pointMarker = new ol.Feature({
        type: 'icon',
        geometry: new ol.geom.Point(center)
      });

var markerStyle =  new ol.style.Style({
	  image: new ol.style.Icon({
		anchor: [0.5, 1],
		src: './img/icons/map-marker.png'
	  })
})
pointMarker.setStyle(markerStyle)

var vectorLayer = new ol.layer.Vector({
	source: new ol.source.Vector({
	  features: [pointMarker]
	}),
	visible: false
});


var map = new ol.Map({
  // use OL3-Google-Maps recommended default interactions
  interactions: olgm.interaction.defaults(),
  controls: ol.control.defaults({
			zoom: false,
			attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
            collapsible: false
          })
        }).extend([
          new app.HomeControl(),
		  new ol.control.FullScreen({
			  tipLabel: 'ย่อ-ขยายเต็มหน้าจอ'
		  })
        ]),
  	layers: [
		googleLayerRoadmap,
		googleLayerHybrid,
		tileWMSLayer_Pk_Slope,
		//tileWMSLayer_Pk_Water,
		//tileWMSLayer_Pk_Road,
		//tileWMSLayer_Pk_Powerline,
		tileWMSLayer_Pk_Public_Area,
		tileWMSLayer_Pk_Boundary,
		tileWMSLayer_Pk_Envi_2560,
		tileWMSLayer_Pk_Cp_2558,
		tileWMSLayer_Pk_Bc_15,
		tileWMSLayer_Pk_Bc_20,
		tileWMSLayer_Pk_Patong_Lu_Act_2548,
		tileWMSLayer_WMSDOL,
		vectorLayer
	],
  	target: 'map',
  	view: new ol.View({
    	center: center,
    	extent: phuket_extent,
    	zoom: 11,
		minZoom: 11,
		maxZoom: 19 
	}),
  	moveTolerance: 500
});

map.on('moveend', function(e) {
  	var view = map.getView();
	if(view.getZoom() >= 16){ // need to zoom more
	 	if(lawmap_ == 'slope' && vectorLayer.getVisible() == false){	
	 		tileWMSLayer_Pk_Boundary.setVisible(false);
			//tileWMSLayer_Pk_Water.setVisible(true);
			//tileWMSLayer_Pk_Road.setVisible(true);
			//tileWMSLayer_Pk_Powerline.setVisible(true);
			tileWMSLayer_Pk_Public_Area.setVisible(false);
			tileWMSLayer_Pk_Slope.setVisible(true);
			tileWMSLayer_Pk_Envi_2560.setVisible(false);
			tileWMSLayer_Pk_Cp_2558.setVisible(false);
			tileWMSLayer_Pk_Bc_15.setVisible(false);
			tileWMSLayer_Pk_Bc_20.setVisible(false);
			tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
	 		$(".legend-box").hide();
			$("#legend-slope").show()
	 	}
	} else {
		tileWMSLayer_Pk_Slope.setVisible(false);
	}
});

var map_obj_array = [tileWMSLayer_Pk_Envi_2560,
	tileWMSLayer_Pk_Cp_2558,
	tileWMSLayer_Pk_Bc_15,
	tileWMSLayer_Pk_Bc_20,
	tileWMSLayer_Pk_Patong_Lu_Act_2548]


// custom zoom control
map.addControl(new ol.control.Zoom({
    zoomInTipLabel: 'ขยายเข้า',
	zoomOutTipLabel: 'ขยายออก'
}));


var olGM = new olgm.OLGoogleMaps({map: map}); // map is the ol.Map instance
olGM.activate();

// change based map
function changeBasedMap(basedmap) {
	if(basedmap == 'hybrid'){
		googleLayerRoadmap.setVisible(false);
		googleLayerHybrid.setVisible(true);
	}
	if(basedmap == 'road'){
		googleLayerRoadmap.setVisible(true);
		googleLayerHybrid.setVisible(false);
	}
}

// change law map
var lawmap_ = "";
function changeLawMap(lawmap){
	lawmap_ = lawmap;
	
	if(lawmap == 'boundary'){
		tileWMSLayer_Pk_Boundary.setVisible(true);
		//tileWMSLayer_Pk_Water.setVisible(true);
		//tileWMSLayer_Pk_Road.setVisible(true);
		//tileWMSLayer_Pk_Powerline.setVisible(true);
		tileWMSLayer_Pk_Public_Area.setVisible(true);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter(center);
			map.getView().setZoom(11);
		}
		$(".legend-box").hide();
		$("#legend-phuket").show()
	}
	
	if(lawmap == 'slope'){
		var view = map.getView();
		if(view.getZoom() < 16){ // need to zoom more
			$('#slope-alert').fadeIn().delay(2500).fadeOut();
		} else {
			tileWMSLayer_Pk_Slope.setVisible(true);
		}
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(true);
		//tileWMSLayer_Pk_Road.setVisible(true);
		//tileWMSLayer_Pk_Powerline.setVisible(true);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
		}
		$(".legend-box").hide();
		$("#legend-slope").show()
		
	}
	
	if(lawmap == 'envi'){
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(false);
		//tileWMSLayer_Pk_Road.setVisible(false);
		//tileWMSLayer_Pk_Powerline.setVisible(false);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(true);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter(center);
			map.getView().setZoom(11);
		}
		$(".legend-box").hide();
		$("#legend-act-envi").show()
	}
	
	if(lawmap == 'bc15'){
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(false);
		//tileWMSLayer_Pk_Road.setVisible(false);
		//tileWMSLayer_Pk_Powerline.setVisible(false);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(true);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter([10941407,882399]);
			map.getView().setZoom(14);
		}
		$(".legend-box").hide();
		$("#legend-act-bc15").show()
	}
	
	if(lawmap == 'bc20'){
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(false);
		//tileWMSLayer_Pk_Road.setVisible(false);
		//tileWMSLayer_Pk_Powerline.setVisible(false);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(true);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter(center);
			map.getView().setZoom(11);
		}
		$(".legend-box").hide();
		$("#legend-act-bc20").show()
	}
	
	if(lawmap == 'cp'){
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(false);
		//tileWMSLayer_Pk_Road.setVisible(false);
		//tileWMSLayer_Pk_Powerline.setVisible(false);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(true);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(false);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter(center);
			map.getView().setZoom(11);
		}
		$(".legend-box").hide();
		$("#legend-act-cp").show()
	}
	
	if(lawmap == 'patong'){
		tileWMSLayer_Pk_Boundary.setVisible(false);
		//tileWMSLayer_Pk_Water.setVisible(false);
		//tileWMSLayer_Pk_Road.setVisible(false);
		//tileWMSLayer_Pk_Powerline.setVisible(false);
		tileWMSLayer_Pk_Public_Area.setVisible(false);
		tileWMSLayer_Pk_Slope.setVisible(false);
		tileWMSLayer_Pk_Envi_2560.setVisible(false);
		tileWMSLayer_Pk_Cp_2558.setVisible(false);
		tileWMSLayer_Pk_Bc_15.setVisible(false);
		tileWMSLayer_Pk_Bc_20.setVisible(false);
		tileWMSLayer_Pk_Patong_Lu_Act_2548.setVisible(true);
		if(vectorLayer.getVisible() == false){
			vectorLayer.setVisible(false);
			map.getView().setCenter([10942415,882202]);
			map.getView().setZoom(14);
		}
		$(".legend-box").hide();
		$("#legend-act-patong").show()
	}
	
}

var mapZone;
var twoZone;
var xy;

map.on('singleclick', function(evt) {
	mapZone = [];
	twoZone = false;
	xy = evt.coordinate;

    var view = map.getView();
    var this_ = this;
    
	if(view.getZoom() < 16){ // need to zoom more
		if(vectorLayer.getVisible())
			vectorLayer.setVisible(false)
		$('#zoom-alert').fadeIn().delay(2500).fadeOut();
		validateInit();
	} else { 
		pointMarker.getGeometry().setCoordinates(evt.coordinate);
		vectorLayer.setVisible(true);

		// check if click on public area
		var viewResolution = view.getResolution();
		var source =  tileWMSLayer_Pk_Public_Area.getSource();
		var url_ = source.getGetFeatureInfoUrl(
			evt.coordinate, viewResolution, view.getProjection(),
			{'INFO_FORMAT': 'text/html', 'FEATURE_COUNT': 50});
		if (url_) {
			$.post( "geoserver_mid/get_zone.php", { url: url_ }, function (xml){
				var count_feature = $(xml).find('feature').length 
				if (count_feature != 0){ // click on public area polygon
					vectorLayer.setVisible(false)
					$('#public-area-alert').fadeIn().delay(2500).fadeOut();
					validateInit();
				} else { 
					// show select dropdown
					$(".legend-box").hide();
					$("#legend-validate").show();
					validateInit();
					
					mapZone = [];
					// start check zone for each acts
					$.each(map_obj_array, function(index, value){
						var source =  value.getSource();
						var url_ = source.getGetFeatureInfoUrl(
						evt.coordinate, viewResolution, view.getProjection(),
						{'INFO_FORMAT': 'text/html', 'FEATURE_COUNT': 50});
						if(url_){
							$.post( "geoserver_mid/get_zone.php", { url: url_ }, function (xml){
								
								var count_feature = $(xml).find('feature').length 
								if (count_feature == 1){
									$layer = $(xml).find( 'feature-id' );
									$zone = $(xml).find( 'zone' );
									$index = $(xml).find( 'index' );
									mz = $layer.text()+":"+$zone.text()+":"+$index.text();
									mapZone.push(mz);
									var width = $(window).width();
									if(width < 980){
										$('#legend-container').scrollView();
									}
								} else if (count_feature > 1 && !twoZone) { // more than 1 zone is selected
									if(vectorLayer.getVisible())
										vectorLayer.setVisible(false)
									$('#zoom-alert').fadeIn().delay(2500).fadeOut();
									twoZone = true;
									validateInit();
								}
							});	
						}
						
					});
				}
			});
		} 
	}

});

$('#map').mousedown(function() {
    $(this).addClass('grabbable');
}).mouseup(function() {
    $(this).removeClass('grabbable');
});

$.fn.scrollView = function () {
    return this.each(function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top
        }, 1000);
    });
}












