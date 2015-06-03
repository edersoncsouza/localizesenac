<?php

// Define URL where the form resides
$form_url = "zenvia/buscarLembretes.php";

for ($contador = 60; $contador >= 60; $contador--) {

	// This is the data to POST to the form. The KEY of the array is the name of the field. The value is the value posted.
	$data_to_post = array();

	$data_to_post['tipoLembrete'] = 'pemail';
	$data_to_post['turno'] = 'M';
	$data_to_post['antecedenciaEmail'] = $contador;

	echo "Enviando POST para zenvia/buscarLembretes.php com campos: tipoLembrete = 'pemail', turno = 'M' e antecedenciaEmail = " . $contador . "<br>";
	
	// Initialize cURL
	$curl = curl_init();

	// Set the options
	curl_setopt($curl,CURLOPT_URL, $form_url);

	// This sets the number of fields to post
	curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));

	// This is the fields to post in the form of an array.
	curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
	
	// define que sera recebido retorno
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	//execute the post
	$result = curl_exec($curl);
	
	// imprime o retorno recebido
	echo "Vou imprimir o retorno de buscarLembretes:";
	print_r($result);
	echo $result;
	echo "<br>";

	//close the connection
	curl_close($curl);

	sleep(60);
}

?>