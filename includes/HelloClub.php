<?php

class HelloClub {

	protected $baseUrl;
	
	function __construct() {
		$this -> baseUrl = get_option ( 'rwnz_hello_club_base_url' );
		
	}
	
	
	/**
	 * Get all events in a specified timeframe
	 * @param $from the from date in Y-m-d format
	 * @param $to the to date in Y-m-d format
	 */
	function get_events($from, $to) {
		error_log("Getting events from $from to $to");
		$url = $this -> baseUrl . '/event?fromDate=' . $from . '&toDate=' . $to;

		$response = wp_remote_get ( $url );
		
		if (is_wp_error ( $response )) {
			error_log("Is error");
			return null;
		}
		
		$body = $response ['body'];
		error_log("Returning ".print_r($body, true));
		return json_decode ( $body, true );
	}
	
	function admin_oauth() {
		/**
		 *	TODO once hello club implement API level keys, replace this call with those!
		 */
		
		$url = $this -> baseUrl . '/auth/token';
			
		$response = wp_remote_post( $url, array(
			'body'  => json_encode(array('grantType' => 'password', 'username' => 'colinmatcham', 'password' => 'test123')),
			'headers' => array(
					'Content-Type' => 'application/json'
			)
		));
			
		$body = $response['body'];
			
		if ($response['response']['code'] == 401) {
			return null;
		}
			
		return json_decode($body) -> accessToken;
	}
	
	function forgottenPassword($username) {
		
		$url = $this -> baseUrl . '/user/forgotPassword';
		$response = wp_remote_post( $url, array(
			'body'  => json_encode(array('username' => $username)),
			'headers' => array(
					'Content-Type' => 'application/json'
			)
		));
		
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			return json_encode(array('error'=>$error_message));
		}
		
		$body = $response['body'];
		return $body;
	}
	
}

