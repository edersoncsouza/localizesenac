<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['andar'], $_POST['unidade'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$andar = $_POST['andar'];
		$unidade = $_POST['unidade'];
		
		// busca as salas do andar recebido
		$result = mysql_query("	SELECT
									numero 
								FROM
									sala
								WHERE
									fk_id_unidade = {$unidade}
								AND
									andar = {$andar}
								AND
									fk_id_categoria = 2
								ORDER BY
									numero");
		
		//cria o array data
		$data;//= []; 

		// armazena no array os nomes das disciplinas para o select
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			 $data[] = $row['numero']; 
		}
		
		// codifica o array em formato Json e devolve como retorno
		echo json_encode($data);

	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");
	
?> 