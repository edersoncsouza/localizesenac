
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

	// configuracao dos limites maximos de exibicao do mapa
	var sudOeste = L.latLng(-30.035996, -51.227157);
	var nordEste = L.latLng(-30.035025, -51.224985);

	var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
	osm = new L.TileLayer(osmUrl, {
		maxZoom: 22,
		attribution: "Map data &copy; OpenStreetMap contributors"
	});

	// cria a variavel mapa, define o centro de visão e o nivel do zoom
	var map = L.map('map', {layers: [osm]}).setView([-30.035476, -51.22593], 19);
	map.setMaxBounds(new L.LatLngBounds(sudOeste, nordEste));
	
	// cria o layer de markers
	var markers = new L.FeatureGroup();
	
	// variavel que contem os dados do senac qdo nenhum ambiente foi selecionado
	var infoSenac = "<h3>Faculdade Senac Porto Alegre<h3>" +
			"<a href=\"http://portal.senacrs.com.br/unidades.asp?unidade=63\">WWW.SENACRS.COM.BR</a>" +
			"<img src=\"dist/images/fotos/unidade1/fachadaSenac.jpg\" height=\"250\" width=\"250\" alt=\"Clio de ouro maciço da Prof. Aline de Campos\"/img></br>" +
			"<br><h4>Rua Coronel Genuino, 130</br>" +
			"Porto Alegre / RS</br>" +
			"CEP 90010350<br>" +
			"<a><strong>Horário de funcionamento:</strong></a> <br>8h30 às 22h40 </br>" +
			"<a><strong>Email:</strong></a> faculdadesenacpoa@senacrs.com.br</br>" +
			"<a><strong>Telefone:</strong></a>  (51) 30221044</h4>";

	// metodo para criacao da legenda do mapa (adaptar para buscar do banco)
	var legend = L.control({position: 'bottomleft'});
	legend.onAdd = function (map) {
		var div = L.DomUtil.create('div', 'info legend'),
				categorias = ['Serviços Administrativos', 'Salas de Aula', 'Alimentação', 'Serviços', 'Acessos', 'Apoio'],
				cores = ['#EF7126', '#F9E559', '#D7191C', '#8EDC9D', '#FF0000', '#4575B4'],
				labels = [];
		div.id = 'legenda'; // acrescenta a id legenda a esta div

		for (var i = 0; i < categorias.length; i++) {
			from = categorias[i];
			labels.push(
					'<i style="background:' + cores[i] + '"></i> ' + categorias[i]);
		}
		div.innerHTML = labels.join('<br>');

		return div;
	};

	legend.addTo(map);

	// armazena os limites do mapa para posterior reset
	var limites = map.getBounds();

	// desativa o zoom por duplo clique ou no scrooll do mouse
	//map.dragging.disable();
	map.doubleClickZoom.disable();
	map.scrollWheelZoom.disable();

	// controle que exibe informacoes da sala ao selecionar
	var info = L.control();
	info.onAdd = function (map) {
		this._div = L.DomUtil.create('div', 'info');
		this.update();
		this._div.id = 'informacoes'; // acrescenta a id a div
		return this._div;
	};
	info.update = function (props) {
		// exibe as informações da tela no evento hover do mouse atraves de uma funcao ternaria
		this._div.innerHTML = '<h4>Descrição do ambiente</h4>' + (props ?
				'<strong>' + props.name +
				'</strong> <br><strong>Sala: ' + props.room +
				'</strong> <br><br>Clique na sala para maiores informações'
				: 'Aponte para o ambiente<br>Clique para ampliar o ambiente<br>Outro clique para voltar');
	};
	info.addTo(map);

	// busca a cor com base no tipo de servico (s - string)
	function getColor(s) {
		return s == "Serviços Administrativos" ? '#EF7126' :
				s == "Salas de Aula" ? '#F9E559' :
				s == "Alimentação" ? '#D7191C' :
				s == "Serviços" ? '#8EDC9D' :
				s == "Acessos" ? '#FF0000' :
				s == "Apoio" ? '#4575B4' :
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
		info.update(layer.feature.properties.tags);

	}
	
	var indoorLayer;
	var levelControl;

	// funcao que define as propriedades dos poligonos com evento mouseout
	function resetHighlight(e) {
		indoorLayer.resetStyle(e.target);
		info.update();
	}

	// funcao de zoom nos poligonos selecionados com evento click
	// caso o conteudo ja esteja ampliado retorna a visualizacao inicial 
	 
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

	// funcao que atualiza o painel de informacoes sobre o ambiente clicado
	function atualizaPainel(props) {

		var newContent = '<h2>Descrição do Ambiente</h2><br>' + (props ?
				'<h2>' + props.name + '</h2>' +
				'<img src="dist/images/fotos/unidade' + props.unidade + '/' + props.image + '.jpg" height="250" width="250"> </img><br>' +
				'<a><strong>Horários de funcionamento:</strong></a> ' + props.horario + '<br>' +
				'<a><strong>Email:</strong></a> ' + props.email + ' <br>' +
				'<a><strong>Telefone:</strong></a> ' + props.telefone + ' <br>'
				: 'Ambiente sem informações');

		$('#infopane').empty().append(newContent);
	}

	// metodo que apaga o painel de informacoes e adiciona informacoes da faculdade
	function resetPanel() {
		$('#infopane').empty().append(infoSenac);
	}

	// metodo para qdo o painel e ocultado
	function fechaPainel() {
		// remove a classe visible para ocultar o painel lateral
		$('.leaflet-info-pane').removeClass('visible');
		// chama a funcao resetPanel com um intervalo para evitar
		// que apareca a atualizacao do painel durante a animacao
		window.setTimeout(function () {
			resetPanel();
		}, 600);
	}
	
	// metodo para qdo o painel e exibido
	function abrePainel(e) {
		var layer = e.target;

		// atualiza informacoes da sala no painel
		atualizaPainel(layer.feature.properties.tags);
		
		// adiciona a classe visible para exibir o painel lateral
		$('.leaflet-info-pane').addClass('visible');
	}

	// funcao que retorna o mapa para o centro e zoom iniciais
	function resetView() {
		map.setView([-30.035476, -51.22593], 19.5);
		fechaPainel();
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
		
	// Exibe os limites da unidade 1 do Senac
	var limites = {
					"type":"Feature",
					"properties":{"indoor":"level"},
					"geometry":{
						"type":"LineString",
						"coordinates":[
						[-51.22668180623533,-30.035285121877315],[-51.2265336609083,-30.035087224146654],[-51.22647355243277,-30.03512094793035],
						[-51.22644383540727,-30.035081250849945],[-51.226048765364894,-30.035302904197504],[-51.22607762249031,-30.0353414525062],
						[-51.22602248063556,-30.035372389694686],[-51.22604615745694,-30.035404017959696],[-51.22556564497819,-30.035673607691603],
						[-51.225665301849794,-30.035806732096372],[-51.22571812974482,-30.03577709327882],[-51.225742071542506,-30.03580907537713],
						[-51.22607061675038,-30.035624746646363],[-51.226047618473885,-30.03559402487214],[-51.22619445159744,-30.03551164470813],
						[-51.2262191796104,-30.03554467714227],[-51.22668180623533,-30.035285121877315]
						]
						}
					};
	L.geoJson(limites).addTo(map);
	
// TUDO ACIMA VEIO DO MAPA.PHP

	// variavel que busca todo o conteudo do arquivo json e armazena
	var jsonSala = $.getJSON("dist/data/data.json");
	//var jsonSala = $.getJSON("teste.json");

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
			levelControl = new L.Control.Level({
                level: "0",
                levels: indoorLayer.getLevels()
            });
			
			// connect the level control to the indoor layer
            levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
			
			// INSERIDO NOVO EVENT LISTENER PARA QUE AO MUDAR DE ANDAR REMOVA O MARKER EXISTENTE
			levelControl.addEventListener("levelchange", function() {
				if (map.hasLayer(marker)) // se houver layer de marcadores
					try{
						map.removeLayer(marker); // remove o layer de marcadores
					}
					catch(e) {
						console.log(e.name + ' - ' + e.message);
					}
			});
			
            levelControl.addTo(map);
		
			// variavel para criacao do painel deslizante
			var controleInfopane = L.control.infoPane('infopane', {position: 'topright'});

			// atualizacao do painel deslizante
            controleInfopane.update = function (props) {
				// insere as informacoes no DOM atraves de uma funcao ternaria
                this._div.innerHTML = '<h2>Descrição do Ambiente</h2><br>' + (props ?
                        '<h2>' + props.name + '</h2>' +
                        '<img src="dist/images/fotos/unidade' + props.unidade + '/' + props.image + '.jpg" height="250" width="250"> </img><br>' +
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