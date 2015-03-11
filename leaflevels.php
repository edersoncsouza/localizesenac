<!DOCTYPE html>
<html>
<head>
	<title>LocalizeSenac - Mapa dos Ambientes</title>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="style/leaf/leaflet.css" />

    <!--[if lte IE 8]><link rel="stylesheet" href="libs/leaflet.ie.css" /><![endif]-->

	<style>
		#map {
			width: 800px;
			height: 500px;
		}

		.info {
			padding: 6px 8px;
			font: 14px/16px Arial, Helvetica, sans-serif;
			background: white;
			background: rgba(255,255,255,0.8);
			box-shadow: 0 0 15px rgba(0,0,0,0.2);
			border-radius: 5px;
		}
		.info h4 {
			margin: 0 0 5px;
			color: #777;
		}

		.legend {
			text-align: left;
			line-height: 18px;
			color: #555;
		}
		.legend i {
			width: 18px;
			height: 18px;
			float: left;
			margin-right: 8px;
			opacity: 0.7;
		}
	</style>
</head>
<body>
	<div id="map"></div>

	<script src="script/jquery-2.1.3.min.js"></script>
    <script src="script/leaf/leaflet-src.js"></script>
	<script src="script/leaf/leaflet-indoor.js"></script>
	<!-- <script type="text/javascript" src="script/leaf/1andar_unidade1.js"></script>  -->
	<script type="text/javascript">
		
		// cria a variavel mapa, define o centro de visão e o nivel do zoom
		var map = L.map('map').setView([-30.035476, -51.22593], 19.5);

		// configura a camada quadriculada (tileLayer) que fica de fundo para o mapa vetorial
		L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
			maxZoom: 24,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			id: 'examples.map-20v6611k'
		}).addTo(map);

		// armazena os limites do mapa para posterior reset
		var limites = map.getBounds();
		
		// desativa o zoom por duplo clique ou no scrooll do mouse
		map.doubleClickZoom.disable();
		map.scrollWheelZoom.disable();
		
		// controle que exibe informacoes da sala ao selecionar
		var info = L.control();

		info.onAdd = function (map) {
			this._div = L.DomUtil.create('div', 'info');
			this.update();
			return this._div;
		};

		info.update = function (props) {
			this._div.innerHTML = '<h4>Descrição do ambiente</h4>' +  (props ?
				'<b>' + props.name + '</b><br /> Id:' +  props.id
				: 'Aponte para o ambiente<br>Clique para ampliar o ambiente<br>Duplo clique para voltar');
		};

		info.addTo(map);

		// busca a cor com base no tipo de servico (s - string)
		function getColor(s) {
			return s == "Serviços Administrativos" ? '#EF7126' :
			       s == "Salas de Aula"  ? '#F9E559' :
			       s == "Alimentação"  ? '#D7191C' :
			       s == "Serviços"  ? '#8EDC9D' :
				   s == "Acessos"  ?'#FF0000':
				   s == "Apoio"  ?'#4575B4':
			                  '#D2FAF8';
		}
		
		// configuracao de estilo dos poligonos
		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.7,
				fillColor: getColor(feature.properties.categoria)
			};
		}


		// funcao que define as propriedades dos poligonos com evento mouseover
		function highlightFeature(e) {
			var layer = e.target;

			layer.setStyle({
				weight: 5,
				color: '#00FF00',
				dashArray: '',
				fillOpacity: 0.7
			});

			if (!L.Browser.ie && !L.Browser.opera) {
				layer.bringToFront();
			}

			//info.update(layer.feature.properties);
			info.update(layer.feature.properties.relations.reltags);
		}

		var indoorLayer;
		
		// funcao que define as propriedades dos poligonos com evento mouseout
		function resetHighlight(e) {
			indoorLayer.resetStyle(e.target);
			info.update();
		}
			
		// funcao de zoom nos poligonos selecionados com evento click
		function zoomToFeature(e) {
			map.fitBounds(e.target.getBounds());
			
		/*
		* Colocar aqui a opção de mostrar a foto da sala ao dar o zoom
		* <br><img src=\"images/bkg_sunset.jpg\" />
		*/
		}

		// funcao que retorna o mapa para o centro e zoom iniciais
		function resetView(){
			map.setView([-30.035476, -51.22593], 19.5);
		}
		
		// funcao que acrescenta funcoes para todos os poligonos (features)
		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature,
				dblclick: resetView
			});
		}
		
		// armazena o GeoJson na variavel
		/*
		geojson = L.geoJson(coordSala, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(map);	
		*/
		
// This example uses a GeoJSON FeatureCollection saved to a file
// (data.json), see the other example (live/index.html) for details on
// fetching data using the OverpassAPI (this is also how the data in
// data.json was generated)
$.getJSON("data/data.json", function(geoJSON) {
	
	 indoorLayer = new L.Indoor(geoJSON, {
		getLevel: function(feature) {
			if (feature.properties.relations.length === 0)
			return null;
			return feature.properties.relations[0].reltags.level;
		},
		getName: function(feature) {
			if (feature.properties.relations.length === 0)
			return null;
			return feature.properties.relations[0].reltags.name;
		},
		onEachFeature: function(feature, layer) {
			//layer.bindPopup(JSON.stringify(feature.properties, null, 4));
			onEachFeature(feature, layer);
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature,
				dblclick: resetView
			});
		},
		style: function(feature) {
			var fill = '#D2FAF8';
			if (feature.properties.tags.buildingpart === 'corridor') {
			fill = '#169EC6';
			} else if (feature.properties.tags.buildingpart === 'verticalpassage') {
			fill = '#0A485B';
			} else if (feature.properties.tags.category === 'Serviços Administrativos') {
			fill = '#EF7126';
			}else if (feature.properties.tags.category === 'Salas de Aula') {
			fill = '#F9E559';
			}else if (feature.properties.tags.category === 'Alimentação') {
			fill = '#D7191C';
			}else if (feature.properties.tags.category === 'Serviços') {
			fill = '#8EDC9D';
			}else if (feature.properties.tags.category === 'Apoio') {
			fill = '#4575B4';
			}else if (feature.properties.tags.category === 'Acessos') {
			fill = '#FF0000';
			}
			return {
			fillColor: fill,
			weight: 1,
			color: '#666',
			fillOpacity: 0.7
			};
		}
	});
	
	indoorLayer.setLevel("0");
	
	indoorLayer.addTo(map);
	
	
	var levelControl = new L.Control.Level({
		level: "0",
		levels: indoorLayer.getLevels()
	});
	
	
	// Connect the level control to the indoor layer
	
	levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
	levelControl.addTo(map);
	
	});
		
		// adiciona os creditos da imagem
		//map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');

		// criacao da legenda do mapa
		var legend = L.control({position: 'bottomright'});

		legend.onAdd = function (map) {

			var div = L.DomUtil.create('div', 'info legend'),
				categorias = ['Serviços Administrativos', 'Salas de Aula', 'Alimentação', 'Serviços', 'Acessos', 'Apoio'],
				cores = ['#EF7126', '#F9E559',  '#D7191C', '#8EDC9D', '#FF0000', '#4575B4'],
				labels=[];	

			for (var i = 0; i < categorias.length; i++) {
				from = categorias[i];

				labels.push(
					'<i style="background:' + cores[i] + '"></i> ' + categorias[i] );
			}

			div.innerHTML = labels.join('<br>');
			return div;
		};

		legend.addTo(map);

	</script>
</body>
</html>
