<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVerificationCode extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = ['user_id','code','status','expired_at'];
}
