<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebe os parametros por POST
	if(isset($_POST['id'], $_POST['passwordAtual'], $_POST['password'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// armazena os parametros recebidos
		$id = $_POST['id']; // armazena o id recebido por POST
		$passwordAtual = $_POST['passwordAtual']; // armazena a senha atual recebida por POST
		$passwordNova = $_POST['password']; // armazena a nova senha recebida por POST
		
		$passwordNovaCriptografada = password_hash($passwordNova, PASSWORD_BCRYPT); // cria a nova senha criptografada
		
		// busca a senha atual do usuario no banco
		$result = mysql_query("SELECT senha FROM aluno WHERE id={$id}");
		
		// compara a senha recebida por parametro com a senha retornada do banco
        //if($passwordAtual!= mysql_result($result, 0)){ // verificacao de senha em plain text
		 if (!password_verify($passwordAtual, mysql_result($result, 0))) { // verificacao de senha com a funcao password_verify da lib password.php
			echo "Senha atual incorreta\n"; 
        }
		else{// caso a senha esteja correta atualiza no banco e verifica o retorno
            
			if(password_verify($passwordNova,$passwordNovaCriptografada)){ // verifica se o hash criado está correto para evitar gravar uma senha errada no banco de dados
				mysql_query("UPDATE aluno SET senha='{$passwordNovaCriptografada}' where id='{$id}'") or die(mysql_error());
			
				// faz a verificação do resultado
				//echo (mysql_affected_rows()) ? "Senha alterada com sucesso!" : "A senha não pode ser alterada!"; 
				echo (mysql_affected_rows()) ? 1 : 0; // retorna 1 caso a senha tenha sido alterada ou 0 se não alterou
			}
		}
	}
	else // caso não tenha recebido os parametros
		echo 0;//("Não recebi os parametros para mudança de senha");
?> 