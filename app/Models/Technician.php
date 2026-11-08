<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technician extends Model
{
    protected $fillable = [
        'code', 'full_name', 'phone', 'whatsapp', 'email',
        'avatar_url', 'skills_category', 'certification_level',
        'is_verified', 'is_online', 'distance_km', 'est_arrival_minutes',
        'rating_average', 'total_ratings_count', 'total_completed_jobs',
        'bio', 'base_fee', 'vehicle', 'police_number',
        'skills_tags', 'portfolio_count',
    ];

    protected $casts = [
        'skills_category' => 'array',
        'skills_tags' => 'array',
        'is_verified' => 'boolean',
        'is_online' => 'boolean',
        'distance_km' => 'float',
        'est_arrival_minutes' => 'integer',
        'rating_average' => 'float',
        'total_ratings_count' => 'integer',
        'total_completed_jobs' => 'integer',
        'base_fee' => 'integer',
        'portfolio_count' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function getFormattedFeeAttribute(): string
    {
        return 'Rp ' . number_format($this->base_fee, 0, ',', '.');
    }

    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', trim($this->full_name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($this->full_name, 0, 2));
    }
}