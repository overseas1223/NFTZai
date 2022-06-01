(function($) {
    "use strict";
    let type = '';
    let like = '';
    let color = '';
    let min = 0;
    let max = 10000;
    let origin = [];
    let category = [];
    let name = [];
    $('#service-type').on('change', function() {
        type = $('#service-type').val();
        searchCall()
    })
    $('#like').on('change', function() {
        like = $('#like').val();
        searchCall()
    })
    $('#color').on('change', function() {
        color = $('#color').val();
        searchCall()
    })
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: 0,
        max: 10000,
        values: [0, 10000],
        step: 10,

        slide: function (event, ui) {
            if (ui.values[0] == ui.values[1]) {
                return false;
            }
            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
            min = $("#min_price").val();
            max = $("#max_price").val();
            searchCall()
        },
    });
    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));
    $('.origin').on('click', function() {
        $('.origin').each(function () {
            if ($(this).is(":checked")) {
                name = $(this).val();
                if(origin.includes(name)) {
                    return;
                } else {
                    origin.push(name);
                }
            }
            else {
                name = $(this).val();
                origin = origin.filter(item => item !== name)
            }
        });
        searchCall()
    });
    $('.category').on('click', function() {
        $('.category').each(function () {
            if ($(this).is(":checked")) {
                name = $(this).val();
                if(category.includes(name)) {
                    return;
                } else {
                    category.push(name);
                }
            }
            else {
                name = $(this).val();
                category = category.filter(item => item !== name)
            }
        });
        searchCall()
    });
    $('#reset-filter').on('click', function() {
        window.location.reload(true);
    });
    function searchCall()
    {
        $.ajax({
            url: $('#filter-url').data("url"),
            type: 'get',
            datatype: 'html',
            data: {
                type: type,
                like: like,
                color: color,
                min: min,
                max: max,
                origin: origin,
                category: category,
            },
            beforeSend: function() {
                $('#load-more-sale').text('Loading...');
            }
        })
            .done(function(data) {
                if(data.length == 0) {
                    $('#all-service').text('No Data Found!');
                    return;
                } else {
                    $('#all-service').html(data);
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                searchCall()
            });
    }

})(jQuery)
