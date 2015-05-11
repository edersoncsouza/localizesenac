<?php

require('HttpPost.class.php');

if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
    $url = 'https://accounts.google.com/o/oauth2/token';
    $params = array(
        "code" => $code,
        "client_id" => "407647315469-0785ljr0q9ijh95dj7qetu0agaq97m5l.apps.googleusercontent.com",
        "client_secret" => "WrIiWLHNXYJBwCwc1tUrL85A",
        "redirect_uri" => "http://localizesenac.com/oauth2callback.php",
        "grant_type" => "authorization_code"
    );
	
	echo "Recebi o code: ".$code."<BR><BR>";
	
	// build a new HTTP POST request
    $request = new HttpPost($url);
    $request->setPostData($params);
    $request->send();

	// decode the incoming string as JSON
    $responseObj = json_decode($request->getHttpResponse());
	
	//var_dump(json_decode($request->getHttpResponse())); // Dump da resposta

	// Tada: we have an access token!
    echo "OAuth2 server provided access token: " . $responseObj->access_token;

	// exemplo com pecl
    /*
	$request = new HttpRequest($url, HttpRequest::METH_POST);
    $request->setPostFields($params);
    $request->send();
    $responseObj = json_decode($request->getResponseBody());
	
    echo "Access token: " . $responseObj->access_token;
	*/
}


?>