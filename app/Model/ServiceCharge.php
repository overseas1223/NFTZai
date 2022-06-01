<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    protected $fillable = [
        'service_holder',
        'type',
        'amount',
        'status',
    ];
}
