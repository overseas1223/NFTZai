<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSocialMedia extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'facebook',
        'twitter',
        'instagram'
    ];
}
