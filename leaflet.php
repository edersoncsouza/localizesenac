<!DOCTYPE html>
<html>
<head>
	<title>LocalizeSenac - Mapa dos Ambientes</title>
	<meta charset="utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="bower_components/leaflet/dist/css/leaflet.css" />

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


	
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/leaflet/dist/js/leaflet-src.js"></script>
    <script src="bower_components/leaflet/dist/js/leaflet-indoor.js"></script>
	<script type="text/javascript" src="script/leaf/limitesUnidade1Senac.js"></script> <!-- arquivo com o GeoJson do limite da unidade 1 -->
	
	<script type="text/javascript">
		
		// configuracao dos limites maximos de exibicao do mapa
        var sudOeste = L.latLng(-30.035996, -51.227157);
        var nordEste = L.latLng(-30.035025, -51.224985);

        // cria a variavel mapa, define o centro de visão e o nivel do zoom
        var map = L.map('map').setView([-30.035476, -51.22593], 19.5);
        map.setMaxBounds(new L.LatLngBounds(sudOeste, nordEste));

		/*
		// configura a camada quadriculada (tileLayer) que fica de fundo para o mapa vetorial
		L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
			maxZoom: 24,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' ,
			id: 'examples.map-20v6611k'
		}).addTo(map);
		*/


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

		//info.addTo(map);

		// busca a cor com base no tipo de servico (s - string)
		function getColor(s) {
			return s == "Serviços Administrativos" ? '#EF7126' :
			       s == "Salas de Aula"  ? '#F9E559' :
			       s == "Alimentação"  ? '#D7191C' :
			       s == "Serviços"  ? '#8EDC9D' :
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

			info.update(layer.feature.properties);
		}

		var indoorLayer;//var geojson;

		// funcao que define as propriedades dos poligonos com evento mouseout
		function resetHighlight(e) {
			geojson.resetStyle(e.target);
			info.update();
		}

        /* funcao de zoom nos poligonos selecionados com evento click
         * caso o conteudo ja esteja ampliado retorna a visualizacao inicial 
         */
        // booleano para controlar se o zoom foi aplicado
        var zoomed = false;
        function zoomToFeature(e) {

            if (!zoomed) {
                // armazena os limites do poligono clicado
                var limitesFeature = e.target.getBounds();

                // exibe o painel lateral
                abrePainel(e);

                // configura os limites do zoom para o centro do poligono selecionado				
                map.fitBounds(limitesFeature).getCenter();
                // inverte o valor do boolean do zoom
                zoomed = true;

                // ocultar o painel de informacoes - deixar por enquanto
                //$("#informacoes").css("display", "none");
            }
            else {
                // volta as configuracoes padrao do mapa
                resetView();
                // inverte o valor do boolean do zoom
                zoomed = false;
                // reexibir o painel de informacoes curtas - deixar por enquanto
                //$("#informacoes").css("display", "block");
            }

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
		
		/*
		// armazena o GeoJson na variavel
		geojson = L.geoJson(coordSala, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(map);	
		*/
		
		// carregamento do Json em uma layer do tipo Indoor
        $.getJSON("data/data.json", function (geoJSON) {

            indoorLayer = new L.Indoor(geoJSON, {
                getLevel: function (feature) {
                    if (feature.properties.relations.length === 0)
                        return null;
                    return feature.properties.relations[0].reltags.level;
                },
                getName: function (feature) {
                    if (feature.properties.relations.length === 0)
                        return null;
                    return feature.properties.relations[0].reltags.name;
                },
                onEachFeature: function (feature, layer) {
                    //layer.bindPopup(JSON.stringify(feature.properties, null, 4));
                    //onEachFeature(feature, layer);
                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight,
                        click: zoomToFeature,
                        dblclick: resetView
                    });
                }
			});
		
		
            indoorLayer.setLevel("0");

            indoorLayer.addTo(map);

            var levelControl = new L.Control.Level({
                level: "0",
                levels: indoorLayer.getLevels()
            });

            // connect the level control to the indoor layer
            levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
            levelControl.addTo(map);
		
		// adiciona os creditos da imagem
		//map.attributionControl.addAttribution('Population data &copy; <a href="http://census.gov/">US Census Bureau</a>');

		// criacao da legenda do mapa
		var legend = L.control({position: 'bottomright'});

		legend.onAdd = function (map) {

			var div = L.DomUtil.create('div', 'info legend'),
				//grades = [0, 10, 20, 50, 100, 200, 500, 1000],
				//labels = [],
				//from, to;
				categorias = ['Serviços Administrativos','Salas de Aula','Alimentação','Serviços','Apoio'],
				cores = ['#EF7126', '#F9E559',  '#D7191C', '#8EDC9D', '#4575B4'],
				labels=[];	

			for (var i = 0; i < categorias.length; i++) {
				from = categorias[i];

				labels.push(
					'<i style="background:' + cores[i] + '"></i> ' + categorias[i] );
			}

			div.innerHTML = labels.join('<br>');
			return div;
		};

		//legend.addTo(map);
}); // final da montagem de layer do level=0 do mapa

// carregamento do Json em uma layer do tipo Indoor
        $.getJSON("data/data2.json", function (geoJSON) {

            indoorLayer2 = new L.Indoor(geoJSON, {
                getLevel: function (feature) {
                    if (feature.properties.relations.length === 0)
                        return null;
                    return feature.properties.relations[0].reltags.level;
                },
                getName: function (feature) {
                    if (feature.properties.relations.length === 0)
                        return null;
                    return feature.properties.relations[0].reltags.name;
                },
                onEachFeature: function (feature, layer) {
                    //layer.bindPopup(JSON.stringify(feature.properties, null, 4));
                    //onEachFeature(feature, layer);
                    layer.on({
                        mouseover: highlightFeature,
                        mouseout: resetHighlight,
                        click: zoomToFeature,
                        dblclick: resetView
                    });
                }
			});
		
		
            indoorLayer2.setLevel("1");

            indoorLayer2.addTo(map);

            var levelControl = new L.Control.Level({
                level: "1",
                levels: indoorLayer2.getLevels()
            });

            // connect the level control to the indoor layer
            levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
            levelControl.addTo(map);
			}); // final da montagem de layer do level=1 do mapa
	</script>

</body>
</html>
