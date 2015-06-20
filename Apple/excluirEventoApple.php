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

	<!-- Bootstrap Core CSS -->
    <link href="../dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- CSS deste arquivo -->
	<link href="../dist/css/calendar.css" rel="stylesheet">
	<!-- <link href="dist/css/calendar.css" rel="stylesheet"> -->
	
	<!-- Custom Fonts -->
	<link href="../dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
	
	<!-- jQuery -->
    <script type="text/javascript" src="../dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="../dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Bootbox -->
	<script type="text/javascript" src="../dist/components/bootbox/dist/js/bootbox.min.js"></script>

	<script>
		$(document).ready(function() {
			if(($('#appleID').val() == ""))
			  bootbox.alert("Você desselecionou todos os lembretes do iCalendar! Para excluí-los entre com suas credenciais");
		  
			$('#cancelaIcloud').click( function() {
					var url = "../principal.php";
					window.location.href = url;
			});

			// exibe a animacao de carregando cada vez que uma requisicao Ajax ocorrer
			$body = $("body");
			$(document).on({
				ajaxStart: function() { $body.addClass("carregando");    },
				 ajaxStop: function() { $body.removeClass("carregando"); }    
			});
			
		});
	</script>
	
    </head>
    <!-- <body onLoad="document.getElementById('appleID').focus();" > -->
	<body>
