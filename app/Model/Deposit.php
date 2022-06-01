<?php

namespace App\Model;

use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    /**
     * @var string[]
     */
    protected $fillable = ['address', 'fees','sender_wallet_id', 'receiver_wallet_id', 'address_type',
        'type', 'amount', 'doller', 'transaction_id','transaction_hash', 'status', 'confirmations', 'deposit_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senderWallet(){
        return $this->belongsTo(Wallet::class,'sender_wallet_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiverWallet(){
        return $this->belongsTo(Wallet::class,'receiver_wallet_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'deposit_by');
    }

}
