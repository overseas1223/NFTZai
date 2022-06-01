(function() {
    "use strict";
    $('#slider').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ajax: $('#table-url').data("url"),
        order: [1, 'desc'],
        autoWidth:false,
        columns: [
            {"data": "title"},
            {"data": "description"},
            {"data": "created_at"},
            {"data": "action",orderable: false, searchable: false}
        ]
    });
})(jQuery)
