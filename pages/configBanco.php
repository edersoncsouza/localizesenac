<?php
// connect to db

$conexao = mysql_connect("localhost","root","usbw") ; // Conexão com o mysql
if (!$conexao) {
    die('Não há conexão : ' . mysql_error());
}
$db = mysql_select_db('localizesenac') ; // Seleciona o banco
if (!$db) {
    die ('Não pude usar localizesenac : ' . mysql_error());
}

?>