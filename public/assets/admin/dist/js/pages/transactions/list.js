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
            {"data": "sell_bid",'name': 'sell_bid'},
            {"data": "holder",'name': 'holder'},
            {"data": "amount",'name':'amount'},
            {"data": "earnings",'name':'earnings'},
            {"data": "type",'name':'type'},
            {"data": "time",'name':'time'},
            {"data": "comments",'name':'comments'},
        ]
    });
})(jQuery)
