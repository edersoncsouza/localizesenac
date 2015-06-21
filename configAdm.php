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
/*
		<!-- formValidation -->
        <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"/>

        <!-- Configuracao para validação dos formularios -->
        <script type="text/javascript" src="dist/js/configFormValidation.js" />
*/

	include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("dist/php/funcoes.php");
	protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);

/*	
	echo "<script> var idP = {$_SESSION['usuarioID']}; </script>";
	
	$sql = "SELECT nome, email, celular FROM aluno WHERE id=".$_SESSION['usuarioID'];
	
	$result = mysql_query($sql, $_SESSION['conexao']);
	
	while ($row = mysql_fetch_assoc($result)) {
		$nome = $row['nome'];
		$email = $row['email'];
		$celular = $row['celular'];
	}
*/
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
		
		<!-- funcoes personalizadas -->
		<script type="text/javascript" src="dist/js/funcoes.js"></script>
		
<script>
	$(document).ready(function(){
		$("#conteudoEventosAcademicos").load("listaEventosAcademicos.html");
		$("#conteudoSalaMapa").load("desenharSalas.php");
	
		// ao clicar nos botoes de sair encaminha de volta ao principal.php
		$('#sairSenha, #sairInfo, #sairDisciplina').click( function() {
			var url = "principal.php";
			$("body").load(url);
		});
	
	
	});
	
	
	var hidWidth;
var scrollBarWidths = 40;

var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

$('.scroller-right').click(function() {
  
  $('.scroller-left').fadeIn('slow');
  $('.scroller-right').fadeOut('slow');
  
  $('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

  });
});

$('.scroller-left').click(function() {
  
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
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
				<div class="container">
                      <div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
  <div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
  <div class="wrapper">
					<ul class="nav nav-pills nav-justified">
                        <li class="active">
                            <a href="#evento" data-toggle="pill">
                                <i class="fa fa-calendar fa-2x">
                                </i>
                                EVENTOS
                            </a>
                        </li>
                        <li>
                            <a href="#seguranca" data-toggle="pill">
                                <i class="fa fa-lock fa-2x">
                                </i>
                                SEGURANÇA
                            </a>
                        </li>
                        <li >
                            <a href="#academico" class="academico" data-toggle="pill">
                                <i class="fa fa-user fa-2x">
                                </i>
                                USUÁRIOS
                            </a>
                        </li>
						<li >
                            <a  href="desenharSalas.php" onclick="window.open(this.href, 'child', 'fullscreen=yes'); return false" class="salaMapa" data-toggle="pill"> <!-- href="#salaMapa" -->
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
					
					</div> <!-- wrapper -->
					</div> <!-- container -->
                </div>
            </div> 
        </div>
        <!-- panel-footer Pills>
        -->

        <div class="tab-content">
            <div class="tab-pane active" id="evento">
                <p class="TabContent">

					<form id="formEventosAcademicos" action="#" title="Modificar Eventos Academicos" method=''> 
					
						<div id="conteudoEventosAcademicos" class="col-xs-12 col-sm-12 col-md-12">
						<!-- carrega aqui o conteudo de listaEventosAcademicos.html -->
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
								<!-- <input id="sairSenha" type="button" value="Sair" class="btn btn-danger btn-block btn-lg"> -->
								<button type="button" id="sairSenha" value="Sair" class="btn btn-primary btn-block btn-lg" style="white-space: normal; padding-right:2px; padding-left:2px;"> <i class="fa fa-home"></i> Voltar</button>
							</div>
						</div> 
					</form>
                </p>
            </div>


            <div class="tab-pane" id="academico">
                <p class="TabContent">
				
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								ADMINISTRAÇÃO DE USUÁRIOS DO PORTAL SENAC 
							</h4>
						</div>
				
					<form id="formMudaDisciplina" role="form">
						
						<div id="minhaGrade">
						<!-- AREA DE EXIBICAO DAS SALAS POR DIA DA SEMANA -->
						</div>
						
						<!-- MODAL DA AREA DE MONTAGEM DE GRADE -->
						<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true" >
							<div class="modal-dialog">
								<div class="modal-content">
								
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">
												DISCIPLINA DE 
											</h4>
									</div>
								
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="form-group">
											<label for="curso">Nome do curso:</label>
												<select class="form-control" id="curso" >
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
												<select class="form-control" id="disciplina" required></select>
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
						
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="turno">Turno:</label>
												<select class="form-control" id="turno" required>
													<option value="M">Manhã</option>
													<option value="N">Noite</option>
												</select>
										</div>
									</div>
						
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="andar">Andar:</label>
											<input class="form-control" id="inputAndarDisciplina" name="andar" value="-1" type="number" min="0" max="10">
										</div>
									</div>
									
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="sala">Sala:</label>
												<select class="form-control" id="sala" required></select>
										</div>
									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="submit" id="salvarDisciplina" class="btn btn-primary">Salvar alterações</button>
									</div>
								
								</div> <!-- class="modal-content" -->

							</div> <!-- class="modal-dialog" -->

						</div> <!-- div class="modal fade"  -->
						
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

        </div>
		
    </body>

</html>