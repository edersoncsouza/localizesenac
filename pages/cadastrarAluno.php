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
	
<?php
include('configBanco.php'); 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `aluno` ( `matricula` ,  `senha` ,  `nome` ,  `celular` ,  `email` ,  `ativo`  ) VALUES(  '{$_POST['matricula']}' ,  '{$_POST['senha']}' ,  '{$_POST['nome']}' ,  '{$_POST['celular']}' ,  '{$_POST['email']}' ,  '{$_POST['ativo']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Aluno incluído.<br />"; 
echo "<a href='listarAluno.php'>Voltar para listagem de Alunos</a>"; 
} 
?>
	
</head>

<body>

<div class="container">

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<form role="form" action='' method='POST'>
			<h2>LocalizeSenac <small>Cadastro de Alunos</small></h2>
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
                        <input type="text" name="matricula" id="first_name" class="form-control input-lg" placeholder="Matrícula" tabindex="1">
					</div>
				</div>

			</div>
			
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="senha" id="senha" class="form-control input-lg" placeholder="Senha" tabindex="2">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="confirma_senha" id="confirma_senha" class="form-control input-lg" placeholder="Repita a Senha" tabindex="3">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
                        <input type="text" name="nome" id="nome" class="form-control input-lg" placeholder="Nome" tabindex="4">
					</div>
				</div>
			</div>

			<div class="form-group">
				<input type="email" name="email" id="email" class="form-control input-lg" placeholder="E-mail" tabindex="5">
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<input type="tel" required="required" maxlength="15" name="celular" id="celular" class="form-control input-lg" placeholder="Celular" />
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div>
						<label >
							<input type="radio" id="ativado" name="ativo" value="S" /> Ativado
						</label> 
						<label >
							<input type="radio" id="desativado" name="ativo" value="N" /> Desativado
						</label>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-6 col-md-6"><input type="submit" value="Cadastrar Aluno" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
				<div class="col-xs-6 col-md-6"><input value="Voltar" class="btn btn-danger btn-block btn-lg"></div>
				<input type='hidden' value='1' name='submitted' /> 
			</div>
		</form>
	</div>

	<div class="form-group">


<!--
		<form action='' method='POST'> 
		
			<p><b>Matricula:</b><br /><input type='text' name='matricula'/> 
			<p><b>Senha:</b><br /><input type='text' name='senha'/> 
			<p><b>Nome:</b><br /><input type='text' name='nome'/> 
			<p><b>Celular:</b><br /><input type='text' name='celular'/> 
			<p><b>Email:</b><br /><input type='text' name='email'/> 
			<p><b>Ativo:</b><br /><input type='text' name='ativo'/> 
			<p><input class="btn btn-success" type='submit' value='Cadastrar Aluno' />
			<input type='hidden' value='1' name='submitted' /> 

		</form> 
-->
	</div>


</div>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script src="../bower_components/jasny/js/inputmask.js" type="text/javascript"></script>	
	
</body>

</html>