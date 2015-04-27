<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	// se recebeo os parametros por POST
	if(isset($_POST['matricula'])){ 
		
		// sanitiza as entradas
		foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
		
		// monta a query
		$sql = "SELECT 
					id, nome 
				FROM 
					`aluno` 
				WHERE 
					`matricula`= {$_POST['matricula']}";
		
		// executa a query
		$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
		
		if(mysql_affected_rows() == 0)
			echo 0;
		else{
			//cria o array data
			$data= []; 

			// armazena no array o nome e o id do aluno
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				 $data[] = $row; 
			}
			
			// codifica o array em formato Json e devolve como retorno
			echo json_encode($data);
		}
	}
	else
		echo ("Não recebi os parametros de consulta");
?> 