// variavel de vetor de objetos nome andar e numero para fazer correspondencia na insercao do marker
var JsonNomeAndarNumeroObj;

// funcao que muda o andar do mapa
function mudaAndarMapa(andarTab){

	if(indoorLayer.getLevel() != andarTab ){ // se o andar atual do mapa for diferente do andar da sala do marcador
		levelControl.setLevel(andarTab); // muda o andar do mapa para o andar da sala
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

// funcao auxiliar para transformar nomes reduzidos e em maiusculas para nomes intermediarios em minusculas
function getNomeDiaSemana(diaReduzidoMaiusculas) {
	var apelidoDiaSemana = new Array("DOM","SEG","TER","QUA","QUI","SEX","SAB");
	var nomeDiaSemana = new Array("domingo","segunda","terça","quarta","quinta","sexta","sábado");
	
	var indice = apelidoDiaSemana.indexOf(diaReduzidoMaiusculas);
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
            diaDaSemana = diaDaSemanaIntermediario(i); // constroi e armazena a string do dia da semana ex.: segunda

            // DEFINE OS SELETORES DA CHECKBOXES
            seletorCheckboxIcloud = "#lembrarIcloud" + diaDaSemana; // icloud
            seletorCheckboxSms = "#lembrarSms" + diaDaSemana; // sms Google
            seletorCheckboxEmail = "#lembrarEmail" + diaDaSemana; // email Google
			seletorCheckboxZenvia = "#lembrarZenvia" + diaDaSemana; // sms Zenvia
			seletorCheckboxPhpmailer = "#lembrarPhpmailer" + diaDaSemana; // email Phpmailer
			
            // DEFINE OS SELETORES DAS INPUTBOXES
            seletorInputIcloud = "input#minutosIcloud" + diaDaSemana;
            seletorInputSms = "input#minutosSms" + diaDaSemana;
            seletorInputEmail = "input#minutosEmail" + diaDaSemana;
			seletorInputZenvia = "input#minutosZenvia" + diaDaSemana;
			seletorInputPhpmailer = "input#minutosPhpmailer" + diaDaSemana;

            // TESTA AS CHECKBOXES DE CADA TIPO E ARMAZENA SE ESTIVEREM MARCADAS
            if ($(seletorCheckboxIcloud).prop('checked')) { // icloud
                lembreteP = "icloud";
                minutosAntec = $(seletorInputIcloud).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true) // se o retorno da funcao de validacao for true (valor valido)
                    lembretesDiaDaSemana.push({
						"dia": diaDaSemana,
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec)); // se o retorno nao for true sera a propria mensagem de erro
            }

            if ($(seletorCheckboxZenvia).prop('checked')) { // zenvia
                lembreteP = "zsms";
                minutosAntec = $(seletorInputZenvia).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true) // se o retorno da funcao de validacao for true (valor valido)
                    lembretesDiaDaSemana.push({
						"dia": diaDaSemana,
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec)); // se o retorno nao for true sera a propria mensagem de erro
            }
			
			if ($(seletorCheckboxPhpmailer).prop('checked')) { // phpmailer
                lembreteP = "pemail";
                minutosAntec = $(seletorInputPhpmailer).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true) // se o retorno da funcao de validacao for true (valor valido)
                    lembretesDiaDaSemana.push({
						"dia": diaDaSemana,
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec)); // se o retorno nao for true sera a propria mensagem de erro
            }
			
            if ($(seletorCheckboxSms).prop('checked')) { // sms google
                lembreteP = "sms";
                minutosAntec = $(seletorInputSms).val(); // armazena a quantidade de minutos de antecedencia

                if (validaInputBox(minutosAntec) == true)
                    lembretesDiaDaSemana.push({
						"dia": diaDaSemana,
                        "tipoLembrete": lembreteP,
                        "minutos": minutosAntec
                    });
                else
                    bootbox.alert(validaInputBox(minutosAntec));
            }

            if ($(seletorCheckboxEmail).prop('checked')) { // email google
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
        return lembretesDiaDaSemana; // retorna o array com os lembretes de todos os dias da semana
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
            seletorTabContent = ('#' + diaDaSemana + '> p:nth-child(1)').replace(/\s+/g, ''); // constroi o seletor e remove espaços e quebras
            disciplinasDoDia = $(seletorTabContent).text(); // armazena as disciplinas do dia em uma string

			if(existeDisciplina(disciplinasDoDia)){ // se existe disciplina no dia
			
                var disciplinas = disciplinasDoDia.split(";"); // desmembra a string pelo caracter ;
				
                for (j = 0; j < disciplinas.length-1; j++) { // laco para percorrer as disciplinas (o -1 e para ignorar o que houver apos a ultima disciplina que tb possui ;)

					diaP = diaDaSemana; // armazena o dia da semana
					unidadeTurnoSalaDisciplina = disciplinas[j]; // recebe cada disciplina

					// desmembrar string da disciplina
					// separar Unidade, Turno, Sala e Disciplina pelo caracter "-"
					var palavras = unidadeTurnoSalaDisciplina.split("-"); // armazena as palavras em um array
					//ex.: Unidade 1 - Turno N - Sala: 301 - Tópicos Avançados em ADS ;

					if (!(palavras[0] === undefined || palavras[0] === null)){ // se existirem, armazena os itens desmembrados em variaveis
					
						var unidadeP = palavras[0].charAt(palavras[0].length - 2); // recebe a unidade - pega a segunda palavra, apenas o caract a duas posicoes do fim, pois o fim é um espaço branco
						var turnoP = palavras[1].charAt(palavras[1].length - 2); // recebe o turno - pega a segunda palavra, apenas o caract a duas posicoes do fim, pois o fim é um espaço branco
						var salaP = palavras[2].substring(7).replace(/\s+/g, ''); // recebe a sala - pega apenas o numero da sala removendo espacos em branco
						var disciplinaP = palavras[3];//.trim; // recebe a disciplina - pega a ultima palavra removendo espaços no inicio e final

						disciplinasDiaDaSemana.push({
							"unidade": unidadeP,
							"turno": turnoP,
							"dia": diaP,
							"sala": salaP,
							"disciplina": disciplinaP
						}); // armazena as informacoes no array
					}
                } // for das disciplinas do dia
			} // if existeDisciplina
        } // for dos dias da semana
		return disciplinasDiaDaSemana; // retorna o array com as disciplinas de todos os dias da semana
    } // function armazenaDisciplinas()
