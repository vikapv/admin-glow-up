<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'partner_request_id'
    ];

    public function partner()
{
    return $this->belongsTo(PartnerRequest::class, 'partner_request_id');
}
}