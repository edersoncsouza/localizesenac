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
    include("calculaCentroPoligono.php"); // Inclui o arquivo com o sistema de segurança
	?>	

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div class="form-group">

<? 
include('config.php'); 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `aluno` ( `matricula` ,  `senha` ,  `nome` ,  `celular` ,  `email` ,  `ativo`  ) VALUES(  '{$_POST['matricula']}' ,  '{$_POST['senha']}' ,  '{$_POST['nome']}' ,  '{$_POST['celular']}' ,  '{$_POST['email']}' ,  '{$_POST['ativo']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Added row.<br />"; 
echo "<a href='list.php'>Back To Listing</a>"; 
} 
?>

<form action='' method='POST'> 
<p><b>Matricula:</b><br /><input type='text' name='matricula'/> 
<p><b>Senha:</b><br /><input type='text' name='senha'/> 
<p><b>Nome:</b><br /><input type='text' name='nome'/> 
<p><b>Celular:</b><br /><input type='text' name='celular'/> 
<p><b>Email:</b><br /><input type='text' name='email'/> 
<p><b>Ativo:</b><br /><input type='text' name='ativo'/> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 

</div>

<?php
  if (isset($_POST['submit'])) {
    $pos1 = $_POST['pos1'];
    $pos2 = $_POST['pos2'];
	$pos3 = $_POST['pos3'];
    $pos4 = $_POST['pos4'];

	$arrayPosicoes = array($pos1, $pos2, $pos3, $pos4);
	
	echo "</br>";
	print_r($arrayPosicoes);
	
	$result = GetCenterFromDegrees($arrayPosicoes);
	
	echo "</br>";
	echo "</br>";
	echo "CENTRO: ";

	print_r( $result);
	
  }
?>

</body>

</html>