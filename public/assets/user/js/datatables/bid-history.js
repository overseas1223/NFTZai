(function ($) {
    "use strict";
    $('#serviceList').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        retrieve: true,
        bLengthChange: true,
        responsive: true,
        ajax: $('#table-url').data("url"),
        order: [0, 'desc'],
        autoWidth: false,
        language: {
            searchPlaceholder: "Type here...",
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "id","orderable": false},
            {"data": "title","orderable": false},
            {"data": "description","orderable": false},
            {"data": "price_usd","orderable": false},
            {"data": "highest_bid","orderable": false},
            {"data": "thumbnail","orderable": false},
            {"data": "status","orderable": false},
            {"data": "action","orderable": false},
        ],
    });
})(jQuery)
