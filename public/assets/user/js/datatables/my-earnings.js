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
            {"data": "artwork","orderable": false},
            {"data": "thumb","orderable": false},
            {"data": "buyer","orderable": false},
            {"data": "earning","orderable": false},
        ],
    });
    $('#bidserviceList').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        retrieve: true,
        bLengthChange: true,
        responsive: true,
        ajax: $('#table-urlbid').data("urlbid"),
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
            {"data": "artwork","orderable": false},
            {"data": "thumb","orderable": false},
            {"data": "buyer","orderable": false},
            {"data": "earning","orderable": false},
        ],
    });
})(jQuery)
