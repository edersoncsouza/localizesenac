// variavel de vetor de objetos nome andar e numero para fazer correspondencia na insercao do marker
var JsonNomeAndarNumeroObj;

// funcao que muda o andar do mapa
function mudaAndarMapa(andarTab){

	if(indoorLayer.getLevel() != andarTab ){ // se o andar atual do mapa for diferente do andar da sala do marcador
		indoorLayer.setLevel(andarTab); // muda o andar do mapa para o andar da sala
	}
}

function existeDisciplina(conteudoPainel){
	existe = true;
	
	if(conteudoPainel.replace(/\s+/g, '') == ("Não tem aulas no dia de hoje").replace(/\s+/g, ''))
			existe = false;
	
	return existe;
	
}

// funcao que insere o marker no mapa
function insereMarker(andarP, salaP){

	// remove o layer de marcadores existentes no mapa
	map.removeLayer(markers);

	// apaga o marcador do FeatureGroup markers
	markers.removeLayer(marker);

	try {
		// cria o marcador do ponto selecionado, do tipo Bounce 
		marker = new L.marker(Vmarkers[salaP], {bounceOnAdd: true,bounceOnAddOptions: {duration: 1500, height: 100, loop: true}})
					.bindPopup("Sala: " + salaP +"<br><a href=\"http://www.senacrs.com.br/faculdades.asp?Unidade=63\" target=\"_blank\">Senac RS</a><br>")
					.openPopup();

		// adiciona o marcador no FeatureGroup markers
		markers.addLayer(marker);
					
		// adiciona o layer de marcadores ao mapa
		map.addLayer(markers);
	}
	catch(e) {
		console.log(e.name + ' - ' + e.message);
	}
	
	

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

// funcao auxiliar para transformar dias numericos em dias string
function diaDaSemanaIntermediario(diaNumerico) {

    var weekday = new Array(7); // cria o array para os nomes
    weekday[0] = "domingo";
    weekday[1] = "segunda";
    weekday[2] = "terça";
    weekday[3] = "quarta";
    weekday[4] = "quinta";
    weekday[5] = "sexta";
    weekday[6] = "sábado";

    var n = weekday[diaNumerico]; // armazena o dia da semana pelo numero do dia
    return n; // retorna o dia da semana
}

function getNomeDiaSemana(data) {
	var apelidoDiaSemana = new Array("DOM","SEG","TER","QUA","QUI","SEX","SAB");
	var nomeDiaSemana = new Array("domingo","segunda","terça","quarta","quinta","sexta","sábado");
	
	var indice = apelidoDiaSemana.indexOf(data);
	var retornoNomeDiaSemana = nomeDiaSemana[indice];
	
	return retornoNomeDiaSemana;
	
}

// function armazenaLembretes() -  
					// verifica quais checkboxes de lembretes estao marcados em cada dia da semana
					// armazena os tipos e minutos de antecedencia de lembretes
					// devolve um array [ [diaDaSemana: SEG, Lembretes[ [tipo: sms, minutos: 10], [tipo:icloud, minutos: 30] ] ], [diaDaSemana: TER...
						
					// onde verifica as informacoes
					// #divCheckboxesApple => div das checkboxes icloud
					// #divCheckboxesGoogle => div das checkboxes de sms e email
					
	function armazenaLembretes() {
        //var diaDaSemana = new Array("DOM","SEG","TER","QUA","QUI","SEX","SAB");
        var disciplinasDiaDaSemana = []; // cria o array de disciplinas do dia da semana
        var lembretesDiaDaSemana = []; // cria o array de lembretes do dia da semana
        var minutosAntec; // varivel que armazenara a quantidade de minutos de antecedencia
        var lembreteP; // variavel do tipo de lembrete (SMS / email)
        var seletorCheckboxIcloud, seletorCheckboxSms, seletorCheckboxEmail;
        var seletorInputIcloud, seletorInputSms, seletorInputEmail;
        var diaDaSemana;

        for (i = 0; i < 7; i++) {
            diaDaSemana = diaDaSemanaIntermediario(i); // constroe e armazena a string do dia da semana ex.: segunda

            // DEFINE OS SELETORES DA CHECKBOXES
            seletorCheckboxIcloud = "#lembrarIcloud" + diaDaSemana;
            seletorCheckboxSms = "#lembrarSms" + diaDaSemana;
            seletorCheckboxEmail = "#lembrarEmail" + diaDaSemana;

            // DEFINE OS SELETORES DAS INPUTBOXES
            seletorInputIcloud = "input#minutosIcloud" + diaDaSemana;
            seletorInputSms = "input#minutosSms" + diaDaSemana;
            seletorInputEmail = "input#minutosEmail" + diaDaSemana;

            // TESTA AS CHECKBOXES DE CADA TIPO E ARMAZENA SE ESTIVEREM MARCADAS
            if ($(seletorCheckboxIcloud).prop('checked')) {
                lembreteP = "icloud";
                minutosAntec = $(seletorInputIcloud).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true)
                    lembretesDiaDaSemana.push({
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec));
            }

            if ($(seletorCheckboxSms).prop('checked')) {
                lembreteP = "sms";
                minutosAntec = $(seletorInputSms).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true)
                    lembretesDiaDaSemana.push({
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec));
            }

            if ($(seletorCheckboxEmail).prop('checked')) {
                lembreteP = "email";
                minutosAntec = $(seletorInputEmail).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true)
                    lembretesDiaDaSemana.push({
                        "dia": diaDaSemana,
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec));
            }
        } // for dos dias da semana
        return lembretesDiaDaSemana;
    } // function armazenaLembretes()
					
					
