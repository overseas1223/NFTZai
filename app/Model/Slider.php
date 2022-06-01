<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
      'short_description',
      'long_desc_header',
        'long_desc_middle',
        'long_desc_footer',
    ];
}
