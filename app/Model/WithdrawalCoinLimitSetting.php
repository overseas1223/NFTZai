<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalCoinLimitSetting extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'from', 'to', 'coin_id','google2fa', 'email2fa', 'admin_approval', 'created_by'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }
}