/*
 * FUNCAO QUE TRATA O RETORNO DA VERIFICACAO DOS EVENTOS ICLOUD NA TABELA aluno_lembrete
 */
function verificaEventoApple(){
	// executa o post para receber o retorno dos lembretes salvos na agenda do aluno
	var url = "icloud_calendar/verificarEventoApple.php";
	var objLembretesJsonApple;
	
		// recebe como retorno um json com os lembretes (lembretesJson)
	$.post(url, function(lembretesJsonIcloud) {
		if (lembretesJsonIcloud == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0
			console.log("O usuario logado não possui lembretes de disciplinas!");
		}
		else{ // se retornou com disciplinas
			//console.log("Lembretes de verificarEventoApple: " + lembretesJsonIcloud);
			
			objLembretesJsonApple = $.parseJSON(lembretesJsonIcloud); // transforma a string JSON em Javascript Array
			console.log(objLembretesJsonApple);	
			
			// PERCORRE TODAS AS DISCIPLINAS DO DIA QUE POSSUAM LEMBRETES
			for (i = 0; i < objLembretesJsonApple.length; i++) {
				
				diaDaSemanaLembrete = getNomeDiaSemana(objLembretesJsonApple[i].diaDaSemana); // recebe o dia da semana por extenso a partir de reduzido ex.: SEG -> segunda
				//alert(diaDaSemanaLembrete);
				
				var inputIcloud = "#minutosIcloud"+diaDaSemanaLembrete; // concatena a string para o input do dia da semana
				var labelIcloud = "#labelIcloud"+diaDaSemanaLembrete; // concatena a string para o label do dia da semana

				var arrayMinutos = objLembretesJsonApple[i].minutos; // recebe os minutos do lembrete
				
				$(inputIcloud).show(); // exibe o input para os minutos de Email neste dia da semana
				$(labelIcloud).show(); // exibe o label do input para os minutos de Email neste dia da semana
				$(inputIcloud).val(arrayMinutos); // recebe o valor de antecedencia do lembrete
				
				
				$('#lembrarIcloud'+diaDaSemanaLembrete).prop('checked', true); // marca a checkbox
			} //for (i = 0; i < objLembretesJsonApple.length; i++)
			
		
		} // se identificou disciplinas com lembretes	
		
	});
	
}

