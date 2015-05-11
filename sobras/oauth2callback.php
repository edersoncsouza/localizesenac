<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

session_start();

require_once realpath(dirname(__FILE__) . '/oauth2/src/Google/autoload.php');

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
 $client_id = '407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com';
 $client_secret = 'WrIiWLHNXYJBwCwc1tUrL85A';
 $redirect_uri = 'http://localhost:8080/projetos/aut/examples/multi-api.php';
/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
//$client->addScope("https://www.googleapis.com/auth/drive");
//$client->addScope("https://www.googleapis.com/auth/youtube");
$client->addScope("https://www.googleapis.com/auth/calendar"); // adicionado escopo do Calendar (Agenda do Google)
$client->addScope("https://www.googleapis.com/auth/userinfo.profile"); // adicionado escopo de informacoes de perfil do usuario Google
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/plus.login");
$client->addScope("https://www.googleapis.com/auth/plus.me");
/************************************************
  We are going to create both YouTube and Drive
  services, and query both.
 ************************************************/
//$yt_service = new Google_Service_YouTube($client);
//$dr_service = new Google_Service_Drive($client);

/* CRIA OS SERVICOS*/
$cl_service = new Google_Service_Calendar($client); // criado servico do Calendar e executada a query
//$cl_service = new Google_Service_Calendar_Event($client); // criado servico do Calendar e executada a query
$pl_service = new Google_Service_Plus($client); // criado servico do Plus e executada a query
$oauth2_service = new Google_Service_Oauth2($client); // outra tentativa de conseguir Id, Nome e email
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

/************************************************
  If we're signed in, retrieve channels from YouTube
  and a list of files from Drive.
 ************************************************/
if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  
/************************************************
  Aqui vou tentar recuperar informacoes da agenda
  e nome e id unico do usuario do plus.
 ************************************************/
  
  /* GOOGLE PLUS */
  $pl_results = $pl_service->people->get('me'); // recebe o perfil completo do Plus
  
  //$oauth2_results = $oauth2_service->people->get('me');
  $oauth2_results = $oauth2_service->userinfo->get();
  
	$idPlus = ($oauth2_results['id']);
	$nome = ($oauth2_results['name']);
	$email = filter_var($oauth2_results['email'], FILTER_SANITIZE_EMAIL);	
  
/* AGENDA */
  
	$event = new Google_Service_Calendar_Event();

	$event->setSummary('Aula - Tópicos Avançados em ADS');
	$event->setLocation('Faculdade Senac Porto Alegre - Unidade 1');

	$start = new Google_Service_Calendar_EventDateTime();
	$start->setTimeZone('America/Sao_Paulo');
	$start->setDateTime('2015-04-27T19:00:00');

	$event->setStart($start);

	$end = new Google_Service_Calendar_EventDateTime();
	$end->setTimeZone('America/Sao_Paulo');
	$end->setDateTime('2015-04-27T22:24:00');

	$event->setEnd($end);

	/* OURO DO BESOURO - NOTIFICACOES (SMS, EMAIL, POPUP) */

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
  
}

?>
<div class="box">
  <div class="request">
<?php 
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
} else {
  
echo "<h3>Resultados do Calendar:</h3>";
	echo "<strong>Id do evento criado:</strong> " .$createdEvent->getId(). "<br /> \n"; // exibe a Id do evento
	echo "<strong>Sumario do evento:</strong> " .$createdEvent->getSummary(). "<br /> \n";

echo "<h3>Resultados do Plus:</h3>";
    echo "<strong>Id do usuario:</strong> " .$idPlus ."<br /> \n";
	echo "<strong>Nome do usuario:</strong> " .$nome ."<br /> \n";
	echo "<strong>Email do usuario:</strong> " .$email ."<br /> \n";

  
} ?>
  </div>
</div>