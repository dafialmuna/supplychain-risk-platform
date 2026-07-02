<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'weather_risk',
        'inflation_risk',
        'currency_risk',
        'news_risk',
        'total',
        'level',
        'calculated_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}