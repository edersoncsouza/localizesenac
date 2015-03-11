<html>

    <head>
        <meta charset="utf-8">
        <title>Sticky footer &middot; Twitter Bootstrap</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <!--    <link href="../assets/css/bootstrap.css" rel="stylesheet">-->
        <link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
        <link type="text/css" rel="stylesheet" href="style/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-theme.min.css" />
        <link type="text/css" rel="stylesheet" href="style/principal.css" />
        <link type="text/css" rel="stylesheet" href="style/bootstrap-responsive.css" />

        <style type="text/css">

            /* Sticky footer styles
            -------------------------------------------------- */

/*            html,
            body {
                height: 100%;
                 The html and body elements cannot have any padding or margin. 
            }*/

            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by it's height */
                margin: 0 auto -60px;
            }

            /* Set the fixed height of the footer here */
            #push,
            #footer {
                height: 85px;
            }
            #footer {
                background-color: #f5f5f5;
            }

            /* Lastly, apply responsive CSS fixes as necessary */
            @media (max-width: 767px) {
                #footer {
                    margin-left: -20px;
                    margin-right: -20px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
            }



            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */

/*            .container {
                width: auto;
                max-width: 680px;
            }
            .container .credit {
                margin: 20px 0;
            }*/

        </style>
        <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body>


        <!-- Part 1: Wrap all page content here -->
        <div id="wrap">

            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1>Sticky footer</h1>
                </div>
                <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
                <p>Use <a href="./sticky-footer-navbar.html">the sticky footer</a> with a fixed navbar if need be, too.</p><p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
                <p>Use <a href="./sticky-footer-navbar.html">the sticky footer</a> with a fixed navbar if need be, too.</p><p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
                <p>Use <a href="./sticky-footer-navbar.html">the sticky footer</a> with a fixed navbar if need be, too.</p><p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>
                <p>Use <a href="./sticky-footer-navbar.html">the sticky footer</a> with a fixed navbar if need be, too.</p><p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p>

            </div>

            <div id="push"></div>
        </div>

        <div id="footer">
            <div class="container">
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
                
            </div>
        </div>



        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
<!--        <script src="../assets/js/jquery.js"></script>
        <script src="../assets/js/bootstrap-transition.js"></script>
        <script src="../assets/js/bootstrap-alert.js"></script>
        <script src="../assets/js/bootstrap-modal.js"></script>
        <script src="../assets/js/bootstrap-dropdown.js"></script>
        <script src="../assets/js/bootstrap-scrollspy.js"></script>
        <script src="../assets/js/bootstrap-tab.js"></script>
        <script src="../assets/js/bootstrap-tooltip.js"></script>
        <script src="../assets/js/bootstrap-popover.js"></script>
        <script src="../assets/js/bootstrap-button.js"></script>
        <script src="../assets/js/bootstrap-collapse.js"></script>
        <script src="../assets/js/bootstrap-carousel.js"></script>
        <script src="../assets/js/bootstrap-typeahead.js"></script>-->

    </body>

</html>
<?php
?>