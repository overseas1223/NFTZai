<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['body', 'created_by', 'service_id'];
}
