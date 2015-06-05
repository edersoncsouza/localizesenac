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
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	//imprimeSessao();
?>
	
    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="dist/js/funcoes.js"></script>
	
</head>
	<body>
	
		<form name="" action="" method="">
			
			<table class="table table-hover">
					<thead>
						<th> DIA DA SEMANA </th>
						<th> DATA DE INICIO </th>
						<th> DATA FINAL</th>
						<th> DESCRIÇÃO </th>
						<th> UNIDADE </th>
						<th> SALA </th>
						<th> XXX </th>
					</thead>

					<tr class="dif">
						<td > A </td>
						<td > B </td>
						<td > C <i class="fa fa-lock fa-2x"></i> </td>
						<td > D <i class="fa fa-lock fa-2x"></i> </td>
						<td > E <i class="fa fa-lock fa-2x"></i> </td>
						<td > F <i class="fa fa-lock fa-2x"></i> </td>
						<td > <i class="fa fa-pencil-square-o fa-2x" data-toggle="tooltip" title="Editar"></i> <i class="fa fa-minus-square-o fa-2x" data-toggle="tooltip" title="Excluir"></i> </td>
					</tr>

					
			</table>
			
		</form>
		
	</body>
</html>
