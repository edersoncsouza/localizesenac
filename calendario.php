<!DOCTYPE html>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
mysql_set_charset('UTF8', $_SG['link']);
?>
<head>
  
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  
  <title>Calendário</title>
	
	<link type="text/css" rel="stylesheet" href="style/jquery-ui.1.11.2.min.css"  />
	<link type="text/css" rel="stylesheet" href="style/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="style/bootstrap-theme.css" />
	<link type="text/css" rel="stylesheet" href="style/principal.css" /> 
	
	<script type="text/javascript" src="script/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
	<script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	
	<style type='text/css'>
		table.ui-datepicker-calendar tbody td.highlight > a {
		background: url("images/ui-bg_inset-hard_55_ffeb80_1x100.png") repeat-x scroll 50% bottom #FFEB80;
		color: #000000;
		border: 1px solid #FFDE2E;
		}
	</style>
  


<script type='text/javascript'> 
$(window).load(function(){
var events = [
	<?php
	//$sql = "SELECT DATE_FORMAT(DT_EVENTO,\"%m/%d/%Y\") AS DIA FROM EVENTOS";
	$sql = "SELECT DATE_FORMAT(DT_INICIO,\"%m/%d/%Y\") AS DIA FROM EVENTO_ALUNO";
	$result = mysql_query($sql, $_SG['link']);
	
	while($consulta = mysql_fetch_array($result)) {
        echo "{ Title: \"Five\", Date: new Date(\"$consulta[DIA]\")} ,";
        }
	?>
];

$("div.teste").datepicker({
    beforeShowDay: function(date) {
        var result = [true, '', null];
        var matching = $.grep(events, function(event) {
            return event.Date.valueOf() === date.valueOf();
        });
        
        if (matching.length) {
            result = [true, 'highlight', null];
        }
        return result;
    },
    onSelect: function(dateText) {
        var date,
            selectedDate = new Date(dateText),
            i = 0,
            event = null;
        
        while (i < events.length && !event) {
            date = events[i].Date;

            if (selectedDate.valueOf() === date.valueOf()) {
                event = events[i];
            }
            i++;
        }
        if (event) {
            alert(event.Title);
        }
    }
});
});  

</script>


<SCRIPT LANGUAGE="JavaScript">
<!--
var U = "eventos.php";

var X = 100;
var Y = 100;
var W = 400;
var H = 400;
var s="resizable,left="+X+",top="+Y+",screenX="+X+",screenY="+Y+",width="+W+",height="+H;
function popMe(){
var SGW = window.open(U,'TheWindow',s)
}
// -->
</script> 


</head>
<body background ="#00FFFF">
	
  <div class="teste"> 
  
  <span class="glyphicon glyphicon-circle-arrow-left"></span>
    <a href="javascript:popMe()"><font face=verdana size=1> <img src="images/mais.jpg" width="15" height="15" alt="Livros"></font></a> 
  </div>
</body>


</html>