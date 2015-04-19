<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- formValidation -->
    <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
    <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"></script>
    <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"></script>
	
	<!-- Configuracao para validação dos formularios -->
	<script type="text/javascript" src="dist/js/configFormValidation.js"></script>
	
	<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
	<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>
	
<?php

    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);

//include('dist/php/configBanco.php'); 
	
if (isset($_POST['submitted'])) { 
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
	$sql = "INSERT INTO
				`aluno` ( `matricula` ,  `senha` ,  `nome` ,  `celular` ,  `email` ,  `ativo`  )
			VALUES(  '{$_POST['matricula']}' ,  '{$_POST['password']}' ,  '{$_POST['nome']}' ,  '{$_POST['celular']}' ,  '{$_POST['email']}' ,  '{$_POST['ativo']}'  ) "; 
			
	mysql_query($sql) or die(mysql_error()); 
	echo "Aluno incluído.<br />"; 
	echo "<a href='listarAluno.php'>Voltar para listagem de Alunos</a>"; 
} 

?>

			<script> 
			$(document).ready(function(){  
				$('#celular').inputmask('(99) 9999-9999[9]');
			});
			</script>

</head>

<body>

<div class="container">

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		
		<form id="formCadastraAluno" role="form" action='' method='POST'>
			<h2>LocalizeSenac <small>Cadastro de Alunos</small></h2>
			<hr class="colorgraph">
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
                        <input 
							type="text"
							name="matricula"
							id="matricula"
							title="Senha: de 4 a 30 caracteres"
							placeholder="Matrícula"
							class="form-control input-lg"
							tabindex="1"
							required
						>
					</div>
				</div>

			</div>
			
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input 
							type="password"
							name="password"
							id="password"							
							title="Senha: de 6 a 10 caracteres"
							placeholder="Senha"
							class="form-control input-lg" 
							tabindex="2"
							required
						>
					</div>
				</div>
				
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">	
						<input     
							type="password"
							name="password2"
							id="password2"
							title="Confirmação de senha"
							placeholder="Confirme a Senha"
							class="form-control input-lg"
							tabindex="3"
							required
						>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
                        <input
							type="text"
							name="nome"
							id="nome"
							title="Nome completo"
							placeholder="Nome completo"
							class="form-control input-lg"
							tabindex="4"
							required
						>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<input
							type="email"
							name="email"
							id="email"
							title="E-mail"
							placeholder="E-mail"
							class="form-control input-lg"
							tabindex="5"
							required
						>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<input
							type="email"
							name="confirmaEmail"
							id="confirmaEmail"
							title="Confirme o E-mail"
							placeholder="Confirme o E-mail"
							class="form-control input-lg"
							tabindex="6"
							required
						>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<input
							type="text"
							name="celular"
							id="celular"
							title="Celular"
							placeholder="Celular"
							class="form-control input-lg" 
							tabindex="7"
							required="required" maxlength="15"
							data-inputmask="'alias':'celular'"
						/>

					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div>
						<div class="form-group">
							<label >
								<input type="radio" id="ativado" name="ativo" value="S" /> Ativado
							</label> 
							<label >
								<input type="radio" id="desativado" name="ativo" value="N" /> Desativado
							</label>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<br>
				<div class="col-xs-6 col-md-6"><input type="submit" value="Cadastrar Aluno" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
				<div class="col-xs-6 col-md-6"><input value="Voltar" class="btn btn-danger btn-block btn-lg"></div>
				<input type='hidden' value='1' name='submitted' /> 
			</div>

		</form>
	</div>

	<div class="form-group">

	</div>


</div>


	
</body>

</html>