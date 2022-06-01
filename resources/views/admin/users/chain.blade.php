@extends('admin.master',['menu'=>'chain'])
@section('title', isset($title) ? $title : '')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/dist/js/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/dist/js/modal.css')}}">
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{__('Chain List')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('OnChain Management')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Chain List')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">{{__("User Chain List")}}</h3>
                            </div>
                            <div style="text-align: right">
                                <button id="myBtn" class="btn btn-info" id="s">Master Wallet Setting</button>
                            </div>
                        </div>
                        <div id="myModal" class="modal" style="z-index: 10000;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="close">&times;</span>
                                    <h2>&nbsp;</h2>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="text-align:center" class="yet-create"><p style="font-size:23px;color:red;font-weight:bold">You have not master wallet. Create Master wallet</p></div>
                                            <div class="form-group yet-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="walletAddress" name="ethwalletAddress" placeholder="{{__('exam : Master Wallet')}}">
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="ethwalletAddress" name="ethwalletAddress" disabled>
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Balance')}}</label>
                                                <input type="text" class="form-control" id="ethbalance" name="ethbalance" disabled>
                                            </div>
                                            <div class="already-create">
                                                <div>
                                                    <p style="font-weight:bold; font-size: 22px;padding:15px;text-align: center">Master Wallet Transaction History</p>
                                                </div>
                                                <div style="max-height: 400px;overflow-y: scroll">
                                                    <table class="table table-striped table-dark">
                                                        <thead>
                                                        <tr class="tran">
                                                            <th scope="col">Previous Balance</th>
                                                            <th scope="col">Current Balance</th>
                                                            <th scope="col">Transaction History</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="ethtransactions">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div style="text-align:center" class="yet-create"><p style="font-size:23px;color:red;font-weight:bold">You have not master wallet. Create Master wallet</p></div>
                                            <div class="form-group yet-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="somasterWallet" name="masterWallet" placeholder="{{__('exam : Master Wallet')}}">
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="solwalletAddress" name="solwalletAddress" disabled>
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Balance')}}</label>
                                                <input type="text" class="form-control" id="solbalance" name="solbalance" disabled>
                                            </div>
                                            <div class="already-create">
                                                <div>
                                                    <p style="font-weight:bold; font-size: 22px;padding:15px;text-align: center">Master Wallet Transaction History</p>
                                                </div>
                                                <div style="max-height: 400px;overflow-y: scroll">
                                                    <table class="table table-striped table-dark">
                                                        <thead>
                                                        <tr class="tran">
                                                            <th scope="col">Previous Balance</th>
                                                            <th scope="col">Current Balance</th>
                                                            <th scope="col">Transaction History</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="soltransactions">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div style="text-align:center" class="yet-create"><p style="font-size:23px;color:red;font-weight:bold">You have not master wallet. Create Master wallet</p></div>
                                            <div class="form-group yet-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="bnmasterWallet" name="masterWallet" placeholder="{{__('exam : Master Wallet')}}">
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Address Or Name')}}</label>
                                                <input type="text" class="form-control" id="bnbwalletAddress" name="bnbwalletAddress" disabled>
                                            </div>
                                            <div class="form-group already-create">
                                                <label for="item-name">{{__('Master Wallet Balance')}}</label>
                                                <input type="text" class="form-control" id="bnbbalance" name="bnbbalance" disabled>
                                            </div>
                                            <div class="already-create">
                                                <div>
                                                    <p style="font-weight:bold; font-size: 22px;padding:15px;text-align: center">Master Wallet Transaction History</p>
                                                </div>
                                                <div style="max-height: 400px;overflow-y: scroll">
                                                    <table class="table table-striped table-dark">
                                                        <thead>
                                                        <tr class="tran">
                                                            <th scope="col">Previous Balance</th>
                                                            <th scope="col">Current Balance</th>
                                                            <th scope="col">Transaction History</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="bnbtransactions">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary yet-create" onclick="createWallet()" id="createWallet">Create Master Wallet</button>
                                    <h3>&nbsp;</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-area">

                                <div class="table-responsive">

                                    {{-- <table id="table" class="table table-bordered table-striped"> --}}
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="desktop">{{__('Username')}}</th>
                                            <th class="all">{{__('Title')}}</th>
                                            <th class="desktop">{{__('Price Fee')}}</th>
                                            <th class="desktop">{{__('Coin Type')}}</th>
                                            <th class="desktop">{{__('Nft Path')}}</th>
                                            <th class="desktop">{{__('Mint Address')}}</th>
                                            <th class="all">{{__('Update Date')}}</th>
                                            <th class="all">{{__('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="table-url" data-url="{{route('admin_chain_list')}}"></div>
@endsection
@section('script')
    <script src="{{asset('assets/admin/dist/js/pages/users/admin-chain.js')}}"></script>
{{--    <script src="{{asset('assets/user/js/web3.min.js')}}"></script>--}}
    <script src="{{asset('assets/admin/dist/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/admin/dist/js/web3.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="https://unpkg.com/moralis@0.0.44/dist/moralis.js"></script>
    <script type="text/javascript">
        // Default Configuration
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
    </script>
    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
            getwallet();
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        var rinkeby = 'https://rinkeby.infura.io/v3/';
        var rinkeby_contract_address = '0xAf182D98841643642dD95C72025f96b888d30Ad3';
        var rinkeby_abi = JSON.parse('[{"inputs":[{"internalType":"address","name":"_marketAddress","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"createToken","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"marketAddress","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"}]');
        var rinkeby_web3 = new Web3(new Web3.providers.HttpProvider(rinkeby));
        var rinkeby_contract = new rinkeby_web3.eth.Contract(rinkeby_abi, rinkeby_contract_address);

        var bsc = 'https://data-seed-prebsc-1-s1.binance.org:8545';
        var bsc_contract_address = '0x42a126765b2ebDEA830cf8f0Ae4C25fe56baBF45';
        var bsc_abi = JSON.parse('[{"inputs":[{"internalType":"address","name":"_marketAddress","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"approved","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"operator","type":"address"},{"indexed":false,"internalType":"bool","name":"approved","type":"bool"}],"name":"ApprovalForAll","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":true,"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"approve","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"createToken","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"getApproved","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"operator","type":"address"}],"name":"isApprovedForAll","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"marketAddress","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"ownerOf","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"bytes","name":"_data","type":"bytes"}],"name":"safeTransferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"operator","type":"address"},{"internalType":"bool","name":"approved","type":"bool"}],"name":"setApprovalForAll","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"_tokenId","type":"uint256"},{"internalType":"string","name":"_tokenURI","type":"string"}],"name":"setTokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bytes4","name":"interfaceId","type":"bytes4"}],"name":"supportsInterface","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"tokenURI","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"_owner","type":"address"}],"name":"tokensOfOwner","outputs":[{"internalType":"uint256[]","name":"tokens_","type":"uint256[]"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"tokenId","type":"uint256"}],"name":"transferFrom","outputs":[],"stateMutability":"nonpayable","type":"function"}]');
        var web3 = new Web3(new Web3.providers.HttpProvider(bsc));
        var bsc_contract = new web3.eth.Contract(bsc_abi, bsc_contract_address);
        var account = '';
        checkUser();
        connect();
        function sendContract(info) {
            createNFT(info.split(",")[0], account, info.split(",")[4])
            // deploySuccess(info.split(",")[2], info.split(",")[3])
        }
        function deploySuccess(title, pinsize) {
            $.ajax({
                url: 'mint-cancel',
                type: 'get',
                data: 'title='+ title + '&date=' + pinsize + '&state=complete',
                success: function(response){
                    if (response.status == true)
                        toastr.success('Success NFT deploy!');
                        window.location.reload();
                }
            });
        }

        function connect() {
            console.log('Calling connect()')
            ethereum.request({method: 'eth_requestAccounts'}).then()
                .catch((err) => {
                    if (err.code === 4001) {
                        // EIP-1193 userRejectedRequest error
                        // If this happens, the user rejected the connection request.
                        console.log('Please connect to MetaMask.');
                    } else {
                        console.error(err);
                    }
                });
        }

        async function payEther(car_price) {
            let isTransaction = false;
            let MERCHANT_ACCOUNT = account
            let eth_wei = ethUnit.toWei(0.0012, 'ether');
            // console.log('ETH AMOUNT ='+eth_wei)
            // console.log('ETH IN HEX ='+eth_wei.toString(16))
            let invoice_id_hex = '494e562d3030';

            const transactionParameters = {
                nonce: '0x00', // ignored by MetaMask
                gasPrice: '0x09184e72a000', // customizable by user during MetaMask confirmation.
                gas: '0x22710', // customizable by user during MetaMask confirmation.
                to: MERCHANT_ACCOUNT, // Required except during contract publications.
                from: account, // must match user's active address.
                value: eth_wei.toString(16),
                data: invoice_id_hex, // You must use a random Invoice ID. it is for Demo Purpose Only
                chainId: '0x3', // Used to prevent transaction reuse across blockchains. Auto-filled by MetaMask.
            };
            // console.log(transactionParameters)

            if (currentAccount != null) {
                let txHash = null;
                try {
                    txHash = await ethereum.request({
                        method: 'eth_sendTransaction',
                        params: [transactionParameters],
                    });
                    console.log(txHash)
                } catch (error) {
                    console.log(error.code)
                    console.log(error)
                }
                if (txHash != null) {
                    addTransaction(txHash, {'invoice_id': invoice_id_hex})
                    isTransaction = true;
                }
            }

            return isTransaction
        }

        async function createNFT(uri, account, chain_type) {
            let contract_type;
            try {
                switch (chain_type) {
                    case 'Ethereum' : {
                        web3.eth.setProvider(Web3.givenProvider)
                        contract_type = bsc_contract;
                        break
                    }
                    case 'Solana' : {
                        rinkeby_web3.eth.setProvider(Web3.givenProvider)
                        contract_type = rinkeby_contract;
                        break
                    }
                }
                await contract_type.methods.createToken(uri).send({from: account}).then(receipt => {
                    console.log('success....', receipt);
                }).catch(error => {
                    console.log('err....', error);
                    alert('Please check your metamask');
                })
                // console.log(tx_hash)
                // tx_hash = await bsc_contract.methods.createToken(uri).send({from: "0x649018c055682f70fF74F61519288BCC96B89312"})
                // // .then(function (result) {
                //     console.log(result);
                //     let tx = result.transactionHash;
                //     return tx;
                // });
                // console.log('Hash Outside:-' + tx_hash)
                // let receipt = await bsc_contract.eth.getTransactionReceipt(tx_hash).then(
                //     function (result) {
                //         return result
                //     }
                // );
                // let topics = receipt['logs'][0]['topics'];
                // let tokenIdHex = topics[3].toString(10);
                // token_id = parseInt(tokenIdHex, 16)
            } catch (error) {
                console.log("Exception in createNFT")
                alert('Please check your metamask');
                console.log(error)
            }
            finally {
                web3 = null;
            }
            // return {'tx_hash': tx_hash, 'token_id': token_id};
        }
        function cancel(item) {
            $.ajax({
                url: 'mint-cancel',
                type: 'get',
                data: 'title='+item.split(",")[0] + '&date=' + item.split(",")[1] + '&state=cancel',
                success: function(response){
                    if (response.status == true)
                        toastr.error('Cancel This NFT deploy!');
                        window.location.reload();
                }
            });
        }
        function getwallet() {
            $.ajax({
                url: 'getwallet',
                type: 'get',
                success: function(response){
                    if (response.status == true){
                        $('.yet-create').css('display', 'none');
                        $('#ethbalance').val(response.ethbalance);
                        $('#ethwalletAddress').val(response.ethaddress);
                        $('#ethtransactions').empty();
                        $('#ethtransactions').append(get_table(response.ETHtransactions))
                        $('#solbalance').val(response.solbalance);
                        $('#solwalletAddress').val(response.soladdress);
                        $('#soltransactions').empty();
                        $('#soltransactions').append(get_table(response.SOLtransations));

                        $('#bnbbalance').val(response.bnbbalance);
                        $('#bnbwalletAddress').val(response.bnbaddress);
                        $('#bnbtransactions').empty();
                        $('#bnbtransactions').append(get_table(response.BNBtransations));
                    }else {
                        $('.already-create').css('display', 'none');
                    }

                }
        })
        }
        function get_table(data) {
            console.log(data);
            let result = [];
            data.forEach(function(rowData) {
                result.push(`<tr class="tran"><td>${rowData.previous_balance}</td><td>${rowData.current_balance}</td><td>${rowData.created_at.replace('T', ' ').replace('Z', ' ').substr(0, 19)}</td></tr>`);
            });
            return result.join('\n');
        }
        function checkUser (info) {
            EthAppDeploy = {
                loadEthereum: async () => {
                    if(typeof window.ethereum !== 'undefined') {
                        EthAppDeploy.web3Provider = ethereum;
                        EthAppDeploy.requestAccount(ethereum);
                    }
                    else {
                        alert("Not able to connect ethereum network");
                    }
                },
                requestAccount: async (ethereum) => {
                    await ethereum.request({
                        method: 'eth_requestAccounts'
                    }).then((res)=>{
                        console.log("res: ", res);
                        account = res[0];
                    }).catch((err)=>{
                        console.log(err);
                    })
                }
            }
            EthAppDeploy.loadEthereum();
        }
    </script>

@endsection

