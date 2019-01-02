<?php
// Prevent direct file access
defined( 'ABSPATH' ) or exit;
/*
Plugin Name: Event Attendance Form Plugin
Plugin URI: https://github.com/davidjr2417/BOEN/tree/switch1
Description: Plugin To Help Track Event Attendance
Version: 0.0.3
Author: David Malone Jr
Author URI:
Text Domain: Event Attendance Form
Domain Path: /languages
*/



//Register Event Attendance Form Plugin For Activiation

// function ea_form_plugin_install() {
// 	//load create table file here
// 	global $wpdb;
// 	$table_name = $wpdb->prefix . "ea_db";
// 	$create_ea_form_query = "CREATE TABLE IF NOT EXISTS '$table_name' (
// 	'id' int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// 	-- `fname` varchar(256) NOT NULL,
// 	-- `lname` varchar(256) NOT NULL,
// 	-- `username` varchar(256) NOT NULL,
// 	-- `email` varchar(256) NOT NULL,
// 	-- `phone` varchar(20)  NULL,
// 	-- `age_range` varchar(20) NOT NULL,
// 	-- `invited_by` varchar(256) NULL,
// 	-- `volunteer` varchar(5)  NULL, 
// 	-- `committee` varchar(50)  NULL,
// 	-- `subscribe` varchar(5)  NULL,
// 	'date_time' datetime NOT NULL
// 	-- `status` varchar(50) NOT NULL
// 	--Always starts at false then goes to true based on effors
// 	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
// 	$wpdb->query($create_ea_form_query);



// }
// Create ea_form Table When Pluign Activate
function ea_form_plugin_install() {
	//load create table file here
	global $wpdb;
	$table_name = $wpdb->prefix . "ea_db";
	$create_ea_form_query = "CREATE TABLE IF NOT EXISTS `$table_name` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`fname` varchar(256) NOT NULL,
	`lname` varchar(256) NOT NULL,
	`username` varchar(256) NOT NULL,
	`email` varchar(256) NOT NULL,
	`phone` varchar(20)  NULL,
	`age_range` varchar(20) NOT NULL,
	`invited_by` varchar(256) NULL,
	`volunteer` varchar(5)  NULL, 
	`committee` varchar(50)  NULL,
	`purpose` longtext  NULL,
	`subscribe` varchar(5)  NULL,
	`date_time` datetime NOT NULL
	-- `status` varchar(50) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
	
	$table_name2 = $wpdb->prefix . "ea_attendance";
	$create_ea_form_query2 =  " CREATE TABLE IF NOT EXISTS `$table_name2` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`attendee` varchar(256) NOT NULL,
	`event` varchar(256) NOT NULL,
	`date_time` datetime NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
	 
	 $wpdb->query($create_ea_form_query);
	$wpdb->query($create_ea_form_query2);
}

register_activation_hook( __FILE__, 'ea_form_plugin_install' );

