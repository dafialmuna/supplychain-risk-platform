<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $response = Http::withoutVerifying()->timeout(30)->get('https://raw.githubusercontent.com/restcountries/restcountries/master/src/main/resources/countriesV3.1.json');
        if ($response->successful()) {
            $countries = $response->json();
            
            // Set 15 featured countries that we already had
            $featured = ['DE', 'CN', 'ID', 'AU', 'US', 'JP', 'IN', 'BR', 'GB', 'FR', 'CA', 'IT', 'KR', 'MX', 'ES'];

            foreach ($countries as $data) {
                if (!isset($data['cca2']) || !isset($data['name']['common'])) {
                    continue;
                }

                $currency = null;
                $currencyName = null;
                if (isset($data['currencies'])) {
                    $currKeys = array_keys($data['currencies']);
                    if (count($currKeys) > 0) {
                        $currency = $currKeys[0];
                        $currencyName = $data['currencies'][$currency]['name'] ?? null;
                    }
                }

                $language = null;
                if (isset($data['languages'])) {
                    $langKeys = array_values($data['languages']);
                    if (count($langKeys) > 0) {
                        $language = $langKeys[0];
                    }
                }

                Country::updateOrCreate(
                    ['code' => $data['cca2']],
                    [
                        'code3' => $data['cca3'] ?? null,
                        'name' => $data['name']['common'],
                        'region' => $data['region'] ?? null,
                        'subregion' => $data['subregion'] ?? null,
                        'capital' => isset($data['capital'][0]) ? $data['capital'][0] : null,
                        'currency' => $currency,
                        'currency_name' => $currencyName,
                        'language' => $language,
                        'lat' => isset($data['latlng'][0]) ? $data['latlng'][0] : 0,
                        'lng' => isset($data['latlng'][1]) ? $data['latlng'][1] : 0,
                        'population' => $data['population'] ?? 0,
                        'flag' => $data['flag'] ?? null,
                        'is_featured' => in_array($data['cca2'], $featured)
                    ]
                );
            }
        }
    }
}