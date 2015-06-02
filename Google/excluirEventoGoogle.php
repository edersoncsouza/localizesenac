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
<script type="text/javascript" src="../dist/components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

<!-- Bootbox -->
<script src="../dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>

<!-- Funcoes JS -->
<script type="text/javascript" src="../dist/js/funcoes.js"></script>
		
<?php

	session_start();

	//require('HttpPost.class.php');
	require_once realpath(dirname(__FILE__) . '/autoload.php');
	include('../dist/php/funcoes.php');
	include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	
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

		// INICIO DO PROCESSO DE EXCLUSAO DE TODOS OS EVENTOS DA SEMANA QUE FOREM DO TIPO GOOGLE
		// DESSA FORMA SE GARANTE A EXCLUSAO DOS LEMBRETES QUE TIVERAM O CHECKBOX DESMARCADO
		
		$eventosExcluidosDia = []; //cria um array com eventos a excluir
		
		date_default_timezone_set('America/Sao_Paulo'); // define o timezone

		// DEFINE O PERIODO DE REMOCAO (SEMANA TODA)
		$diaAtualRemocao = (date('Y-m-d'). 'T00:00:00.000z'); // define o inicio do dia atual
		$diaFinalRemocao = (date('Y-m-d', strtotime("+7 days")).'T23:59:59.000z'); // define o final do ultimo dia da semana
	
		//configura os parametros da pesquisa na agenda
		$params = array(
			'singleEvents' => 'true',
			'timeMax' => $diaFinalRemocao,
			'timeMin' => $diaAtualRemocao,
			'orderBy' => 'startTime'
			);
		
		$listaEventos = $cl_service->events->listEvents('primary', $params); // armazena a lista de eventos
		
		$eventos = $listaEventos->getItems(); // recebe os itens da lista de eventos
		
		if(count($eventos)>0){ // se existem eventos na semana

			foreach ($eventos as $evento) { // para cada item de eventos como evento (dentro do periodo de tempo do dia)
				
				// armazena o sumario do evento existente
				$sumarioEventoExistente = $evento->getSummary();
				echo "Sumario do evento: " . $sumarioEventoExistente . "<br><br>";
				
				$introducaoSumario = substr($sumarioEventoExistente, 0, 13); // filtra os primeiros 13 caracteres do inicio do sumario
							
				// verifica se o evento foi criado pelo sistema LocalizeSenac
				if($introducaoSumario  == 'LocalizeSenac'){
					
					$deleteParams = $deleteParams = array('timeMin' =>  $diaAtualRemocao);
					
					// armazena informacoes do evento existente
					$idEventoExistente = $evento->getId();
					echo "Id do evento existente: " . $idEventoExistente."<br><br>";

					// deleta o evento encontrado
					//$cl_service->events->delete('primary', $idEventoExistente); // exlui um evento unico, sem recorrencia
					
					/* EXCLUI OS EVENTOS RECORRENTES http://stackoverflow.com/questions/20561258/how-recurring-events-in-google-calendar-work */
					$eventosRecorrentes = $cl_service->events->instances('primary', $idEventoExistente, $deleteParams); // armazena todas as instancias do evento recorrente
					
					echo "contagem de itens: " . count($eventosRecorrentes->getItems()) . "<br><br>";
					
					if ($eventosRecorrentes && count($eventosRecorrentes->getItems())) { // se houverem eventosRecorrentes
					  foreach ($eventosRecorrentes->getItems() as $instance) { // laco para percorrer todos os eventos recorrentes
						$cl_service->events->delete('primary', $instance->getId()); // deleta cada instancia do evento
					  }
					}

				}
			} // foreach ($eventos as $evento) 
			
		} // se existem eventos

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