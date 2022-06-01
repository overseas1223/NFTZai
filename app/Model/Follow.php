<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following_user()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
