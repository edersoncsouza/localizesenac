<?php

//session_start();
include_once("human_gateway_client_api/HumanClientMain.php");
include("../dist/php/funcoes.php");
include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança

function enviaEmail($corpo, $destinatario, $nome){

	require_once('../phpmailer/class.phpmailer.php');
	include("../phpmailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	/*
	$body             = file_get_contents('contents.html');
	$body             = eregi_replace("[\]",'',$body);
	*/
	$body = $corpo;
	
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mx1.hostinger.com.br"; // SMTP server
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "localizesenac@gmail.com";  // GMAIL username
	$mail->Password   = "N1kolatesla";            // GMAIL password

	$mail->SetFrom('localizesenac@gmail.com', 'LocalizeSenac');

	$mail->AddReplyTo('localizesenac@gmail.com',"LocalizeSenac");

	$mail->Subject    = retiraAcentos($corpo);

	$mail->AltBody    = $body; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = $destinatario;
	$mail->AddAddress($address, $nome);

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
	
}

enviaEmail("Aula: Tópicos Avançados em TI  - Unidade: 1 - Turno: N - Sala: 301", "edersoncsouza@gmail.com", "Ederson Souza");

?>
