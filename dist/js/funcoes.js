// variavel de vetor de nome andar e numero para uso do typeahead
var JsonNomeAndarNumero;

// variavel de vetor de saida para fonte para o typeahead
var sourceArr = [];

// variavel de vetor de objetos nome andar e numero para fazer correspondencia na insercao do marker
var JsonNomeAndarNumeroObj;


// funcao que insere o marker no mapa
function insereMarker(andarP, salaP){

	// remove o layer de marcadores existentes no mapa
	map.removeLayer(markers);

	// apaga o marcador do FeatureGroup markers
	markers.removeLayer(marker);

	// cria o marcador do ponto selecionado, do tipo Bouncem 
	marker = new L.marker(Vmarkers[salaP], {bounceOnAdd: true,bounceOnAddOptions: {duration: 1500, height: 100, loop: true}})
				.bindPopup("Sala: " + salaP +"<br><a href=\"http://www.senacrs.com.br/faculdades.asp?Unidade=63\" target=\"_blank\">Senac RS</a><br>")
				.openPopup();

	// adiciona o marcador no FeatureGroup markers
	markers.addLayer(marker);
				
	// adiciona o layer de marcadores ao mapa
	map.addLayer(markers);

}

// funcao mantida apenas para consulta de passagem de parametros por AJAX
function atualizaMapaAjax(andarP, salaP){

	 $.ajax({
        url: "mapa.php",
        data: {
            andar : andarP, //parametro 1
            sala : salaP // parametro 2
            }
    })
    .done (function() {
		alert("Success: ") ; 
		})
    .fail (function() {
		alert("Error")   ; 
		})
    ;

}

// funcao mantida apenas para comparacao de passagem comum com passagem de parametros por AJAX
function atualizaMapa(andar, sala){

	$("#result").load('mapa.php?sala='+sala+'&andar='+andar);

}

// funcao que seleciona o dia da semana corrente na area denominada Minhas Aulas
function selecionaTab(){
    $('#' + diaDaSemana()).addClass("in active"); // seleciona e ativa o texto da tab do dia atual
    $('[href=#' + diaDaSemana() + ']').tab('show'); // seleciona a tab (guia) do dia atual
}

// funcao auxiliar para transformar dias numericos em dias string
function diaDaSemana() {

    var d = new Date(); // instancia a data atual
    var weekday = new Array(7); // cria o array para os nomes
    weekday[0] = "dom";
    weekday[1] = "seg";
    weekday[2] = "ter";
    weekday[3] = "qua";
    weekday[4] = "qui";
    weekday[5] = "sex";
    weekday[6] = "sab";

    var n = weekday[d.getDay()]; // armazena o dia da semana pelo numero do dia
    return n; // retorna o dia da semana
}

// funcao para ocultar div de resultados de pesquisa na versao anterior do sistema
function verificaInput() {
    var busca = document.forms["searchForm"]["inputBusca"].value;
    if (busca == "")
        $("#conteudo_mostrar_pesquisas").hide();
}

// funcao para validacao de pesquisa, evitando chamar search.php sem parametros
function validaBusca() {
    $("#searchForm").submit(function (e) { // quando houver submissao do formulario

        $("#conteudo_mostrar_pesquisas").hide(); // oculta area de resultado da pesquisa 
        e.preventDefault(); // evita que o comportamento padrao ACTION
        var busca = document.forms["searchForm"]["inputBusca"].value; // armazena o conteudo do inputBusca

        if (busca != "") { // se o inputBusca nao estiver vazio
            busca = "search.php/?inputBusca=" + busca; // concatena o input com o caminho da pagina de busca
            $("#conteudo_mostrar_pesquisas").show(); // exibe a area de resultado da pesquisa 
            atualizaPesquisas(busca); // chama o metodo atualizaPesquisas do instrucao.js
        }
        else { // se o inputBusca estiver vazio
            $("#conteudo_mostrar_pesquisas").hide(); // oculta area de resultado da pesquisa
        }

    });
}

// funcao que cria o vetor de descricoes de sala para o typeahead e o vetor de objetos para correspondencia
function criaVetorTypeahead(vetorPhpCodificado){
	
	// armazena o vetor PHP em um vetor JavaScript
	JsonNomeAndarNumero = vetorPhpCodificado;
			
	// transforma o vetor em um objeto JSON
	JsonNomeAndarNumeroObj = $.parseJSON(JsonNomeAndarNumero);
			
	// instancia o vetor source para uso do Typeahead
	sourceArr = [];
 
	// loop de alimentacao do vetor sourceArr
	for (var i = 0; i < JsonNomeAndarNumeroObj.length; i++) {
	   sourceArr.push(JsonNomeAndarNumeroObj[i].descricao);
	}
	
	// retorna o vetor com apenas os nomes das salas
	return sourceArr;
}

// funcao que busca a correspondencia da descrição da sala com andar e numero da sala
function getAndarSala(descricao){

	for (var i = 0; i < JsonNomeAndarNumeroObj.length; i++) {

		if(JsonNomeAndarNumeroObj[i].descricao == descricao){
						
			insereMarker(JsonNomeAndarNumeroObj[i].andar, JsonNomeAndarNumeroObj[i].numero);

		}
	}
}

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
			 		
// funcao executada ao selecionar um item do menu dropdown do typeahead
function onSelected($e, datum) {
	console.log('function onSelected'); // loga no console a funcao utilizada
	console.log(datum); // loga no console o objeto de dados selecionado
	console.log(datum.value); // loga no console a propriedade valor do objeto de dados selecionado
	getAndarSala(datum.value); // chama a funcao de busca de correspondencia de andar e sala pela descricao e atualiza o mapa
}
			

