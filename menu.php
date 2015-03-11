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
        <link type="text/css" rel="stylesheet" href="style/principal.css" />

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

        <!--  para o ajax -->
<!--        <script type="text/javascript" src="script/ajax.js"></script>
        <script type="text/javascript" src="script/instrucao.js"></script>-->

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
        <div class="container-fluid containerMenu ">

            <div class="row-fluid">
                    <div class="row linhaPesquisa">
                        <div class="col-md-12">
                            <strong>Procure aqui locais ou serviços</strong>

                            <form  id="searchForm" name="searchForm" action="" class="search" >
                                <input type="text" name="inputBusca"  placeholder="Digite aqui sua busca..." />
                            </form>

                            <p></p>

                        </div>

                        <div class="col-md-12">

                        </div>
                    </div>

                    <div class="row linhaMenu">
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
                                        $mapa = "mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&cd_andar=$consulta2[CD_ANDAR]&id_nome=$consulta2[NM_LOCAL]";
                                        //echo $mapa; // apenas pra ver se $mapa esta armazenando corretamente
                                        //esta funcionando       // echo "<p><a href=\"#\" onclick=\" abrirPag('mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]');atualizaServicos('servicos.php?cd_andar=$consulta2[CD_ANDAR]'); \"> $consulta2[NM_LOCAL]</a></p>\n";
                                        echo "<p><a href=\"#\" onclick=\" atualizaMapa('$mapa');\"> $consulta2[NM_LOCAL]</a></p>\n";
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

        </div> <!-- container fluid menu -->
    </body>
</html>