jQuery(document).ready(function($){

	$( '.mycred-action.notifications' ).click( function(e){
	    var url    = new URL( $(this).attr('href') );
	    var action = url.searchParams.get('addon_action');
	    if ( action == 'activate' ) {
	    	e.preventDefault();
	    	alert( 'myCred Notifications Plus addon is activated.' );
	    }
	});

});