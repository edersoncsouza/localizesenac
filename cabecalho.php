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
        <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css" />

        <script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
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

    </head> <!-- <head> -->
    <body>

        <!-- Header -->
        <div id="top-nav" class="navbar navbar-inverse navbar-static-top cabecalho">
            <div class="container-fluid">
                
                <div class="row-fluid"> <!-- linha unica do cabecalho -->
                
                <div class="span8 navbar-header ">  <!-- coluna de largura 8 -->
                    <div class="logoLocalizesenac">
                        <a href="http://www.localizesenac.com/principal.php"> <img src="images/logo_LocalizeSenac_novo_small.png" alt="Logo Senac" height="92" width="170" hspace="20"> </a>
                    </div>
                </div> 

                <div class="span4 navbar-collapse collapse"> <!-- coluna de largura 4 -->
                    <div class="">
                        <ul class="nav navbar-nav navbar-right areaSaudacao">

                            <li class="dropdown">
                                <a class="dropdown-toggle " role="button" data-toggle="dropdown" href="#">
                                    <i class="glyphicon glyphicon-user"></i> 
                                    <?php echo $_SESSION['usuarioNome']; ?> 
                                    <span class="caret"></span>
                                </a>

                                <ul id="g-account-menu" class="dropdown-menu" role="menu">
                                    <li><a href="#">Meu Perfil</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="logout.php"><i class="glyphicon glyphicon-off"></i> 
                                    Sair
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> 
                
            </div> <!-- row-fluid -->
                
            </div><!-- /container -->


        </div> <!-- <div id="top-nav" class="navbar navbar-inverse navbar-static-top cabecalho"> -->
        <!-- /Header -->

    </body>

</html>