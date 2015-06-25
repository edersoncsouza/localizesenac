<!--								

PENDENCIAS LOCAIS:

-->

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
	verificaPerfil();
?>			

		<!-- Bootstrap Core CSS -->
        <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
        <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		
		<!-- Custom CSS -->
		<link href="dist/css/sb-admin-2.css" rel="stylesheet">
		
		<!-- CSS para animacoes Ajax -->
		<link href="dist/css/ajax.css" rel="stylesheet">
		
	    <!-- jQuery -->
        <script src="dist/components/jquery/dist/jquery.min.js"></script>
		
		<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
		<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Bootbox -->
		<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>

    <script src="dist/components/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="dist/components/datatables-tabletools/js/dataTables.tableTools.js" type="text/javascript"></script>
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="dist/components/datatables/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="dist/components/datatables-editable/js/jquery.jeditable.js" type="text/javascript"></script>
    <script src="dist/components/datatables-editable/js/jquery.dataTables.editable.min.js" type="text/javascript"></script>
	<script src="dist/components/jquery-validate/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="dist/components/jquery-validate/js/additional-methods.js" type="text/javascript"></script> 
	
					<!-- formValidation -->
        <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"/>

        <!-- Configuracao para validação dos formularios -->
        <script type="text/javascript" src="dist/js/configFormValidation.js" />
		
		<!-- funcoes personalizadas -->
		<script type="text/javascript" src="dist/js/funcoes.js"></script>
		
<script>
	$(document).ready(function(){
		//$("#conteudoEventosAcademicos").load("listaEventosAcademicos.html");
		$("#conteudoAdministracaoUsuarios").load("listaAlunos.html");
		//$("#conteudoSalaMapa").load("desenharSalas.php");
	/*
		// ao clicar nos botoes de sair encaminha de volta ao principal.php
		$('#sairSenha, #sairInfo, #sairDisciplina').click( function() {
			var url = "principal.php";
			$("body").load(url);
		});
	*/
	
			$('#enviaFormulario').click(function() {
			
			// armazena as datas em formato dd/mm/aaaa
			var dataInicio = $('#dataInicio').val();
			var dataFinal = $('#dataFinal').val();
			
			if (!/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/.test(dataInicio)) {
				// desmembra, inverte a data e muda o separador para formatar em aaaa-mm-dd
				var dataInicioFormatada = dataInicio.split("/").reverse().join("-");
				// armazena a data formatada no imput do formulario
				$('#dataInicio').val(dataInicioFormatada);
			}
			if (!/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/.test(dataFinal)) {
				// desmembra, inverte a data e muda o separador para formatar em aaaa-mm-dd
				var dataFinalFormatada = dataFinal.split("/").reverse().join("-");
				// armazena a data formatada no imput do formulario
				$('#dataFinal').val(dataFinalFormatada);
			}
			
			// efetua o submit do formulario
			$('formAddNewRow').submit();
			
		});
	
	
	$('#formAddNewRow').formValidation({
		framework: 'bootstrap',
    	excluded: [':disabled'],
		message: 'Este não é um valor válido',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			horaInicio: {
				validators: {
					notEmpty: {
						message: 'O horário é obrigatório'
					},
					regexp: {
                        regexp: /^([1-9]|1[0-2]):[0-5]\d(:[0-5]\d(\.\d{1,3})?)?$/,
                        message: 'O horário deve estar no formato hh:mm:ss'
                    }
				}
			}
			
		}
    });


	
	});	
	
		// ao clicar nos botoes de sair encaminha de volta ao principal.php
		$('#sairAdm').click( function() {
			var url = "principal.php";
			$("body").load(url);
		});
