<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['action','user_id','source','ip_address','location','created_at'];
}
