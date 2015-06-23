<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    mysql_set_charset('UTF8', $_SG['link']);
	
	//setup php for working with Unicode data
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');

	//if(isset($_POST['unidade')){
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value);}

		// armazena os parametros recebidos
		$unidade = 1;//$_POST['unidade'];

		$sqlUnidade = "SELECT
								*
						FROM
								coordenadas
						WHERE
								fk_sala_fk_id_unidade = {$unidade}
						ORDER BY
								id";
								
		// executa a query para verificar se o aluno ja possui eventos
		$result = mysql_query($sqlUnidade) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		//cria o array data
			$data;//= []; 
		
		$salaAtual = "0";
		$cabecalhoGeometry = "\"geometry\": {
								\"type\": \"Polygon\",
								\"coordinates\": [
									[";
		$rodapeGeometry = "]
								]
							},";
							
		$lat=""; $long="";

		// cria o array de pares de coordenadas
		$coordinate = array();
		/*
		$coordinate = array(
			'longitude' => $long,
			'latitude' => $lat,
		);
		*/
		
		// cria o array de geometries de salas por enquanto so poligons
		$geometry = array(
			'type' => 'Polygon',
			'coordinates' => array()
		);
		
		// cria o array de relations de salas
		$relations = array(
			//'buildingpart' => 'room',
			'reltags' => array()
		);
		
		$properties = array(
			'relations' => array()
		);
		
		
		$tags="";
		
		// cria o array de features
		$feature = array(
			'type' => 'Feature',
			//'geometry' => array(),
			//'properties' => array()
		);
		
		// cria o array geoJson
		$geojson = array(
		   'type'      => 'FeatureCollection',
		   'features'  => array()
		);
	

		
		// armazena os dados nos arrays
		while ($row = mysql_fetch_assoc($result)) { // loop atraves de todas as linhas do resultset
$linha = $row;
			$sala = $row['fk_numero_sala']; // armazena a sala lida
			
			if ($sala != $salaAtual){ // se for uma nova sala
				
				if (count($coordinate) > 1){ // se possui coordenadas armazenadas
					
					// duplica o primeiro par de coordenadas em coordinate para fechar o polygon
					array_push($coordinate, $coordinate[0]);
					
					// adiciona o registro coordinate em geometry para encerrar a sala anterior
					array_push($geometry['coordinates'], $coordinate);
					
					// adiciona o registro geometry em feature para encerrar a sala anterior
					//array_push($feature['geometry'], $geometry);
					$feature['geometry'] = $geometry; // adiciona as coordenadas ao campo geometry da feature
					
					$tags['unidade'] = $row['fk_sala_fk_id_unidade']; // armazena a unidade da linha lida
					$tags['level'] = $row['fk_andar_sala']; // armazena a unidade da linha lida
					$tags['room'] = $row['fk_numero_sala']; // armazena a unidade da linha lida
					
					$reltags['buildingpart'] = "room"; //fixando room por enquanto
					$reltags['level'] = $row['fk_andar_sala'];
					$reltags['room'] = $row['fk_numero_sala'];
					$relations['reltags'] = $reltags; // adiciona as reltags ao campo realtags de relations
					
					$properties['tags'] = $tags ; // adiciona as tags ao campo tags da properties
					array_push($properties['relations'],$relations); // adiciona as relations ao array properties
					$feature['properties'] = $properties; // adiciona properties ao campo properties
					
					// adiciona o registro feature em geojson para encerrar a sala anterior
					array_push($geojson['features'], $feature);	
					
					//echo json_encode($geojson, JSON_NUMERIC_CHECK);
					
					// cria um novo registro feature para iniciar uma nova sala
					$feature = array(
						'type' => 'Feature',
						//'geometry' => array(),
						//'properties' => array()
					);
					
					// cria um novo registro geometry para iniciar uma nova sala
					$geometry = array(
						'type' => 'Polygon',
						'coordinates' => array()
					);
					
					// cria um novo registro coordinate para iniciar uma nova sala
					$coordinate = array();
					
					// cria um novo registro properties para iniciar uma nova sala
					$properties = array(
						'relations' => array()
					);
					
					// armazena as coordenadas da sala da linha lida
					$long = $row['longitude'];
					$lat = $row['latitude'];
					
					// adiciona o primeiro par de coordenadas da nova sala em coordinate
					//array_push($coordinate, array('longitude' => $long, 'latitude' => $lat));
					array_push($coordinate, array($long,$lat));

				}
				else{ // se for a primeira sala de todas da unidade
					
					// armazena as coordenadas da sala da linha lida
					$long = $row['longitude'];
					$lat = $row['latitude'];
					
					// adiciona o par de coordenadas em coordinate
					//array_push($coordinate, array('longitude' => $long, 'latitude' => $lat));
					array_push($coordinate, array($long,$lat));
				}
				
				// teste de string
				$salaAtual = $sala;
				$parCoordenadas = "[" . $row['longitude'] . ", " . $row['latitude'] . "]";
			}
			else{ // se for coordenada da mesma sala
				
				// armazena a latitude e longitude da linha lida
				$long = $row['longitude'];
				$lat = $row['latitude'];
				
				// adiciona o par de coordenadas em coordinate
				array_push($coordinate, array($long,$lat));
				
				// teste de string
				$parCoordenadas = $parCoordenadas . ",";
				$parCoordenadas = $parCoordenadas . "[" . $row['longitude'] . ", " . $row['latitude'] . "]";
			}
			
			//echo $cabecalhoGeometry . $parCoordenadas . $cabecalhoGeometry;

		}
		
		//echo $cabecalhoGeometry . $parCoordenadas . $rodapeGeometry . "<br>"; // imprime todas as coordenadas

		encerraGeoJson(); // funcao que armazena os dados da ultima sala para encerrar
		
		echo json_encode($geojson, JSON_NUMERIC_CHECK); // GeoJson resultado final
		

