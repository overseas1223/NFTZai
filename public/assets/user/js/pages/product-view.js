(function($) {
    "use strict";
    $('#like_now').on('click', function() {
        if($('#likeable').val() == 1) {
            $.ajax({
                url: $('#s-like-store').val(),
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    service_id: $('#sid').val()
                }
            })
                .done(function(data) {
                    $('#like_count').html(data);
                    $('#like_now').html('<i class="fas fa-heart"></i>');
                    $('#likeable').val(0);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Something went wrong.');
                });
        }
        else{
            $.ajax({
                url: $('#s-like-remove').val(),
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    service_id: $('#sid').val()
                }
            })
                .done(function(data) {
                    $('#like_count').html(data);
                    $('#like_now').html('<i class="far fa-heart"></i>');
                    $('#likeable').val(1);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('Something went wrong.');
                });
        }
    });

    function getPrice(wid,price,mint_address, chainNet){
        $.ajax({
            url: '/change-price-to-coin?wid='+ wid + '&amount=' + price + '&mint_address=' + mint_address + '&chainNet=' + chainNet,
            type: 'get'
        })
            .done(function(data) {
                var price = data.price +' '+ data.coin;
                var service_fee = data.service_fee_coin +' '+ data.coin;
                var pay = data.final_pay +' '+ data.coin;
                var my_balance = data.my_balance + ' ' + data.coin;
                var gas_percentage_coin = data.gas_percentage_coin + ' ' + data.coin;
                var gas_fee_coin = data.gas_fee_coin + ' ' + data.coin;
                $('#balance').html(price);
                $('#service-fee').html(service_fee);
                $('#pay').html(pay);
                $('#my-balance').html(my_balance);
                $('#coin_type').val(data.coin);
                $('#coin_id').val(data.coin_id);
                $('#conversion_rate').val(data.conversion_rate);
                $('#on_balance').val(data.price);
                $('#service_charge_coin').val(data.service_fee_coin);
                $('#final_pay').val(data.final_pay);
                $('#gas_percentage_coin').html(gas_percentage_coin);
                $('#gas_fee_coin').html(gas_fee_coin);
                $('#before_chain_price').val(data.before_chain_price);
                $('#before_fee_coin').val(data.before_fee_coin);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
            });
    }
    $('#wallet_id').on('change', function() {
        var wid = $('#wallet_id').val();
        var price = $('#price').val();
        if(wid != 0 && price != ''){
            getPrice(wid,price);
        }
    });
    $("#price").on("input", function() {
        var wid = $('#wallet_id').val();
        var price = $('#price').val();
        var mint_address = $('#mint_address').val();
        var chainNet = $('#chainNet').val();
        if(wid != 0 && price != ''){
            getPrice(wid,price,mint_address,chainNet);
        }
    });
    $('#chain_setting').on('change', function () {

        if ($('#chain_setting:checked').val() == 'on') {
            $("#mint_address").prop('disabled', false);
        }
        else {
            $("#mint_address").prop('disabled', true);
        }
    });
    $('#chainNet').on('change', function () {
        $('.eth').css('display', 'table-row');
        var wid = $('#wallet_id').val();
        var price = $('#price').val();
        var mint_address = $('#mint_address').val();
        var chainNet = $('#chainNet').val();
        if(wid != 0 && price != '' && mint_address != '' && chainNet != '') {
            getPrice(wid,price,mint_address,chainNet);
        }
    })
})(jQuery)
