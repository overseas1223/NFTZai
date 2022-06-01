<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FaqHead extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'icon'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'fh_id');
    }
}
