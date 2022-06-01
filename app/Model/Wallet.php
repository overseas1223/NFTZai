<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'coin_id', 'address',  'balance'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }
}
