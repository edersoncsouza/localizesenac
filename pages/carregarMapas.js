

		// carregamento do Json em uma layer do tipo Indoor
        $.getJSON("../data/data.json", function (geoJSON) {

            indoorLayer0 = new L.Indoor(geoJSON, {
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
                },
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
                }
            });

			// define o numero do nivel
		    indoorLayer0.setLevel("0");
			// insere o layer no mapa
			indoorLayer0.addTo(map);

			// instancia e define o controle de andares
			var levelControl0 = new L.Control.Level({
                level: "0",
                levels: indoorLayer0.getLevels()
            });
			
			// connect the level control to the indoor layer
            levelControl0.addEventListener("levelchange", indoorLayer0.setLevel, indoorLayer);
            levelControl0.addTo(map);
			
			            var controleInfopane = L.control.infoPane('infopane', {position: 'topright'});

            controleInfopane.update = function (props) {
                this._div.innerHTML = '<h2>Descrição do Ambiente</h2><br>' + (props ?
                        '<h2>' + props.name + '</h2>' +
                        '<img src="../images/fotos/' + props.image + '.jpg" height="300" width="300"> </img><br>' +
                        '<strong>Horários de funcionamento:</strong> ' + props.horario + '<br>' +
                        '<strong>Email:</strong> ' + props.email + ' <br>' +
                        '<strong>Telefone:</strong> ' + props.telefone + ' <br>'
                        : 'Ambiente sem informações');

            };
            controleInfopane.addTo(map);

		}); // final da montagem de layer andar terreo do mapa
		
		/*
		 * primeiro andar
		 *
		 */
		 
		 // carregamento do Json em uma layer do tipo Indoor
        $.getJSON("../data/data.json", function (geoJSON) {

            indoorLayer1 = new L.Indoor(geoJSON, {
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
                },
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
                }
            });
			

	
        }); // final da montagem de layer primeiro andar do mapa

		// <script src="../bower_components/leaflet/dist/js/leaflet-indoor.js"></script>
		/*
		// para invocar elementos de outro arquivo javascript
		$.getScript("../bower_components/leaflet/dist/js/leaflet-indoor.js", function(){

		});
		*/
		
