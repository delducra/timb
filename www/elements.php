<?php

$_DEF_JQUERY_URI	= './elements/jquery-2.0.3.min.js';
$_DEF_CSS_URI		= './elements/style.css';

function render_html_header( array $options = array() ) {

	global $_DEF_JQUERY_URI;
	global $_DEF_CSS_URI;
	
	if ( isset( $options['title'] ) ) {
		$title = $options['title'];
	} else {
		$title = get_config_key( 'theme-title' );
	}

	if ( isset( $options['keywords'] ) ) {
		$keywords = $options['keywords'];
	} else {
		$keywords = get_config_key( 'theme-keywords' );
	}
	
	if ( isset( $options['jquery'] ) ) {
		$jquery_uri = $options['jquery'];
	} else {
		$jquery_uri = $_DEF_JQUERY_URI;
	}
	
	if ( isset( $options['css'] ) ) {
		$css_url = $options['css'];
	} else {
		$css_url = $_DEF_CSS_URL;
	}
	
	if ( isset( $options['description'] ) ) {
		$description = $options['description'];
	} else {
		$description = get_config_key( 'theme-description' );
	}

	if ( isset( $options['css'] ) ) {
		$css = $options['css'];
	} else {
		$css = get_config_key( 'theme-css' );;
	}
	
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<HTML>
	<HEAD>
	  <TITLE><?php echo $title ?></TITLE>
	<?php 
		if ( $keywords ) {
			?> <meta name="keywords" content="<?php echo "$keywords"; ?>"><?php 
		}
		if ( $description ) {
			?> <meta name="description" content="<?php echo "$description"; ?>"><?php
		} ?>
		<SCRIPT src="<?php echo "$jquery_uri"; ?>" type="text/javascript"></SCRIPT>
		<LINK rel="stylesheet" type="text/css" href="<?php echo "$_DEF_CSS_URI"; ?>" media="screen" />
	<BODY>
		<?php 
				
}

function render_html_footer( array $options = array() ) {
	echo "</body></html>";
}

function render_html_photo_slider() {
	// TODO: 
	?>
	<DIV class='timb_bike_slider'>
		<!-- TODO: -->
	</DIV>
	<?php 
}

function render_html_action_bar() {
	?>
	<DIV class='timb-action-bar'>
		<TABLE class="timb-action-bar"><TR>
			<TD class="timb-action-bar_cell">
				<FORM name="view" method="post" action="index.php">
					<INPUT type="HIDDEN" name="action" value="view-my-bikes" />
					<INPUT type="submit" class="timb-action-button timb-action-button-left" value="View my bikes" />
				</FORM>
			</TD><TD class="timb-action-bar_cell">
				<FORM name="view-all" method="post" action="index.php">
					<INPUT type="HIDDEN" name="action" value="view-all-bikes" />
					<INPUT type="submit" class="timb-action-button timb-action-button_center" value="View all bikes" />
				</FORM>
			</TD><TD class="timb-action-bar_cell">
				<FORM name="register" method="post" action="index.php">
					<INPUT type="HIDDEN" name="action" value="register-bike" />
					<INPUT type="submit" class="timb-action-button timb-action-button-left" value="Register a new bike" />
				</FORM>
			</TD>
		</TR></TABLE>
	</DIV>
	<?php 
}

function render_html_stats() {
	$stats = get_overall_stats();
	if ( $stats['users'] == 1 ) {
		$user_description = 'user';
	} else {
		$user_description = 'users';
	}
	if ( $stats['photos'] == 1 ) {
		$photo_description = 'photo';
	} else {
		$photo_description = 'photos';
	}
	if ( $stats['bikes'] == 1 ) {
		$bike_description = 'bike';
	} else {
		$bike_description = 'bikes';
	}

	?>
		<DIV class='timb_stats'>
		<P><?php echo $stats['users'] . " $user_description "?> have posted <?php echo $stats['photos'] . " $photo_description "?>  of <?php echo $stats['bikes'] . " $bike_description "?>
		</DIV>
	<?php 
}

function render_html_titles( $subtitle = TRUE ) {
	?>
	<DIV class='timb-title'><?php echo get_config_key( 'theme-title' ); ?></DIV>
	<?php
	if ( $subtitle ) { 
		?> <DIV class='timb-subtitle'><?php echo get_config_key( 'theme-subtitle' ); ?></DIV><?php 
	}
	
}


