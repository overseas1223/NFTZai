(function($) {
    "use strict";
    $(document).ready( function () {
        $('#serviceList').DataTable();
    } );
    $('.deposit-btn').on('click', function() {
        var address = $(this).data("address")
        var coin = $(this).data("coin")
        var wallet_id = $(this).data("wallet_id")
        $('.deposit-header').text('Deposit '+coin)
        if(address === ''){
            $.ajax({
                type: "POST",
                url: $('#deposit-url').data("url"),
                data: {'wallet_id': wallet_id, '_token':$('meta[name="csrf-token"]').attr('content')},
                async: false,
                success: function(response) {
                    if(response.status === true){
                        address = response.data.address
                        coin = response.data.coin_type
                    }else{
                        alert(response.message);
                        return false;
                    }
                }
            });
        }
        // qrcode.clear(); // clear the code.
        $('.noteDanger').text('Important  :  Send Only '+coin+' To This Address ')
        if(address !== ''){
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "address not found",
                width: 128,
                height: 128,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            qrcode.makeCode(address); // make another code.
            $('.depositAddress').text(address);
        } else {
            $('.noteDanger').text('Important  :  Address not found! ')
            $('.send-text').text('')
        }
    });
    $('.withdrawal-btn').on('click', function() {
        var coin = $(this).data("coin");
        var wallet_id = $(this).data("wallet_id")
        $('.withdrawal-header').text(coin+' Withdrawal ')
        $('.wallet_id').val(wallet_id)
        $('.w-notice').text('Note : You Are About To withdrawal '+coin)
    });
})(jQuery)
