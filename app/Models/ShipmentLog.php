<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentLog extends Model
{
    protected $fillable = ['shipment_id', 'location_name', 'status_message', 'lat', 'lng', 'recorded_at'];
    protected $casts = ['recorded_at' => 'datetime'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
