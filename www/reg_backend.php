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

	// Required fields
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
	if ( ! preg_match( "/^.+@.+\..+$/", $_POST['owner_email'] ) ) {
		$validate_error++;
		$error_details .= '<LI>Email address invalid</LI>';
		$_POST['owner_email'] = '';
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
		$return_string='<DIV class="timb-reg-validation-error"><IMG src="./elements/notice_button.png" width=15 height=15 style="vertical-align: text-bottom" /><h2>Please correct the following form errors</h2>';
		$return_string .= '<UL class="timb-reg-validation-result">';
		$return_string .= $error_details;
		$return_string .= '</DIV>';
		$return_string .= '</UL>';
		$result_set['success'] = 0;
		$result_set['error_string'] = $return_string;
		$result_set['form_data'] = $_POST;
	}
	
	echo json_encode( $result_set );
	exit();
}



?>