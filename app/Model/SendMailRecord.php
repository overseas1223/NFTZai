<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SendMailRecord extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id','email_type','status'];
}
