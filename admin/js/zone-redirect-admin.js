(function( $ ) {
	'use strict';
	$ = jQuery.noConflict();
	 $( window ).load(function() {
		 console.log('Loading Resources...................100%');
		$('#tbl-redirect').DataTable({
			"order": [
				[0, "desc"]
			]
		});
		
	 });
})( jQuery );
