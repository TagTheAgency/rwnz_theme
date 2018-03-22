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
include_once 'includes/rwnz_settings.php';

include_once 'includes/HelloClub.php';
include_once 'includes/Events.php';
include_once 'includes/RWNZLogin.php';
include_once 'includes/RWNZMigrate.php';

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

add_post_type_support( 'page', 'excerpt' );

function register_my_session() {
    if( !session_id()) {
        session_start();
    }

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        // session started more than 30 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }

}

add_action('init', 'register_my_session');


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

		wp_register_script('bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.bundle.min.js', array('jquery'), '4.0.0'); // Custom scripts
		wp_enqueue_script('bootstrap'); // Enqueue it!

		wp_register_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0' );

		$google_api = 'AIzaSyBrdzLAJw2Kvrt28jzyGGVw_dSGUsUnq-k';
		wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_api . '&libraries=places', array(), '1.0.0');

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

	wp_register_style('fa', get_template_directory_uri() . '/css/font-awesome.min.css', '4.2.0', 'all');
	wp_enqueue_style('fa'); // Enqueue it!

	wp_register_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.0.0', 'all' );
	wp_register_style( 'slick-theme', get_template_directory_uri() . '/css/slick-theme.css', array(), '1.0.0', 'all' );


}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
	register_nav_menus(array( // Using array to specify more menus if needed
		'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
		'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
		'extra-menu' => __('Extra Menu', 'html5blank'),
		'frontpage-menu' => 'Home page menu items',
	    'services-menu' => 'Services menu'
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

function get_bootstrap_paginate_links() {
    ob_start();
    ?>
<?php
				global $wp_query;
				$current = max( 1, absint( get_query_var( 'paged' ) ) );
				$pagination = paginate_links( array(
					'base' => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
					'format' => '?paged=%#%',
					'current' => $current,
					'total' => $wp_query->max_num_pages,
					'type' => 'array',
					'prev_text' => '&laquo;',
					'next_text' => '&raquo;',
				) ); ?>
<?php if ( ! empty( $pagination ) ) : ?>
				<ul class="pagination pagination-lg">
<?php foreach ( $pagination as $key => $page_link ) : ?>
				<? $page_link = str_replace( "page-numbers", "page-link", $page_link ); ?>
				<li class="page-item<?php if ( strpos( $page_link, 'current' ) !== false ) { echo ' active'; } ?>"><?php echo $page_link ?></li>
<?php endforeach ?>
				</ul>
<?php endif ?>
<?php
	$links = ob_get_clean();
	return apply_filters( 'sa_bootstap_paginate_links', $links );
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

// Custom excerpt limit override
function custom_excerpt_length( $length ) {
        return 10;
    }
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

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
add_action('init', 'create_post_type_submission');
add_action('init', 'create_post_type_bursary');
add_action('init', 'create_post_type_directory');
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination
add_action('init', 'build_taxonomies', 0 );

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

// Simply remove anything that looks like an archive title prefix ("Archive:", "Foo:", "Bar:").
add_filter('get_the_archive_title', function ($title) {
    return preg_replace('/^.*: /', '', $title);
});

function build_taxonomies() {
    register_taxonomy( 'business_directory', 'directory', array( 'hierarchical' => true, 'label' => 'Business Directory Categories', 'query_var' => true, 'rewrite' => true, 'show_in_nav_menus' => true ) );
}

function create_post_type_submission() {
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
function create_post_type_directory() {
	register_taxonomy_for_object_type('business_directory', 'directory'); // Register Taxonomies for Category
	register_post_type('directory', // Register Custom Post Type
		array(
		'labels' => array(
			'name' => 'Directory entry', // Rename these to suit
			'singular_name' => 'Directory entry',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Directory Entry',
			'edit' => 'Edit',
			'edit_item' => 'Edit Directory Entry',
			'new_item' => 'New Directory Entry',
			'view' => 'View Directory Entry',
			'view_item' => 'View Directory Entry',
			'search_items' => 'Search Directory Entries',
			'not_found' => 'No business found',
			'not_found_in_trash' => 'No directory entry found in Trash'
		),
		'public' => true,
		'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor'
		), // Go to Dashboard Custom HTML5 Blank post for supports
		'can_export' => true, // Allows export in Tools > Export
		'taxonomies' => array(
			'business_directory'
		) // Add Category and Post Tags support
	));
}
add_action('admin_menu', 'directory_register_ref_page');
/**
 * Adds a submenu page under a custom post type parent.
 */
function directory_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=directory',
        'Settings',
        'Settings',
        'manage_options',
        'directory-settings-ref',
        'directory_settings_cb'
        );
}

/**
 * Display callback for the submenu page.
 */
function directory_settings_cb() {

    // Save attachment ID
    if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
    update_option( 'business-directory-featured-image', absint( $_POST['image_attachment_id'] ) );
    endif;

    wp_enqueue_media();


    ?>
    <div class="wrap">
    <h1>Business directory settings</h1>
    <h2>Select the featured image for the business directory pages</h2>
    <form method='post'>
	<div class='image-preview-wrapper'>
		<img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'business-directory-featured-image' ) ); ?>' height='100'>
	</div>
	<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
	<input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'business-directory-featured-image' ); ?>'>
	<input type="submit" name="submit_image_selector" value="Save" class="button-primary">
	</form>

    </div>

    <?php
}


