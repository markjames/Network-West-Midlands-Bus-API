<?php
/**
 * Network West Midlands Bus Search
 *
 * 
 *
 * @author Mark James
 */

if( !class_exists('SimpleBrowser') ) {
	require_once( dirname(__FILE__) . '/../simpletest/browser.php' );
	require_once( dirname(__FILE__) . '/../simplehtmldom/simple_html_dom.php' );
	require_once( dirname(__FILE__) . '/../phpcoord/phpcoord-2.3.php' );
	require_once( dirname(__FILE__) . '/latlng.php' );
	require_once( dirname(__FILE__) . '/departure.php' );
}

/**
 * Network wm buses search
 *
 * @author	Mark James
 */
class NetworkWmBuses_Stop {

	/**
	 * Search
	 * 
	 * @param String $location Location
	 */
	public static function Search( $location, $limit=20 ) {

		// Is the location a latlng?
		if( false ) {
			$searchTerm = $location;
		} else {
			$searchTerm = $location;
		}

		$browser = &new SimpleBrowser();
		$browser->addHeader('User-Agent: Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; FDM; .NET CLR 1.1.4322)');
		$browser->get('http://www.netwm.mobi/');
		$browser->setFieldByName('searchTerm', $searchTerm);
		$html = $browser->clickSubmit('Find stops');

		$results = array();
		$loops = 0;
		
		do {
			$dom = str_get_html($html);

			// Get results
			$stops = array();
			foreach($dom->find('table tr td a[href^=/departureboard]') as $node) {

				$stop = new NetworkWmBuses_Stop();
				$stop->name = html_entity_decode( trim($node->plaintext), ENT_QUOTES, 'UTF-8');
				$stop->departuresLink = 'http://www.netwm.mobi' . $node->href;
				$stop->location = html_entity_decode( trim($node->parent()->parent()->next_sibling()->last_child()->plaintext), ENT_QUOTES, 'UTF-8');
				$stop->code = substr( $node->href, -strlen(strrchr($node->href,'='))+1 );
				$stops []= $stop;

			}
		
			// Get the geo positions from the map
			list($node) = $dom->find('img[src^=/mapimage]');
			$matches = array();
			// Find the geo points
			if( preg_match('/xylist=([^&]+)/', $node->src, $matches) ) {
				$points = explode('%2C',$matches[1]);
				$pointsLength = count($points);
				for( $i = 0; $i < $pointsLength; $i+=2 ) {
					$stops[floor($i/2)]->latlng = NetworkWmBuses_Stop::OsgbToLatLng( $points[$i], $points[$i+1] );
				}
			}

			$results = array_merge($results, $stops);
			$html = $browser->clickLink('[more stops]');

		} while( count($results) < $limit && $loops++ < 12 && $html );
		

		return $results;

	}

	public static function OsgbToLatLng( $easting, $northing ) {
		
		$os1 = new OSRef($easting, $northing);
		$ll1 = $os1->toLatLng('NetworkWmBuses_LatLng');
		return $ll1;

	}

	public static function Departures( $stopcode ) {

		$browser = &new SimpleBrowser();
		$browser->addHeader('User-Agent: Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; FDM; .NET CLR 1.1.4322)');
		$browser->get('http://www.netwm.mobi/');
		$browser->setFieldByName('searchTerm', $stopcode);
		$html = $browser->clickSubmit('Find stops');
		$dom = str_get_html($html);

		$departures = array();
		foreach($dom->find('table tr td a[href^=/departureboard]') as $node) {
			$departure = new NetworkWmBuses_Departure();
			$departure->service = $node->innertext;
			$departure->stopCode = $stopcode;

			$rowNode = $node->parent()->parent();
			$rowText = trim($rowNode->innertext);
			$rowText = substr($rowText,strpos($rowText, '</b>')+5);

			if( preg_match( '/(\S*)\s+(.*?)( in | at )(.*?)\s\(/' , $rowText, $matches ) ) {
				$departure->operator = $matches[1];
				$departure->destination = trim($matches[2]);
			
				// Which date format are they using? 'in 15 mins' or 'at 18:00'
				if( ' in ' == $matches[3] ) {
					$departure->departureTime = strtotime('now+'.str_replace(' ','',$matches[4]) );
				} else {
					// Make adjustments for hours after midnight, not totally sure what the output will be
					if( strtotime($matches[4]) < strtotime('now') - 43200 ) {
						$departure->departureTime = strtotime('tomorrow '.$matches[4]);
					} else {
						$departure->departureTime = strtotime($matches[4]);
					}
				}

				$departures []= $departure;
			}
		}
		return $departures;

	}

	/**
	 * Name
	 *
	 * @var String
	 */
	public $name;

	/**
	 * Departures link
	 *
	 * @var String
	 */
	public $departuresLink;

	/**
	 * Stop Code
	 *
	 * @var String
	 */
	public $code;

	/**
	 * Location
	 *
	 * @var String
	 */
	public $location;

	/**
	 * Latitude/Longitude
	 *
	 * @var Number
	 */
	public $latlng;

	/**
	 * Constructor for NetworkWmBuses_Stop
	 * 
	 * @param String $name Name
	 * @param String $departuresLink Departures link Optional (Defaults to '')
	 * @param String $location Location Optional (Defaults to '')
	 */
	public function __construct( $name='', $departuresLink='', $location='' ) {

		$this->name = $name;
		$this->departuresLink = $departuresLink;
		$this->location = $location;

	}

	public function getDepartures() {

		if( !$this->code ) {
			throw new Exception('You must specify a stop code');
		}

		return NetworkWmBuses_Stop::Departures( $this->code );

	}

}
?>