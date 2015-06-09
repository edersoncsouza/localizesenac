<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
	//protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	$sql = "select concat(data_inicio, ' ', hora_inicio) as date, descricao as title from evento_geral"; //replace emp_info with your table name


// executa a query para verificar se o aluno ja possui lembretes
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0){ // se houverem lembretes do tipo recebido
		
	//create an array
		$data[] = array();
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