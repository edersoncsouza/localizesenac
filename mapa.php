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
	
	<?php
		// Verifica se recebeu o parametro de sala
		if (isset($_GET['sala'])) {
			// armazena a sala
			$sala = $_GET['sala'];
			// tranfere o valor de $sala(PHP) para sala(JavaScript)
			echo "<script> sala = {$sala};</script>";
		}
	?>
	
	<link rel="stylesheet" href="dist/components/leaflet/dist/css/leaflet.css" />
	<link rel="stylesheet" href="dist/components/leaflet/dist/css/leaflet.infopane.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="libs/leaflet.ie.css" /><![endif]-->	

	<style>
		body {
			padding: 0;
			margin: 0;
		}
		html, body, #map {
			height: 100%;
			width: 100%;
		<!--		
			width: 800px; height: 600px;
			-->	
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
			clear: both;
		}

	</style>

    <script src="dist/components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="dist/components/leaflet/dist/js/leaflet-src.js" type="text/javascript"></script>
    <script src="dist/components/leaflet/dist/js/leaflet-indoor.js" type="text/javascript"></script>
	<!-- <script src="../script/leaf/limitesUnidade1Senac.js" type="text/javascript"></script> <!-- arquivo com o GeoJson do limite da unidade 1 -->
	<script src="dist/components/leaflet.bouncemarker/bouncemarker.js"></script>
    <!-- Include Info pane -->
    <script src="dist/components/leaflet/dist/js/leaflet.infopane.js"></script>
	
	<!-- Chama o arquivo JavaScript que carrega o mapa apos armazenar a variavel sala -->
	<script src="dist/js/carregarMapas.js" type="text/javascript"></script>
	
	<script>
	$( document ).ready(function() {
		resetPanel();
		setTimeout(map.invalidateSize.bind(map),200);
	});
	</script>
	
	<script type="text/javascript">
	/*	
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
                "<img src=\"dist/images/fotos/fachadaSenac.jpg\" height=\"300\" width=\"300\" alt=\"Clio de ouro maciço da Prof. Aline de Campos\"/img></br>" +
                "<h4>Rua Coronel Genuino, 130</br>" +
                "Porto Alegre / RS</br>" +
                "CEP 90010350<br>" +
                "<a><strong>Horários de funcionamento:</strong></a> 8h30 às 22h40 </br>" +
                "<a><strong>Email:</strong></a>  atendimentofatecpoa@senacrs.com.br / </br> faculdadesenacpoa@senacrs.com.br</br>" +
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
                    '<img src="dist/images/fotos/unidade' + props.unidade + '/' + props.image + '.jpg" height="300" width="300"> </img><br>' +
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
	*/	
	</script>
		
    </head>

	<body>
        <div id="map"> <!-- class="row" --> 

            <div id="painel" class="leaflet-info-pane col-md-12" hidden>
                <div id="infopane" class="content">	</div>
            </div>

        </div>

    </body>

</html>