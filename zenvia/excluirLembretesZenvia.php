<?php

include('../dist/php/funcoes.php');
include('../dist/php/seguranca.php'); // Inclui o arquivo com o sistema de segurança

	// definir o charset do banco
	mysql_set_charset('UTF8', $_SG['link']);
	
	// monta a query de pesquisa de lembretes do zenvia
	$sqlPesquisa = "SELECT
				aluno_lembrete.id
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

	// EXCLUI OS LEMBRETES DO zsms DA TABELA aluno_lembrete
	if(mysql_num_rows($resultPesquisa) != 0){ // se encontrou lembretes zsms para o aluno
		while($row = mysql_fetch_array($resultPesquisa)) { // para cada linha do resultset
				$sqlDelete = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
				$resultDelete = mysql_query($sqlDelete) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		}
	}

?>