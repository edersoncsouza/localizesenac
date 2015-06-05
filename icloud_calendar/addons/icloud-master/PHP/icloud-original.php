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
    <link href="../../../../dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../../dist/components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	
	<!-- CSS deste arquivo -->
	<link href="../../../../dist/css/calendar.css" rel="stylesheet">
	<!-- <link href="dist/css/calendar.css" rel="stylesheet"> -->
	
	<!-- Custom Fonts -->
	<link href="../../../../dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
	
	<!-- jQuery -->
    <script type="text/javascript" src="../../../../dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="../../../../dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Bootbox -->
	<script type="text/javascript" src="../../../../dist/components/bootbox/dist/js/bootbox.min.js"></script>

	<script>
		$(document).ready(function() {
			if(($('#appleID').val() == ""))
			  bootbox.alert("Você efetuou alterações em avisos do iCalendar! Entre com suas credenciais para efetivar as mudanças!");
		  
			$('#cancelaIcloud').click( function() {
					var url = "../../../../principal.php";
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
	
    include("../../../../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("../../../../dist/php/funcoes.php");
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
		
		// armazena as informacoes da conta iCloud
		$retornoIcloud['usuario'] = $user;
		$retornoIcloud['senha'] = $pw;
		$retornoIcloud['id'] = $userID;
		
		$arrayRetornoJson = json_encode($retornoIcloud); // codifica o array em formato JSON e armazena

		if($retornoIcloud['id']){ // se possuir o id do usuario
		
			// ARMAZENA O ARRAY DE AUTENTICACAO EM UM ARRAY JAVASCRIPT
			echo "<script type=\"text/javascript\">
					var arrayAutenticacaoApple =" . $arrayRetornoJson . ";
					//console.log(arrayAutenticacaoApple);
					
				</script>";
			
			// ENVIA POR POST OS ARRAYS PARA A INCLUSAO DOS EVENTOS
			echo "<script type=\"text/javascript\">
				var arrayLembretesApple = localStorage.getItem('arrayLembretesApple');
				var arrayDisciplinasApple = localStorage.getItem('arrayDisciplinasApple');
				
				var url = \"../../../inserirEventoApple.php\";
						$.post(
								url,
								{'arrayLembretes' : arrayLembretesApple, 'arrayDisciplinas' : arrayDisciplinasApple, 'arrayAutenticacao' : arrayAutenticacaoApple }
						);
				</script>";
				
			// RETORNA A PAGINA PRINCIPAL
			echo "<script>location.href='../../../../principal.php';</script>";
					
		}
		
		}
	}
?>

	</body>
	<script type="text/javascript" src="../../../../dist/js/calendar.js"></script> 

</html>