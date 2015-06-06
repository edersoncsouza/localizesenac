<?php

include("dist/php/funcoes.php");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y H:i');
$dataExtensa = strftime('%A, %d de %B de %Y', strtotime('today'));

set_time_limit(0); // tentativa de evitar o limite que causa o erro: Fatal error: Maximum execution time of 300 seconds exceeded  

for ($contador = 60; $contador >= 1; $contador--) {

	// monta o array com os campos de POST
	$params = array(
	   "tipoLembrete" => "pemail",
	   "turno" => "M",
	   "antecedenciaEmail" => $contador
	);
	 
	// Define a URL
	$form_url = "http://localhost:8080/projetos/localizesenac/zenvia/buscarLembretes.php";

	// executa a funcao httpPost e armazena na variavel retorno
	$retorno = httpPost($form_url,$params);

	// caso haja retorno
	if($retorno){
		// armazena a mensagem de erro em uma variavel
		//$mensagemDeSucesso = "Job de e-mails com " . $contador . " minutos de antecedencia, do turno M executado em " . strftime('%A, %d de %B de %Y', strtotime('today')) . "<br>";
		$mensagemDeSucesso = "E-mail Job with " . $contador . " min of advance, Morning shift executed at " . date('d/m/Y H:i') . "<br>";

		// grava o retorno no log de sucesso
		file_put_contents(dirname(__FILE__).'/logs/successlog.txt', $retorno, FILE_APPEND);
		
		// imprime o log para verificar na area Advanced Cron Job
		echo $mensagemDeSucesso;
	}
	else{
		// armazena a mensagem de erro em uma variavel
		$mensagemDeErro = "Não houve retorno no Job de e-mail executado em " . strftime('%A, %d de %B de %Y', strtotime('today'));
		
		// grava mensagem de erro no log de erros
		file_put_contents(dirname(__FILE__).'logs/errorlog.txt', $mensagemDeErro, FILE_APPEND);
		
		// imprime o log para verificar na area Advanced Cron Job
		echo $mensagemDeErro;
	}
	
	sleep(60); // para a execucao por 60 segundos
	
}

?>


















