<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- formValidation -->
    <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
    <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"></script>
    <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"></script>
	
	<!-- Configuracao para validação dos formularios -->
	<script type="text/javascript" src="dist/js/configFormValidation.js"></script>
	
	<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
	<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>

<script>	

	$(document).ready(function(){
		
		// evento onclick do botão Novo Aluno abre o modal
		$('#addAluno').click(function () {
			$('#addModal').modal({
				show: true
			});
		});
		
		// chama a funcao que preenche o formulario
		$('#embuxa').on('click', function(e){
			embuxa();
		});
		
		// mascara para o celular
		$('#celular').inputmask('(99) 9999-9999[9]');
		
		// captura o evento submit e chama a funcao insereAluno
		$( "#formAddNewRow" ).submit(function( event ) {
			event.preventDefault();
			insereAluno();
		});
		
	});
		
		function alerta(){
			bootbox.alert("Aluno incluido com sucesso!");
		}
		
		function alerta2(){
			alert("Sem bootbox - Aluno incluido com sucesso!");
		}
	
	// funcao que executa o post da id do aluno a excluir por jQuery
	function apagaAluno(idP){

		var url = "apagarAluno.php";
		
		$.post(url,{ id: idP }, function(result) {

			if (result == 1){
				bootbox.alert('Aluno excluido com sucesso');
			}
			else{
				alert('Falha ao excluir o aluno');
			}
			
			location.reload();
			
		});
		
	}
	
	// funcao que executa o POST do formulario por jQuery
	function insereAluno(){

		var url = "inserirAluno.php";
		
			$.post(url, $("#formAddNewRow").serialize(),function(result) {

				if (result == 1){
					//bootbox.alert('Aluno inserido com sucesso');
					alert("result: " + result);
					alert("Inserido - sem bootbox");
				}
				else{
					alert("result: " + result);
					//bootbox.alert('Falha ao inserir o aluno');
				}
				
				//location.reload();
				
			});
		
	}
	
	// funcao pra preencher o formulario de aluno
	function embuxa(){
		// variaveis teste para preenchimento do formulario
		var fMatricula='777777', fSenha='123456', fNome='Teste da Silva', fCelular='51999988888', fEmail='teste@teste',  fAtivo=1;
		$( "#matricula" ).val(fMatricula);
		$( "#password" ).val(fSenha);
		$( "#password2" ).val(fSenha);
		$( "#nome" ).val(fNome);
		$( "#celular" ).val(fCelular);
		$( "#email" ).val(fEmail);
		$( "#confirmaEmail" ).val(fEmail);
		$('input:radio[name="ativo"][value="S"]').attr('checked',true);
		
	}

	
</script>

<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
?>



</head>

<body>


<!-- MODAL DO FORMULARIO DE INSCLUSAO DE ALUNO -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
		
		<a href="#" id="embuxa" class="btn btn-success">Embuxa</a>
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="addModalLabel">Incluir Aluno</h4>
			</div>

			<form id="formAddNewRow" action="#" title="Incluir um novo Aluno" method='POST'>	
				<div class="modal-body">

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
							<div class="modal-footer">
								<div class="col-xs-6 col-md-6"><input type="submit" value="Cadastrar Aluno" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
								<div class="col-xs-6 col-md-6"><input value="Voltar" data-dismiss="modal" class="btn btn-danger btn-block btn-lg"></div>
							</div>
						<!-- <input type='hidden' value='1' name='submitted' />  -->
					</div>
				
				</div>
			</form>
		</div>
	</div>
</div>

<?php
echo "<div class=\"container\">";
echo "<div class=\"row\">";
echo "<h3>Listagem de Alunos</h3>";
echo "</div>";
echo "<div id=\"rowTabela\" class=\"row\">";
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

// query para montar a tabela de alunos
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
	echo 	"<td valign='top'>
				<a id=\"botaoEditar\" class=\"btn btn-primary\" href=editarAluno.php?id={$row['id']} > <i class=\"fa fa-edit fa-lg\"> </i>Editar</a>
			</td>
			<td>
				<a 
					id=\"botaoExcluir\" 
					class=\"btn btn-danger\" 
					onclick=\"apagaAluno({$row['id']});\" 	> 
					
					<i class=\"fa fa-times-circle fa-lg\" style:\"color:red;\"></i>
					Excluir
				</a>
			</td> "; 
	echo "</tr>";

} 


echo "</tbody>";
echo "</table>"; 
echo "</div>"; //row da table


?>

<a href="#" id="addAluno" class="btn btn-success">Novo Aluno</a>


</body>

</html>