function verificaEventoGoogle(){

	// executa o post para receber o retorno dos lembretes salvos na agenda do aluno
	var url = "verificarEvento.php";

	// recebe como retorno um json com os lembretes (lembretesJson)
	$.post(url, function(lembretesJson) {
		if (lembretesJson == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0
			//bootbox.alert('Erro no envio de parâmetros!');
			console.log("O usuario logado não possui lembretes de disciplinas!");
		}
		else{ // se retornou com disciplinas
			objLembretesJson = $.parseJSON(lembretesJson); // transforma a string JSON em Javascript Array
			
			console.log(objLembretesJson);
			//[{"diaDaSemana":"TER","lembretes":["sms"],"minutos":[20]},{"diaDaSemana":"QUA","lembretes":["sms"],"minutos":[20]},{"diaDaSemana":"QUI","lembretes":["sms"],"minutos":[20]},{"diaDaSemana":"SEX","lembretes":["email","sms"],"minutos":[10,20]},{"diaDaSemana":"SEG","lembretes":["sms"],"minutos":[20]}] 
			//console.log("Aqui o objLembretesJson e: "+objLembretesJson);
			//console.log("Aqui o diaDaSemana e: "+objLembretesJson[0].diaDaSemana);
									
			// PERCORRE TODAS AS DISCIPLINAS DO DIA QUE POSSUAM LEMBRETES
			for (i = 0; i < objLembretesJson.length; i++) {
				
				diaDaSemanaLembrete = getNomeDiaSemana(objLembretesJson[i].diaDaSemana); // recebe o dia da semana por extenso a partir de reduzido ex.: SEG -> segunda
				//alert(diaDaSemanaLembrete);
				
				var inputSms = "#minutosSms"+diaDaSemanaLembrete; // concatena a string para o input do dia da semana
				var labelSms = "#labelSms"+diaDaSemanaLembrete; // concatena a string para o label do dia da semana
				var inputEmail = "#minutosEmail"+diaDaSemanaLembrete; // concatena a string para o input do dia da semana
				var labelEmail = "#labelEmail"+diaDaSemanaLembrete; // concatena a string para o label do dia da semana

				var arrayLembretes = objLembretesJson[i].lembretes; // recebe os lembretes do dia
				var arrayMinutos = objLembretesJson[i].minutos; // recebe os minutos do lembrete
				
				// IDENTIFICA O TIPO DE LEMBRETE E EXIBE OS LABELS E INPUTS DE ACORDO
				if (arrayLembretes.length > 1){ // se possuir os dois tipos de lembrete (sms / email)
					
					$(inputSms).show(); // exibe o input para os minutos de SMS neste dia da semana
					$(labelSms).show(); // exibe o label do input para os minutos de SMS neste dia da semana
					$(inputEmail).show(); // exibe o input para os minutos de Email neste dia da semana
					$(labelEmail).show(); // exibe o label do input para os minutos de Email neste dia da semana
					
					$(inputSms).val(arrayMinutos[arrayLembretes.indexOf('sms')]); // recebe o valor de antecedencia do lembrete de sms
					$(inputEmail).val(arrayMinutos[arrayLembretes.indexOf('email')]); // recebe o valor de antecedencia do lembrete de email
					// OBS: como os nomes dos lembretes e valores em minutos sao colocados juntos, foi usado
					// o indice do nome para identificar a posicao dos minutos no outro array
					
					$('#lembrarEmail'+diaDaSemanaLembrete).prop('checked', true); // marca a checkbox de email
					$('#lembrarSms'+diaDaSemanaLembrete).prop('checked', true); // marca a checkbox de sms
					
				}
				else{ // se possuir apenas um tipo de lembrete
					if (arrayLembretes[0] == "sms"){ // verifica se e do tipo sms
						//alert ("Lembrete de SMS");
						$(inputSms).show(); // exibe o input para os minutos de SMS neste dia da semana
						$(labelSms).show(); // exibe o label do input para os minutos de SMS neste dia da semana
						$(inputSms).val(arrayMinutos[0]); // recebe o valor de antecedencia do lembrete de sms
						
						$('#lembrarSms'+diaDaSemanaLembrete).prop('checked', true); // marca a checkbox de sms
					}
					else{ // caso contrario e do tipo email
						//alert("Lembrete de Email");
						$(inputEmail).show(); // exibe o input para os minutos de Email neste dia da semana
						$(labelEmail).show(); // exibe o label do input para os minutos de Email neste dia da semana
						$(inputEmail).val(arrayMinutos[0]); // recebe o valor de antecedencia do lembrete de email
						
						$('#lembrarEmail'+diaDaSemanaLembrete).prop('checked', true); // marca a checkbox de email
					}
				}

			} //for (i = 0; i < objLembretesJson.length; i++)
		
		} // se identificou disciplinas com lembretes
		
	}); // $.post(url, function(lembretesJson) 
	
}

