<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentEvent extends Model
{
    //class ShipmentEvent extends Model

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'description',
        'occurred_at',
        'pending'
    ];
}

