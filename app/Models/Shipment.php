<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'tracking_number',
        'sender_name',
        'sender_email',
        'sender_phone',
        'sender_address',
        'receiver_name',
        'receiver_email',
        'receiver_phone',
        'receiver_address',
        'origin',
        'destination',
        'status',
        'progress',
        'product_image',
        'goods_description',
        'current_lat',
        'current_lng',
        'map_moving',
        'map_tile_url',
        'google_link',
        'estimated_delivery',
        'pickup_date',
        'pickup_time',
        'transit_time',
        'reference',
        'package_type',
        'weight',
        'quantity',
        'service_type',
    ];

    protected $casts = [
        'map_moving' => 'boolean',
        'progress'   => 'integer',
        'pickup_date' => 'datetime',
        'estimated_delivery' => 'datetime',
    ];

    public function updates()
    {
        return $this->hasMany(ShipmentUpdate::class)->orderBy('created_at', 'asc');
    }

    /**
     * Returns the CSS badge class for the current status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'In Transit' => 'sbadge-transit',
            'On Hold'    => 'sbadge-hold',
            'Delivered'  => 'sbadge-delivered',
            default      => 'sbadge-pending',
        };
    }
    public function events()
{
    return $this->hasMany(ShipmentUpdate::class)->orderBy('created_at');
}

    /**
     * Scope: filter by status
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: search by tracking/name
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('tracking_number', 'like', "%{$term}%")
              ->orWhere('sender_name',   'like', "%{$term}%")
              ->orWhere('receiver_name', 'like', "%{$term}%");
        });
    }
}
