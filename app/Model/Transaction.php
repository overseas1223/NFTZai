<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'amount',
      'buyer_id',
      'seller_id',
      'transaction_hash',
      'bid_id',
      'fees',
      'transaction_time',
      'status',
      'coin_type',
      'coin_id',
    ];
}
