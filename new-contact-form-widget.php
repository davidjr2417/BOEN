<?php
// Prevent direct file access
defined( 'ABSPATH' ) or exit;
/*
Plugin Name: Event Attendance Form Plugin
Plugin URI: 
Description: Plugin To Help Track Event Attendance
Version: 0.0.1
Author: David Malone Jr
Author URI: 
Text Domain: Event Attendance Form
Domain Path: /languages
*/



//Register Event Attendance Form Plugin For Activiation
register_activation_hook( __FILE__, 'ea_form_plugin_install' );
// Create ea_form Table When Pluign Activate
function ea_form_plugin_install() {
	//load create table file here
	global $wpdb;
	$table_name = $wpdb->prefix . "ea_form_db";
	$create_ea_form_query = "CREATE TABLE IF NOT EXISTS `$table_name` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	-- `name` varchar(256) NOT NULL,
	`email` varchar(256) NOT NULL,
	-- `subject` varchar(256) NOT NULL,
	-- `message` text NOT NULL,
	`date_time` datetime NOT NULL
	-- `status` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	$wpdb->query($create_ea_form_query);
}

//Register Event Attendance Form Plugin For Deactiviation
register_deactivation_hook( __FILE__, 'ea_form_plugin_uninstall' );
// Drop ea_form Table When This Plugin De-Activated 
function ea_form_plugin_uninstall(){
	//load delete table file here
	// delete table when pluign deactivate
	global $wpdb;
	$table_name = $wpdb->prefix . "ea_form_db";
	$delete_attnd_form_query = "DROP TABLE $table_name";
	$wpdb->query($delete_attnd_form_query);
}



//Plugin Text Domain
define("EAFP_TXTDM","ea-form-plugin");

add_action( 'plugins_loaded', '_load_textdomain_eaf' );

function _load_textdomain_eaf() {
		load_plugin_textdomain( EAFP_TXTDM, false, dirname( plugin_basename(__FILE__) ) .'/languages' );			
}
// EAFP Shortcode
require_once('shortcode.php');

// ajax action
add_action( 'wp_ajax_submit_user_query', 'submit_ea_form_handle' );
add_action( 'wp_ajax_nopriv_submit_user_query', 'submit_ea_form_handle'  ); // need this to serve non logged in users

function submit_ea_form_handle(){
	if(isset($_POST['action']) && $_POST['formsdata']) {
		$eafw_query_nonce_value = $_POST['security'];
		if(!wp_verify_nonce( $eafw_query_nonce_value, 'eafw_query_nonce' )) {

			$action = $_POST['action'];
			//convert sterilise forms data into array
			$eafw_data = array();
			parse_str($_POST['formsdata'], $eafw_data);
			global $wpdb;
			if($action == "submit_user_query") {
				// $name = sanitize_text_field($cfw_data['name']);
				$email = sanitize_email($eafw_data['q1']);
				// $subject = sanitize_text_field($cfw_data['subject']);
				// $message = sanitize_text_field($cfw_data['message']);
				
				// table name
				$eafw_table_name = $wpdb->prefix . 'boen_contact_form';
	
				//data array
				$eafw_columns_data = array(
					//column_name => field_value
					'id' => NULL,
					// 'name' => $name,
					'email' => $email,
					// 'subject' => $subject,
					// 'message' => $message,
					'date_time' => date("Y-m-d h:i:s")
					// 'status' => 'pending'
				);

				//format array
				$eafw_data_format = array('%d', '%s', '%s');
				
				// load saved message
				$all_setttings = get_option('contact_form_settings');
				if(isset($all_setttings)){
					$qsm = $all_setttings['qsm'];
					$qfm = $all_setttings['qfm'];
				}
				
				if($wpdb->insert( $eafw_table_name, $eafw_columns_data, $eafw_data_format)) {
					if($qsm == "") echo "Thank you, you have successfully signed in."; else echo $qsm;
				} else {
					if($qfm == "") echo "Sorry! contact from not working properly. Please directly contact to site admin using this email: ".get_option( 'admin_email' ); else echo $qfm;
				}
			}
		}// verify query nonce value
	}// end of isset
}

//Widget Initialize Action
add_action( 'widgets_init', function(){
	register_widget( 'eafw_Widget' );
});

