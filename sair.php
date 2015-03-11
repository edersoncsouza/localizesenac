<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>LocalizeSenac</title>

<link rel="stylesheet" href="style/bootstrap.css" />
<link rel="stylesheet" href="style/bootstrap_theme.css" />

<style type="text/css">
<!--
.Style6 {font-size: 13px}
-->
</style>
</head>

<body style="background:  rgb(17, 104, 149);">


<div class="container" style="margin: 80px auto;  width: 640px; ">
    <div class="row">
	<div style="color:white"> 
	<CENTER><img src="images/logo_LocalizeSenac_novo.png" height="184" width="340">
	<?php
		include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
		echo"<br>";
		echo "Sessão encerrada, pelo usuário: " . $_SESSION['usuarioNome'] ;
		unset($_SESSION['usuarioNome']); // Deleta uma variável da sessão
		session_destroy(); // Destrói toda sessão
                header("Location: index.php");
	?>
	
	
	
	
	</CENTER>
	</div>
	
	</div>
</div>


</body>
</html>