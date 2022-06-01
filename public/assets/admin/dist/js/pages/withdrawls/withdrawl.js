(function($) {
    "use strict";
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ajax: $('#table-url-one').data("url"),
        order: [7, 'desc'],
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "address_type"},
            {"data": "sender"},
            {"data": "address"},
            {"data": "receiver"},
            {"data": "amount"},
            {"data": "fees"},
            {"data": "transaction_hash"},
            {"data": "updated_at"},
            {"data": "actions"}
        ]
    });

    $('#reject-withdrawal').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ajax: $('#table-url-two').data("url"),
        order: [7, 'desc'],
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "address_type"},
            {"data": "sender"},
            {"data": "address"},
            {"data": "receiver"},
            {"data": "amount"},
            {"data": "fees"},
            {"data": "transaction_hash"},
            {"data": "updated_at"},
        ]
    });

    $('#success-withdrawal').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ajax: $('#table-url-three').data("url"),
        order: [7, 'desc'],
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "address_type"},
            {"data": "sender"},
            {"data": "address"},
            {"data": "receiver"},
            {"data": "amount"},
            {"data": "fees"},
            {"data": "transaction_hash"},
            {"data": "updated_at"},
        ]
    });
})(jQuery)
