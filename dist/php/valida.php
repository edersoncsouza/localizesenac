<?php

session_start();

// Inclui o arquivo com o sistema de segurança
include("seguranca.php");

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		// Salva duas variáveis com o que foi digitado no formulário
		// Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
		$usuario = addslashes((isset($_POST['usuario'])) ? $_POST['usuario'] : '');
		$senha = addslashes((isset($_POST['senha'])) ? $_POST['senha'] : '');

		// Utiliza uma função criada no seguranca.php pra validar os dados digitados
		if (validaUsuario($usuario, $senha) == true) {
			// armazena o tipo de usuario autenticado
			$_SESSION['tipoUsuario'] = "local";
			// O usuário e a senha digitados foram validados, manda pra página interna
			header("Location: ../../principal.php");
		} 
		else {
			// O usuário e/ou a senha são inválidos, manda de volta pro form de login
			// Para alterar o endereço da página de login, verifique o arquivo seguranca.php
			//expulsaVisitante();

			echo "<script>alert('Usuario e senha incorretos!');location=\"../../index.php\";	</script>";
		}
}
else{ // se for do tipo usuario oauth2 (google ou facebook)
	
	//echo "<script>alert('Entrou na area de usuarios Oauth2!');</script>";
	
	// recebe "usuario" => $emailGoogle, "senha" => $idGoogle,
	$usuario = addslashes((isset($_SESSION['usuarioOauth2'])) ? $_SESSION['usuarioOauth2'] : '');
	$senha = addslashes((isset($_SESSION['senhaOauth2'])) ? $_SESSION['senhaOauth2'] : '');

	// O usuário e/ou a senha são inválidos, manda de volta pro form de login
	if(($usuario == '') || ($senha == ''))
		//echo "<script>alert('Usuario e senha incorretos!');location=\"../../index.php\";	</script>";
		echo "<script>alert('Usuario ou senha Oauth2 vazios!');</script>";
	else
		// O usuário e a senha digitados foram validados, manda pra página interna
		header("Location: ../../principal.php");
		//echo "<script>alert('Usuarios Oauth2 preenchidos, usuario: {$usuario}, senha: {$senha} enviar para principal.php!');</script>";
}


?>