(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).load(function () {
        
        /** Add Link */
        $("#btn-addLink").on("click", function (event) {
            var zn_txt_from = $('#zn_txt-from').val();
            var zn_txt_to = $('#zn_txt-to').val();
            var zn_txt_type = $('#zn_txt-type').val();
            if(zn_txt_from !== "" && zn_txt_from !== null) {
                if(zn_txt_to !== "" && zn_txt_to !== null) {
                    $.ajax({
                        url: redirectsettingsAjax.ajax_url,
                        type: 'POST',
                        data: {
                            'action': 'save_redirection_link',
                            'zn_txt_from': zn_txt_from,
                            'zn_txt_to': zn_txt_to,
                            'zn_txt_type': zn_txt_type,
                            'zn_nonce': $(this).data('zn_nonce')
                        },
                        success: function (data) {
                            data = data.replace(/\}\d/, "}");
                            var response = $.parseJSON(data);
                            if(response.confirm){
                                $('#zn_txt-from').val('');
                                $('#zn_txt-to').val('');
                                $('#tbl-redirect #body_links').prepend(response.html);
                                successNotif('Successfully added a new redirection');
                            } else {
                                errorNotif('There is an Error occured while saving the data')
                            }
                        },
                        error: function (errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                } else {
                    warningrNotif('Please Add the required Fields');
                }
            } else {
                warningrNotif('Please Add the required Fields');
            }
        });

        /** Update Link */
        $("#btn-updateLink").on("click", function (event) {
            var zn_edit_id = $('#zn_edit_id').val();
            var zn_txt_from = $('#zn_edit_from').val();
            var zn_txt_to = $('#zn_edit_to').val();
            var zn_txt_type = $('#zn_edit_type').val();
            if(zn_txt_from !== "" && zn_txt_from !== null) {
                if(zn_txt_to !== "" && zn_txt_to !== null) {
                    $.ajax({
                        url: redirectsettingsAjax.ajax_url,
                        type: 'POST',
                        data: {
                            'action': 'update_redirection_link',
                            'zn_edit_id': zn_edit_id,
                            'zn_txt_from': zn_txt_from,
                            'zn_txt_to': zn_txt_to,
                            'zn_txt_type': zn_txt_type,
                            'zn_nonce': $(this).data('zn_nonce')
                        },
                        success: function (data) {
                            // data = data.replace(/\}\d/, "}");
                            // var response = $.parseJSON(data);
                            // if(response.confirm){
                            //     $('#link'+zn_edit_id).empty();
                            //     $('#link'+zn_edit_id).append(response.html);
                            //     successNotif('Successfully updated the redirection');
                            // } else {
                            //     errorNotif('There is an Error occured while saving the data')
                            // }
                            successNotif(data);
                        },
                        error: function (errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                } else {
                    warningrNotif('Please Add the required Fields');
                }
            } else {
                warningrNotif('Please Add the required Fields');
            }
        });
        
        /** Remove Link */
        $("#tbl-redirect").on("click", ".btn-link-remove", function (event) {
            var $button = $(this);
            if (confirm('Are you sure to remove this redirection?')) {
                $.ajax({
                    url: redirectsettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'trash_link',
                        'link_rem_id': $button.data('link_rem_id')
                    },
                    success: function (data) {
                        if (data == 1) {
                            successNotif('Successfully moved to trash');
                            $button.closest('tr').css('background', 'tomato');
                            $button.closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                        } else {
                            errorNotif('There is an Error occured while saving the data')
                        }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });


        // Live Notification in Bubble Popup Sidebar
        // setInterval(liveNotificationGDPR, 5000);
   });

   function liveNotificationGDPR() {
       $.ajax({
           url: settingsAjax.ajax_url,
           type: 'POST',
           data: {
               'action': 'zoneLiveNotifGDPR',
           },
           success: function (data) {
               $('#toplevel_page_zone-gdpr span.awaiting-mod').empty();
               $('#toplevel_page_zone-gdpr span.awaiting-mod').append(data);
           }
       });
   }

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

})(jQuery);
