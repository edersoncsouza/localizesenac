<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
        <title>LocalizeSenac</title>
        
    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- <link href="style/normalize.css" rel="stylesheet" type="text/css"/> -->
    <link href="../dist/css/login.css" rel="stylesheet" type="text/css"/>

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
    </head>

    <body>

		<div class="container-fluid">
			<div class="row">
				<div role="main">
					
					<div id="formulario">

						<legend id="legendaForm">LOGIN</legend>

						<img id="logo" src="../dist/images/logo_LocalizeSenac_novo_small.png" alt="logotipo localizesenac"/>

						<form class= "loginForm" method="POST" action="valida.php" accept-charset="UTF-8">

							<ul class="social-icons invert" style="margin-top:-15px; margin-bottom:-5px;">
								<li>
									<a href="https://www.facebook.com/dialog/oauth/?client_id=1622249498010646&redirect_uri=http%3A%2F%2Flocalizesenac.com/principal.php%2Fpublic%2Foauth%2Fprovider%2Ffacebook%2Ftype%2Fregister&scope=email" class="facebook social_login">
									</a>
								</li>
								<li>
									<a href="https://accounts.google.com/o/oauth2/auth?response_type=code&amp;client_id=407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com&amp;redirect_uri=http%3A%2F%2Flocalizesenac.com/principal.php&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&amp;state=55250354ae2de" class="googleplus social_login">
									</a>
								</li> 
							</ul>
							<br>
							
							<input type="text" id="usuario" class="form-control" name="usuario" placeholder="Usuário">

							<br>

							<input type="password" id="senha" class="form-control" name="senha" placeholder="Senha">

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
		
	<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		
    </body>
</html>