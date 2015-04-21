<!--
PARA PREENCHER OS SELECTS: http://www.plus2net.com/php_tutorial/disable-drop-down.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
<?php
/*
		<!-- formValidation -->
        <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"/>

        <!-- Configuracao para validação dos formularios -->
        <script type="text/javascript" src="dist/js/configFormValidation.js" />
*/

	include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	
	/*
	If (isSet($_SESSION)){
		echo "sessão iniciada";

		echo "<br>id de usuário: ".$_SESSION['usuarioID'];
	}
	else{
		echo "sessão não iniciada";
	}
	*/
	//echo $_SESSION['id'];
	
	echo "<script> var idP = {$_SESSION['usuarioID']}; </script>";
	
	$sql = "SELECT nome, email, celular FROM aluno WHERE id=".$_SESSION['usuarioID'];
	
	$result = mysql_query($sql, $_SESSION['conexao']);
	
	while ($row = mysql_fetch_assoc($result)) {
		$nome = $row['nome'];
		$email = $row['email'];
		$celular = $row['celular'];
	}
?>			
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
		
		<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
		<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Bootbox -->
		<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>
		

        <script>
		$(document).ready(function(){
			// carrega a pagina com a lista dos dias da semana e disciplinas
			$("#minhaGrade").load("calendarioSemana.php");
			
			// mascara para o celular
			$('#celular').inputmask('(99) 9999-9999[9]');
			
			// captura o evento onChange do select box curso
			$('#curso').on('change', function() {
			  
			  var cursoP = this.value; // armazena o id do curso
			  
			  montarGrade(cursoP); // chama a funcao para montar a grade
			  
			});
		
			// captura a alteracao no value do input de andar
			//$('#andar').on('change', function() {
			$("input[type='number']").bind("input", function() {
			  
			  $('#salas').empty(); // zera os itens previos do select sala
			  var andarP = this.value; // armazena o id do curso
			  var unidadeP = $("#unidade").val();

			  montarAndar(andarP, unidadeP); // chama a funcao para montar a grade
			  
			});
		
			// captura o evento onChange do select box unidade
			$('#unidade').on('change', function() {
				
				$('#salas').empty(); // zera os itens previos do select sala
				$("input[type='number']").val(-1); // recebe o valor atual de andar
				//alert("unidade foi mudada");
				//$("input[type='number']").val(andar); // atualiza o mesmo para disparar a atualizacao de salas
				
			});
		
            // captura o evento submit do formMudaSenha e chama a funcao atualizaSenha
            $("#formMudaSenha").submit(function (event) {
                
				event.preventDefault(); // impede o submit

				//var idP = <?php $_SESSION['usuarioID'];?>; // esta informação esta sendo trazida no start do PHP
				var senhaAtualP = $("#passwordAtual").val(); // recebe o valor do input de senha atual
				var senhaP = $("#password").val(); // recebe o valor de input de nova senha
				var senhaConfirmacao = $("#password2").val();
				
				// verifica se a confirmacao de senha esta OK
				if(senhaP!=senhaConfirmacao){
					bootbox.alert('As novas senhas não conferem!');
				}
				else			
					atualizaSenha(senhaAtualP, senhaP); // chama a funcao para atualizar a senha
            });
			
			// captura o evento submit do formMudaInfo e chama a funcao atualizaInfo
            $("#formMudaInfo").submit(function (event) {
                
				event.preventDefault(); // impede o submit

				//var idP = <?php $_SESSION['usuarioID'];?>; // esta informação esta sendo trazida no start do PHP
				var nomeP = $("#nome").val(); // recebe o valor do input de nome
				var emailP = $("#email").val(); // recebe o valor de input de email
				var celularP = $("#celular").val(); // recebe o valor de input de celular
				var emailConfirmacao = $("#confirmaEmail").val();
				
				// verifica se a confirmacao de email esta OK
				if(emailP!=emailConfirmacao){
					bootbox.alert('Os emails não conferem!');
				}
				else			
					atualizaInfo(nomeP, emailP, celularP); // chama a funcao para atualizar as informacoes
            });

		});

			// funcao que executa o post do curso para montar o select de disciplinas por jQuery
			function montarGrade(cursoP){

				var url = "dist/php/montarGrade.php";
				
				$('#disciplina').empty(); // zera os itens previos de select
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ curso: cursoP }, function(json) {
					
					if (json == 0){// caso o retorno de montarGrade.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
							var objJson = JSON.parse(json); // transforma a string recebida em objeto
							var listaItens; // cria uma lista de itens para inserir uma única vez
							
							$.each(objJson, function(index, value) { // para cada objeto da lista armazena na string
								listaItens += '<option>' + value + '</option>';
							});
							
							$('#disciplina').append(listaItens); // faz enxerta o conteudo da select disciplina
					}
				});
			}
		
			// funcao que executa o post do andar para montar o select de salas por jQuery
			function montarAndar(andarP, unidadeP){

				var url = "dist/php/montarAndar.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ andar: andarP, unidade: unidadeP}, function(json) {
					
					if (json == 0){// caso o retorno de montarGrade.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
							var objJson = JSON.parse(json); // transforma a string recebida em objeto
							var listaItens; // cria uma lista de itens para inserir uma única vez
							
							$.each(objJson, function(index, value) { // para cada objeto da lista armazena na string
								listaItens += '<option>' + value + '</option>';
							});
							
							$('#sala').append(listaItens); // faz enxerta o conteudo da select disciplina
					}
				});
			}
		
			// funcao que executa o post da id, da senha atual e da nova senha para modificar por jQuery
			function atualizaSenha(senhaAtualP, senhaP){

				var url = "dist/php/mudarSenha.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ id: idP, passwordAtual: senhaAtualP,  password: senhaP}, function(result) {

					if (result == 1){// caso o retorno de mudarSenha.php seja = 1, o processo foi OK
						bootbox.alert('Senha alterada com sucesso!');
						
						$("#passwordAtual").val(''); // zera os valores dos inputs de senha
						$("#password").val('');
						$("#password2").val('');
					}
					else{
						bootbox.alert('A senha não pode ser alterada!');
					}
					
				});
				
			}
			
			// funcao que executa o post da id, da senha atual e da nova senha para modificar por jQuery
			function atualizaInfo(nomeP, emailP, celularP){

				var url = "dist/php/mudarInfo.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ id: idP, nome: nomeP, email: emailP,  celular: celularP}, function(result) {

					if (result == 1){// caso o retorno de mudarInfo.php seja = 1, o processo foi OK

						bootbox.alert('Informações atualizadas com sucesso!', function() {// apos OK executa a funcao
						  location.reload();
						});

					}
					else{
						bootbox.alert('A informações não foram alteradas!');
					}
					
				});
				
			}
        </script>
    </head>

    <body>

        <div class="panel-group" >

            <div class="panel panel-primary" >

                <!-- Minhas Aulas -->

                <div class="panel-heading">

                    <!-- Disciplinas -->
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-cogs fa-5x">
                            </i>
                        </div>
                        <div class="col-xs-9 text-right">

                            <div>
                                <h3> CONFIGURAÇÕES DO USUÁRIO </h3>
								<br> <?php echo $nome; ?> <i class="fa fa-user fa-fw"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer" id="pills">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active">
                            <a href="#perfil" data-toggle="pill">
                                <i class="fa fa-user fa-2x">
                                </i>
                                PERFIL
                            </a>
                        </li>
                        <li>
                            <a href="#seguranca" data-toggle="pill">
                                <i class="fa fa-lock fa-2x">
                                </i>
                                SEGURANÇA
                            </a>
                        </li>
                        <li>
                            <a href="#academico" data-toggle="pill">
                                <i class="fa fa-calendar fa-2x">
                                </i>
                                ACADÊMICO
                            </a>
                        </li>

                    </ul>
                </div>
            </div> 
        </div>
        <!-- panel-footer Pills>
        -->

        <div class="tab-content">
            <div class="tab-pane active" id="perfil">
                <p class="TabContent" >
                    <form id="formMudaInfo" action="#" title="Modificar as informações pessoais" method='POST' > 
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MODIFICAR AS INFORMAÇÕES PESSOAIS 
							</h4>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12" >
							<div class="form-group">
								<input
									type="text"
									name="nome"
									id="nome"
									title="Nome completo"
									placeholder="Nome completo"
									class="form-control input-lg"
									tabindex="1"
									value='<?php echo $nome; ?>'
									required
								>
							</div>
						</div>
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="email"
									name="email"
									id="email"
									title="E-mail"
									placeholder="E-mail"
									class="form-control input-lg"
									tabindex="2"
									value='<?php echo $email; ?>'
									required
								>
							</div>
						</div>
					

					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="email"
									name="confirmaEmail"
									id="confirmaEmail"
									title="Confirme o E-mail"
									placeholder="Confirme o E-mail"
									class="form-control input-lg"
									tabindex="3"
									value='<?php echo $email; ?>'
									required
								>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="text"
									name="celular"
									id="celular"
									title="Celular"
									placeholder="Celular"
									class="form-control input-lg" 
									tabindex="4"
									value='<?php echo $celular; ?>'
									required="required" maxlength="15"
									data-inputmask="'alias':'celular'"
								/>

							</div>
						</div>
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<br>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<input id="salvaInfo" type="submit" value="Salvar" class="btn btn-success btn-block btn-lg" >
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6">
								<input type="button" value="Sair" class="btn btn-danger btn-block btn-lg" data-dismiss="modal" data-target="#configModal">
							</div>
						</div> 
					
					</form>

                </p>
            </div>

            <div class="tab-pane" id="seguranca">
                <p class="TabContent">

					<form id="formMudaSenha" action="#" title="Modificar a Senha" method='POST'> 

						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MODIFICAR A SENHA 
							</h4>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input 
									type="password"
									name="passwordAtual"
									id="passwordAtual"							
									title="Senha atual: de 6 a 10 caracteres"
									placeholder="Senha atual"
									class="form-control input-lg" 
									tabindex="1"
									required
									/>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input 
									type="password"
									name="password"
									id="password"							
									title="Nova senha: de 6 a 10 caracteres"
									placeholder="Nova senha"
									class="form-control input-lg" 
									tabindex="2"
									required
									/>
							</div>
						</div>


						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input     
									type="password"
									name="password2"
									id="password2"
									title="Confirmação de senha"
									placeholder="Confirme a nova senha"
									class="form-control input-lg"
									tabindex="3"
									required
									/>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<br>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<input id="salvaSenha" type="submit" value="Salvar" class="btn btn-success btn-block btn-lg" >
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6">
								<input type="button" value="Voltar" class="btn btn-danger btn-block btn-lg">
							</div>
						</div> 
					</form>
                </p>
            </div>


            <div class="tab-pane" id="academico">
                <p class="TabContent">
				
					<form role="form">
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MONTAR A GRADE DE AULAS DO SEMESTRE 
							</h4>
						</div>
						
						<div id="minhaGrade">
						<!-- AREA DE EXIBICAO DAS SALAS POR DIA DA SEMANA -->
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<label for="curso">Nome do curso:</label>
									<select class="form-control" id="curso" ><!-- onchange=atualizaDisciplina(); -->
										<?php
											$sql2="SELECT id, descricao FROM curso order by descricao";
											
											$result2 = mysql_query($sql2, $_SESSION['conexao']);
											
											echo "<option value=0></option>"; 
											
											while ($row = mysql_fetch_assoc($result2)) {
												
												echo "<option value=$row[id]>$row[descricao]</option>"; 
											
											}
										?>
									</select>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<label for="disciplina">Disciplina:</label>
									<select class="form-control" id="disciplina"></select>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<label for="unidade">Unidade Senac:</label>
									<select class="form-control" id="unidade">
										<?php
											$sql3="SELECT id, nome, endereco FROM unidade order by nome";
											
											$result3 = mysql_query($sql3, $_SESSION['conexao']);
											
											while ($row = mysql_fetch_assoc($result3)) {
												
												echo "<option value=$row[id]>$row[nome] -  $row[endereco]</option>"; 
											
											}
										?>
									</select>
							</div>
						</div>
						
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="andar">Andar:</label>
								<input class="form-control" name="andar" type="number" min="0" max="10">
							</div>
						</div>
						
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<label for="sala">Sala:</label>
									<select class="form-control" id="sala"></select>
							</div>
						</div>
						
					</form>
				
                </p>
				
            </div>

        </div>
		
    </body>

	<!-- NAO REMOVER, COLOCADO AQUI PARA CONSERTAR O DROPDOWN QUE PARAVA DE FUNCIONAR DEPOIS DE APRESENTAR O MODAL -->
		<!-- Bootstrap Core JavaScript -->
		<!-- <script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script> -->

</html>