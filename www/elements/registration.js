
// Help & Alert dialogs
$(document).ready(function(){
	$("#timb-help-window").click(function() {
		$("#timb-help-window").hide(500);
	});
	$("#timb-help-dialog").click(function() {
		$("#timb-help-window").hide(500);
	});

	$("#timb-regvalidate-window").click(function() {
		hide_regvalidate();
	});
	$("#timb-regvalidate-dialog").click(function() {
		hide_regvalidate();
	});
	$("#timb-regvalidate-button").click(function() {
		hide_regvalidate();
	});	
	// Legal warning support
	$("#timb-hide-button").click(function() {
		$("#timb-legal-cover").hide();
		$("#timb-legal-dialog").hide(500);
	});
    $( "#bike_date" ).datepicker();

});

function hide_regvalidate() {
	$("#timb-regvalidate-window").hide(0);
	$("#timb-regvalidate-dialog").hide(500);	
}

function showTimbHelp( e, topic ) {
	$("#timb-help-window").offset({left:e.pageX,top:e.pageY});
	if ( topic == 'alert_email' ) {
		$("#timb-help-dialog").html('<p>An email address is REQUIRED to register your bike, but may aid in recovery.</p><p>Your email address will be stored in the database, but will never be publically displayed to other users. It will be used to allow others to send you emails using this system - perhaps someone that has found your bicycle and wishes to return it.</p><p>See the <a href="./index.php?action=privacy_policy">Privacy Policy</a> for additional details</p>');
		$("#timb-help-window").show();
	} else if ( topic == 'alert_phone' ) {
		$("#timb-help-dialog").html('<p>A phone number is NOT required to register your bike, but may aid in recovery.</p><p>Be very careful if you decide to list you phone number as it will become <b>publicaly available</b> to others browsing this registry.</p><p>See the <a href="./index.php?action=privacy_policy">Privacy Policy</a> for additional details</p>');
		$("#timb-help-window").show();
	}
}

function validate_and_submit() {
	var windowH = $(window).height();
	var windowW = $(window).width();

	// Niceties
	$("#timb-regvalidate-dialog").html('<p>Validating...');
	$("#timb-regvalidate-window").css({ height: $(window).height() + 1000 } );

	$("#timb-regvalidate-dialog").css({
	 position:"fixed",
	 left: ((windowW - $("#timb-regvalidate-dialog").outerWidth())/2),
	 top: ((windowH - $("#timb-regvalidate-dialog").outerHeight())/2)
	});
	$("#timb-regvalidate-window").show();
	$("#timb-regvalidate-dialog").show();
	
	// Submit the request
	data = $("#timb-reg-form").serialize();
	$.ajax({
	    type: "POST",
	    url: "./reg_backend.php",
	    data: data,
	    dataType: 'json',
	    async: false,
        cache: false,
        timeout: 1000,
        
	    success: function( returned ){
	    	if ( ! returned.success ) {
	    		
	    		$("#timb-regvalidate-dialog").html( returned.error_string+'<DIV class="timb-inter-button" id="timb-regvalidate-buton">OK</DIV>' );
	    		// Reset values
	    		var fields = [ "owner_firstname", "owner_lastname", "owner_email", "owner_phonenumber", "owner_addr1", "owner_addr2", "owner_addr3", "owner_addr4", "bike_make", "bike_model", "bike_year", "bike_serial", "bike_color", "bike_size", "bike_from", "bike_date", ];
	    		for (var i = 0; i < fields.length; ++i) {
	    			$("#" + fields[i]).val( returned.form_data[fields[i]] );
	    		}
	    		$("#timb-regvalidate-dialog").onclick=function(){ 
	    			$("#timb-regvalidate-window").hide();
	    			$("#timb-regvalidate-dialog").hide();
	    		};
	    	} else if ( ! returned.new_user ) {
	    		$("#timb-regvalidate-dialog").html( 'Found an existing user with email address '+$("#owner_email").value+'<BR />The form has been udpated to match the stored data.<DIV class="timb-inter-button" id="timb-regvalidate-buton">OK</DIV>' );
	    		var fields = [ "owner_firstname", "owner_lastname", "owner_email", "owner_phonenumber", "owner_addr1", "owner_addr2", "owner_addr3", "owner_addr4", "bike_make", "bike_model", "bike_year", "bike_serial", "bike_color", "bike_size", "bike_from", "bike_date", ];
	    		for (var i = 0; i < fields.length; ++i) {
	    			$("#" + fields[i]).val( returned.form_data[fields[i]] );
	    		}

	    	} else {
	    		$("#timb-regvalidate-dialog").html( 'Why are we here?' );
	    	}
	    },
	    error: function(xhr, ajaxOptions, thrownError) {
	    	$("#timb-regvalidate-dialog").html( '<P>Unexpected error in form validation</P><P>'+xhr.status+'</P><P>'+thrownError+'</P><DIV class="timb-inter-button" id="timb-regvalidate-buton">OK</DIV>' );
	    }
	});
}
