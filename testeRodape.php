<!DOCTYPE html>
<html lang="pt-br">

    <?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    include("funcoes.php");
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
    ?>

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LocalizeSenac - Sistema de Localização FATEC POA</title>

        <link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
        <link type="text/css" rel="stylesheet" href="style/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-theme.min.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css" />

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

        <!--  para o ajax -->
        <script type="text/javascript" src="script/ajax.js"></script>
        <script type="text/javascript" src="script/instrucao.js"></script>

        <!--  funcoes em javascript -->
        <script type="text/javascript" src="script/funcoes.js"></script>
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type = "text/javascript" >
            $(document).ready(function () {
                $("#conteudo_mostrar_pesquisas").hide();
            });
        </script>

    </head> <!-- <head> -->
    <body> 
        <div class="container-fluid principal">
            <div class="row clearfix cabecalho">
                <div class="col-md-12 column">
<!--                    <div class="page-header">-->
                        <div class="col-md-9 logoLocalizesenac">
                            <a href="http://www.localizesenac.com/principal.php"> <img src="images/logo_LocalizeSenac_novo_small.png" alt="Logo Senac" height="92" width="170" hspace="20"> </a>
                        </div>

                        <div class="col-md-3 areaSaudacao">

                            <span>
                                Olá <?php echo $_SESSION['usuarioNome']; ?>!
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <a style="color:red" href="sair.php">
                                    <span class="glyphicon glyphicon-off">
                                        SAIR
                                    </span> 
                                </a>
                            </span>
                        </div>
