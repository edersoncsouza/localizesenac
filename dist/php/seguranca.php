<?php

include ('lib/password.php');

//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;     // Usar case-sensitive? 

$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['servidor'] = 'localhost';    // Servidor MySQL
$_SG['usuario'] = 'root';          // Usuário MySQL
$_SG['senha'] = 'usbw';            // Senha MySQL
$_SG['banco'] = 'localizesenac';   // Banco de dados MySQL

$_SG['paginaLogin'] = 'index.php'; // Página de login

$_SG['tabela'] = 'aluno';       // Nome da tabela onde os usuários são salvos
// ==============================

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
$_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
	
	if(!isset($_SESSION)){
		session_start();
	}
//session_start();
}

$_SESSION['conexao'] = $_SG['link'];
mysql_set_charset('UTF8', $_SG['link']);

/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
global $_SG;

$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

// Usa a função addslashes para escapar as aspas
$nusuario = addslashes($usuario);
$nsenha = addslashes($senha);

// Monta uma consulta SQL (query) para procurar um usuário
//$sql = "SELECT `id`, `nome` FROM `".$_SG['tabela']."` WHERE ".$cS." `matricula` = '".$nusuario."' AND ".$cS." `senha` = '".$nsenha."' LIMIT 1";
//$sql = "SELECT `id`, `nome` FROM `".$_SG['tabela']."` WHERE ".$cS." `matricula` = '".$nusuario."' AND ".$cS." `senha` = '".md5($nsenha)."' LIMIT 1";
$sql = "SELECT `id`, `nome`, `senha` FROM `".$_SG['tabela']."` WHERE ".$cS." `matricula` = '".$nusuario."'";
$query = mysql_query($sql);
//$resultado = mysql_fetch_assoc($query);

$usuarioExiste = false; // cria e seta a variavel booleana de verificacao de usuario

while($row = mysql_fetch_assoc($query)) { // loop para cada linha de usuario encontrada no banco
	
	if(password_verify($nsenha,$row["senha"])){ // executa a verificacao da senha vinda do banco para saber se e compativel com a fornecida pelo usuario
		//echo "Achei!";
		$usuarioID = $row['id']; // caso tenha encontrado armazena o ID do usuario
		$usuarioNome = $row['nome']; // armazena o nome do usuario
		$usuarioExiste = true; // seta a variavel dizendo que encontrou usuario com senha compativel
	}
	
}


// Verifica se encontrou algum registro
//if (empty($resultado)) {]

// verifica se o usuario existe
if (!$usuarioExiste) {
// Nenhum registro foi encontrado => o usuário é inválido
return false;

} else {
// O registro foi encontrado => o usuário é valido

// Definimos dois valores na sessão com os dados do usuário
//$_SESSION['usuarioID'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
$_SESSION['usuarioID'] = $usuarioID; // Pega o valor da coluna 'id do registro encontrado no MySQL
//$_SESSION['usuarioNome'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
$_SESSION['usuarioNome'] = $usuarioNome; // Pega o valor da coluna 'nome' do registro encontrado no MySQL

// Verifica a opção se sempre validar o login
if ($_SG['validaSempre'] == true) {
// Definimos dois valores na sessão com os dados do login
$_SESSION['usuarioLogin'] = $usuario;
$_SESSION['usuarioSenha'] = $senha;
}

return true;
}
}

/**
* Função que protege uma pagina
*/
function protegePagina() {
global $_SG;

if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
// Não ha usuario logado, manda para a pagina de login
expulsaVisitante();
} else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
	// Há usuário logado, verifica se precisa validar o login novamente
	if ($_SG['validaSempre'] == true) {
		// Verifica se os dados salvos na sessao batem com os dados do banco de dados
		if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
		// Os dados nao batem, manda para a tela de login
		expulsaVisitante();
	}
	}
}
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
global $_SG;

// Remove as variáveis da sessão (caso elas existam)
unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);

session_destroy();

// Manda pra tela de login
header("Location: ".$_SG['paginaLogin']);
}

function verificaPerfil(){
	global $_SG;
	
	$sql = "SELECT
					id 
			FROM
					`aluno_perfil`
			WHERE
					`id` = '".$_SESSION['usuarioID']."'
			AND
					fk_id_perfil = '1'";
	
	// executa a query para verificar se o aluno ja possui eventos
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(!mysql_num_rows($result) > 0) // se houverem não houver aluno com a id logada na tabela aluno_perfil com o perfil de administrador
		expulsaVisitante();	
	else
		$_SESSION['administrador'] = true;
	
}

function armazenaPerfil(){
	
	global $_SG;
	
	$sql = "SELECT
					fk_id_perfil 
			FROM
					`aluno_perfil`
			WHERE
					`id` = '".$_SESSION['usuarioID']."'";
	
	// executa a query para verificar se o aluno ja possui eventos
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(!mysql_num_rows($result) > 0) // se houverem não houver aluno com a id logada na tabela aluno_perfil com o perfil de administrador
		expulsaVisitante();	
	else{
		$row = mysql_fetch_row($result);
		$_SESSION['perfil'] = $row[0];	
	}
}

?>