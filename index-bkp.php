<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LocalizeSenac - Sistema de Indoor Mapping para a Faculdade Senac Porto Alegre">
	<meta name="keywords" content="Indoor Mapping,mapeamento interno,Faculdade Senac Porto Alegre">
    <meta name="author" content="Ederson Souza">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

	<?php
		session_start();
		session_destroy();
	?>
	
    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    
    <link href="dist/css/login.css" rel="stylesheet" type="text/css"/>

	<!-- jQuery -->
    <script type="text/javascript" src="dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Bootbox -->
	<script type="text/javascript" src="dist/components/bootbox/dist/js/bootbox.min.js"></script>	

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    </head>

	<script>
		function forgetpassword(){
			$('#formulario').hide();
			$('#recuperacao').show();
		}
	</script>
	
    <body>

		<div class="container">
			<div class="row">
				<div role="main">
					
					<div id="recuperacao" style="display:none;">
						<legend id="legendaForm">RECUPERAÇÃO DE SENHA</legend>
						
						<img id="logo" src="dist/images/logo_LocalizeSenac_novo_small.png" alt="logotipo localizesenac"/>
						
						<form class= "loginForm" action="" method="post" id="passwd" accept-charset="UTF-8">
						
							<input type="email" id="email" class="form-control" name="email" placeholder="E-mail de cadastro" required>

							<input name="action" type="hidden" value="password" />
							<br>
							<button type="submit" name="submit" class="btn btn-info btn-block" >Resetar a senha</button>

						</form>
						  
					</div>
					
					<div id="formulario">

						<legend id="legendaForm">LOGIN</legend>

						<img id="logo" src="dist/images/logo_LocalizeSenac_novo_small.png" alt="logotipo localizesenac"/>

						<form class= "loginForm" method="POST" action="dist/php/valida.php" accept-charset="UTF-8">

							<ul class="social-icons invert" style="margin-top:-15px; margin-bottom:-5px;">
								<li>
									<a href="https://www.facebook.com/dialog/oauth/?client_id=1622249498010646&redirect_uri=http%3A%2F%2Flocalhost:8080/projetos/localizesenac/Facebook/fbconfig.php%2Fpublic%2Foauth%2Fprovider%2Ffacebook%2Ftype%2Fregister&scope=email" class="facebook social_login">
									</a>
								</li>
								<li>
									<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&amp;client_id=407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com&amp;redirect_uri=http%3A%2F%2Flocalhost:8080/projetos/localizesenac/auth.php&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.login+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fcalendar+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.me&amp;state=55250354ae2de" class="googleplus social_login">
									</a>
								</li> 
							</ul>
							<br>
							
							<input type="text" id="usuario" class="form-control" name="usuario" placeholder="Usuário" required>

							<br>

							<input type="password" id="senha" class="form-control" name="senha" placeholder="Senha" required>

							<br> <a href="#forget" onclick="forgetpassword();" id="forget">Esqueceu sua senha?</a> <br>

							<button type="submit" name="submit" class="btn btn-info btn-block" >OK</button>
												
						</form>
					</div>
					
				</div> <!-- role="main"> -->
			</div> <!-- class="row"> -->
		</div> <!-- class="container"> -->
	
    </body>
</html>