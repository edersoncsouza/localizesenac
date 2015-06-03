<?php

include("dist/php/funcoes.php");

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
		// grava o retorno no log de sucesso
		file_put_contents('logs/successlog.txt', $retorno, FILE_APPEND);
	}
	
}

?>