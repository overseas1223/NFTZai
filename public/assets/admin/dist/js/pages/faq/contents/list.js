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
            {"data": "question",name: 'question'},
            {"data": "answer",'name':'answer'},
            {"data": "heading",'name':'heading'},
            {"data": "action",'name':'action'}
        ]
    });
})(jQuery)