function render_config_bootstrap_form(
		$cnf_path = '../config/', $cnf_hostname = 'localhost', $cnf_inst = 'timb',
		$cnf_user = 'timb', $cnf_pas1 = NULL, $cnf_pas2 = NULL ) {
	?>
	<DIV class='timb-config' id='timb_cnf_path'>
	<FORM action="." method="post">
		<INPUT type='hidden' name='init_config' value='1' />
		<TABLE class='timb-form-table'>
			<TR class='timb-tbl-tre'>
				<TD><LABEL class='timb-tbl-label' for='config_local_path'>Local path to config files:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='text' id='config_local_path' name='config_local_path' value='<?php echo "$cnf_path" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tro'>				
				<TD><LABEL class='timb-tbl-label' for='config_db_host'>Database Server Hostname:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='text' id='config_db_host' name='config_db_host' value='<?php echo "$cnf_hostname" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tre'>				
				<TD><LABEL class='timb-tbl-label' for='config_db_inst'>Database Name:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='text' id='config_db_inst' name='config_db_inst' value='<?php echo "$cnf_inst" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tro'>				
				<TD><LABEL class='timb-tbl-label' for='config_db_iuser'>Database Username:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='text' id='config_db_user' name='config_db_user' value='<?php echo "$cnf_user" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tre'>				
				<TD><LABEL class='timb-tbl-label' for='config_db_pas1'>Database Password:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='password' id='config_db_pas1' name='config_db_pas1' value='<?php echo "$cnf_pas1" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tro'>				
				<TD><LABEL class='timb-tbl-label' for='config_db_pas2'>Confirm Database Password:</LABEL></TD>
				<TD><INPUT class='timb-tbl-input' type='password' id='config_db_pas2' name='config_db_pas2' value='<?php echo "$cnf_pas1" ?>'><BR /></TD>
			</TR><TR class='timb-tbl-tre'>
				<TD colspan='2'><INPUT class='timb-config' type='submit' value='Write config'></TD>
			</TR>
		</TABLE>
	</FORM>
	</DIV>
	<?php 
	render_html_footer();
}

function render_html_landing_page() {
	render_html_titles();
	render_html_stats();
	render_html_photo_slider();
	render_html_action_bar();

}

