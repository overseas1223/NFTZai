(function($) {
    "use strict";
    $('.putImage1').on('change', function () {
        let src = this;
        let target = document.getElementById('target1');
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#target1').attr('src', e.target.result);
        }
        reader.readAsDataURL(src.files[0]);
    });
    $('#social_add_facebook').on('click', function() {
        $('#social_twitter').removeClass('d-none');
        $('#social_add_twitter').removeClass('d-none');
        $('#social_add_facebook').addClass('d-none');
    });
    $('#social_add_twitter').on('click', function() {
        $('#social_twitter').removeClass('d-none');
        $('#social_instagram').removeClass('d-none');
        $('#social_add_twitter').addClass('d-none');
        $('#social_add_facebook').addClass('d-none');
    });
})(jQuery)
