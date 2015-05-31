<?php

session_start();
include('funcoes.php');
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança

// se recebeu os parametros por POST
if(isset($_POST['tipoLembrete'], $_POST['turno'])){ 

	// sanitiza as entradas
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }

	$tipoLembrete = $_POST['tipoLembrete'];
	$turno = $_POST['turno'];
	//$tipoLembrete = "icloud";
	//$turno = "M";
	
	$data = [];
	
	date_default_timezone_set('America/Sao_Paulo'); // define o timezone
	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

	//setup php for working with Unicode data
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');

	$diaAtual = date('d-m-Y'); // armazena a data atual 29-05-15
	$diaDaSemana = strtoupper(strftime("%a", strtotime($diaAtual))); // recebe o dia da semana reduzido e transforma em maiusculas (SÁB)
	$diaDaSemana = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', utf8_encode($diaDaSemana) ) ); // remove acentos do dia da semana (SAB)
	
	echo "Procurei apenas por mensagens do tipo " . $tipoLembrete . " no turno " . $turno . " no dia: " . $diaDaSemana . "<br>";
	
	$diaEnvio = date('d/m/Y', strtotime($diaAtual))	; // formata a data atual para 29/05/2015

	// define a hora de inicio da aula de acordo com o turno
	if ($turno == "N")
		$horaEnvio = "19:00:00";
	if ($turno == "M")
		$horaEnvio = "08:00:00";
	
	// monta a query de pesquisa de lembretes do icloud
	$sql = "SELECT
				celular, disciplina.nome, fk_sala_fk_id_unidade, fk_numero_sala, aluno_lembrete.id, dia_semana, minutosantec, turno
			FROM
				aluno_lembrete, aluno, disciplina
			WHERE
				fk_id_aluno = aluno.id
			AND
				fk_id_disciplina = disciplina.id
			AND
				dia_semana = \"{$diaDaSemana}\"
			AND
				turno = \"{$turno}\"
			AND
				tipo = \"{$tipoLembrete}\"";
				
	// executa a query para verificar se o aluno ja possui lembretes
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0){ // se houverem lembretes do tipo recebido
		
		if($tipoLembrete == "pemail"){
			
		}
		
		if($tipoLembrete == "zsms"){ // se o tipo de lembrete do SMS da Zenvia
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
				// armazena os minutos de antecedencia do registro
				$antecedencia = $row[6]; 
				// diminui o tempo de antecedencia do horario da aula
				$horaEnvio = date("H:i:s",strtotime("-" . $antecedencia . " minutes", strtotime($horaEnvio)));
				// monta a string de data e hora de agendamento de envio para a mensagem
				$agendado = $diaEnvio . " " . $horaEnvio; 
				
				// armazena os campos necessarios a mensagem em um array
				$data[] = array('celular' => "55" . preg_replace("/[^0-9]/","", $row[0]), 'disciplina' => "Aula - " . $row[1], 'unidade' => "Unidade " . $row[2], 'sala' => "Sala " . $row[3], 'idMensagem' => "id" . $row[4], 'enviadoPor' => "LocalizeSenac.com", 'agendadoPara' => $agendado);	
			}
		}
		
	}
	
	/*
	// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
	if(count($data)>0)
		echo json_encode($data);
	else
		echo 0;
	
	echo "<br>";
	print_r($data);
	echo "<br>";
	*/
	
	
	
	// monta a string de mensagens
	if($tipoLembrete == "zsms"){
		$stringSms = "";
		foreach($data as $sms) {
			$stringSms .= $sms['celular'];
			$stringSms .= ";" . $sms['disciplina'] . " - " . $sms['unidade'] . " - " . $sms['sala'] . ";" . $sms['idMensagem'] . ";" . $sms['enviadoPor'] . ";". $sms['agendadoPara']."\n";
		}
		
		echo $stringSms . "<br>";
	}
	

}	
else
	echo 0;
	


?>
