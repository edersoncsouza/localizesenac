<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	if(isset($_POST['id'])){
		
		$id = (int) $_POST['id'];
		$sql = "DELETE FROM `aluno` WHERE `id` = '$id' ";
		mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		//echo (mysql_affected_rows()) ? "Aluno apagado." : "Nada apagado."; 
		echo (mysql_affected_rows()) ? 1 : 0; 
	}
	else
		echo ("Não chegou o id");
?> 
