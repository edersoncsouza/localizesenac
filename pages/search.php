<!DOCTYPE html>
<html lang="pt-br">
    <?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
    ?>

    <head>
        <title>localizeSenac - Sistema de Localização FATEC POA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
        <link type="text/css" rel="stylesheet" href="style/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-theme.min.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

    </head>

    <body>

        <div class="panel-group" id="accordion">

            <!-- INICIO DO ACCORDION -->
            <?php

            $busca = filter_input(INPUT_GET, 'inputBusca');

            if (empty($busca)) {
                //echo "vazia";    
            } else {
                $sql = "SELECT CD_CATEGORIA, 'Resultado da Pesquisa'  NM_CATEGORIA, PARAMETRO_IMAGEM FROM categoria WHERE CD_CATEGORIA = 1";
                $result = mysql_query($sql, $_SG['link']);
                $i = 0;

                while ($consulta = mysql_fetch_array($result)) {

                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>
                            <h4 class='panel-title'>
				<span class='$consulta[PARAMETRO_IMAGEM]'></span>
                                    <a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $i . "'>$consulta[NM_CATEGORIA]</a>
                            </h4>
                          </div>";
                    /* <a data-toggle='collapse' data-parent='#accordion' href='#collapse" . $i . "'>$consulta[NM_CATEGORIA]</a> */
                    /* Escrever itens secundários do menu */

                    $sql2 = "SELECT  CD_LOCAL, NM_LOCAL, CORD_X, CORD_Y,CD_ANDAR FROM andar_locais WHERE NM_LOCAL LIKE '%$busca%'  ORDER BY CD_ANDAR, NR_MAPA";
                    $result2 = mysql_query($sql2, $_SG['link']);

                    if (mysql_num_rows($result2) > 0) {

                        echo "<div id='collapse" . $i . "' class='panel-collapse collapse in'>";
                        echo "<div class='panel-body'>";
                        while ($consulta2 = mysql_fetch_array($result2)) {
                            //echo "<p><a href=\"mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]\"> $consulta2[NM_LOCAL]</a></p>\n";
                            //echo "<p><a href=\"#\" onclick=\" abrirPag('mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]');atualizaServicos('servicos.php?cd_andar=$consulta2[CD_ANDAR]'); \"> $consulta2[NM_LOCAL]</a></p>\n";
							echo "<p><a href=\"#\" onclick=\" abrirPag('openlayers/senac.html'); \"> $consulta2[NM_LOCAL]</a></p>\n";
                        }
                        echo "</div>";
                        echo "</div>";

                        echo "</div>";

                        $i++;
                    } else {
                        echo "Sem resultados para a pesquisa!!!";
                    }
                } // fim do while do menu secundario
            }

            ?>
            <!-- FIM DO ACCORDION -->

        </div>

        <?php
        mysql_close($_SG['link']);
        ?>  

    </body>
</html>