(function( $ ) {
	'use strict';
	$ = jQuery.noConflict();
	$(window).on('load', function () {
		console.log('Loading Resources...................100%');
		/** Generate DataTable */
		$('#tbl-redirect').DataTable({
			"order": [
				[0, "desc"]
			]
		});
		$('#tbl-history').DataTable({
			"order": [
				[0, "desc"]
			]
		});
	 });

	$('.btn-link-update').on('click', function (event) {
		$.ajax({
			url: redirectsettingsAjax.ajax_url,
			type: 'POST',
			data: {
				'action': 'load_link_info',
				'link_edit_id': $(this).data('link_edit_id'),
				'link_edit_from': $(this).data('link_edit_from'),
				'link_edit_to': $(this).data('link_edit_to'),
				'link_edit_type': $(this).data('link_edit_type'),
				'_ajax_nonce': redirectsettingsAjax.ajax_nonce,
			},
			success: function (data) {
				$('.container-link-info').empty();
				$('.container-link-info').append(data);
			},
			error: function (errorThrown) {
				console.log(errorThrown);
			}
		});
	});
	
	$(document).on('click', '#btn-upload', function (e) {
		e.preventDefault();
		var $button = $(this);
		var file_frame = wp.media.frames.file_frame = wp.media({
		   title: 'Select or upload image',
		   library: {
			  type: 'csv'
		   },
		   button: {
			  text: 'Select'
		   },
		   multiple: false  // Set to true to allow multiple files to be selected
		});
		file_frame.on('select', function () {
		   var attachment = file_frame.state().get('selection').first().toJSON();
		   $('#selected_file').val(attachment.url);
		});
		file_frame.open();
	 });

	/** EXECUTE NOTIFICATIONS */
	function successNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'success',
            styling: 'bootstrap3'
        });
    }

    function warningrNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'warning',
            styling: 'bootstrap3'
        });
    }

    function errorNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'error',
            styling: 'bootstrap3'
        });
    }

})( jQuery );
