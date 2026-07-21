<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['tracking_number', 'origin_country', 'destination_country', 'status', 'current_lat', 'current_lng'];

    public function logs()
    {
        return $this->hasMany(ShipmentLog::class)->orderBy('recorded_at', 'desc');
    }
}
