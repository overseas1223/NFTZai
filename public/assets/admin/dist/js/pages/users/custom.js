$(document).ready(function() {
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': false,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '1000',
        'hideDuration': '1000',
        'timeOut': '5000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }
});
var modal = document.getElementById("myModal");
var btn = document.getElementsByClassName("myBtn");
var span = document.getElementsByClassName("close")[0];
var selectElement = document.querySelector('#chainNet');
var service_id = 0;
var price = 0;
var coin_price = 0;
var wallet_id = 0;
$('#chainNet').on('change', function() {
    $('#paymentInfo').css('display', 'block')
    wallet_id = $('#chainNet').val();
    gettotalinfo(wallet_id,price);
});
btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function DeployNFT() {
    var mint_address = $('#mintAddress').val();
    var chain_type = $('#chainNet').val();
    if (mint_address == '') return
    $.ajax({
            url: '/user/deploynft?service_id='+ service_id + '&mint_address=' + mint_address + '&wid=' + wallet_id + '&coin_price=' + coin_price,
        type: 'get'
    })
        .done(function(data) {
            if(data.status == true && data.message == 'success') {
                toastr.success('Deploy Successful! Please wait!');
                window.location.reload();
            }
            if(data.status == false && data.message == 'priceError') {
                toastr.error('balance is less!')
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
}
function deploy(id, pri, wid) {
    modal.style.display = "block";
    service_id = id;
    price = pri;
    wallet_id = wid;
}
function gettotalinfo(wid,price,mint_address, chainNet){
    $.ajax({
        url: '/change-price-to-coin?wid='+ wid + '&amount=' + price + '&mint_address=' + mint_address + '&chainNet=' + chainNet,
        type: 'get'
    })
        .done(function(data) {
            var price = data.price +' '+ data.coin;
            var service_fee = data.service_fee_coin +' '+ data.coin;
            var pay = data.final_pay +' '+ data.coin;
            coin_price = data.final_pay;
            $('#balance').html(price);
            $('#service-fee').html(service_fee);
            $('#pay').html(pay);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong.');
        });
}
