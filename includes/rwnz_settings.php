<?php

add_action( 'admin_menu', 'rwnz_admin_menu' );

function rwnz_admin_menu() {
    add_options_page('RWNZ settings', 'RWNZ settings', 'manage_options', 'rwnz', 'rwnz_options_page' );
}
add_action( 'admin_init', 'rwnz_settings_init' );
function rwnz_settings_init() {
  
    register_setting('rwnz-settings-group', 'rwnz_dropbox_api_token');
    register_setting('rwnz-settings-group', 'rwnz_dropbox_board_papers_location'); 
    register_setting('rwnz-settings-group', 'rwnz_hello_club_base_url');
    
    // register a new section in the "reading" page
    add_settings_section(
        'rwnz_settings_section',
        'RWNZ Settings Section',
        'rwnz_settings_section_cb',
        'rwnz'
        );
    
    // register a new field in the "rwnz_settings_section" section, inside the "reading" page
    add_settings_field(
        'rwnz_dropbox_api_setting',
        'Dropbox API token',
        'rwnz_dropbox_api_token_cb',
        'rwnz',
        'rwnz_settings_section'
        );
    
    add_settings_field(
        'rwnz_dropbox_boardpapers_location',
        'Path to board papers',
        'rwnz_dropbox_boardpapers_cb',
        'rwnz',
        'rwnz_settings_section'
        );
    
    add_settings_field(
        'rwnz_hello_club_base_url',
        'Hello Club API URL',
        'rwnz_hello_club_base_url_cb',
        'rwnz',
        'rwnz_settings_section'
        );
    
    /* 
	 * http://codex.wordpress.org/Function_Reference/register_setting
	 * register_setting( $option_group, $option_name, $sanitize_callback );
	 * The second argument ($option_name) is the option name. It’s the one we use with functions like get_option() and update_option()
	 * */
  	# With input validation:
  	# register_setting( 'my-settings-group', 'rwnz-settings', 'my_settings_validate_and_sanitize' );    
  	register_setting( 'rwnz-settings-group', 'rwnz-settings' );
	
}


/* 
 * THE ACTUAL PAGE 
 * */
function rwnz_options_page() {
?>
  <div class="wrap">
      <h2>RWNZ Settings</h2>
      <form action="options.php" method="POST">
        <?php settings_fields('rwnz-settings-group'); ?>
        <?php do_settings_sections('rwnz'); ?>
        <?php submit_button(); ?>
      </form>
  </div>
<?php }



/**
 * callback functions
 */

// section content cb
function rwnz_settings_section_cb()
{
    echo '<p>To fully activate the RWNZ theme, you need to complete this section with your API keys etc.</p>';
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
	$setting = get_option('rwnz_dropbox_board_papers_location');
	// output the field
	?>
	<input type="text" class="regular-text" name="rwnz_dropbox_board_papers_location" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
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