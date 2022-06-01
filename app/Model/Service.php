<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'expired_at',
        'price_dollar',
        'fees_percentage',
        'fees_fixed',
        'fees_type',
        'like',
        'dislike',
        'available_item',
        'views',
        'category_id',
        'status',
        'comment',
        'buyer_id',
        'thumbnail',
        'video_link',
        'color',
        'origin',
        'mint_address',
        'max_bid_amount',
        'min_bid_amount',
        'created_by',
        'is_unlockable',
        'is_resellable',
        'resell_service_id',
        'pin_date',
        'ipfsHash',
        'pinsize',
        'chain_type',
        'state'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function resell_service()
    {
        return $this->belongsTo(Service::class, 'resell_service_id');
    }

    public function latest_transfer()
    {
        return $this->hasOne(TransferToken::class, 'service_id');
    }

    public function all_transfers()
    {
        return $this->hasMany(TransferToken::class, 'service_id');
    }
}
