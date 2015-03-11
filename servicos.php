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

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
        <script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript" src="script/bootstrap.min.js"></script>

    </head> <!-- <head> -->

    <body>

        <div class="servicos">
            <?php
                            echo "<p>";
                            if(isset($_GET['cd_andar'])){
                                $cd_andar = $_GET['cd_andar'];
                            
                            $sql = "SELECT 
                                        CONCAT (NR_MAPA,' - ', NM_LOCAL) AS DS_LOC
                                    FROM parametro_imagem I,
                                        andar_locais A
                                    WHERE
                                        I.CD_ANDAR = A.CD_ANDAR
                                        AND
                                        I.CD_PARAMETRO = $cd_andar ORDER BY NR_MAPA";
                            $result = mysql_query($sql, $_SG['link']);
                            while ($consulta5 = mysql_fetch_array($result)) {
                                echo "$consulta5[DS_LOC]\n";
                                echo "</br>";
                            }
                            echo "</p>";
                            }
                 ?>    

        </div> <!-- <div class="servicos"> -->

        <?php
        mysql_free_result($result);
        mysql_close($_SG['link']);
        ?>  

    </body>

</html>