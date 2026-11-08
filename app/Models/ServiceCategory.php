<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    protected $fillable = [
        'slug', 'category_name', 'title', 'description',
        'base_price', 'estimated_duration_minutes', 'icon',
        'image_url', 'active_tech_count', 'tag_color',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'estimated_duration_minutes' => 'integer',
        'active_tech_count' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->base_price, 0, ',', '.');
    }
}