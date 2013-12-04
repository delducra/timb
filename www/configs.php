<?php

function config_is_present() {
	$cwd = getcwd();
	$cfg_path = $cwd . DIRECTORY_SEPARATOR . 'config_base.ini';
	return file_exists( $cfg_path ); 
}

function init_config_bootstrap() {
	if ( isset( $_POST['config_path'] ) ) {
		// init config file
	} else {
		$header_elements = array(
			'title'			=> 'Initialize Configuration',
			'keywords'		=> '',
			'description'	=> '',	
		);
		render_html_header( $header_elements );
		
	}
}
?>