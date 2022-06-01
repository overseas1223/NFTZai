<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TopSeller extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'amount', 'activate_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