<!--                    </div>-->
                </div>
            </div>
            <div class="row clearfix menuPesquisas">
                <div class="col-md-12 column">
                <div class="col-md-3 column blocoPesquisa">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Procure aqui locais ou serviços</strong>
                        </div>

                        <div class="col-md-12">
                            <form  id="searchForm" name="searchForm" action="" class="search" >
                                <input type="text" name="inputBusca"  placeholder="Digite aqui sua busca..." />
                            </form>
                        </div>

                        <div class="col-md-12 resultadoPesquisa">
                            <div id="conteudo_mostrar_pesquisas" class="modalDialog">
                                <script>
                                    validaBusca(); // chama a funcao de validacao de busca do arquivo funcoes.js
                                </script>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="row panel-group" id="accordion">

                                <p></p>

                                <?php
                                /* Inicio do acordion */
                                if (isset($_GET['cd_andar'])) {
                                    $cd_andar = $_GET['cd_andar'];
                                }
                                $sql = "SELECT CD_CATEGORIA, NM_CATEGORIA, parametro_imagem FROM categoria";

                                $result = mysql_query($sql, $_SG['link']);
                                $i = 1; // o valor dos collapses parte de 1 para nao sobrescrever a area de pesquisas que e collapse 0

                                while ($consulta = mysql_fetch_array($result)) {
                                    echo "<div class='panel panel-default'>";
                                    echo "<div class='panel-heading'><h4 class='panel-title'>
						<span class='$consulta[parametro_imagem]'></span>
						<a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $i . "'>$consulta[NM_CATEGORIA]</a>
						</h4></div>";

                                    /* Escrever itens secundários do menu */

                                    $sql2 = "SELECT  CD_LOCAL, NM_LOCAL, CORD_X, CORD_Y, CD_ANDAR FROM andar_locais WHERE CD_CATEGORIA = $consulta[CD_CATEGORIA] ORDER BY CD_ANDAR, NR_MAPA";
                                    $result2 = mysql_query($sql2, $_SG['link']);

                                    echo "<div id='collapse" . $i . "' class='panel-collapse collapse'>";
                                    echo "<div class='panel-body'>";
                                    while ($consulta2 = mysql_fetch_array($result2)) {
                                        //echo "<p><a href=\"mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]\"> $consulta2[NM_LOCAL]</a></p>\n";
                                        echo "<p><a href=\"#\" onclick=\" abrirPag('mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]');atualizaServicos('servicos.php?cd_andar=$consulta2[CD_ANDAR]'); \"> $consulta2[NM_LOCAL]</a></p>\n";
                                        //echo "<p><a href=\"#\" onclick=\" abrirPag('mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]'); \"> $consulta2[NM_LOCAL]</a></p>\n";
                                    }
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    $i++;
                                }

                                /* fim do acordion */
                                ?>
                            </div>

                        </div>

                    </div><!--<div class="row"> linha unica do bloco_pesquisa -->
                </div>
                
                <div class="col-md-9 column blocoExtras">
                    <div class="row clearfix linhaExtras">
                        
                        <div class="col-md-3 column subBloco_outrosServicos">
                            
                            <p><b> Outros Serviços </b></p>

                            <div id="conteudo_mostrar_servicos">
                                <script>
                                    $ajax.ready(function () {
                                        $.ajax({
                                            url: 'servicos.php?cd_andar=3',
                                            async: true
                                        }).done(function (data) {
                                            alert(data);
                                        });
                                    }
                                </script>
                            </div>

                            <?php
                            echo "<p>";
                            if (isset($_GET['cd_andar'])) {
                                $sql5 = "SELECT 
                                        CONCAT (NR_MAPA,' - ', NM_LOCAL) AS DS_LOC
                                    FROM parametro_imagem I,
                                        andar_locais A
                                    WHERE
                                        I.CD_ANDAR = A.CD_ANDAR
                                        AND
                                        I.CD_PARAMETRO = $cd_andar ORDER BY NR_MAPA";
                                $result5 = mysql_query($sql5, $_SG['link']);
                                while ($consulta5 = mysql_fetch_array($result5)) {
                                    echo "$consulta5[DS_LOC]\n";
                                    echo "</br>";
                                }
                                echo "</p>";
                            }
                            ?>  
                        </div>
                        <div class="col-md-4 column subBloco_EventosSenac">
                                                        <div class="control-group">
                                <label for="date-picker" class="control-label">Eventos Senac</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <input id="datepicker" type="text" class="date-picker form-control" />
                                        <label for="datepicker" class="input-group-addon btn">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </label>
                                    </div>
                                </div>
                                        <!-- Datepicker -->
        <script>
            $(function () {
                $("#datepicker").datepicker();
                $("#datepicker").datepicker("setDate", new Date());
            });
        </script>
        <!-- Datepicker -->
                            </div>
                        </div>
                        <div class="col-md-5 column subBloco_MinhasAulas">

                            <p> <b>Minhas Aulas</b> </p>

                            <ul id="pillsMinhasAulas" class="nav nav-pills">
                                <li class="active">
                                    <a href="#seg" data-toggle="tab">
                                        SEG
                                    </a>
                                </li>
                                <li>
                                    <a href="#ter" data-toggle="tab">
                                        TER
                                    </a>
                                </li>
                                <li>
                                    <a href="#qua" data-toggle="tab">
                                        QUA
                                    </a>
                                </li>
                                <li>
                                    <a href="#qui" data-toggle="tab">
                                        QUI
                                    </a>
                                </li>
                                <li>
                                    <a href="#sex" data-toggle="tab">
                                        SEX
                                    </a>
                                </li>
                            </ul>

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
                            }
                            ?>

                            <!--  fim do while para preencher os conteudos das pills -->

                            <div id="conteudoPillsMinhasAulas" class="tab-content">
                                <!-- <div class="tab-pane fade in active" id="seg"> -->
                                <div class="tab-pane fade" id="seg">
                                    <p class="TabContent">
                                        <?php echo $discSeg; ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="ter">
                                    <p class="TabContent">
                                        <?php echo $discTer; ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="qua">
                                    <p class="TabContent">
                                        <?php echo $discQua; ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="qui">
                                    <p class="TabContent">
                                        <?php echo $discQui; ?>
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="sex">
                                    <p class="TabContent">
                                        <?php echo $discSex; ?>
                                    </p>
                                </div>

                                <script type="text/javascript">
                                    selecionaTab();
                                </script> 

                            </div> <!-- <div id="conteudoPillsMinhasAulas" class="tab-content"> -->

                        </div>
                    </div>
                    </div>
                    
                    <div class="row linhaMapas">

                        <?php
                        if (isset($_GET['cd_andar'])) {
                            $sql6 = "SELECT 
					CAMINHO_IMAGEM,
					PIX_X,
					PIX_Y,
                                        CONCAT ('<B>',NM_UNIDADE, ' - ', DS_ENDERECO,'</B>') DS_UD
                                  FROM 
                                    parametro_imagem P,
                                    unidade U
             
                                WHERE 
                                    U.CD_UNIDADE = P.CD_UNIDADE
                                AND
                                    P.CD_ANDAR = $cod";

                            $result6 = mysql_query($sql6, $_SG['link']);
                            $consulta6 = mysql_fetch_array($result6);
	
                            echo "<div style=\"background-color:white\"\">";
                            echo "$consulta6[DS_UD]" . "<BR>";
//				echo "<div id=\"iPicture\">";
//				echo "<div class=\"slide\"><div id=\"picture1\" style=\"background: url('$consulta6[CAMINHO_IMAGEM]') no-repeat scroll 0 0 #393737; width: $consulta6[PIX_X]px; height: $consulta6[PIX_Y]px;position: relative; margin:0 auto;\"></div></div><br/>";
//				echo "</div>";	
//				echo "</div>";			
                            echo "</div>";
                        } //fim do isset de controle da sql
                        ?>

                        <div class="col-md-12 blocoMapa">
