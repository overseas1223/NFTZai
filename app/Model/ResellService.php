<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResellService extends Model
{
    protected $fillable = ['new_service_id', 'past_service_id'];

    public function new_service()
    {
        $this->belongsTo(Service::class, 'new_service_id');
    }

    public function past_service()
    {
        $this->belongsTo(Service::class, 'past_service_id');
    }
}
