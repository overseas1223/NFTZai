<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinSetting extends Model
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
        'coin_id','api_service', 'user', 'password', 'host', 'port', 'withdrawal_fee_percent', 'withdrawal_fee_fixed', 'withdrawal_fee_method'
    ];
}
