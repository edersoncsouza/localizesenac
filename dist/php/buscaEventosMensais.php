<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    mysql_set_charset('UTF8', $_SG['link']);
	
	//setup php for working with Unicode data
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	mb_language('uni');
	mb_regex_encoding('UTF-8');
	ob_start('mb_output_handler');

if(isset($_POST['mesEvento'], $_POST['anoEvento'])){ 
		
	// sanitiza as entradas
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value);}
	
	// armazena os parametros recebidos
	$mesEvento = $_POST['mesEvento'];
	$anoEvento = $_POST['anoEvento'];
	
	// armazena o total de dias no mes
	$diaFinalMes = cal_days_in_month(CAL_GREGORIAN, $mesEvento, $anoEvento);

	// monta a query de pesquisa de eventos no banco de dados
	$sql = "SELECT
					`id`
			FROM 
				`evento_geral`
			WHERE
				`data_inicio`
			BETWEEN
				'".$anoEvento."-".$mesEvento."-01'
			AND
				'".$anoEvento."-".$mesEvento."-".$diaFinalMes."'";
	
	// executa a query para verificar se o aluno ja possui eventos
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0) // se houverem eventos mensais	
		echo mysql_num_rows($result);
	else // caso não tenha eventos no mes recebido
		echo 0;//("Não existem eventos neste mes");
}
else // caso não tenha recebido os parametros
	echo 0;//("Não recebi os parametros para buscar eventos mensais");

?>