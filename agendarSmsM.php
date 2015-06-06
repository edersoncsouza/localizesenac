<?php

include("dist/php/funcoes.php");
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y H:i');
$dataExtensa = strftime('%A, %d de %B de %Y', strtotime('today'));

	// monta o array com os campos de POST
	$params = array(
	   "tipoLembrete" => "zsms",
	   "turno" => "M"
	);
	 
	// Define a URL
	$form_url = "http://localhost:8080/projetos/localizesenac/zenvia/buscarLembretes.php";

	// executa a funcao httpPost e armazena na variavel retorno
	$retorno = httpPost($form_url,$params);

	// caso haja retorno
	if($retorno){
		// armazena a mensagem de erro em uma variavel
		$mensagemDeSucesso = "SMS jox executed at " . $data);
		
		// grava o retorno no log de sucesso
		file_put_contents(dirname(__FILE__).'/logs/successlog.txt', $retorno, FILE_APPEND);
		
		// imprime o log para verificar na area Advanced Cron Job
		echo $mensagemDeSucesso;
	}
	else{
		// armazena a mensagem de erro em uma variavel
		$mensagemDeErro = "Não houve retorno no Job de SMS executado em " . strftime('%A, %d de %B de %Y', strtotime('today'));
		
		// grava mensagem de erro no log de erros
		file_put_contents(dirname(__FILE__).'logs/errorlog.txt', $mensagemDeErro, FILE_APPEND);
		
		// imprime o log para verificar na area Advanced Cron Job
		echo $mensagemDeErro;
	}

?>






