(function($) {
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
            {"data": "coin_icon"},
            {"data": "coin_type"},
            {"data": "full_name"},
            {"data": "minimum_buy_amount"},
            {"data": "deposit_status"},
            {"data": "withdrawal_status"},
            {"data": "earnings"},
            {"data": "active_status"},
            {"data": "created_at"},
            {"data": "action",orderable: false, searchable: false}
        ]
    });
})(jQuery)
