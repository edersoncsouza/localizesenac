<!--								
								
PENDENCIAS LOCAIS:

 - INSERIR UM SUBMENU DE CATEGORIAS(SALAS POR ANDAR POR EXEMPLO);
 - ALIMENTAR TYPEAHEAD COM AS TAGS DE SALAS DO BANCO DE DADOS;
								
								 
-->
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

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>

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
			text-align: center;
		}
		
		#scrollable-dropdown-menu .tt-dropdown-menu {
			max-height: 150px;
			overflow-y: auto;
			
			width: 160px;
			margin-top: 12px;
			padding: 8px 0px;
			background-color: #FFF;
			border: 1px solid rgba(0, 0, 0, 0.2);
			border-radius: 8px;
			box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
		}
		
		.tt-suggestion {
		  padding: 3px 20px;
		  font-size: 14px;
		  line-height: 16px;
		}

			
		} 
		
	</style>
	
	<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

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
                <a class="navbar-brand" href="principal.php">LocalizeSenac 2.0 - Site para Indoor Mapping da Faculdade Senac Porto Alegre</a>
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
						
						 <?php
                                /* Inicio do acordion */
                                if (isset($_GET['andar'])) {
                                    $andar = $_GET['andar'];
                                }
                                $sql = "SELECT id, nome, parametro_imagem FROM categoria";

                                $result = mysql_query($sql, $_SG['link']);
                                $i = 1; // o valor dos collapses parte de 1 para nao sobrescrever a area de pesquisas que e collapse 0
								
                                while ($consulta = mysql_fetch_array($result)) {
									
                                    echo "<li id=\"menuCategoria\">"; // cria a estrutura do menu de categoria
									echo "<a href=\"#\"><i class=\" {$consulta['parametro_imagem']} \"></i> $consulta[nome] <span class=\"fa arrow\"></span></a>";
											
                                    /* Escrever itens secundários do menu */

                                    //$sql2 = "SELECT  id, nome, andar FROM andar_locais WHERE fk_id_categoria = $consulta[id] ORDER BY andar";
									$sql2 = "SELECT
										sala.id, numero, descricao, andar
									FROM
										sala, info_locais
									WHERE
										sala.numero = info_locais.fk_numero_sala
									AND
										fk_id_categoria = $consulta[id]
									ORDER BY andar";

                                    $result2 = mysql_query($sql2, $_SG['link']);
									
                                    echo "<ul class=\"nav nav-second-level collapse\">"; // cria a estrutura dos itens de menu
										while ($consulta2 = mysql_fetch_array($result2)) {
											echo "<li>"; // cria o item de categoria
											//echo "<a href=\"#\" onclick=\" abrirPag('mapas.php?id_nome=$consulta2[nome]&andar=$consulta2[andar]');atualizaServicos('servicos.php?andar=$consulta2[andar]'); \"> $consulta2[nome]</a>\n";                                        
											//echo "<a href=\"#\" onclick=\"location.href='mapa.php?sala=$consulta2[numero]&andar=$consulta2[andar]'; \"> $consulta2[descricao]</a>\n";
											//echo "<a href=\"#\" onclick=\"atualizaMapa($consulta2[andar],$consulta2[numero])\"> $consulta2[descricao]</a>\n";
											
											//echo "<a href=\"#\" onclick=\"atualizaMapa($consulta2[andar],$consulta2[numero]) \"> $consulta2[descricao]</a>\n";
											  echo "<a href=\"#\" onclick=\" insereMarker($consulta2[andar],$consulta2[numero]); \"> $consulta2[descricao]</a>\n";
											
											echo "</li>";
											
											// acrescenta cada descricao, andar e sala ao vetor associativo $nomeAndarNumero para uso do typeahead
											$nomeAndarNumero[] = array('descricao' => $consulta2['descricao'], 'andar' =>$consulta2['andar'], 'numero' =>$consulta2['numero']);
											
											// codifica o vetor em formato JSON
											//$JsonNomeAndarNumero = json_encode($nomeAndarNumero,JSON_FORCE_OBJECT);
											$JsonNomeAndarNumero = json_encode($nomeAndarNumero);
										}	
                                    echo "</ul>";
									
                                    echo "</li>";

                                    $i++;
                                }

                                /* fim do acordion */
                                ?>
						
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

							<!-- codigo PHP que faz a query e armazena os valores do conteudo das pills -->
							<?php
							
							defineDisciplinas();
							/*
							$sql3 = "SELECT
								aluno_disciplina.dia_semana AS DIA, aluno_disciplina.fk_numero_sala AS SALA, disciplina.nome AS DISC
							FROM
								aluno_disciplina, disciplina, aluno
							WHERE
								aluno.id = aluno_disciplina.fk_id_aluno
							AND
								disciplina.id = aluno_disciplina.fk_id_disciplina
							AND
								aluno_disciplina.fk_id_aluno=" . $_SESSION['usuarioID'] . " ORDER BY aluno_disciplina.id";
							
							$result3 = mysql_query($sql3, $_SG['link']);
							
							$contDiscp = mysql_num_rows($result3);
							
                            $discSeg = "Não tem aulas no dia de hoje";
                            $discTer = "Não tem aulas no dia de hoje";
                            $discQua = "Não tem aulas no dia de hoje";
                            $discQui = "Não tem aulas no dia de hoje";
                            $discSex = "Não tem aulas no dia de hoje";
							$discSab = "Não tem aulas no dia de hoje";
							$discDom = "Não tem aulas no dia de hoje";

                            //  incio do while para preencher os conteudos das pills 
                            
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
							
							//fim do while para preencher os conteudos das pills
							
							*/
							
                            ?>
						
					    <div class="panel-heading"> <!-- Disciplinas -->
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
									<div class="huge"><?php echo$_SESSION['contDiscp']; ?></div>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script> 

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="../dist/js/funcoes.js"></script>
	
	<script src="../bower_components/typeahead/dist/js/typeahead.bundle.js"></script>
		
	    <script type="text/javascript">
		selecionaTab(); // seleciona o dia da semana corrente na area Minhas Aulas
		$("#result").load("mapa.php");	 // carrega a pagina do mapa na div result
		</script>

		<!-- typeahead 	-->
	    <script type="text/javascript">
			
			// funcao utilizada para verificar se parte dos termos digitados constam na lista de locais fornecidos
			var substringMatcher = function(strs) {
				return function findMatches(q, cb) {
					var matches, substrRegex;
					 
					// an array that will be populated with substring matches
					matches = [];
					 
					// regex used to determine if a string contains the substring `q`
					substrRegex = new RegExp(q, 'i');
					 
					// iterate through the pool of strings and for any string that
					// contains the substring `q`, add it to the `matches` array
					$.each(strs, function(i, str) {
						if (substrRegex.test(str)) {
							// the typeahead jQuery plugin expects suggestions to a
							// JavaScript object, refer to typeahead docs for more info
							matches.push({ value: str });
						}
					});
					 
					cb(matches);
				};
			};
			 
			
			// coloca cada elemento do vetor $salas do php no vetor javascript salas
			// var salas = ['Sala 102', 'Sala 301', 'Sala 409', 'Sala 603', 'Sala 704'];
			/* var Vsalas = < ?php echo '["' . implode('", "', $salas) . '"]' ?>; */
			
			// armazena o vetor PHP em um vetor JavaScript
			var JsonNomeAndarNumero = '<?php echo $JsonNomeAndarNumero ?>';
			
			var VjsonNomeAndarNumero = <?php echo $JsonNomeAndarNumero ?>;
			
			// transforma o vetor em um objeto JSON
			var jsonObj = $.parseJSON(JsonNomeAndarNumero);
			
			// instancia o vetor source para uso do Typeahead
			var sourceArr = [];
 
			// loop de alimentacao do vetor sourceArr
			for (var i = 0; i < jsonObj.length; i++) {
			   sourceArr.push(jsonObj[i].descricao);
			}
			
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
					source: substringMatcher(sourceArr), // fonte das palavras chave to typeahead
					//source: substringMatcher(Vsalas)
						templates: {
							empty: [
								'<div class="empty-message" style="padding: 5px 10px; text-align: center;">',
								'Sem sugestões...',
								'</div>'
								].join('\n')
						}
				}
				).on('typeahead:selected', onSelected); // acrescenta o evento "ao selecionar" do menu dropdown
			
			// funcao executada ao selecionar um item do menu dropdown do typeahead
			function onSelected($e, datum) {
				console.log('function onSelected'); // loga no console a funcao utilizada
				console.log(datum); // loga no console o objeto de dados selecionado
				console.log(datum.value); // loga no console a propriedade valor do objeto de dados selecionado
				getAndarSala(datum.value); // chama a funcao de busca de correspondencia de andar e sala pela descricao e atualiza o mapa
			}
			
			// funcao que busca a correspondencia da descrição da sala com andar e numero da sala
			function getAndarSala(descricao){
				
				for (var i = 0; i < VjsonNomeAndarNumero.length; i++) {
					
				   if(VjsonNomeAndarNumero[i].descricao == descricao){
					   
					    //atualizaMapa(VjsonNomeAndarNumero[i].andar,VjsonNomeAndarNumero[i].numero);
						insereMarker(VjsonNomeAndarNumero[i].andar, VjsonNomeAndarNumero[i].numero);

				   }
				}
			}
    </script>
	
</body>

</html>