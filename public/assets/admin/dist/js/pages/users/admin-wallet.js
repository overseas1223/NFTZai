(function ($) {
    "use strict";
    $('#table').DataTable({
        processing: true,
        pageLength: 10,
        ajax: $('#table-url').data("url"),
        order:[0,'asc'],
        responsive: false,
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "email",name: 'users.email'},
            {"data": "coin_type",'name':'coins.coin_type'},
            {"data": "full_name",'name':'coins.full_name'},
            {"data": "address",'name':'wallets.address'},
            {"data": "balance",'name':'wallets.balance'},
            {"data": "created_at",'name':'users.created_at'}
        ]
    });
})(jQuery)
