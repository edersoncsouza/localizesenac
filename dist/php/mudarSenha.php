<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['id'], $_POST['passwordAtual'], $_POST['password'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$id = $_POST['id'];
		$passwordAtual = $_POST['passwordAtual'];
		$password = $_POST['password'];
		
		// busca a senha atual do usuario no banco
		$result = mysql_query("SELECT senha FROM aluno WHERE id={$id}");
		
		// compara a senha recebida por parametro com a senha retornada do banco
        if($passwordAtual!= mysql_result($result, 0)){
			echo "Senha atual incorreta";
        }
		else{// caso a senha esteja correta atualiza no banco e verifica o retorno
            mysql_query("UPDATE aluno SET senha='{$password}' where id='{$id}'") or die(mysql_error());
			
			// faz a verificação do resultado
			//echo (mysql_affected_rows()) ? "Senha alterada com sucesso!" : "A senha não pode ser alterada!"; 
			echo (mysql_affected_rows()) ? 1 : 0; // retorna 1 caso a senha tenha sido alterada ou 0 se não alterou
		}
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");
?> 