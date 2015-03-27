<!DOCTYPE html>
<html>
    <head>
        <title>LocalizeSenac - Mapa dos Ambientes</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="../bower_components/leaflet/dist/css/leaflet.css" />

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
            }

        </style>
		
<?php 


/**
 * Licensed under Creative Commons 3.0 Attribution
 * Copyright Adam Wulf 2013
 */
 
 /*
include("config.php");
include("include.classloader.php");
$classLoader->addToClasspath(ROOT);
$mysql = new MySQLConn(DATABASE_HOST, DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
$db = new JSONtoMYSQL($mysql);
// create some json
//$obj = json_decode('{"id":4,"asdf" : "asfd"}'); // vou utilizar meu arquivo Json
$contents = file_get_contents('../data/data.json'); 
$contents = utf8_encode($contents); 
$obj = json_decode($contents); 

// save it to a table
$db->save($obj, "brandnewtable");
*/
?> 
		
    </head>
    <body onload="resetPanel();">
        <div id="map"> <!-- class="row" --> 

            <div id="painel" class="leaflet-info-pane col-md-12" hidden>
                <div id="infopane" class="content">	</div>
            </div>

        </div>

    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/leaflet/dist/js/leaflet-src.js"></script>
    <script src="../bower_components/leaflet/dist/js/leaflet-indoor.js"></script>
	<script type="text/javascript" src="../script/leaf/limitesUnidade1Senac.js"></script> <!-- arquivo com o GeoJson do limite da unidade 1 -->
    <!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->

        <script type="text/javascript">

		// configuracao dos limites maximos de exibicao do mapa
        var sudOeste = L.latLng(-30.035996, -51.227157);
        var nordEste = L.latLng(-30.035025, -51.224985);

        // cria a variavel mapa, define o centro de visão e o nivel do zoom
        var map = L.map('map').setView([-30.035476, -51.22593], 19.5);
        map.setMaxBounds(new L.LatLngBounds(sudOeste, nordEste));

		// identifica o centro do objeto e inclui um marcador
		//L.marker(map.getCenter()).addTo(map);
		
		// variavel que contem os dados do senac qdo nenhum ambiente foi selecionado
        var infoSenac = "<h3>Faculdade Senac Porto Alegre<h3>" +
                "<a href=\"http://portal.senacrs.com.br/unidades.asp?unidade=63\">WWW.SENACRS.COM.BR</a>" +
                "<img src=\"../images/fotos/fachadaSenac.jpg\" height=\"300\" width=\"300\" alt=\"Clio de ourto maciço da Prof. Aline de Campos\"/img></br>" +
                "<h4>Rua Coronel Genuino, 130</br>" +
                "Porto Alegre / RS</br>" +
                "CEP 90010350<br>" +
                "<a><strong>Horários de funcionamento:</strong></a> 8h30 às 22h40 </br>" +
                "<a><strong>Email:</strong></a>  atendimentofatecpoa@senacrs.com.br / </br> faculdadesenacpoa@senacrs.com.br</br>" +
                "<a><strong>Telefone:</strong></a>  (51) 30221044</h4>";

        /*
         // configura a camada quadriculada (tileLayer) que fica de fundo para o mapa vetorial
         L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
         maxZoom: 24,
         attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
         '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
         'Imagery © <a href="http://mapbox.com">Mapbox</a>',
         id: 'examples.map-20v6611k'
         }).addTo(map);
         */

        // metodo para criacao da legenda do mapa
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
            this._div.innerHTML = '<h4>Descrição do ambiente</h4>' + (props ?
                    '<b>' + props.name + '</b> <br><br>Clique na sala para maiores informações'
                    //+ '</b><br /> Id:' +  props.id
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
        var indoorLayer; //var controleInfopane; 

        // funcao que define as propriedades dos poligonos com evento mouseout
        function resetHighlight(e) {
            indoorLayer.resetStyle(e.target);
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

        // funcao que atualiza o painel de informacoes sobre o ambiente clicado
        function atualizaPainel(props) {

            var newContent = '<h2>Descrição do Ambiente</h2><br>' + (props ?
                    '<h2>' + props.name + '</h2>' +
                    '<img src="../images/fotos/' + props.image + '.jpg" height="300" width="300"> </img><br>' +
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

		// carregamento do Json em uma layer do tipo Indoor
        $.getJSON("../data/data.json", function (geoJSON) {

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

            indoorLayer.setLevel("0");

            indoorLayer.addTo(map);

            var levelControl = new L.Control.Level({
                level: "0",
                levels: indoorLayer.getLevels()
            });

            // connect the level control to the indoor layer
            levelControl.addEventListener("levelchange", indoorLayer.setLevel, indoorLayer);
            levelControl.addTo(map);

            // painel de informacoes dos ambientes
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
			
        }); // final da montagem de layer do mapa

        </script>	

        <!-- Include Info pane -->
        <script src="../bower_components/leaflet/dist/js/leaflet.infopane.js"></script>
		<link rel="stylesheet" href="../bower_components/leaflet/dist/css/leaflet.infopane.css" />
    </body>

</html>