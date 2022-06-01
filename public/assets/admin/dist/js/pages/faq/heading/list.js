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
            {"data": "title",name: 'title'},
            {"data": "icon",'name':'icon'},
            {"data": "action",'name':'action'}
        ]
    });
})(jQuery)
