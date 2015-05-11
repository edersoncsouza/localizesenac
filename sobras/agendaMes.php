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
	
    <!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="dist/components/eventCalendar/css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="dist/components/eventCalendar/css/eventCalendar_theme_responsive.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- eventCalendar -->
	<script src="dist/components/eventCalendar/js/jquery.eventCalendar.min.js" type="text/javascript"></script>		
	
	<!-- Moment -->
	<script src="dist/components/moment/js/moment.js" type="text/javascript"></script>
	
<script>
$(document).ready(function() {

	$('#collapseOne').collapse("hide");

	// eventos "inline" para a agenda
	var eventsInline = [
						{ 	"date": "2015-05-08 21:40:00",
							"type": "Orientação",
							"title": "Orientação sobre andamento do projeto",
							"url": "http://www.event1.com/" },
						{ "date": "2015-05-19 17:30:00",
							"type": "Reunião",
							"title": "Reunião com a equipe de segurança",
							"url": "http://www.event2.com/" }
						];
	
	// parametros de configuracao do eventCalendar
	$("#inlineEventcalendar").eventCalendar({
		//jsonData: eventsInline,
		eventsjson: 'event.humanDate.json.php',
		eventsScrollable: true,
		jsonDateFormat: 'human',
		monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho","Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
		dayNames: [ 'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado' ],
		dayNamesShort: [ 'Dom','Seg','Ter','Qua', 'Qui','Sex','Sáb' ],
		txt_noEvents: "Não existem eventos para este período",
		txt_SpecificEvents_prev: "",
		txt_SpecificEvents_after: "eventos:",
		txt_next: "seguinte",
		txt_prev: "anterior",
		txt_NextEvents: "Próximos eventos:",
		txt_GoToEventUrl: "Ir ao evento"
	}); 
});

</script>

</head>

<body>

			<div class="row"> <!-- Eventos Acadêmicos -->
                <div class="hidden-xs col-lg-12 col-md-12">
                    <div class="panel panel-primary"> <!-- Agenda Acadêmica -->
                        <div class="panel-footer">
                            <span class="pull-left"><strong>Agenda Acadêmica</strong></span>
                            <div class="clearfix"></div>
                        </div>
					
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">12</div>
                                    <div>Eventos</div>
                                </div>
                            </div>
                        </div>
                        
						<div class="accordion" id="accordion2">
						  <div class="accordion-group">
							<div class="accordion-heading">
							  <a class="accordion-toggle " data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
								
								<div class="panel-footer" id="agenda">
											<span class="pull-left">Exibir Agenda</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-down"></i></span>
											<div class="clearfix"></div>					
								
								</div>
							  </a>
							</div>
							<div id="collapseOne" class="accordion-body collapse in">
							  <div class="accordion-inner">
							  
								<div id="inlineEventcalendar">
									<!-- AREA QUE RECEBE O calendarEvent-->
								</div>
								
							  </div>
							</div>
						  </div>
						</div>	
						
                    </div>
                </div>
			</div>
			
			
</body>

</html>