// funcao de validacao de valores de inputbox
// recebe o valor do inputbox
// retorna true para valores validos e mensagem de erro para invalidos
function validaInputBox(valorMinutos) {
    var retorno;

    if (!valorMinutos.match(/^\d+$/)) {
        retorno = "Valor não numérico no campo minutos!";
    } else {
        if (parseInt(valorMinutos, 10) > 60) {
            retorno = "O valor excede 60 minutos!";
        } else {
            retorno = true;
        }
    }
    return retorno;
}
					
// function armazenaDisciplinas() -  
// verifica quais as disciplinas do dia em cada dia da semana
// armazena unidade, turno, dia, sala e disciplina
// devolve um array "unidade": unidadeP, "turno": turnoP, "dia": diaP, "sala": salaP, "disciplina": disciplinaP
// onde verifica as informacoes
// #segunda > p:nth-child(1) => texto da disciplina
// se possuir duas disciplinas o ponto e virgula servira para separar
function armazenaDisciplinas() {
        var unidadeTurnoSalaDisciplina;
        var disciplinasDiaDaSemana = [];
        var seletorTabContent;
        var diaDaSemana;
        var disciplinasDoDia;
        var diaP;

        for (i = 0; i < 7; i++) { // laco para percorrer os dias da semana
            diaDaSemana = diaDaSemanaIntermediario(i); // constroe e armazena a string do dia da semana ex.: segunda
            seletorTabContent = ('#' + diaDaSemana + '> p:nth-child(1)').replace(/\s+/g, ''); // constroe o seletor e remove espaços e quebras
            disciplinasDoDia = $(seletorTabContent).text(); // armazena as disciplinas do dia em uma string

                var disciplinas = disciplinasDoDia.split(";"); // desmebra a string pelo caracter ;

				bootbox.alert("Dia: " + diaDaSemana + " - " + disciplinasDoDia);
				
                for (j = 0; j < disciplinas.length; j++) { // laco para percorrer as disciplinas
                    if (disciplinas[j] != '') { // pois a ultima disciplina tambem tera ;

                        diaP = diaDaSemana; // armazena o dia da semana
                        unidadeTurnoSalaDisciplina = disciplinas[j]; // recebe cada disciplina

                        // desmembrar string da disciplina
                        // separar Unidade, Turno, Sala e Disciplina pelo caracter "-"
                        var palavras = unidadeTurnoSalaDisciplina.split("-"); // armazena as palavras em um array
                        //ex.: Unidade 1 - Turno N - Sala: 301 - Tópicos Avançados em ADS ;
						
						if (palavras[1] != null){
						
							var unidadeP = palavras[0].charAt(palavras[0].length - 2); // recebe a unidade - pega a segunda palavra, apenas o caract a duas posicoes do fim, pois o fim é um espaço branco
							var turnoP = palavras[1].charAt(palavras[1].length - 2); // recebe o turno - pega a segunda palavra, apenas o caract a duas posicoes do fim, pois o fim é um espaço branco
							var salaP = palavras[2].substring(7).replace(/\s+/g, ''); // recebe a sala - pega apenas o numero da sala removendo espacos em branco
							var disciplinaP = palavras[3].trim; // recebe a disciplina - pega a ultima palavra removendo espaços no inicio e final

							disciplinasDiaDaSemana.push({
								"unidade": unidadeP,
								"turno": turnoP,
								"dia": diaP,
								"sala": salaP,
								"disciplina": disciplinaP
							}); // armazena as informacoes no array
						}
                    } // se a disciplina nao esta em branco
                } // for das disciplinas do dia

        } // for dos dias da semana
    } // function armazenaDisciplinas()

