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

							<input type="text" id="usuario" class="form-control" name="usuario" placeholder="Usuário">

							<br>

							<input type="password" id="senha" class="form-control" name="senha" placeholder="Senha">

							<br>

							<button type="submit" name="submit" class="btn btn-info btn-block" >OK</button>

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