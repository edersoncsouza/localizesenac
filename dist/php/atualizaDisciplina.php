<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// verifica se recebeu os parametros por POST
	if(isset($_POST['id'], $_POST['dia'], $_POST['sala'], $_POST['andar'], $_POST['turno'], $_POST['unidade'], $_POST['disciplina'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$id = $_POST['id'];
		$dia = $_POST['dia'];
		$sala = $_POST['sala'];
		$andar = $_POST['andar'];
		$turno = $_POST['turno'];
		$unidade = $_POST['unidade'];
		$disciplina = $_POST['disciplina'];
		
		// monta a query de insercao de disciplina
		$sql = "INSERT INTO
					`aluno_disciplina`
					(`id`, `dia_semana`, `turno`, `fk_id_aluno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`)
				VALUES
					(NULL, '".$dia."', '".$turno."', ".$id.", ".$unidade.", ".$andar.", ".$sala.", \"".$disciplina."\");
		";
		
		echo "Query de inserção: ".$sql."<br>";
		
		// executa a query de insercao
		mysql_query($sql) or die(mysql_error());
		
        //mysql_query("UPDATE aluno SET nome='{$nome}', email='{$email}', celular='{$celular}'  where id='{$id}'") or die(mysql_error());
			
		// faz a verificação do resultado
		//echo (mysql_affected_rows()) ? "Disciplina inserida/alterada com sucesso!" : "A disciplina não pode ser inserida/alterada!"; 
		echo (mysql_affected_rows()) ? 1 : 0; // retorna 1 caso a disciplina tenha sido inserida/alterada ou 0 se não inseriu/alterou	
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para inserir ou alterar os dados");
?> 