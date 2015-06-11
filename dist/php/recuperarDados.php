<!-- Fonte: http://www.andrebuzzo.com.br/sistema-de-login-e-senha-criptografados-parte-02/#.VXnfMHUViko -->

<!DOCTYPE HTML>

<html lang="br" class="no-js">

<head>

<meta charset="utf-8">
<title>Sistema de Login e Senha Criptografados</title>
<link href="../style.css" rel="stylesheet" />

</head>

<body>

<div id="conteudo">

<h1>Sistema de login e senha criptografados - Recuperação de Dados</h1>

<div class="borda"></div>

<div class="clear"></div>

<!-- Formulário para acesso -->
<p>Para recuperar seus dados, por favor, preencha o formulário abaixo!<p>

<!-- A lógica que empregaremos aqui é a seguinte: Vamos pedir o endereço de email e vamos conferir se o mesmo está cadastrado no sistema.
Se o endereço estiver cadastrado, enviaremos um e-mail para que ele possa acessar uma nova página e informar novamente seus dados para acessar o Conteúdo exclusivo dele! -->

<form method="post" action="enviaInformacoes.php" id="recuperaDados">
<fieldset>
<legend>Recuperação de Dados</legend>
<label for="nomeUsuario">Informe o e-mail:</label>
<input type="text" name="email" id="email" />
<div class="clear"></div>
<input type="submit" value="Recuperar Dados" />

</fieldset>
</form>

<div class="borda"></div>

</div>

</body>

</html>