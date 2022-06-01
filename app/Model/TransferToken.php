<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransferToken extends Model
{
    protected $fillable = ['service_id', 'resell_service_id', 'prev_mint_address', 'new_mint_address'];
}
