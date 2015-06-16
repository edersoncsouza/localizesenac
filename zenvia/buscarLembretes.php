<?php

//session_start();
include_once("human_gateway_client_api/HumanClientMain.php");
include("../dist/php/funcoes.php");
include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança

// se recebeu os parametros por POST
if(isset($_POST['tipoLembrete'], $_POST['turno'])){

	// sanitiza as entradas
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }

	$tipoLembrete = $_POST['tipoLembrete'];
	
	// converte o valor de string para a FK correspondente na tabela lembrete_tipo
	if ($tipoLembrete == "pemail")
		$fk_TipoLembrete = 1;
	if ($tipoLembrete == "zsms")
		$fk_TipoLembrete = 2;	
	
	$turno = $_POST['turno'];
	//$tipoLembrete = "pemail";
	//$turno = "N";
	
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
	
	//$diaDaSemana = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', utf8_encode($diaDaSemana) ) ); // remove acentos do dia da semana (SAB)
	$diaDaSemana = retiraAcentos(utf8_encode($diaDaSemana) ); // remove acentos do dia da semana (SAB)
	
	//echo "Procurei apenas por mensagens do tipo " . $tipoLembrete . " no turno " . $turno . " no dia: " . $diaDaSemana . "\n";
	
	$diaEnvio = date('d/m/Y', strtotime($diaAtual))	; // formata a data atual para 29/05/2015

	// define a hora de inicio da aula de acordo com o turno
	if ($turno == "N")
		$horaEnvio = "19:00:00";
	if ($turno == "M")
		$horaEnvio = "08:00:00";
	
	// monta a query de pesquisa de lembretes do icloud
	$sql = "SELECT
				celular, disciplina.nome, fk_sala_fk_id_unidade, fk_numero_sala, aluno_lembrete.id, dia_semana, minutosantec, turno, aluno.nome, aluno.email
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
				fk_id_lembrete_tipo = \"{$fk_TipoLembrete}\"";
				
	// executa a query para verificar se o aluno ja possui lembretes
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0){ // se houverem lembretes do tipo recebido
		
		if($tipoLembrete == "pemail"){ // se o lembrete for do tipo email
		
			if(isset($_POST['antecedenciaEmail'])){ // se recebeu os minutos de antecedencia por parametro
				
				//$antecedenciaEmail = 60;
				$antecedenciaEmail = $_POST['antecedenciaEmail']; // armazena a antencedencia
				
				while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
					
						if($antecedenciaEmail == $row[6]){ // verifica se os lembretes listados tem a antecedencia desejada
							
							$corpo = "Aula: " . $row[1] . " - Unidade: " . $row[2] . " - Turno: " . $row[7] . " - Dia: " . $row[5] . " - Sala: " . $row[3];
							$nome = $row[8];
							$destinatario = $row[9];
							enviaEmail($corpo, $destinatario, $nome);
							echo "\n Email enviado para " . $destinatario . "\n";
						}
						
				}
			}	
		}
		
		if($tipoLembrete == "zsms"){ // se o tipo de lembrete do SMS da Zenvia
			
			// EXECUTA O LACO PARA RECUPERAR AS INFORMACOES PARA OS SMS's
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
				// armazena os minutos de antecedencia do registro
				$antecedencia = $row[6];
				
				// diminui o tempo de antecedencia do horario da aula
				$horaEnvioAntecipado = date("H:i:s",strtotime("-" . $antecedencia . " minutes", strtotime($horaEnvio)));
				// monta a string de data e hora de agendamento de envio para a mensagem
				$agendado = $diaEnvio . " " . $horaEnvioAntecipado; 
				
				// formata e armazena os campos necessarios a mensagem em um array
				$data[] = array('celular' => "55" . preg_replace("/[^0-9]/","", $row[0]), 'disciplina' => "Aula - " . retiraAcentos($row[1]), 'unidade' => "Unidade " . $row[2], 'sala' => "Sala " . $row[3], 'idMensagem' => "id" . $row[4], 'enviadoPor' => "LocalizeSenac.com", 'agendadoPara' => $agendado);	
			}
			
			// CONFIGURA O ACESSO AO SISTEMA ZENVIA
			$humanMultipleSend = new HumanMultipleSend("dsx.assessoria", "wryuvGT12E"); // instancia a classe e fornece usuario e senha
			$tipo = HumanMultipleSend::TYPE_E; // define o tipo de mensagem [numero;mensagem;id;sender;agenda]
			$callBack = HumanMultipleSend::CALLBACK_FINAL_STATUS; // define o retorno (callback)
			
			// MONTA A STRING COM AS MENSAGENS
			$msg_list = "";
			
			foreach($data as $sms) {
				$msg_list .= $sms['celular'];
				$msg_list .= ";" . $sms['disciplina'] . " - " . $sms['unidade'] . " - " . $sms['sala'] . ";" . $sms['idMensagem'] . ";" . $sms['enviadoPor'] . ";". $sms['agendadoPara']."\n";
			}
			
			echo $msg_list . "<br>";
			
			// FAZ O ENVIO DAS MENSAGENS AO SISTEMA ZENVIA
			$responses = $humanMultipleSend->sendMultipleList($tipo, $msg_list, $callBack); // envia as mensagens e armazena o retorno

			foreach ($responses as $response)  { // desmembra o array de retorno
				echo $response->getCode();
				echo $response->getMessage();
			}
			
		}
		
	}

	/*
	// CONFIGURA O ACESSO AO SISTEMA ZENVIA
	$humanMultipleSend = new HumanMultipleSend("dsx.assessoria", "wryuvGT12E"); // instancia a classe e fornece usuario e senha
	$tipo = HumanMultipleSend::TYPE_E; // define o tipo de mensagem [numero;mensagem;id;sender;agenda]
	$callBack = HumanMultipleSend::CALLBACK_FINAL_STATUS; // define o retorno (callback)
	*/

	/*
	// monta a string de mensagens
	if($tipoLembrete == "zsms"){
		$msg_list = "";
		foreach($data as $sms) {
			$msg_list .= $sms['celular'];
			$msg_list .= ";" . $sms['disciplina'] . " - " . $sms['unidade'] . " - " . $sms['sala'] . ";" . $sms['idMensagem'] . ";" . $sms['enviadoPor'] . ";". $sms['agendadoPara']."\n";
		}
		
		echo $msg_list . "<br>";
	}
	*/

	/*
	// FAZ O ENVIO DAS MENSAGENS AO SISTEMA ZENVIA
	$responses = $humanMultipleSend->sendMultipleList($tipo, $msg_list, $callBack); // envia as mensagens e armazena o retorno

	foreach ($responses as $response)  { // desmembra o array de retorno
		echo $response->getCode();
		echo $response->getMessage();
	}
	*/


}	
else
	echo 0;



?>
