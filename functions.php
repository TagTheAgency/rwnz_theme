<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

include_once 'advanced-custom-fields/acf.php';
// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

add_post_type_support( 'page', 'excerpt' );


if (!isset($content_width))
{
	$content_width = 900;
}

if (function_exists('add_theme_support'))
{
	// Add Menu Support
	add_theme_support('menus');

	// Add Thumbnail Theme Support
	add_theme_support('post-thumbnails');
	add_image_size('large', 700, '', true); // Large Thumbnail
	add_image_size('page-header', 1000, 478, true); // Large Thumbnail
	
	add_image_size('medium', 250, '', true); // Medium Thumbnail
	add_image_size('small', 120, '', true); // Small Thumbnail
	add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
	add_image_size('sub-nav', 200, 250, true); 

	// Add Support for Custom Backgrounds - Uncomment below if you're going to use
	/*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
	));*/

	// Add Support for Custom Header - Uncomment below if you're going to use
	/*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
	));*/

	// Enables post and comment RSS feed links to head
	add_theme_support('automatic-feed-links');

	// Localisation Support
	load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
	if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

		wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
		wp_enqueue_script('conditionizr'); // Enqueue it!

		wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
		wp_enqueue_script('modernizr'); // Enqueue it!

		wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
		wp_enqueue_script('html5blankscripts'); // Enqueue it!
		
		
	}
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
	if (is_page('pagenamehere')) {
		wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
		wp_enqueue_script('scriptname'); // Enqueue it!
	}
}

