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
session_start();

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
	
	// ARMAZENA E DECODIFICA O ARRAY DE LEMBRETES
	$arrayLembretes = json_decode($_POST['arrayLembretes'], true);

	// ARMAZENA E DECODIFICA O ARRAY DE DISCIPLINAS
	$arrayDisciplinas = json_decode($_POST['arrayDisciplinas'], true);
	
	// DESMEMBRA O ARRAY DE DISCIPLINAS, ARMAZENA NAS VARIAVEIS LOCAIS E EFETUA A CRIACAO DOS EVENTOS POR DISCIPLINA
	foreach($arrayDisciplinas as $campoDisciplina) {
		//disciplinasDiaDaSemana.push({ "unidade": unidadeP, "turno": turnoP, "dia": diaP, "sala": salaP, "disciplina": disciplinaP});
		//echo "Disciplina: " . $result['disciplina'] . '<br>';
		$dia = $campoDisciplina['dia'];
		$sala = $campoDisciplina['sala'];
		$turno = $campoDisciplina['turno'];
		$unidade = $campoDisciplina['unidade'];
		$disciplina = $campoDisciplina['disciplina'];
		
		// DESMEMBRA O ARRAY DE LEMBRETES E ARMAZENA OS MINUTOS DE ANTECEDENCIA DO DIA DA  SEMANA DA DISCIPLINA ATUAL 
		foreach($arrayLembretes as $campoLembrete) {
			$diaLembrete = $campoLembrete['dia'];
			if($diaLembrete == $dia)
				$minutosAntec = $campoLembrete['minutos'];
		}
		
		// monta as strings para o evento
		$sumarioEvento = 'LocalizeSenac - Aula -  ' . $disciplina;
		$unidadeEvento = 'Faculdade Senac Porto Alegre - Unidade ' .$unidade. ' - Sala: ' . $sala;
		
		date_default_timezone_set('America/Sao_Paulo'); // define o timezone

		// DEFINE OS PERIODOS MAXIMOS DIARIOS DOS LEMBRETES
		$horaInicioDiaLetivo = '07:00:00';
		$horaFinalDiaLetivo = '23:00:00';
		
		// DEFINE AS DATAS DE INICIO E FINAL DE SEMESTRE PARA RECORRENCIA DOS EVENTOS
		if(date('n') < 8){ // se o mes for ate julho
			//$dataInicioSemestre = '2015-02-23T07:00:00.000Z'; // formato API PHP Google Calendar
			$dataInicioSemestre = '20150223T070000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			//$dataFinalSemestre = '2015-07-10T23:00:00.000Z'; // formato API PHP Google Calendar
			$dataFinalSemestre = '20150710T230000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			//echo "Primeiro Semestre <BR>";
		}
		else{ // se for de julho a dezembro
			//$dataInicioSemestre = '2015-08-01T07:00:00.000Z'; // formato API PHP Google Calendar
			$dataInicioSemestre = '20150801T070000Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
			//$dataFinalSemestre = '2015-12-12T23:00:00.000Z'; // formato API PHP Google Calendar
			$dataFinalSemestre = '20151212T235959Z'; // 20150710T230000Z - Formato Classe class.iCloudCalendar.class.php
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
			
			if($diaSemanaAtual == $dia){ // verifica se o dia da semana atual e igual ao dia recebido como parametro
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

		//foreach($my_events as $event) echo $event->SUMMARY;

		$dataHoraInicioEvento = ($dataDoEvento . 'T' . $horaInicioAula. '.000'); // define a data e hora de inicio do evento
		$dataHoraFinalEvento = ($dataDoEvento . 'T' . $horaFinalAula. '.000'); // define a data e hora de final do evento

		// Get iCloud events
		//$my_range_date_time_from = date("Y-m-d H:i:s", strtotime("-1 week"));
		//$my_range_date_time_to = date("Y-m-d H:i:s", strtotime("+1 week"));

		//$my_events = $icloud_calendar->get_events($my_range_date_time_from, $my_range_date_time_to);
		
		// ARMAZENA OS EVENTOS DENTRO DO PERIODO DO EVENTO QUE ESTA SENDO INCLUIDO
		$my_events = $icloud_calendar->get_events($dataHoraInicioEvento, $dataHoraFinalEvento);
		
		echo "Eventos no dia" . $dataDoEvento . "\n";
		//var_dump($my_events);
		
		// LISTA E ARMAZENA OS IDs DOS EVENTOS
		foreach($my_events as $event){
			echo "ID do evento: " . $event['UID'] . "\n";
			$UID_evento = $event['UID'];
			
			// SE O EVENTO FOR DO TIPO LOCALIZESENAC APAGA O MESMO
			if (substr($event['SUMMARY'], 0, 13) == "LocalizeSenac")
				//echo "SUMARIO do evento: " . $event['SUMMARY'] . "\n";
				// deletar o evento a partir do UID // http://www.simplemachines.org/community/index.php?topic=520893.0
				//$UID_evento
		}
		
		/*
		array(100) {
				[0]=>
					array(13) {
							["DTSTAMP"]=>
							string(16) "20150518T021433Z"
							["DTSTART"]=>
							string(16) "20150522T220000Z"
							["DTEND"]=>
							string(16) "20150523T014000Z"
							["UID"]=>
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
		
	}	
}//if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes']))
else
	echo 0;