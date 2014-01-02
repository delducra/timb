
// Help & Alert dialogs
$(document).ready(function(){
	$("#timb-help-window").click(function() {
		$("#timb-help-window").hide(500);
	});
	$("#timb-help-dialog").click(function() {
		$("#timb-help-window").hide(500);
	});
	// Legal warning support
	$("#timb-hide-button").click(function() {
		$("#timb-legal-cover").hide();
		$("#timb-legal-dialog").hide(500);
	});

});

function showTimbHelp( e, topic ) {
	$("#timb-help-window").offset({left:e.pageX,top:e.pageY});
	if ( topic == 'alert_email' ) {
		$("#timb-help-dialog").html('<p>An email address is NOT required to register your bike, but may aid in recovery.</p><p>Your email address will be stored in the database, but will never be publically displayed to other users. It will be used to allow others to send you emails using this system - perhaps someone that has found your bicycle and wishes to return it.</p><p>See the <a href="./index.php?action=privacy_policy">Privacy Policy</a> for additional details</p>');
		$("#timb-help-window").show();
	} else if ( topic == 'alert_phone' ) {
		$("#timb-help-dialog").html('<p>A phone number is NOT required to register your bike, but may aid in recovery.</p><p>Be very careful if you decide to list you phone number as it will become <b>publicaly available</b> to others browsing this registry.</p><p>See the <a href="./index.php?action=privacy_policy">Privacy Policy</a> for additional details</p>');
		$("#timb-help-window").show();
	}
}
