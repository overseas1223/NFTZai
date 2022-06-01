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
            ajax: $('#table-url').data("url")+'?type='+type,
            order: [3, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "first_name","orderable": false},
                {"data": "email","orderable": false},
                {"data": "type","orderable": false},
                {"data": "status","orderable": false},
                {"data": "created_at","orderable": false},
                {"data": "activity","orderable": false}
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
