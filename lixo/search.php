<!doctype html>
<html>
<?php
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
mysql_set_charset('UTF8', $_SG['link']);
?>

<head>
	<title>localizeSenac - Sistema de Localização FATEC POA</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<link type="text/css" href="style/principal.css" rel="stylesheet" />  
	<link type="text/css" href="style/jquery-ui-1.10.4.min.css" rel="stylesheet" />  
	<link type="text/css" href="style/bootstrap.css" rel="stylesheet"/>
	<link type="text/css" href="style/bootstrap_theme.css" rel="stylesheet"/>
	
	<script type="text/javascript" src="script/jquery-1.11.1..min.js"></script>
	<script type="text/javascript" src="script/jquery-ui-1.11.2.min.js"></script>
	<script type="text/javascript" src="script/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="script/bootstrap.min.js"></script>
	
	<script type='text/javascript'>//<![CDATA[ 
		$(window).load(function(){
		$(".date-picker").datepicker();

			$(".date-picker").on("change", function () {
				var id = $(this).attr("id");
				var val = $("label[for='" + id + "']").text();
			$("#msg").text(val + " changed");
			});
		});//]]>  

	</script>
	
</head>

<body>

   
        <div class="div_cabecalho">	
			<img src="images/logo_LocalizeSenac.gif" alt="Logo Senac" height="92" width="170" hspace="20">
			<p class="login"> Olá <?php echo $_SESSION['usuarioNome'];?> <a style="color:red" href="sair.php">SAIR <span  class="glyphicon glyphicon-off"</span> </a></p>
        </div>
		
        <div class="left_block div_busca" >

                <div class="bloco_pesquisa">
                    
					<p><strong>Procure aqui locais ou serviços</strong></p>	</br>				
							
					<form class="search" action="search.php">
						<input type="text" name="busca" placeholder="Digite aqui sua busca..." />
					</form>		
							
                </div> 
				
                <div class="top_block bloco_menu"> 
				
	<div class="panel-group" id="accordion">
	
	<!-- INICIO DO ACCORDION -->
        <?php 
		/*Inicio do acordion*/		 
	
			$search = $_GET['busca'];
			
			$sql = "SELECT CD_CATEGORIA, 'Resultado da Pesquisa'  NM_CATEGORIA, PARAMETRO_IMAGEM FROM categoria WHERE CD_CATEGORIA = 1"; 
			$result = mysql_query($sql, $_SG['link']); 
			$i = 0;
			
			while($consulta = mysql_fetch_array($result)) {
				echo "<div class='panel panel-default'>";
				echo "<div class='panel-heading'><h4 class='panel-title'>
						<span class='$consulta[PARAMETRO_IMAGEM]'></span>
						<a data-toggle='collapse' data-parent='#accordion' href='#collapse".$i."'>$consulta[NM_CATEGORIA]</a>
						</h4></div>";
			
				/*Escrever itens secundários do menu*/
					
				$sql2 = "SELECT  CD_LOCAL, NM_LOCAL, CORD_X, CORD_Y,CD_ANDAR FROM andar_locais WHERE NM_LOCAL LIKE '%$search%'  ORDER BY CD_ANDAR, NR_MAPA";
				$result2 = mysql_query($sql2, $_SG['link']);
				
				echo "<div id='collapse".$i."' class='panel-collapse collapse'>";
				echo "<div class='panel-body'>";
					while($consulta2 = mysql_fetch_array($result2)) {
						echo "<p><a href=\"mapas.php?cordx=$consulta2[CORD_X]px&cordy=$consulta2[CORD_Y]px&id_nome=$consulta2[NM_LOCAL]&cd_andar=$consulta2[CD_ANDAR]\"> $consulta2[NM_LOCAL]</a></p>\n";
					}
				echo "</div>";
				echo "</div>";
			
				echo "</div>";
				
				$i++;
			} 	
	
	
	
	
	
		/*fim do acordion*/
		?>
		</div>
		</div>
	<!-- FIM DO ACCORDION -->
                    
        </div>
	
    <div class="background div_central" >

			<div class="bloco_extras">
					<div class="subBloco_outrosServicos">
                       <p>  </p>
                         
                    </div>
					
					<div class="subBloco_EventosSenac">
						<p><b>Eventos Senac</b></p>
						   <p><iframe width='250'  scrolling="no" height='200' frameborder='0' src='date/calendario.php'></iframe></p>
					</div>
					
					<div class="subBloco_MinhasAulas" id="postit">
					<p><b> Minhas Aulas </b></p>
                        <?php
                        $sql3 = "SELECT 
                                    CONCAT ('<B>',A. NM_LOCAL, '</B> - ' , (DATE_FORMAT(ADDDATE(CURDATE()-DATE_FORMAT(CURDATE(),'%w'),DIA_SEMANA),\"%d/%m\")),' - ', NM_DISCIPLINA ) AS DIA_AULA
                                FROM 
                                    evento_aluno E,
                                    andar_locais A,
                                    aluno AL,
                                    disciplina D
    
                                WHERE 
                                    E.CD_LOCAL = A.CD_LOCAL
                                    AND
                                    E.CD_ALUNO = AL.CD_ALUNO
                                    AND
                                    D.CD_DISCIPLINA = E.CD_DISCIPLINA
                                    AND
                                    AL.CD_ALUNO =".$_SESSION['usuarioID']." ORDER BY DIA_SEMANA"; 
										
                        $result3 = mysql_query($sql3, $_SG['link']); 
                        while($consulta3 = mysql_fetch_array($result3)) {
                        echo "<p>$consulta3[DIA_AULA]</p>\n";
                        }
                        ?>
                    </div>
			</div>
			
			<div class="bloco_mapas">		
				<div>
				<img src="mapas/LocalizeSenac-4andar.jpg" alt="" height="229" width="800" align="middle">
				</div>			
			</div>
			
	</div>
	
    <div class="center_block div_central">
        
    </div>
    
	<div id="rodape" class="bottom_block div_rodape" >
        <div class="content">
		<div style="float: left; width:40%; height: 100px;">
			<p class="rodape"><span> © 2010 Senac-RS - Todos os direitos Reservados.<br />
			Serviço Nacional de Aprendizagem Comercial do Rio Grande do Sul - Senac-RS <p><span>
		</div>
		
		<div class="div_redesSociais" style="float: left; width:28% ; height: 100px;"> <!-- style="position:relative; float:left; width: 220px; margin-left:15px;"> -->
			<a href="http://www.facebook.com/senacrsoficial"><img src="images/link_facebook.png" border="0"/></a>
            <a href="http://www.twitter.com/senacrs"><img src="images/link_twitter.png" border="0"/></a>
            <a href="http://www.youtube.com/senacrsoficial"><img src="images/link_youtube.png" border="0"/></a>
           </div>
		
			<ul class="logos clearfix">
				<li style="margin-top: 8px;">
					<a href="http://www.fecomercio-rs.org.br" target="_blank"><img src="images/logo_rodape_fecomercio.jpg" alt="Fecomércio" />
					</a>
				</li>
				
				<li>
					<a href="http://www.senacrs.com.br" target="_blank"><img src="images/logo_rodape_senac3.jpg" alt="SENAC" />
					</a>
				</li>
				
				<li>
					<a href="http://www.sesc-rs.com.br" target="_blank"><img src="images/logo_rodape_sesc.png" alt="SESC-RS" />
					</a>
				</li>
			</ul>
		
        </div>
    </div>
    
	<?php
        
		mysql_close($_SG['link']); 
    ?>  
	
</body>

</html>