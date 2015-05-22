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

	<!-- CLNDR.js css -->
	<link rel="stylesheet" href="dist/css/clndr2.css">
	
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- Underscore -->
	<script src="dist/components/underscore/js/underscore-min.js" type="text/javascript"></script>	
	
	<!-- Moment -->
	<script src="dist/components/moment/js/moment.js" type="text/javascript"></script>

	<!-- CLNDR -->
	<script src="dist/components/CLNDR/js/clndr.min.js" type="text/javascript"></script>
	
	<!-- <script src="testeClndr/site.js" type="text/javascript"></script>	 CLNDR -->

<script>
$(document).ready(function() {
	
	//$('#clndr-grid').clndr(); // carregando o CLNDR.js
	var clndr = {};
	
	 $('#mini-clndr').clndr({
    template: $('#mini-clndr-template').html(),
    events: events,
    clickEvents: {
      click: function(target) {
        if(target.events.length) {
          var daysContainer = $('#mini-clndr').find('.days-container');
          daysContainer.toggleClass('show-events', true);
          $('#mini-clndr').find('.x-button').click( function() {
            daysContainer.toggleClass('show-events', false);
          });
        }
      }
    },
    adjacentDaysChangeMonth: true,
    forceSixRows: true
  });
  
    $('#clndr-3').clndr({
    template: $('#clndr-3-template').html(),
    events: events,
    showAdjacentMonths: false
  });
  
  
  $('#calendar').clndr({
  template: $('#calendar-template').html(),
  events: [
    { date: '2013-09-09', title: 'CLNDR GitHub Page Finished', url: 'http://github.com/kylestetz/CLNDR' }
  ],
  clickEvents: {
    click: function(target) {
      console.log(target);
    },
    onMonthChange: function(month) {
      console.log('you just went to ' + month.format('MMMM, YYYY'));
    }
  },
  doneRendering: function() {
    console.log('this would be a fine place to attach custom event handlers.');
  }
});
  
});
</script>


</head>

<body>
	
<div id="mini-clndr"><div class="clndr">

            <div class="controls">
              <div class="clndr-previous-button">‹</div><div class="month">May</div><div class="clndr-next-button">›</div>
            </div>

            <div class="days-container">
              <div class="days">
                <div class="headers">
                  <div class="day-header">S</div><div class="day-header">M</div><div class="day-header">T</div><div class="day-header">W</div><div class="day-header">T</div><div class="day-header">F</div><div class="day-header">S</div>
                </div>
                <div class="day past adjacent-month last-month calendar-day-2015-04-26 calendar-dow-0" id="">26</div><div class="day past adjacent-month last-month calendar-day-2015-04-27 calendar-dow-1" id="">27</div><div class="day past adjacent-month last-month calendar-day-2015-04-28 calendar-dow-2" id="">28</div><div class="day past adjacent-month last-month calendar-day-2015-04-29 calendar-dow-3" id="">29</div><div class="day past adjacent-month last-month calendar-day-2015-04-30 calendar-dow-4" id="">30</div><div class="day past calendar-day-2015-05-01 calendar-dow-4" id="">1</div><div class="day past calendar-day-2015-05-02 calendar-dow-5" id="">2</div><div class="day past calendar-day-2015-05-03 calendar-dow-6" id="">3</div><div class="day past calendar-day-2015-05-04 calendar-dow-0" id="">4</div><div class="day past calendar-day-2015-05-05 calendar-dow-1" id="">5</div><div class="day past calendar-day-2015-05-06 calendar-dow-2" id="">6</div><div class="day past calendar-day-2015-05-07 calendar-dow-3" id="">7</div><div class="day past calendar-day-2015-05-08 calendar-dow-4" id="">8</div><div class="day past calendar-day-2015-05-09 calendar-dow-5" id="">9</div><div class="day past event calendar-day-2015-05-10 calendar-dow-6" id="">10</div><div class="day past calendar-day-2015-05-11 calendar-dow-0" id="">11</div><div class="day past calendar-day-2015-05-12 calendar-dow-1" id="">12</div><div class="day past calendar-day-2015-05-13 calendar-dow-2" id="">13</div><div class="day past calendar-day-2015-05-14 calendar-dow-3" id="">14</div><div class="day past calendar-day-2015-05-15 calendar-dow-4" id="">15</div><div class="day past calendar-day-2015-05-16 calendar-dow-5" id="">16</div><div class="day past calendar-day-2015-05-17 calendar-dow-6" id="">17</div><div class="day past calendar-day-2015-05-18 calendar-dow-0" id="">18</div><div class="day past event calendar-day-2015-05-19 calendar-dow-1" id="">19</div><div class="day past calendar-day-2015-05-20 calendar-dow-2" id="">20</div><div class="day past calendar-day-2015-05-21 calendar-dow-3" id="">21</div><div class="day today past calendar-day-2015-05-22 calendar-dow-4" id="">22</div><div class="day event calendar-day-2015-05-23 calendar-dow-5" id="">23</div><div class="day calendar-day-2015-05-24 calendar-dow-6" id="">24</div><div class="day calendar-day-2015-05-25 calendar-dow-0" id="">25</div><div class="day calendar-day-2015-05-26 calendar-dow-1" id="">26</div><div class="day calendar-day-2015-05-27 calendar-dow-2" id="">27</div><div class="day calendar-day-2015-05-28 calendar-dow-3" id="">28</div><div class="day calendar-day-2015-05-29 calendar-dow-4" id="">29</div><div class="day calendar-day-2015-05-30 calendar-dow-5" id="">30</div><div class="day calendar-day-2015-05-31 calendar-dow-6" id="">31</div><div class="day adjacent-month next-month calendar-day-2015-05-31 calendar-dow-0" id="">31</div><div class="day adjacent-month next-month calendar-day-2015-06-01 calendar-dow-1" id="">1</div><div class="day adjacent-month next-month calendar-day-2015-06-02 calendar-dow-2" id="">2</div><div class="day adjacent-month next-month calendar-day-2015-06-03 calendar-dow-3" id="">3</div><div class="day adjacent-month next-month calendar-day-2015-06-04 calendar-dow-4" id="">4</div><div class="day adjacent-month next-month calendar-day-2015-06-05 calendar-dow-5" id="">5</div>
              </div>
              <div class="events">
                <div class="headers">
                  <div class="x-button">x</div>
                  <div class="event-header">EVENTS</div>
                </div>
                <div class="events-list">
                  
                    <div class="event">
                      <a href="">May 10th: Persian Kitten Auction</a>
                    </div>
                  
                    <div class="event">
                      <a href="">May 19th: Cat Frisbee</a>
                    </div>
                  
                    <div class="event">
                      <a href="">May 23rd: Kitten Demonstration</a>
                    </div>
                  
                </div>
              </div>
            </div>

          </div></div>
		  
		  
</body>
</html>