<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'slug', 'description', 'thumbnail', 'views', 'likes', 'isHotNews', 'isTrending'];
}
