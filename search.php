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
    protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
    ?>

	<link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
	<link type="text/css" rel="stylesheet" href="style/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="style/bootstrap-theme.min.css" />
	<link type="text/css" rel="stylesheet" href="style/principal.css" />

	<script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
	<script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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