function carregaCalendarioSemana(){
	// carrega a pagina com a lista dos dias da semana e disciplinas
	$("#minhaGrade").load("calendarioSemana.php",function(){
		
		// apos carregar insere a funcionalidade de voltar para a pagina principal ao botao sairDisciplina
		$('button#excluiDisciplina').click( function() {
			
			// armazena o dia da semana por extenso para as mensagens
			var diaExtenso = $(this).parent().parent().attr("id").toUpperCase();
			// armazena o dia da semana reduzido para usar como parametro
			var diaP = diaExtenso.substring(0, 3).replace(/[ÀÁÂÃÄÅ]/g,"A");
			
			// mensagem de confirmacao de exclusao
			bootbox.confirm("Tem certeza que deseja excluir a(s) disciplina(s) de "+diaExtenso+" ?", function(result) {

			if (result){// se o usuario confirmou a exclusao
				
				// chama metodo que busca em um php as disciplinas do aluno naquele dia
				// e enxerta a string de disciplinas em um bootbox.dialog
				buscarDisciplinasDia(diaP); 
				
			}
			
			}); 
		});
		
		// apos carregar insere a funcionalidade de voltar a pagina principal ao botao sairDisciplina
		$('button#sairDisciplina').click( function() {
			
			var arrayLembretes = armazenaLembretes();
			var arrayDisciplinas = armazenaDisciplinas();
			var arrayLembretesPhpmailer = [];
			var arrayLembretesZenvia = [];
			var arrayLembretesGoogle = [];
			var arrayLembretesApple = [];
			arrayDisciplinasPhpmailer = [];
			arrayDisciplinasZenvia = [];
			arrayDisciplinasGoogle = [];
			arrayDisciplinasApple = [];
			
			console.log("=== CONFIG ALUNO === \n Lembrete:\n" + JSON.stringify(arrayLembretes));
			console.log("Disciplinas:\n" + JSON.stringify(arrayDisciplinas) + "\n === CONFIG ALUNO ===");
			
			// SEPARA OS LEMBRETES POR TIPO DE LEMBRETE
			for (i = 0; i < arrayLembretes.length; i++){ // laço que percorre todos os lembretes e desmembra por tipo
				
				if( (arrayLembretes[i].tipoLembrete == "sms") || (arrayLembretes[i].tipoLembrete == "email")){ // se for lembrete Google						
					arrayLembretesGoogle.push(arrayLembretes[i]); // adiciona o lembrete do dia da semana ao array
					diaDaSemana = arrayLembretes[i].dia; // armazena o dia da semana do lembrete
					
					// SEPARA AS DISCIPLINAS DO DIA DO LEMBRETE INCLUIDO
					for (j = 0; j < arrayDisciplinas.length; j++){ // laco percorre todas as disciplinas do array
						
						if (arrayDisciplinas[j].dia == diaDaSemana){ // se o dia da disciplina for igual ao dia do lembrete
						arrayDisciplinasGoogle.push(arrayDisciplinas[j]); // armazena a disciplina no array de disciplinas
						}
					}
				}
				
				if (arrayLembretes[i].tipoLembrete == "icloud"){ // se o lembrete for do tipo icloud
					arrayLembretesApple.push(arrayLembretes[i]); // adiciona o lembrete no array da Apple
					diaDaSemana = arrayLembretes[i].dia; // armazena o dia da semana do lembrete
					
					// SEPARA AS DISCIPLINAS DO DIA DO LEMBRETE INCLUIDO
					for (j = 0; j < arrayDisciplinas.length; j++){ // laco percorre todas as disciplinas do array
						
						if (arrayDisciplinas[j].dia == diaDaSemana){ // se o dia da disciplina for igual ao dia do lembrete
						arrayDisciplinasApple.push(arrayDisciplinas[j]); // armazena a disciplina no array de disciplinas
						}
					}
				}
				
				if (arrayLembretes[i].tipoLembrete == "zsms"){ // se o lembrete for do tipo zsms
					arrayLembretesZenvia.push(arrayLembretes[i]); // adiciona o lembrete no array da Zenvia
					diaDaSemana = arrayLembretes[i].dia; // armazena o dia da semana do lembrete
					
					// SEPARA AS DISCIPLINAS DO DIA DO LEMBRETE INCLUIDO
					for (j = 0; j < arrayDisciplinas.length; j++){ // laco percorre todas as disciplinas do array
						
						if (arrayDisciplinas[j].dia == diaDaSemana){ // se o dia da disciplina for igual ao dia do lembrete
						arrayDisciplinasZenvia.push(arrayDisciplinas[j]); // armazena a disciplina no array de disciplinas
						}
					}
				}
				
				if (arrayLembretes[i].tipoLembrete == "pemail"){ // se o lembrete for do tipo pemail
					arrayLembretesPhpmailer.push(arrayLembretes[i]); // adiciona o lembrete no array da Phpmailer
					diaDaSemana = arrayLembretes[i].dia; // armazena o dia da semana do lembrete
					
					// SEPARA AS DISCIPLINAS DO DIA DO LEMBRETE INCLUIDO
					for (j = 0; j < arrayDisciplinas.length; j++){ // laco percorre todas as disciplinas do array
						
						if (arrayDisciplinas[j].dia == diaDaSemana){ // se o dia da disciplina for igual ao dia do lembrete
						arrayDisciplinasPhpmailer.push(arrayDisciplinas[j]); // armazena a disciplina no array de disciplinas
						}
					}
				}
				
			} // laco do array de lembretes
			
			// ENVIA OS ARRAYS PARA A CRIACAO DOS EVENTOS
			if(arrayLembretesGoogle[0] != null){ // se o array de lembretes Google não estiver vazio
				var url = "inserirEvento.php";
					$.post(
							url,
							{'arrayLembretes' : arrayLembretesGoogle, 'arrayDisciplinas' : arrayDisciplinasGoogle}
					);
			}
			
			if(arrayLembretesZenvia[0] != null){ // se o array de lembretes Zenvia não estiver vazio
				var url = "inserirEventoZenvia.php";
					$.post(
							url,
							{'arrayLembretes' : arrayLembretesZenvia, 'arrayDisciplinas' : arrayDisciplinasZenvia}
					);
			}
			
			if(arrayLembretesPhpmailer[0] != null){ // se o array de lembretes Phpmailer não estiver vazio
				var url = "inserirEventoPhpmailer.php";
					$.post(
							url,
							{'arrayLembretes' : arrayLembretesPhpmailer, 'arrayDisciplinas' : arrayDisciplinasPhpmailer}
					);
			}
			
			if(arrayLembretesApple[0] != null){ // se o array de lembretes Apple contiver lembretes icloud
				
				var elementosIguais = false; // inicia com a variavel afirmando que a quantidade de lembretes ou minutos nao sao iguais
				var disciplinasIguais = false; // inicia com a variavel afirmando que as disciplinas com lembretes na tela e em aluno_lembrete nao sao iguais
				
				// RETORNA E COMPARA OS LEMBRETES DO USUARIO DA TABELA aluno_lembrete COM OS LEMBRETES ARMAZENADOS DE alunoConfig
				var url = "icloud_calendar/verificarEventoApple.php";
					var objLembretesJson; // array javascript de lembretes vindos de aluno_lembrete
	
				// RECEBE COMO RETORNO UM JSON COM OS LEMBRETES (lembretesJson)
				$.post(url, function(lembretesJsonIcloud) {
					if (lembretesJsonIcloud == 0){// se nao houverem lembretes icloud no banco
						console.log("if(arrayLembretesApple[0] != null) : O usuario logado ainda não possui lembretes de disciplinas do tipo icloud!");
						
						// se chegou aqui ainda nem existem lembretes gravados e tem que inserir os lembretes
						
						// ARMAZENA OS ARRAYS UTILIZANDO O STORAGE API DO HTML5
						localStorage.clear();
						localStorage.setItem('arrayLembretesApple', JSON.stringify(arrayLembretesApple));
						localStorage.setItem('arrayDisciplinasApple',JSON.stringify(arrayDisciplinasApple));
						
						// ABRE A PAGINA PARA AUTENTICACAO NO ICLOUD
						window.location.href = "icloud_calendar/addons/icloud-master/PHP/icloud-original.php";
					}
					else{ // se retornou com disciplinas
					
						console.log("if(arrayLembretesApple[0] != null) lembretesJsonIcloud: " + lembretesJsonIcloud);

						objLembretesJson = $.parseJSON(lembretesJsonIcloud); // transforma a string JSON em Javascript Array (ordenado por dia)	
						
						arrayLembretesApple.sort(dynamicSort("dia")); // ordena o array pelo dia da semana para comparacao
						
						// PROCESSO DE VERIFICACAO SE HOUVE ALTERACOES NOS LEMBRETES ICLOUD DE CADA DIA
						// O array arrayLembretesApple vem da verificacao de todos os checkboxes do tipo icloud da area academico
						// O array objLembretesJson vem do retorno da query na tabela aluno_lembrete
						
						if(arrayLembretesApple.length == objLembretesJson.length){ // se os dois arrays tiverem o mesmo tamanho
							
							elementosIguais = true; // parte do principio que sao iguais
							
							for (j = 0; j < arrayLembretesApple.length; j++) { // laco que percorre todo o array
								
								// se em algum dos elementos os nomes dos dias e minutos nao forem iguais em ambos
								if ( !( (arrayLembretesApple[j].dia == getNomeDiaSemana(objLembretesJson[j].diaDaSemana)) && (arrayLembretesApple[j].minutos == objLembretesJson[j].minutos) )){
									
									//alert("DIA - Array tela: " + arrayLembretesApple[j].dia + " - Array banco: " + objLembretesJson[j].diaDaSemana);
									//alert("MINUTOS - Array tela: " + arrayLembretesApple[j].minutos + " - Array banco: " + objLembretesJson[j].minutos);
									elementosIguais = false; // afirma que algum dos elementos nao e igual
								}
								
							}
													
							if(elementosIguais){ // se os dias e minutos dos lembretes forem iguais, confirma as disciplinas
								
								// COMPARA SE NÃO HOUVERAM ALTERACOES NAS DISCIPLINAS E TURNOS POR DIA
								// verificar em aluno_lembrete, se no dia e turno de cada lembrete a unidade, sala e disciplina sao as mesmas de arrayDisciplinas
								// ex. objLembretesJson: [{"diaDaSemana":"QUA","minutos":"7","turno":"N","unidade":"1","sala":"603","disciplina":"28"},{"diaDaSemana":"QUI","minutos":"8","turno":"N","unidade":"1","sala":"409","disciplina":"31"},
								// ex. objDisciplinasAlunoJson: [{"dia":"QUA","turno":"N","unidade":"1","sala":"603","disciplina":"28"},
								
								var urlDisciplina = "buscarDisciplinasAluno.php";
								var objDisciplinasAlunoJson; // array de objetos javascript para as disciplinas de aluno_disciplina
								
								$.post(urlDisciplina, function(disciplinasAluno) {
								
									if (disciplinasAluno == 0){// se nao houverem disciplinas para o aluno
										console.log("buscarDisciplinasAluno : O usuario logado não possui disciplinas!");
									}
									else{ 
										objDisciplinasAlunoJson = $.parseJSON(disciplinasAluno); // transforma em array de objetos javascript
										
										console.log("Disciplinas com lembretes icloud(Array objLembretesJson, vindo de aluno_lembrete): " +  JSON.stringify(objLembretesJson));
										console.log("Disciplinas do aluno(Array: objDisciplinasAlunoJson, vindo de aluno_disciplina): " +  JSON.stringify(objDisciplinasAlunoJson));
										
										disciplinasIguais = true; //inicia afirmando que as disciplinas sao iguais pois a logica do filter adiante e ao contrario
										
										for (i = 0; i < arrayLembretesApple.length; i++) { // laco que percorre todo o array de disciplinas com lembretes icloud

											
											if(!(
													objDisciplinasAlunoJson.filter(function (el) { // filtra um registro de aluno_disciplina exatamente igual ao aluno_lembrete
													  return el.dia == objLembretesJson[i].diaDaSemana &&
															 el.turno == objLembretesJson[i].turno &&
															 el.unidade == objLembretesJson[i].unidade &&
															 el.sala == objLembretesJson[i].sala &&
															 el.disciplina == objLembretesJson[i].disciplina;
													}) 
												) // nega o resultado 
											){ // se nao encontrou executa o alert e muda o valor do boolean
												alert("Esta disciplina nao combina com aluno_lembrete: " + JSON.stringify(objDisciplinasAlunoJson[i]));
												disciplinasIguais = false;
											}
											else{ // se achou igual
												console.log("Achei disciplina em aluno_disciplina que combina com aluno_lembrete: " + JSON.stringify(objDisciplinasAlunoJson[i]));
											}
											
										}
										
										if(disciplinasIguais){ // se os lembretes vindos da tela sao iguais aos armazenados em banco
											
											// carrega a pagina principal evitando alteracoes
											var url = "principal.php";
											$("body").load(url);
											window.location.href = "principal.php";
										}
										else{ // se chegou aqui houveram alteracoes nas disciplinas e tem que reinserir os lembretes
											
											
											// ARMAZENA OS ARRAYS UTILIZANDO O STORAGE API DO HTML5
											localStorage.clear();
											localStorage.setItem('arrayLembretesApple', JSON.stringify(arrayLembretesApple));
											localStorage.setItem('arrayDisciplinasApple',JSON.stringify(arrayDisciplinasApple));
											
											// ABRE A PAGINA PARA AUTENTICACAO NO ICLOUD
											window.location.href = "icloud_calendar/addons/icloud-master/PHP/icloud-original.php";
											
										}										
	
									}
								});
								
								
								// SE HOUVERAM ALTERACOES ENVIA PARA ICLOUD-ORIGINAL.PHP
								// SENAO APENAS RETORNA PARA PRINCIPAL.PHP
								
							} // FIM DO if(elementosIguais){ // se os dias e minutos dos lembretes forem iguais, confirma as disciplinas
							
							// se chegou aqui, a quantidade de lembretes e igual mas os dias ou minutos sao diferentes e tem que reinserir os lembretes
							
							$(document).ajaxStop(function () { // se nao houver nenhuma requisicao ajax rodando
								  
								if(!elementosIguais){
									// ARMAZENA OS ARRAYS UTILIZANDO O STORAGE API DO HTML5
									localStorage.clear();
									localStorage.setItem('arrayLembretesApple', JSON.stringify(arrayLembretesApple));
									localStorage.setItem('arrayDisciplinasApple',JSON.stringify(arrayDisciplinasApple));
									
									// ABRE A PAGINA PARA AUTENTICACAO NO ICLOUD
									window.location.href = "icloud_calendar/addons/icloud-master/PHP/icloud-original.php";
								}
							});
							
							
						} //FIM DO if(arrayLembretesApple.length == objLembretesJson.length){ // se os dois arrays tiverem o mesmo tamanho
						
							$(document).ajaxStop(function () { // se nao houver nenhuma requisicao ajax rodando
								if(arrayLembretesApple.length != objLembretesJson.length){
									// ARMAZENA OS ARRAYS UTILIZANDO O STORAGE API DO HTML5
									localStorage.clear();
									localStorage.setItem('arrayLembretesApple', JSON.stringify(arrayLembretesApple));
									localStorage.setItem('arrayDisciplinasApple',JSON.stringify(arrayDisciplinasApple));
									
									// ABRE A PAGINA PARA AUTENTICACAO NO ICLOUD
									window.location.href = "icloud_calendar/addons/icloud-master/PHP/icloud-original.php";
								}
							});
					}
				
				}); // fim do postverificarEventoApple.php
				
				
			}else{ // se o array de lembretes icloud vindo de configAluno.php estiver vazio (se desmarcou todos os checkboxes icloud)
				
				// verifica se existem lembretes icloud na tabela aluno_lembrete
				var url = "icloud_calendar/verificarEventoApple.php";
	
				// recebe como retorno um json com os lembretes (lembretesJsonIcloud)
				$.post(url, function(lembretesJsonIcloud) {
					if (lembretesJsonIcloud != 0){// caso existam eventos do tipo icloud em aluno_lembrete
						// se houverem 
							// apagar os lembretes do banco
							$.post("icloud_calendar/excluirLembretesApple.php");
							
							// autenticar no icloud e apagar eventos
							window.location.href = "icloud_calendar/excluirEventoApple.php";
					}
				});	
			}
			
			// DEPOIS DE GRAVAR TODOS OS LEMBRETES NA AGENDA DO USUARIO VOLTA A PAGINA PRINCIPAL
			var url = "principal.php";
			$("body").load(url);
			
		}); // $('button#sairDisciplina').click( function()
		
		// apos carregar insere a funcionalidade de abrir o modal aos botoes incluiDisciplina e editaDisciplina
		$("#incluiDisciplina, #editaDisciplina").click(function(){
				
			// monta a variavel de titulo do modal
			var tituloModalGrade = "DISCIPLINA DE " + $(this).parent().parent().attr("id").toUpperCase();
				
			// define o titulo do modal
			$(".modal-title").text(tituloModalGrade);
				
			// exibe o modal
			$("#gradeModal").modal('show');
				
		});
		
		// inicializa com os inputs e labels de lembretes ocultos
		$('.labelIcloud').hide();
		$('.minutosIcloud').hide();
		$('.minutosIcloud').val('');
		
		$('.labelZenvia').hide();
		$('.minutosZenvia').hide();
		$('.minutosZenvia').val('');
		
		$('.labelPhpmailer').hide();
		$('.minutosPhpmailer').hide();
		$('.minutosPhpmailer').val('');
		
		$('.labelEmail').hide();
		$('.minutosEmail').hide();
		$('.minutosEmail').val('');
		
		$('.labelSms').hide();
		$('.minutosSms').hide();							
		$('.minutosSms').val('');


		// verificar se o aluno for autenticado pelo google mandar verificar eventos google
		if(tipoUsuario == "google"){
			verificaEventoGoogle();	// funcao que verifica se existem eventos gravados na agenda
		}
		// para todos verificar os lembretes Pemail, Zsms, icloud
		verificaEventoApple();
		
		// define o que fazer ao selecionar/desselecionar os chekboxes de lembrete de SMS
		$('.lembrarSms').change(function () { // quando algum checkbox desta classe mudar de status
		
			// separa o dia da semana para identificar labels e inputs a ocultar e exibir
			var stringDiaSemana = $(this).attr('id'); // Recebe o id do checkbox ex.: lembrarSmssegunda
			var addTo = stringDiaSemana.substr(10); // Separa uma substring do id ex.: segunda (substr pega da posicao ate o final da string)
			var inputSms = "#minutosSms"+addTo; // concatena a string para o input do dia da semana
			var labelSms = "#labelSms"+addTo; // concatena a string para o label do dia da semana
		
			if ($(this).is(":checked")) { // se ele estiver marcado
				$(inputSms).show(); // exibe o input para os minutos de SMS neste dia da semana
				$(labelSms).show(); // exibe o label do input para os minutos de SMS neste dia da semana
			}
			else {// se o checkbox de lembrete nao estiver selecionado
				$(inputSms).hide(); // oculta todos os inputs desta classe
				$(inputSms).val(''); // zera os valores de todos os inputs desta classe
				$(labelSms).hide();	// oculta todos os labels desta classe
			}
		});
		
		// define o que fazer ao selecionar/desselecionar os chekboxes de lembrete de E-mail 
		$('.lembrarEmail').change(function () {
			
			// separa o dia da semana para identificar labels e inputs a ocultar e exibir
			var stringDiaSemana = $(this).attr('id'); // Recebe o id do checkbox ex.: lembrarEmailsegunda
			var addTo = stringDiaSemana.substr(12); // Separa uma substring do id ex.: segunda (substr pega da posicao ate o final da string)
			var inputEmail = "#minutosEmail"+addTo; // concatena a string para o input do dia da semana
			var labelEmail = "#labelEmail"+addTo; // concatena a string para o label do dia da semana
			
			if ($(this).is(":checked")) {
				$(inputEmail).show(); // exibe o input para os minutos de Email neste dia da semana
				$(labelEmail).show(); // exibe o label do input para os minutos de Email neste dia da semana
			}
			else {// se o checkbox de lembrete nao estiver selecionado
				$(inputEmail).hide(); // exibe o input para os minutos de Email neste dia da semana
				$(inputEmail).val(''); // zera os valores de todos os inputs desta classe
				$(labelEmail).hide(); // oculta todos os labels desta classe
			}
		});
		
		// define o que fazer ao selecionar/desselecionar os chekboxes de lembrete de iCloud 
		$('.lembrarIcloud').change(function () {
			
			// separa o dia da semana para identificar labels e inputs a ocultar e exibir
			var stringDiaSemana = $(this).attr('id'); // Recebe o id do checkbox ex.: lembrarIcloudsegunda
			var addTo = stringDiaSemana.substr(13); // Separa uma substring do id ex.: segunda (substr pega da posicao ate o final da string)
			var inputIcloud = "#minutosIcloud"+addTo; // concatena a string para o input do dia da semana
			var labelIcloud = "#labelIcloud"+addTo; // concatena a string para o label do dia da semana
			
			if ($(this).is(":checked")) {
				$(inputIcloud).show(); // exibe o input para os minutos de iCloud neste dia da semana
				$(labelIcloud).show(); // exibe o label do input para os minutos de Email neste dia da semana
			}
			else {// se o checkbox de lembrete nao estiver selecionado
				$(inputIcloud).hide(); // exibe o input para os minutos de iCloud neste dia da semana
				$(inputIcloud).val(''); // zera os valores de todos os inputs desta classe
				$(labelIcloud).hide(); // oculta todos os labels desta classe
			}
		});
		
		// define o que fazer ao selecionar/desselecionar os chekboxes de lembrete do Zenvia 
		$('.lembrarZenvia').change(function () {
			
			// separa o dia da semana para identificar labels e inputs a ocultar e exibir
			var stringDiaSemana = $(this).attr('id'); // Recebe o id do checkbox ex.: lembrarIcloudsegunda
			var addTo = stringDiaSemana.substr(13); // Separa uma substring do id ex.: segunda (substr pega da posicao ate o final da string)
			var inputZenvia = "#minutosZenvia"+addTo; // concatena a string para o input do dia da semana
			var labelZenvia = "#labelZenvia"+addTo; // concatena a string para o label do dia da semana
			
			if ($(this).is(":checked")) {
				$(inputZenvia).show(); // exibe o input para os minutos de iCloud neste dia da semana
				$(labelZenvia).show(); // exibe o label do input para os minutos de Email neste dia da semana
			}
			else {// se o checkbox de lembrete nao estiver selecionado
				$(inputZenvia).hide(); // exibe o input para os minutos de iCloud neste dia da semana
				$(inputZenvia).val(''); // zera os valores de todos os inputs desta classe
				$(labelZenvia).hide(); // oculta todos os labels desta classe
			}
		});
		
		// define o que fazer ao selecionar/desselecionar os chekboxes de lembrete do Phpmailer 
		$('.lembrarPhpmailer').change(function () {
			
			// separa o dia da semana para identificar labels e inputs a ocultar e exibir
			var stringDiaSemana = $(this).attr('id'); // Recebe o id do checkbox ex.: lembrarIcloudsegunda
			var addTo = stringDiaSemana.substr(16); // Separa uma substring do id ex.: segunda (substr pega da posicao ate o final da string)
			var inputPhpmailer = "#minutosPhpmailer"+addTo; // concatena a string para o input do dia da semana
			var labelPhpmailer = "#labelPhpmailer"+addTo; // concatena a string para o label do dia da semana
			
			if ($(this).is(":checked")) {
				$(inputPhpmailer).show(); // exibe o input para os minutos de iCloud neste dia da semana
				$(labelPhpmailer).show(); // exibe o label do input para os minutos de Email neste dia da semana
			}
			else {// se o checkbox de lembrete nao estiver selecionado
				$(inputPhpmailer).hide(); // exibe o input para os minutos de iCloud neste dia da semana
				$(inputPhpmailer).val(''); // zera os valores de todos os inputs desta classe
				$(labelPhpmailer).hide(); // oculta todos os labels desta classe
			}
		});
		
	});// final do load calendarioSemana.php	
}

