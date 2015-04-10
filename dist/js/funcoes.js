function atualizaMapa(mapa){
    alert("vou atualizar!");
    $('#mapas').load(mapa);
}

function insertMarker(sala){
	$("#result").load("mapa.php?sala="+sala);
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