add_action( 'admin_footer', 'media_selector_print_scripts' );
function media_selector_print_scripts() {
    global $pagenow;
    if (( $pagenow == 'edit.php' ) && ($_GET['post_type'] == 'directory') && ($_GET['page'] == 'directory-settings-ref')) {

        $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );
        ?><script type='text/javascript'>
    		jQuery( document ).ready( function( $ ) {
    			// Uploading files
    			var file_frame;
    			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
    			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
    			jQuery('#upload_image_button').on('click', function( event ){
    				event.preventDefault();
    				// If the media frame already exists, reopen it.
    				if ( file_frame ) {
    					// Set the post ID to what we want
    					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
    					// Open frame
    					file_frame.open();
    					return;
    				} else {
    					// Set the wp.media post id so the uploader grabs the ID we want when initialised
    					wp.media.model.settings.post.id = set_to_post_id;
    				}
    				// Create the media frame.
    				file_frame = wp.media.frames.file_frame = wp.media({
    					title: 'Select a image to upload',
    					button: {
    						text: 'Use this image',
    					},
    					multiple: false	// Set to true to allow multiple files to be selected
    				});
    				// When an image is selected, run a callback.
    				file_frame.on( 'select', function() {
    					// We set multiple to false so only get one image from the uploader
    					attachment = file_frame.state().get('selection').first().toJSON();
    					// Do something with attachment.id and/or attachment.url here
    					$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
    					$( '#image_attachment_id' ).val( attachment.id );
    					// Restore the main post ID
    					wp.media.model.settings.post.id = wp_media_post_id;
    				});
    					// Finally, open the modal
    					file_frame.open();
    			});
    			// Restore the main ID when the add media button is pressed
    			jQuery( 'a.add_media' ).on( 'click', function() {
    				wp.media.model.settings.post.id = wp_media_post_id;
    			});
    		});
    	</script><?php
    }
}

