<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['id'], $_POST['dia'], $_POST['turno'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$id = $_POST['id'];
		$dia = $_POST['dia'];
		$turno = $_POST['turno'];
		
		$sql = "	DELETE FROM
						aluno_disciplina
					WHERE
						dia_semana =\"" .$dia.
					"\" AND
						turno =\"" .$turno.
					"\" AND
						fk_id_aluno =".$id;
		echo "Query sql: ". $sql."<br>";
		
		// executa a query para exclusao da disciplina
		$result = mysql_query($sql)or die(mysql_error());
			
			// faz a verificação do resultado
			//echo (mysql_affected_rows()) ? "Disciplina excluida com sucesso!" : "A disciplina não pode ser excluida!"; 
			echo (mysql_affected_rows()) ? 1 : 0; // retorna 1 caso a disciplina tenha sido excluida ou 0 se não excluiu

	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para a exclusao da disciplina");
?> 