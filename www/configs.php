<?php

include_once "./core.php";

$cwd = getcwd();
$cfg_path = $cwd . DIRECTORY_SEPARATOR . 'config_base.ini';

function config_is_present() {
	global $cfg_path;
	
	return file_exists( $cfg_path ); 
}

function init_config_bootstrap() {
	$header_elements = array(
			'title'			=> 'Initialize Configuration',
			'keywords'		=> '',
			'description'	=> '',
	);
	render_html_header( $header_elements );
	
	if ( isset( $_POST['init_config'] ) ) {
		write_config_bootstrap();
	} else {
		render_config_bootstrap_form();
	}
	render_html_footer();
	exit;
}

function write_config_bootstrap() {
	global $cfg_path;

	// Do we have everything necessary?
	if ( ! (
		$_POST['config_local_path'] &&
		$_POST['config_db_host'] &&
		$_POST['config_db_inst'] &&
		$_POST['config_db_user'] &&
		$_POST['config_db_pas1'] &&
		$_POST['config_db_pas2'] 
	) ) {
		?>
		
		<DIV class='timb-config_err'>
		<P>ERROR: One or more values missing. Please fill out all fields</P>
		</DIV>
		<?php 
		render_config_bootstrap_form( 
			$_POST['config_local_path'], $_POST['config_db_host'], 
			$_POST['config_db_inst'], $_POST['config_db_user'], 
			$_POST['config_db_pas1'], $_POST['config_db_pas2'] 
		); 
		return;
	}
	
	if ( ! ( $_POST['config_db_pas1'] == $_POST['config_db_pas2'] ) ) {
		?>
		<DIV class='timb-config_err'>
		<P>ERROR: Given passwords do not match</P>
		</DIV>
		<?php
		render_config_bootstrap_form(
				$_POST['config_local_path'], $_POST['config_db_host'],
				$_POST['config_db_inst'], $_POST['config_db_user'],
				'', ''
		);
		return;
	}

	$cfg_write['config_path'] 		= $_POST['config_local_path'];
	$cfg_write['database_host']		= $_POST['config_db_host'];
	$cfg_write['database_username']	= $_POST['config_db_user'];
	$cfg_write['database_password']	= $_POST['config_db_pas1'];
	$cfg_write['database_name']		= $_POST['config_db_inst'];
	
	if ( write_ini_file( $cfg_write, $cfg_path ) ) {
		?>
		<p>Configuration written to <?php echo "$cfg_path"; ?>. <a href="./index.php">Click here</a> to continue</p>
		<?php 
		render_html_footer();
	} else {
		?>
		<DIV class='timb-config_err'>
		<P>ERROR: Unable to save config to <?php echo "$cfg_path"?>. Contact your administrator / hosting service to verify file permissions and path.</P>
		</DIV>
		<?php
		render_config_bootstrap_form(
				$_POST['config_local_path'], $_POST['config_db_host'],
				$_POST['config_db_inst'], $_POST['config_db_user'],
				'', ''
		);
		return;
	}
	
	get_config_key('db-initialized') || init_db_schema();
	
}

function load_config_bootstrap() {
	global $config_bootstrap;
	global $cfg_path;

	$config_bootstrap = parse_ini_file( $cfg_path );
}
?>