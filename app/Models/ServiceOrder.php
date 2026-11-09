<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $fillable = [
        'order_code', 'customer_name', 'customer_phone', 'service_address',
        'service_category_id', 'category_name', 'technician_id', 'status',
        'is_emergency', 'scheduled_arrival_at', 'issue_description', 'photos_url',
        'base_fee', 'diagnostic_fee', 'spareparts_fee', 'emergency_fee',
        'total_amount', 'escrow_status', 'eta_minutes', 'speed_kmh',
        'warranty_valid_until', 'ordered_label',
    ];

    protected $casts = [
        'photos_url' => 'array',
        'is_emergency' => 'boolean',
        'base_fee' => 'integer',
        'diagnostic_fee' => 'integer',
        'spareparts_fee' => 'integer',
        'emergency_fee' => 'integer',
        'total_amount' => 'integer',
        'eta_minutes' => 'integer',
        'speed_kmh' => 'integer',
    ];

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'COMPLETED';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'CANCELLED';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['ON_THE_WAY', 'ACTIVE', 'WORKING', 'ASSIGNED'], true);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}