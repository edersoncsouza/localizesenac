<!doctype html>
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
        <link type="text/css" rel="stylesheet" href="style/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-theme.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />

        <!---CSS do mapa--->
        <link type="text/css" rel="stylesheet" media="screen" href="style/jquery-ui-1.8.16.custom.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="style/jQuery.iPicture.css"/>

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

        <!---js do mapa--->
<!--        <script type="text/javascript" src="script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.8.16.custom.min.js"></script>-->
        <script type="text/javascript" src="script/jQuery.iPicture.js"></script>
        <script>
            jQuery(document).ready(function () {
                $("#iPicture").iPicture({
                    animation: true,
                    animationBg: "bgblack",
                    animationType: "ltr-slide",
                    pictures: ["picture1", "picture2", "picture3", "picture4", "picture5"],
                    button: "moreblack",
<?php
$top = $_GET['cordx'];
$left = $_GET['cordy'];
$rotulo = $_GET['id_nome'];
echo "moreInfos:{\"picture1\":[{\"id\":\"tooltip1\",\"descr\":\"$rotulo\",\"top\":\"$top\",\"left\":\"$left\"}]}"
?>
                });

            });


        </script>	

    </head> <!-- <head> -->

    <body>

        <div class="mapaLocal">
            <?php

            $cd_andar = $_GET['cd_andar'];
            
            if (isset($_GET['cd_andar'])) {
                $sql = "SELECT 
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
                                    P.CD_ANDAR = $cd_andar";
                //P.CD_ANDAR = $cod"

                $result = mysql_query($sql, $_SG['link']);
                $consulta = mysql_fetch_array($result);

                echo "<div class=\"bloco_mapas\">";
                echo "<div style=\"color:yellow\"\">"; //cor da fonte do titulo do mapa
                echo "$consulta[DS_UD]" . "<BR>";
                echo "<div id=\"iPicture\">";
                echo "<div class=\"slide\"><div id=\"picture1\" style=\"background: url('$consulta[CAMINHO_IMAGEM]') no-repeat scroll 0 0 #393737; width: $consulta[PIX_X]px; height: $consulta[PIX_Y]px;position: relative; margin:0 auto;\"></div></div><br/>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            } //fim do isset de controle da sql
            ?>
        </div> <!-- <div class="center_block div_central"> -->

        <?php
        mysql_free_result($result);
        mysql_close($_SG['link']);
        ?>  

    </body>

</html>