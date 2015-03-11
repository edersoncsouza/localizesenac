<!DOCTYPE html>
<html lang="pt-br">
    <!-- /* http://behstant.com/blog/?p=662 */ Ver isso, Ajax --> 

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
        <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />

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
            });</script>

    </head> <!-- <head> -->

    <body>
        <div class="container-fluid principal">
            <div class="row cabecalho">
                <div class="col-md-12 column">

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

                </div> <!-- class="col-md-12"> -->

            </div> <!-- row cabecalho -->

            <div class="row">
                <div class="col-md-12 column" style="background-color: yellow">
                    <div class="col-md-3 column" style="background-color: orange">
                        <div id="menu" class="col-md-12" >
                            <script>
                                $(document).ready(function () {
                                    $('#menu').load('menu.php');
                                });
                            </script>
                        </div>    
                    </div> <!-- <div class="col-md-3 column"> CAIXA DE PESQUISA -->
                    
                    <div class="col-md-9 column" style="background-color: green">
                        <div class="col-md-12 column">
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

                                </div><!--<div class="col-md-4 subBloco_outrosServicos">-->

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
                                                    });</script>
                                        <!-- Datepicker -->
                                    </div>

                                </div><!--<div class="col-md-4 subBloco_EventosSenac">-->

                                <div class="col-md-5 column subBloco_MinhasAulas" id="postit">

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

                                </div> <!-- <div class="col-md-5 subBloco_MinhasAulas" id="postit"> -->

                        </div><!--  <div class="col-md-12 column">SERVICOS -->
                        
                        <div id="mapa" class="col-md-12">
                            
                            <div class="mapaR"></div>
                            <!--<img src="images/1andar.jpg" alt=""/>-->
                        </div><!--  <div class="col-md-12 column"> MAPAS -->
                        

                    </div> <!--  <div class="col-md-9 column"> MAPAS E SERVICOS -->

                </div> <!-- <div class="col-md-12 column"> -->
            </div> <!-- row miolo -->
            
            <div class="row rodape hidden-lg hidden-md hidden-sm hidden-xs"> <!-- Ocultando o rodape em dispositivos eXtraSmall -->
                <footer class="navbar-default navbar-fixed-bottom">

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
            </div> <!-- row rodape -->
        </div>
    </body>

</html>