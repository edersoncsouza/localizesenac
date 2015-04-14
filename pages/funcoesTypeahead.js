// funcao utilizada para verificar se parte dos termos digitados constam na lista de locais fornecidos
			var substringMatcher = function(strs) {
				return function findMatches(q, cb) {
					var matches, substrRegex;
					 
					// an array that will be populated with substring matches
					matches = [];
					 
					// regex used to determine if a string contains the substring `q`
					substrRegex = new RegExp(q, 'i');
					 
					// iterate through the pool of strings and for any string that
					// contains the substring `q`, add it to the `matches` array
					$.each(strs, function(i, str) {
						if (substrRegex.test(str)) {
							// the typeahead jQuery plugin expects suggestions to a
							// JavaScript object, refer to typeahead docs for more info
							matches.push({ value: str });
						}
					});
					 
					cb(matches);
				};
			};
			 
			
			// coloca cada elemento do vetor $salas do php no vetor javascript salas
			// var salas = ['Sala 102', 'Sala 301', 'Sala 409', 'Sala 603', 'Sala 704'];
			/* var Vsalas = <?php echo '["' . implode('", "', $salas) . '"]' ?>; */
			
			// armazena o vetor PHP em um vetor JavaScript
			var JsonNomeAndarNumero = '<?php echo $JsonNomeAndarNumero ?>';
			
			var VjsonNomeAndarNumero = '<?php echo $JsonNomeAndarNumero ?>';
			
			// transforma o vetor em um objeto JSON
			var jsonObj = $.parseJSON(JsonNomeAndarNumero);
			
			// instancia o vetor source para uso do Typeahead
			var sourceArr = [];
 
			// loop de alimentacao do vetor sourceArr
			for (var i = 0; i < jsonObj.length; i++) {
			   sourceArr.push(jsonObj[i].descricao);
			}
			
			// instancia o controle typehead
			$('#idBusca .typeahead').typeahead(
				{
					hint: true,
					highlight: true,
					minLength: 1
				},
				{
					name: 'salas',
					displayKey: 'value',
					source: substringMatcher(sourceArr), // fonte das palavras chave to typeahead
					//source: substringMatcher(Vsalas)
						templates: {
							empty: [
								'<div class="empty-message" style="padding: 5px 10px; text-align: center;">',
								'Sem sugestões...',
								'</div>'
								].join('\n')
						}
				}
				).on('typeahead:selected', onSelected); // acrescenta o evento "ao selecionar" do menu dropdown
			
			function onSelected($e, datum) {
				console.log('function onSelected'); // loga no console a funcao utilizada
				console.log(datum); // loga no console o objeto de dados selecionado
				console.log(datum.value); // loga no console a propriedade valor do objeto de dados selecionado
				getAndarSala(datum.value); // chama a funcao de busca de correspondencia de andar e sala pela descricao e atualiza o mapa
			}
		
			function getAndarSala(descricao){
				
				for (var i = 0; i < VjsonNomeAndarNumero.length; i++) {
					
				   if(VjsonNomeAndarNumero[i].descricao == descricao){
					   
					    atualizaMapa(VjsonNomeAndarNumero[i].andar,VjsonNomeAndarNumero[i].numero);

				   }
				}
			}