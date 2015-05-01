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
//$client->addScope("https://www.googleapis.com/auth/drive");
//$client->addScope("https://www.googleapis.com/auth/youtube");

$client->addScope("https://www.googleapis.com/auth/plus.me"); // adicionados escopos do Google Plus
$client->addScope("https://www.googleapis.com/auth/plus.login");
$client->addScope("https://www.googleapis.com/auth/calendar"); // adicionado escopo do Calendar (Agenda do Google)
$client->addScope("https://www.googleapis.com/auth/userinfo.profile"); // adicionados escopos de informacoes de perfil do usuario Google
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

/************************************************

/* CRIA OS SERVICOS*/
$cl_service = new Google_Service_Calendar($client); // criado servico do Calendar e executada a query
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

/****************************************************
  se estiver logado fara os processos de recuperacao
  de informacoes dos serviços do Google
 ***************************************************/
if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  
/************************************************
  Aqui vou tentar recuperar informacoes da agenda
  e nome, email e id unico do usuario do plus.
 ************************************************/
  
  /* GOOGLE PLUS */
  $pl_results = $pl_service->people->get('me'); // recebe o perfil completo do Plus
  
  $oauth2_results = $oauth2_service->userinfo->get();
  
	$idGoogle = ($oauth2_results['id']);
	$nomeGoogle = ($oauth2_results['name']);
	$emailGoogle = filter_var($oauth2_results['email'], FILTER_SANITIZE_EMAIL);	

	
/* AGENDA */
/*
	$event = new Google_Service_Calendar_Event();

	$event->setSummary('Aula - Tópicos Avançados em ADS');
	$event->setLocation('Faculdade Senac Porto Alegre - Unidade 1');

	$start = new Google_Service_Calendar_EventDateTime();
	$start->setTimeZone('America/Sao_Paulo');
	$start->setDateTime('2015-04-27T19:00:00');

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
*/
}

?>

<!-- jQuery -->
<script type="text/javascript" src="dist/components/jquery/dist/jquery.min.js"></script>

<!-- Funcoes JS -->
<script type="text/javascript" src="dist/js/funcoes.js"></script>

<script>
	/*
	// funcao que busca o aluno no BD e se nao existir cria
	function consultarAluno(matriculaP, senhaP, nomeP){
		var url = "consultarAlunoOauth2.php";
		
		// executa o post enviando o parametro matricula
		// recebe como retorno um json com o retorno da existencia do aluno (alunoJson)
		$.post(url,{ matricula: matriculaP }, function(alunoJson) {
			
			console.log(alunoJson); // envia para o console o Json do usuario
			
			if (alunoJson == 0){// caso o retorno de consultarAluno.php seja = 0
				// aluno nao existe no banco
				
				var celularP = ""; // variavel para o celular, criada para possivelmente pedir ao usuario esta entrada
				var ativoP = "S"; // variavel ativo recebe o valor padrao, sera utilizada pelo administrador para desativar usuarios
				
				var url2 = "inserirAlunoOauth2.php";
				
				// executa o post para inserir o aluno no banco
				$.post(url2,{ matricula: matriculaP, password: senhaP, nome: nomeP,
								celular: celularP, email: matriculaP, ativo: ativoP}, 
									function(alunoInseridoJson) {
									
										var idNome;
										
										// se deu retorno 0 (nao afetou linhas da tabela)
										if (alunoInseridoJson == 0){
											alert("Aluno não inserido!");
										}
										else{
											if (isNaN(alunoInseridoJson)) // se retornou um valor nao numerico (Erro do mysql)
												alert("Erro do MySql: " + alunoInseridoJson);
											else{ // se retornou valor numerico != 0, este e o Id de insercao
												window.location.replace("principal.php"); // caso o aluno tenha sido inserido redirecioina para a pagina principal
											}
										}
								});
				
			}
			else{ // se o aluno existir
				window.location.replace("principal.php"); // caso o aluno exista redirecioina para a pagina principal
			}

		});
		
	}
*/
	
</script>
	
</head>
<body>
<div class="box">
  <div class="request">
<?php 
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Conectar com minha conta Google!</a>";
} 
else {
		$_SESSION['usuarioOauth2'] = $emailGoogle; // sera o usuario, ou seja o campo matricula da tabela aluno (PK)
		$_SESSION['senhaOauth2'] = $idGoogle; // sera a senha, ou seja o campo senha da tabela aluno
		$_SESSION['nomeOauth2'] = $nomeGoogle; // sera o nome, ou seja o campo nome da tabela aluno
		
		// chama a funcao JavaScript que executa os POSTS para os arquivos PHP de manipulacao de banco
		// consultarAlunoOauth2 - Pesquisar se aluno ja existe no banco
		// inserirAlunoOauth2 - Caso nao exista o aluno, insere no banco	
		echo "<script type=\"text/javascript\">consultarAluno(\"$emailGoogle\", \"$idGoogle\", \"$nomeGoogle\");</script>"; // tentativa de receber o retorno do script
		
		/*
			//echo "<h3>Resultados do Calendar:</h3>";
			//echo "<strong>Id do evento criado:</strong> " .$createdEvent->getId(). "<br /> \n"; // exibe a Id do evento
			//echo "<strong>Sumario do evento:</strong> " .$createdEvent->getSummary(). "<br /> \n";
		*/
  
} ?>
  </div>
</div>


</body>
</html>