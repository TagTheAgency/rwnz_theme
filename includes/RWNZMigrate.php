<?php


class RWNZMigrate {

	protected $baseUrl;
	
	function __construct() {
		$this -> baseUrl = "https://www.ruralwomen.org.nz";
				
		add_action( 'wp_ajax_run_migration', array($this, 'parseImport' ) );
		
	}
	
	
	function parseImport() {
	    require_once("../wp-load.php");
	    
        $import = file_get_contents(get_template_directory() . '/migrate/import.xml');
        
        // print_r($import);
        
        $arr = simplexml_load_string($import);
        
        //Friday, April 29, 2011
        $dateFormat = "l, F j, Y";
        
        
        foreach ($arr as $post) {
            print_r("<br>Processing ".(string) ($post->title));
            
            $title = (string) ($post->title);
            $datestring = (string) ($post->date);
            $body = (string) ($post->body);
            $date = date_create_from_format($dateFormat, $datestring);
            
            $postdate = date("Y-m-d H:i:s", $date->getTimestamp());
            
            $page = get_page_by_title($title, OBJECT, 'post');
            if ($page->ID) {
                print_r("... Post already exists, skipping");
                continue;
            }
            
            echo "... Creating post. ";

            $postType = 'post'; 
            $userID = 1; 
            $postStatus = 'publish'; 
            
            $new_post = array(
                'post_title' => $title,
                'post_content' => $body,
                'post_status' => $postStatus,
                'post_date' => $postdate,
                'post_author' => $userID,
                'post_type' => $postType
            );
            
            $post_id = wp_insert_post($new_post, true);
            if (is_wp_error($post_id)) {
                print_r ("... Errored... " . $post_id -> get_error_message());
                continue;
            }
            
            echo "... Created ". $post_id; 
//            echo ('<br>');
        }
        
        wp_die();
        // wp_redirect( $_SERVER['HTTP_REFERER'] );
    }
	
	function processImage($post_id, $image_url) {
	    // required libraries for media_sideload_image
	    require_once(ABSPATH . 'wp-admin/includes/file.php');
	    require_once(ABSPATH . 'wp-admin/includes/media.php');
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    
	    // load the image
	    $description = "";
	    $result = media_sideload_image($image_url, $description);
	    
	    // then find the last image added to the post attachments
	    $attachments = get_posts(array('numberposts' => '1', 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));
	    
	    
	    if(sizeof($attachments) > 0){
	        // set image as the post thumbnail
	        set_post_thumbnail($post_id, $attachments[0]->ID);
	    }  
	}
	    
	
}

$rwnzMigrate = new RWNZMigrate();