// Load HTML5 Blank styles
function html5blank_styles()
{
	wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
	wp_enqueue_style('normalize'); // Enqueue it!

	wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
	wp_enqueue_style('html5blank'); // Enqueue it!
	
	wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '4.0.0', 'all');
	wp_enqueue_style('bootstrap'); // Enqueue it!
	
	wp_register_style('fa', get_template_directory_uri() . '/css/font-awesome.min.css', '4.2.0', all);
	wp_enqueue_style('fa'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
	register_nav_menus(array( // Using array to specify more menus if needed
		'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
		'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
		'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
	));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
	$args['container'] = false;
	return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
	return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
	return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
	global $post;
	if (is_home()) {
		$key = array_search('blog', $classes);
		if ($key > -1) {
			unset($classes[$key]);
		}
	} elseif (is_page()) {
		$classes[] = sanitize_html_class($post->post_name);
	} elseif (is_singular()) {
		$classes[] = sanitize_html_class($post->post_name);
	}

	return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
	// Define Sidebar Widget Area 1
	register_sidebar(array(
		'name' => __('Widget Area 1', 'html5blank'),
		'description' => __('Description for this widget-area...', 'html5blank'),
		'id' => 'widget-area-1',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

	// Define Sidebar Widget Area 2
	register_sidebar(array(
		'name' => __('Widget Area 2', 'html5blank'),
		'description' => __('Description for this widget-area...', 'html5blank'),
		'id' => 'widget-area-2',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
	global $wp_widget_factory;
	remove_action('wp_head', array(
		$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
		'recent_comments_style'
	));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
	global $wp_query;
	$big = 999999999;
	echo paginate_links(array(
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
	return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
	return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
	global $post;
	if (function_exists($length_callback)) {
		add_filter('excerpt_length', $length_callback);
	}
	if (function_exists($more_callback)) {
		add_filter('excerpt_more', $more_callback);
	}
	$output = get_the_excerpt();
	$output = apply_filters('wptexturize', $output);
	$output = apply_filters('convert_chars', $output);
	$output = '<p>' . $output . '</p>';
	echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
	global $post;
	return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
	return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
	return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
	$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
	return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
	$myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
	$avatar_defaults[$myavatar] = "Custom Gravatar";
	return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}
	}
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<!-- heads up: starting < for the html tag (li or div) in the next line: -->
	<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('init', 'create_post_type_bursary'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
	register_taxonomy_for_object_type('category', 'submission'); // Register Taxonomies for Category
	register_taxonomy_for_object_type('post_tag', 'submission');
	register_post_type('submission', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => __('Submission Post', 'submission'), // Rename these to suit
			'singular_name' => __('Submission Post', 'submission'),
			'add_new' => __('Add New', 'submission'),
			'add_new_item' => __('Add New Submission Post', 'submission'),
			'edit' => __('Edit', 'submission'),
			'edit_item' => __('Edit Submission Post', 'submission'),
			'new_item' => __('New Submission Post', 'submission'),
			'view' => __('View Submission Post', 'submission'),
			'view_item' => __('View Submission Post', 'submission'),
			'search_items' => __('Search Submission Post', 'submission'),
			'not_found' => __('No Submission  found', 'submission'),
			'not_found_in_trash' => __('No Submission Posts found in Trash', 'submission')
		),
		'public' => true,
		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
		'taxonomies' => array(
			'post_tag',
			'category'
		) // Add Category and Post Tags support
	));
}

function create_post_type_bursary() {
	register_post_type('bursary', // Register Custom Post Type
		array(
			'labels' => array(
				'name' => __('Bursary', 'bursary'), // Rename these to suit
				'singular_name' => __('Bursary', 'bursary'),
				'add_new' => __('Add New', 'bursary'),
				'add_new_item' => __('Add New Bursary', 'bursary'),
				'edit' => __('Edit', 'bursary'),
				'edit_item' => __('Edit Bursary', 'bursary'),
				'new_item' => __('New Bursary', 'bursary'),
				'view' => __('View Bursary', 'bursary'),
				'view_item' => __('View Bursary', 'bursary'),
				'search_items' => __('Search Bursaries', 'bursary'),
				'not_found' => __('No Bursaries  found', 'bursary'),
				'not_found_in_trash' => __('No Bursaries found in Trash', 'bursary')
			),
			'public' => true,
			'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail'
			), // Go to Dashboard Custom HTML5 Blank post for supports
			'can_export' => true, // Allows export in Tools > Export
			'menu_icon' => get_template_directory_uri() . '/img/icons/icon-bursary2.png'
			));
}
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_bursary',
		'title' => 'Bursary',
		'fields' => array (
			array (
				'key' => 'field_59fa3a22c69e2',
				'label' => 'Application Form',
				'name' => 'application_form',
				'type' => 'file',
				'instructions' => 'Please upload the application form here',
				'save_format' => 'id',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'bursary',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
	return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
	return '<h2>' . $content . '</h2>';
}

function bursary_shortcode($atts, $content = null) {
   $bursaries = new WP_Query( array(
		'orderby'	=> 'menu_order',
		'post_type'      => 'bursary', // set the post type to page
		'order'	=> 'asc'
	));
	$compiled_content = '<div class="bursaries">';
	
	if ( $bursaries->have_posts() ) : while ( $bursaries->have_posts() ) : $bursaries->the_post();

	$compiled_content .= '<div class="bursary row">';
	$compiled_content .= '<div class="col-md-6"><h3> ' . the_title('','',false) . '</h3>';
	$bursary_content = apply_filters('the_content',get_the_content());
	
	$compiled_content .= '<div class="content">' . $bursary_content . '</div>';
	$compiled_content .= '</div>';
	
	$compiled_content .= '<div class="col-md-6 attachment"><a href="' . wp_get_attachment_url(get_post_meta(get_the_ID(), 'application_form', true)) . '">Download application form</a></div></div>';
	

	endwhile; endif;  
	
	$compiled_content .= "</div>";
	wp_reset_postdata();
	return $compiled_content; 

}
add_shortcode('bursaries', 'bursary_shortcode'); // You can place [html5_shortcode_demo] in Pages, Posts now.

function board_papers($atts) {
	return getBoardPapers();
}

add_shortcode('board-papers', 'board_papers');

add_shortcode('events', 'get_events');

/*------------------------------------*\
	Meta boxes
\*------------------------------------*/

function rwnz_add_meta_boxes( $post ) {

	// Get the page template post meta
	$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
	// If the current page uses our specific
	// template, then output our custom metabox

	add_meta_box(
		'colour-meta-box', // id, used as the html id att
		( 'Page theme colour' ), // meta box title, like "Page Attributes"
		'colour_theme_meta_box_cb', // callback function, spits out the content
		'page', // post type or page. We'll add this to pages only
		'side', // context (where on the screen
		'low' // priority, where should this go in the context?
	);
	
}
add_action( 'add_meta_boxes_page', 'rwnz_add_meta_boxes' );

function colour_theme_meta_box_cb($post) {
	$selected = get_post_meta( $post->ID, 'page-colour-theme', true );
	/* Display the post meta box. */
	wp_nonce_field( basename( __FILE__ ), 'page-colour-theme_nonce' ); ?>

  <p>
	<label for="page-colour-theme"><?php _e( "Select colour theme for page", 'example' ); ?></label>
	<br />
	<select name="page-colour-theme" id="page-colour-theme" style="background-color: <?php echo $selected?>">
		<option value="#c0d72f" style="background-color:#c0d72f" <?php selected( $selected, '#c0d72f'); ?>>Theme color</option>
		<option value="#74b64a" style="background-color:#74b64a" <?php selected( $selected, '#74b64a'); ?>>Theme color</option>
		<option value="#00aba0" style="background-color:#00aba0" <?php selected( $selected, '#00aba0'); ?>>Theme color</option>
		<option value="#5fccf5" style="background-color:#5fccf5" <?php selected( $selected, '#5fccf5'); ?>>Theme color</option>
		<option value="#e6e6e8" style="background-color:#e6e6e8" <?php selected( $selected, '#e6e6e8'); ?>>Theme color</option>
		<option value="#414042" style="background-color:#414042; color: white;" <?php selected( $selected, '#414042'); ?>>Theme color</option>
		<option value="#009fc2" style="background-color:#009fc2" <?php selected( $selected, '#009fc2'); ?>>Theme color</option>
		
	</select>
  </p>
  <script>
	jQuery( "#page-colour-theme" ).change(function() {
		jQuery('#page-colour-theme').css( "background-color", jQuery('#page-colour-theme').val() );
		
	});
  </script>
<?php 
}



function page_colour_theme_save_custom_post_meta($post_id) {
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'page-colour-theme' ] ) ) {
		update_post_meta( $post_id, 'page-colour-theme', sanitize_text_field( $_POST[ 'page-colour-theme' ] ) );
	}
	
}
add_action( 'publish_page', 'page_colour_theme_save_custom_post_meta' );
add_action( 'draft_page', 'page_colour_theme_save_custom_post_meta' );
add_action( 'future_page', 'page_colour_theme_save_custom_post_meta' );


