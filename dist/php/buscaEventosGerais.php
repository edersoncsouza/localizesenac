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
	
	// monta a query de pesquisa de eventos no banco de dados
	$sql = "select concat(data_inicio, ' ', hora_inicio) as date, descricao as title from evento_geral";
	
	// executa a query para verificar se o aluno ja possui eventos
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0){ // se houverem eventos
		
		$data = array(); //cria o array
		while($row =mysql_fetch_assoc($result))
		{
			$data[] = $row;
		}
		
	}
	if($data){
		echo json_encode($data);	
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");

?>