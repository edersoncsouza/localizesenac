
	// funcao que filtra por regex a URL em busca de parametros e os retorna por nome
	// fonte: http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
	
	/*
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	*/
	
	/* OPCAO DE BUSCA DE PARAMETRO EM PHP
	<?php
			// se recebeu sala por parametro
			if (isset($_GET['sala'])) {
				// armazena a sala
				$sala = $_GET['sala'];
				// transfere o valor de $sala em php para sala em javascript
				echo "sala = {$sala};";
			}
	?>
	*/
	
	// recebe o valor de parametro sala da URL
	//sala = getParameterByName('sala');



	// variavel que busca todo o conteudo do arquivo json e armazena
	var jsonSala = $.getJSON("dist/data/data.json");

	// variavel criada para filtrar a sala desejada
	var sala;
	
	// variaveis criadas para armazenar o layer o marcador unico e o array de marcadores
	var marker; var Vmarkers = [];

	jsonSala.then(function(data) {

        //var todasSalas = L.geoJson(data,{
		indoorLayer = new L.Indoor(data, {
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
				
			// funcao executada com cada feature do GeoJson
			onEachFeature: function (feature, layer) {
				// Verifica se a feature é do tipo polygon
				if (feature.geometry.type === 'Polygon') {
					// Recebe os limites do polygon
					var bounds = layer.getBounds();
					// Recebe o centro dos limites do polygon
					var center = bounds.getCenter();
					// Adiciona o centro do objeto no array indexando pela tag room do json
					Vmarkers[feature.properties.tags.room]=center;
				}
				
				// Verifica se o polygon e igual a sala passada por parametro pelo item de menu
				if (sala == feature.properties.tags.room){
					// Adiciona o popup com a descricao da sala ao marcador e o adiciona no centro do polygon buscado(bounceOnAdd é para os bounce markers)
					//L.marker(Vmarkers[feature.properties.tags.room], {bounceOnAdd: true,bounceOnAddOptions: {duration: 1000, height: 100, loop: true}}).bindPopup(feature.properties.tags.name+"<br><a href=\"http://www.senacrs.com.br/faculdades.asp?Unidade=63\" target=\"_blank\">Senac RS</a><br>").openPopup().addTo(map);
					marker = new L.marker(Vmarkers[feature.properties.tags.room], {bounceOnAdd: true,bounceOnAddOptions: {duration: 1000, height: 100, loop: true}}).bindPopup(feature.properties.tags.name+"<br><a href=\"http://www.senacrs.com.br/faculdades.asp?Unidade=63\" target=\"_blank\">Senac RS</a><br>").openPopup();
					map.addLayer(marker);
				}
				
				// Insere os eventos de mouse no layer
				layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature,
                    dblclick: resetView,		
                });
			},
			
			// formata os polygonos de acrodo com as caracteristicas
			style: function (feature) {
                    var fill = '#D2FAF8';
                    if (feature.properties.tags.buildingpart === 'corridor') {
                        fill = '#169EC6';
                    } else if (feature.properties.tags.buildingpart === 'verticalpassage') {
                        fill = '#0A485B';
                    } else if (feature.properties.tags.category === 'Serviços Administrativos') {
                        fill = '#EF7126';
                    } else if (feature.properties.tags.category === 'Salas de Aula') {
                        fill = '#F9E559';
                    } else if (feature.properties.tags.category === 'Alimentação') {
                        fill = '#D7191C';
                    } else if (feature.properties.tags.category === 'Serviços') {
                        fill = '#8EDC9D';
                    } else if (feature.properties.tags.category === 'Apoio') {
                        fill = '#4575B4';
                    } else if (feature.properties.tags.category === 'Acessos') {
                        fill = '#FF0000';
                    }
                    return {
                        fillColor: fill,
                        weight: 1,
                        color: '#666',
                        fillOpacity: 0.7
                    };
            },
			
			filter: function(feature, layer) {
				return feature.properties.tags.room; // retorna a exibicao do polygon se houver propriedade room
			}
			
		});

			// define o numero do nivel
		    indoorLayer.setLevel("0");
			// insere o layer no mapa
			indoorLayer.addTo(map);

			// instancia e define o controle de andares
			var levelControl = new L.Control.Level({
                level: "0",
                levels: indoorLayer.getLevels()
            });
			
			// connect the level control to the indoor layer
            levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
			
			// inserido novo event listener para que ao mudar de andar remova o marker existente
			levelControl.addEventListener("levelchange", function() {
					map.removeLayer(marker);
			});
			
            levelControl.addTo(map);
		
			// variavel para criacao do painel deslizante
			var controleInfopane = L.control.infoPane('infopane', {position: 'topright'});

			// atualizacao do painel deslizante
            controleInfopane.update = function (props) {
				// insere as informacoes no DOM atraves de uma funcao ternaria
                this._div.innerHTML = '<h2>Descrição do Ambiente</h2><br>' + (props ?
                        '<h2>' + props.name + '</h2>' +
                        '<img src="dist/images/fotos/unidade' + props.unidade + '/' + props.image + '.jpg" height="300" width="300"> </img><br>' +
                        '<strong>Horários de funcionamento:</strong> ' + props.horario + '<br>' +
                        '<strong>Email:</strong> ' + props.email + ' <br>' +
                        '<strong>Telefone:</strong> ' + props.telefone + ' <br>' 
                        : 'Ambiente sem informações');
            };
			
			
			//controleInfopane.update(indoorLayer);
			// insere o painel deslizante no mapa
            controleInfopane.addTo(map);
		
		// insere o layer filtrado
		indoorLayer.addTo(map)
		
    });