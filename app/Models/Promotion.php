<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount',   // ← было discount_percent, в миграции колонка называется discount
        'category',
    ];

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'category', 'category');
    }
}