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

	// campos enviados de configAluno.php unidadeP, turnoP, diaP, salaP, disciplinaP
	// verifica se recebeu os parametros por POST
		if(isset($_POST['unidade'], $_POST['turno'], $_POST['dia'], $_POST['sala'], $_POST['disciplina'], $_POST['lembrete'], $_POST['minutos'])){

			// sanitiza as entradas
			foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
			
			// armazena os parametros recebidos
			$dia = $_POST['dia'];
			$sala = $_POST['sala'];
			$turno = $_POST['turno'];
			$unidade = $_POST['unidade'];
			$minutos = $_POST['minutos'];
			$lembrete = $_POST['lembrete'];
			$disciplina = $_POST['disciplina'];

			// monta as strings para o evento
			$sumarioEvento = 'LocalizeSenac - Aula -  ' . $disciplina;
			$unidadeEvento = 'Faculdade Senac Porto Alegre - Unidade ' .$unidade;
			
			$horaInicioDiaLetivo = '08:00:00';
			$horaFinalDiaLetivo = '22:40:00';
			
			if ($turno == 'M'){ // se for o turno da manha
				$horaInicioAula = '08:00:00';
				$horaFinalAula = '11:40:00';
			}
			if ($turno == 'N'){
				$horaInicioAula = '19:00:00';
				$horaFinalAula = '22:40:00';
			}
			
			date_default_timezone_set('America/Sao_Paulo'); // define o timezone
			
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
			
			// teste de montagem dos campos do evento
			//echo "/========================== APOS O FOR ==========================\\<BR>" ;
			//echo "O evento sera incluido na proxima " . $dia . " dia " . $dataDoEvento . " as " . $horaInicioAula;
		
		// VERIFICA A EXISTENCIA DE EVENTOS PREVIOS NAS MESMAS DATAS E HORARIOS EM QUE O EVENTO ESTA SENDO INSERIDO

		// ************************* SERVICO JA FOI CRIADO NA LINHA 66 ***************************
		//$cl_service = new Google_Service_Calendar($client); // criado servico do Calendar e executada a query
				
		//$agendaAluno = new Google_Service_Calendar($client); // se fosse instanciar um novo servico para pesquisar a agenda
		
		
		date_default_timezone_set('America/Sao_Paulo'); // define a TimeZone
		
		//$inicio = ($dataDoEvento. 'T' . $horaInicioDiaLetivo . '.000Z'); // cria a string com o dia atual e primeiro horario letivo
		$inicio = ($dataDoEvento. 'T' . $horaInicioAula . '.000Z'); // cria a string com o dia atual e primeiro horario do turno
		// exemplo de formato de data e hora aceitos: 2015-03-07T17:06:02.000Z
		
		//$final = ($dataDoEvento. 'T' . $horaFinalDiaLetivo . '.000Z'); // cria a string com o dia atual e ultimo horario letivo
		$final = ($dataDoEvento. 'T' . $horaFinalAula . '.000Z'); // cria a string com o dia atual e ultimo horario do turno
		
		echo "Data e hora para verificacao: " . $inicio . "<br>"; // testa a string de data e hora de inicio da pesquisa
		
		//configura os parametros da pesquisa na agenda
		$params = array(
			'singleEvents' => 'true',
			'timeMax' => $final,
			'timeMin' => $inicio,
			'orderBy' => 'startTime');
	
		$listaEventos = $cl_service->events->listEvents('primary', $params); // armazena a lista de eventos
		
		$eventos = $listaEventos->getItems(); // recebe os itens da lista de eventos
		
		$existeEvento = FALSE; // cria variavel booleana para identificar se ja existe o evento
		
		foreach ($eventos as $evento) { // para cada item de eventos como evento (dentro do periodo de tempo do dia)
			// monta uma tabela com os eventos encontrados no dia
			echo '<tr>';
			echo '<td>'.$evento->getId().'</td>';
			echo '<td>'.$evento->getSummary().'</td>';
			echo '<td>'.$evento->getStart()->getDateTime().'</td>';
			echo '<td>'.$evento->getEnd()->getDateTime().'</td>';
			echo '</tr>';
			
			// armazena o sumario do evento existente
			$sumarioEventoExistente = $evento->getSummary();
			
			$sumarioEventoExistente = substr($sumarioEventoExistente, 0, 13); // filtra os primeiros 13 caracteres do inicio do sumario
			
			echo "<br> Sumario do evento existente: " . $sumarioEventoExistente . "<br>";

			// verifica se o evento foi criado pelo sistema LocalizeSenac
			if($sumarioEventoExistente == 'LocalizeSenac'){
				// armazena informacoes do evento existente
				$idEventoExistente = $evento->getId();
				$dataHoraInicioEventoExistente = $evento->getStart()->getDateTime();
				$dataHoraFinalEventoExistente = $evento->getEnd()->getDateTime();
				
				// tentando buscar reminders lembretes notificacoes existentes e montar com os novos ou dar append
				//http://stackoverflow.com/questions/17546940/php-google-calendar-api-add-reminder-to-recurring-events
				//$lembretesExistentes = evento->getDefaultReminders[];
				
				$existeEvento = TRUE;
				
				/*
				// bacalhau pra apagar todos os eventos do dia
				// ao inves de atualizar, pois o usuario pode ter
				// excluido a disciplina e na atualizacao dos lembretes
				// manteria os excluidos 
				// basicamente: Aumentado o range de horario para o dia todo (lin 164 e 168) 
				// e se existir deletar o evento com o if abaixo:
				// PROBLEMA: deste jeito apenas aceita um evento por dia e com um tipo de lembrete
				
				if ($existeEvento == TRUE){
					
					// deleta o evento encontrado
					$cl_service->events->delete('primary', $idEventoExistente);
					
					// retorna o status pra false pra criar eventos novos
					$existeEvento = FALSE;
				}
				*/
			}
		}

		// se for um evento existente (mantido para quando o bacalhau for removido)
		if ($existeEvento == TRUE)
			// busca o evento do usuario atraves do id do evento
			$event = $cl_service->events->get('primary', $idEventoExistente);
		// se for um novo evento
		else
			// cria o evento calendar
			$event = new Google_Service_Calendar_Event(); // cria o novo evento

		$event->setSummary($sumarioEvento); // define o sumario do evento ex.: 'Aula - Tópicos Avançados em ADS'
		$event->setLocation($unidadeEvento); // define o local do evento

		// INICIO DO EVENTO
		$start = new Google_Service_Calendar_EventDateTime(); // cria o servico do calendar para o inicio do evento
		$start->setTimeZone('America/Sao_Paulo'); // define a TimeZone	
		$start->setDateTime($dataDoEvento . 'T'. $horaInicioAula. '.000Z'); // define a data e hora de inicio do evento
		//$start->setDateTime('2015-04-27T19:00:00'); // formato de hora de inicio

		$event->setStart($start); // insere data e hora de inicio no objeto event

		// FINAL DO EVENTO
		$end = new Google_Service_Calendar_EventDateTime(); // cria o servico do calendar para o final do evento
		$end->setTimeZone('America/Sao_Paulo'); // define a TimeZone
		$end->setDateTime($dataDoEvento . 'T'. $horaFinalAula. '.000Z'); // define a data e hora de final do evento
		//$end->setDateTime('2015-04-27T22:40:00'); // formato de hora de final

		$event->setEnd($end); // insere data e hora de final no objeto event
		
		// https://developers.google.com/google-apps/calendar/recurringevents
		//$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20150515T170000Z')); // recorrencia do evento
		
		// OURO DO BESOURO - NOTIFICACOES (SMS, EMAIL, POPUP) //

		// cria o array para acumular as notificacoes
		$remindersArray = array();
		
		$reminder = new Google_Service_Calendar_EventReminder(); // instancia a notificacao
		
		if($lembrete == "SMS")
			$reminder->setMethod('sms'); // define o metodo como sms
		if($lembrete == "email")
			$reminder->setMethod('email'); // define o metodo como email

		$reminder->setMinutes($minutos); // define quantos minutos antes do evento (recebido por parametro)
		
		$remindersArray[] = $reminder; // insere a notificacao ao array de notificacoes			

		$reminders = new Google_Service_Calendar_EventReminders(); // instancia o objeto de notificacoes do evento
		$reminders->setUseDefault(false); // desativa as notificacoes de modo default (popup 30 minutos)
		
		$reminders->setOverrides($remindersArray); // armazena o array de notificacoes
		
		
		$event->setReminders($reminders); // insere o array de notificacoes no evento
			
		if ($existeEvento == TRUE)	
			// atualiza o evento na agenda
			$eventoAtualizado = $cl_service->events->update('primary', $evento->getId(), $event);
		else
			// cria o evento na agenda
			$createdEvent = $cl_service->events->insert('primary', $event); // insere o evento na agenda default ('primary') do usuario
	
	}//if(isset($_POST['unidade'], $_POST['turno'], $_POST['dia'], $_POST['sala'], $_POST['disciplina'], $_POST['lembrete'], $_POST['minutos']))
	
	else{
		if(isset($_POST['arrayDisciplinas']))
			//echo "<script>console.log({$_POST['arrayDisciplinas']});</script>";
			
			foreach($_POST['arrayLembretes'] as $result) {
				echo "Tipo de lembrete: " . $result['tipoLembrete'] . '<br>';
				echo "Tempo de antecedencia: " . $result['minutos'] . '<br>';
			}
			
			foreach($_POST['arrayDisciplinas'] as $result) {
				echo "Disciplina: " . $result['disciplina'] . '<br>';
			}
			
	}
	
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