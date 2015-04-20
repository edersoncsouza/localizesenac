<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['curso'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$curso = $_POST['curso'];
		
		// busca as disciplinas do curso recebido
		$result = mysql_query("	SELECT
									nome
								FROM
									disciplina, `disciplina_curso`
								WHERE
									disciplina_curso.fk_id_curso = {$curso}
								AND
									disciplina.id = disciplina_curso.fk_id_disciplina");
		
		//cria o array data
		$data= []; 

		// armazena no array os nomes das disciplinas para o select
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			 $data[] = $row['nome']; 
		}
		
		// codifica o array em formato Json e devolve como retorno
		echo json_encode($data);

	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");
	
?> 