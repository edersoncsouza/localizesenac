<?
// connect to db

$conexao = mysql_connect("localhost","root","usbw") or die(mysql_error()); // Conexão com o mysql
$db = mysql_select_db("localizesenac") or die(mysql_error()); // Seleciona o banco

/*
if (!$conexao) {
    die('Não há conexão : ' . mysql_error());
}

if (!$db) {
    die ('Não pude usar localizesenac : ' . mysql_error());
}
*/
?>