<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $exchangeRate;

    public function __construct(ExchangeRateService $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function index(Request $request)
    {
        $base = $request->base ?? 'USD';
        $target = $request->target ?? 'EUR';

        $rate = $this->exchangeRate->getRate($base, $target);

        if (!$rate) {
            return response()->json(['error' => 'Failed to fetch exchange rate'], 500);
        }

        return response()->json($rate);
    }

    public function all(Request $request)
    {
        $base = $request->base ?? 'USD';
        $rates = $this->exchangeRate->getRates($base);

        if (!$rates) {
            return response()->json(['error' => 'Failed to fetch exchange rates'], 500);
        }

        return response()->json($rates);
    }

    public function trend(Request $request)
    {
        $base = $request->base ?? 'USD';
        $target = $request->target ?? 'EUR';
        $days = $request->days ?? 30;

        // Simulasi data trend (karena API gratis tidak menyediakan historis)
        $points = [];
        $now = now();
        $currentRate = $this->exchangeRate->getRate($base, $target);
        $baseRate = $currentRate['rate'] ?? 1.0;

        for ($i = $days; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            // Simulasi fluktuasi +/- 5%
            $variation = 1 + (rand(-50, 50) / 1000);
            $rate = $baseRate * $variation;
            $points[] = [
                'date' => $date->format('Y-m-d'),
                'rate' => round($rate, 4),
            ];
        }

        return response()->json([
            'base' => $base,
            'target' => $target,
            'points' => $points,
        ]);
    }
}