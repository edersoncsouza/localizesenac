<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['celular'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$celular = $_POST['celular'];
		
        mysql_query("UPDATE aluno SET nome='{$nome}', email='{$email}', celular='{$celular}'  where id='{$id}'") or die(mysql_error());
			
		// faz a verificação do resultado
		//echo (mysql_affected_rows()) ? "Senha alterada com sucesso!" : "A senha não pode ser alterada!"; 
		echo (mysql_affected_rows()) ? 1 : 0; // retorna 1 caso alterações tenham acontecido ou 0 se não alterou	
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para atualização de dados");
?> 