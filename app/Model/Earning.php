<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earning extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sell_id',
        'bid_id',
        'user_id',
        'coin_id',
        'user_to_platform',
        'platform_to_user',
        'trans_amount',
        'amount',
        'coin_type',
        'comments',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