function render_html_registration_form() {
	render_html_titles();
	render_html_action_bar();
	$makers = get_maker_list();
	?>
	<DIV class="timb-help-window" id="timb-help-window">
		<DIV class="timb-help-dialog" id="timb-help-dialog"></DIV>
	</DIV>
	<DIV class="timb-inprogress-blur" id='timb-regvalidate-window'></DIV>
	<DIV class="timb-inprogress" id='timb-regvalidate-dialog'></DIV>
	
	<DIV class="timb-reg-form">
		<SCRIPT src="./elements/registration.js" type="text/javascript"></SCRIPT>
		<SCRIPT src="./elements/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></SCRIPT>
		<LINK href="./elements/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
		<FORM name="registration" method="post" action="." class="timb-reg-form" id="timb-reg-form">
			<INPUT type="hidden" name="registration-step" value="validation">
				<TABLE class="timb-form-table">
					<TR class="timb-tbl-head">
						<TH colspan=2 class="timb-tbl-head">Personal Information</TH>
					</TR>
					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_firstname'>First Name:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=64 id='owner_firstname' name='owner_firstname' value='<?php echo $_POST['owner_firstname']; ?>'><BR /></TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_lastname'>Last Name:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=64 id='owner_lastname' name='owner_lastname' value='<?php echo $_POST['owner_lastname']; ?>'><BR /></TD>
					</TR>

					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_email'>Email Address:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type="email" maxlength=64 id='owner_email' name='owner_email' "value='<?php echo $_POST['owner_email']; ?>'>
							<IMG class="timb-alert-button" id="timb-altemail" width=15 height=15 src="./elements/notice_button.png" onclick="showTimbHelp(event, 'alert_email')" />
						</TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_phonenumber'>Phone Number:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=32 id='owner_phonenumber' name='owner_phonenumber' value='<?php echo $_POST['owner_phonenumber']; ?>'>
							<IMG class="timb-alert-button" id="timb_altphone" width=15 height=15 src="./elements/notice_button.png" onclick="showTimbHelp(event, 'alert_phone')" />
							<IMG class="timb-help-button" id="timb_hlpphone" width=15 height=15 src="./elements/help_button.png" onclick="showTimbHelp(event, 'owner-phonenumber')" />
						</TD>
					</TR>
					
					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_addr1'>Address (line 1):</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=92 id='owner_addr1' name='owner_addr1' value='<?php echo $_POST['owner_addr1']; ?>'>
						<IMG class="timb-alert-button" id="timb_altemail" width=15 height=15 src="./elements/notice_button.png" onclick="showTimbHelp(event, 'alert_email')" />
						<IMG class="timb-help-button" id="timb_hlpaddr" width=15 height=15 src="./elements/help_button.png" onclick="showTimbHelp(event, 'user-addr1')" /><BR />
						</TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_addr2'>Address (line 2):</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=92 id='owner_addr2' name='owner_addr2' value='<?php echo $_POST['owner_addr2']; ?>'><BR /></TD>
					</TR>
					
					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_addr3'>Address (line 3):</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=92 id='owner_addr3' name='owner_addr3' value='<?php echo $_POST['owner_addr3']; ?>'><BR /></TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='owner_addr4'>Address (line 4):</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=92 id='owner_addr4' name='owner_addr4' value='<?php echo $_POST['owner_addr4']; ?>'><BR /></TD>
					</TR>
					
					<TR>
						<TD class="timb-tbl-hspace" colspan=2></TD>
					</TR>
					
					<TR class="timb-tbl-head">
						<TH colspan=2 class="timb-tbl-head">Bicycle Information</TH>
					</TR>

					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_make'>Make:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=64 id='bike_make' name='bike_make' value='<?php echo $_POST['bike_make']; ?>'><BR /></TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_model'>Model:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=64 id='bike_model' name='bike_model' value='<?php echo $_POST['bike_model']; ?>'><BR /></TD>
					</TR>

					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_year'>Year:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=4 id='bike_year' name='bike_year' pattern="[0-9]" value='<?php echo $_POST['bike_year']; ?>'><BR /></TD>
					</TR>				
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_serial'>Serial Number:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=92 id='bike_serial' name='bike_serial' value='<?php echo $_POST['bike_serial']; ?>'>
							<IMG class="timb-help-button" id="timb_hlpserial" width=15 height=15 src="./elements/help_button.png" onclick="showTimbHelp(event, 'bike-serial')" /><BR />
						</TD>
					</TR>
					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_color'>Color:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=32 id='bike_color' name='bike_color' value='<?php echo $_POST['bike_color']; ?>'><BR /></TD>
					</TR>
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_size'>Frame Size:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=15 id='bike_size' name='bike_size' value='<?php echo $_POST['bike_size']; ?>'><BR /></TD>
					</TR>

					<?php // TODO: Format date string. Also make optional fields obvious to user somehow (Font? Color? ) ?>
					<TR class='timb-tbl-tre'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_from'>Purchased from (store):</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=32 id='bike_from' name='bike_from' value='<?php echo $_POST['bike_from']; ?>'>
							<IMG class="timb-help-button" id="timb_hlpstore" width=15 height=15 src="./elements/help_button.png" onclick="showTimbHelp(event, 'bike_from')" /><BR />
						</TD>
					</TR>
					<TR class='timb-tbl-tro'>
						<TD class="timb-reg-label"><LABEL class='timb-tbl-label' for='bike_date'>Purchase date:</LABEL></TD>
						<TD class="timb-reg-input"><INPUT class='timb-tbl-input' type='text' maxlength=15 id='bike_date' name='bike_date' value='<?php echo $_POST['bike_date']; ?>'>
							<IMG class="timb-help-button" id="timb_hlpbuydate" width=15 height=15 src="./elements/help_button.png" onclick="showTimbHelp(event, 'bike_date')" /><BR />
						</TD>
					</TR>
					
					</TABLE>
					<SCRIPT>
						$(function() {
							var set_makers = [
							<?php
								echo "''"; 
								foreach ( get_maker_list() as $builder ) {
									echo ", '$builder'";
								}
							?>
		  					];
		  					$("#bike_make").autocomplete({
								source: set_makers
		  					});	
			  				
						});
					</SCRIPT>
								
				<DIV class="timb-reg-upload">Photos</DIV>
				<DIV class=timb-bike-comp-in>Components</DIV>	
				<DIV class="timb-reg-submit"><DIV class="timb-inter-button" id="timb-submit-reg" onClick="validate_and_submit()">Submit</DIV>			
		</FORM>
		<?php if ( ! get_config_key('suppress-reg-notice') || $_POST['hide-legal-notice'] ) { ?>
		<!-- Legal Interstitial -->
		<DIV class="timb-interstitial-blur" id='timb-legal-cover'></DIV>
		<DIV class="timb-interstitial" id='timb-legal-dialog'>
			<DIV class="timb-legal-notice">
				<p>This service is designed to record a <i>claim of ownership only</i>. Records entered here record this claim, providing for the potential for third-party verification of the claim</p>
				<p>These records are not definitive proof of ownership of the bicycles and equipment in question. However, there are a couple of steps that you can take to help in the unfortunate situation where you need to utilize this information:</p>
				<ul>
				<li>Include a photograph of the serial number</li>
				<li>Include a photograph that has yourself and the bicycle in the same shot</li>
				<li>
				</ul>
			</DIV>
			<DIV class="timb-inter-button" id="timb-hide-button">I understand.</DIV>
		</DIV>
		<?php } ?>
		
	</DIV>
	
	<?php 
}

?>