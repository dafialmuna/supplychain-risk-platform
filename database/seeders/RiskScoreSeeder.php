<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\RiskScore;
use Carbon\Carbon;

class RiskScoreSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel risk_scores terlebih dahulu agar tidak menumpuk
        RiskScore::truncate();

        $countries = Country::all();
        
        foreach ($countries as $country) {
            // Generate dummy risk scores yang lebih realistis (sebagian besar rendah/aman)
            // Sesekali beri angka tinggi agar ada beberapa yang 'high risk'
            $isHighRiskCountry = (rand(1, 100) > 85); // Hanya ~15% negara yang berisiko tinggi

            if ($isHighRiskCountry) {
                $weatherRisk = rand(50, 90);
                $inflationRisk = rand(60, 100);
                $currencyRisk = rand(40, 80);
                $newsRisk = rand(60, 95);
            } else {
                $weatherRisk = rand(5, 40);
                $inflationRisk = rand(5, 30);
                $currencyRisk = rand(5, 20);
                $newsRisk = rand(10, 45);
            }
            
            // Formula from controller: 30% weather, 20% inflation, 10% currency, 40% news
            $total = ($weatherRisk * 0.30) + ($inflationRisk * 0.20) + ($currencyRisk * 0.10) + ($newsRisk * 0.40);
            $total = round($total);
            
            $level = 'low';
            if ($total >= 60) $level = 'critical';
            elseif ($total >= 35) $level = 'high';
            elseif ($total >= 25) $level = 'medium';
            
            RiskScore::create([
                'country_id' => $country->id,
                'weather_risk' => $weatherRisk,
                'inflation_risk' => $inflationRisk,
                'currency_risk' => $currencyRisk,
                'news_risk' => $newsRisk,
                'total' => $total,
                'level' => $level,
                'calculated_at' => Carbon::now()->subDays(rand(0, 5)),
            ]);
        }
    }
}
