<?php

include('../dist/php/funcoes.php');
include('../dist/php/seguranca.php'); // Inclui o arquivo com o sistema de segurança

// verifica se recebeu os parametros por POST
if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes'])){
	
	// ARMAZENA O ARRAY DE LEMBRETES
	$arrayLembretes = $_POST['arrayLembretes'];

	// ARMAZENA O ARRAY DE DISCIPLINAS
	$arrayDisciplinas = $_POST['arrayDisciplinas'];
	
	date_default_timezone_set('America/Sao_Paulo'); // define o timezone	
	
	// INICIO DO PROCESSO DE EXCLUSAO DE TODOS OS LEMBRETES DO USUARIO DO TIPO pemail DA TABELA aluno_lembrete
	
	// definir o charset do banco
	mysql_set_charset('UTF8', $_SG['link']);
	
	// monta a query de pesquisa de lembretes
	$sqlPesquisa = "SELECT
				aluno_lembrete.id, fk_id_aluno, dia_semana, turno, fk_id_lembrete_tipo
			FROM
				aluno_lembrete, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				autenticacao = \"{$_SESSION['tipoUsuario']}\"
			AND
				fk_id_aluno = aluno.id
			AND
				fk_id_lembrete_tipo = 1"; //pemail = 1
	
	// executa a query para verificar se o aluno ja possui lembretes
	$resultPesquisa = mysql_query($sqlPesquisa) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());

	// EXCLUI OS LEMBRETES DO TIPO pemail DA TABELA aluno_lembrete
	if(mysql_num_rows($resultPesquisa) != 0){ // se encontrou lembretes icloud para o aluno
		while($row = mysql_fetch_array($resultPesquisa)) { // para cada linha do resultset
				$sqlDelete = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
				$resultDelete = mysql_query($sqlDelete) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		}
	}
	// FINAL DO PROCESSO DE EXCLUSAO DE TODOS OS LEMBRETES DO USUARIO DO TIPO pemail DA TABELA aluno_lembrete
	
	// DESMEMBRA O ARRAY DE DISCIPLINAS, ARMAZENA NAS VARIAVEIS LOCAIS E EFETUA A CRIACAO DOS EVENTOS POR DISCIPLINA
	foreach($arrayDisciplinas as $campoDisciplina) {
		
		$dia = $campoDisciplina['dia'];
		$sala = $campoDisciplina['sala'];
		$turno = $campoDisciplina['turno'];
		$unidade = $campoDisciplina['unidade'];
		$disciplina = $campoDisciplina['disciplina'];
		
		$tipoLembrete = $arrayLembretes[0]['tipoLembrete']; // armazena o tipo de lembrete pemail
		
		// DESMEMBRA O ARRAY DE LEMBRETES E ARMAZENA OS MINUTOS DE ANTECEDENCIA DO DIA DA  SEMANA DA DISCIPLINA ATUAL 
		foreach($arrayLembretes as $campoLembrete) {
			$diaLembrete = $campoLembrete['dia'];
			if($diaLembrete == $dia)
				$minutosAntec = $campoLembrete['minutos'];
		}

		// DEFINE AS DATAS DE INICIO E FINAL DE SEMESTRE PARA LIMITAR OS ENVIOS DOS SMS 
		if(date('n') < 8){ // se o mes for ate julho
			//$dataInicioSemestre = '2015-02-23T07:00:00.000Z'; // formato API PHP Google Calendar
			$dataInicioSemestre = '20150223T070000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			//$dataFinalSemestre = '2015-07-10T23:00:00.000Z'; // formato API PHP Google Calendar
			$dataFinalSemestre = '20150710T230000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			$dataFinal = '2015-07-10T23:00:00.000Z'; // incluido para inserir o lembrete na tabela aluno_lembrete
			//echo "Primeiro Semestre <BR>";
		}
		else{ // se for de julho a dezembro
			//$dataInicioSemestre = '2015-08-01T07:00:00.000Z'; // formato API PHP Google Calendar
			$dataInicioSemestre = '20150801T070000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			//$dataFinalSemestre = '2015-12-12T23:00:00.000Z'; // formato API PHP Google Calendar
			$dataFinalSemestre = '20151212T235959Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			$dataFinal = '2015-12-12T23:59:59.000Z'; // incluido para inserir o lembrete na tabela aluno_lembrete
			//echo "Segundo Semestre <BR>";
		}

		// DEFINE A DATA DE INICIO DO ENVIO DE SMS PARA EVITAR ENVIO DE SMS ANTES DO INICIO DO SEMESTRE
		$diaAtual = date('Y-m-d'); // instancia e define a mascara da data
		
		//$diaAtual = date('Y-m-dTH:i:s'); // formato de data com hora
		$diaSemanaAtual = getDiaSemana($diaAtual); // busca e armazena o dia da semana atual
		
		// laco de 0 a 6 para percorrer todos os dias da semana e definir a data do evento
		// inclui os lembretes a partir do dia atual, nunca para dias anteriores
		for ($i = 0; $i < 7; $i++) { 
			
			$diaAtual = date('Y-m-d', strtotime("+".$i." days")); // incrementa o dia atual com a variavel $i
			//$diaSemanaAtual = getDiaSemana($diaAtual); // atualizar a variavel diaSemanaAtual
			$diaSemanaAtual = getNomeDiaSemana(getDiaSemana($diaAtual)); // atualizar a variavel diaSemanaAtual (pega o dia abrevidado pela data, pega o dia estendido pelo dia abreviado)
			
			if($diaSemanaAtual == $dia){ // verifica se o dia da semana atual e igual ao dia recebido como parametro de insercao de lembrete
				$dataDoEvento = $diaAtual; // varivel de data do evento recebe a data do proximo dia da semana correspondente
				$i = 7; // forca a saida do FOR
			}
		}
		
		// PROCEDIMENTO DE INCLUIR OS LEMBRETES NA TABELA aluno_lembrete NO BANCO DE DADOS
		$dia = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $dia ) ); // remove acentuacao do dia (sábado)
		$dia = strtoupper(substr($dia, 0, 3)); // armazena os tres primeiros caracteres do dia em maiusculas (SAB)
		
		$disciplina = trim($disciplina); // limpa espacos em branco no inicio e final do nome da disciplina
		
		// monta a query de pesquisa de id de disciplina
		$sql2 = "SELECT id FROM disciplina WHERE nome = \"$disciplina\"";
		// executa a query para armazenar o id da disciplina
		$result2 = mysql_query($sql2) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
		$idDisciplina =  mysql_result($result2,0); // recebe o id da disciplina
		
		$andarSala = substr($sala, 0, 1); // recebe o primeiro caractere do numero da sala como andar

		// monta a query de pesquisa de id de usuario
		$sql3 = "SELECT id FROM aluno WHERE matricula = \"{$_SESSION['usuarioLogin']}\"";
		// executa a query para armazenar o id do aluno
		$result3 = mysql_query($sql3) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		$idAluno = mysql_result($result3,0); // recebe o id do aluno			
		
		// INSERE OS LEMBRETES NA TABELA aluno_lembrete
		
		// monta a query de insercao de lembrete
		$sql5 = "INSERT INTO
			`aluno_lembrete` ( `fk_id_aluno` ,  `dia_semana` ,  `turno` ,  `fk_sala_fk_id_unidade` ,  `fk_andar_sala` , `fk_numero_sala`, `fk_id_disciplina`, `fk_id_lembrete_tipo`, `minutosantec`,`dt_inicio`,`dt_final`)
		VALUES(  '{$idAluno}', '{$dia}', '{$turno}', '{$unidade}', '{$andarSala}', '{$sala}', '{$idDisciplina}', 1, '{$minutosAntec}', '{$dataDoEvento}', '{$dataFinal}'  ) "; 						
		// executa a query para armazenar o lembrete em banco na tabela aluno_lembrete
		$result5 = mysql_query($sql5) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
	}
}//if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes']))
else
	echo 0;