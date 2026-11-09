<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerRegistration extends Model
{
    protected $fillable = [
        'registration_code', 'full_name', 'phone',
        'category', 'city', 'has_bnsp', 'status',
    ];

    protected $casts = [
        'has_bnsp' => 'boolean',
    ];
}