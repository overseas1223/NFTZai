(function ($) {
    "use strict";
    $('.nav-link').on('click', function () {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        var str = '#' + $(this).data('controls');
        $('.tab-pane').removeClass('show active');
        $(str).addClass('show active');
    });
})(jQuery)
