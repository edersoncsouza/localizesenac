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

			date_default_timezone_set('America/Sao_Paulo'); // define o timezone
			
			// DEFINE OS HORARIOS POSSIVEIS DE INICIO E FINAL DE AULAS COM MARGEM
			$horaInicioDiaLetivo = '07:00:00';
			$horaFinalDiaLetivo = '23:00:00';
			
			// DEFINE A DATA E O DIA DA SEMANA ATUAL
			$diaAtual = date('Y-m-d'); // instancia e define a mascara da data
			$diaSemanaAtual = getDiaSemana($diaAtual); // busca e armazena o dia da semana atual
			$data = [];
			
			// PERCORRE TODOS OS DIAS DA SEMANA DA VARIAVEL DE SESSAO DE DIAS COM DISCIPLINAS
			foreach ($_SESSION['arrayDiasComDisciplinas'] as $dia){ // executa o laco a cada dia da semana em que existem disciplinas
				
				// DEFINE A DATA DO EVENTO COMPARANDO COM O DIA DA SEMANA E DATA CORRENTE
				for ($i = 0; $i < 7; $i++) { // laco de 0 a 6 para percorrer todos os dias da semana e definir a data do evento
					
					$diaAtual = date('Y-m-d', strtotime("+".$i." days")); // incrementa o dia atual com a variavel $i
					$diaSemanaAtual = getDiaSemana($diaAtual); // atualizar a variavel diaSemanaAtual
					
					if($diaSemanaAtual == $dia){ // verifica se o dia da semana atual e igual ao dia recebido como parametro
						$dataDoEvento = $diaAtual; // varivel de data do evento recebe a data do proximo dia da semana correspondente
						$i = 7; // forca a saida do FOR
					}
				}
				
				// DEFINE PERIODO PARA PESQUISA DE EVENTOS
				$inicio = ($dataDoEvento. 'T' . $horaInicioDiaLetivo . '.000z'); // cria a string com o dia atual e primeiro horario letivo
				$final = ($dataDoEvento. 'T' . $horaFinalDiaLetivo . '.000z'); // cria a string com o dia atual e ultimo horario letivo
				
				// CONFIGURA OS PARAMETROS DA PESQUISA NA AGENDA
				$params = array(
					'singleEvents' => 'true',
					'timeMax' => $final,
					'timeMin' => $inicio,
					'orderBy' => 'startTime');
				
				// FILTRA OS LEMBRETES DE UM DOS EVENTOS DA LISTA DE EVENTOS EM DUAS ETAPAS
				$listaEventos = $cl_service->events->listEvents('primary', $params); // armazena a lista de eventos
				$eventos = $listaEventos->getItems(); // recebe os itens da lista de eventos
				
				// CASO JA EXISTAM EVENTOS
				if (count($eventos)){ // se ja existem eventos
					
					$lembretes = $eventos[0]->getReminders()->getOverrides(); // armazena em um array os lembretes do primeiro evento

					// EXECUTA O LACO PARA ARMAZENAR TODOS OS LEMBRETES E MINUTOS DE UM DOS EVENTOS DO DIA
					foreach($lembretes as $lembrete){ // para cada lembrete
						$metodos[] = $lembrete->getMethod(); // armazena em um array o metodo
						$minutos[] = $lembrete->getMinutes(); // armazena em um array os minutos
					}

					// ARMAZENA OS DADOS DE DIA E LEMBRETES NO ARRAY DE RETORNO
					$retornoLembretesDiaDaSemana['diaDaSemana'] = $dia; // armazena o dia da semana no array de retorno
					$retornoLembretesDiaDaSemana['lembretes'] = $metodos; // armazena o array de metodos de lembretes no array de retorno
					$retornoLembretesDiaDaSemana['minutos'] = $minutos; // armazena o array de minutos de lembretes no array de retorno
					
					/*
					// IMPRIME A DATA OS METODOS E MINUTOS DE ANTECEDENCIA DOS LEMBRETES
					echo "<br>=========== Data e Lembretes ============<br>";
					echo $dia . " - " . $dataDoEvento . "<br>"; // imprime a data do evento
					for ($i = 0; $i <  count($metodos); $i++){ // executa o laco para percorrer os arrays de metodo e minutos
						echo "<br> Metodo: " . $metodos[$i] . "<br>"; // imprime o metodo
						echo "<br> Minutos: " . $minutos[$i] . "<br>"; // imprime os minutos
					}
					*/
					
					// RESETA OS ARRAYS DE LEMBRETES PARA EVITAR INCREMENTO PARA OUTROS DIAS
					$metodos = array(); // zera o array de metodos
					$minutos = array(); // zera o array de minutos
					

					$data[] = $retornoLembretesDiaDaSemana; // armazena o array do dia no array de retorno final
					$retornoLembretesDiaDaSemana = array(); // sera o array do dia
				}
			}
			// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
			if(count($data)>0)
				echo json_encode($data);
			else
				echo 0;
			
} // if ($client->getAccessToken())
?>
