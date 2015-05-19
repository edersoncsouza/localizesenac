<!--
PENDENCIAS LOCAIS:

CONSULTA:

- Atalho para encaminhar à agenda com dados atraves de link
/* http://stackoverflow.com/questions/10488831/link-to-add-to-google-calendar 
http://www.google.com/calendar/event?action=TEMPLATE&dates=20140611T170000Z%2F20140611T174500Z&text=Real+Boy+Tech&details=Details%20go%20here
*/
-->

<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LocalizeSenac - Sistema de Indoor Mapping para a Faculdade Senac Porto Alegre">
	<meta name="keywords" content="Indoor Mapping,mapeamento interno,Faculdade Senac Porto Alegre">
    <meta name="author" content="Ederson Souza">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

<!-- jQuery -->
<script type="text/javascript" src="dist/components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

<!-- Bootbox -->
<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>

<!-- Funcoes JS -->
<script type="text/javascript" src="dist/js/funcoes.js"></script>
		
<?php

	session_start();

	//require('HttpPost.class.php');
	require_once realpath(dirname(__FILE__) . '/Google/autoload.php');
	include('dist/php/funcoes.php');

	 $client_id = '407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com';
	 $client_secret = 'WrIiWLHNXYJBwCwc1tUrL85A';
	 $redirect_uri = 'http://localhost:8080/projetos/localizesenac/auth.php';

	/************************************************/
	 
	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);

	$client->addScope("https://www.googleapis.com/auth/plus.me"); // adicionados escopos do Google Plus
	$client->addScope("https://www.googleapis.com/auth/plus.login");
	$client->addScope("https://www.googleapis.com/auth/calendar"); // adicionado escopo do Calendar (Agenda do Google)
	$client->addScope("https://www.googleapis.com/auth/userinfo.profile"); // adicionados escopos de informacoes de perfil do usuario Google
	$client->addScope("https://www.googleapis.com/auth/userinfo.email");

	/************************************************

	/* CRIA O SERVICO CALENDAR */
	$cl_service = new Google_Service_Calendar($client); // criado servico do Calendar e executada a query

	/************************************************
	  Boilerplate auth management - see
	  user-example.php for details.
	 ************************************************/
	if (isset($_REQUEST['logout'])) {
	  unset($_SESSION['access_token']);
	}
	if (isset($_GET['code'])) {
	  $client->authenticate($_GET['code']);
	  $_SESSION['access_token'] = $client->getAccessToken();
	  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}

	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	  $client->setAccessToken($_SESSION['access_token']);
	} else {
	  $authUrl = $client->createAuthUrl();
	}

	/****************************************************
	  se estiver logado fara os processos de recuperacao
	  de informacoes dos serviços do Google
	 ***************************************************/
	if ($client->getAccessToken()) {
	  $_SESSION['access_token'] = $client->getAccessToken();
	  
	/************************************************/

	// verifica se recebeu os parametros por POST
		if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes'])){
			
			// sanitiza as entradas
			//foreach($_POST AS $key => $value) {	$_POST[$key] = mysql_real_escape_string($value); }
			$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$jaLimpei = FALSE; // cria variavel booleana para efetuar limpeza dos eventos uma unica vez
			
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
			
			//configura os parametros da pesquisa na agenda
			$params = array(
				'singleEvents' => 'true',
				'timeMax' => $final,
				'timeMin' => $inicio,
				'orderBy' => 'startTime');
			
			$listaEventos = $cl_service->events->listEvents('primary', $params); // armazena a lista de eventos
			
			$eventos = $listaEventos->getItems(); // recebe os itens da lista de eventos

			//$existeEvento = FALSE; // cria variavel booleana para identificar se ja existe o evento
			
			if(count($eventos)>0){
			
			echo "Entrei para apagar eventos \n";
			
			// verifica se ja foi executada limpeza de eventos, para evitar excluir a primeira disciplina incluida
			if ( $jaLimpei === FALSE){ 

				$deleteParams = array('timeMin' => $inicio); // parametros para apagar os eventos recorrentes

				foreach ($eventos as $evento) { // para cada item de eventos como evento (dentro do periodo de tempo do dia)

					// armazena o sumario do evento existente
					$sumarioEventoExistente = $evento->getSummary();
					
					$introducaoSumario = substr($sumarioEventoExistente, 0, 13); // filtra os primeiros 13 caracteres do inicio do sumario

					// verifica se o evento foi criado pelo sistema LocalizeSenac
					if($introducaoSumario  == 'LocalizeSenac'){
						
						// armazena informacoes do evento existente
						$idEventoExistente = $evento->getId();
						echo "Evento encontrado ID: " . $idEventoExistente . "<br>";
						//$dataHoraInicioEventoExistente = $evento->getStart()->getDateTime();
						//$dataHoraFinalEventoExistente = $evento->getEnd()->getDateTime();

						// deleta o evento encontrado
						//$cl_service->events->delete('primary', $idEventoExistente); // exlui um evento unico, sem recorrencia
						
						/* TENTATIVA DE EXCLUSAO DE EVENTOS RECORRENTES http://stackoverflow.com/questions/20561258/how-recurring-events-in-google-calendar-work */
						$eventosRecorrentes = $cl_service->events->instances('primary', $idEventoExistente, $deleteParams); // armazena todas as instancias do evento recorrente
						
						if ($eventosRecorrentes && count($eventosRecorrentes->getItems())) { // se houverem eventosRecorrentes
						  foreach ($eventosRecorrentes->getItems() as $instance) { // laco para percorrer todos os eventos recorrentes
							  echo "Instancia do evento encontrada ID: " . $instance->getId() . "<br>";
							$cl_service->events->delete('primary', $instance->getId()); // deleta cada instancia do evento
						  }
						}

					}
				} // foreach ($eventos as $evento) 
			
				$jaLimpei = TRUE; // identifica que ja foram excluidos eventos do localizesenac antigos
			
			}
			
			} // se existem eventos
			
			// cria o evento calendar
			$event = new Google_Service_Calendar_Event(); // cria o novo evento

			$event->setSummary($sumarioEvento); // define o sumario do evento ex.: 'Aula - Tópicos Avançados em ADS'
			$event->setLocation($unidadeEvento); // define o local do evento

			// INICIO DO EVENTO
			$start = new Google_Service_Calendar_EventDateTime(); // cria o servico do calendar para o inicio do evento
			$start->setTimeZone('America/Sao_Paulo'); // define a TimeZone
			
			$start->setDateTime($dataDoEvento . 'T' . $horaInicioAula. '.000'); // define a data e hora de inicio do evento
			//$start->setDateTime('2015-04-27T19:00:00'); // formato de hora de inicio

			$event->setStart($start); // insere data e hora de inicio no objeto event

			// FINAL DO EVENTO
			$end = new Google_Service_Calendar_EventDateTime(); // cria o servico do calendar para o final do evento
			$end->setTimeZone('America/Sao_Paulo'); // define a TimeZone
			
			$end->setDateTime($dataDoEvento . 'T' . $horaFinalAula. '.000'); // define a data e hora de final do evento
			//$end->setDateTime('2015-04-27T22:40:00'); // formato de hora de final

			$event->setEnd($end); // insere data e hora de final no objeto event
					
			// https://developers.google.com/google-apps/calendar/recurringevents
			//$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20150515T170000Z')); // recorrencia do evento
			$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20150710T230000Z')); // recorrencia do evento
			
			// OURO DO BESOURO - NOTIFICACOES (SMS, EMAIL, POPUP) //

			$remindersArray = array(); // cria o array para acumular as notificacoes
			
			foreach($_POST['arrayLembretes'] as $campoLembrete) {
				
				$reminder = new Google_Service_Calendar_EventReminder(); // instancia a notificacao
				
				$minutos = $campoLembrete['minutos']; // armazena os minutos de antecedencia
				$lembrete = $campoLembrete['tipoLembrete']; // armazena o tipo de lembrete
			
				/* FALTA ADAPTAR ESTE FOREACH PARA COLOCAR OS LEMBRETES POR DIA DA SEMANA, POIS ESTA CONCATENANDO TUDO
				if($lembrete == "SMS")
					$reminder->setMethod('sms'); // define o metodo como sms
				if($lembrete == "email")
					$reminder->setMethod('email'); // define o metodo como email
				*/
				
				$reminder->setMethod($campoLembrete['tipoLembrete']); // define o metodo como sms
				
				$reminder->setMinutes($campoLembrete['minutos']); // define quantos minutos antes do evento (recebido por parametro)
				
				$remindersArray[] = $reminder; // insere a notificacao ao array de notificacoes			
			
			} // FINAL DO FOR DE REMINDERS
			
				$reminders = new Google_Service_Calendar_EventReminders(); // instancia o objeto de notificacoes do evento
				$reminders->setUseDefault(false); // desativa as notificacoes de modo default (popup 30 minutos)
				$reminders->setOverrides($remindersArray); // armazena o array de notificacoes
				
				$event->setReminders($reminders); // insere o array de notificacoes no evento
				// cria o evento na agenda
				$createdEvent = $cl_service->events->insert('primary', $event); // insere o evento na agenda default ('primary') do usuario
				echo "<============ EVENTO CRIADO ===============><br>";
				echo "Evento: " . $sumarioEvento . "<br>";
				echo "Local: " . $unidadeEvento . "<br>";
				echo "Evento criado em: " . ($dia . ": " . $dataDoEvento . 'T' . $horaInicioAula. '.000') . "<br>";
				echo "<==========================================><br>";				
				
				// caso fosse atualizar o evento ao inves de criar:
				//$createdEvent = $cl_service->events->update('primary', $evento->getId(), $event);

		}// ******************* FINAL DO FOR DE DISCIPLINAS ************************
			
		}//if(isset($_POST['unidade'], $_POST['turno'], $_POST['dia'], $_POST['sala'], $_POST['disciplina'], $_POST['lembrete'], $_POST['minutos']))
	

	
} // if ($client->getAccessToken())
?>

</head>
	<body>
		<div class="box">
		  <div class="request">
			<?php 
				if (isset($authUrl)) {
				  echo "<a class='login' href='" . $authUrl . "'>Conectar com minha conta Google!</a>";
				} 
			 ?>
		  </div>
		</div>

	</body>

</html>