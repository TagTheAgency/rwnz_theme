<?php


class RWNZMigrate {

	protected $baseUrl;
	
	function __construct() {
		$this -> baseUrl = "https://www.ruralwomen.org.nz";
				
		add_action( 'wp_ajax_run_migration', array($this, 'parseImport' ) );
		
	}
	
	
	function parseImport() {
	    require_once("../wp-load.php");
	    
	    require_once(ABSPATH . 'wp-admin/includes/file.php');
	    require_once(ABSPATH . 'wp-admin/includes/media.php');
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    

	    
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
            
            $pattern = '/<span class="CSJM-image-replacement" data-src="(.*)"><\/span>/';
            
            preg_match_all($pattern, $body, $matches, PREG_SET_ORDER, 0);
            
//            error_log(print_r($matches, true));
            
            foreach ($matches as $val) {
                error_log(print_r($val[1], true));
                
                $this->addImageToMedia($val[1]);
            }
            
            $body = preg_replace($pattern, '[migrated-image src="${1}"]', $body);
            
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

            $featured_image = (string)($post->img);
            if ($featured_image) {
                $img_ref = $this->setFeaturedImage($post_id, $featured_image);
                
            }
            
            echo "... Created ". $post_id; 
//            echo ('<br>');
        }
        
        wp_die();
        // wp_redirect( $_SERVER['HTTP_REFERER'] );
    }
	
    function addImageToMedia($image_url) {
        error_log("Processing image ".$image_url);
        error_log("Looking up option rwnz-migrate-image-".mb_strtolower($image_url));
        //check if we've already processed it.
        $exists = get_option("rwnz-migrate-image-".mb_strtolower($image_url));
        
        if (is_wp_error($exists)) {
            print_r ("... Errored... " . $exists -> get_error_message());
            return -1;
        }
        
        if ($exists) {
            return $exists;
        }
        
        $result = media_sideload_image($image_url, -1, '', 'id');
        
        add_option("rwnz-migrate-image-".mb_strtolower($image_url), $result);
        
        return $result;
        
    }
    
	function setFeaturedImage($post_id, $image_url) {
	   
	    
	    // required libraries for media_sideload_image

	    
	    // load the image
	    $description = "";
	    $result = $this->addImageToMedia($image_url);
	    if ($result < 0) {
	        error_log("Image didn't upload properly");
	        return;
	    }
	    
	    error_log("Setting post thumbnail for $post_id");
	    
	    set_post_thumbnail($post_id, $result);
	    
// 	    // then find the last image added to the post attachments
// 	    $attachments = get_posts(array('numberposts' => '1', 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));
	    
	    
// 	    if(sizeof($attachments) > 0){
// 	        // set image as the post thumbnail
// 	        set_post_thumbnail($post_id, $attachments[0]->ID);
// 	    }  
	}
	    
	
}

$rwnzMigrate = new RWNZMigrate();