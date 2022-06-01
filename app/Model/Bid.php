<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'transaction_id',
        'bid_amount',
        'service_charge',
        'service_id',
        'user_id',
        'is_sale_bid',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bid_holder()
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
}
