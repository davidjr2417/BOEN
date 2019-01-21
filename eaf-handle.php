<?php
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

				$event = strtolower(sanitize_text_field($eafw_data['event']));
				$attendee = strtolower(sanitize_user($eafw_data['sign-in']));

				

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


function signUp_query_form_handle(){
	
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


			if($action == "signUp_query") {
				global $wpdb;
				$eafw_table_name = $wpdb->prefix . 'ea_db';

				$event = strtolower(sanitize_text_field($eafw_data['event']));
				$fname = strtolower(sanitize_text_field($eafw_data['fname']));
				$lname = strtolower(sanitize_text_field($eafw_data['lname']));
				$username = strtolower(sanitize_user($eafw_data['username']));
				$email = strtolower(sanitize_email($eafw_data['email']));
				$phone = strtolower(sanitize_text_field($eafw_data['phone']));
				$age = strtolower(sanitize_text_field($eafw_data['age_range']));
				$invited_by = strtolower(sanitize_text_field($eafw_data['invited_by']));
				$volunteer = "N/A";
				$committee = "N/A";
				$purpose = strtolower(sanitize_textarea_field($eafw_data['purpose']));
				$subscribe = ($eafw_data['subscribe']) ? 'yes' : 'no' ;
				// table name
$date = new DateTime( 'now',  new DateTimeZone( 'PDT' ) );

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
					'date_time' => $date->format('Y-m-d H:i:s'),
					'event' => $event
					// 'status' => 'pending'
				);
				// echo "0";
				// echo $_POST['formsdata']['phone'];
				//  echo "$fname, $lname,\n $username, $email, \n $age,$invited_by,";
				//  echo " $volunteer,$committee";
				//  echo "$purpose $subscribe, $phone";
	// 			//format array
				// $eafw_data_format = array('%d', '%s', '%s','%s', '%s','%s','%s', '%s','%s', '%s','%s', '%s',  '%s');

				// load saved message
				// $all_setttings = get_option('contact_form_settings');
				// if(isset($all_setttings)){
				// 	$qsm = $all_setttings['qsm'];
				// 	$qfm = $all_setttings['qfm'];
				// }
				// $essence = checkUser($eafw_columns_data );
				echo signUp($eafw_columns_data);
				
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



function signUp($dbVals){
	global $wpdb;
	$eafw_table_name = $wpdb->prefix . 'ea_db';
	$dbUsername = strtolower($dbVals["username"]);
	$dbEmail = strtolower($dbVals["email"]);
	$dbFname = strtolower($dbVals["fname"]);
	$dbLname = strtolower($dbVals["lname"]);
	$attendee = strtolower($dbVals["attendee"]);
	// $checkDB ='';
	$msg= $checkDB = '';
	$opt = false;
	$vals = $dbVals;
	

	if(!empty($dbUsername) && !empty($dbEmail) ){
		$checkDB = $wpdb->get_results("SELECT * FROM $eafw_table_name Where LOWER(email)= '$dbEmail' OR LOWER(username) ='$dbUsername' Limit 1", ARRAY_A);
		if(!empty($checkDB))
			$vals = $vals+$checkDB[0];
		$opt = true;
	
	}else if(!empty($attendee)){
		$checkDB = $wpdb->get_results("SELECT * FROM $eafw_table_name Where LOWER(email) = '$attendee' OR LOWER(username) = '$attendee' Limit 1", ARRAY_A);
		if(!empty($checkDB))
			$vals = $vals+$checkDB[0];
		$opt = false;
		
	
	}
	

	if(!empty($checkDB)){
		// $msg='a';
		if($opt){
			//$msg = $opt;
			//foreach ($checkDB as $row) {
				// If Everything Is Identical Then 
			// $msg =(($checkDB[0]['fname'])." 1. ".$dbFname)." ".(($checkDB[0]['username'])."2. ".$username);
			if((strtolower($checkDB[0]['lname']) == $dbLname  && strtolower($checkDB[0]['username']) == $dbUsername && strtolower($checkDB[0]['fname']) == $dbFname )|| (strtolower($checkDB[0]['email']) == $dbEmail)  ){
				//You Are A Returning Volunteer, You Have been signed into today's event
				//Confirmation email and offer option to view profile (show information)
				//Make sure user is not already signed in
				
				// $msg ='a';
				$event = array('event' => $dbVals['event']);
				$val = array_merge($checkDB[0],$event);
				$msg = signIn($val);
				
			}
			else if(strtolower($checkDB[0]['username']) ===$dbUsername){
				//Username has been taken by another user
				
				$msg = "FOUNDUSER";//error
			}
			else {
				if(addToDB($vals)=="ADDEDTODB")
					if(signIn($vals)=="SIGNEDIN")
						$msg = "ADDEDTODB";
					else 
						$msg = "ADDINGERROR";
				else
					$msg = "ADDINGERROR";
			}

		
		}else{
				
			//ELSE IF: this is the attendee (sign in)
			// $msg = $opt;
				$event = array('event' => $dbVals['event']);
				$val = array_merge($checkDB[0],$event);
				$msg = signIn($val);

			
		}

	}else{
		if($opt){
			
			if(addToDB($vals)=="ADDEDTODB")
				if(signIn($vals)=="SIGNEDIN")
					$msg = "ADDEDTODB" ;
				else 
					$msg = "ADDINGERROR"."1";
			else
				$msg = "ADDINGERROR"."2";
			// foreach ($val as $key) {
			// 	$msg = $msg . $key;
			// }
			
		}else{

			$msg = "NOUSER";
		}
	}

	return $msg;
}


function addToDB($dbVals){
	global $wpdb;
	$eafw_table_name = $wpdb->prefix . 'ea_db';
	$msg ='';
	$eafw_columns_data = array(
		//cxolumn_name => field_value
		'id' => NULL,
		'fname' => $dbVals['fname'],
		'lname' => $dbVals['lname'],
		'username' => $dbVals['username'],
		'email' => $dbVals['email'],
		'phone' => $dbVals['phone'],
		'age_range' => $dbVals['age_range'],
		'invited_by' => $dbVals['invited_by'],
		'volunteer' => $dbVals['volunteer'],
		'committee' => $dbVals['committee'],
		'purpose' => $dbVals['purpose'],
		'subscribe' => $dbVals['subscribe'],
		'date_time' => $dbVals['date_time']
		// 'status' => 'pending'
	);
		
	 $eafw_data_format = array('%d', '%s', '%s','%s', '%s','%s','%s', '%s','%s', '%s','%s', '%s',  '%s');

	if($wpdb->insert( $eafw_table_name, $eafw_columns_data, $eafw_data_format)) {
		$msg = "ADDEDTODB";
	}else{
		$msg = "ADDINGERROR";
		// $msg =$eafw_columns_data;
	}
// 
	return $msg;
}




function signIn($dbVals){
	global $wpdb;
	$eafw_attendence_table = $wpdb->prefix . 'ea_attendance';
	$email =strtolower($dbVals["email"]);
	$username =strtolower($dbVals["username"]);
	$event =strtolower($dbVals["event"]);
	$attendee =strtolower($dbVals["attendee"]);
	// $msg='';
	$msg='';
	// $signIn ='';
	// $msg = $email." ". $username;


	$signIn = $wpdb->get_results("SELECT * FROM $eafw_attendence_table Where (LOWER(attendee)= '$email' OR LOWER(attendee) ='$username' ) AND DATE(date_time)=CURDATE() ", ARRAY_A);
	
	 
	// $msg=empty($signIn);

	if(!empty($signIn)){
		$msg = "ALREADYIN";	 	
	}
	else{
		$date = new DateTime( 'now',  new DateTimeZone( 'PDT' ) );			
	 	$eafw_columns_data = array(
			'id' => NULL,
			'attendee' => $username,
			'event' => $event,
			'date_time' => $date->format('Y-m-d H:i:s')
		);
						
		$eafw_data_format = array('%d', '%s', '%s','%s');
	 	if($wpdb->insert( $eafw_attendence_table, $eafw_columns_data, $eafw_data_format)){
	 		$msg = "SIGNEDIN";
	 	}else{
			$msg = "ADDINGERROR";
		}
	}
	
	// 	$msg = 'pos';
	// }
	// else
	// 	$msg = 'neg';
	
	return $msg;
}


?>