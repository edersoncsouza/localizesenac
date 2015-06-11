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
$recebeEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$confereEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_MAGIC_QUOTES);

//Nesse if, faço uma conferência em relação ao e-mail informado. Se não for informado nenhum, retorno a mensagem para que o usuário informe corretamente
if ($recebeEmail == NULL ) {
echo "<p>O endereço de e-mail precisa ser informado!";
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
<p>Acesse sua caixa de entrada. Se a mensagem não for encontrada, verifique se não está na caixa de spam!</p>";

//Aqui vou enviar o e-mail com os dados para que o cliente faça o acesso à página
//O e-mail será enviado utilizando o PHPMailer
//Para executar essa função, é necessário que o sistema esteja hospedado em algum servidor web | SERVIDORES LOCAIS NÃO ENVIAM E-MAIL
include ("phpmailer/class.phpmailer.php");

$headers = "Content-type:text/html; charset=utf-8";
$headers = "From: seuEmail@seuDominio.com.br";

$destino = $recebeEmail;
$de = utf8_decode("Contato - André Buzzo");
$assunto = "..:: Recuperação de dados ::..";
$html = utf8_decode('
<hr />
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recuperação de Dados</title>
<style type="text/css">
<!--
.style1 {
font-family: "Trebuchet MS", Arial;
font-size: 16px;
color: #FFFFFF;
}
.style4 {
font-family: "Trebuchet MS", Arial;
font-size: 12px;
color: #333333;
font-weight: bold;
}
-->
</style></head>

<body>
<form method="post" action="http://seuDominio.com.br/exclusivo/atualizaInformacoes.php">
<fieldset>
<legend>Recuperação de Dados de Acesso</legend>
<label for="informacao">Para recuperar seus dados, clique no botão "Atualizar Meus Dados"!</label>
<input type="hidden" name="confereEmail" value="'.$confereEmail.'" /><br />
<input type="submit" value="Atualizar Meus Dados" />
</fieldset>
</form>
</body>
</html>
<hr />');

$mail = new PHPMailer(); // criando a nova classe - instnciando

$mail->IsSMTP = ("smtp");
$mail->Mailer = ("mail");
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth = true;
//$mail->CharSet = 'utf-8';
$mail->Username = ("seuEmail@seuDominio.com.br");
$mail->Password = ("suaSenha");
$mail->Sender = ("seuEmail@seuDominio.com.br");
$mail->From = ("seuEmail@seuDominio.com.br");
$mail->FromName = $de;
$mail->AddAddress ($destino);
//$mail->Addbcc ($para);
$mail->AddReplyTo("$email","$nome");
$mail->Wordwrap = 50;
$mail->Subject = ($assunto);
$mail->IsHTML = (true);
$texto = "body";

$mail->Body = $html;
$mail->AltBody =$texto;

if($mail->Send($destino, "Recuperação de dados!", $html, $headers)){
echo "<p>Mensagem enviada com sucesso! Obrigado!";
} else {echo "Houve um problema";}

} else {
//Se nenhuma das confirmações acima foram efetuadas, mais uma vez, retorno uma mensagem de erro ao usuário.
echo "<p>Endereço de e-mail informado não consta em nossa base de dados. Por favor, <a href='javascript:history.back();'>volte</a> e tente novamente!</p>";

}

}
?>

</div>

</body>

</html>