function hex2RGB($hex) {
	preg_match("/^#{0,1}([0-9a-f]{1,6})$/i",$hex,$match);
	if(!isset($match[1])) {
		return false;
	}
	
	if(strlen($match[1]) == 6) {
		list($r, $g, $b) = array($hex[1].$hex[2],$hex[3].$hex[4],$hex[5].$hex[6]);
	}
	elseif(strlen($match[1]) == 3)
	{
		list($r, $g, $b) = array($hex[0].$hex[0],$hex[1].$hex[1],$hex[2].$hex[2]);
	}
	else if(strlen($match[1]) == 2)
	{
		list($r, $g, $b) = array($hex[0].$hex[1],$hex[0].$hex[1],$hex[0].$hex[1]);
	}
	else if(strlen($match[1]) == 1)
	{
		list($r, $g, $b) = array($hex.$hex,$hex.$hex,$hex.$hex);
	}
	else
	{
		return false;
	}
	
	$color = array();
	$color['r'] = hexdec($r);
	$color['g'] = hexdec($g);
	$color['b'] = hexdec($b);
	
	return $color;
}

/* Drop box integration */


function rwnz_settings_init() {
	// register a new setting for "reading" page
	register_setting('general', 'rwnz_dropbox_api_token');
	register_setting('general', 'rwnz_dropbox_board_papers_location');

    register_setting('general', 'rwnz_hello_club_base_url');
 
	// register a new section in the "reading" page
	add_settings_section(
		'rwnz_settings_section',
		'RWNZ Settings Section',
		'rwnz_settings_section_cb',
		'general'
	);
 
	// register a new field in the "rwnz_settings_section" section, inside the "reading" page
	add_settings_field(
		'rwnz_dropbox_api_setting',
		'Dropbox API token',
		'rwnz_dropbox_api_token_cb',
		'general',
		'rwnz_settings_section'
	);

	add_settings_field(
		'rwnz_dropbox_boardpapers_location',
		'Path to board papers',
		'rwnz_dropbox_boardpapers_cb',
		'general',
		'rwnz_settings_section'
	);

	add_settings_field(
		'rwnz_hello_club_base_url',
		'Hello Club API URL',
		'rwnz_hello_club_base_url_cb',
		'general',
		'rwnz_settings_section'
	);
}
 
