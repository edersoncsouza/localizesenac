<!--								
								
PENDENCIAS LOCAIS:

 - INSERIR UM SUBMENU DE CATEGORIAS(SALAS POR ANDAR POR EXEMPLO);
 - ALIMENTAR TYPEAHEAD COM AS TAGS DE SALAS DO BANCO DE DADOS;
								
								 
-->
<!DOCTYPE html>
<html lang="en">

    <?php
    include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("dist/php/funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
    ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="dist/components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Morris Charts CSS -->
    <!-- <link href="../bower_components/morrisjs/morris.css" rel="stylesheet"> -->

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
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="dist/js/funcoes.js"></script>
	
	<!-- Typeahead -->
	<script src="dist/components/typeahead/dist/js/typeahead.bundle.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="principal.php">LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Olá <?php echo $_SESSION['usuarioNome']; ?>! <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil do Usuário</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Configurações</a>
                        </li>
                        <li class="divider"></li>
                        <!-- <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Sair</a> -->
						<li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
            <div class="navbar-default sidebar" role="navigation">
			
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
						<!-- caixa de pesquisa -->
						
						<li class="sidebar-search">
                            <div id="idBusca" class="input-group custom-search-form">
							
								<form class="search" action="search.php">
								
								
									<!-- typeahead -->
									<div id="scrollable-dropdown-menu">
										<input 
											type="text" 
											name="busca"
											class="form-control typeahead"

											placeholder="Digite aqui sua busca..."
										>
									</div>
									<!-- typeahead -->
									
									<!-- removendo o botão de busca
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</span>
									-->
								
								</form>	
							
                            </div>
                            <!-- /input-group -->
                        </li>
						
						<!-- função PHP que faz a query e cria o menu lateral e seus itens -->
						<!-- tambem cria o vetor com as salas para utilizacao do typeahead -->
						<?php defineAcordion(); ?>
						
						
						<script type="text/javascript">

							// recebe o vetor PHP codificado a partir do BD durante a criacao do menu lateral
							var vetorNomeAndarNumero = <?php echo json_encode($_SESSION['JsonNomeAndarNumero']); ?>;
								
							// envia o vetor Json com nome andar e numero da sala e recebe de volta apenas nomes
							var vetorNomesTypeahead= criaVetorTypeahead(vetorNomeAndarNumero);

							// instancia o controle typehead
							$('#idBusca .typeahead').typeahead(
								{
									hint: true,
									highlight: true,
									minLength: 1
								},
								{
									name: 'salas',
									displayKey: 'value',
									source: substringMatcher(vetorNomesTypeahead),// fonte das palavras chave to typeahead
										templates: {
											empty: [
												'<div class="empty-message" style="padding: 5px 10px; text-align: center;">',
												'Sem sugestões...',
												'</div>'
												].join('\n')
										}
								}
							).on('typeahead:selected', onSelected); // acrescenta o evento "ao selecionar" do menu dropdown
								
						</script>
						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

	<div id="page-wrapper">
	
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header"> <i class="fa fa-graduation-cap fa-2x"></i> Eventos Acadêmicos</h1>		
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-primary"> <!-- Agenda Acadêmica -->
                        <div class="panel-footer">
                            <span class="pull-left"><strong>Agenda Acadêmica</strong></span>
                            <div class="clearfix"></div>
                        </div>
					
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Eventos</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer" id="agenda">
                                <span class="pull-left">Exibir Agenda</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
                                <div class="clearfix"></div>					
                            </div>
                        </a>
                    </div>
                </div>
				
				
				<div class="col-lg-6 col-md-6">
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
                                    <p class="TabContent">
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

                            </div> <!-- <div id="conteudoPillsMinhasAulas" class="tab-content"> -->
						
						<!-- <a href="#mostrarSala"> -->
                            <div class="panel-footer">
                                <span class="pull-left">Mostrar a Sala</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        <!-- </a> -->
						
                    </div> <!--  <div class="panel panel-primary"> Painel Minhas aulas-->
				
				
			</div> <!-- agenda academica e minhas aulas -->
			<!-- /.row -->
	
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading" style="background-color:#337ab7; color: #FFFFFF;">
							<h4><i class="fa fa-location-arrow"></i>Indoor Map<h4>
								<div class="pull-right">
	
								</div>
						</div>
						<!-- /.panel-heading -->
						
						<!-- area de exibicao do mapa -->
						<div class="panel-body" id="result"> 

						</div>
						<!-- /.panel-body -->
						
					</div>
				</div>
			</div>
	
		</div>
        <!-- /#page-wrapper -->
	
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="dist/components/metisMenu/dist/metisMenu.min.js"></script> 

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

	<script type="text/javascript">
		selecionaTab(); // seleciona o dia da semana corrente na area Minhas Aulas
		$("#result").load("mapa.php");	 // carrega a pagina do mapa na div result
	</script>


	
</body>

</html>