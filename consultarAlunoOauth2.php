<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebeo os parametros por POST
	if(isset($_SESSION['usuarioOauth2'])){ 
		
		// sanitiza as entradas
		$matricula = mysql_real_escape_string($_SESSION['usuarioOauth2']);
		
		// monta a query
		$sql = "SELECT 
					matricula 
				FROM 
					`aluno` 
				WHERE 
					`matricula`= {$_POST['matricula']}";
		
		// executa a query
		mysql_query($sql) or die(mysql_error());
		
		// faz a verificação do resultado
		//echo (mysql_affected_rows()) ? "Aluno inserido." : "Nada inserido."; 
		echo (mysql_affected_rows()) ? 1 : 0; 
	}
	else
		echo ("Não recebi os parametros de insercao");
?> 