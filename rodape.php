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

    </head> <!-- <head> -->
    <body>  
        <footer class="footer">

            <!--<div class="row rodape linhaUnicaRodape">-->

<!--                <div class="col-md-12 gridUnicoRodape">-->

                    <div class="col-md-6 copyRight" > <!--  -->
                        <p>© 2010 Senac-RS - Todos os direitos Reservados.</p>
                        <p>Serviço Nacional de Aprendizagem Comercial do Rio Grande do Sul - Senac-RS</p>
                    </div>

                    <div class="col-md-3 redesSociais" > <!--  -->
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

                    <div class="col-md-3 sistemaS" > <!--  -->
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

                <!--</div>  <div class="col-md-12 gridUnicoRodape"> -->

<!--            </div> <div class="row rodape linhaUnicaRodape"> -->

        </footer>  <!-- <footer class="navbar-default navbar-fixed-bottom">  -->
    </body>
</html>