/**
 * register wporg_settings_init to the admin_init action hook
 */
add_action('admin_init', 'rwnz_settings_init');
 
/**
 * callback functions
 */
 
// section content cb
function rwnz_settings_section_cb()
{
	echo '<p>RWNZ specific settings.</p>';
}
 
// field content cb
function rwnz_dropbox_api_token_cb()
{
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('rwnz_dropbox_api_token');
	// output the field
	?>
	<input type="text" class="regular-text code" name="rwnz_dropbox_api_token" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}

function rwnz_dropbox_boardpapers_cb()
{
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('rwnz_hello_club_api_setting');
	// output the field
	?>
	<input type="text" class="regular-text" name="rwnz_hello_club_api_setting" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}

function rwnz_hello_club_api_cb() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('rwnz_dropbox_board_papers_location');
    // output the field
    ?>
	<input type="text" class="regular-text" name="rwnz_dropbox_board_papers_location" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}
function rwnz_hello_club_base_url_cb()
{
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('rwnz_hello_club_base_url');
	// output the field
	?>
	<input type="text" class="regular-text" name="rwnz_hello_club_base_url" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}


add_action( 'http_api_debug', 'viper_http_api_debug', 10, 5 );
 
function viper_http_api_debug( $response, $type, $class, $args, $url ) {
	// You can change this from error_log() to var_dump() but it can break AJAX requests
	error_log( 'Request URL: ' . var_export( $url, true ) );
	error_log( 'Request Args: ' . var_export( $args, true ) );
	error_log( 'Request Response : ' . var_export( $response, true ) );
}

function get_events($attr) {
	$url = get_option('rwnz_hello_club_base_url') . '/event?fromDate=2017-01-01&toDate=2017-12-31';
	
	$response = wp_remote_get($url);

	if ( is_wp_error( $response ) ) {
	 
		$html = '<div id="post-error">';
			$html .= __( 'There was a problem retrieving the response from the server.', 'wprp-example' );
		$html .= '</div><!-- /#post-error -->';
	 	return $html;
	}
	
	$body = $response['body'];
	$events = json_decode($body, true);

	$internal_events = array();

	foreach ($events as $event ) {
		$date = new DateTime($event['date']);
		$date->setTimezone(new DateTimeZone('Pacific/Auckland'));

		$compiled_content = '<div class="bursary row">';
		$compiled_content .= '<div class="col-md-6"><h3> ' . $event['name'] . '</h3>';
		$compiled_content .= '<div class="date">' . $date->format('l, F jS, Y') . '</div>';
		$event_content = apply_filters('the_content', esc_html($event['description']));
		
		$compiled_content .= '<div class="content">' . $event_content . '</div>';
		$compiled_content .= '</div>';
		
		$compiled_content .= '<div class="col-md-6 attachment">Some content here?</div></div>';



		$html .= $compiled_content;
	}

	return $html;


}

