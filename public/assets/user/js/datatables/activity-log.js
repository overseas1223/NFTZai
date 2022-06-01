(function($) {
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
            {"data": "amount","orderable": false},
            {"data": "transaction_hash","orderable": false},
            {"data": "is_bid","orderable": false},
            {"data": "time","orderable": false},
            {"data": "status","orderable": false},
        ],
    });
})(jQuery)
