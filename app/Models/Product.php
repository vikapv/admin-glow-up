<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'brand',
        'category',
        'price',
        'discount',
        'image'
    ];

     public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
}
