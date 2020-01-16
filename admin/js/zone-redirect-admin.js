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
		updateLinkInfo();
	 });

	 function updateLinkInfo() {
		$('.btn-link-update').on('click', function (event) {
			$.ajax({
				url: redirectsettingsAjax.ajax_url,
				type: 'POST',
				data: {
					'action': 'load_link_info',
					'link_edit_id': $(this).data('link_edit_id'),
					'link_edit_from': $(this).data('link_edit_from'),
					'link_edit_to': $(this).data('link_edit_to'),
					'link_edit_type': $(this).data('link_edit_type')
				},
				success: function (data) {
					$('.container-link-info').empty();
					$('.container-link-info').append(data);
					//  alert(data);
				},
				error: function (errorThrown) {
					console.log(errorThrown);
				}
			});
		});
	}
})( jQuery );
