<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LocalizeSenac - Sistema de Indoor Mapping para a Faculdade Senac Porto Alegre">
	<meta name="keywords" content="Indoor Mapping,mapeamento interno,Faculdade Senac Porto Alegre">
    <meta name="author" content="Ederson Souza">

	<!-- CLNDR.js css 
	<link rel="stylesheet" href="dist/css/clndr2.css">-->

  <link rel="stylesheet/less" type="text/css" href="testeClndr/css/clndr.less" />
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>

  <script src="testeClndr/js/less.js" type="text/javascript"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- Underscore -->
	<script src="dist/components/underscore/js/underscore-min.js" type="text/javascript"></script>	
	
	<!-- Moment -->
	<script src="dist/components/moment/js/moment.js" type="text/javascript"></script>

	<!-- CLNDR -->
	<script src="dist/components/CLNDR/js/clndr.min.js" type="text/javascript"></script>
	
	<script src="testeClndr/js/site.js" type="text/javascript"></script>
	
</head>

<body>
	<div class="wrap"> 
        <div id="mini-clndr">
          <script id="mini-clndr-template" type="text/template">

            <div class="controls">
              <div class="clndr-previous-button">&lsaquo;</div><div class="month"><%= month %></div><div class="clndr-next-button">&rsaquo;</div>
            </div>

            <div class="days-container">
              <div class="days">
                <div class="headers">
                  <% _.each(daysOfTheWeek, function(day) { %><div class="day-header"><%= day %></div><% }); %>
                </div>
                <% _.each(days, function(day) { %><div class="<%= day.classes %>" id="<%= day.id %>"><%= day.day %></div><% }); %>
              </div>
              <div class="events">
                <div class="headers">
                  <div class="x-button">x</div>
                  <div class="event-header">EVENTS</div>
                </div>
                <div class="events-list">
                  <% _.each(eventsThisMonth, function(event) { %>
                    <div class="event">
                      <a href="<%= event.url %>"><%= moment(event.date).format('MMMM Do') %>: <%= event.title %></a>
                    </div>
                  <% }); %>
                </div>
              </div>
            </div>

          </script>
        </div>
		
	</div>  
		  
</body>
</html>