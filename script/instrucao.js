function abrirPag(valor){
var url = valor;

xmlRequest.open("GET",url,false);
xmlRequest.onreadystatechange = mudancaEstado;
xmlRequest.send(null);

if (xmlRequest.readyState == 1) {
document.getElementById("conteudo_mostrar").innerHTML = "<img src='images/loader.gif'>";
}

return url;
}

function atualizaServicos(valor2){
var url2 = valor2;

xmlRequest.open("GET",url2,false);
xmlRequest.onreadystatechange = mudancaEstadoServicos;
xmlRequest.send(null);

if (xmlRequest.readyState == 1) {
document.getElementById("conteudo_mostrar_servicos").innerHTML = "<img src='images/loader.gif'>";
}

return url2;
}

function atualizaPesquisas(valor3){
var url3 = valor3;

xmlRequest.open("GET",url3,false);
xmlRequest.onreadystatechange = mudancaEstadoPesquisas;
xmlRequest.send(null);

if (xmlRequest.readyState == 1) {
document.getElementById("conteudo_mostrar_pesquisas").innerHTML = "<img src='images/loader.gif'>";
}

return url3;
}

function mudancaEstado(){
if (xmlRequest.readyState == 4){
document.getElementById("conteudo_mostrar").innerHTML = xmlRequest.responseText;

}

}

function mudancaEstadoServicos(){
if (xmlRequest.readyState == 4){
document.getElementById("conteudo_mostrar_servicos").innerHTML = xmlRequest.responseText;

}

}

function mudancaEstadoPesquisas(){
if (xmlRequest.readyState == 4){
document.getElementById("conteudo_mostrar_pesquisas").innerHTML = xmlRequest.responseText;

}

}