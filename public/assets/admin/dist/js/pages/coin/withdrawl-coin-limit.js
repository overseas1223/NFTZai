(function($) {
    "use strict";
    $(document).ready(function () {
        $('.delete-limit').click(function () {
            if (confirm("Do you want to delete this?")) {
                window.location.replace('delete-withdrawal-limit/' + $(this).data('setting-id'));
            }
        });
    });
})(jQuery)