/* FUNCOES PARA USO COM O TYPEAHEAD */

// variavel de vetor de nome andar e numero para uso do typeahead
var JsonNomeAndarNumero;

// variavel de vetor de saida para fonte para o typeahead
var sourceArr = [];

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

// funcao que busca a correspondencia da descrição da sala com andar e numero da sala
function getAndarSala(descricao){

	for (var i = 0; i < JsonNomeAndarNumeroObj.length; i++) {

		if(JsonNomeAndarNumeroObj[i].descricao == descricao){
						
			insereMarker(JsonNomeAndarNumeroObj[i].andar, JsonNomeAndarNumeroObj[i].numero);

		}
	}
}

/* FUNCOES PARA USO COM A AUTENTICACAO DO USUARIO */

// funcao que busca o aluno no BD e se nao existir cria
function consultarAluno(matriculaP, senhaP, nomeP){
	var url = "consultarAlunoOauth2.php";
	
	// executa o post enviando o parametro matricula
	// recebe como retorno um json com o retorno da existencia do aluno (alunoJson)
	$.post(url,{ matricula: matriculaP }, function(alunoJson) {
		
		console.log(alunoJson); // envia para o console o Json do usuario
		
		if (alunoJson == 0){// caso o retorno de consultarAluno.php seja = 0
			// aluno nao existe no banco
			
			var celularP = ""; // variavel para o celular, criada para possivelmente pedir ao usuario esta entrada
			var ativoP = "S"; // variavel ativo recebe o valor padrao, sera utilizada pelo administrador para desativar usuarios
			
			var url2 = "inserirAlunoOauth2.php";
			
			// executa o post para inserir o aluno no banco
			$.post(url2,{ matricula: matriculaP, password: senhaP, nome: nomeP,
							celular: celularP, email: matriculaP, ativo: ativoP}, 
								function(alunoInseridoJson) {
								
									var idNome;
									
									// se deu retorno 0 (nao afetou linhas da tabela)
									if (alunoInseridoJson == 0){
										alert("Aluno não inserido!");
									}
									else{
										if (isNaN(alunoInseridoJson)) // se retornou um valor nao numerico (Erro do mysql)
											alert("Erro do MySql: " + alunoInseridoJson);
										else{ // se retornou valor numerico != 0, este e o Id de insercao
											window.location.replace("principal.php"); // caso o aluno tenha sido inserido redirecioina para a pagina principal
										}
									}
							});
			
		}
		else{ // se o aluno existir
			window.location.replace("principal.php"); // caso o aluno exista redirecioina para a pagina principal
		}

	});
	
}

/* FUNCOES UTILIZADAS NA VERSAO ANTERIOR DO SISTEMA */

// funcao para ocultar div de resultados de pesquisa na versao anterior do sistema
function verificaInput() {
    var busca = document.forms["searchForm"]["inputBusca"].value;
    if (busca == "")
        $("#conteudo_mostrar_pesquisas").hide();
}

// funcao para validacao de pesquisa, evitando chamar search.php sem parametros na versao anterior do sistema
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

	
