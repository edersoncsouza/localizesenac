<?php
/**
 * php iCloud Calendar class
 * 
 * Copyright by Emanuel zuber <emanuel@zubini.ch>
 * Version 0.1
 */




/**
 * php iCloud Calendar class
 *
 * @author   Emanuel Zuber <emanuel@zubini.ch>
 * @link     https://github.com/zubini/php_icloud_calendar/
 */
class php_icloud_calendar {
	
	
	/**
	 * @var string
	 * @access private
	 */
	var $server;
	
	
	/**
	 * @var string
	 * @access private
	 */
	var $user_id;
	
	
	/**
	 * @var string
	 * @access private
	 */
	var $calendar_id;
	
	
	/**
	 * @var string
	 * @access private
	 */
	var $username;
	
	
	/**
	 * @var string
	 * @access private
	 */
	var $password;
	
	
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param string $server
	 * @param string $user_id
	 * @param string $calendar_id
	 * @param string $username
	 * @param string $password
	 * @return void
	 */
	public function __construct($server, $user_id, $calendar_id, $username, $password) {
		$this->server = $server;
		$this->user_id = $user_id;
		$this->calendar_id = $calendar_id;
		$this->username = $username;
		$this->password = $password;
	}
	
	
	
	/**
	 * Get iCloud events.
	 * 
	 * @param string $date_time_range_from Format: yyyy-mm-dd HH:ii:ss
	 * @param string $date_time_range_to Format: yyyy-mm-dd HH:ii:ss
	 * @access public
	 * @return array|FALSE
	 */
	public function get_events($date_time_range_from, $date_time_range_to) {
		
		// Do CalDAV request to iCloud
		$request_body  = '<?xml version="1.0" encoding="utf-8" ?>';
		$request_body .= '<c:calendar-query xmlns:d="DAV:" xmlns:c="urn:ietf:params:xml:ns:caldav">';
		$request_body .= '	<d:prop>';
		$request_body .= '		<c:calendar-data />';
		$request_body .= '	</d:prop>';
		$request_body .= '	<c:filter>';
		$request_body .= '		<c:comp-filter name="VCALENDAR">';
		$request_body .= '			<c:comp-filter name="VEVENT">';
		$request_body .= '				<c:time-range start="%sZ" end="%sZ"/>';
		$request_body .= '			</c:comp-filter>';
		$request_body .= '		</c:comp-filter>';
		$request_body .= '	</c:filter>';
		$request_body .= '</c:calendar-query>';
		$request_body = sprintf($request_body, date('Ymd\THis', strtotime($date_time_range_from)), date('Ymd\THis', strtotime($date_time_range_to)));
		$caldav_answer = $this->_do_report_request($request_body);
		
		
		// Load XML into php array
		$caldav_answer_object = simplexml_load_string($caldav_answer, 'SimpleXMLElement', LIBXML_NOCDATA);
		$caldav_answer_array = $this->_object2array($caldav_answer_object);
		
		echo "<pre>";
		echo "Resposta CALDAV Objeto:\n";
		print_r($caldav_answer_object);
		echo "Resposta CALDAV Array:\n";
		print_r($caldav_answer_array);
		
		echo "CALDAV Array e array?: " . is_array($caldav_answer_array) . "\n";
		echo "Count do CALDAV Array: " . count($caldav_answer_array) . "\n";
		
		// Iter events
		if (is_array($caldav_answer_array) && count($caldav_answer_array) > 0) {
			
			echo "E array e o array e maior que zero!". "\n";
			echo " caldav_answer_array e array e o count e : " . count($caldav_answer_array). "\n";
			echo "caldav_answer_array[response] e array?: " . is_array($caldav_answer_array) . " e o count de caldav_answer_array[response] e : " . count($caldav_answer_array['response']). "\n";
			
			if (is_array($caldav_answer_array['response']) && count($caldav_answer_array['response']) > 0) {
				
				// Get ICS content
				$ics_content = '';
				foreach($caldav_answer_array['response'] as $event) {
					if (isset($event['propstat']['prop']['calendar-data'])) {
						$ics_content .= $event['propstat']['prop']['calendar-data'];
					}
				}
				
				echo "Eventos do caldav_answer_array[response][propstat][prop][calendar-data] \n";
				echo $ics_content . "\n";
				
				// 
				if (!empty($ics_content)) {
					$ics_content = explode("\n", $ics_content);
					$ics = new ICal($ics_content);
					
					// Return events
					return $ics->events();
				}
				
				
			}
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * Add new iCloud event.
	 * 
	 * @access public
	 * @param string $date_time_from Format: yyyy-mm-dd HH:ii:ss
	 * @param string $date_time_to Format: yyyy-mm-dd HH:ii:ss
	 * @param string $title
	 * @param string $description (Optional)
	 * @param string $location (Optional) // adicionado por Ederson
	 * @param string $minAntec (Optional) // adicionado por Ederson
	 * @param string $recurrency (Optional) // adicionado por Ederson
	 * @param string $limitRecurrency (Optional) // adicionado por Ederson
	 * @return string
	 */
	public function add_event($date_time_from, $date_time_to, $title, $description = null, $location = null, $minAntec, $recurrency, $limitRecurrency) {
		
		// Set random event_id
		$event_id = md5('event-'.rand(1000000, 9999999).time());
		
		// Get unique event url
		$event_url = $this->_get_add_event_url($event_id);
		
		// Set date start / date end
		$tstart = gmdate("Ymd\THis\Z", strtotime($date_time_from));
		$tend = gmdate("Ymd\THis\Z", strtotime($date_time_to));
		
		// Set current timestamp
		$tstamp = gmdate("Ymd\THis\Z");
		
		// Build ICS content
		$body  = "BEGIN:VCALENDAR\n";
		$body .= "VERSION:2.0\n";
		$body .= "BEGIN:VEVENT\n";
		$body .= "DTSTAMP:".$tstamp."\n";
		$body .= "DTSTART:".$tstart."\n";
		$body .= "DTEND:".$tend."\n";
		$body .= "UID:".$event_id."\n";
		if (!empty($description)) {
			$body .= "DESCRIPTION:".$description."\n";
		}
		if (!empty($location)) {
			$body .= "LOCATION:".$location."\n";
		}
		if (!empty($title)) {
			$body .= "SUMMARY:".$title."\n";
		}
		if ((!empty($recurrency)) && (!empty($limitRecurrency))) {
				$body .= "RRULE:FREQ=" . $recurrency . ";INTERVAL=1;UNTIL=" . $limitRecurrency . "\n";
		}
		// adicionada opcao de incluir um alarme
		if (!empty($minAntec)) {
			$body .= "BEGIN:VALARM\n";
			$body .= "ACTION:DISPLAY\n";
			$body .= "DESCRIPTION:Reminder\n";
			$body .= "TRIGGER:-PT". (int) $minAntec ."M\n";
			$body .= "X-WR-ALARMUID:" . $event_id . "\n";
			$body .= "END:VALARM\n";
		}
		
		$body .= "END:VEVENT\n";
		$body .= "END:VCALENDAR\n";
		
		// Do request
		$this->_do_put_request($event_url, $body);
		
		// incluido para verificar se a montagem esta ok
		echo '<pre>';
		echo $body;
		echo '</pre>';
		
		return $event_id;
	}
	
	
	
	// TODO
	public function modify_event() {
		// ...
	}
	
	
	
	// TODO
		 /* funcao criada por Ederson
		 */
	public function remove_event($event_id) {
//
$body = <<<__EOD
UID:{$event_id }
__EOD;
		
		// Get unique event url
		$event_url = $this->_get_add_event_url($event_id);
		// Do request
		$this->_do_delete_request($event_url, $body);
		
	}
	
	
	
	/**
	 * Getting add event url.
	 * 
	 * @access private
	 * @param string $event_id
	 * @return string
	 */
	private function _get_add_event_url($event_id) {
		return 'https://'.$this->server.'-caldav.icloud.com/'.$this->user_id.'/calendars/'.$this->calendar_id.'/'.$event_id.'.ics';
	}
	
	
	
	/**
	 * Do a CalDAV PUT request to add an iCloud event.
	 * 
	 * @access private
	 * @param string $url
	 * @param string $data
	 * @return string
	 */
	private function _do_put_request($url, $data) {
		
		// Initialize cURL
		$c = curl_init($url);
		
		// Set headers
		curl_setopt($c, CURLOPT_HTTPHEADER, array(	"Depth: 1", 
													"Content-Type: text/calendar; charset='UTF-8'", 
													"If-None-Match: *", 
													"User-Agent: DAVKit/4.0.1 (730); CalendarStore/4.0.1 (973); iCal/4.0.1 (1374); Mac OS X/10.6.2 (10C540)"
													));
		curl_setopt($c, CURLOPT_HEADER, 0);
		
		// Set SSL options
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		
		// Set HTTP authentication
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($c, CURLOPT_USERPWD, $this->username.":".$this->password);
		
		// Set PUT request
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($c, CURLOPT_POSTFIELDS, $data);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		
		// Execute and return value
		$data = curl_exec($c);
		curl_close($c);
		return $data;
	}
	

	/**
	 * funcao criada por Ederson
	 * Do a CalDAV DELETE request to remove an iCloud event.
	 * 
	 * @access private
	 * @param string $url
	 * @param string $data
	 * @return string
	 */
	private function _do_delete_request($url, $data) {
		
		// Initialize cURL
		$c = curl_init($url);
		
		// Set headers
		curl_setopt($c, CURLOPT_HTTPHEADER, array(	"Depth: 1", 
													"Content-Type: text/calendar; charset='UTF-8'", 
													//"If-None-Match: *",  // removido para permitir update / delete
													"User-Agent: DAVKit/4.0.1 (730); CalendarStore/4.0.1 (973); iCal/4.0.1 (1374); Mac OS X/10.6.2 (10C540)"
													));
		curl_setopt($c, CURLOPT_HEADER, 0);
		
		// Set SSL options
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		
		// Set HTTP authentication
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($c, CURLOPT_USERPWD, $this->username.":".$this->password);
		
		// Set DELETE request
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($c, CURLOPT_POSTFIELDS, $data);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		
		// Execute and return value
		$data = curl_exec($c);
		curl_close($c);
		return $data;
	}
	
	
	/**
	 * Do a CalDAV REPORT request to get iCloud events.
	 * 
	 * @access private
	 * @param mixed $data
	 * @return string
	 */
	private function _do_report_request($data) {
		
		// Set url
		$url = 'https://'.$this->server.'-caldav.icloud.com/'.$this->user_id.'/calendars/'.$this->calendar_id.'/';
		
		// Initialize cURL
		$c = curl_init($url);
		
		// Set headers
		curl_setopt($c, CURLOPT_HTTPHEADER, array(	"Depth: 1", 
													"Content-Type: text/xml; charset='UTF-8'", 
													"User-Agent: DAVKit/4.0.1 (730); CalendarStore/4.0.1 (973); iCal/4.0.1 (1374); Mac OS X/10.6.2 (10C540)"
													));
		curl_setopt($c, CURLOPT_HEADER, 0);
		
		// Set SSL options
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		
		// Allow HTTP authentication
		curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($c, CURLOPT_USERPWD, $this->username.":".$this->password);
		
		// Set PUT request
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, "REPORT");
		//curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PROPFIND");
		curl_setopt($c, CURLOPT_POSTFIELDS, $data);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		
		// Execute and return value
		$data = curl_exec($c);
		curl_close($c);
		return $data;
	}
	
	
	
	/**
	 * Return an assoziative array from a php object.
	 * 
	 * @access private
	 * @param object $object
	 * @return array
	 */
	private function _object2array($object) {
		return @json_decode(@json_encode($object),1);
	}
	
}

