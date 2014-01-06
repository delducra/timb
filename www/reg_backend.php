<?php

include_once './core.php';

if ( $_POST['registration-step'] == 'validation' ) {
	reg_validate_data();
	exit();
}

function reg_validate_data() {
	$validate_error = 0;
	
	foreach ( $_POST as $postkey ) {
		trim( $_POST[$postkey] );
	}


	// Let's see if we have an email match first before validating user data
	if ( $_POST['owner_email'] && ( ! preg_match( "/^.+@.+\..+$/", $_POST['owner_email'] ) ) ) {
		$validate_error++;
		$error_details .= '<LI>Email address invalid</LI>';
		$_POST['owner_email'] = '';
	} else {
		$existing_user = get_user_data( $_POST['owner_email'] );
		if ( $existing_user ) {
			$result_set['new_user'] = 0;
			// We blindly assume this data was previously validated
			$_POST['owner_firstname'] = $existing_user['first_name'];
			$_POST['owner_lastname'] = $existing_user['last_name'];
			$_POST['owner_phonenumber'] = $existing_user['phone_number'];
			$_POST['owner_addr1'] = $existing_user['address1'];
			$_POST['owner_addr2'] = $existing_user['address2'];
			$_POST['owner_addr3'] = $existing_user['address3'];
			$_POST['owner_addr1'] = $existing_user['address4'];
		}
	}

	if ( ! $_POST['owner_firstname'] ) {
		$validate_error++;
		$error_details .= '<LI>First Name is required</LI>';
	}
	if ( ! $_POST['owner_lastname'] ) {
		$validate_error++;
		$error_details .= '<LI>Last Name is required</LI>';
	}
	if ( ! $_POST['bike_make'] ) {
		$validate_error++;
		$error_details .= '<LI>Bike Make is required</LI>';
	}
	if ( ! $_POST['bike_model'] ) {
		$validate_error++;
		$error_details .= '<LI>Bike Model is required</LI>';
	}
	if ( ! $_POST['bike_serial'] ) {
		$validate_error++;
		$error_details .= '<LI>Bike Serial Number is required</LI>';
	}
	// If we have a year, and it is either greater than the current year or doesn't match 19xx or 2xxx
	if ( $_POST['bike_year'] && ( ! ( preg_match( "/^19\d\d$/", $_POST['bike_year'] ) || preg_match( "/^2\d\d\d$/", $_POST['bike_year'] ) ) ) ) {
		$validate_error++;
		$error_details .= '<LI>Bike Year invalid</LI>';
		$_POST['bike_year'] = '';
	}
	
	if ( $_POST['bike_year'] && ( $_POST['bike_year'] > date("Y") ) ) {
		$validate_error++;
		$error_details .= '<LI>Bike Year is in the future</LI>';
		$_POST['bike_year'] = '';
	}	
	
	if ( $validate_error ) {
		$return_string ='<DIV class="timb-reg-validation-error"><IMG src="./elements/notice_button.png" width=15 height=15 style="vertical-align: text-bottom" /><h2>Please correct the following form errors</h2>';
		$return_string .= '<UL class="timb-reg-validation-result">';
		$return_string .= $error_details;
		$return_string .= '</DIV>';
		$return_string .= '</UL>';
		$result_set['success'] = 0;
		$result_set['error_string'] .= $return_string;
	} else {
		if ( $new_user ) {
			add_new_user( $_POST ); // Will exit itself on failure
		}
		add_new_bike( $_POST ); // Will exit itself if bike exists or other error
	}
	$result_set['form_data'] = $_POST; // We may have updated it above
	echo json_encode( $result_set );
	exit();
}

function add_new_user( $submit_data ) {
	// $user_data should have already been sanitized in reg_validate_data()
	$user_data['first_name'] 	= $submit_data['owner_firstname'];
	$user_data['last_name'] 	= $submit_data['owner_lastname'];
	$user_data['email']	 		= $submit_data['owner_email'];
	$user_data['phone_number'] 	= $submit_data['owner_phonenumber'];
	$user_data['address1'] 		= $submit_data['owner_addr1'];
	$user_data['address2'] 		= $submit_data['owner_addr2'];
	$user_data['address3'] 		= $submit_data['owner_addr3'];
	$user_data['address4'] 		= $submit_data['owner_addr4'];
	
	$add_result = insert_new_user_data( $user_data );
	if ( $add_result ) {
		return(1);
	}
	
	$result_set['error_string'] ='<DIV class="timb-reg-validation-error"><IMG src="./elements/notice_button.png" width=15 height=15 style="vertical-align: text-bottom" />';
	$result_set['error_string'] .= '<h2>Something went wrong trying to add you as a new user</h2>';
	$result_set['error_string'] .= '<P>Try and submit your registration again. If the problem continues, contact the administrator via the link at the bottom of this page</P>';
	$result_set['success'] = 0;
	echo json_encode( $result_set );
	exit();
	
}

?>