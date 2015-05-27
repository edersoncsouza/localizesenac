<?php
/**
 * php iCloud Calendar class example
 * 
 * Copyright by Emanuel zuber <emanuel@zubini.ch>
 * Version 0.1
 */

// Load ICS parser
require_once('addons/ics-parser/class.iCalReader.php');
// Load iCloud Calendar class
require_once('class.iCloudCalendar.class.php');
include('../dist/php/funcoes.php');
include('../dist/php/seguranca.php'); // Inclui o arquivo com o sistema de segurança

// iCloud CalDAV URL looks like:
// https://p02-caldav.icloud.com/12345678/calendars/XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX/
// https://<SERVER>-caldav.icloud.com/<USER_ID>/calendars/<CALENDAR_ID>/

// verifica se recebeu os parametros por POST
if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes'], $_POST['arrayAutenticacao'])){

	// ARMAZENA O ARRAY DE AUTENTICACAO
	$arrayAutenticacao = $_POST['arrayAutenticacao'];
	
	// DESMEMBRA O ARRAY DE AUTENTICACAO E ARMAZENA NAS VARIAVEIS LOCAIS
	$idIcloud = $arrayAutenticacao['id'];
	$userIcloud = $arrayAutenticacao['usuario'];
	$pwIcloud = $arrayAutenticacao['senha'];

	// INICIO DO PROCESSO DE AUTENTICACAO NO ICLOUD
	// cria um array com os valores dos servidores iCloud
	$icloudServers = array();
	for($i = 1; $i < 25; $i++)
		$icloudServers[] = "p" . str_pad($i, 2, '0', STR_PAD_LEFT);

	// Connection settings
	//$my_icloud_server = 'p02';
	$my_icloud_server = $icloudServers[rand(0,23)]; // seleciona um dos servidores aleatoriamente
	
	//echo "Servidor iCloud selecionado: " . $my_icloud_server . "\n";
	
	//$my_user_id = '1759380956';
	$my_user_id = $idIcloud; // armazena o id do usuario vindo do POST
	$my_calendar_id= 'home'; // define o calendario pessoal como o calendario de destino do evento
	//$my_icloud_username = 'xxx@icloud.com';
	$my_icloud_username = $userIcloud; // define o usuario para cadastrar o evento
	//$my_icloud_password = 'xxx';
	$my_icloud_password = $pwIcloud; // define a senha para cadastrar o evento

	// iCloud calendar object
	$icloud_calendar = new php_icloud_calendar($my_icloud_server, $my_user_id, $my_calendar_id, $my_icloud_username, $my_icloud_password);

	// Get iCloud events
	//$my_range_date_time_from = date("Y-m-d H:i:s", strtotime("-1 week"));
	//$my_range_date_time_to = date("Y-m-d H:i:s", strtotime("+1 week"));
	//$my_events = $icloud_calendar->get_events($my_range_date_time_from, $my_range_date_time_to);	
	//foreach($my_events as $event) echo $event->SUMMARY;
		
	// FINAL DO PROCESSO DE AUTENTICACAO NO ICLOUD

	
	// ARMAZENA E DECODIFICA O ARRAY DE LEMBRETES
	$arrayLembretes = json_decode($_POST['arrayLembretes'], true);

	// ARMAZENA E DECODIFICA O ARRAY DE DISCIPLINAS
	$arrayDisciplinas = json_decode($_POST['arrayDisciplinas'], true);
	
	date_default_timezone_set('America/Sao_Paulo'); // define o timezone	
	
	// METODO 1 - INICIO DO PROCESSO DE EXCLUSAO DE TODOS OS EVENTOS DA SEMANA QUE FOREM DO TIPO ICLOUD
	// DESSA FORMA SE GARANTE A EXCLUSAO DOS LEMBRETES QUE TIVERAM O CHECKBOX DESMARCADO
	
	// DEFINE O PERIODO DE REMOCAO (SEMANA TODA)
	$diaAtualRemocao = (date('Y-m-d'). 'T00:00:00.000z'); // define o inicio do dia atual
	$diaFinalRemocao = (date('Y-m-d', strtotime("+7 days")).'T23:59:59.000z'); // define o final do ultimo dia da semana
	
	// ARMAZENA OS EVENTOS DA SEMANA DO TIPO LOCALIZESENAC E EXCLUI
	$eventosSemanaisIcloud = $icloud_calendar->get_events($diaAtualRemocao, $diaFinalRemocao); // armazena os eventos no periodo da semana atual
	
	echo "Dia inicial de remocao: " . $diaAtualRemocao . "\n";
	echo "Dia final de remocao: " . $diaFinalRemocao . "\n";
	
	//echo "Array de eventos semanais iCloud:\n";
	//print_r($eventosSemanaisIcloud);
	//echo "\n";
	
	if($eventosSemanaisIcloud){ // se existirem eventos na semana
		$eventosDiariosExcluir = []; // cria o array de eventos a excluir
		
		foreach($eventosSemanaisIcloud as $eventoDiario){ // laço que percorre cada evento diario
			
			if (substr($eventoDiario['SUMMARY'], 0, 13) == "LocalizeSenac"){ // se o evento for do tipo Localizesenac
				//$icloud_calendar->remove_event($eventoDiario['UID']);
				
				if(!in_array($eventoDiario['UID'], $eventosDiariosExcluir)){ // se o id do evento ja nao estiver no array de exclusao
					
					array_push($eventosDiariosExcluir,$eventoDiario['UID']); // envia o elemento pro array
				
				}
				
			}
		}
		
		echo "Array de eventos a excluir:\n";
		print_r($eventosDiariosExcluir);
		echo "\n";
		
		
		foreach($eventosDiariosExcluir as $eventoParaExcluir) // laço que percorre todos os UID's de eventos a excluir
			$icloud_calendar->remove_event($eventoParaExcluir); // remove o evento com o UID fornecido
		
	}
	// METODO 1 - FINAL DO PROCESSO DE EXCLUSAO DE TODOS OS EVENTOS DA SEMANA QUE FOREM DO TIPO ICLOUD
	
	// INICIO DO PROCESSO DE EXCLUSAO DE TODOS OS LEMBRETES DO USUARIO DO TIPO ICLOUD DA TABELA aluno_lembrete
	
	// definir o charset do banco
	mysql_set_charset('UTF8', $_SG['link']);
	
	// monta a query de pesquisa de lembretes do icloud
	$sqlPesquisa = "SELECT
				aluno_lembrete.id, fk_id_aluno, dia_semana, turno, tipo
			FROM
				aluno_lembrete, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				tipo = 'icloud'";
	
	// executa a query para verificar se o aluno ja possui lembretes
	$resultPesquisa = mysql_query($sqlPesquisa) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());

	// EXCLUI OS LEMBRETES DO icloud DA TABELA aluno_lembrete
	if(mysql_num_rows($resultPesquisa) != 0){ // se encontrou lembretes icloud para o aluno
		while($row = mysql_fetch_array($resultPesquisa)) { // para cada linha do resultset
				$sqlDelete = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
				$resultDelete = mysql_query($sqlDelete) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		}
	}
	// FINAL DO PROCESSO DE EXCLUSAO DE TODOS OS LEMBRETES DO USUARIO DO TIPO ICLOUD DA TABELA aluno_lembrete
	
	
	
	/*
	// ARMAZENA OS DIAS DA SEMANA SEM EVENTOS PARA EXCLUIR LEMBRETES DESMARCADOS
	$arrayDiasDaSemana = ["segunda", "terça", "quarta", "quinta", "sexta", "sábado", "domingo"]; // array com dias da semana para comparacao
	$arrayDiasDaSemanaLembretes = []; // array para armazenar os dias da semana com lembrete para comparacao
	
	foreach($arrayLembretes as $lembrete){ // para cada lembrete
		array_push($arrayDiasDaSemanaLembretes, $lembrete['dia']); // armazena os dias dos lembretes no arrayDiasDaSemanaLembretes
	}
	
	// ARMAZENA OS DIAS SEM LEMBRETES PARA EXCLUSAO
	foreach($arrayDiasDaSemana as $diaDaSemana){// para cada dia da semana
		if (!in_array($diaDaSemana, $arrayDiasDaSemanaLembretes)){ // se um dia da semana nao constar no array de lembretes
			
			$data = getDataDiaDaSemana($diaDaSemana);// descobrir a data do dia da semana
			
			$inicioDataRemocao = ($data . 'T00:00:00.000z'); // define o inicio do dia de remocao
			$finalDataRemocao = (($data, strtotime("+6 days")) . 'T23:59:59.000z'); // define o final do dia de remocao
			
			$eventosSemanaisIcloud = $icloud_calendar->get_events($inicioDataRemocao, $finalDataRemocao); // armazena os eventos no periodo da semana atual
			// listar os eventos do icloud no diaDaSemana
			// armazenar o(s) UID(s) do(s) evento(s) do diaDaSemana
			// verificar se os eventos sao do tipo localizesenac
				//$icloud_calendar->remove_event($eventoDiario['UID']); // excluir os eventos do tipo localizesenac do icloud no dia da semana
				// excluir os eventos do tipo do tipo icloud na tabela aluno_lembrete no dia da semana
		}
	}
	*/

	// DESMEMBRA O ARRAY DE DISCIPLINAS, ARMAZENA NAS VARIAVEIS LOCAIS E EFETUA A CRIACAO DOS EVENTOS POR DISCIPLINA
	foreach($arrayDisciplinas as $campoDisciplina) {
		//disciplinasDiaDaSemana.push({ "unidade": unidadeP, "turno": turnoP, "dia": diaP, "sala": salaP, "disciplina": disciplinaP});
		//echo "Disciplina: " . $result['disciplina'] . '<br>';
		$dia = $campoDisciplina['dia'];
		$sala = $campoDisciplina['sala'];
		$turno = $campoDisciplina['turno'];
		$unidade = $campoDisciplina['unidade'];
		$disciplina = $campoDisciplina['disciplina'];
		
		$tipoLembrete = $arrayLembretes[0]['tipoLembrete']; // armazena o tipo de lembrete icloud
		
		// DESMEMBRA O ARRAY DE LEMBRETES E ARMAZENA OS MINUTOS DE ANTECEDENCIA DO DIA DA  SEMANA DA DISCIPLINA ATUAL 
		foreach($arrayLembretes as $campoLembrete) {
			$diaLembrete = $campoLembrete['dia'];
			if($diaLembrete == $dia)
				$minutosAntec = $campoLembrete['minutos'];
		}
		
		// monta as strings para o evento
		$sumarioEvento = 'LocalizeSenac - Aula -  ' . $disciplina;
		$unidadeEvento = 'Faculdade Senac Porto Alegre - Unidade ' .$unidade. ' - Sala: ' . $sala;
		

		// DEFINE OS PERIODOS MAXIMOS DIARIOS DOS LEMBRETES
		$horaInicioDiaLetivo = '07:00:00';
		$horaFinalDiaLetivo = '23:00:00';
		
		// DEFINE AS DATAS DE INICIO E FINAL DE SEMESTRE PARA RECORRENCIA DOS EVENTOS
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
		
		if ($turno == 'M'){ // se for o turno da manha
			$horaInicioAula = '08:00:00';
			$horaFinalAula = '11:40:00';
		}
		if ($turno == 'N'){ // se for o turno da noite
			$horaInicioAula = '19:00:00';
			$horaFinalAula = '22:40:00';
		}
		
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
		
		date_default_timezone_set('America/Sao_Paulo'); // define a TimeZone
		
		// DEFINE PERIODO PARA PESQUISA DE EVENTOS
		$inicio = ($dataDoEvento. 'T' . $horaInicioDiaLetivo . '.000z'); // cria a string com o dia atual e primeiro horario letivo
		//$inicio = ($dataDoEvento. 'T' . $horaInicioAula . '.000Z'); // cria a string com o dia atual e primeiro horario do turno com Z identifica GMT
		// exemplo de formato de data e hora aceitos: 2015-03-07T17:06:02.000Z
		
		$final = ($dataDoEvento. 'T' . $horaFinalDiaLetivo . '.000z'); // cria a string com o dia atual e ultimo horario letivo
		//$final = ($dataDoEvento. 'T' . $horaFinalAula . '.000Z'); // cria a string com o dia atual e ultimo horario do turno
	
		$dataHoraInicioEvento = ($dataDoEvento . 'T' . $horaInicioAula. '.000'); // define a data e hora de inicio do evento
		$dataHoraFinalEvento = ($dataDoEvento . 'T' . $horaFinalAula. '.000'); // define a data e hora de final do evento
		
		/*
		// METODO 2 - ARMAZENA OS EVENTOS DENTRO DO PERIODO DO EVENTO QUE ESTA SENDO INCLUIDO
		$my_events = $icloud_calendar->get_events($dataHoraInicioEvento, $dataHoraFinalEvento);
		
		// SE RETORNOU EVENTOS NO MESMO PERIODO
		if($my_events){
			$eventosExcluir = []; //cria um array com eventos a excluir para evitar excluir eventos um por um
			
			// LISTA E ARMAZENA OS IDs DOS EVENTOS
			foreach($my_events as $event){ // laco que percorre cada um dos eventos encontrados
				
				echo "ID do evento: " . $event['UID'] . "\n";
				$UID_evento = $event['UID']; // armazena o ID do evento
				
				if(!in_array($UID_evento, $eventosExcluir)){ // se o id ja nao estiver no array
					array_push($eventosExcluir,$UID_evento); // envia o elemento pro array
				
					// SE O EVENTO FOR DO TIPO LOCALIZESENAC APAGA O MESMO
					if (substr($event['SUMMARY'], 0, 13) == "LocalizeSenac"){
						 $icloud_calendar->remove_event($UID_evento);
						 echo "UID do evento removido: " . $UID_evento . "\n";
					}
				}
				
			}
		}
		*/
		
		// Add iCloud event
		$icloud_calendar->add_event($dataHoraInicioEvento, 
									$dataHoraFinalEvento, 
									$sumarioEvento, 
									$unidadeEvento, 
									"Porto Alegre",
									$minutosAntec,
									"WEEKLY",
									$dataFinalSemestre
									);
		
		
		
		// PROCEDIMENTO DE INCLUIR OS LEMBRETES NA TABELA aluno_lembrete NO BANCO DE DADOS
		
		$dia = strtoupper(substr($dia, 0, 3)); // armazena os tres primeiros caracteres do dia
		
		// monta a query de pesquisa de lembretes do icloud
		$sql = "SELECT
					aluno_lembrete.id, fk_id_aluno, dia_semana, turno, tipo
				FROM
					aluno_lembrete, aluno
				WHERE
					matricula = \"{$_SESSION['usuarioLogin']}\"
				AND 
					dia_semana = \"{$dia}\"
				AND
					turno = \"{$turno}\"
				AND
					tipo = \"{$tipoLembrete}\"";
					
		// executa a query para verificar se o aluno ja possui lembretes
		$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		//echo "O numero de lembretes icloud e: " . mysql_num_rows($result) . "\n";
		
		$disciplina = trim($disciplina);
		
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
		
		// ARMAZENA A ID DE LEMBRETES PARA DISCIPLINAS INEXISTENTES PARA O ALUNO
		$sql6 = "SELECT
					id
				FROM
					aluno_lembrete
				WHERE
					`fk_id_aluno` = \"{$idAluno}\"
				AND
					tipo = \"icloud\"
				AND
					(fk_id_aluno, fk_id_disciplina, dia_semana, turno)

				NOT IN (
					SELECT
						fk_id_aluno, fk_id_disciplina, dia_semana, turno
					FROM 
						aluno_disciplina
					WHERE
						`fk_id_aluno` =  \"{$idAluno}\"
				)";
		$result6 = mysql_query($sql6) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		// EXCLUI LEMBRETES PARA DISCIPLINAS INEXISTENTES PARA O ALUNO 
		if(mysql_num_rows($result6) != 0){ // se encontrou lembretes sem disciplina associada ao aluno
			while($row = mysql_fetch_array($result6)) { // para cada linha do resultset
					//echo "Exclui o lembrete ID: " . $row['id'] . "\n";
					$sql7 = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
					$result7 = mysql_query($sql7) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
			}
		}
			
			
		// EXCLUI OS LEMBRETES DO icloud DA TABELA aluno_lembrete
		if(mysql_num_rows($result) != 0){ // se encontrou lembretes icloud para o aluno
			while($row = mysql_fetch_array($result)) { // para cada linha do resultset
					$sql4 = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
					//echo "SQL4: " . $sql4 . "\n";
					$result4 = mysql_query($sql4) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
			}
		}
		
		// INSERE OS LEMBRETES NA TABELA aluno_lembrete
		
		// monta a query de insercao de lembrete
		$sql5 = "INSERT INTO
			`aluno_lembrete` ( `fk_id_aluno` ,  `dia_semana` ,  `turno` ,  `fk_sala_fk_id_unidade` ,  `fk_andar_sala` , `fk_numero_sala`, `fk_id_disciplina`, `tipo`, `minutosantec`,`dt_inicio`,`dt_final`)
		VALUES(  '{$idAluno}', '{$dia}', '{$turno}', '{$unidade}', '{$andarSala}', '{$sala}', '{$idDisciplina}', '{$tipoLembrete}', '{$minutosAntec}', '{$dataDoEvento}', '{$dataFinal}'  ) "; 						
		// executa a query para armazenar o lembrete em banco na tabela aluno_lembrete
		$result5 = mysql_query($sql5) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());

	}	
}//if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes']))
else
	echo 0;