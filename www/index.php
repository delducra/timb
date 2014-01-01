<?php 

include "./configs.php";
include "./elements.php";
include_once "./core.php";

// Let's see if we've initialized
config_is_present() || init_config_bootstrap();
load_config_bootstrap();

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
		html_var_dump( $_POST );
		if ( $_POST['registration-step'] == 'submission' ) {
			// TODO:
		} else {
			render_html_registration_form();
		}
		render_html_footer();
	}
}


?>