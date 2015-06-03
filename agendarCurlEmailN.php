<?php

include("dist/php/funcoes.php");

for ($contador = 60; $contador >= 1; $contador--) {

	// monta o array com os campos de POST
	$params = array(
	   "tipoLembrete" => "pemail",
	   "turno" => "N",
	   "antecedenciaEmail" => $contador
	);
	 
	// Define a URL
	$form_url = "http://localhost:8080/projetos/localizesenac/zenvia/buscarLembretes.php";

	// executa a funcao httpPost e armazena na variavel retorno
	$retorno = httpPost($form_url,$params);

	// caso haja retorno
	if($retorno){
		// grava o retorno no log de sucesso
		file_put_contents('logs/successlog.txt', $retorno, FILE_APPEND);
	}
	
	sleep(60); // para a execucao por 60 segundos
	
}

?>