class eafw_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'ea_form',
			'description' => 'Display event attendance form to your visitors.',
		);
		parent::__construct( 'ea_form', 'Event Attendance Form Widget', $widget_ops );
	}

	/**
	 * Outputs of the widget
	 */
	public function widget( $args, $instance ) {
		
		//css
		wp_enqueue_style( 'eafw-bootstrap-css', plugin_dir_url( __FILE__ ).'css/eafw-bootstrap.min.css' );

		wp_enqueue_style( 'font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
	
		wp_enqueue_style( 'component', plugin_dir_url( __FILE__ ).'css/component.css' );


		//js
		wp_enqueue_script( 'jquery');
		

		wp_enqueue_script( 'jquery-min-js', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array('jquery'), '', false );

		wp_enqueue_script( 'bootstrap-min-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array('jquery'), '', false );
	

		wp_enqueue_script( 'modernizr-js', plugin_dir_url( __FILE__ ) . 'js/modernizr.custom.js', array('jquery'), '', false );
		
		wp_enqueue_script( 'classie-js', plugin_dir_url( __FILE__ ) . 'js/classie.js', array('jquery'), '3.3.6', false );
		

		wp_enqueue_script( 'stepsForm-js', plugin_dir_url( __FILE__ ) . 'js/stepsForm.js', array( 'jquery' ), '', true );		

		wp_enqueue_script( 'stepsForm2-js', plugin_dir_url( __FILE__ ) . 'js/stepsForm2.js', array( 'jquery' ), '', true );		
	

		wp_enqueue_script( 'eafw-ajax', plugin_dir_url( __FILE__ ) . 'js/eafw-ajax.js', array( 'jquery' ), '', true );
		
	

		wp_localize_script( 'eafw-ajax', 'eafw_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );		
		
		echo $args['before_widget'];
		// widget title
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		?>

		
          <section id="b-sign-in">
          <form id="evnt-attnd-form" class="eaform" autocomplete="off">
            <div class="eaform-inner">
              <ol class="questions">
             <!--    <li class="current">
                 
                  <span>
                  	<label for="q1">Sign In With Your Email Or Phone</label>
                  </span>
                  
                  <div id="q1_container" >
                    <button class="b-btn" id="q1_email" type="button" name="q1_btn1" onclick="signInAs()"> Email </button>
                    <button class="b-btn"  id="q1_phone" type="button" name="q1_btn1" onclick="signInAs()"> Phone </button>
                    <input  name="q1" type="email" id="q1"  />
                  </div>
            
                </li> 
                <li>
                 
                  <span>
                  	<label for="q2">Have You Attended A BOEN Event Before?</label>
                  </span>
                  
                  <div id="q2_container" >
                    <input class="b-radio" id="q2_yes" type="radio" name="q2_btn1" value="yes"> Yes
                    <input class="b-radio"  id="q2_no" type="radio" name="q2_btn1" value="no" > No
                   
                  </div>
            
                </li>   -->
                <li class="current">
                 
                  <span>
                  	<label for="q3">Please Provide Your Information Below</label>
                  </span>
                  
                  <div id="q3_container" >
                  	<div >
                     <label> First Name:</label>
                     <input class="b-info"  id="q3_a" type="text" name="q3_input1" placeholder="John" required> 
                     
</div>
<div>

                     <label> Last Name:</label>
                     <input class="b-info"  id="q3_b" type="text" name="q3_input2" placeholder="Doe" required> 
</div>
<div>
                     <label> Invited By:</label>
                     <input class="b-info"  id="q3_c" type="text" name="q3_input3" placeholder="John Q. Public" required> 
                   </div>
                   <div> 

                     <label> Check 3 Committee Interest:</label>
                    <div>
                     <input class="b-info"   type="checkbox" name="q3_cb_1" value="Tech" /> <span>Tech</span>
                 </div>
                 <div>
                    <input class="b-info"  type="checkbox" name="q4_cb_2" value="Education" /> <span>Education</span>
                    </div>
                    <div><input class="b-info"   type="checkbox" name="q4_cb_3" value="Political" /> <span>Political</span>
                    </div>

</div>
<div>
                    <label> Check If Interested In Newsletter:</label>
                    
                    <input class="b-info"   type="checkbox" name="q5" value="" ><span>Yes, I am interested in recieving the newsletter.</span> 
                  </div>
                  </div>
            
                </li>  
              </ol>
              <div class="controls">
                <button class="prev show"></button>
                <button class="next show"></button>
                <div class="progress"></div>
                <span class="number">
                  <span class="number-current">1</span>
                  <span class="number-total">6</span>
                </span>
                <span class="error-message"></span>
              </div><!-- / controls -->
            </div><!-- /eaform-inner -->
            <span class="final-message"></span>
          </form><!-- /eaform -->      
        </section>
       
     
		<!--loading icon-->
		<div id="eawp-loading-icon" class="text-center" style="display: none;">
			<!-- <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> -->

			<div class="svg-container">

<div id="preloader">
  <div id="loader"></div>
</div>

</div>

			<br>
			Saving Your Information. Please Wait.
	
	
		
		</div>
		<!--Ajax result-->
		<div id="ea-form-result" style="display: none;">
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs Form For Admin
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		echo "<p><a href='admin.php?page=cfw-settings'>Configure Widget Settings</a></p>";
		echo "<p><strong>Important Note:</strong></p>";
		echo "<p>Don't use multiple shortcode on same Widget / Sidebar Area.</p>";
		echo "<p>Also, don't activate multiple Contact Form Widget into multiple Widget / Sidebar Area like (Sidebar Widgets / Footer Widgets / Header Widgets)</p>";
	}

	/**
	 * Processing widget options on save
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

// Contact Form Widget Menu Page For Administrator
// For mange all contact queries & contact form widget settings
require_once('cfw-menu-pages.php');
?>