(function ($) {
    "use strict";
    $('.nav-link').on('click',function () {
        var query = $(this).data('id');
        window.history.pushState('page2', 'Title', $('#table-url').data("url")+'?tab='+query);
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        var str = '#'+$(this).data('controls');
        $('.tab-pane').removeClass('show active');
        $(str).addClass('show active');
    });
    $("#file").on('change', function () {
        this.form.submit();
    });
    $(function () {
        $(document.body).on('submit','.Upload', function(e){
            e.preventDefault();
            $('.error_msg').addClass('d-none');
            $('.succ_msg').addClass('d-none');
            var form = $(this);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: form.attr('action'),
                data: new FormData($(this)[0]),
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == true){
                        $('.succ_msg').removeClass('d-none');
                        $('.succ_msg').html(data.message);
                    } else {

                        $('.error_msg').removeClass('d-none');
                        $('.error_msg').html(data.message);
                    }
                }
            });
            return false;
        });
    });
})(jQuery)
