<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal2fa extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'wallet_id','coin_id', 'category', 'address', 'amount', 'equivalent_btc', 'fee', 'transaction_hash', 'status', 'in_queue', 'ip', 'device_type',
        'withdrawal_coin_limit_setting_id', 'user_id', 'url_validation_code','url_validation_url', 'verification_code', 'expire_at', 'failed_count'
    ];
}
