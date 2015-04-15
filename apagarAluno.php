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
include('configBanco.php'); 
$id = (int) $_GET['id']; 
mysql_query("DELETE FROM `aluno` WHERE `id` = '$id' ") ; 
echo (mysql_affected_rows()) ? "Aluno apagado.<br /> " : "Nada apagado.<br /> "; 
?> 

<a href='listarAluno.php'>Voltar a listagem de Alunos</a>

</body>

</html>