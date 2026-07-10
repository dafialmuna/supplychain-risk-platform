<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\OpenMeteoService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(OpenMeteoService $weather)
    {
        $this->weather = $weather;
    }

    public function index(Request $request)
    {
        if ($request->has('code')) {
            $country = Country::where('code', $request->code)->first();
            if (!$country) {
                return response()->json(['error' => 'Country not found'], 404);
            }
            $weather = $this->weather->getCurrentWeather($country->lat, $country->lng);
            return response()->json(['weather' => $weather]);
        }

        if ($request->has('lat') && $request->has('lng')) {
            $weather = $this->weather->getCurrentWeather($request->lat, $request->lng);
            return response()->json(['weather' => $weather]);
        }

        return response()->json(['error' => 'Missing lat/lng or country code'], 400);
    }

    public function all()
    {
        $cacheKey = 'weather_all_countries';
        $weatherData = \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () {
            $countries = Country::all();
            $data = [];
            foreach ($countries as $country) {
                if ($country->lat && $country->lng) {
                    $weather = $this->weather->getCurrentWeather($country->lat, $country->lng);
                    if ($weather) {
                        $data[$country->code] = $weather;
                    }
                }
            }
            return $data;
        });

        return response()->json(['data' => $weatherData]);
    }

    public function forecast(Request $request)
    {
        if (!$request->has('code')) {
            return response()->json(['error' => 'Country code required'], 400);
        }

        $country = Country::where('code', $request->code)->first();
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $days = $request->days ?? 7;
        $forecast = $this->weather->getForecast($country->lat, $country->lng, $days);

        return response()->json([
            'code' => $country->code,
            'country' => $country->name,
            'forecast' => $forecast,
        ]);
    }
}