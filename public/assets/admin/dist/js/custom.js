(function($) {
    "use strict";
    $.widget.bridge('uibutton', $.ui.button)
    /* Add here all your JS customizations */
    $('.number-only').keypress(function (e) {
        var regex = /^[+0-9+.\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
    $('.no-regx').keypress(function (e) {
        var regex = /^[a-zA-Z+0-9+\b]+$/;
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
    // $('[data-toggle="switch"]').bootstrapSwitch();
    $(document).on('click', '.delete', function () {
        return confirm("Are You Sure To Delete This!");
    });
    $(document).on('click', '.success-warning', function () {
        return confirm("This person is not highest bid holder! Still you want to handover?");
    });
})(jQuery)