//Register Event Attendance Form Plugin For Deactiviation
register_deactivation_hook( __FILE__, 'ea_form_plugin_uninstall' );
// Drop ea_form Table When This Plugin De-Activated
function ea_form_plugin_uninstall(){
	//load delete table file here
	// delete table when pluign deactivate
	// global $wpdb;
	// $table_name = $wpdb->prefix . "ea_form";
	// $delete_attnd_form_query = "DROP TABLE $table_name";
	// $wpdb->query($delete_attnd_form_query);
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
add_action( 'wp_ajax_test_query', 'test_query_form_handle' );
add_action( 'wp_ajax_nopriv_test_query', 'test_query_form_handle'  ); // need this to serve non logged in users





add_action( 'wp_ajax_login_query', 'login_query_form_handle' );
add_action( 'wp_ajax_nopriv_login_query', 'login_query_form_handle'  ); // need this to serve non logged in users
function login_query_form_handle(){

	if(isset($_POST['action']) && $_POST['formsdata']) {
		
		$eafw_query_nonce_value = $_POST['security'];
		if(!wp_verify_nonce( $eafw_query_nonce_value, 'eafw_query_nonce' )) {
	
			$action = $_POST['action'];
			//convert sterilise forms data into array
			$eafw_data = array();
			parse_str($_POST['formsdata'], $eafw_data);
		


			if($action == "login_query") {
				
				global $wpdb;

				$event = sanitize_text_field($eafw_data['event']);
				$attendee = sanitize_user($eafw_data['sign-in']);
				

				$eafw_columns_data = array(
					//cxolumn_name => field_value
					'attendee' => $attendee,
					'event' => $event
				);
				echo signUp($eafw_columns_data );
			}
		}
	}
}


function test_query_form_handle(){
	
	if(isset($_POST['action']) && $_POST['formsdata']) {
		$eafw_query_nonce_value = $_POST['security'];
		if(!wp_verify_nonce( $eafw_query_nonce_value, 'eafw_query_nonce' )) {

			$action = $_POST['action'];
			//convert sterilise forms data into array
			$eafw_data = array();
			parse_str($_POST['formsdata'], $eafw_data);
			global $wpdb;
			// $age = $eafw_data['age'].value;
			// echo $age;
			
			// foreach ($eafw_data as $value) {
			// 	echo $value;
			// 	echo $eafw_data[$value];
			// };


			if($action == "test_query") {
				global $wpdb;
				$eafw_table_name = $wpdb->prefix . 'ea_db';

				$event = sanitize_text_field($eafw_data['event']);
				$fname = sanitize_text_field($eafw_data['fname']);
				$lname = sanitize_text_field($eafw_data['lname']);
				$username = sanitize_user($eafw_data['username']);
				$email = sanitize_email($eafw_data['email']);
				$phone = sanitize_text_field($eafw_data['phone']);
				$age = sanitize_text_field($eafw_data['age_range']);
				$invited_by = "N/A";
				$volunteer = "N/A";
				$committee = "N/A";
				$purpose = sanitize_textarea_field($eafw_data['purpose']);
				$subscribe = ($eafw_data['subscribe']) ? 'yes' : 'no' ;
				// table name

				//echo date("Y-m-d h:i:s");
	// 			//data array
				$eafw_columns_data = array(
					//cxolumn_name => field_value
					'id' => NULL,
					'fname' => $fname,
					'lname' => $lname,
					'username' => $username,
					'email' => $email,
					'phone' => $phone,
					'age_range' => $age,
					'invited_by' => $invited_by,
					'volunteer' => $volunteer,
					'committee' => $committee,
					'purpose' => $purpose,
					'subscribe' => $subscribe,
					'date_time' => date("Y-m-d h:i:s"),
					'event' => $event
					// 'status' => 'pending'
				);
				// echo "0";
				// echo $_POST['formsdata']['phone'];
				//  echo "$fname, $lname,\n $username, $email, \n $age,$invited_by,";
				//  echo " $volunteer,$committee";
				//  echo "$purpose $subscribe, $phone";
	// 			//format array
				$eafw_data_format = array('%d', '%s', '%s','%s', '%s','%s','%s', '%s','%s', '%s','%s', '%s',  '%s');

				// load saved message
				$all_setttings = get_option('contact_form_settings');
				if(isset($all_setttings)){
					$qsm = $all_setttings['qsm'];
					$qfm = $all_setttings['qfm'];
				}
				$essence = checkUser($eafw_columns_data );
				$essence2 = signIn($eafw_columns_data);
				echo $essence2;
				// if($wpdb->insert( $eafw_table_name, $eafw_columns_data, $eafw_data_format)) {
				// 	if($qsm == "") {
				//echo "Thank you, you have successfully signed in."; 
				//SignIn
			//}
				//else echo $qsm;
				// } else {
				// 	if($qfm == "") echo "Sorry! contact from not working properly. Please directly contact to site admin using this email: david@brotherhoodofelders.net"; else echo $qfm; //.get_option( 'admin_email' ); 
				// }
			}
	    }// verify query nonce value
	}// end of isset
}


// function getUserInfo(){

// 	//pass is array of possible checks
// 	//query the data base for entire array
// 	//Verify User if contains first and last name or email = start with username
// 	//if fname, lname, username, email, phone match then just sign user in
// 	//if fname, lname and email confirm old user name
// 	//if fname and lastname confirm old user name
// 	//if email exist confirm old user name
// 	//if only username found suggest to create another username
// 	//



// 	if(is equal to something){
// 		if{ fname and lname or email or phone  }{confirm username}
// 		if(username and first and lastname and email  and phone)Or if(username and email){
// 			you have already signed up--> Your are now signed in --> print information --> confirmation email
// 		}
// 		if(username only){try another username}
		

// 	}else{add new user and sign them in 2 confirmations emails}
	



// }
function checkUser($dbVals){
	global $wpdb;
	$eafw_table_name = $wpdb->prefix . 'ea_db';
	$fname = $dbVals ["fname"];
	$lname = $dbVals ["lname"];
	$username = $dbVals ["username"];
	$email = $dbVals ["email"];
	$phone = $dbVals ["phone"];
	
	$checkDB = $wpdb->get_results("SELECT * FROM $eafw_table_name Where email= '$email' OR username ='$username'  OR (fname='$fname' AND lname ='$lname') ", ARRAY_A);// 
	
	if(sizeof($checkDB)>0){
		foreach ($checkDB as $row) {
			//If Everything Is Identical Then 
			if($row['email'] == $email && $row['lname'] == $lname || ($row['username'] == $username && $row['fname'] == $fname) ){
				//You Are A Returning Volunteer, You Have been signed into today's event
				//Confirmation email and offer option to view profile (show information)
				//Make sure user is not already signed in
				
				return 'User Found';
				
			}
			else if($row['username']){
				//Username has been taken by another user
				
				return 'pick another username';//error
			}
			else {
				//Add User To Database
				return 'User Added To Database';
			}

		}
	

		return 'a';
	}
	return 'no';
}


function signUp($dbVals){
	global $wpdb;
	$eafw_table_name = $wpdb->prefix . 'ea_db';
	$username = $dbVals["username"];
	$email = $dbVals["email"];
	$attendee = $dbVals["attendee"];
	
	// if($username && $email){echo  " 1 " . $username . " 2 " . $email ; }
	// 	else if($attendee){	echo "1 ". $attendee . " 2 " . $username . " 3 " . $email ;}

	if($username && $email){
		$checkDB = $wpdb->get_results("SELECT * FROM $eafw_table_name Where email= '$email' OR username ='$username' Limit 1", ARRAY_A);
	
	}else if($attendee){
		$checkDB = $wpdb->get_results("SELECT * FROM $eafw_table_name Where email = '$attendee' OR username = '$attendee' Limit 1", ARRAY_A);
	
	}

	if(sizeof($checkDB)>0){
		$eafw_attendence_table = $wpdb->prefix . 'ea_attendance';
		//Need To Do: LowerCase All Font
		$email =$checkDB[0]["email"];
		$username =$checkDB[0]["username"];
		echo $email . " ". $username; 

		$signIn = $wpdb->get_results("SELECT * FROM $eafw_attendence_table Where attendee= '$email' OR attendee ='$username' AND DATE(date_time)=CURDATE() ", ARRAY_A);// 
	
		if(sizeof($signIn)>0){
		 	return 'You have already signed in today... Thank You...';
		 }
		 else{
		 	$checkDB[0]['username'];
		 	$eafw_columns_data = array(
					'id' => NULL,
					'attendee' => $username,
					'event' => $dbVals["event"],
					'date_time' => date("Y-m-d h:i:s")
				);
				
				$eafw_data_format = array('%d', '%s', '%s','%s');
		 	if($wpdb->insert( $eafw_attendence_table, $eafw_columns_data, $eafw_data_format)) {
		 		return "Thank You For Signing In To Todays BOEN Event";
		 	}else{
				return "There was an error adding your information. Please try again...";

			}
		}	
		}else{
				return "NOUSER";

			}
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
		// wp_enqueue_style( 'eafw-bootstrap-css', plugin_dir_url( __FILE__ ).'css/eafw-bootstrap.min.css' );

		// wp_enqueue_style( 'font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );

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
<style>

  .ea-current select{
		background-color:#2F2828;
		text-align: center;
		text-decoration:underline;
		border-width:2px;
		font-size:14px;
	}
	.ea-current label span{
text-decoration:underline;
	}
	/* .sign-in-as:focus{
		background-color:rgba(89, 191, 111);
	} */
	input[type="radio"].toggle:checked + label {
  background-color: rgba(89, 191, 111);
  box-shadow: inset 0 1px 6px rgba(41, 41, 41, 0.2),
                    0 1px 2px rgba(0, 0, 0, 0.05);
  cursor: default;
  /* color: #E6E6E6; */
  border-color: transparent;
  /* text-shadow: 0 1px 1px rgba(40, 40, 40, 0.75); */
}

input[type="radio"].toggle + label {
  width: 100%;

}

input[type="radio"].toggle:checked + label.btn:hover {
  background-color: inherit;
  background-position: 0 0;
  transition: none;
	background-color: rgba(89, 191, 111);

}

input[type="radio"].toggle-left + label {
  border-right: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="radio"].toggle-right + label {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
.ea-current .btn{
	background-color:transparent;
	border:2px solid rgba(89, 191, 111);
	text-transform: capitalize;

}
.sign-in-as{
	display:none !important;
}
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  font-size: 14px;
}
::-moz-placeholder { /* Firefox 19+ */
  font-size: 14px;
}
:-ms-input-placeholder { /* IE 10+ */
  font-size: 14px;
}
:-moz-placeholder { /* Firefox 18- */
  font-size: 14px;
}

.tooltips {
  position: relative;
  display: inline-block;
}
.tooltips:active .tooltiptext, 
.tooltips:focus .tooltiptext {
	visibility: hidden !important;
}
.tooltips .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: rgba(89, 191, 111);
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    border: 2px solid white;
    position: absolute;
    /* z-index: 1; */
    
    font-size: 1.5vh;  
  bottom: 115%;
  left: 50%; 
  margin-left: -60px; /* Use half of the width (120/2 = 60), to center the tooltip */

    font-size: 1.5vh;
}


.tooltips:hover .tooltiptext {
  visibility: visible;
   transition-delay: 2s;
}
.tooltips .tooltiptext::after {
  content: " ";
  position: absolute;
  top: 100%; /* At the bottom of the tooltip */
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: rgba(89, 191, 111) transparent transparent transparent;
}
</style>

        <section id="b-sign-in">
          <form id="evnt-attnd-form" class="eaform" autocomplete="off">
            <div class="eaform-inner">
              <ol class="questions">
				

			<!--Sign In Options -->
				<li id="user" class="ea-current" >
				
					<div class="row">
						<h5 >
						<div class="col-xs-7">
							<span>
								<label for="q1">Event:	 </label>	
							</span>
							<select class="event-names" style="cursor:pointer; border: 2px solid rgba(89, 191, 111); color:#FFF;     background: transparent;" name="event">
								<option value="Saturday" name="Saturday" checked>
									<label >	Saturday Meeting	 </label>
								</option>
							</select>

						</div>
						<div class="col-xs-4 tooltips" style="float:right">
							<!-- <span class="tooltiptext">Returning</span> -->
							<input class="sign-in-as toggle event-names" id="q2_volunteer" type="radio" name="toggle" value="Returning Volunteer">
							<label title="This is the text of the tooltip" class = "btn"  for="q2_volunteer">Login</label>

						</div>
						</h5>
					</div>
					<div class="row " style=" cursor:pointer;">
						<div class="col-xs-7"></div>
						<div class="col-xs-4 tooltips" style="float:right">
							<input class="sign-in-as toggle " id="q2_guest" type="radio" name="toggle" value="Guest" />
							<label class = "btn" for="q2_guest">First Time</label>
							<!-- <span class="tooltiptext">Sign Up</span> -->
						</div>

					</div>
				</li>



<!-- style="display:none"-->
            	<li id="login"  style="display:none">
					<div class="row">
	                	<span>
	                  		<h5><label for="q3">Please Sign In Below:</label></h5>
	                  	</span>
                  	</div>
                  	<div class="row">
                  		
                  		<!-- <div class="col-xs-12 tooltips" style="float:right" > -->
	                  		<input class="b-info event-names"  id="q3" type="text" name="sign-in" placeholder="Username Or Email" autocomplete="off" >
	                  	<!-- 	<span class="tooltiptext">Sign In With Username Or Email</span>
	                  	</div> -->
              		</div>
              	</li>
              	<li id="signUp" style="display:none" >
	              	<span>
	              		<h5><label for="q3">Please Provide Your Information Below</label></h5>
	              	</span>
					<div id="q3_container">
						<div class="signUp-row">
							<div class="signUp-label" >
								<label>  First Name:</label>
							</div>
							<div class="signUp-input" >
								<input type="text" name="fname" placeholder="John"autocomplete="off" required/>
							</div>
						</div>
						<div class="signUp-row">
							<div class="signUp-label" >
									<label>  Last Name:</label>
								</div>
							<div class="signUp-input" >
								<input type="text" name="lname" placeholder="Doe"autocomplete="off" required/>
							</div>
						</div>
						<div class="signUp-row">
							<div class="signUp-label" >
									<label>  Username:</label>
								</div>
							<div class="signUp-input" >
								<input type="text" name="username" placeholder="johnDoe1234" autocomplete="off" required/>
							</div>
						</div>
						<div class="signUp-row">
							<div class="signUp-label" >
									<label>  Email:</label>
								</div>
							<div class="signUp-input" >
								<input type="email" name="email" placeholder="doe@brotherhoodofelders.net" autocomplete="off" required/>
							</div>
						</div>
						<div class="signUp-row">
							<div class="signUp-label" >
									<label>  Phone:</label>
								</div>
							<div class="signUp-input" >
								<input type="tel" name="phone" placeholder="123-456-7890" autocomplete="off" />
							</div>
						</div>
						<div class="signUp-row">
							<div class="signUp-label" >
									<label>  Age Range:</label>
								</div>
							<div class="signUp-input" >
								<select class="col-sm-3" name="age_range">
									<option name="age" value="warriors" checked> 17 - 30</option>
									<option name="age" value="brothermen"> 30 - 50</option>
									<option name="age" value="elders"> 50+</option>

								</select>
							</div>
						</div>
						<!-- <div class="signUp-row">
							<div class="signUp-label" >
									<label> Invited By:</label>
								</div>
							<div class="signUp-input" >
								 <select class="col-sm-3">
									
									List Of Brothers From Database
								</select> 
							</div>
						</div> -->
						<!-- <div class="signUp-row">
							<div class="signUp-label" >
									<label>Top 2 Interests:</label>
								</div>
							<div class="signUp-input" >
								checkbox button with 2 options
							</div>
						</div> -->
						<div class="row">
							<div class="col-sm-12" >
									<label>  What Brings You Here:</label>
								</div>
							<div class="col-sm-12" >
								<textarea  name="purpose" rows="4"  placeholder="(1-2 Sentences)" autocomplete="off" required ></textarea>
							</div>
						</div>
						<div class="signUp-row">
							
							<div class="signUp-checkbox" >
								<input type="checkbox" name="subscribe" autocomplete="off" />
							</div>
							<div  class="signUp-input">
									<label> Check To Subscribe To Our Newsletter</label>
								</div>
						</div>
					</div>
				</li>

<style> 
.signUp-row{display:flex} 
.signUp-label{flex:1.2;  text-align:right; }
.signUp-checkbox {flex:.2;  text-align:right; }
.signUp-checkbox input {    margin-top: .7vh !important;}
 .signUp-input{flex:5 } 
 .signUp-input input{padding-top: 5px; font-size:.9em }
#q3_container textarea {
   resize: none;
   color:#2F2828;
   width:100%;
}
.ea-current select{
	    margin-left: 5px;
}
</style>


              </ol>
              <div class="controls">
                <button class="prev " type="button"></button>
                <button class="next show"  type="button"></button>
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
