<!DOCTYPE HTML>

<html lang="br" class="no-js">

<head>

<meta charset="utf-8">
<title>Sistema de Login e Senha Criptografados</title>
<link href="../style.css" rel="stylesheet" />

</head>

<body>

<div id="conteudo">

<h1>Sistema de login e senha criptografados</h1>

<div class="borda"></div>

<!-- Recebendo e gravando os dados -->
<?php

include "conexao.php";

//URL para a qual o usuário será enviado após ter preenchido todos os campos corretamente
$urlAcesso = "index.php";

//Recebendo os dados e tratando os mesmos para inserção no banco
$recebeNomeUsuario = filter_input(INPUT_POST, 'nomeUsuario', FILTER_SANITIZE_SPECIAL_CHARS);
$confereNomeUsuario = filter_input(INPUT_POST, 'nomeUsuario', FILTER_SANITIZE_MAGIC_QUOTES);
$recebeEmail = filter_input(INPUT_POST, 'emailControle', FILTER_VALIDATE_EMAIL);
$recebeSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

//Nesse if, faço uma conferência em relação ao e-mail informado; se não for um e-mail validado pelo filtro, ele retornará a mensagem abaixo.
//Se o email for válido, ele passa para a segunda parte da verificação
if ($recebeEmail == NULL ) {
echo "<p>Retorne e digite um e-mail válido por favor!";
echo "<p><a href='javascript:history.back();'>Voltar</a></p>";
return false;
}

//Nesse if, faço uma conferência em relação à senha informada. Se não for informada nenhuma, retorno a mensagem para que o usuário informe algo!
if ($recebeSenha == NULL ) {
echo "<p>Retorne e informe uma senha por favor!";
echo "<p><a href='javascript:history.back();'>Voltar</a></p>";
return false;
}

//Aqui faço a segunda parte da verificação: vejo se no nome de usuário foi utilizado algum caractere especial
//Isso serve para evitar uma possível invasão sql no banco de dados, possibilitando assim a proteção e integridade dos dados
//Nesse caso, eu comparo os nomes. Se forem iguais, após passarem pelos filtros, eu inicio a criptografia. Se não forem, peço que volte à página anterior
else if ($confereNomeUsuario != $recebeNomeUsuario) {
echo "<p>Você informou o seguinte Nome de Usuário: <strong>$recebeNomeUsuario</strong> .</p>";
echo "<p>Por favor, não utilize caracteres especiais (tais como aspas simples ou duplas, assim como barras!) no campo <strong>Nome de Usuário</strong>.</p>";
echo "<p><a href='javascript:history.back();'>Volte</a> para a página anterior e tente novamente! Obrigado!</p>";
return false;

} else {

//Aqui vou agora, criptografar as informações antes de enviá-las ao banco de dados
echo "<h3>Atualizando informações em nosso banco de dados</h3>";

//Aqui vamos criar a função que vai criptografar os dados.
//Serão necessários criptografar apenas o endereço de e-mail e a senha informada

//Função para criptografar a senha
function criptoSenha($criptoSenha){
return sha1(md5($criptoSenha));
}
//Função para criptografar o e-mail
function criptoNomeUsuario($criptoNomeUsuario){
return sha1(md5($criptoNomeUsuario));
}
//Aqui realizo a criptografia do endereço de e-mail
$criptoNomeUsuario = criptoNomeUsuario(filter_input(INPUT_POST, 'nomeUsuario', FILTER_SANITIZE_MAGIC_QUOTES));
//Aqui realizo a criptografia da senha informada do usuário
$criptoSenha = criptoSenha(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS));

//Agora vamos atualizar os dados no banco
$atualizaDados = mysql_query("UPDATE usuario SET userlogin = '$criptoNomeUsuario', passlogin = 'criptoSenha' WHERE email = '$recebeEmail'") or die (mysql_error());

echo "<p>Seu cadastro foi atualizado com sucesso!</p>";
echo "<p>Aguarde enquanto lhe encaminhamos para a página de acesso ao <strong>Conteúdo Exclusivo</strong>!";
echo "<meta http-equiv=\"refresh\" content=\"5;URL=\".$urlAcesso.\">";
}

?>

</div>

</body>

</html>