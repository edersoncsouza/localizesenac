<?php

session_start();
include('../dist/php/funcoes.php');
include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança

	$data = []; // cria o array de retorno
		
	// monta a query de pesquisa de lembretes do icloud
	$sql = "SELECT
				dia_semana, minutosantec, turno, fk_sala_fk_id_unidade, fk_numero_sala, fk_id_disciplina
			FROM
				aluno_lembrete, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				fk_id_aluno = aluno.id
			AND
				autenticacao = \"{$_SESSION['tipoUsuario']}\"
			AND
				fk_id_lembrete_tipo = 3
			ORDER BY
				dia_semana"; // icloud = 3
				
	// executa a query para verificar se o aluno ja possui lembretes
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	//echo "O numero de lembretes icloud e: " . mysql_num_rows($result) . "\n";
	
	if(mysql_num_rows($result) > 0){ // se houverem lembretes do tipo icloud
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
			//$data[] = array('diaDaSemana' => $row[0], 'minutos' => $row[1]); // armazena o dia da semana e os minutos em um array associativo
			$data[] = array('diaDaSemana' => $row[0], 'minutos' => $row[1], 'turno' => $row[2], 'unidade' => $row[3], 'sala' => $row[4], 'disciplina' => $row[5]); // armazena o dia da semana e os minutos em um array associativo
		}
	}
	
	// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
	if(count($data)>0)
		echo json_encode($data);
	else
		echo 0;
?>
