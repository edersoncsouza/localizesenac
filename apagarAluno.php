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
//include('dist/php/configBanco.php');

    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
$id = (int) $_GET['id']; 
mysql_query("DELETE FROM `aluno` WHERE `id` = '$id' ") ; 
echo (mysql_affected_rows()) ? "Aluno apagado." : "Nada apagado."; 

?> 

<a href='listarAluno.php'>Voltar a listagem de Alunos</a>

</body>

</html>