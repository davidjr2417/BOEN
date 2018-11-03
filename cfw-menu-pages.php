<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// All Query Page Code
add_action( 'admin_menu', 'cfw_menus' );
function cfw_menus() {
	add_menu_page( 'Contact Form Queries', __( 'Contact Form Queries', NCFWS_TXTDM ),  'administrator', 'cfw-all-queries', 'cfw_all_queries', 'dashicons-email-alt', 65);
	add_submenu_page( 'cfw-all-queries', 'Shortcode', __( 'Shortcode', NCFWS_TXTDM ),  'administrator', 'evnt-attnd-form', 'cfw_shortcode');
	add_submenu_page( 'cfw-all-queries', 'Settings', __( 'Settings', NCFWS_TXTDM ), 'administrator','cfw-settings','cfw_settings');   
	add_submenu_page( 'cfw-all-queries','Our Theme', __( 'Our Theme', NCFWS_TXTDM ),  'administrator', 'sr-theme-page', 'cfw_theme_page' );
}

//all contact queries page body function
function cfw_all_queries() {
	require_once('all-query-page.php');
}

//shortccode page body
function cfw_shortcode(){
	wp_enqueue_style( 'cfw-bootstrap-css', plugin_dir_url( __FILE__ ).'css/bootstrap.css' );
	wp_enqueue_style( 'cfw-font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
	wp_enqueue_script( 'cfw-boostrap-js', plugin_dir_url( __FILE__ ).'js/bootstrap.js', array('jquery'), '3.3.6', true );
	?>
	<h2><?php _e('Contact Form Shortcode', NCFWS_TXTDM); ?> - [CFW]</h2>
	<hr>
	<div>
		<p><?php _e('Use', NCFWS_TXTDM); ?><strong>[CFW]</strong><?php _e('Shortcode to display Contact Form on any Page / Post.', NCFWS_TXTDM); ?></p>
		<p><strong><?php _e('Note:', NCFWS_TXTDM); ?></strong><?php _e('Don t use multiple shortcode on same Page / Post.', NCFWS_TXTDM); ?></p>
	</div>
	<?php
}

// theme page
function cfw_theme_page() {
	require_once('our-theme/awp-theme.php');
}

// setting page body
function cfw_settings() {
	require_once('settings-page.php');	
}
?>