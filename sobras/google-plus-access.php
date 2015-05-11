<?php

  require_once 'google-api-php-client/src/Google/autoload.php'; // or wherever autoload.php is located

  $client = new Google_Client();
  $client->setApplicationName("localizesenac");
  $client->setDeveloperKey("WrIiWLHNXYJBwCwc1tUrL85A");

  $service = new Google_Service_Plus($client);
  $optParams = array('filter' => 'free-ebooks');
  $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

  foreach ($results as $item) {
    echo $item['volumeInfo']['title'], "<br /> \n";
  }

?>