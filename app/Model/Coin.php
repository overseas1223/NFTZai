<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string[]
     */
    protected $fillable = ['coin_type', 'full_name', 'coin_icon', 'is_base', 'is_currency',
        'is_primary', 'is_wallet', 'is_buyable', 'deposit_status', 'withdrawal_status',
        'trade_status', 'active_status', 'minimum_buy_amount', 'minimum_sell_amount',
        'minimum_withdrawal', 'maximum_withdrawal',
        'sign', 'is_transferable', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coin_settings(){
        return $this->hasOne(CoinSetting::class,'coin_id','id');
    }
}
