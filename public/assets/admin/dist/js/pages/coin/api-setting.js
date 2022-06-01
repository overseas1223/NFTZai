(function($) {
    "use strict";
    $(document).ready(function () {
        $('.fees-amount').each(function () {
            var val = parseFloat($(this).val());
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toFixed(8));
        })
    });
})(jQuery)
