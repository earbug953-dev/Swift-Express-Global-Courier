<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentUpdate extends Model
{
    protected $fillable = ['shipment_id', 'location', 'description', 'status', 'occurred_at', 'pending'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
