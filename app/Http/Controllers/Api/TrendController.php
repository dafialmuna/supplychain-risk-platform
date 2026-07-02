<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\WorldBankService;
use Illuminate\Http\Request;

class TrendController extends Controller
{
    protected $worldBank;

    public function __construct(WorldBankService $worldBank)
    {
        $this->worldBank = $worldBank;
    }

    public function index(Request $request)
    {
        $code = $request->code;
        if (!$code) {
            return response()->json(['error' => 'Country code required'], 400);
        }

        $country = Country::where('code', $code)->first();
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        // Simulasi data trend (karena World Bank API terbatas)
        $trends = [
            'gdp' => $this->generateTrend('gdp', $country->code),
            'inflation' => $this->generateTrend('inflation', $country->code),
            'population' => $this->generateTrend('population', $country->code),
            'exports' => $this->generateTrend('exports', $country->code),
            'imports' => $this->generateTrend('imports', $country->code),
            'risk' => $this->getRiskTrend($country->id),
        ];

        return response()->json([
            'code' => $country->code,
            'country' => $country->name,
            'trends' => $trends,
        ]);
    }

    private function generateTrend($indicator, $code)
    {
        $currentValue = $this->worldBank->{'get' . ucfirst($indicator)}($code) ?? 100;

        // Generate 5 tahun data dengan variasi
        $points = [];
        $year = date('Y') - 4;
        for ($i = 0; $i < 5; $i++) {
            $variation = 1 + (rand(-15, 20) / 100);
            $value = $currentValue * $variation;
            $points[] = [
                'year' => $year + $i,
                'value' => round($value, 2),
            ];
        }

        return $points;
    }

    private function getRiskTrend($countryId)
    {
        $scores = RiskScore::where('country_id', $countryId)
            ->orderBy('calculated_at', 'asc')
            ->take(10)
            ->get();

        $points = [];
        foreach ($scores as $score) {
            $points[] = [
                'year' => date('Y', strtotime($score->calculated_at)),
                'value' => $score->total,
            ];
        }

        // Jika tidak ada data, buat simulasi
        if (empty($points)) {
            for ($i = 0; $i < 5; $i++) {
                $points[] = [
                    'year' => date('Y') - 4 + $i,
                    'value' => rand(20, 60),
                ];
            }
        }

        return $points;
    }
}