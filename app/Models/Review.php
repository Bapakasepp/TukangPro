<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'service_order_id', 'customer_name', 'customer_location',
        'customer_avatar', 'rating', 'review_comment', 'verified',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified' => 'boolean',
    ];

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class);
    }
}