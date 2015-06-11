
<!DOCTYPE HTML>

<html lang="br" class="no-js">

<head>

<meta charset="utf-8">
<title>Sistema de Login e Senha Criptografados</title>
<link href="../style.css" rel="stylesheet" />

</head>

<body>

<div id="conteudo">

<h1>Sistema de login e senha criptografados - Verificando Informações</h1>

<div class="borda"></div>

<!-- Recebendo e gravando os dados -->
<?php

include "conexao.php";
//Praticamente faço as mesmas validações que fizemos para o cadastrado do usuário no banco de dados.
//Recebendo os dados e tratando os mesmos para inserção no banco
$recebeEmail = filter_input(INPUT_POST, 'confereEmail', FILTER_VALIDATE_EMAIL);
$confereEmail = filter_input(INPUT_POST, 'confereEmail', FILTER_SANITIZE_MAGIC_QUOTES);

//Nesse if, faço uma conferência em relação ao e-mail informado. Se não for informado nenhum, retorno a mensagem para que o usuário informe corretamente
if ($recebeEmail == NULL ) {
echo "<p>Nenhum endereço de e-mail foi informado!";
echo "<p><a href='javascript:history.back();'>Voltar</a></p>";
return false;
}

//Aqui faço a segunda parte da verificação: vejo se no endereço de e-mail foi utilizado algum caractere especial
//Isso serve para evitar uma possível invasão sql no banco de dados, possibilitando assim a proteção e integridade dos dados
//Nesse caso, eu comparo os nomes. Se forem iguais, após passarem pelos filtros, eu inicio a criptografia. Se não forem, peço que volte à página anterior
else if ($recebeEmail != $confereEmail) {
echo "<p>Você informou o seguinte endereço de e-mail: <strong>$confereEmail</strong> .</p>";
echo "<p>Por favor, não utilize caracteres especiais (tais como aspas simples ou duplas e/ou barras!) no campo <strong>Informe o E-mail</strong>.</p>";
echo "<p><a href='javascript:history.back();'>Volte</a> para a página anterior e tente novamente! Obrigado!</p>";
return false;

} else {

/*
Agora vamos consultar no banco de dados para ver se existe realmente esse cadastro
Vamos verificar ambos os dados: E-mail e ainda se o campo "ATIVO" está setado como SIM
*/

$consultaInformacoes = mysql_query("SELECT * FROM usuario WHERE email = '$confereEmail' AND ativo = 'sim'") or die (mysql_error());
$verificaInformacoes = mysql_num_rows($consultaInformacoes);

//Aqui vou verificar se houve resultado positivo na pesquisa
if($verificaInformacoes == 1){

echo "<p>O e-mail informado (<strong><em>$confereEmail</em></strong>) consta de nossa base de dados.</p>
<p>Preencha os dados abaixo para obter acesso ao <strong>Conteúdo Exclusivo!</strong></p>";

echo "
<form method='post' action='atualizaDados.php'>
<fieldset>
<legend>Preencha os dados para obter acesso ao Conteúdo Exclusivo!</legend>
<label for='nomeUsuario'>Nome de Usuário:</label>
<input type='text' name='nomeUsuario' id='nomeUsuario' />
<div class='clear'></div>
<label for='senha'>Informe a senha:</label>
<input type='password' name='senha' id='senha' />
<div class='clear'></div>
<input type='hidden' name='emailControle' value='".$confereEmail."' />
<input type='submit' value='Atualizar informações' />
</fieldset>
</form>";

}
}
?>

</div>

</body>

</html>