</script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		
    </head>

    <body>
	
		<div class="modal"></div>
		
        <div class="panel-group">

            <div id="painelAdministrador" class="panel panel-primary" >

                <!-- Minhas Aulas -->

                <div id="painelAdministrador" class="panel-heading">

                    <!-- Disciplinas -->
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-cogs fa-5x">
                            </i>
                        </div>
                        <div class="col-xs-9 text-right">

                            <div>
                                <h3> PAINEL DE ADMINISTRAÇÃO </h3>
								<br> <?php //echo $nome; ?> <!-- <i class="fa fa-user fa-fw"></i> -->
								
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer" id="pills">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active">
						    <a href="#usuarios" class="usuarios" data-toggle="pill">
                                <i class="fa fa-users fa-2x">
                                </i>
                                USUÁRIOS
                            </a>
                        </li>
                        <!--<li>
                            <a href="#seguranca" data-toggle="pill">
                                <i class="fa fa-lock fa-2x">
                                </i>
                                SEGURANÇA
                            </a>
                        </li>-->
                        <li >
                            <a  href="#evento" onclick="window.open('listaEventosAcademicos.html', 'child', 'fullscreen=yes');" class="eventos" data-toggle="pill"> 
                                <i class="fa fa-calendar fa-2x">
                                </i>
                                EVENTOS
                            </a>
                        </li>
						<li >
                            <a  href="#salaMapa" onclick="window.open('desenharSalas.php', 'child', 'fullscreen=yes'); return false" class="salaMapa" data-toggle="pill"> <!-- href="#salaMapa" -->
                                <i class="fa fa-codepen fa-2x">
                                </i>
                                SALAS
                            </a>
                        </li>
						<!--
						<li >
                            <a href="#icloud" class="icloud" data-toggle="pill">
                                <i class="fa fa-mobile fa-2x">
                                </i>
                                ICLOUD
                            </a>
                        </li>
						-->
                    </ul>
                </div>
            </div> 
        </div>
        <!-- panel-footer Pills>
        -->

        <div class="tab-content">

            <div class="tab-pane active" id="usuarios">
                <p class="TabContent">
						<!--
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								ADMINISTRAÇÃO DE USUÁRIOS DO PORTAL SENAC 
							</h4>
						</div>
						-->
					<form id="formAdministracaoUsuarios" action="#" title="Administrar Usuarios" method=''> 	
						<div id="conteudoAdministracaoUsuarios" class="col-xs-12 col-sm-12 col-md-12">
						<!-- carrega aqui o conteudo de listaAlunos.html -->
						</div>
					</form>
                </p>
				
            </div>
			
            <!--<div class="tab-pane" id="seguranca">
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
								<input id="sairSenha" type="button" value="Sair" class="btn btn-danger btn-block btn-lg">
							</div>
						</div> 
					</form>
					
                </p>
            </div>-->

            <div class="tab-pane" id="evento">
                <p class="TabContent">

					<form id="formEventosAcademicos" action="#" title="Modificar Eventos Academicos" method=''> 
					
						<div id="conteudoEventosAcademicos" class="col-xs-12 col-sm-12 col-md-12">
						<!-- carrega aqui o conteudo de listaEventosAcademicos.html -->
						</div>
					
					</form>
					
                </p>
				
            </div>
			


			<div class="tab-pane" id="salaMapa">
			
                <p  class="TabContent">
				
						<div  class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								EDIÇÃO DE SALAS 
							</h4>
						</div>
						
						<form id="formMudaSala" role="form">
							
						</form>
						
						<div id="conteudoSalaMapa" class="col-xs-12 col-sm-12 col-md-12">
							<!-- carrega aqui o conteudo de desenharSalas.php -->
						</div>
				</p>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<!-- <input id="sairInfo" type="button" value="Sair" class="btn btn-danger btn-block btn-lg" data-dismiss="modal" data-target="#configModal"> -->
				<button type="button" id="sairAdm" value="Sair" class="btn btn-primary btn-block btn-lg" data-dismiss="modal" data-target="#configModal" style="white-space: normal; padding-right:2px; padding-left:2px;"> <i class="fa fa-home"></i> Voltar</button>
			</div>
			
        </div>

    </body>

</html>