<!--                                <img class="mapa" src="images/1andar.jpg" alt="primeiro andar">-->

                            <div id="conteudo_mostrar">
                                <!-- Aqui aparece o conteudo do ajax -->

                            </div>

                        </div> <!-- <div class="col-md-12 blocoMapa"> -->

                    </div> <!-- <div class="row linhaMapas"> -->  

                    
                </div> <!-- <div class="col-md-9 blocoExtras"> -->
            </div> <!-- menuPesquisas -->
            
<footer class="footer">

            <div class="row rodape linhaUnicaRodape">

                <div class="col-md-12 gridUnicoRodape">

                    <div class="col-md-6 copyRight">
                        <p>© 2010 Senac-RS - Todos os direitos Reservados.</p>
                        <p>Serviço Nacional de Aprendizagem Comercial do Rio Grande do Sul - Senac-RS</p>
                    </div>

                    <div class="col-md-3 redesSociais">
                        <a href="http://www.facebook.com/senacrsoficial">
                            <img src="images/link_facebook.png" alt="facebook"/>
                        </a>
                        <a href="http://www.twitter.com/senacrs">
                            <img src="images/link_twitter.png" alt="twitter"/>
                        </a>
                        <a href="http://www.youtube.com/senacrsoficial">
                            <img src="images/link_youtube.png" alt="youtube"/>
                        </a>
                    </div> 

                    <div class="col-md-3 sistemaS">
                        <a href="http://www.fecomercio-rs.org.br" target="_blank">
                            <img src="images/logo_rodape_fecomercio.jpg" alt="Fecomércio" />
                        </a>

                        <a href="http://www.senacrs.com.br" target="_blank">
                            <img src="images/logo_rodape_senac3.jpg" alt="SENAC" />
                        </a>

                        <a href="http://www.sesc-rs.com.br" target="_blank">
                            <img src="images/logo_rodape_sesc.png" alt="SESC-RS" />
                        </a>
                    </div>

                </div> <!-- <div class="col-md-12 gridUnicoRodape"> -->

            </div><!-- <div class="row rodape linhaUnicaRodape"> -->

        </footer> <!-- <footer class="navbar-default navbar-fixed-bottom"> -->
        </div>
    </body>
</html>