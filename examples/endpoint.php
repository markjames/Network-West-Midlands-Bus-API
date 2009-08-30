<?php

include(dirname(__FILE__).'/../lib/networkwmbuses/stop.php');

$action = isset( $_GET['action'] ) ? $_GET['action'] : '';
$format = isset( $_GET['format'] ) ? $_GET['format'] : 'json';

function output( $format, $input ) {
	switch($format) {

		case 'php':
			highlight_string('<?php ' . var_export($input,true) . ' ?>');
			break;

		case 'json':
		default:
			header('Content-type: application/json');
			echo json_encode( $input );
	}
}

switch( $action ) {

	case 'stop.search':
	
		if( isset($_GET['location']) ) {
			output( $format, NetworkWmBuses_Stop::Search($_GET['location']), 10 );
		} else {
			output( $format, array('error'=>"You must specify a location") );
		}
		break;

	case 'stop.departures':

		if( isset($_GET['stopcode']) ) {
			output( $format, NetworkWmBuses_Stop::Departures($_GET['stopcode']) );
		} else {
			output( $format, array('error'=>"You must specify a stop code") );
		}
		break;

	default:

		output( $format, array('error'=>"You must specify an action") );

}

?>