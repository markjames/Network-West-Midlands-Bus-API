<?php
/**
 * Project Title
 *
 * 
 *
 * @author Mark James
 */


/**
 * Network wm buses lat lng
 *
 * @author	Mark James
 */
class NetworkWmBuses_LatLng extends LatLng {

	/**
	 * _construct
	 * 
	 */
	public function __construct( $lat, $lng ) {

		parent::LatLng( $lat, $lng );

	}

	/**
	 * _to string
	 * 
	 * @return String
	 */
	public function __toString() {

		return $this->toString();

	}
	
	public function getPostcode( $googleApiKey=null ) {
		
		if( $googleApiKey ) {
			//$url = "http://maps.google.com/maps/geo?q=$this->lat,$this->lng&output=json&oe=utf8&sensor=false&key=$googleApiKey";

			$url = "http://ajax.googleapis.com/ajax/services/search/local?v=1.0&q=$this->lat,$this->lng&sll=52.4806,-1.8956&sspn=7.60233,12.084961&rsz=small&key=".$googleApiKey;

			//Set up a CURL request, telling it not to spit back headers, and to throw out a user agent.
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER,0); //Change this to a 1 to return headers
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$data = curl_exec($ch);
			curl_close($ch);

			$res = json_decode($data);
			$res = $res->responseData->results;
			return $res;
			if( isset($res[0]) ) {
				$lat = $res[0]->lat;
				$lng = $res[0]->lng;
				$geo_data_array = array(
					'latitude'=>$lat,
					'longitude'=>$lng,
					'accuracy'=>$res[0]->accuracy,
					'using'=>'localsearch');
				return $geo_data_array;
			}
		} else {
			$url = "http://ws.geonames.org/findNearbyPostalCodes?lat=$this->lat&lng=$this->lng";
			$ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$cUrlResponse = curl_exec($ch);
			$httpResponseArr = curl_getinfo($ch);
			curl_close($ch);
			return $cUrlResponse;

		}
	}

}

?>