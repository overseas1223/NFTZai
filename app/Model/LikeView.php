<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LikeView extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'service_id', 'isLike', 'isView'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
