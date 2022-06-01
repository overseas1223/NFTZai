<?php
namespace App\Http\Services;
/*
	CoinPayments.net API Class - v1.1
	Copyright 2014-2018 CoinPayments.net. All rights reserved.
	License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

use App\Model\CoinPaymentApiLog;
use Illuminate\Support\Facades\Auth;

class CoinPaymentsApiService {
	private $private_key = '';
	private $public_key = '';
	private $ch = null;
	private $ipn_deposit_url = '';
	private $ipn_withdrawal_url = '';
	private $coin_type = '';

    public function __construct($coinType)
    {
        $this->public_key = env('COIN_PAYMENT_PUBLIC_KEY',0);
        $this->private_key = env('COIN_PAYMENT_PRIVET_KEY',0);
        $this->ch = null;
        $this->ipn_deposit_url = env('COIN_PAYMENT_DEPOSIT_CALLBACK_URL','');
        $this->ipn_withdrawal_url = env('COIN_PAYMENT_WITHDRAWAL_CALLBACK_URL','');
        $this->coin_type = $coinType;

    }

    protected function addToLog($request_body=null, $curl_object=null, $response=null){
        $userId = Auth::id();
        if($userId == null){
            $userId = 'queue';
        }
        CoinPaymentApiLog::create([
            'request_body'=>$request_body,
            'curl_object'=>$curl_object,
            'response' => $response,
            'user_id' => $userId
        ]);
    }
	/**
	 * Gets the current CoinPayments.net exchange rate. Output includes both crypto and fiat currencies.
	 * @param short If short == TRUE (the default), the output won't include the currency names and confirms needed to save bandwidth.
	 */
	public function GetRates($short = TRUE) {
		$short = $short ? 1:0;
		return $this->api_call('rates', array('short' => $short));
	}

	/**
	 * Gets your current coin balances (only includes coins with a balance unless all = TRUE).<br />
	 * @param all If all = TRUE then it will return all coins, even those with a 0 balance.
	 */
    public function getbalance($all = TRUE) {
        try{
            $response = $this->api_call('balances', array('all' => 0));
            if(isset($response) && $response['error'] == 'ok'){
                if($all){
                    return $response['result'];
                }
                return $response['result'][$this->coin_type]['balancef'];
            }
        }catch (\Exception $e){
            return -1;
        }
    }

    public function verifyAddress($address){
        return true;
    }
    public function getWithdrawalInfo($transactionId){
        try{
            $response = $this->api_call('get_withdrawal_info', array('id' => $transactionId));
            if(isset($response) && $response['error'] == 'ok'){
                return $response['result']['send_txid'];
            }
        }catch (\Exception $e){
            return -1;
        }
    }

	/**
	 * Creates a basic transaction with minimal parameters.<br />
	 * See CreateTransaction for more advanced features.
	 * @param amount The amount of the transaction (floating point to 8 decimals).
	 * @param currency1 The source currency (ie. USD), this is used to calculate the exchange rate for you.
	 * @param currency2 The cryptocurrency of the transaction. currency1 and currency2 can be the same if you don't want any exchange rate conversion.
	 * @param buyer_email Set the buyer's email so they can automatically claim refunds if there is an issue with their payment.
	 * @param address Optionally set the payout address of the transaction. If address is empty then it will follow your payout settings for that coin.
	 * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
	 */
//	public function CreateTransactionSimple($amount, $currency1, $currency2, $buyer_email, $address='', $ipn_url='') {
//		$req = array(
//			'amount' => $amount,
//			'currency1' => $currency1,
//			'currency2' => $currency2,
//			'buyer_email' => $buyer_email,
//			'address' => $address,
//			'ipn_url' => $ipn_url,
//		);
//		return $this->api_call('create_transaction', $req);
//	}

