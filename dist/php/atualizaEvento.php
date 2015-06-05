<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// verifica se recebeu os parametros por POST
	if(isset($_POST['dataInicio'], $_POST['horaInicio'], $_POST['dataFinal'], $_POST['horaFinal'], $_POST['descricaoEvento'], $_POST['local'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
			
		// armazena os parametros recebidos
		$descricaoEvento = $_POST['descricaoEvento'];
		$dataInicio = $_POST['dataInicio'];
		$horaInicio = $_POST['horaInicio'];
		$dataFinal = $_POST['dataFinal'];
		$horaFinal = $_POST['horaFinal'];
		$local = $_POST['local'];

		// monta a query de insercao de evento
		$sql = "INSERT INTO
					`evento_geral`
					(`id`, `data_inicio`, `hora_inicio`,`data_final`,`hora_final`,`descricao`, `local_evento`)
				VALUES
					(NULL, STR_TO_DATE('".$dataInicio."', '%d/%m/%Y'), '".$horaInicio."', STR_TO_DATE('".$dataFinal."', '%d/%m/%Y'), '".$horaFinal."', '".$descricaoEvento."', '".$local."');";

		echo "Query de inserção: ".$sql."<br>";
			
		// executa a query de insercao
		mysql_query($sql) or die(mysql_error());
		
        //mysql_query("UPDATE aluno SET nome='{$nome}', email='{$email}', celular='{$celular}'  where id='{$id}'") or die(mysql_error());
			
		// faz a verificação do resultado
		//echo (mysql_affected_rows()) ? "Disciplina inserida/alterada com sucesso!" : "A disciplina não pode ser inserida/alterada!"; 
		echo (mysql_affected_rows()) ? 1 : 99; // retorna 1 caso a disciplina tenha sido inserida/alterada ou 0 se não inseriu/alterou

		//echo $local . " - " . $dataInicio . " - " . $horaInicio . " - " . $dataFinal . " - " . $horaFinal . " - " . $descricaoEvento . " - " . $local;
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para inserir ou alterar os dados");
?> 