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
		/** Initiate Functions */
		updateLinkInfo();
		showUpload();
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
	}

	/** Init the Upload media module */
	function showUpload(){
		$('#btn-upload').on('click', function (event) {
			var formfield = $('#selected_file').attr('name');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});
	}

	/** Transfer file to input box */
	window.send_to_editor = function (html) { 
		var url = "";
		url = $(html).attr('href');
		$('#selected_file').val(url);
		tb_remove();
		blur_file_upload_field(); 
	}

	/** Filter if the file has csv extenstion */
	function blur_file_upload_field() {
		var file_upload_url = $('#selected_file').val();
		let find = file_upload_url.lastIndexOf(".");
  		var extension = file_upload_url.substr(find);
		if (extension !== '.csv') {
			errorNotif('Invalid Extension');
			$('#selected_file').val('');
			return;
		}
	}

	/** Init Filtering */
	$('#selected_file').blur(function () {
		blur_file_upload_field(); 
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
