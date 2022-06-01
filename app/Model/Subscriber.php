<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['email_address', 'status'];
}
