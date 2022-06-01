<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalCancelReason extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];            // Must add to use soft delete

    /**
     * @var string[]
     */
    protected $fillable = [
        'withdrawal_id', 'reason'
    ];

}
