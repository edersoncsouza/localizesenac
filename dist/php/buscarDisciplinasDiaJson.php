<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
	//protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['dia'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$dia = $_POST['dia'];
	
	// busca as disciplinas do dia recebido
	$sql = "SELECT
				fk_sala_fk_id_unidade AS UNIDADE, turno AS TURNO, aluno_disciplina.dia_semana AS DIA, aluno_disciplina.fk_numero_sala AS SALA, disciplina.nome AS DISC
			FROM
				aluno_disciplina, disciplina, aluno
			WHERE
				aluno.id = aluno_disciplina.fk_id_aluno
			AND
				disciplina.id = aluno_disciplina.fk_id_disciplina
			AND
				aluno_disciplina.fk_id_aluno =" . $_SESSION['usuarioID'] . 
			" AND dia_semana =\"" .$dia .
			"\" ORDER BY
				aluno_disciplina.id";

	$result = mysql_query($sql, $_SESSION['conexao']);

	//cria o array data
		$data;//= []; 
		
	// armazena no array os nomes das disciplinas
	while ($row = mysql_fetch_assoc($result)) {
        $data[] = $row;
	}
		// codifica o array em formato Json e devolve como retorno
		echo json_encode($data);
		
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");

?>

