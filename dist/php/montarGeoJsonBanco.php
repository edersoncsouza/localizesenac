<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("funcoes.php"); // inclui o arquivo de funcoes php
	
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
						coordenadas.id, longitude, latitude, coordenadas.fk_sala_fk_id_unidade, coordenadas.fk_andar_sala, coordenadas.fk_numero_sala,
						categoria.nome AS nomecategoria,
						info_locais.descricao, info_locais.imagem, horario, email, telefone
				FROM
						sala, categoria, coordenadas, info_locais
				WHERE
						coordenadas.fk_sala_fk_id_unidade = {$unidade}
				AND
						numero = coordenadas.fk_numero_sala
				AND
						fk_id_categoria = categoria.id
				AND
						info_locais.fk_numero_sala = coordenadas.fk_numero_sala
				ORDER BY
						id";
								
		// executa a query para verificar se o aluno ja possui eventos
		$result = mysql_query($sqlUnidade) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
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
			
			$sala = $row['fk_numero_sala']; // armazena a sala lida
			
			if ($sala != $salaAtual){ // se for uma nova sala
				
				if (count($coordinate) > 1){ // se possui coordenadas armazenadas (entra aqui ao ler a primeira coordenada de cada nova sala)
					
					// duplica o primeiro par de coordenadas em coordinate para fechar o polygon
					array_push($coordinate, $coordinate[0]);
					
					// ESTRUTURA GEOJSON
					//[feature[geometry[coordinate]]]
					//[properties[tags,relations[reltags]]]
					
					// adiciona o registro coordinate em geometry para encerrar a sala anterior
					array_push($geometry['coordinates'], $coordinate);
					
					// adiciona o registro geometry em feature para encerrar a sala anterior
					$feature['geometry'] = $geometry; // adiciona as coordenadas ao campo geometry da feature
					
					// ARMAZENA AS INFORMACOES DA AREA PROPERTIES - TAGS DO GEOJSON
					$tags['unidade'] = $linha['fk_sala_fk_id_unidade']; // armazena a unidade da linha lida anteriormente
					$tags['level'] = $linha['fk_andar_sala']; // armazena o andar da linha lida anteriormente
					$tags['room'] = $linha['fk_numero_sala']; // armazena o numero da sala da linha lida anteriormente
					$tags['category'] = $linha['nomecategoria']; // armazena a categoria da sala da linha lida anteriormente
					$tags['name'] = $linha['descricao']; // armazena a descricao da sala da linha lida anteriormente
					
					// como ainda nao estao cadastrados no banco, faz o nome da imagem com a descricao trocando espacos por "_", passando para minusculas e removendo acentos
					$tags['image'] = retiraAcentos(strtolower(str_replace(" ", "_", $linha['descricao'])));
					//$tags['image'] = $linha['imagem']; // armazena a imagem da sala da linha lida anteriormente
					
					$tags['horario'] = $linha['horario']; // armazena o horario de funcionamento da sala da linha lida anteriormente
					$tags['email'] = $linha['email']; // armazena o email da sala da linha lida anteriormente
					$tags['telefone'] = $linha['telefone']; // armazena o telefone da sala da linha lida anteriormente
					
					$properties['tags'] = $tags ; // adiciona as tags ao campo tags da properties ex.: {
					
					$reltags['buildingpart'] = "room"; //fixando room por enquanto
					$reltags['level'] = $linha['fk_andar_sala'];
					$reltags['room'] = $linha['fk_numero_sala'];
					$relations['reltags'] = $reltags; // adiciona as reltags ao campo realtags de relations
					
					array_push($properties['relations'],$relations); // adiciona as relations ao array properties ex.: [

					$feature['properties'] = $properties; // adiciona properties ao campo properties
					
					// ARMAZENAMENTO FINAL NA VARIAVEL geojson
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
					$long = $row['longitude']; // utiliza row para pegar informacoes da linha atual
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
			$linha = $row; // armazena a linha para fechamento da ultima sala da unidade em encerraGeoJson()
		}
		
		//echo $cabecalhoGeometry . $parCoordenadas . $rodapeGeometry . "<br>"; // imprime todas as coordenadas

		encerraGeoJson(); // funcao que armazena os dados da ultima sala para encerrar
		
		echo json_encode($geojson, JSON_NUMERIC_CHECK); // GeoJson resultado final
		


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
										
		// ARMAZENA AS INFORMACOES DA AREA PROPERTIES - TAGS DO GEOJSON
		$tags['unidade'] = $linha['fk_sala_fk_id_unidade']; // armazena a unidade da linha lida anteriormente
		$tags['level'] = $linha['fk_andar_sala']; // armazena o andar da linha lida anteriormente
		$tags['room'] = $linha['fk_numero_sala']; // armazena o numero da sala da linha lida anteriormente
		$tags['category'] = $linha['nomecategoria']; // armazena a categoria da sala da linha lida anteriormente
		$tags['name'] = $linha['descricao']; // armazena a descricao da sala da linha lida anteriormente
		
		// como ainda nao estao cadastrados no banco, faz o nome da imagem com a descricao trocando espacos por "_", passando para minusculas e removendo acentos
		$tags['image'] = retiraAcentos(strtolower(str_replace(" ", "_", $linha['descricao'])));
		//$tags['image'] = $linha['imagem']; // armazena a imagem da sala da linha lida anteriormente
		
		$tags['horario'] = $linha['horario']; // armazena o horario de funcionamento da sala da linha lida anteriormente
		$tags['email'] = $linha['email']; // armazena o email da sala da linha lida anteriormente
		$tags['telefone'] = $linha['telefone']; // armazena o telefone da sala da linha lida anteriormente

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