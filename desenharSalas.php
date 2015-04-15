<!DOCTYPE html>
<html>
    <head>
        <title>LocalizeSenac - Mapa dos Ambientes</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="../bower_components/leaflet/dist/css/leaflet.css" />
		<link rel="stylesheet" href="../bower_components/leafletdraw/dist/css/leaflet.draw.css" />
	
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="lib/leaflet/leaflet.ie.css" />
		<link rel="stylesheet" href="leaflet.draw.ie.css" />
	<![endif]-->
	
	<script src="../bower_components/leaflet/dist/js/leaflet.js"></script>
	<script src="../bower_components/leafletdraw/dist/js/leaflet.draw.js"></script>
	<script type="text/javascript" src="../script/leaf/limitesUnidade1Senac.js"></script> <!-- arquivo com o GeoJson do limite da unidade 1 -->
</head>
<body>

<div id="map" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>

<script>
	
		//var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		var osmUrl = 'http://a{s}.acetate.geoiq.com/tiles/acetate-hillshading/{z}/{x}/{y}.png',
			osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			osm = L.tileLayer(osmUrl, {maxZoom: 24, attribution: osmAttrib}),
			//map = new L.Map('map', {layers: [osm], center: new L.LatLng(-30.035476, -51.22593), zoom: 19.5 });
			map = L.map('map').setView([-30.035476, -51.22593], 20.2);

		// configuracao de estilo dos poligonos
		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.7,
				fillColor: '#00FF00'
			};
		}
	
		// armazena o GeoJson na variavel
		var geojson = L.geoJson(limites, {
			//style: style
		}).addTo(map);	
	
		
		var drawnItems = new L.FeatureGroup();
		map.addLayer(drawnItems);

		var drawControl = new L.Control.Draw({
			draw: {
				position: 'topleft',
				polygon: {
					title: 'Draw a sexy polygon!',
					allowIntersection: false,
					drawError: {
						color: '#b00b00',
						timeout: 1000
					},
					shapeOptions: {
						color: '#bada55'
					},
					showArea: true
				},
				polyline: {
					metric: false
				},
				circle: {
					shapeOptions: {
						color: '#662d91'
					}
				}
			},
			edit: {
				featureGroup: drawnItems
			}
		});
		map.addControl(drawControl);

		// metodo map.on original, apenas desenha
		/*
		map.on('draw:created', function (e) {
			var type = e.layerType,
				layer = e.layer;

			if (type === 'marker') {
				layer.bindPopup('A popup!');
			}

			drawnItems.addLayer(layer);
		});
		*/
		
		map.on('draw:created', function (e) {
			var type = e.layerType,
				layer = e.layer;

			// gerar GeoJson dos poligonos
			if (type === 'polygon') {
				// structure the geojson object
				var geojson = {};
				geojson['type'] = 'Feature';
				geojson['geometry'] = {};
				geojson['geometry']['type'] = "Polygon";

				// export the coordinates from the layer
				coordinates = [];
				latlngs = layer.getLatLngs();
				for (var i = 0; i < latlngs.length; i++) {
					coordinates.push([latlngs[i].lng, latlngs[i].lat])
				}

				// push the coordinates to the json geometry
				geojson['geometry']['coordinates'] = [coordinates];

				// Finally, show the poly as a geojson object in the console
				console.log(JSON.stringify(geojson));

			}
			else if(type === 'rectangle'){
				// structure the geojson object
				var geojson = {};
				geojson['type'] = 'Feature';
				geojson['geometry'] = {};
				geojson['geometry']['type'] = "Rectangle";

				// export the coordinates from the layer
				coordinates = [];
				latlngs = layer.getLatLngs();
				for (var i = 0; i < latlngs.length; i++) {
					coordinates.push([latlngs[i].lng, latlngs[i].lat])
				}

				// push the coordinates to the json geometry
				geojson['geometry']['coordinates'] = [coordinates];

				// Finally, show the poly as a geojson object in the console
				console.log(JSON.stringify(geojson));
			}
			

			drawnItems.addLayer(layer);
		});
	
/*
 *  Inicio do armazenamento das formas para enviar ao banco
 */
 
 /*
    var shapes = getShapes(drawnItems);

    // Process them any way you want and save to DB
    //...



var getShapes = function(drawnItems) {

    var shapes = [];

    drawnItems.eachLayer(function(layer) {

        // Note: Rectangle extends Polygon. Polygon extends Polyline.
        // Therefore, all of them are instances of Polyline
        if (layer instanceof L.Polyline) {
            shapes.push(layer.getLatLngs())
        }

        if (layer instanceof L.Circle) {
            shapes.push([layer.getLatLng()])
        }

        if (layer instanceof L.Marker) {
            shapes.push([layer.getLatLng()]);
        }

    });

    return shapes;
};
	*/
	</script>
</body>
</html>


</body>

</html>