// funcao vinda de: http://stackoverflow.com/questions/1129216/sort-array-of-objects-by-property-value-in-javascript
function dynamicSort(property) {
    var sortOrder = 1;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a,b) {
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

function atualizaIcloud(){
	// ARMAZENA OS ARRAYS UTILIZANDO O STORAGE API DO HTML5
	localStorage.clear();
	localStorage.setItem('arrayLembretesApple', JSON.stringify(arrayLembretesApple));
	localStorage.setItem('arrayDisciplinasApple',JSON.stringify(arrayDisciplinasApple));
	
	// ABRE A PAGINA PARA AUTENTICACAO NO ICLOUD
	window.location.href = "icloud_calendar/addons/icloud-master/PHP/icloud-original.php";
}
	
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
			
			mudaAndarMapa(JsonNomeAndarNumeroObj[i].andar);	// muda o andar no mapa		
			insereMarker(JsonNomeAndarNumeroObj[i].andar, JsonNomeAndarNumeroObj[i].numero); // acrescenta o marker no mapa

		}
	}
}

/* FUNCOES PARA USO COM A AUTENTICACAO DO USUARIO */

// funcao que busca o aluno no BD e se nao existir cria
function consultarAluno(matriculaP, senhaP, nomeP, tipoUsuarioP){
	var url = "consultarAlunoOauth2.php";
	
	console.log("Sou o funcoes.js rodando a funcao consultarAluno, aqui tipoUsuario recebeu: " + tipoUsuarioP);
	
	// executa o post enviando o parametro matricula
	// recebe como retorno um json com o retorno da existencia do aluno (alunoJson)
	$.post(url,{ matricula: matriculaP, autenticacao: tipoUsuarioP }, function(alunoJson) {
		
		console.log(alunoJson); // envia para o console o Json do usuario
		
		if (alunoJson == 0){// caso o retorno de consultarAluno.php seja = 0
			// aluno nao existe no banco
			
			var celularP = ""; // variavel para o celular, criada para possivelmente pedir ao usuario esta entrada
			var ativoP = "S"; // variavel ativo recebe o valor padrao, sera utilizada pelo administrador para desativar usuarios
			
			var url2 = "inserirAlunoOauth2.php";
			
			// executa o post para inserir o aluno no banco
			$.post(url2,{ matricula: matriculaP, password: senhaP, nome: nomeP,
							celular: celularP, email: matriculaP, autenticacao: tipoUsuarioP, ativo: ativoP}, 
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
			window.location.replace("principal.php"); // caso o aluno exista redireciona para a pagina principal
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


	