function getBoardPapers() {
	$api_key = get_option('rwnz_dropbox_api_token');
	$url = 'https://api.dropboxapi.com/2/files/list_folder';
	$path = get_option('rwnz_dropbox_board_papers_location');



	$response = wp_remote_post( $url, array(
		'body'  => json_encode(array('path' => $path)),
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key,
			'Content-Type' => 'application/json'
		)
	));

	if ( is_wp_error( $response ) ) {
	 
		$html = '<div id="post-error">';
			$html .= __( 'There was a problem retrieving the response from the server.', 'wprp-example' );
		$html .= '</div><!-- /#post-error -->';
	 
	}
	else {
		
		$body = $response['body'];
		$decoded = json_decode($body);
		$entries = $decoded -> entries;

		foreach ($entries as $entry) {
			$cast = (array)$entry;
			if ($entry->{'.tag'} == 'file') {
				$html .= '<p><a href="index.php?pagename=board-papers&boardpaper=' . $entry->name . '">' . $entry -> name . '</p>';
			}
		}
//        print_r($entries);
	 
	}

	return $html;

}
function add_boardpaper_query_vars_filter( $vars ){
	$vars[] = "boardpaper";
	return $vars;
}
add_filter( 'query_vars', 'add_boardpaper_query_vars_filter' );

function download_board_paper() {
	$api_key = get_option('rwnz_dropbox_api_token');
	$url = 'https://api.dropboxapi.com/2/files/get_temporary_link';

	$download = get_query_var('download');
//	if (!$download) {
//		$url = 'https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings';
//	}

	error_log("CSJM url is ".$url);
	$path = get_option('rwnz_dropbox_board_papers_location');
	$file = get_query_var('boardpaper');

	$file_path = $path . '/' . $file;

	$response = wp_remote_post( $url, array(
		'body'  => json_encode(array('path' => $file_path)),
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key,
			'Content-Type' => 'application/json'
		)
	));

	$body = $response['body'];
	$decoded = json_decode($body);
	//echo $decoded -> link;
//	if (!$download) {
		wp_redirect( $decoded -> link );
//	} else {
//		wp_redirect( $decoded -> url);
//	}

	
	exit;

}

function get_share_link($path) {
	$url = 'https://api.dropboxapi.com/2/sharing/list_shared_links';
	$body = json_encode(array('path' => $path, 'direct_only' => true));
	$data = array(
		'body' => $body,
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key,
			'Content-Type' => 'application/json'
		)
	);


}

function rwnz_rewrite_rule() {
	add_rewrite_rule('^board/paper/(.*)?','index.php?pagename=board-papers&boardpaper=$matches[1]','top');
	add_rewrite_endpoint( 'board-papers', EP_PERMALINK | EP_PAGES );

}
add_action('init', 'rwnz_rewrite_rule', 10, 0);

function rwnz_custom_display() {
	$dials_page = get_query_var('pagename');
	if ('board-papers' == $dials_page) {
//        header("HTTP/1.1 200 OK");
		download_board_paper();
		exit;
	} /*else if ('public-dial' == $dials_page) {
		header("HTTP/1.1 200 OK");
		include( get_template_directory().'/public-dial-page.php');
		exit;
	} else if ('pdf-dial' == $dials_page) {
		header("HTTP/1.1 200 OK");
		include( get_template_directory().'/pdfgen.php');
		exit;
	}*/
}

//register plugin custom pages display
add_filter('template_redirect', 'rwnz_custom_display');


/**************
 * Login      *
 **************/

add_action( 'wp_ajax_rwnz_login', rwnz_login );
add_action( 'wp_ajax_nopriv_rwnz_login', rwnz_login );

function rwnz_login() {
	$username = $_REQUEST['u'];
	$password = $_REQUEST['p'];
	
	$url = get_option('rwnz_hello_club_base_url') . '/auth/token';

	$response = wp_remote_post( $url, array(
		'body'  => json_encode(array('grantType' => 'password', 'username' => $username, 'password' => $password)),
		'headers' => array(
			'Content-Type' => 'application/json'
		)
	));

	echo json_encode($response);
    wp_die();
}


?>
