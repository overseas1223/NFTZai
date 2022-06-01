<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];            // Must add to use soft delete
    /**
     * @var string[]
     */
    protected $hidden = ['deleted_at'];            // Must add to use soft delete

    /**
     * @var string[]
     */
    protected $fillable = ['receiver_wallet_id','user_id','wallet_id','confirmations','status','address','address_type',
        'amount','fees','transaction_hash','message','btc','doller','in_queue', 'withdraw_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiverWallet(){
        return $this->belongsTo(Wallet::class,'receiver_wallet_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class,'wallet_id');
    }

}
