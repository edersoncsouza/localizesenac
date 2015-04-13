var salas = new Bloodhound({
   datumTokenizer: function (salas) {
            return Bloodhound.tokenizers.whitespace(salas.sala);
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //limit: 10,
  prefetch: {
    url: '../data/dataTypeahead.json',
        filter: function (data) {
            //console.log("data", data.properties.tags)
			//return $.map(data.response.songs, function (song) {
            //return $.map(data.properties.tags, function (sala) {
			//return $.map(data, function (sala) {
			
			return data.properties.tags;
			
                /*return {
                    andar: sala.level,
                    sala: sala.room,
					nome: sala.name
                };*/
            //});
        }
	}
});
 
// kicks off the loading/processing of `local` and `prefetch`
salas.initialize();

// instantiate the typeahead UI
$('#idBusca .typeahead').typeahead(
      {
          hint: true,
          highlight: true,
          minLength: 1
      },
      {
          name: 'salas',
          //displayKey: 'sala',
		  displayKey: function(salas) {
			return salas.tags.name;        
		  },
          source: salas.ttAdapter(),
          templates: {
              empty: [
              '<div class="empty-message">',
              'unable to find any results that match the current query',
              '</div>'
              ].join('\n'),
              //suggestion: Handlebars.compile(['<p><strong>{{andar}}</strong> by {{sala}}</p>'])
          }
});
