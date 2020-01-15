(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).load(function () {
        
        /** Update GDPR Content Page */
        $("#btn-addLink").on("click", function (event) {
            var zn_txt_from = $('#zn_txt-from').val();
            var zn_txt_to = $('#zn_txt-to').val();
            var zn_txt_type = $('#zn_txt-type').val();
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
                    // if (data == 1) {
                    //     successNotif('The New Redirection is Added');
                    // } else {
                    //     errorNotif('There is an Error occured while saving the data')
                    // }
                    successNotif(data);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
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
