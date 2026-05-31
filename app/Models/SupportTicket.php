<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'email',
        'subject',
        'message',
        'attachment',
        'status',
        'admin_reply',
    ];
}