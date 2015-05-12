<?php
	//Define iCloud URLs
	$icloudUrls = array();
	for($i = 1; $i < 25; $i++)
		$icloudUrls[] = "https://p".str_pad($i, 2, '0', STR_PAD_LEFT)."-caldav.icloud.com";
	
	//Functions
	function doRequest($user, $pw, $url, $xml)
	{
		//Init cURL
		$c=curl_init($url);
		//Set headers
		curl_setopt($c, CURLOPT_HTTPHEADER, array("Depth: 1", "Content-Type: text/xml; charset='UTF-8'", "User-Agent: DAVKit/4.0.1 (730); CalendarStore/4.0.1 (973); iCal/4.0.1 (1374); Mac OS X/10.6.2 (10C540)"));
		curl_setopt($c, CURLOPT_HEADER, 0);
		//Set SSL
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		//Set HTTP Auth
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($c, CURLOPT_USERPWD, $user.":".$pw);
		//Set request and XML
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PROPFIND");
		curl_setopt($c, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		//Execute
		$data=curl_exec($c);
		//Close cURL
		curl_close($c);
		
		return $data;
	}

	if(isset($_POST['appleID']))
	{
		$user=$_POST['appleID'];
		$pw=$_POST['pw'];
		
		//Get Principal URL
		$principal_request="<A:propfind xmlns:A='DAV:'>
								<A:prop>
									<A:current-user-principal/>
								</A:prop>
							</A:propfind>";
		$response=simplexml_load_string(doRequest($user, $pw, $_POST['server'], $principal_request));
		//Principal URL
		$principal_url=$response->response[0]->propstat[0]->prop[0]->{'current-user-principal'}->href;
		$userID=explode("/", $principal_url);
		$userID=$userID[1];
		
		//Get Calendars
		$calendars_request="<A:propfind xmlns:A='DAV:'>
								<A:prop>
									<A:displayname/>
								</A:prop>
							</A:propfind>";
		$url=$_POST['server']."/".$userID."/calendars/";
		$response=simplexml_load_string(doRequest($user, $pw, $url, $calendars_request));
		//To array
		$calendars=array();
		foreach($response->response as $cal)
		{
			$entry["href"]=$cal->href;
			if(isset($cal->propstat[0]->prop[0]->displayname)) {
				$entry["name"]=$cal->propstat[0]->prop[0]->displayname;
			} else {
				$entry["name"]="";
			}
			$calendars[]=$entry;
		}

		//CardDAV URL
		$cardserver = str_replace('caldav', 'contacts', $_POST['server']);
		$card_request="<A:propfind xmlns:A='DAV:'>
							<A:prop>
								<A:addressbook-home-set xmlns:A='urn:ietf:params:xml:ns:carddav'/>
							</A:prop>
						</A:propfind>";
		$response=simplexml_load_string(doRequest($user, $pw, $cardserver . $principal_url, $card_request));
		$cardurl=$response->response[0]->propstat[0]->prop[0]->{'addressbook-home-set'}->href;
		
		// armazena as informacoes da conta iCloud
		$retornoIcloud['usuario'] = $user;
		$retornoIcloud['senha'] = $pw;
		$retornoIcloud['id'] = $userID;
		
		// codifica o array em formato Json e devolve como retorno
		echo json_encode($retornoIcloud);
		
		}
		else // caso não tenha recebido os parametros
			echo 0;//("Não recebi os parametros para mudança de senha");
