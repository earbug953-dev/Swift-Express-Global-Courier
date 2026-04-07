<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
    'tracking_number', 'sender_name', 'receiver_name',
    'origin', 'destination', 'status', 'progress',
    'product_image', 'goods_description',
    'current_lat', 'current_lng', 'map_moving',
    'map_tile_url', 'google_link'
];

    public function updates()
    {
        return $this->hasMany(ShipmentUpdate::class);
    }
}
