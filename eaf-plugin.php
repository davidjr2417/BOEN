<?php
// Prevent direct file access
defined( 'ABSPATH' ) or exit;
/*
Plugin Name: Event Attendance Form Plugin
Plugin URI: https://github.com/davidjr2417/BOEN/tree/switch1
Description: Plugin To Help Track Event Attendance
Version: 1.0.0
Author: David Malone Jr
Author URI:
Text Domain: Event Attendance Form
Domain Path: /languages
*/

//Add necessary files for plugin
require_once('eaf-db.php');

require_once('eaf-handle.php');

require_once('eaf-init.php');


// EAFP Shortcode
// require_once('shortcode.php');


//Register Event Attendance Form Plugin For Activiation
register_activation_hook( __FILE__, 'ea_form_plugin_install' );


//Register Event Attendance Form Plugin For Deactiviation
// register_deactivation_hook( __FILE__, 'ea_form_plugin_uninstall' );

// ajax action
add_action( 'wp_ajax_signUp_query', 'signUp_query_form_handle' );
add_action( 'wp_ajax_nopriv_signUp_query', 'signUp_query_form_handle'  ); // need this to serve non logged in users


add_action( 'wp_ajax_login_query', 'login_query_form_handle' );
add_action( 'wp_ajax_nopriv_login_query', 'login_query_form_handle'  ); // need this to serve non logged in users

//Widget Initialize Action
add_action( 'widgets_init', function(){
	register_widget( 'eafw_Widget' );
});


?>