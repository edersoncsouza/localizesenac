<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LocalizeSenac - Sistema de Indoor Mapping para a Faculdade Senac Porto Alegre">
    <meta name="keywords" content="Indoor Mapping,mapeamento interno,Faculdade Senac Porto Alegre">
    <meta name="author" content="Ederson Souza">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="dist/components/leaflet/dist/css/leaflet.css" />
    <link rel="stylesheet" href="dist/components/leafletdraw/dist/css/leaflet.draw.css" />
	    <!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <script type="text/javascript" src="dist/components/leaflet/dist/js/leaflet.js"></script>
    <script type="text/javascript" src="dist/components/leafletdraw/dist/js/leaflet.draw.js"></script>
	<script type="text/javascript" src="dist/components/leaflet.filelayer/dist/js/leaflet.filelayer.js"></script>
    <script type="text/javascript" src="dist/js/limitesUnidade1Senac.js"></script>
    <!-- arquivo com o GeoJson do limite da unidade 1 -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="map" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>

    <script>
        //var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        var osmUrl = 'http://a{s}.acetate.geoiq.com/tiles/acetate-hillshading/{z}/{x}/{y}.png',
            osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            osm = L.tileLayer(osmUrl, {
                maxZoom: 24,
                attribution: osmAttrib
            }),
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

        // armazena o GeoJson dos limites do andar na variavel
        var geojson = L.geoJson(limites, {
            //style: style
        }).addTo(map);



		// INSTANCIA O CONTROLE DE CARREGAMENTO DE ARQUIVO PARA O MAPA
		L.Control.FileLayerLoad.LABEL = '<i class="fa fa-folder-open"></i>';
		/*
		L.Control.fileLayerLoad({
			// See http://leafletjs.com/reference.html#geojson-options
			layerOptions: {style: {color:'red'}},
			// Add to map after loading (default: true) ?
			addToMap: true,
			// File size limit in kb (default: 1024) ?
			fileSizeLimit: 1024,
			// Restrict accepted file formats (default: .geojson, .kml, and .gpx) ?
			formats: [
				'.geojson',
				'.kml'
			]
		}).addTo(map);
		*/
		
		// cria um grupo de features

		var controleArquivo = new L.Control.fileLayerLoad({
			// See http://leafletjs.com/reference.html#geojson-options
			layerOptions: {style: {color:'red'}},
			// Add to map after loading (default: true) ?
			addToMap: true,
			// File size limit in kb (default: 1024) ?
			fileSizeLimit: 1024,
			// Restrict accepted file formats (default: .geojson, .kml, and .gpx) ?
			formats: [
				'.geojson',
				'.kml'
			]
		}).addTo(map);


		// evento disparado quando as salas sao carregadas
        controleArquivo.loader.on('data:loaded', function(e) {
            var type = e.layerType,
                layer = e.layer;
				console.log(layer);
				alert("foi carregado");
				console.log(e);
		});
				
				
				
				
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

        map.on('draw:created', function(e) {
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

            } else if (type === 'rectangle') {
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