<?php

session_start();
include('dist/php/funcoes.php');
include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança

	$data = [];
		
	// monta a query de pesquisa de disciplinas do aluno
	$sql = "SELECT
				dia_semana, turno, fk_sala_fk_id_unidade, fk_numero_sala, fk_id_disciplina
			FROM
				aluno_disciplina, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				fk_id_aluno = aluno.id";
				
	// executa a query para verificar as disciplinas do aluno
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0){ // se houverem disciplinas para o aluno
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
			$data[] = array('dia' => $row[0], 'turno' => $row[1], 'unidade' => $row[2], 'sala' => $row[3], 'disciplina' => $row[4]); // armazena o dia da semana e os minutos em um array associativo
		}
	}
	
	// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
	if(count($data)>0)
		echo json_encode($data);
	else
		echo 0;
?>
