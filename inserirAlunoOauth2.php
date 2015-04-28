<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    //protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebeo os parametros por POST
	if(isset($_POST['matricula'], $_POST['password'], $_POST['nome'], $_POST['celular'], $_POST['email'], $_POST['ativo'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// monta a query
		$sql = "INSERT INTO
					`aluno` ( `matricula` ,  `senha` ,  `nome` ,  `celular` ,  `email` ,  `ativo`  )
				VALUES(  '{$_POST['matricula']}', '{$_POST['password']}', '{$_POST['nome']}', '{$_POST['celular']}', '{$_POST['email']}', '{$_POST['ativo']}' ) "; 
		
		// executa a query
		mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		// se nao inseriu o aluno
		if(mysql_affected_rows() == 0)
			echo 0;
		else{
			// registra as variaveis de sessao para equiparar aos usuarios logados localmente
			$_SESSION['usuarioID'] = mysql_insert_id(); // Pega o valor de 'id' criado ao incluir o aluno no MySQL
			$_SESSION['usuarioNome'] = $_POST['nome']; // Pega o valor de $_POST 'nome'
			$_SESSION['usuarioLogin'] = $_POST['matricula']; // Pega o valor de $_POST 'matricula'
			$_SESSION['usuarioSenha'] = $_POST['password']; // Pega o valor de $_POST 'password'

			echo mysql_insert_id(); // retorna o id do aluno inserido
		}
		// faz a verificação do resultado
		//echo (mysql_affected_rows()) ? "Aluno inserido." : "Nada inserido."; 
		//echo (mysql_affected_rows()) ? 1 : 0; 
	}
	else
		echo ("Não recebi os parametros de insercao");
?> 