var clndr = {};

$( function() {

moment.locale("pt-br");
  // PARDON ME while I do a little magic to keep these events relevant for the rest of time...
  var currentMonth = moment().format('YYYY-MM');
  var nextMonth    = moment().add(1,'month').format('YYYY-MM');

  var events = [
    { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },
    { date: currentMonth + '-' + '19', title: 'Cat Frisbee', location: 'Jefferson Park' },
    { date: currentMonth + '-' + '23', title: 'Kitten Demonstration', location: 'Center for Beautiful Cats' },
    { date: nextMonth + '-' + '07',    title: 'Small Cat Photo Session', location: 'Center for Cat Photography' }
  ];

  clndr = $('#full-clndr').clndr({
    template: $('#full-clndr-template').html(),
    events: events,
    forceSixRows: true
  });

  $('#mini-clndr').clndr({
    template: $('#mini-clndr-template').html(),
    events: events,
	daysOfTheWeek : ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],// inserido para adicionar os titulos dos dias da semana personalizados
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


});