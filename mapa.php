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
			clear: both; <!-- colocado para consertar erro na legenda no Chrome para Mac -->
		}
		
		
		<!-- Alterações para o painel lateral com informações das salas -->
		#painel{ 
			
		}
		h4{
			font-size: 16px;
			font-size: 1.1vw; 
		}
		h3{
			font-size: 18px;
			font-size: 1.5vw; 
		}
		img {
			max-width: 100%;
			height: auto;
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
		$('#menuCategoria > ul').removeClass('in'); // fecha os menus laterais da pagina principal
		resetPanel();
		setTimeout(map.invalidateSize.bind(map),200);
	});
	</script>
		
    </head>

	<body>
			<div id="map"> <!-- class="row" --> 
				<div id="painel" class="leaflet-info-pane col-md-12" hidden>
					<div id="infopane" class="content">
					</div>
				</div>
			</div>
    </body>

</html>