/*		
		echo "<br>";
		echo "<pre>";
		print_r($feature);
		echo "</pre>";
		echo "<br>";
		

		
		
		echo "<br>";
		echo "<pre>";
		print_r($geojson);
		echo "</pre>";
		echo "<br>";
*/		
		
		/*
			$features =	"{
							\"type\": \"FeatureCollection\",
							\"features\": [";
			
			$features. = "{
							\"type\": \"Feature\",
							\"geometry\": {
								\"type\": \"Polygon\",
								\"coordinates\": [
									[
										[
											-51.22653419020298, 	=> coordenadas.longitude
											-30.03509282853612 		=> coordenadas.latitude
										]
									]
								]
							},
							"properties": {
								"tags": {
									"unidade": "1", 				=> coordenadas.fk_sala_fk_id_unidade
									"level": "3", 					=> coordenadas.fk_andar_sala
									"room": "301", 					=> coordenadas.fk_numero_sala
									"category": "Apoio",			=> sala.fk_id_categoria -> categoria
									"name": "Portaria",				=> info_locais.descricao
									"image": "portaria",			=> info_locais.descricao (retiraAcentos + strToLower)
									"horario": "8:00 às 21:00",		=> info_locais.horario
									"email": "@senacrs.com.br",		=> info_locais.email
									"telefone": "(51) 302210"		=> info_locais.telefone
								},
								"relations": [
									{
										"reltags": {
											"buildingpart": "room",
											"level": "3",			=> coordenadas.fk_andar_sala 
											"room": ""
										}
									}
								]
							},
							"id": "043"
						},
		*/
	//}
	
	function encerraGeoJson(){
		
		global $properties, $coordinate, $geometry, $feature, $geojson, $row, $linha;
		
		// duplica o primeiro par de coordenadas em coordinate para fechar o polygon
		array_push($coordinate, $coordinate[0]);
		
		// adiciona o registro coordinate em geometry para encerrar a sala anterior
		array_push($geometry['coordinates'], $coordinate);
		
		// adiciona o registro geometry em feature para encerrar a sala anterior
		//array_push($feature['geometry'], $geometry);
		$feature['geometry'] = $geometry;
										
					$tags['unidade'] = $linha['fk_sala_fk_id_unidade']; // armazena a unidade da linha lida
					$tags['level'] = $linha['fk_andar_sala']; // armazena a unidade da linha lida
					$tags['room'] = $linha['fk_numero_sala']; // armazena a unidade da linha lida
					
					$reltags['buildingpart'] = "room"; //fixando room por enquanto
					$reltags['level'] = $linha['fk_andar_sala'];
					$reltags['room'] = $linha['fk_numero_sala'];
					$relations['reltags'] = $reltags; // adiciona as reltags ao campo realtags de relations
					
					$properties['tags'] = $tags ; // adiciona as tags ao campo tags da properties
					array_push($properties['relations'],$relations); // adiciona as relations ao array properties
					$feature['properties'] = $properties; // adiciona properties ao campo properties

					
		// adiciona o registro feature em geojson para encerrar a sala anterior
		array_push($geojson['features'], $feature);		
	}
?>