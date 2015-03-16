<!DOCTYPE html>
<html lang="en">

    <?php
    include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("../funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
    ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LocalizeSenac 2.0 - Site para Indoor Mapping da Faculdade Senac Porto Alegre</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style>
		#conteudoPillsMinhasAulas {
			background-color: #fff;
			height: 40px;
			border-radius:1em;
			-webkit-border-radius: 1em;
			-moz-border-radius: 1em;
			text-align: center;
		}
		p.TabContent{
			line-height:40px;
		}
	</style>
	
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
                <a class="navbar-brand" href="index.html">LocalizeSenac</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
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
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Buscar...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                       <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
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
                            <div class="panel-footer">
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

					    <div class="panel-heading"> <!-- Disciplinas -->
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">5</div>
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
						<!-- panel-footer Pills>
						
						<!-- codigo PHP que faz a query e armazena os valores do conteudo das pills -->
                            <?php					
                            
							$sql3 = "SELECT
                                            dia_semana AS DIA, nm_local AS SALA, nm_disciplina AS DISC
                                    FROM
                                            aluno, aluno_disciplina AD, andar_locais, disciplina
                                    WHERE
                                            aluno.CD_ALUNO = AD.fk_id_aluno
                                    AND
                                            disciplina.CD_DISCIPLINA = AD.fk_id_disciplina
                                    AND
                                            andar_locais.CD_LOCAL = AD.fk_id_local
                                    AND
                                            cd_aluno =" . $_SESSION['usuarioID'] . " ORDER BY AD.ID_AULA";
							
                            $result3 = mysql_query($sql3, $_SG['link']);
							
							
                            $discSeg = "Não tem aulas no dia de hoje";
                            $discTer = "Não tem aulas no dia de hoje";
                            $discQua = "Não tem aulas no dia de hoje";
                            $discQui = "Não tem aulas no dia de hoje";
                            $discSex = "Não tem aulas no dia de hoje";
							$discSab = "Não tem aulas no dia de hoje";
							$discDom = "Não tem aulas no dia de hoje";

                            /*  incio do while para preencher os conteudos das pills */
                            
							while ($row = mysql_fetch_assoc($result3)) {
                                if ($row['DIA'] == "SEG") {
                                    $discSeg = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "TER") {
                                    $discTer = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "QUA") {
                                    $discQua = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "QUI") {
                                    $discQui = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "SEX") {
                                    $discSex = $row['SALA'] . " - " . $row['DISC'];
                                }
								if ($row['DIA'] == "SAB") {
                                    $discSab = $row['SALA'] . " - " . $row['DISC'];
                                }
								if ($row['DIA'] == "DOM") {
                                    $discDom = $row['SALA'] . " - " . $row['DISC'];
                                }
								
                            }
							
							/*fim do while para preencher os conteudos das pills*/
							
                            ?>
	
                            <div class="tab-content">

                                <div class="tab-pane active" id="seg">
                                    <p class="TabContent">
                                        <?php echo $discSeg; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="ter">
                                    <p class="TabContent">
                                        <?php echo $discTer; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="qua">
                                    <p class="TabContent">
                                        <?php echo $discQua; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="qui">
                                    <p class="TabContent">
                                        <?php echo $discQui; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="sex">
                                    <p class="TabContent">
                                        <?php echo $discSex; ?>
                                    </p>
                                </div>
								 <div class="tab-pane" id="sab">
                                    <p class="TabContent">
                                        <?php echo $discSab; ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="dom">
                                    <p class="TabContent">
                                        <?php echo $discDom; ?>
                                    </p>
                                </div>
                                
								<script type="text/javascript">
                                    //selecionaTab();
                                </script> 

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
						<div class="panel-heading">
							<h4><i class="fa fa-location-arrow"></i>Indoor Map<h4>
								<div class="pull-right">
										
										
								</div>
						</div>
						<!-- /.panel-heading -->
						
						<div class="panel-body" id="result"> <!--  -->
									<!-- <div id="morris-area-chart"></div> -->

						</div>
						<!-- /.panel-body -->
						
					</div>
				</div>
			</div>
	
		</div>
        <!-- /#page-wrapper -->
	
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script> 

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="../dist/js/funcoes.js"></script>
	
	<script>
		selecionaTab();
		$("#result").load("mapa.php");	
	</script>
	

</body>

</html>