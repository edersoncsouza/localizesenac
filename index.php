<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
        <title>LocalizeSenac</title>
        
    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    
    <link href="dist/css/login.css" rel="stylesheet" type="text/css"/>
		
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- Bootbox -->
	<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>	
<?php
session_start();
session_destroy();
?>	
	
    </head>

    <body>

		<div class="container">
			<div class="row">
				<div role="main">
					
					<div id="formulario">

						<legend id="legendaForm">LOGIN</legend>

						<img id="logo" src="dist/images/logo_LocalizeSenac_novo_small.png" alt="logotipo localizesenac"/>

						<form class= "loginForm" method="POST" action="dist/php/valida.php" accept-charset="UTF-8">

							<ul class="social-icons invert" style="margin-top:-15px; margin-bottom:-5px;">
								<li>
									<a href="https://www.facebook.com/dialog/oauth/?client_id=1622249498010646&redirect_uri=http%3A%2F%2Flocalizesenac.com/principal.php%2Fpublic%2Foauth%2Fprovider%2Ffacebook%2Ftype%2Fregister&scope=email" class="facebook social_login">
									</a>
								</li>
								<li>
									<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&amp;client_id=407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com&amp;redirect_uri=http%3A%2F%2Flocalizesenac.com/principal.php&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fplus.login&amp;state=55250354ae2de" class="googleplus social_login">
											 https://accounts.google.com/o/oauth2/auth?scope=email%20profile&state=security_token%3D138r5719ru3e1%26url%3Dhttps://oa2cb.example.com/myHome&redirect_uri=https%3A%2F%2Foauth2-login-demo.appspot.com%2Fcode&,response_type=code&client_id=812741506391.apps.googleusercontent.com&approval_prompt=force
									</a>
								</li> 
							</ul>
							<br>
							
							<input type="text" id="usuario" class="form-control" name="usuario" placeholder="Usuário" required>

							<br>

							<input type="password" id="senha" class="form-control" name="senha" placeholder="Senha" required>

							<br>

							<button type="submit" name="submit" class="btn btn-info btn-block" >OK</button>

							  <!-- Below we include the Login Button social plugin. This button uses
							  the JavaScript SDK to present a graphical Login button that triggers
							  the FB.login() function when clicked. -->


							<br><fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
							</fb:login-button>
							
							
						</form>
					</div>
					
				</div> <!-- role="main"> -->
			</div> <!-- class="row"> -->
		</div> <!-- class="container"> -->
	
    </body>
</html>