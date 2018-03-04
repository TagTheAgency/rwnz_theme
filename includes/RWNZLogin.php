<?php
class RWNZLogin {
	
	protected $hello;
	
	function __construct() {
		$this -> hello = new HelloClub();
		
		add_shortcode('register-form', array($this, 'register_form'));

	}
	
		
	function register_form($attr) {
		ob_start();
		include('become-member-form-template.php');
		return ob_get_clean();
		
	}
	
}

$rwnzLogin = new RWNZLogin();