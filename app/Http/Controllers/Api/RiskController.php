<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\RiskScore;
use App\Services\WorldBankService;
use App\Services\OpenMeteoService;
use App\Services\ExchangeRateService;
use App\Services\SentimentService;
use App\Services\GNewsService;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    protected $worldBank;
    protected $weather;
    protected $exchangeRate;
    protected $sentiment;
    protected $gnews;

    public function __construct(
        WorldBankService $worldBank,
        OpenMeteoService $weather,
        ExchangeRateService $exchangeRate,
        SentimentService $sentiment,
        GNewsService $gnews
    ) {
        $this->worldBank = $worldBank;
        $this->weather = $weather;
        $this->exchangeRate = $exchangeRate;
        $this->sentiment = $sentiment;
        $this->gnews = $gnews;
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

        // Ambil data ekonomi dari World Bank (Gunakan code3 ISO Alpha-3 agar lebih kompatibel)
        $wbCode = $country->code3 ?? $country->code;
        $gdp = $this->worldBank->getGDP($wbCode) ?? 0;
        $inflation = $this->worldBank->getInflation($wbCode) ?? 0;
        $population = $this->worldBank->getPopulation($wbCode) ?? 0;

        // Ambil cuaca dari Open-Meteo
        $weatherData = null;
        if ($country->lat && $country->lng) {
            $weatherData = $this->weather->getCurrentWeather($country->lat, $country->lng);
        }

        // Ambil kurs dari ExchangeRate
        $currencyRate = null;
        if ($country->currency) {
            $rate = $this->exchangeRate->getRate('USD', $country->currency);
            if ($rate !== null) {
                $currencyRate = [
                    'rate' => $rate,
                    'target' => $country->currency,
                    'date' => now()->format('Y-m-d')
                ];
            }
        }

        // Ambil berita dan analisis sentimen
        $newsItems = $this->gnews->searchNews($country->name . ' logistics', 5);
        $sentimentScores = ['positive' => 0, 'negative' => 0];
        foreach ($newsItems as $item) {
            $text = ($item['title'] ?? '') . ' ' . ($item['description'] ?? '');
            $result = $this->sentiment->analyze($text);
            if ($result['sentiment'] == 'positive') $sentimentScores['positive']++;
            elseif ($result['sentiment'] == 'negative') $sentimentScores['negative']++;
        }

        // Hitung risk components
        $weatherRisk = $this->calculateWeatherRisk($weatherData);
        $inflationRisk = $this->calculateInflationRisk($inflation);
        $currencyRisk = $this->calculateCurrencyRisk($currencyRate);
        $newsRisk = $this->calculateNewsRisk($sentimentScores);

        // Weighted total (30% weather, 20% inflation, 10% currency, 40% news)
        $total = ($weatherRisk * 0.30) + ($inflationRisk * 0.20) + ($currencyRisk * 0.10) + ($newsRisk * 0.40);
        $total = round($total);

        $level = 'low';
        if ($total >= 60) $level = 'critical';
        elseif ($total >= 35) $level = 'high';
        elseif ($total >= 25) $level = 'medium';

        // Simpan ke database (opsional)
        RiskScore::create([
            'country_id' => $country->id,
            'weather_risk' => $weatherRisk,
            'inflation_risk' => $inflationRisk,
            'currency_risk' => $currencyRisk,
            'news_risk' => $newsRisk,
            'total' => $total,
            'level' => $level,
            'calculated_at' => now(),
        ]);

        return response()->json([
            'country' => $country->code,
            'risk' => [
                'total' => $total,
                'level' => $level,
                'weather_risk' => $weatherRisk,
                'inflation_risk' => $inflationRisk,
                'currency_risk' => $currencyRisk,
                'news_risk' => $newsRisk,
            ],
            'weather' => $weatherData,
            'inflation' => $inflation,
            'gdp' => $gdp,
            'population' => $population,
            'exchange_rate' => $currencyRate,
            'sentiment' => $sentimentScores,
        ]);
    }

    private function calculateWeatherRisk($weather)
    {
        if (!$weather) return 30;
        $risk = 30;
        if (isset($weather['wind_speed']) && $weather['wind_speed'] > 40) $risk = 70;
        elseif (isset($weather['weathercode']) && $weather['weathercode'] > 60) $risk = 60;
        return $risk;
    }

    private function calculateInflationRisk($inflation)
    {
        if (!$inflation) return 20;
        if ($inflation > 10) return 80;
        if ($inflation > 5) return 50;
        return 20;
    }

    private function calculateCurrencyRisk($currencyRate)
    {
        if (!$currencyRate || !isset($currencyRate['rate'])) return 10;
        $rate = $currencyRate['rate'];
        if ($rate < 0.1) return 70;
        if ($rate < 0.5) return 40;
        return 15;
    }

    private function calculateNewsRisk($scores)
    {
        $positive = $scores['positive'] ?? 0;
        $negative = $scores['negative'] ?? 0;
        $total = $positive + $negative;
        if ($total === 0) return 40;
        $ratio = $negative / $total;
        if ($ratio > 0.7) return 80;
        if ($ratio > 0.4) return 50;
        return 20;
    }

    public function leaderboard()
{
    $countries = Country::all();
    $result = [];

    foreach ($countries as $country) {
        // Ambil risk score terakhir dari database
        $risk = RiskScore::where('country_id', $country->id)
            ->orderBy('calculated_at', 'desc')
            ->first();

        if ($risk) {
            $result[] = [
                'code' => $country->code,
                'name' => $country->name,
                'flag' => $country->flag,
                'region' => $country->region,
                'currency' => $country->currency,
                'total' => $risk->total,
                'level' => $risk->level,
                'weather_risk' => $risk->weather_risk,
                'inflation_risk' => $risk->inflation_risk,
                'currency_risk' => $risk->currency_risk,
                'news_risk' => $risk->news_risk,
            ];
        }
    }

    // Urutkan dari total tertinggi ke terendah
    usort($result, function ($a, $b) {
        return $b['total'] - $a['total'];
    });

    return response()->json(['countries' => $result]);
}
}