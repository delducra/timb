<?php

date_default_timezone_set("UTC");

function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
	$content = "";
	if ($has_sections) {
		foreach ($assoc_arr as $key=>$elem) {
			$content .= "[".$key."]\n";
			foreach ($elem as $key2=>$elem2) {
				if(is_array($elem2))
				{
					for($i=0;$i<count($elem2);$i++)
					{
						$content .= $key2."[] = \"".$elem2[$i]."\"\n";
					}
				}
				else if($elem2=="") $content .= $key2." = \n";
				else $content .= $key2." = \"".$elem2."\"\n";
			}
		}
	}
	else {
		foreach ($assoc_arr as $key=>$elem) {
			if(is_array($elem))
			{
				for($i=0;$i<count($elem);$i++)
				{
					$content .= $key."[] = \"".$elem[$i]."\"\n";
				}
			}
			else if($elem=="") $content .= $key." = \n";
			else $content .= $key." = \"".$elem."\"\n";
		}
	}

	if (!$handle = fopen($path, 'w')) {
		return false;
	}
	if (!fwrite($handle, $content)) {
		return false;
	}
	fclose($handle);
	return true;
}

function get_config_key( $key = NULL ) {
	global $db_connection;
	
	if ( ! ( isset( $key ) ) ) {
		return( NULL );
	}
	
	if ( ! ( isset( $db_connection ) ) ) {
		get_db_connection();	
	}
	if ( ! ( isset( $db_connection ) ) ) {
		// TODO: Error handling
		return;
	}
	
	$stmt =  $db_connection->stmt_init();
	if ($stmt->prepare( "SELECT value FROM " . $config_bootstrap['database_name'] . ".metadata WHERE variable=?" ) ) {
		$stmt->bind_param( "s", $key );
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();
		$result->free();
		return( $data['value'] );
	}	

}

// First time load of database schema
function init_db_schema() {
	// TODO: 
}

function get_db_connection() {
	global $config_bootstrap;
	global $db_connection;

	$db_connection = mysqli_connect(
		$config_bootstrap['database_host'],$config_bootstrap['database_username'],
		$config_bootstrap['database_password'],$config_bootstrap['database_name'] 
	);
	
}

// General stats of activity. Used primarliy for the landing page
function get_overall_stats() {
	global $db_connection;
	
	if ( ! ( isset( $db_connection ) ) ) {
		get_db_connection();
	}
	if ( ! ( isset( $db_connection ) ) ) {
		// TODO: Error handling
		return;
	}

	$result = $db_connection->query( 'SELECT COUNT(id) AS users FROM users', MYSQLI_USE_RESULT );
	$row = $result->fetch_assoc();
	$stats['users'] = $row['users'];
	$result->free();
	
	$result = $db_connection->query( 'SELECT COUNT(id) AS photos FROM photos', MYSQLI_USE_RESULT );
	$row = $result->fetch_assoc();
	$stats['photos'] = $row['photos'];
	$result->free();
	
	$result = $db_connection->query( 'SELECT COUNT(id) AS bikes FROM user_bikes', MYSQLI_USE_RESULT );
	$row = $result->fetch_assoc();
	$stats['bikes'] = $row['bikes'];
	$result->free();
	
	return( $stats );
	
}

function get_maker_list() {
	global $db_connection;
	$makers = array();
	
	if ( ! ( isset( $db_connection ) ) ) {
		get_db_connection();
	}
	if ( ! ( isset( $db_connection ) ) ) {
		// TODO: Error handling
		return;
	}	
	
	$result = $db_connection->query( 'SELECT name FROM makers ORDER BY name', MYSQLI_USE_RESULT );
	while ( $row = $result->fetch_assoc() ) {
		array_push( $makers, $row['name'] );
	}
	return( $makers );
}

// This is just for debug/dev
function html_var_dump( $var ) {

		echo "<pre>";
		echo var_dump($var);
		echo "</pre>";
}

?>