<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['user_id', 'tracking_number', 'origin_country', 'destination_country', 'status', 'current_lat', 'current_lng'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(ShipmentLog::class)->orderBy('recorded_at', 'desc');
    }
}
