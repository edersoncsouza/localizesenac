<?php
//include('db.php');

include('../dist/php/seguranca.php');
include('../dist/php/funcoes.php');

if(isset($_POST['action']))
{          
    if($_POST['action']=="login")
    {
        $email = mysql_real_escape_string($_POST['email']);
        $password = mysql_real_escape_string($_POST['password']);
        $strSQL = mysql_query("select nome from aluno where email='".$email."' and autenticacao = 'local' and password='".md5($password)."'");
        $Results = mysql_fetch_array($strSQL);
        if(count($Results)>=1)
        {
            $message = $Results['name']." Login Sucessfully!!";
        }
        else
        {
            $message = "Invalid email or password!!";
        }        
    }
    elseif($_POST['action']=="signup")
    {
        $name       = mysql_real_escape_string($_POST['name']);
        $email      = mysql_real_escape_string($_POST['email']);
        $password   = mysql_real_escape_string($_POST['password']);
        $query = "SELECT email FROM users where email='".$email."'";
        $result = mysql_query($query);
        $numResults = mysql_num_rows($result);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
        {
            $message =  "Invalid email address please type a valid email!!";
        }
        elseif($numResults>=1)
        {
            $message = $email." Email already exist!!";
        }
        else
        {
            mysql_query("insert into users(name,email,password) values('".$name."','".$email."','".md5($password)."')");
            $message = "Signup Sucessfully!!";
        }
    }
    elseif($_POST['action']=="password")
    {
        $email      = mysql_real_escape_string($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
        {
            $message =  "Invalid email address please type a valid email!!";
        }
        else
        {
            $query = "SELECT id, nome FROM aluno where email='".$email."'";
            $result = mysql_query($query);
            $Results = mysql_fetch_array($result);
            
			
			
            if(count($Results)>=1)
            {
				$nome = $Results['nome'];
				
                $encrypt = md5(90*13+$Results['id']);
                $message = "Your password reset link send to your e-mail address.";
                $to=$email;
                $subject="Forget Password";
                $from = 'info@phpgang.com';
                $body='Hi, <br/>' . $nome . ' <br/>Your Membership ID is '.$Results['id'].' <br><br>Click here to reset your password http://localhost:8080/projetos/localizesenac/recupera/reset.php?encrypt='.$encrypt.'&action=reset   <br/> <br/>--<br>PHPGang.com<br>Solve your problems.';
                $headers = "From: " . strip_tags($from) . "\r\n";
                $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
				enviaEmailSilencioso($body, $to, $nome);
                //mail($to,$subject,$body,$headers);
                
                //$query = "SELECT id FROM users where md5(90*13+id)='".$encrypt."'";
//                $Results = mysql_fetch_array($result);
//                print_r($Results);
//                $message = $encrypt. $query;
            }
            else
            {
                $message = "Account not found please signup now!!";
            }
        }
    }
}


$content ='<script type="text/javascript" src="jquery-1.8.0.min.js"></script> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript">
function forgetpassword() {
  $("#login").hide();
  $("#passwd").show();
}
</script>
<style type="text/css">
input[type=text]
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
input[type=text]:focus
{
  width: 400px;
  border-color: #51a7e8;
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1),0 0 5px rgba(81,167,232,0.5);
  outline: none;
}
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
  </script>
</head>
<body>

<div id="tabs" style="width: 480px;">
  <ul>
    <li><a href="#tabs-1">Login</a></li>
    <li><a href="#tabs-2" class="active">Signup</a></li>
    
  </ul>                 
  <div id="tabs-1">
  <form action="" method="post" id="login">
    <p><input id="email" name="email" type="text" placeholder="Email"></p>
    <p><input id="password" name="password" type="password" placeholder="Password">
    <input name="action" type="hidden" value="login" /></p>
    <p><input type="submit" value="Login" />&nbsp;&nbsp;<a href="#forget" onclick="forgetpassword();" id="forget">Forget Password?</a></p>
  </form>
  <form action="" method="post" id="passwd" style="display:none;">
    <p><input id="email" name="email" type="text" placeholder="Email to get Password"></p>
    <input name="action" type="hidden" value="password" /></p>
    <p><input type="submit" value="Reset Password" /></p>
  </form>
  </div>
  <div id="tabs-2">
    <form action="" method="post">
    <p><input id="name" name="name" type="text" placeholder="Name"></p>
    <p><input id="email" name="email" type="text" placeholder="Email"></p>
    <p><input id="password" name="password" type="password" placeholder="Password">
    <input name="action" type="hidden" value="signup" /></p>
    <p><input type="submit" value="Signup" /></p>
  </form>
  </div>
</div>';


$pre = 1;
$title = "How to create Login and Signup form in PHP";
$heading = "How to create Login and Signup form in PHP.";
//include("html.inc"); 
echo $content;           
?>