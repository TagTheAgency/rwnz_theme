<?php

class HelloClub {

	/**
	 * Get all events in a specified timeframe
	 * @param $from the from date in Y-m-d format
	 * @param $to the to date in Y-m-d format
	 */
	function get_events($from, $to) {
		error_log("Getting events from $from to $to");
		$url = get_option ( 'rwnz_hello_club_base_url' ) . '/event?fromDate=' . $from . '&toDate=' . $to;
		error_log($url);
		$response = wp_remote_get ( $url );
		
		if (is_wp_error ( $response )) {
			error_log("Is error");
			return null;
		}
		
		$body = $response ['body'];
		error_log("Returning ".print_r($body, true));
		return json_decode ( $body, true );
	}
}

