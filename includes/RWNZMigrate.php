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
        
        // print_r($arr);
        
        foreach ($arr as $post) {
            print_r("<br>Processing ".(string) ($post->title));
            
            $title = (string) ($post->title);
            
            $page = get_page_by_title($title, OBJECT, 'post');
            if ($page->ID) {
                print_r("... Post already exists, skipping");
                continue;
            }
            
            echo "... Creating post. ";

            $postType = 'post'; 
            $userID = 1; 
            $postStatus = 'publish'; 
            
            
            
            
            print_r((string) ($post->title));
            echo ('<br>');
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