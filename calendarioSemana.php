<!DOCTYPE html>
<html lang="en">

<head>

<?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Principal CSS -->
    <link href="dist/css/principal.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="dist/js/funcoes.js"></script>
	
<script>

$(document).ready(function() {

	// div classe tab-pane, conteudo p. para cada um deles executa a funcao de alerta de seu conteudo
	/* EXEMPLO
	<div class="tab-pane" id="sex">
        <p class="TabContent">
					Não tem aulas no dia de hoje */
	
	// verifica o conteudo das pills dos dias de semana
	$('div.tab-pane>p') // div classe tab-pane, conteudo p
		.filter(function() {
			var Id = $(this).parent().attr("id");   
			return (Id == 'seg' || Id == 'ter'|| Id == 'qua'|| Id == 'qui'|| Id == 'sex'|| Id == 'sab'|| Id == 'dom');
		}) // se o id for um dia da semana
			.each(function(){ // com todos eles
					// se nao existirem disciplinas cadastradas no dia
					if($(this).text().trim() == 'Não tem aulas no dia de hoje'){ // o trim remove os espaços extra que jquery traz
						// adiciona um botao para incluir disciplinas no mesmo nivel do container de texto
						$(this).parent().append('<p class="TabContent col-xs-12 col-sm-12 col-md-12">'+
										'<button type="button" id="incluiDisciplina" class="btn btn-success btn-block btn-lg">Adicionar Disciplina</button>'+
										'</p>');
					}
					else{ // se ja existirem disciplinas cadastradas no dia 
						// adiciona um botao para editar e um para excluir disciplinas no mesmo nivel do container de texto
						$(this).parent().append('<p class="TabContent col-xs-12 col-sm-12 col-md-12">'+
										'<button type="button" id="editaDisciplina" class="btn btn-warning btn-block btn-lg">Editar Disciplina</button>'+
										'</p>'+
										'<p class="TabContent col-xs-12 col-sm-12 col-md-12">'+
										'<button type="button" id="excluiDisciplina" class="btn btn-danger btn-block btn-lg">Excluir Disciplina</button>'+
										'</p>'
										);
					}
			});
});

</script>

</head>

<body>

	<div id="page-wrapper">
				<div class="col-xs-12 col-sm-12 col-md-12" >
                    <div class="panel panel-primary"> <!-- Minhas Aulas -->
                        <div class="panel-footer">
                            <span class="pull-left"><strong>Minhas Aulas</strong></span>
                               
                            <div class="clearfix"></div>
                        </div>

							<!-- função PHP que faz a query e armazena os valores do conteudo das pills -->
							<?php defineDisciplinas(); ?>
						
					    <div class="panel-heading"> <!-- Disciplinas -->
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
									<div class="huge"><?php echo $_SESSION['contDiscp']; ?></div>
                                    <div>Disciplinas</div>
                                </div>
                            </div>
                        </div>					
						
						<div class="panel-footer" id="pills">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active">
                                    <a href="#seg" data-toggle="pill">
                                        SEG
                                    </a>
                                </li>
                                <li>
                                    <a href="#ter" data-toggle="pill">
                                        TER
                                    </a>
                                </li>
                                <li>
                                    <a href="#qua" data-toggle="pill">
                                        QUA
                                    </a>
                                </li>
                                <li>
                                    <a href="#qui" data-toggle="pill">
                                        QUI
                                    </a>
                                </li>
                                <li>
                                    <a href="#sex" data-toggle="pill">
                                        SEX
                                    </a>
                                </li>
								<li>
                                    <a href="#sab" data-toggle="pill">
                                        SAB
                                    </a>
                                </li>
								<li>
                                    <a href="#dom" data-toggle="pill">
                                        DOM
                                    </a>
                                </li>
                            </ul>
						</div>
						<!-- panel-footer Pills> -->
	
                            <div class="tab-content">

							<!-- recebe as disciplinas de funcoes.php (defineDisciplinas())-->
                                <div class="tab-pane active" id="seg">
                                    <p class="TabContent  col-xs-12 col-sm-12 col-md-12">
                                        <?php echo $_SESSION['discSeg']; ?> 
                                    </p>
                                </div>
                                <div class="tab-pane" id="ter">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discTer']; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="qua">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discQua']; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="qui">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discQui']; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="sex">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discSex']; ?>
                                    </p>
                                </div>
								 <div class="tab-pane" id="sab">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discSab']; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="dom">
                                    <p class="TabContent">
                                        <?php echo $_SESSION['discDom']; ?>
                                    </p>
                                </div>

                            </div> <!-- < div id="conteudoPillsMinhasAulas" class="tab-content"> -->
												
					</div><!-- div class="panel panel-primary"> Painel Minhas aulas-->
                     
				</div> <!-- div class="col-lg-6 col-md-6"> -->
				
	
	</div> <!-- /#page-wrapper -->


	<script type="text/javascript">
		selecionaTab(); // seleciona o dia da semana corrente na area Minhas Aulas
	</script>


	
</body>

</html>