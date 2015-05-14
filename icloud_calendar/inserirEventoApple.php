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
	
// iCloud CalDAV URL looks like:
// https://p02-caldav.icloud.com/12345678/calendars/XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX/
// https://<SERVER>-caldav.icloud.com/<USER_ID>/calendars/<CALENDAR_ID>/

// verifica se recebeu os parametros por POST
if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes'])){
	
	// sanitiza as entradas
	//foreach($_POST AS $key => $value) {	$_POST[$key] = mysql_real_escape_string($value); }
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	foreach($_POST['arrayDisciplinas'] as $campoDisciplina) {
		//disciplinasDiaDaSemana.push({ "unidade": unidadeP, "turno": turnoP, "dia": diaP, "sala": salaP, "disciplina": disciplinaP});
		//echo "Disciplina: " . $result['disciplina'] . '<br>';
		$dia = $campoDisciplina['dia'];
		$sala = $campoDisciplina['sala'];
		$turno = $campoDisciplina['turno'];
		$unidade = $campoDisciplina['unidade'];
		$disciplina = $campoDisciplina['disciplina'];
		//} comentado para estender o for ate o final deste arquivo
		
		// monta as strings para o evento
		$sumarioEvento = 'LocalizeSenac - Aula -  ' . $disciplina;
		$unidadeEvento = 'Faculdade Senac Porto Alegre - Unidade ' .$unidade. ' - Sala: ' . $sala;
		
		date_default_timezone_set('America/Sao_Paulo'); // define o timezone

		$horaInicioDiaLetivo = '07:00:00';
		$horaFinalDiaLetivo = '23:00:00';
		
		// define as datas de inicio e final de semestre para recorrencia dos eventos
		if(date('n') < 8){ // se o mes for ate julho
			$dataInicioSemestre = '2015-02-23T07:00:00.000Z';
			$dataFinalSemestre = '2015-07-10T23:00:00.000Z';
			echo "Primeiro Semestre <BR>";
		}
		else{
			$dataInicioSemestre = '2015-08-01T17:06:02.000Z';
			$dataFinalSemestre = '2015-12-12T23:00:00.000Z';
			echo "Segundo Semestre <BR>";
		}
		
		if ($turno == 'M'){ // se for o turno da manha
			$horaInicioAula = '08:00:00';
			$horaFinalAula = '11:40:00';
		}
		if ($turno == 'N'){
			$horaInicioAula = '19:00:00';
			$horaFinalAula = '22:40:00';
		}
		
		$diaAtual = date('Y-m-d'); // instancia e define a mascara da data
		//$diaAtual = date('Y-m-dTH:i:s'); // formato de data com hora
		$diaSemanaAtual = getDiaSemana($diaAtual); // busca e armazena o dia da semana atual
		
		// laco de 0 a 6 para percorrer todos os dias da semana e definir a data do evento
		for ($i = 0; $i < 7; $i++) { 
			
			$diaAtual = date('Y-m-d', strtotime("+".$i." days")); // incrementa o dia atual com a variavel $i
			$diaSemanaAtual = getDiaSemana($diaAtual); // atualizar a variavel diaSemanaAtual
			
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
	
		// Connection settings
		$my_icloud_server = 'p02';
		$my_user_id = '1759380956';
		//$my_calendar_id= 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
		$my_calendar_id= 'home';
		$my_icloud_username = 'xxx@icloud.com';
		$my_icloud_password = 'xxx';

		// iCloud calendar object
		$icloud_calendar = new php_icloud_calendar($my_icloud_server, $my_user_id, $my_calendar_id, $my_icloud_username, $my_icloud_password);

		// Get iCloud events
		$my_range_date_time_from = date("Y-m-d H:i:s", strtotime("-1 week"));
		$my_range_date_time_to = date("Y-m-d H:i:s", strtotime("+1 week"));
		$my_events = $icloud_calendar->get_events($my_range_date_time_from, $my_range_date_time_to);
		print_r($my_events);

		// Add iCloud event
		$icloud_calendar->add_event(date("Y-m-d 16:05:00"), 
									date("Y-m-d 16:20:00"), 
									"Título do evento", 
									"Descrição do evento", 
									"Minha cidade",
									"60");
			}	
	}
else
	echo 0;