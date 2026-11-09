<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BroadcastLog extends Model
{
    protected $fillable = [
        'sender_name', 'message', 'target_count', 'priority',
    ];

    protected $casts = [
        'target_count' => 'integer',
    ];
}