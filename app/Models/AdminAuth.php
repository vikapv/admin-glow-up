<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAuth extends Authenticatable
{
    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = ['password'];
}