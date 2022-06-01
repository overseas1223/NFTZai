function startProcess() {
    if ($('#inp_amount').val() > 0) {
        // run metamsk functions here
        EThAppDeploy.loadEtherium();
    } else {
        alert('Please Enter Valid Amount');
    }
}

EThAppDeploy = {
    loadEtherium: async () => {
        if (typeof window.ethereum !== 'undefined') {
            EThAppDeploy.web3Provider = ethereum;
            EThAppDeploy.requestAccount(ethereum);
        } else {
            alert(
                "Not able to locate an Ethereum connection, please install a Metamask wallet"
            );
        }
    },
    /****
     * Request A Account
     * **/
    requestAccount: async (ethereum) => {
        ethereum
            .request({
                method: 'eth_requestAccounts'
            })
            .then((resp) => {
                //do payments with activated account
                EThAppDeploy.payNow(ethereum, resp[0]);
            })
            .catch((err) => {
                // Some unexpected error.
                console.log(err);
            });
    },
    /***
     *
     * Do Payment
     * */
    payNow: async (ethereum, from) => {
        var amount = $('#inp_amount').val();
        ethereum
            .request({
                method: 'eth_sendTransaction',
                params: [{
                    from: from,
                    to: "0x64213950924affd5aA309d478402E8e2363028B7",
                    value: '0x' + ((amount * 1000000000000000000).toString(16)),
                }, ],
            })
            .then((txHash) => {
                if (txHash) {
                    console.log(txHash);
                    //Store Your Transaction Here
                } else {
                    console.log("Something went wrong. Please try again");
                }
            })
            .catch((error) => {
                console.log(error);
            });
    },
}
