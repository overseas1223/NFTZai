<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CoinPaymentApiLog extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id','request_body','curl_object','response'];
}
