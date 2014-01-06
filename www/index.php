<?php 

include "./elements.php";
include_once "./core.php";

direct_via_post_data();


function direct_via_post_data() {
	if ( ! ( isset( $_POST['action'] ) ) ) {
		render_html_header();
		render_html_landing_page();
		render_html_footer();
		exit();	
	}
	
	if ( $_POST['action'] == 'register-bike' ) {
		$header_elements = array(
			'title'			=> 'Register New Bike',
			'keywords'		=> '',
			'description'	=> '',
		);
		render_html_header( $header_elements );
		render_html_registration_form();
		render_html_footer();
	}
}


?>