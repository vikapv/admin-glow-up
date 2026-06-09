<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'birthday',
        'gender',
        'bonuses',
        'password',
         'status',
    ];

    protected $hidden = ['password'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function bonusHistory()
    {
        return $this->hasMany(BonusHistory::class);
    }
}
