(function($) {
    "use strict";
    function getTable(type) {
        var table =  $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: $('#table-url').data("url") + '?type='+type,
            order: [3, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "title","orderable": false},
                {"data": "description","orderable": false},
                {"data": "mint_address","orderable": false},
                {"data": "owner","orderable": false},
                {"data": "category","orderable": false},
                {"data": "type","orderable": false},
                {"data": "available_item","orderable": false},
                {"data": "price","orderable": false},
                {"data": "bid_amount","orderable": false},
                {"data": "views","orderable": false},
                {"data": "like","orderable": false},
                {"data": "thumbnail","orderable": false},
                {"data": "comment","orderable": false},
                {"data": "slider","orderable": false},
                {"data": "status","orderable": false},
                {"data": "action","orderable": false},
            ],
        });
    }
    $(document.body).on('click','.nav-link',function () {
        var id = $(this).data('id');
        if (id != 'undefined'){
            $('#table').DataTable().destroy();
            getTable(id)
        }
    });
    getTable('active_users');
})(jQuery)
