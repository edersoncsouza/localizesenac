<html lang="en">

<head>
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

//require('HttpPost.class.php');
require_once realpath(dirname(__FILE__) . '/Google/autoload.php');

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
 $client_id = '407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com';
 $client_secret = 'WrIiWLHNXYJBwCwc1tUrL85A';
 $redirect_uri = 'http://localhost:8080/projetos/localizesenac/auth.php';
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
    <script src="dist/components/jquery/dist/jquery.min.js"></script>

<script>

	$(document).ready(function() {
	});
	
	// funcao que busca as disciplinas do aluno no dia da semana fornecido (diaP)
	function consultarAluno(matriculaP, senhaP, nomeP){
		var url = "consultarAlunoOauth2.php";
		
		alert("Entrei na funcao consultarAluno");
		alert("A matricula é: " + matriculaP);
		
		// executa o post enviando o parametro matricula
		// recebe como retorno um json com o retorno da existencia do aluno (alunoJson)
		$.post(url,{ matricula: matriculaP }, function(alunoJson) {
			
			alert("Aqui já fez o post para consultarAluno.php e retornou alunoJson, mandando o json em copia para o console");
			//console.log(alunoJson);
			
			if (alunoJson == 0){// caso o retorno de consultarAluno.php seja = 0
				// aluno nao existe no banco
				
				alert("Retornou que nao existe aluno");
				
				var celularP = ''; var ativoP = 'S'; // envia dados padrao para insercao
				
				var url2 = 'inserirAluno.php';
				
				// executa o post para inserir o aluno no banco
				$.post(url2,{ matricula: matriculaP, password: senhaP, nome: nomeP,
								celular: celularP, email: matriculaP, ativo: ativoP}, 
									function(alunoInseridoJson) {
									
										var idNome;
										
										// se deu retorno 0 (nao afetou linhas da tabela)
										if (alunoInseridoJson == 0){
											alert("Aluno não inserido!");
										}
										else
											if (isNaN(alunoInseridoJson)) // se retornou um valor nao numerico (Erro do mysql)
												alert("Erro do MySql: " + alunoInseridoJson);
											else{
												alert("Id do aluno: " + alunoInseridoJson);
												alert("Nome do aluno: " + nomeP);
											}
									
								});	
			}
			else{ // se o aluno existir
				alert("aqui ja entrou no else (aluno != 0), aluno EXISTE! portanto nao faz nada, o consultarAlunoOauth2 fara");
				
				/*
				var objJson = JSON.parse(alunoJson); // transforma a string recebida em objeto
				
							$.each(objJson, function() {// para cada registro no Json {objJson[0].id ou objJson[0].nome
							  $.each(this, function(name, value){
								  
								  if(name == 'nome')
									  alert("Nome do aluno: " + value);
								  else
									  alert("Id do aluno: " + value);
							   });
							 
							 });
				*/
			}
		});
		
	}


</script>
	
</head>
<body>
<div class="box">
  <div class="request">
<?php 
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Conectar com minha conta Google!</a>";
} else {
		
		$_SESSION['usuarioOauth2'] = $emailGoogle; // sera o usuario, ou seja o campo matricula da tabela aluno (PK)
		$_SESSION['senhaOauth2'] = $idGoogle; // sera a senha, ou seja o campo senha da tabela aluno
		$_SESSION['nomeOauth2'] = $nomeGoogle; // sera o nome, ou seja o campo nome da tabela aluno
		
		// chama o metodo para pesquisar se aluno ja existe no banco
		// caso nao exista o aluno, insere no banco	
		echo "<script>consultarAluno(\"$emailGoogle\", \"$idGoogle\", \"$nomeGoogle\");</script>"; // tentativa de receber o retorno do script
		
		/*
		echo $_SESSION['usuarioID'];
		echo $_SESSION['usuarioNome'];
		echo $_SESSION['usuarioLogin'];
		echo $_SESSION['usuarioSenha']; 
		*/
		
		// envia para a validacao
		//$url = 'dist/php/valida.php';
		
		//header( 'Location: '.$url);


		
/*
echo "<h3>Resultados do Calendar:</h3>";
	//echo "<strong>Id do evento criado:</strong> " .$createdEvent->getId(). "<br /> \n"; // exibe a Id do evento
	//echo "<strong>Sumario do evento:</strong> " .$createdEvent->getSummary(). "<br /> \n";

echo "<h3>Resultados do Plus:</h3>";
    echo "<strong>Id do usuario:</strong> " .$idGoogle ."<br /> \n";
	echo "<strong>Nome do usuario:</strong> " .$nomeGoogle ."<br /> \n";
	echo "<strong>Email do usuario:</strong> " .$emailGoogle ."<br /> \n";
*/
  
} ?>
  </div>
</div>


</body>
</html>