function create_post_type_bursary() {
	register_post_type('bursary', // Register Custom Post Type
		array(
			'labels' => array(
				'name' => __('Bursary', 'bursary'),
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
if(function_exists("register_field_group")) {
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

	register_field_group(array (
		'id' => 'acf_business-directory',
		'title' => 'Business Directory',
		'fields' => array (
			array (
				'key' => 'field_5a1b443c9b6e8',
				'label' => 'Contact',
				'name' => 'contact',
				'type' => 'text',
				'instructions' => 'Who to contact at the business',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a1b447e9b6e9',
				'label' => 'Mobile',
				'name' => 'mobile',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a1b44a19b6ea',
				'label' => 'Email',
				'name' => 'email',
				'type' => 'email',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_5a1b44af9b6eb',
				'label' => 'Website',
				'name' => 'website',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a1b44db9b6ec',
				'label' => 'Phone',
				'name' => 'phone',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5a1b44ec9b6ed',
				'label' => 'Address',
				'name' => 'address',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 3,
				'formatting' => 'br',
			),
			array (
				'key' => 'field_5a1b45259b6ee',
				'label' => 'Logo',
				'name' => 'logo',
				'type' => 'image',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'directory',
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

    register_field_group(array (
        'id' => 'acf_members-only',
        'title' => 'Members only',
        'fields' => array (
            array (
                'key' => 'field_5aa99cf0111f9',
                'label' => 'Members only',
                'name' => 'members_only',
                'type' => 'true_false',
                'instructions' => 'Select this if the page should be visible only to logged in users',
                'message' => '',
                'default_value' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
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

	$compiled_content .= '<div class="bursary">';
	$compiled_content .= '<div class="bursary-content"><h3> ' . the_title('','',false) . '</h3>';
	$bursary_content = apply_filters('the_content',get_the_content());

	$compiled_content .= '<div class="content">' . $bursary_content . '</div>';
	$compiled_content .= '</div>';

	$compiled_content .= '<div class="attachment"><a class="btn btn-secondary" href="' . wp_get_attachment_url(get_post_meta(get_the_ID(), 'application_form', true)) . '">Apply Online</a> &nbsp; <a class="btn btn-secondary" href="' . wp_get_attachment_url(get_post_meta(get_the_ID(), 'application_form', true)) . '">Download application form</a></div></div>';

    $compiled_content .= '<hr></hr>';


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

function migrated_image($atts) {
    
    error_log(print_r($atts, true));
    error_log("getting a migrated image " . $atts['src']);
    $image =  get_option("rwnz-migrate-image-".mb_strtolower($atts['src']));
    
    return wp_get_attachment_image($image, 'full');

}

add_shortcode('migrated-image', 'migrated_image');

function member_name($atts) {
    return is_logged_in();
}

add_shortcode('member-name', 'member_name');


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
		<option value="#c0d72f" style="background-color:#c0d72f" <?php selected( $selected, '#c0d72f');?>>Theme color</option>
		<option value="#74b64a" style="background-color:#74b64a" <?php selected( $selected, '#74b64a');?>>Theme color</option>
		<option value="#00aba0" style="background-color:#00aba0" <?php selected( $selected, '#00aba0');?>>Theme color</option>
		<option value="#5fccf5" style="background-color:#5fccf5" <?php selected( $selected, '#5fccf5');?>>Theme color</option>
		<option value="#e6e6e8" style="background-color:#e6e6e8" <?php selected( $selected, '#e6e6e8');?>>Theme color</option>
		<option value="#414042" style="background-color:#414042; color: white;" <?php selected( $selected, '#414042');?>>Theme color</option>
		<option value="#009fc2" style="background-color:#009fc2" <?php selected( $selected, '#009fc2');?>>Theme color</option>

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




add_action( 'http_api_debug', 'viper_http_api_debug', 10, 5 );

function viper_http_api_debug( $response, $type, $class, $args, $url ) {
	// You can change this from error_log() to var_dump() but it can break AJAX requests
	error_log( 'Request URL: ' . var_export( $url, true ) );
	error_log( 'Request Args: ' . var_export( $args, true ) );
	error_log( 'Request Response : ' . var_export( $response, true ) );
}


function getBoardPapers() {
	if (!is_board_member() && !is_committee_member()) {
		return "<p>Sorry, you need to be logged in as a board member to access this area.</p>";
	}

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

		$html .= "<table><tr><th>File</th><th>Download</th><th>Edit</th></tr>";
		foreach ($entries as $entry) {
			$cast = (array)$entry;
			if ($entry->{'.tag'} == 'file') {
				$html .= '<tr><td>' . $entry->name . '</td><td><a href="index.php?pagename=board-papers&boardpaper=' . $entry->name . '">' . $entry -> name . '</a></td><td> <a href="index.php?pagename=board-papers&action=edit&id=' . $entry->id. '&boardpaper=' . $entry->name . '">edit</a></td></tr>';
			}
		}
		$html .= "</table>";
//        print_r($entries);

	}

	return $html;

}
function add_boardpaper_query_vars_filter( $vars ){
	$vars[] = "boardpaper";
	array_push($vars, "action", "id");
	return $vars;
}
add_filter( 'query_vars', 'add_boardpaper_query_vars_filter' );

function download_board_paper() {
	$api_key = get_option('rwnz_dropbox_api_token');
	$url = 'https://api.dropboxapi.com/2/files/get_temporary_link';

	$action = get_query_var('action');
	error_log('csjm action is '. $action);
	if ($action == 'edit') {
	    edit_board_paper();
	    wp_die();
	}
//	if (!$download) {
//		$url = 'https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings';
//	}

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
	wp_redirect( $decoded -> link );

	exit;

}

function edit_board_paper() {
    $api_key = get_option('rwnz_dropbox_api_token');
    $path = get_option('rwnz_dropbox_board_papers_location');
    $file = get_query_var('boardpaper');

    $id = get_query_var('id');

    $url = 'https://api.dropboxapi.com/2/sharing/list_shared_links';
    $body = json_encode(array('path' => $id, 'direct_only' => true));
    $data = array(
        'body' => $body,
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        )
    );

    $response = wp_remote_post( $url, $data);
    $body = $response['body'];

    $links = json_decode($body)->links;
    if (!empty($links)) {
        error_log('CSJM found a link redirecting to ' . $links[0] -> url);
        wp_redirect( $links[0] -> url);
        exit;
    }

    //don't already have a sharing link, generate one.
    error_log('CSJM creating a shared link');

    $url = 'https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings';
    $body = json_encode(array('path' => $path . '/' . $file));
    $data = array(
        'body' => $body,
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json'
        )
    );

    $response = wp_remote_post( $url, $data);
    $body = $response['body'];

    error_log('CSJM created the link, redirecting to ' . json_decode($body) -> url);
//    print_r($body);
    wp_redirect( json_decode($body) -> url);
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

/*	curl -X POST https://api.dropboxapi.com/2/sharing/create_shared_link_with_settings \
	--header "Authorization: Bearer <get access token>" \
	--header "Content-Type: application/json" \
	--data "{\"path\": \"/Prime_Numbers.txt\",\"settings\": {\"requested_visibility\": \"public\"}}"

*/


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

add_action( 'wp_ajax_rwnz_login', 'rwnz_login' );
add_action( 'wp_ajax_nopriv_rwnz_login', 'rwnz_login' );

add_action( 'wp_ajax_rwnz_logout', 'rwnz_logout' );
add_action( 'wp_ajax_nopriv_rwnz_logout', 'rwnz_logout' );

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

	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
	    echo json_encode(array('error'=>$error_message));
	    wp_die();
	}

	$body = $response['body'];

	if ($response['response']['code'] == 401) {
	    echo json_encode(array('error' => 'invalid'));
	    wp_die();
	}

	$token = json_decode($body) -> accessToken;


	$url = get_option('rwnz_hello_club_base_url') . '/user/me';
	$response = wp_remote_get($url, array(
		'headers' => array (
            'accept' => 'application/json',
            'Authorization' => 'Bearer '. $token
        )
    ));

	$body = $response['body'];

	$_SESSION["token"]=$token;
	$_SESSION["member_name"] = json_decode($body) -> firstName . " " . json_decode($body) -> lastName;
	$_SESSION["member_roles"] = json_decode($body) -> roles;

	$body = json_decode($body);

	echo json_encode(array('body' => $body, 'links' => login_links()));

	wp_die();
}



function login_links() {
    $links = array();
    if (is_array($_SESSION["member_roles"])) {
        array_push($links, array('href' => 'test.php', 'link' => 'Testing link'));
        if (is_board_member()) {
            array_push($links, array('href' => 'board', 'link' => 'Board members'));
        }
        if (is_committee_member()) {
            array_push($links, array('href' => 'committee', 'link' => 'Committee members'));
        }

    }
    return $links;
}

function rwnz_logout() {
    $_SESSION["token"]=null;
    $_SESSION["member_name"] = null;
    $_SESSION["member_roles"] = null;
}

add_action( 'wp_ajax_rwnz_create_account', 'rwnz_create_account_ajax' );
add_action( 'wp_ajax_nopriv_rwnz_create_account', 'rwnz_create_account_ajax' );

function rwnz_forgotten_password() {
	$username = $_REQUEST['username'];
	$hello = new HelloClub();

	echo $hello -> forgottenPassword($username);
	wp_die();

}

add_action('wp_ajax_rwnz_forgotten_password', 'rwnz_forgotten_password');
add_action('wp_ajax_nopriv_rwnz_forgotten_password', 'rwnz_forgotten_password');



function rwnz_create_account_ajax() {
	$hello = new HelloClub();

	$response = rwnz_create_account($_REQUEST['firstName'], $_REQUEST['lastName'], $_REQUEST['email']);

	$created = json_decode($response);

	//TODO these are hardcoded from the ids in HelloClub - find some way to enumerate them from there instead.
	$memberships = array('personal' => array('id' => '555bee3e4527879d33c7b31a', 'amount' => 50), 'corporate' => array('id' => '555bee3e4527879d33c7b31b', 'amount' => 100));


	if ($created->id) {
		$subscription  = $_REQUEST['subscription'];
		if ($subscription == 'none') {
			//
		} else {
			$subscription_response = rwnz_create_account_subscription($created->id, $memberships[$subscription]);
		}
	}

	$user = array('id' => $created->id, 'subscription' => json_decode($subscription_response));
	echo json_encode($user);

// 	echo $response;
// 	echo $subscription_response;
	wp_die();


}

function rwnz_create_account_subscription($member_id, $membership_id) {
	$hello = new HelloClub();
	//get an admin token... TODO this needs to be replaced by an API level token, once HelloClub implements this.
	$admin = $hello -> admin_oauth();


	$url = get_option('rwnz_hello_club_base_url') . '/subscription';
	$data = json_encode(array(
		'member' => $member_id,
		'membership' => $membership_id['id'],
		'notifyByEmail' => true,
		'startDate' => date("c"),
		'endDate' => date("c", strtotime('+1 years')),
		'transaction' => array('amount' => $membership_id['amount'], 'create' => true)
	));

	//echo $data;


	$response = wp_remote_post($url, array(
		'body'	=> $data,
		'headers' => array(
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer '. $admin)
	));

	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
	    echo json_encode(array('error'=>$error_message));
	    wp_die();
	}

	$body = $response['body'];
	return $body;

}

function rwnz_create_account($firstName, $lastName, $email) {

	$url = get_option('rwnz_hello_club_base_url') . '/user';

	$response = wp_remote_post( $url, array(
		'body'  => json_encode(array('email' => $email, 'firstName' => $firstName, 'lastName' => $lastName)),
		'headers' => array(
			'Content-Type' => 'application/json'
		)
	));

//	echo (json_encode($response));

	if ( is_wp_error( $response ) ) {
	    $error_message = $response->get_error_message();
	    echo json_encode(array('error'=>$error_message));
	    wp_die();
	}

	$body = $response['body'];
	return $body;

}

function is_logged_in() {
    error_log($_SESSION["member_name"]);
    if ($_SESSION["member_name"]) {
        return $_SESSION["member_name"];
    } else {
        return false;
    }
}

function is_board_member() {
	if (is_array($_SESSION["member_roles"])) {
		return in_array("board", $_SESSION["member_roles"], true);
	} else {
		return false;
	}
}

function is_committee_member() {
	if (is_array($_SESSION["member_roles"])) {
		return in_array("committee", $_SESSION["member_roles"], true);
	} else {
		return false;
	}
}

function check_members_only() {
//     echo ('CSJM: is logged in ' . is_logged_in());
//     echo ('CSJM members only  ' . get_post_meta(get_the_ID(), 'members_only', true) . ' value');
    if (is_logged_in() || !get_post_meta(get_the_ID(), 'members_only', true)) {
        return;
    }
    
    echo '<h1>Members only</h1><p>You must be logged in to view this page</p>';
    get_footer();
    wp_die();
    
}

/*
 Bootstrap 4.0.0-alpha2 nav walker extension class
 =================================================
 */
class bootstrap_4_walker_nav_menu extends Walker_Nav_menu {

    function start_lvl( &$output, $depth = 0, $args = array()){ // ul
        error_log("starting level");
        $indent = str_repeat("\t",$depth); // indents the outputted HTML
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span
        error_log("starting el");

        $indent = ( $depth ) ? str_repeat("\t",$depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if( $depth && $args->walker->has_children ){
            $classes[] = 'dropdown-menu';
        }

        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';

        $attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';

        $item_output = $args->before;
        $item_output .= ( $depth > 0 ) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }

}

function rwnz_page_header($title, $image_source) {
    ?>
    <section role="header" class="header">
        <section class="mainStory header-content-wrapper">
			<div class="header-image-wrapper">
				<div class="header-image-inner"><img class="img" src="<?php echo $image_source; ?>" /></div>
            </div>
            <div class="page-title-container">
				<h1><?php echo $title; ?></h1>
			</div>
		</section>
	</section>
	<?php 
}

function rwnz_archive_image($img_id) {
    $image = wp_get_attachment_image_src($img_id, '');
    $image_w = $image[1];
    $image_h = $image[2];
    if ($image_w >= $image_h) {
        echo '<div class="landscape">';
    } else {
        echo '<div class="portrait">';
    }
    the_post_thumbnail('');
	echo '</div>';
    
}

//* Changing excerpt more - only works where excerpt IS hand-crafted
function manual_excerpt_more( $excerpt ) {
    $excerpt_more = '';
    if( has_excerpt() ) {
        $excerpt_more = '&nbsp;<a href="' . get_permalink() . '" rel="nofollow">[Read more]</a>';
    }
    return $excerpt . $excerpt_more;
}
add_filter( 'get_the_excerpt', 'manual_excerpt_more' );

//debug
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
        if( $echo )
            echo $GLOBALS['current_theme_template'];
            else
                return $GLOBALS['current_theme_template'];
}
