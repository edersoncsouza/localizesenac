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
	include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	
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

	echo "<script>alert(\"Tenho Token do Google\"); console.log(\"Tenho Token do Google\");</script>";
	
	$disciplinas = $_POST['arrayDisciplinas'];
	print_r($disciplinas);
	
	// verifica se recebeu os parametros por POST
	if(isset($_POST['arrayDisciplinas'], $_POST['arrayLembretes'])){
			
			echo "<script>alert(\"Recebi o arrayDisciplinas e arrayLembretes\"); console.log(\"Recebi o arrayDisciplinas e arrayLembretes\");</script>";
			
			// sanitiza as entradas
			//foreach($_POST AS $key => $value) {	$_POST[$key] = mysql_real_escape_string($value); }
			$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$jaLimpei = FALSE; // cria variavel booleana para efetuar limpeza dos eventos uma unica vez
			$eventosExcluidosDia = []; //cria um array com eventos a excluir
			
			$disciplinas = $_POST['arrayDisciplinas']; // armazena o array que pode estar duplicado pois existem dois tipos de lembretes do Google
			$disciplinas = array_unique($disciplinas, SORT_REGULAR); // remove os objetos duplicados do array fonte: http://stackoverflow.com/questions/2426557/array-unique-for-objects
			
			$lembretes = $_POST['arrayLembretes']; // armazena o array dos lembretes
			
			
			
		foreach($disciplinas as $campoDisciplina) {
				//disciplinasDiaDaSemana.push({ "unidade": unidadeP, "turno": turnoP, "dia": diaP, "sala": salaP, "disciplina": disciplinaP});
				//echo "Disciplina: " . $result['disciplina'] . '<br>';
				$dia = $campoDisciplina['dia'];
				$sala = $campoDisciplina['sala'];
				$turno = $campoDisciplina['turno'];
				$unidade = $campoDisciplina['unidade'];
				$disciplina = $campoDisciplina['disciplina'];

			echo "AGORA A DISCIPLINA E: " . $disciplina . "<br>";	
				
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

			echo "A quantidade de eventos de " . $inicio . " ate " . $final . " e: " . count($eventos) . "<br>";
			
			
			if(count($eventos)>0){ // se existem eventos no dia da disciplina
			
				echo "Entrei para apagar " . count($eventos) . " eventos <br>";
				
				if(!in_array($dia, $eventosExcluidosDia)){ // se o dia ainda nao estiver no array
					echo "O dia " . $dia . " não estava cadastrado como dia de evento excluido, por isso vou excluir<br>";
					
					array_push($eventosExcluidosDia,$dia); // envia o dia pro array
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
								
								// EXCLUSAO DE EVENTOS RECORRENTES http://stackoverflow.com/questions/20561258/how-recurring-events-in-google-calendar-work 
								$eventosRecorrentes = $cl_service->events->instances('primary', $idEventoExistente, $deleteParams); // armazena todas as instancias do evento recorrente
								
								if ($eventosRecorrentes && count($eventosRecorrentes->getItems())) { // se houverem eventosRecorrentes
								  foreach ($eventosRecorrentes->getItems() as $instance) { // laco para percorrer todos os eventos recorrentes
									echo "Instancia do evento encontrada, deletei o evento ID: " . $instance->getId() . "<br>";
									$cl_service->events->delete('primary', $instance->getId()); // deleta cada instancia do evento
								  }
								}
								else{ // se o evento LocalizeSenac existe mas nao tem recorrencia
									$cl_service->events->delete('primary', $idEventoExistente); // exlui um evento unico, sem recorrencia
									echo "Deletei o evento sem recorrencia id: " . $idEventoExistente . "<br>";
								}

							} // se o sumario e LocalizeSenac
							
						} // foreach ($eventos as $evento) 
				
				} //if(!in_array(dia, eventosExcluidosDia))
				
			} // se existem eventos no dia da disciplina
			
			
			
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
					
			$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20150710T230000Z')); // define a recorrencia do evento semanal ate o final do semestre
			
			// OURO DO BESOURO - NOTIFICACOES (SMS, EMAIL, POPUP) //

			$remindersArray = array(); // cria o array para acumular as notificacoes
			$arrayLembretesTipo = array(); // criado para armazenar os lembretes para a tabela aluno_lembrete
			
			//$lembretes = $_POST['arrayLembretes']; colocado no inicio do arquivo
			
			foreach($lembretes as $campoLembrete) {
				
				$reminder = new Google_Service_Calendar_EventReminder(); // instancia a notificacao
				
				$minutos = $campoLembrete['minutos']; // armazena os minutos de antecedencia
				$lembrete = $campoLembrete['tipoLembrete']; // armazena o tipo de lembrete
			
				if ($campoLembrete['dia'] == $dia){
					$reminder->setMethod($campoLembrete['tipoLembrete']); // define o metodo como sms
					
					$reminder->setMinutes($campoLembrete['minutos']); // define quantos minutos antes do evento (recebido por parametro)
					
					$remindersArray[] = $reminder; // insere a notificacao ao array de notificacoes
					
					// ADICIONADO PARA UTILIZAR NA GRAVACAO NA TABELA ALUNO_LEMBRETE
					$lembreteTipo['tipo'] = $campoLembrete['tipoLembrete'];
					$lembreteTipo['minutos'] = $campoLembrete['minutos'];
					array_push($arrayLembretesTipo, $lembreteTipo);
				}				
			
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
				
				// PROCEDIMENTO DE INCLUIR OS LEMBRETES NO BANCO DE DADOS
				// conectar no banco
				mysql_set_charset('UTF8', $_SG['link']);
				
				$dia = strtoupper(substr($dia, 0, 3));
				
				// monta a query de pesquisa de lembretes do google (sms ou email)
				$sql = "SELECT
							aluno_lembrete.id, fk_id_aluno, dia_semana, turno, fk_id_lembrete_tipo
						FROM
							aluno_lembrete, aluno
						WHERE
							matricula = \"{$_SESSION['usuarioLogin']}\"
						AND 
							dia_semana = \"{$dia}\"
						AND
							turno = \"{$turno}\"
						AND
							(fk_id_lembrete_tipo = 5 OR fk_id_lembrete_tipo = 6)"; // email = 5, sms = 6
							
				// executa a query para verificar se o aluno ja possui lembretes
				$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
				
				$disciplina = trim($disciplina);
				// monta a query de pesquisa de id de disciplina
				$sql2 = "SELECT id FROM disciplina WHERE nome = \"$disciplina\"";
				// executa a query para armazenar o id da disciplina
				$result2 = mysql_query($sql2) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
			
				$idDisciplina =  mysql_result($result2,0); // recebe o id da disciplina
				
				$andarSala = substr($sala, 0, 1); // recebe o primeiro caractere do numero da sala como andar

				// monta a query de pesquisa de id de usuario
				$sql3 = "SELECT id FROM aluno WHERE matricula = \"{$_SESSION['usuarioLogin']}\"";
				// executa a query para armazenar o id do aluno
				$result3 = mysql_query($sql3) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
				
				$idAluno = mysql_result($result3,0);
				
				// ARMAZENA A ID DE LEMBRETES PARA DISCIPLINAS INEXISTENTES PARA O ALUNO
				$sql6 = "SELECT
							id
						FROM
							aluno_lembrete
						WHERE
							`fk_id_aluno` = \"{$idAluno}\"
						AND
							(fk_id_lembrete_tipo = 5 OR fk_id_lembrete_tipo = 6)
						AND
							(fk_id_aluno, fk_id_disciplina, dia_semana, turno)

						NOT IN (
							SELECT
								fk_id_aluno, fk_id_disciplina, dia_semana, turno
							FROM 
								aluno_disciplina
							WHERE
								`fk_id_aluno` =  \"{$idAluno}\"
						)";
				$result6 = mysql_query($sql6) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
				
				// EXCLUI LEMBRETES PARA DISCIPLINAS INEXISTENTES PARA O ALUNO 
				if(mysql_num_rows($result6) != 0){ // se encontrou lembretes sem disciplina associada ao aluno
					while($row = mysql_fetch_array($result6)) { // para cada linha do resultset
							echo "Exclui o lembrete ID: " . $row['id'] . "\n";
							$sql7 = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
							$result7 = mysql_query($sql7) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
					}
				}
				
				// EXCLUI OS LEMBRETES DO GOOGLE DA TABELA aluno_lembrete
				if(mysql_num_rows($result) != 0){ // se encontrou lembretes do google para o aluno
					while($row = mysql_fetch_array($result)) { // para cada linha do resultset
							$sql4 = "DELETE FROM aluno_lembrete WHERE id = \"{$row['id']}\""; // exclui o registro da tabela aluno_lembrete
							echo "SQL4: " . $sql4 . "<br>";
							$result4 = mysql_query($sql4) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
					}
				}
				
				// INSERE OS LEMBRETES NA TABELA aluno_lembrete
				foreach($arrayLembretesTipo as $lembreteGoogle){ // ESTAMOS DENTRO DE UM FOR POR DISCIPLINA/TURNO E EM CADA ITERACAO PODE TER MAIS DE UM TIPO DE LEMBRETE
					$tipoLembrete = $lembreteGoogle['tipo'];
					
					if ($tipoLembrete == "email")
						$fkTipoLembrete = 5;
					if ($tipoLembrete == "sms")
						$fkTipoLembrete = 6;
					
					$minutosLembrete = $lembreteGoogle['minutos'];
					
					// monta a query de insercao de lembrete
					$sql5 = "INSERT INTO
						`aluno_lembrete` ( `fk_id_aluno` ,  `dia_semana` ,  `turno` ,  `fk_sala_fk_id_unidade` ,  `fk_andar_sala` , `fk_numero_sala`, `fk_id_disciplina`, `fk_id_lembrete_tipo`, `minutosantec`,`dt_inicio`,`dt_final`)
					VALUES(  '{$idAluno}', '{$dia}', '{$turno}', '{$unidade}', '{$andarSala}', '{$sala}', '{$idDisciplina}', '{$fkTipoLembrete}', '{$minutosLembrete}', '{$dataDoEvento}', '{$dataFinalSemestre}'  ) "; 						
					// executa a query para armazenar o lembrete em banco na tabela aluno_lembrete
					$result5 = mysql_query($sql5) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
					
				}
				
				
				// listar registros que possuam mesmo usuario, dia da semana, turno e tipo de lembrete
				// se existirem, update 
				// excluir registros que possuam mesmo usuario, dia da semana, turno e tipo de lembrete
				// inserir registro novo (fk_id_aluno, dia_semana, turno, fk_sala_id_unidade, fk_andar_sala, fk_numero_sala, fk_id_disciplina, tipo, dt_inicio, dt_fim)
				
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