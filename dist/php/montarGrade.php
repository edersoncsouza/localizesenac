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
		$sql = "	SELECT
									id, nome
								FROM
									disciplina, `disciplina_curso`
								WHERE
									disciplina_curso.fk_id_curso = {$curso}
								AND
									disciplina.id = disciplina_curso.fk_id_disciplina";
		
		// executa a query de selecao de disciplina por curso
		$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		//cria o array data
		$data;//= []; 

		// armazena no array os nomes das disciplinas para o select
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			 //$data[] = $row['nome']; 
			 $data[] = $row; // envia id e nome para montar os selects
		}
		
		// codifica o array em formato Json e devolve como retorno
		echo json_encode($data);

	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");
	
?> 