//	public function CreateTransaction($req) {
//		// See https://www.coinpayments.net/apidoc-create-transaction for parameters
//		return $this->api_call('create_transaction', $req);
//	}

	/**
	 * Creates an address for receiving payments into your CoinPayments Wallet.<br />
	 * @param currency The cryptocurrency to create a receiving address for.
	 * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
	 */
	public function getNewAddress() {
		$req = array(
			'currency' => $this->coin_type,
            'ipn_url' => $this->ipn_deposit_url
        );
//        'ipn_url' => $this->ipn_deposit_url.'?coin_id='.$this->coin_type.'&user_id='.Auth::id()

        try {
            $response = $this->api_call('get_callback_address', $req);
            if (isset($response['error']) && ($response['error'] == 'ok')){
                return $response['result']['address'];
            } else{
                return false;
            }
        }catch (\Exception $e){
            return false;
        }


	}

	/**
	 * Creates a withdrawal from your account to a specified address.<br />
	 * @param amount The amount of the transaction (floating point to 8 decimals).
	 * @param currency The cryptocurrency to withdraw.
	 * @param address The address to send the coins to.
	 * @param auto_confirm If auto_confirm is TRUE, then the withdrawal will be performed without an email confirmation.
	 * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
	 */
	public function sendToAddress($address, $amount, $givenAuthId, $adminId = null) {
        if (empty($givenAuthId)) {
            die;
        }
        if (empty($adminId)) {
            $comment = 'Processed By User. User Id: ' . $givenAuthId;
        } else {
            $comment = 'Approved By Admin. Admin UserID: ' . $adminId;
        }
		$req = array(
			'amount' => $amount,
			'currency' => $this->coin_type,
			'address' => $address,
			'auto_confirm' => 1,
			'ipn_url' => $this->ipn_withdrawal_url,
			'note' => $comment,
		);

        try {
            $response = $this->api_call('create_withdrawal', $req);
            if (isset($response['error']) && ($response['error'] == 'ok')) {
                if ($response['result']['status'] == 1) {
                    return ['success' => true, 'transaction' => $response['result']['id'], 'message' =>'successful'];
                } else {
                    return ['success' => false, 'message' =>'Withdrawal created, waiting for email confirmation.'];
                }
            } else {
                return ['success' => false, 'message' => $response['error']];
            }
        } catch (\Exception $e){
            return ['success' => false, 'message' => $e->getMessage()];
        }

	}

	/**
	 * Creates a transfer from your account to a specified merchant.<br />
	 * @param amount The amount of the transaction (floating point to 8 decimals).
	 * @param currency The cryptocurrency to withdraw.
	 * @param merchant The merchant ID to send the coins to.
	 * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
	 */
//	public function CreateTransfer($amount, $currency, $merchant, $auto_confirm = FALSE) {
//		$req = array(
//			'amount' => $amount,
//			'currency' => $currency,
//			'merchant' => $merchant,
//			'auto_confirm' => $auto_confirm ? 1:0,
//		);
//		return $this->api_call('create_transfer', $req);
//	}

	/**
	 * Creates a transfer from your account to a specified $PayByName tag.<br />
	 * @param amount The amount of the transaction (floating point to 8 decimals).
	 * @param currency The cryptocurrency to withdraw.
	 * @param pbntag The $PayByName tag to send funds to.
	 * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
	 */
//	public function SendToPayByName($amount, $currency, $pbntag, $auto_confirm = FALSE) {
//		$req = array(
//			'amount' => $amount,
//			'currency' => $currency,
//			'pbntag' => $pbntag,
//			'auto_confirm' => $auto_confirm ? 1:0,
//		);
//		return $this->api_call('create_transfer', $req);
//	}

	private function is_setup() {
		return (!empty($this->private_key) && !empty($this->public_key));
	}

	private function api_call($cmd, $req = array()) {
		if (!$this->is_setup()) {
			return array('error' => 'You have not called the Setup function with your private and public keys!');
		}

		// Set the API command and required fields
        $req['version'] = 1;
		$req['cmd'] = $cmd;
		$req['key'] = $this->public_key;
		$req['format'] = 'json'; //supported values are json and xml

		// Generate the query string
		$post_data = http_build_query($req, '', '&');

		// Calculate the HMAC signature on the POST data
		$hmac = hash_hmac('sha512', $post_data, $this->private_key);

		// Create cURL handle and initialize (if needed)
		if ($this->ch === null) {
			$this->ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($this->ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);

		$data = curl_exec($this->ch);
        $this->addToLog($post_data,json_encode(curl_getinfo($this->ch)),$data);
		if ($data !== FALSE) {
			if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
				// We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
				$dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
			} else {
				$dec = json_decode($data, TRUE);
			}
			if ($dec !== NULL && count($dec)) {
				return $dec;
			} else {
				// If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
				return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
			}
		} else {
			return array('error' => 'cURL error: '.curl_error($this->ch));
		}
	}


    function coinpayments_api_call($cmd, $req = array()) {
        // Fill these in from your API Keys page
        $public_key = $this->public_key;
        $private_key = $this->private_key;

        // Set the API command and required fields

       $req['version'] = 1;

        $req['cmd'] = $cmd;
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');


        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Create cURL handle and initialize (if needed)
        static $ch = NULL;
        if ($ch === NULL) {
            $ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        // Parse and return data if successful.
        if ($data !== FALSE) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, TRUE);
            }
            if ($dec !== NULL && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($ch));
        }
    }
};



