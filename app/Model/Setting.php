<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['slug', 'value'];
}
