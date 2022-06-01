(function($) {
    "use strict";
    let title = null;
    let color = null;
    let origin = null;
    let price_dollar = null;
    let fees_type = null;
    $('#item-name').on('keyup', function(e) {
        title = e.target.value;
        $('#file-saved').text('Writing...');
        document.getElementById('service-title').innerHTML = title;
    });

    $('#price').on('keyup', function(e) {
        price_dollar = e.target.value;
        $('#file-saved').text('Writing...');
        document.getElementById('price-dollar-service').innerHTML = new Intl.NumberFormat().format(price_dollar);
    });

    $('#fees_type').on('change', function(e) {
        fees_type = e.target.value;
        if(fees_type == 1) {
            $('#fees_text').html('(Fixed)');
            $('#fees').prop('disabled', false);
        }
        else if(fees_type == 2) {
            $('#fees_text').html('(Percentage)');
            $('#fees').prop('disabled', false);
        }
        else {
            $('#fees_text').html('');
            $('#fees').prop('disabled', true);
        }
    });

    $('#type1').on('click', function(e) {
        $('#max_bid_d').addClass('d-none');
        $('#min_bid_d').addClass('d-none');
        $('#price-d').removeClass('d-none');
        $('#av-d').removeClass('d-none');
    });

    $('#type2').on('click', function(e) {
        $('#max_bid_d').removeClass('d-none');
        $('#min_bid_d').removeClass('d-none');
        $('#price-d').addClass('d-none');
        $('#price').val(0);
        $('#av-d').addClass('d-none');
        $('#available_item').val(1);
    });

    $('#color').on('change', function (e) {
        color = e.target.value;
        $('#file-saved').text('Writing...');
        document.getElementById('product-color').innerHTML = color;
    });

    $('#origin').on('change', function (e) {
        origin = e.target.value;
        $('#file-saved').text('Writing...');
        document.getElementById('product-origin').innerHTML = origin;
    });

    $('.putImage1').on('change', function () {
        var src = this;
        var target = document.getElementById('target1');
        target.style.width = '449px';
        target.style.height = '517px';
        var reader = new FileReader();

        var target2 = document.getElementById('target2');
        target2.style.width = '623px';
        target2.style.height = '718px';

        reader.onload = function (e) {
            $('#target1').attr('src', e.target.result);
            $('#target2').attr('src', e.target.result);
        }
        reader.readAsDataURL(src.files[0]);
    });
    $('#show-prev').on('click', function () {
        $('#file-saved').text('File Saved !');
    });
    $('#chain_setting').on('change', function () {
        if ($('#chain_setting:checked').val() == 'on') {
            $('#mint_address').val(account);
            // $("#chainNet").prop('disabled', false);
            $("#mint_address").prop('disabled', false);
           
        }
        else {
            $('#mint_address').val('');
            $("#mint_address").prop('disabled', true);
            // $("#chainNet").prop('disabled', true);
        }
    });
    $('#submitdata').click(function () {
        if ($('#mint_address').val() != '') {
            const pinataApiKey = 'b1595d122e177efa6f23';
            const pinataSecretApiKey = "b1136711a25f07948bd6d36da2be31b0669ab70d1864d38fffee32772e6549fe"
            const url = `https://api.pinata.cloud/pinning/pinFileToIPFS`;
            console.log($('#customFile')[0].files[0]);
            let data = new FormData();
            data.append("file", document.querySelector('#customFile').files[0]);
            axios.post(url, data, {
                maxBodyLength: 'Infinity', //this is needed to prevent axios from erroring out with large directories
                headers: {
                    "Content-Type": `multipart/form-data ; boundary= ${data._boundary}`,
                    pinata_api_key: pinataApiKey,
                    pinata_secret_api_key: pinataSecretApiKey
                }
            }).then(response => {
                $('#pin_date').val(response.data.PinSize);
                $('#ipfsHash').val('https://gateway.pinata.cloud/ipfs/' + response.data.IpfsHash);
                $('#pinsize').val(response.data.Timestamp);
                $('#CreateNFT').submit();
            }).catch(error => {
                console.log(error);
            });
        }else {
            $('#CreateNFT').submit();
        }

    })

})(jQuery)
