<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SellService extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'price_amount',
        'coin_amount',
        'service_charge',
        'service_charge_coin',
        'conversion_rate',
        'service_id',
        'user_id',
        'is_sale_bid',
        'coin_type',
        'coin_id',
        'status',
        'refund_amount',
        'wallet_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
