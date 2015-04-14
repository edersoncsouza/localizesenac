function insereMarker(andarP, salaP){

// remove o layer de marcadores existentes no mapa
map.removeLayer(markers);

// apaga o marcador do FeatureGroup markers
markers.removeLayer(marker);

// cria o marcador do ponto selecionado, do tipo Bouncem 
marker = new L.marker(Vmarkers[salaP], {bounceOnAdd: true,bounceOnAddOptions: {duration: 1500, height: 100, loop: true}})
			.bindPopup(salaP+"<br><a href=\"http://www.senacrs.com.br/faculdades.asp?Unidade=63\">Senac RS</a><br>")
			.openPopup();

// adiciona o marcador no FeatureGroup markers
markers.addLayer(marker);
			
// adiciona o layer de marcadores ao mapa
map.addLayer(markers);

}

function atualizaMapaAjax(andarP, salaP){

	 $.ajax({
        url: "mapa.php",
        data: {
            andar : andarP,
            sala : salaP
            }
    })
    .done (function() {
		alert("Success: ") ; 
		map.invalidateSize(false);
		
		})
    .fail   (function()     { alert("Error")   ; })
    ;

}

function atualizaMapa(andar, sala){

	$("#result").load('mapa.php?sala='+sala+'&andar='+andar);

}

function selecionaTab(){
    $('#' + diaDaSemana()).addClass("in active"); // seleciona e ativa o texto da tab do dia atual
    $('[href=#' + diaDaSemana() + ']').tab('show'); // seleciona a tab (guia) do dia atual
}

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


function atualizaAndar(andar) {
    alert("Entrei");
    var url = './principal.php?cd_andar=' + andar;
    $.get(url, function (data) {
        $("#frmDivUpdate").html(data);
    });
}

function verificaInput() {
    var busca = document.forms["searchForm"]["inputBusca"].value;
    if (busca == "")
        $("#conteudo_mostrar_pesquisas").hide();
}

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