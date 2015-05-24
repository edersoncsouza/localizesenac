<?php

require 'facebook-php-sdk/facebook.php';

// Create our Application instance (replace this with your appId and secret).

$facebook = new Facebook(array(
  'appId'  => '1622249498010646',
  'secret' => 'ff8ad7bd7cd2b50d99eddc9429ca941a',
));


// Get User ID
$user = $facebook->getUser();


if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

		$emailFacebook = $user->email;
		$idFacebook =  $user->id;
		$nomeFacebook = $user->name;
		
		$_SESSION['usuarioOauth2'] = $emailFacebook; // sera o usuario, ou seja o campo matricula da tabela aluno (PK)
		$_SESSION['senhaOauth2'] = $idFacebook; // sera a senha, ou seja o campo senha da tabela aluno
		$_SESSION['nomeOauth2'] = $nomeFacebook; // sera o nome, ou seja o campo nome da tabela aluno
?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>
<!--
    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php //if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Your User Object (/me)</h3>
      <pre><?php //print_r($user_profile); ?></pre>
    <?php //else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php //endif ?>

    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php //echo $naitik['name']; ?>
-->
  </body>
</html>