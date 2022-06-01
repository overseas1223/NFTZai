(function($) {
    "use strict";
    $('#type').on('change', function () {
        if($(this).val() == 1) {
            $('#price_dollar_d').removeClass('d-none');
            $('#min_bid_price_d').addClass('d-none');
            $('#max_bid_price_d').addClass('d-none');
            $('#f-submit').removeClass('d-none');
        }
        else if($(this).val() == 2) {
            $('#price_dollar_d').addClass('d-none');
            $('#min_bid_price_d').removeClass('d-none');
            $('#max_bid_price_d').removeClass('d-none');
            $('#f-submit').removeClass('d-none');
        }
        else {
            $('#price_dollar_d').addClass('d-none');
            $('#min_bid_price_d').addClass('d-none');
            $('#max_bid_price_d').addClass('d-none');
            $('#f-submit').addClass('d-none');
        }
    });
})(jQuery)
