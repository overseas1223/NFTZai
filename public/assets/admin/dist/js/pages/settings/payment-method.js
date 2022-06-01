(function ($) {
    "use strict";
    function processForm(active_id) {
        $.ajax({
            type: "POST",
            url: $('#table-url').data("url"),
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'active_id': active_id
            },
            success: function (data) {
                //TODO need to add toaster
            }
        });
    }
})(jQuery)
