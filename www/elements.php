<?php

function render_html_header( array $options = array() ) {
	
	if ( isset( $options['title'] ) ) {
		$title = $options['title'];
	} else {
		$title = THEME_TITLE;
	}

	if ( isset( $options['keywords'] ) ) {
		$keywords = $options['keywords'];
	} else {
		$keywords = THEME_KEYWORDS;
	}
	
	if ( isset( $options['description'] ) ) {
		$description = $options['description'];
	} else {
		$description = THEME_DESCRIPTION;
	}

	if ( isset( $options['css'] ) ) {
		$css = $options['css'];
	} else {
		$css = THEME_CSS;
	}
	
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<HTML>
	<HEAD>
	  <TITLE><?php echo $title ?></TITLE>
	<?php 
		if ( $keywords ) {
			?> <meta name="keywords" content="<?php echo "$keywords" ?>"><?php 
		}
		if ( $description ) {
			?> <meta name="description" content="<?php echo "$description" ?>"><?php
		}
				
}