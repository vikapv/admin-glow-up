<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerRequest extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'description',
        'email',
        'status'
    ];
}