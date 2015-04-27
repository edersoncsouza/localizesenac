<?php
	session_start(); // Create a session

	require_once realpath(dirname(__FILE__) . '/Google/autoload.php');	
	
    /**************************
    * Google Client Configuration
    *
    * You may want to consider a modular approach,
    * and do the following in a separate PHP file.
    ***************************/

    /* Required Google libraries */
	
	/*
    require_once 'Google/Client.php';
    require_once 'Google/Service/Analytics.php';
	require_once 'Google/Service/Calendar.php';
	require_once 'Google/Service/Plus.php';
	require_once 'Google/Service/Oauth2.php';
	*/
	
    /* API client information */
    $clientId = '407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com';
    $clientSecret = 'WrIiWLHNXYJBwCwc1tUrL85A';
    $redirectUri = 'http://localhost:8080/projetos/localizesenac/auth.php';
    $devKey = '407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l@developer.gserviceaccount.com';

    // Create a Google Client.
    $client = new Google_Client();
    $client->setApplicationName('App'); // Set your app name here

    /* Configure the Google Client with your API information */

    // Set Client ID and Secret.
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);

    // Set Redirect URL here - this should match the one you supplied.
    $client->setRedirectUri($redirectUri);

    // Set Developer Key and your Application Scopes.
    $client->setDeveloperKey($devKey);
    //$client->setScopes( array('https://www.googleapis.com/auth/analytics.readonly') );
	$client->setScopes( array('https://www.googleapis.com/auth/userinfo.profile') );
	$client->setScopes( array('https://www.googleapis.com/auth/userinfo.email') );
	$client->setScopes( array('https://www.googleapis.com/auth/plus.login') );
	$client->setScopes( array('https://www.googleapis.com/auth/calendar') );
	$client->setScopes( array('https://www.googleapis.com/auth/plus.me') );

    /**************************
    * OAuth2 Authentication Flow
    *
    * You may want to consider a modular approach,
    * and do the following in a separate PHP file.
    ***************************/

    // Create a Google Analytics Service using the configured Google Client.
    //$analytics = new Google_Service_Analytics($client);
	
	/* CRIA OS SERVICOS*/
	$oauth2_service = new Google_Service_Oauth2($client); // outra tentativa de conseguir Id, Nome e email
	$cl_service = new Google_Service_Calendar($client); // criado servico do Calendar e executada a query
	$pl_service = new Google_Service_Plus($client); // criado servico do Plus e executada a query

    // Check if there is a logout request in the URL.
    if (isset($_REQUEST['logout'])) {
        // Clear the access token from the session storage.
        unset($_SESSION['access_token']);
    }

    // Check if there is an authentication code in the URL.
    // The authentication code is appended to the URL after
    // the user is successfully redirected from authentication.
    if (isset($_GET['code'])) {
        // Exchange the authentication code with the Google Client.
        $client->authenticate($_GET['code']); 

        // Retrieve the access token from the Google Client.
        // In this example, we are storing the access token in
        // the session storage - you may want to use a database instead.
        $_SESSION['access_token'] = $client->getAccessToken(); 

        // Once the access token is retrieved, you no longer need the
        // authorization code in the URL. Redirect the user to a clean URL.
        //header('Location: '.filter_var($redirectUri, FILTER_SANITIZE_URL)); // original de http://stackoverflow.com/questions/23498104/why-do-i-keep-catching-a-google-auth-exception-for-invalid-grant
		
		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }

    // If an access token exists in the session storage, you may use it
    // to authenticate the Google Client for authorized usage.
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $client->setAccessToken($_SESSION['access_token']);
    }

    // If the Google Client does not have an authenticated access token,
    // have the user go through the OAuth2 authentication flow.
    if (!$client->getAccessToken()) {
        // Get the OAuth2 authentication URL.
        $authUrl = $client->createAuthUrl();
	}
	else{
		  $_SESSION['access_token'] = $client->getAccessToken();
        /* Have the user access the URL and authenticate here */

        // Display the authentication URL here.
		
	/*********************************
	* OAuth2 Authentication Complete *
	*********************************/
	


	/************************************************
	  Aqui vou tentar recuperar informacoes da agenda
	  e nome e id unico do usuario do plus.
	************************************************/
  
	/* GOOGLE PLUS */
	$pl_results = $pl_service->people->get('me'); // recebe o perfil completo do Plus
	$oauth2_results = $oauth2_service->userinfo->get(); // recebe o perfil completo do oauth2
	
	//$tudo = var_dump($pl_results);
	$tudo = "quaquaqua";
	
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
	
	echo $tudo;
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head></head>
	<body>
		<div class="box">
			<div class="request">
			<?php 
			if (isset($authUrl)) {
			  echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
			} else {
			  
			echo "<h3>Resultados do Calendar:</h3>";
				//echo "<strong>Id do evento criado:</strong> " .$createdEvent->getId(). "<br /> \n"; // exibe a Id do evento
				//echo "<strong>Sumario do evento:</strong> " .$createdEvent->getSummary(). "<br /> \n";

			echo "<h3>Resultados do Plus:</h3>";
				//echo "<strong>Id do usuario:</strong> " .$idPlus ."<br /> \n";
				//echo "<strong>Nome do usuario:</strong> " .$nome ."<br /> \n";
				//echo "<strong>Email do usuario:</strong> " .$email ."<br /> \n";
				echo $tudo;
			} ?>
			</div>
		</div>
	</body>
	</html>