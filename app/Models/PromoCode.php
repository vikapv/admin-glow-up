<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
    'code',
    'discount',
    'limit',
      'used_count',
    'is_active'
];
}
