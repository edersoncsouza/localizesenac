<?php
//include('db.php');

include('../dist/php/seguranca.php');
include('../dist/php/funcoes.php');

if(isset($_GET['action']))
{          
    if($_GET['action']=="reset"){
		
        $encrypt = mysql_real_escape_string($_GET['encrypt']);
        $query = "SELECT id FROM aluno where md5(90*13+id)='".$encrypt."'";
        $result = mysql_query($query);
        $Results = mysql_fetch_array($result);
        if(count($Results)>=1){

        }
        else{
            $message = 'Chave inválida, por favor tente novamente. <a href="http://localhost:8080/projetos/localizesenac/recupera/#forget">Esqueceu a senha?</a>';
        }
    }
}
elseif(isset($_POST['action'])){
    
    $encrypt      = mysql_real_escape_string($_POST['action']);
    $password     = mysql_real_escape_string($_POST['password']);
    $query = "SELECT id FROM aluno where md5(90*13+id)='".$encrypt."'";
//    echo $query;
    $result = mysql_query($query);
    $Results = mysql_fetch_array($result);
    if(count($Results)>=1)
    {
        $query = "update aluno set senha='".md5($password)."' where id='".$Results['id']."'";
        mysql_query($query);
//        echo $query;
        $message = "Sua senha foi modificada com sucesso <a href=\"http://localhost:8080/projetos/localizesenac/\">clique aqui para autenticar-se</a>.";
    }
    else
    {
        $message = 'Chave inválida, por favor tente novamente. <a href="http://localhost:8080/projetos/localizesenac/recupera/#forget">Esqueceu a senha?</a>';
    }
}
else
{
    header("location: /login-signup-in-php");
}
/*
$content ='<script type="text/javascript" src="jquery-1.8.0.min.js"></script> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">
input[type=password]
{
  border: 1px solid #ccc;
  border-radius: 3px;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  width:200px;
  min-height: 28px;
  padding: 4px 20px 4px 8px;
  font-size: 12px;
  -moz-transition: all .2s linear;
  -webkit-transition: all .2s linear;
  transition: all .2s linear;
}
input[type=password]:focus
{
  width: 400px;
  border-color: #51a7e8;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1),0 0 5px rgba(81,167,232,0.5);
  outline: none;
}
</style>  
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  

<div id="tabs" style="width: 480px;">
  <ul>
    <li><a href="#tabs-1">Reset Password</a></li>
    
    
  </ul>                 
  <div id="tabs-1">
  <form action="reset.php" method="post" id="reset" >
    <p><input id="password" name="password" type="password" placeholder="Enter new password">
    <p><input id="password2" name="password2" type="password" placeholder="Re-type new password">
    <input name="action" type="hidden" value="'.$encrypt.'" /></p>
    <p><input type="button" value="Reset Password" onclick="mypasswordmatch();" /></p>
  </form>
  </div>
</div>
*/
$content ='
  <script>
function mypasswordmatch(){
	
    var pass1 = $("#password").val();
    var pass2 = $("#password2").val();
	
    if (pass1 != pass2){
        alert("As senhas não combinam");
        return false;
    }
    else{
        $( "#reset" ).submit();
    }
}
  </script>
	
	<!-- jQuery -->
    <script type="text/javascript" src="../dist/components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="../dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
  
    <!-- Bootstrap Core CSS -->
    <link href="../dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
	
	<link href="../dist/css/login.css" rel="stylesheet" type="text/css"/>
  
</head>
<body>
	<div class="container">
		<div class="row">
			<div role="main">
				<div id="reset">
					<legend id="legendaForm">RESET DE SENHA</legend>
					
					<img id="logo" src="../dist/images/logo_LocalizeSenac_novo_small.png" alt="logotipo localizesenac"/>
					
					<form class= "loginForm" action="" method="post" id="formReset" accept-charset="UTF-8">
					
						<input type="password" id="password" name="password" class="form-control" name="email" placeholder="Digite a nova senha" required>

						<input type="password" id="password2" name="password2" class="form-control" name="email" placeholder="Repita a nova senha" required>
						
						<input name="action" type="hidden" value="{$encrypt}" /></p>
						<br>
						<button name="botaoSalvarSenha" class="btn btn-info btn-block" onclick=\"mypasswordmatch();\" >Salvar nova senha</button>

					</form>
				</div>
			</div>
		</div>
	</div>';


$pre = 1;
$title = "How to create Login and Signup form in PHP";
$heading = "How to create Login and Signup form in PHP.";
//include("html.inc");

echo $content;
?>