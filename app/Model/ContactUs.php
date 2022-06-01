<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'email',
        'message',
        'file'
    ];
}
