<?php
	include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("../dist/php/funcoes.php");
	protegePagina(); // Chama a função que protege a página

	// definir o charset do banco
	mysql_set_charset('UTF8', $_SG['link']);
	
	// monta a query de pesquisa de lembretes
	$sqlPesquisa = "SELECT
				dia_semana, minutosantec
			FROM
				aluno_lembrete, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				autenticacao = \"{$_SESSION['tipoUsuario']}\"
			AND
				fk_id_aluno = aluno.id
			AND
				tipo = 'zsms'";
	
	// executa a query para verificar se o aluno ja possui lembretes
	$resultPesquisa = mysql_query($sqlPesquisa) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());

	if(mysql_num_rows($resultPesquisa) > 0){ // se houverem lembretes do tipo icloud
		while ($row = mysql_fetch_array($resultPesquisa, MYSQL_NUM)) { // para cada linha
			$data[] = array('diaDaSemana' => $row[0], 'minutos' => $row[1]); // armazena o dia da semana e os minutos em um array associativo
		}
	}
	// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
	if(count($data)>0)
		echo json_encode($data);
	else
		echo 0;
?>
