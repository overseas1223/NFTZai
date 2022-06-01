(function ($) {
    "use strict";
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        retrieve: true,
        bLengthChange: true,
        responsive: true,
        ajax: $('#table-url').data("url"),
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "user","orderable": false},
            {"data": "bid_amount","orderable": false},
            {"data": "coin_amount","orderable": false},
            {"data": "conversion_rate","orderable": false},
            {"data": "action","orderable": false},
        ],
    });
})(jQuery)
