<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'status', 'priority', 'comment'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
