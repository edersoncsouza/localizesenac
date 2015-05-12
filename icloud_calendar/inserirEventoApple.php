<?php
/**
 * php iCloud Calendar class example
 * 
 * Copyright by Emanuel zuber <emanuel@zubini.ch>
 * Version 0.1
 */



// Load ICS parser
require_once('addons/ics-parser/class.iCalReader.php');
// Load iCloud Calendar class
require_once('class.iCloudCalendar.class.php');



// iCloud CalDAV URL looks like:
// https://p02-caldav.icloud.com/12345678/calendars/XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX/
// https://<SERVER>-caldav.icloud.com/<USER_ID>/calendars/<CALENDAR_ID>/



// Connection settings
$my_icloud_server = 'p02';
$my_user_id = '1759380956';
//$my_calendar_id= 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX';
$my_calendar_id= 'home';
$my_icloud_username = 'xxx@icloud.com';
$my_icloud_password = 'xxx';


// iCloud calendar object
$icloud_calendar = new php_icloud_calendar($my_icloud_server, $my_user_id, $my_calendar_id, $my_icloud_username, $my_icloud_password);

// define o timezone
date_default_timezone_set('America/Sao_Paulo'); // define o timezone

// Get iCloud events
$my_range_date_time_from = date("Y-m-d H:i:s", strtotime("-1 week"));
$my_range_date_time_to = date("Y-m-d H:i:s", strtotime("+1 week"));
$my_events = $icloud_calendar->get_events($my_range_date_time_from, $my_range_date_time_to);
print_r($my_events);


// Add iCloud event
$icloud_calendar->add_event(date("Y-m-d 16:05:00"), 
							date("Y-m-d 16:20:00"), 
							"Título do evento", 
							"Descrição do evento", 
							"Minha cidade",
							"60");


