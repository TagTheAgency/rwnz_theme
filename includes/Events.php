<?php
class RWNZEvents {
	
	protected $hello;
	
	function __construct() {
		$this -> hello = new HelloClub();
		
		add_shortcode('events', array($this, 'events_slider'));
		add_shortcode('events-form', array($this, 'events_form'));
		
		add_action( 'wp_ajax_add_event', array($this, 'process_add_event_form' ));
		add_action( 'wp_ajax_nopriv_add_event', array($this, 'process_add_event_form' ));
		
	}
	
	
	
	function get_next_event() {
		$now = date('Y-m-d');
		$future = date("Y-m-d", strtotime("+1 month", strtotime("now")));
		$events = $this -> hello -> get_events($now, $future);
		
		return $events;
	}
	
	
	function process_add_event_form() {
		
	}
	
	
	function events_form($attr) {
		//    wp_enqueue_style('date-picker');
		wp_enqueue_script('google-maps');
		ob_start();
		include('events-form-template.php');
		return ob_get_clean();
		
	}
	
	function convert_event_to_display($event) {
		error_log(print_r($event, true));
		
		if ($event == null) {
			return '';
		}
		
		$date = new DateTime($event['date']);
		$date->setTimezone(new DateTimeZone('Pacific/Auckland'));
		
		
		$content = "<div class=\"event\"><h3>{$event['name']}</h3>";
		$content .= '<p class="event_icon"><i class="fa fa-calendar-o fa-3x" aria-hidden="true"></i></p>';
		$content .= "<h4>{$event['venue']}</h4>";
		$content .= "<p class=\"event_date\">{$date->format('l, F jS, Y')}</p>";
		
		$content .= "</div>";
		return $content;
		//    return print_r($event, true);
	}
	/**
	 * Reads events for preceeding and following two months, and builds them into a carousel
	 * @param unknown $attr
	 * @return string
	 */
	function events_slider($attr) {
		wp_enqueue_style ( 'slick' );
		wp_enqueue_style ( 'slick-theme' );
		wp_enqueue_script ( 'slick' );
		$google_api = 'AIzaSyBrdzLAJw2Kvrt28jzyGGVw_dSGUsUnq-k';
		
		$now = date ( 'Y-m-d' );
		$past = date ( "Y-m-d", strtotime ( "-2 months" ) );
		$future = date ( "Y-m-d", strtotime ( "+2 month", strtotime ( "now" ) ) );
		$events = $this -> hello -> get_events($past, $future);
				
		$internal_events = array ();
		
		$pastEvents = array ();
		$futureEvents = array ();
		
		$now = new DateTime ();
		foreach ( $events as $event ) {
			$date = new DateTime ( $event ['date'] );
			$date->setTimezone ( new DateTimeZone ( 'Pacific/Auckland' ) );
			if ($date > $now) {
				array_push ( $futureEvents, $event );
			} else {
				array_push ( $pastEvents, $event );
			}
		}
		
		$slick_content = "<div class=\"slick\">";
		
		$initial_slide = - 1;
		
		foreach ( $events as $idx => $event ) {
			$date = new DateTime ( $event ['date'] );
			$date->setTimezone ( new DateTimeZone ( 'Pacific/Auckland' ) );
			if ($date > $now && $initial_slide < 0) {
				$initial_slide = $idx;
			}
			$slick_content .= $this -> convert_event_to_display ( $event );
		}
		
		if ($initial_slide < 0) {
			$initial_slide = 0;
		}
		
		$slick_content .= <<<slickinit
</div><script>
$(function() {
$('.slick').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  initialSlide: $initial_slide,
  responsive: [
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 765,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
});

</script>
slickinit;
		
		$html = $slick_content;
		
		return $html;
	}
}

$rwnzEvents = new RWNZEvents();