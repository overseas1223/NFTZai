<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'title', 'notification_body', 'status'];
}
