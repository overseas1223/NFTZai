(function ($) {
    "use strict";
    $('#table').DataTable({
        processing: true,
        pageLength: 10,
        ajax: $('#table-url').data("url"),
        order:[0,'asc'],
        autoWidth: false,
        language: {
            paginate: {
                next: 'Next &#8250;',
                previous: '&#8249; Previous'
            }
        },
        columns: [
            {"data": "email_address",name: 'email_address'},
            {"data": "status",'name':'status'},
            {"data": "created_at",'name':'created_at'},
            {"data": "action",'name':'action'}
        ]
    });
})(jQuery)
