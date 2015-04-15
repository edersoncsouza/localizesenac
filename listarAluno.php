<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
</head>

<body>


<?php
include('configBanco.php');

echo "<div class=\"container\">";
echo "<div class=\"row\">";
echo "<h3>Listagem de Alunos</h3>";
echo "</div>";
echo "<div class=\"row\">";
echo "<table class=\"table table-striped table-bordered\">"; 
//echo "<table border=1 >"; 
echo "<thead>";
echo "<tr>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Matricula</b></td>"; 
echo "<td><b>Senha</b></td>"; 
echo "<td><b>Nome</b></td>"; 
echo "<td><b>Celular</b></td>"; 
echo "<td><b>Email</b></td>"; 
echo "<td><b>Ativo</b></td>"; 
echo "</tr>";

echo "</thead>";
echo "<tbody>";

$result = mysql_query("SELECT * FROM `aluno`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['matricula']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['senha']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['nome']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['celular']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['email']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['ativo']) . "</td>";  
echo "<td valign='top'><a class=\"btn btn-primary\"href=editarAluno.php?id={$row['id']}> <i class=\"fa fa-edit fa-lg\"> </i>Editar</a></td><td><a class=\"btn btn-danger\" href=apagarAluno.php?id={$row['id']}> <i class=\"fa fa-times-circle fa-lg\" style:\"color:red;\"></i> Apagar</a></td> "; 
echo "</tr>"; 
} 

echo "</tbody>";
echo "</table>"; 
echo "</div>"; //row da table
echo "<a href=cadastrarAluno.php class=\"btn btn-success\">Novo Aluno</a>"; 

?>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>