<!DOCTYPE html>
<html lang="pt-br">
    <!-- /* http://behstant.com/blog/?p=662 */ Ver isso, Ajax --> 


    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LocalizeSenac - Sistema de Localização FATEC POA</title>

        <link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
        <link type="text/css" rel="stylesheet" href="style/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-theme.min.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css" />

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

        <!--  para o ajax -->
        <script type="text/javascript" src="script/ajax.js"></script>
        <script type="text/javascript" src="script/instrucao.js"></script>

        <!--  funcoes em javascript -->
        <script type="text/javascript" src="script/funcoes.js"></script>
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

	
		<!-- INICIO DO GOOGLE MAPS -->
		<!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD_9uzBff-rTngZ9cBmFOluI3f7tpejlbU&sensor=FALSE"></script> -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
		<script type="text/javascript">
			var camada1;
			var map;
		  function initialize() {		

			var limitesCamada = new google.maps.LatLngBounds(
				new google.maps.LatLng(-30.035887, -51.226779),
				new google.maps.LatLng(-30.035104, -51.225490));
				
			var mapOptions = {
			  center: new google.maps.LatLng(-30.035057, -51.226513),
			  zoom: 20,
			  //mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			
			var limitesSenac;
			
			map = new google.maps.Map(document.getElementById("map-canvas"),
				mapOptions);
			
			var marker = new google.maps.Marker({
				position: map.getCenter(),
				map: map,
				title: 'Click to zoom'
			});

			map.data.loadGeoJson('data/data2.json');
			map.data.loadGeoJson('data/data.json');

			
		  google.maps.event.addListener(map, 'center_changed', function() {
			// 3 seconds after the center of the map has changed, pan back to the marker.
			window.setTimeout(function() {
			  map.panTo(marker.getPosition());
			}, 3000);
		  });
		
			//camada1 = new google.maps.GroundOverlay('images/1andar.svg', limitesCamada);
			//camada2 = new google.maps.GroundOverlay('images/2andar.svg', limitesCamada);
			//addOverlay();
			
// Define the LatLng coordinates for the polygon's path.
  var triangleCoords = [
    new google.maps.LatLng(25.77425200000001, -80.19026200000001),
    new google.maps.LatLng(18.46646500000001, -66.11829200000001),
    new google.maps.LatLng(32.32138400000001, -64.7573700000001),
    new google.maps.LatLng(25.77425200000001, -80.19026200000001)
  ];
  
   var limitesSenacCoord = [
		new google.maps.LatLng(-51.22668180623533, -30.035285121877315),
		new google.maps.LatLng(-51.2265336609083, -30.035087224146654),
		new google.maps.LatLng(-51.22647355243277, -30.03512094793035),
		new google.maps.LatLng(-51.22644383540727, -30.035081250849945),
		new google.maps.LatLng(-51.226048765364894, -30.035302904197504),
		new google.maps.LatLng(-51.22607762249031, -30.0353414525062),
		new google.maps.LatLng(-51.22602248063556, -30.035372389694686),
		new google.maps.LatLng(-51.22604615745694, -30.035404017959696),
		new google.maps.LatLng(-51.22556564497819, -30.035673607691603),
		new google.maps.LatLng(-51.225665301849794, -30.035806732096372),
		new google.maps.LatLng(-51.22571812974482, -30.03577709327882),
		new google.maps.LatLng(-51.225742071542506, -30.03580907537713),
		new google.maps.LatLng(-51.22607061675038, -30.035624746646363),
		new google.maps.LatLng(-51.226047618473885, -30.03559402487214),
		new google.maps.LatLng(-51.22619445159744, -30.03551164470813),
		new google.maps.LatLng(-51.2262191796104, -30.03554467714227),
		new google.maps.LatLng(-51.22668180623533, -30.035285121877315)
];
  // Construct the polygon.
 var bermudaTriangle = new google.maps.Polygon({
    paths: triangleCoords,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
			
limitesSenac = new google.maps.Polygon({
    paths: limitesSenacCoord,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });

	limitesSenac.setMap(map);
	//bermudaTriangle.setMap(map);
  
}
		/*  
		function addOverlay() {
			camada1.setMap(map);
			camada2.setMap(map);
		}	

		function removeOverlay() {
		  camada1.setMap(null);
		  camada1.setMap(null);
		}
		*/
		
		google.maps.event.addDomListener(window, 'load', initialize);
		  
    </script>

		<!-- FINAL DO GOOGLE MAPS -->
    </head> <!-- <head> -->
	
	
    <body onload="initialize()">
	
		<div id="map-canvas" style="width:90%; height:90%"></div>

    </body>

</html>