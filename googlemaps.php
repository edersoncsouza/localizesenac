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
			
			map = new google.maps.Map(document.getElementById("map-canvas"),
				mapOptions);
			
			var marker = new google.maps.Marker({
				position: map.getCenter(),
				map: map,
				title: 'Click to zoom'
			});

		  google.maps.event.addListener(map, 'center_changed', function() {
			// 3 seconds after the center of the map has changed, pan back to the marker.
			window.setTimeout(function() {
			  map.panTo(marker.getPosition());
			}, 3000);
		  });
		
			camada1 = new google.maps.GroundOverlay('images/1andar.svg', limitesCamada);
			camada2 = new google.maps.GroundOverlay('images/2andar.svg', limitesCamada);
			addOverlay();
			
			
		  }
		  
		function addOverlay() {
			camada1.setMap(map);
			camada2.setMap(map);
		}	

		function removeOverlay() {
		  camada1.setMap(null);
		  camada1.setMap(null);
		}
		
		google.maps.event.addDomListener(window, 'load', initialize);
		  
    </script>

		<!-- FINAL DO GOOGLE MAPS -->
    </head> <!-- <head> -->
	
	
    <body onload="initialize()">
	
		<div id="map-canvas" style="width:90%; height:90%"></div>

    </body>

</html>