<?php

// // Create ea_form Table When Pluign Activate
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
	`phone` varchar(12)  NULL,
	`age_range` varchar(10) NOT NULL,
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




// Drop ea_form Table When This Plugin De-Activated
function ea_form_plugin_uninstall(){
	// delete table when pluign deactivate
	global $wpdb;
	$table_name = $wpdb->prefix . "ea_db";
	$delete_db = "DROP TABLE $table_name";
	$table_name2 = $wpdb->prefix . "ea_attendance";
	$delete_attnd = "DROP TABLE $table_name2";
	$wpdb->query( $delete_db);
	$wpdb->query( $delete_attnd );
	
}


?>