<?php
	
    include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("../dist/php/funcoes.php");
	
	// Load ICS parser
	require_once('addons/ics-parser/class.iCalReader.php');
	// Load iCloud Calendar class
	require_once('class.iCloudCalendar.class.php');
	
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	//imprimeSessao();
	
	//Define iCloud URLs
	$icloudUrls = array();
	for($i = 1; $i < 25; $i++)
		$icloudUrls[] = "https://p".str_pad($i, 2, '0', STR_PAD_LEFT)."-caldav.icloud.com";
	
	//Functions
	function doRequest($user, $pw, $url, $xml)
	{
		//Init cURL
		$c=curl_init($url);
		//Set headers
		curl_setopt($c, CURLOPT_HTTPHEADER, array("Depth: 1", "Content-Type: text/xml; charset='UTF-8'", "User-Agent: DAVKit/4.0.1 (730); CalendarStore/4.0.1 (973); iCal/4.0.1 (1374); Mac OS X/10.6.2 (10C540)"));
		curl_setopt($c, CURLOPT_HEADER, 0);
		//Set SSL
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		//Set HTTP Auth
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($c, CURLOPT_USERPWD, $user.":".$pw);
		//Set request and XML
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PROPFIND");
		curl_setopt($c, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		//Execute
		$data=curl_exec($c);
		//Close cURL
		curl_close($c);
		
		return $data;
	}
?>
		<div class="container">
		
			<div class="row">
			  <div class="col-centered col-md-4">

				<div id="formulario">
				
					<!-- ICONE DO CALENDAR -->
					<div class="btn-icon-container" >
						<div class="btn-border"></div>
						<canvas id="canvas"></canvas>
					</div>
					
					<div class="btn-text-container" style="width:80px;left:-3px;">
						<span class="btn-text">Calendar</span>
						
						
					</div>
					<!-- ICONE DO CALENDAR -->
					
					
					
				  <h3>Entre com suas credenciais Apple:</h3>
				  <br>
				  
				  <form role="form" action="" method="post">
					<div class="form-group">
					 
						<?php
							//echo "<td><input type='text' name='appleID' id='appleID' size='50' value='";
							echo "<input type='text' name='appleID' id='appleID' class='form-control' placeholder='ID Apple' required value='";
							
							if(isset($_POST['appleID'])) {
								echo $_POST['appleID'];
							}
							echo "'>";
						?>
					 
					</div>
					<div class="form-group">

						<?php
							//echo "<td><input type='password' name='pw' id='pw' size='50' value='";
							echo "<input type='password' name='pw' id='pw' class='form-control' placeholder='Senha' required value='";

							if(isset($_POST['pw'])) {
								echo $_POST['pw'];
							}
							echo "'>";
						?>
					  
					</div>

					<input type="submit"  name="submit" class="btn btn-primary " name="Login"/>
					<button type="button" id="cancelaIcloud" name="cancelaIcloud" class="btn btn-danger" >Cancelar</button>
					
				  </form>
				  <h4 style="color:rgba(153,0,0,1);" align="center">
				  </h4>
				</div>
				
			  </div>
			  
			</div>
			
		</div>
		
<?php
	if(isset($_POST['appleID']))
	{
		$user=$_POST['appleID'];
		$pw=$_POST['pw'];
		
		//Get Principal URL
		$principal_request="<A:propfind xmlns:A='DAV:'>
								<A:prop>
									<A:current-user-principal/>
								</A:prop>
							</A:propfind>";
		//$response=simplexml_load_string(doRequest($user, $pw, $_POST['server'], $principal_request));
		$response=simplexml_load_string(doRequest($user, $pw, $icloudUrls[rand(0,23)], $principal_request));
		
		if($response[0]->head->title == "Unauthorized"){
			echo "<script>bootbox.alert(\"Erro na autenticação, tente novamente ou clique no botão Cancelar para desistir\"); </script>";
		}
		else{
		
		//Principal URL
		$principal_url=$response->response[0]->propstat[0]->prop[0]->{'current-user-principal'}->href;
		$userID=explode("/", $principal_url);
		$userID=$userID[1];
		
		//Get Calendars
		$calendars_request="<A:propfind xmlns:A='DAV:'>
								<A:prop>
									<A:displayname/>
								</A:prop>
							</A:propfind>";
							
		//$url=$_POST['server']."/".$userID."/calendars/";
		$url=$icloudUrls[rand(0,23)]."/".$userID."/calendars/";
		$response=simplexml_load_string(doRequest($user, $pw, $url, $calendars_request));
		//To array
		$calendars=array();
		foreach($response->response as $cal)
		{
			$entry["href"]=$cal->href;
			if(isset($cal->propstat[0]->prop[0]->displayname)) {
				$entry["name"]=$cal->propstat[0]->prop[0]->displayname;
			} else {
				$entry["name"]="";
			}
			$calendars[]=$entry;
		}

		//CardDAV URL
		//$cardserver = str_replace('caldav', 'contacts', $_POST['server']);
		$cardserver = str_replace('caldav', 'contacts', $icloudUrls[rand(0,23)]);
		$card_request="<A:propfind xmlns:A='DAV:'>
							<A:prop>
								<A:addressbook-home-set xmlns:A='urn:ietf:params:xml:ns:carddav'/>
							</A:prop>
						</A:propfind>";
		$response=simplexml_load_string(doRequest($user, $pw, $cardserver . $principal_url, $card_request));
		$cardurl=$response->response[0]->propstat[0]->prop[0]->{'addressbook-home-set'}->href;

		
		if($userID){ // se possuir o id do usuario
		
			// INICIO DO PROCESSO DE AUTENTICACAO NO ICLOUD
			// cria um array com os valores dos servidores iCloud
			$icloudServers = array();
			for($i = 1; $i < 25; $i++)
				$icloudServers[] = "p" . str_pad($i, 2, '0', STR_PAD_LEFT);

			// Connection settings
			//$my_icloud_server = 'p02';
			$my_icloud_server = $icloudServers[rand(0,23)]; // seleciona um dos servidores aleatoriamente
			
			//echo "Servidor iCloud selecionado: " . $my_icloud_server . "\n";
			
			//$my_user_id = '1759380956';
			$my_user_id = $userID; // armazena o id do usuario vindo do POST
			$my_calendar_id= 'home'; // define o calendario pessoal como o calendario de destino do evento
			//$my_icloud_username = 'xxx@icloud.com';
			$my_icloud_username = $user; // define o usuario para cadastrar o evento
			//$my_icloud_password = 'xxx';
			$my_icloud_password = $pw; // define a senha para cadastrar o evento

			// iCloud calendar object
			$icloud_calendar = new php_icloud_calendar($my_icloud_server, $my_user_id, $my_calendar_id, $my_icloud_username, $my_icloud_password);
			
			// INICIO DO PROCESSO DE EXCLUSAO DE TODOS OS EVENTOS DA SEMANA QUE FOREM DO TIPO ICLOUD
			// DESSA FORMA SE GARANTE A EXCLUSAO DOS LEMBRETES QUE TIVERAM O CHECKBOX DESMARCADO
			
			date_default_timezone_set('America/Sao_Paulo'); // define o timezone	
				
			// DEFINE O PERIODO DE REMOCAO (SEMANA TODA)
			$diaAtualRemocao = (date('Y-m-d'). 'T00:00:00.000z'); // define o inicio do dia atual
			$diaFinalRemocao = (date('Y-m-d', strtotime("+7 days")).'T23:59:59.000z'); // define o final do ultimo dia da semana
			
			// ARMAZENA OS EVENTOS DA SEMANA DO TIPO LOCALIZESENAC E EXCLUI
			$eventosSemanaisIcloud = $icloud_calendar->get_events($diaAtualRemocao, $diaFinalRemocao); // armazena os eventos no periodo da semana atual
			
			echo "Dia inicial de remocao: " . $diaAtualRemocao . "\n";
			echo "Dia final de remocao: " . $diaFinalRemocao . "\n";
			
			//echo "Array de eventos semanais iCloud:\n";
			//print_r($eventosSemanaisIcloud);
			//echo "\n";
			
			if($eventosSemanaisIcloud){ // se existirem eventos na semana
				$eventosDiariosExcluir = []; // cria o array de eventos a excluir
				
				foreach($eventosSemanaisIcloud as $eventoDiario){ // laço que percorre cada evento diario
					
					if (substr($eventoDiario['SUMMARY'], 0, 13) == "LocalizeSenac"){ // se o evento for do tipo Localizesenac
						//$icloud_calendar->remove_event($eventoDiario['UID']);
						
						if(!in_array($eventoDiario['UID'], $eventosDiariosExcluir)){ // se o id do evento ja nao estiver no array de exclusao
							
							array_push($eventosDiariosExcluir,$eventoDiario['UID']); // envia o elemento pro array
						
						}
						
					}
				}
				
				echo "Array de eventos a excluir:\n";
				print_r($eventosDiariosExcluir);
				echo "\n";
				
				foreach($eventosDiariosExcluir as $eventoParaExcluir) // laço que percorre todos os UID's de eventos a excluir
					$icloud_calendar->remove_event($eventoParaExcluir); // remove o evento com o UID fornecido
				
			}
			// METODO 1 - FINAL DO PROCESSO DE EXCLUSAO DE TODOS OS EVENTOS DA SEMANA QUE FOREM DO TIPO ICLOUD

			// RETORNA A PAGINA PRINCIPAL
			echo "<script>location.href='../principal.php';</script>";		
		}
		
		}
	}
?>

	</body>
	<script type="text/javascript" src="../dist/js/calendarExclusaoApple.js"></script> 

</html>