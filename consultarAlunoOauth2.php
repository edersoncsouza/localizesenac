<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    //protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebeu os parametros por POST
	if(isset($_POST['matricula']) && isset($_POST['autenticacao'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		$matricula = $_POST['matricula'];
		$autenticacao = $_POST['autenticacao'];
		
		// matricula no caso de usuarios oauth2 refere-se ao email
		// monta a query
		$sql = "SELECT id, nome, matricula, senha, autenticacao FROM aluno WHERE matricula = '$matricula' AND autenticacao = '$autenticacao'";
		
		// executa a query
		$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		// se encontrou o aluno
		if(mysql_num_rows($result) != 0){
						
			//cria o array data
			$data;//= []; 

			// armazena no array o nome e o id do aluno
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				 $data[] = $row;
				 
				 $id = $row['id'];
				 $nome = $row['nome'];
				 $matricula = $row['matricula'];
				 $senha = $row['senha'];
			}
			
			// registra as variaveis de sessao para equiparar aos usuarios logados localmente
			$_SESSION['usuarioID'] = $id; // Pega o valor da coluna 'id do registro encontrado no MySQL
			$_SESSION['usuarioNome'] = $nome; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
			$_SESSION['usuarioLogin'] = $matricula;
			$_SESSION['usuarioSenha'] = $senha;
			$_SESSION['tipoUsuario'] = $autenticacao;
			
			// codifica o array em formato Json e devolve como retorno
			echo json_encode($data);
		}
		else{ // if(mysql_num_rows($result) == 0)
			echo 0;
		}
	}
	else
		echo ("Não recebi os parametros de consulta");
?> 