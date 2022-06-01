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
            {"data": "user_name",name: 'user_name'},
            {"data": "title",'name':'services.title'},
            {"data": "nft_fee",'name':'nft_fee'},
            {"data": "coin_type",'name':'coin_type'},
            {"data": "ipfsHash",'name':'services.ipfsHash'},
            {"data": "mint_address",'name':'services.mint_address'},
            {"data": "pinsize",'name':'services.pinsize'},
            {"data": "action",orderable: false, searchable: false}
        ]
    });
})(jQuery)
