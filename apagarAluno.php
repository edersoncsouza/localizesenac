<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	if(isset($_POST['id'])){
		
		$id = (int) $_POST['id'];
		
		mysql_query("DELETE FROM `aluno` WHERE `id` = '$id' ") ; 
		
		//echo (mysql_affected_rows()) ? "Aluno apagado." : "Nada apagado."; 
		echo (mysql_affected_rows()) ? 1 : 0; 
	}
	else
		echo ("Não chegou o id");
?> 
