(function ($) {
    'use strict';
    $ = jQuery.noConflict();
    $(window).on('load', function () {
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
                            '_ajax_nonce': redirectsettingsAjax.ajax_nonce
                        },
                        success: function (data) {
                            if(data.confirm){
                                $('#zn_txt-from').val('');
                                $('#zn_txt-to').val('');
                                $('#tbl-redirect #body_links .dataTables_empty').empty();
                                $('#tbl-redirect #body_links').prepend(data.html);
                                successNotif('Successfully added a new redirection');
                            } else if (data.confirm == 2) {
                                warningrNotif('Please add valid URL.');
                            } else {
                                errorNotif('Please add valid URL.');
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
                            '_ajax_nonce': redirectsettingsAjax.ajax_nonce,
                        },
                        success: function (data) {
                            if(data.confirm){
                                self.parent.tb_remove();
                                $('#link-'+zn_edit_id).empty();
                                $('#link-'+zn_edit_id).append(data.html);
                                successNotif('Successfully updated the redirection');
                            } else if (data.confirm == 2) {
                                warningrNotif('Please add valid URL.');
                            } else {
                                errorNotif('Please add valid URL.');
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
        
        /** Remove Link */
        $("#tbl-redirect").on("click", ".btn-link-remove", function (event) {
            var $button = $(this);
            if (confirm('Are you sure to remove this redirection?')) {
                $.ajax({
                    url: redirectsettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'trash_link',
                        'link_rem_id': $button.data('link_rem_id'),
                        '_ajax_nonce': redirectsettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        if (data == 1) {
                            successNotif('Successfully moved to trash');
                            $button.closest('tr').css('background', 'tomato');
                            $button.closest('tr').fadeOut(800, function () {
                                $(this).remove();
                            });
                        } else {
                            errorNotif('There is an Error occured while saving the data');
                        }
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });

        /** Update Availability */
        $("#tbl-redirect").on("change", ".zn_link_stat" ,function (event) {
            $.ajax({
                url: redirectsettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'change_link_status',
                    'zn_link_stat_id': $(this).data('zn_link_stat_id'),
                    '_ajax_nonce': redirectsettingsAjax.ajax_nonce
                },
                success: function (data) {
                    if (data == 1) {
                        successNotif('The redirection link is ON.');
                    } else {
                        successNotif('The redirection link is OFF.');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });

        /** Import Data */
        $('#btn-import').on("click", function (event) {
            var $button = $(this);
            var fileData = $('#selected_file').val();
            var startRow = $('#zn_start_row').val();
            var updateRow = '';
            if($('input[name="zn_update_data"]').prop("checked") == true){
                updateRow = 1;
            }
            else {
                updateRow = 0;
            }
            if(fileData !== "" && fileData !== null) {
                $.ajax({
                    url: redirectsettingsAjax.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'importing_spreadsheet',
                        'zn_import_file': fileData,
                        'zn_start_row': startRow,
                        'zn_update_data': updateRow,
                        '_ajax_nonce': redirectsettingsAjax.ajax_nonce
                    },
                    success: function (data) {
                        successNotif(data);
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                errorNotif('Please add a file before importing.');
            }
        });

        $("#btn-extract").on("click", function (event) {
            var $button = $(this);
            $.ajax({
                url: redirectsettingsAjax.ajax_url,
                type: 'POST',
                data: {
                    'action': 'exporting_spreadsheet',
                    '_ajax_nonce': redirectsettingsAjax.ajax_nonce,
                },
                success: function (data) {
                    let csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(data);
                    var csvHtml = '<a href="'+csvData+'" download="Zone_Redirect_Links.csv" style="text-align:center;"><h2>Download Here</h2></a>';
                    downloadNotif(csvHtml);
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
   });

    function downloadNotif(label) {
        new PNotify({
            title: '' + label + '',
            type: 'success',
            styling: 'bootstrap3',
            hide: false,
            modules: {
                Buttons: {
                  closer: false,
                  sticker: false
                }
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
