<!DOCTYPE html>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
mysql_set_charset('UTF8', $_SG['link']);
?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Eventos Senac</title>
	
	<link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
	<link type="text/css" rel="stylesheet" href="style/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="style/bootstrap-theme.css" />
	<link type="text/css" rel="stylesheet" href="style/principal.css" /> 
	
	<script type="text/javascript" src="script/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="script/jquery-ui-1.10.4.min.js"></script>
	<script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	
	<style type='text/css'>
    table.ui-datepicker-calendar tbody td.highlight > a {
    background: url("images/ui-bg_inset-hard_55_ffeb80_1x100.png") repeat-x scroll 50% bottom #FFEB80;
    color: #000000;
    border: 1px solid #FFDE2E;
}

  </style>
  
  </head>
<body background ="#00FFFF">

	<?php
	
	echo"<p><b>Eventos Senac</b></p>";
	$sql = "SELECT DATE_FORMAT(DT_INICIO,\"%d/%m/%Y\") AS DIA, NM_LOCAL FROM evento_aluno";
	$result = mysql_query($sql, $_SG['link']);
	
	while($consulta = mysql_fetch_array($result)) {
        echo "<b>$consulta[DIA] </b> $consulta[NM_LOCAL] <br>";
        }
	?>


</body>


</html>