(function($) {
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
            {"data": "email",'name':'email'},
            {"data": "message",'name':'message'},
            {"data": "file",'name':'file'},
        ]
    });
})(jQuery)
