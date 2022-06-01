(function($) {
    "use strict";
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ajax: $('#table-url').data("url"),
        order: [1, 'desc'],
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
            {"data": "email",'name':'users.email'},
            {"data": "amount"},
            {"data": "fees"},
            {"data": "transaction_id"},
            {"data": "status"},
            {"data": "created_at",'name':'deposits.created_at'}
        ]
    });
})(jQuery)
