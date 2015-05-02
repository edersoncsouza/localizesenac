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
	
<?php

session_start();

//require('HttpPost.class.php');
require_once realpath(dirname(__FILE__) . '/Google/autoload.php');

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
	if(isset($_POST['unidade'], $_POST['turno'], $_POST['dia'], $_POST['sala'], $_POST['disciplina'])){ 

	// sanitiza as entradas
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
	
	// armazena os parametros recebidos
	$dia = $_POST['dia'];
	$sala = $_POST['sala'];
	$turno = $_POST['turno'];
	$unidade = $_POST['unidade'];
	$disciplina = $_POST['disciplina'];
	
/* CRIA E CONFIGURA O EVENTO CALENDAR */
	$event = new Google_Service_Calendar_Event();

	$event->setSummary('Aula - ' . $disciplina); // ex.: 'Aula - Tópicos Avançados em ADS'
	$event->setLocation('Faculdade Senac Porto Alegre - Unidade ' .$unidade);

	$start = new Google_Service_Calendar_EventDateTime();
	$start->setTimeZone('America/Sao_Paulo');
	
	if ($turno == 'M'){
		$horaInicioAula = '08:00:00';
	}
	else{
		$horaInicioAula = '19:00:00';
	}
	
	// identificar a data atual
	// identificar o dia da semana atual
	// fazer alguma vinculacao dia autal com dia da semana para acrescentar a data ao incluir o evento
	
	$start->setDateTime('2015-04-27' . 'T'. $horaInicioAula);

	//$start->setDateTime('2015-04-27T19:00:00'); // formato de hora de inicio

	$event->setStart($start);

	$end = new Google_Service_Calendar_EventDateTime();
	$end->setTimeZone('America/Sao_Paulo');
	$end->setDateTime('2015-04-27T22:40:00');

	$event->setEnd($end);
	// OURO DO BESOURO - NOTIFICACOES (SMS, EMAIL, POPUP) //

	// cria o array para acumular as notificacoes
	$remindersArray = array();

	$reminder = new Google_Service_Calendar_EventReminder(); // instancia a primeira notificacao
	$reminder->setMethod('sms'); // define o metodo como sms
	$reminder->setMinutes(15); // define quantos minutos antes do evento
	$remindersArray[] = $reminder; // insere a primeira notificacao ao array de notificacoes

	$reminder = new Google_Service_Calendar_EventReminder(); // instancia a segunda notificacao
	$reminder->setMethod('email'); // define o metodo como email
	$reminder->setMinutes(25); // define quantos minutos antes do evento
	$remindersArray[] = $reminder; // insere a primeira notificacao ao array de notificacoes

	$reminders = new Google_Service_Calendar_EventReminders(); // instancia o objeto de notificacoes do evento
	$reminders->setUseDefault(false); // desativa as notificacoes de modo default (popup 30 minutos)
	$reminders->setOverrides($remindersArray); // armazena o array de notificacoes
	 
	$event->setReminders($reminders); // insere o array de notificacoes no evento

	$createdEvent = $cl_service->events->insert('primary', $event); // insere o evento na agenda default ('primary') do usuario
	
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
<!-- jQuery -->
<script type="text/javascript" src="dist/components/jquery/dist/jquery.min.js"></script>

<!-- Funcoes JS -->
<script type="text/javascript" src="dist/js/funcoes.js"></script>
