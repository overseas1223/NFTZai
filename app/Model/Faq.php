<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['question', 'answer', 'status', 'author', 'fh_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faq_head()
    {
        return $this->belongsTo(FaqHead::class, 'fh_id');
    }
}
