<?php

session_start();
include('../dist/php/funcoes.php');
include("../dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança

/*
// se recebeu os parametros por POST
if(isset($_POST['tipoLembrete'], $_POST['turno'])){ 

	// sanitiza as entradas
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
*/	
	//$tipoLembrete = $_POST[$tipoLembrete];
	//$turno = $_POST['turno'];
	$turno = "N";
	$tipoLembrete = "icloud";
	
	$data = [];
	
	date_default_timezone_set('America/Sao_Paulo'); // define o timezone
	//setlocale (LC_ALL, 'pt_BR');
	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");

	$diaAtual = date('d-m-Y'); // 29/05/15
	$diaDaSemana = strtoupper(strftime("%a", strtotime($diaAtual))); // SEX
	
	$diaEnvio = date('d/m/Y', strtotime($diaAtual))	;
	
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
	
	if(mysql_num_rows($result) > 0){ // se houverem lembretes do tipo icloud
		while ($row = mysql_fetch_array($result, MYSQL_NUM)) { // para cada linha
		
			//'dia' => $row[5], 'minutos' => $row[6], 'turno' => $row[7]
			//echo "Hora envio antes antecedencia: " . $horaEnvio . "<br>";
			$antecedencia = $row[6]; 
			//echo "Antecedencia: " . $antecedencia . "<br>";
			$horaEnvio = date("H:i:s",strtotime("-" . $antecedencia . " minutes", strtotime($horaEnvio)));
			//date("H:i:s",strtotime("-15 minutes", strtotime($horaEnvio)));
			//echo "Hora envio depois antecedencia: " . $horaEnvio . "<br>";
			
			$agendado = $diaEnvio . " " . $horaEnvio;
			
			$data[] = array('celular' => "55" . preg_replace("/[^0-9]/","", $row[0]), 'disciplina' => "Aula - " . $row[1], 'unidade' => "Unidade " . $row[2], 'sala' => "Sala " . $row[3], 'idMensagem' => "id" . $row[4], 'enviadoPor' => "LocalizeSenac.com", 'agendadoPara' => $agendado);
			
			echo $data['agendadoPara'] . "<br>";
			
		}
	}
	
	// CODIFICA O ARRAY EM FORMATO JSON E DEVOLVE COMO RETORNO
	if(count($data)>0)
		echo json_encode($data);
	else
		echo 0;
	
/*
}	
else
	echo 0;
*/	


?>
