<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
</head>

<body>



<?php
include('dist/php/configBanco.php'); 
if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `aluno` SET  `matricula` =  '{$_POST['matricula']}' ,  `senha` =  '{$_POST['senha']}' ,  `nome` =  '{$_POST['nome']}' ,  `celular` =  '{$_POST['celular']}' ,  `email` =  '{$_POST['email']}' ,  `ativo` =  '{$_POST['ativo']}'   WHERE `id` = '$id' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Aluno editado.<br />" : "Nada modificado. <br />"; 
echo "<a href='listarAluno.php'>Voltar a listagem de Alunos</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `aluno` WHERE `id` = '$id' ")); 
?>

<form action='' method='POST'> 
<p><b>Matricula:</b><br /><input type='text' name='matricula' value='<?= stripslashes($row['matricula']) ?>' /> 
<p><b>Senha:</b><br /><input type='text' name='senha' value='<?= stripslashes($row['senha']) ?>' /> 
<p><b>Nome:</b><br /><input type='text' name='nome' value='<?= stripslashes($row['nome']) ?>' /> 
<p><b>Celular:</b><br /><input type='text' name='celular' value='<?= stripslashes($row['celular']) ?>' /> 
<p><b>Email:</b><br /><input type='text' name='email' value='<?= stripslashes($row['email']) ?>' /> 
<p><b>Ativo:</b><br /><input type='text' name='ativo' value='<?= stripslashes($row['ativo']) ?>' /> 
<p><input type='submit' value='Editar Aluno' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<?php } ?>

</body>

</html>