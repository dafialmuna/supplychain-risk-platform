<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['code' => 'DE', 'code3' => 'DEU', 'name' => 'Germany', 'region' => 'Europe', 'subregion' => 'Western Europe', 'capital' => 'Berlin', 'currency' => 'EUR', 'currency_name' => 'Euro', 'language' => 'German', 'lat' => 51.1657, 'lng' => 10.4515, 'population' => 83240000, 'flag' => '🇩🇪', 'is_featured' => true],
            ['code' => 'CN', 'code3' => 'CHN', 'name' => 'China', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'capital' => 'Beijing', 'currency' => 'CNY', 'currency_name' => 'Yuan', 'language' => 'Chinese', 'lat' => 35.8617, 'lng' => 104.1954, 'population' => 1412000000, 'flag' => '🇨🇳', 'is_featured' => true],
            ['code' => 'ID', 'code3' => 'IDN', 'name' => 'Indonesia', 'region' => 'Asia', 'subregion' => 'Southeast Asia', 'capital' => 'Jakarta', 'currency' => 'IDR', 'currency_name' => 'Rupiah', 'language' => 'Indonesian', 'lat' => -0.7893, 'lng' => 113.9213, 'population' => 277500000, 'flag' => '🇮🇩', 'is_featured' => true],
            ['code' => 'AU', 'code3' => 'AUS', 'name' => 'Australia', 'region' => 'Oceania', 'subregion' => 'Australia and New Zealand', 'capital' => 'Canberra', 'currency' => 'AUD', 'currency_name' => 'Australian Dollar', 'language' => 'English', 'lat' => -25.2744, 'lng' => 133.7751, 'population' => 26400000, 'flag' => '🇦🇺', 'is_featured' => true],
            ['code' => 'US', 'code3' => 'USA', 'name' => 'United States', 'region' => 'Americas', 'subregion' => 'Northern America', 'capital' => 'Washington D.C.', 'currency' => 'USD', 'currency_name' => 'US Dollar', 'language' => 'English', 'lat' => 37.0902, 'lng' => -95.7129, 'population' => 335000000, 'flag' => '🇺🇸', 'is_featured' => true],
            ['code' => 'JP', 'code3' => 'JPN', 'name' => 'Japan', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'capital' => 'Tokyo', 'currency' => 'JPY', 'currency_name' => 'Yen', 'language' => 'Japanese', 'lat' => 36.2048, 'lng' => 138.2529, 'population' => 123700000, 'flag' => '🇯🇵', 'is_featured' => true],
            ['code' => 'IN', 'code3' => 'IND', 'name' => 'India', 'region' => 'Asia', 'subregion' => 'Southern Asia', 'capital' => 'New Delhi', 'currency' => 'INR', 'currency_name' => 'Indian Rupee', 'language' => 'Hindi', 'lat' => 20.5937, 'lng' => 78.9629, 'population' => 1428000000, 'flag' => '🇮🇳', 'is_featured' => true],
            ['code' => 'BR', 'code3' => 'BRA', 'name' => 'Brazil', 'region' => 'Americas', 'subregion' => 'South America', 'capital' => 'Brasília', 'currency' => 'BRL', 'currency_name' => 'Brazilian Real', 'language' => 'Portuguese', 'lat' => -14.2350, 'lng' => -51.9253, 'population' => 216400000, 'flag' => '🇧🇷', 'is_featured' => true],
            ['code' => 'GB', 'code3' => 'GBR', 'name' => 'United Kingdom', 'region' => 'Europe', 'subregion' => 'Northern Europe', 'capital' => 'London', 'currency' => 'GBP', 'currency_name' => 'Pound Sterling', 'language' => 'English', 'lat' => 55.3781, 'lng' => -3.4360, 'population' => 67700000, 'flag' => '🇬🇧', 'is_featured' => true],
            ['code' => 'FR', 'code3' => 'FRA', 'name' => 'France', 'region' => 'Europe', 'subregion' => 'Western Europe', 'capital' => 'Paris', 'currency' => 'EUR', 'currency_name' => 'Euro', 'language' => 'French', 'lat' => 46.6034, 'lng' => 1.8883, 'population' => 68000000, 'flag' => '🇫🇷', 'is_featured' => true],
            ['code' => 'CA', 'code3' => 'CAN', 'name' => 'Canada', 'region' => 'Americas', 'subregion' => 'Northern America', 'capital' => 'Ottawa', 'currency' => 'CAD', 'currency_name' => 'Canadian Dollar', 'language' => 'English', 'lat' => 56.1304, 'lng' => -106.3468, 'population' => 38800000, 'flag' => '🇨🇦', 'is_featured' => true],
            ['code' => 'IT', 'code3' => 'ITA', 'name' => 'Italy', 'region' => 'Europe', 'subregion' => 'Southern Europe', 'capital' => 'Rome', 'currency' => 'EUR', 'currency_name' => 'Euro', 'language' => 'Italian', 'lat' => 41.8719, 'lng' => 12.5674, 'population' => 58900000, 'flag' => '🇮🇹', 'is_featured' => true],
            ['code' => 'KR', 'code3' => 'KOR', 'name' => 'South Korea', 'region' => 'Asia', 'subregion' => 'Eastern Asia', 'capital' => 'Seoul', 'currency' => 'KRW', 'currency_name' => 'Won', 'language' => 'Korean', 'lat' => 35.9078, 'lng' => 127.7669, 'population' => 51700000, 'flag' => '🇰🇷', 'is_featured' => true],
            ['code' => 'MX', 'code3' => 'MEX', 'name' => 'Mexico', 'region' => 'Americas', 'subregion' => 'Central America', 'capital' => 'Mexico City', 'currency' => 'MXN', 'currency_name' => 'Mexican Peso', 'language' => 'Spanish', 'lat' => 23.6345, 'lng' => -102.5528, 'population' => 128500000, 'flag' => '🇲🇽', 'is_featured' => true],
            ['code' => 'ES', 'code3' => 'ESP', 'name' => 'Spain', 'region' => 'Europe', 'subregion' => 'Southern Europe', 'capital' => 'Madrid', 'currency' => 'EUR', 'currency_name' => 'Euro', 'language' => 'Spanish', 'lat' => 40.4637, 'lng' => -3.7492, 'population' => 47500000, 'flag' => '🇪🇸', 'is_featured' => true],
            // Tambahkan 15 negara lagi sesuai kebutuhan (lihat daftar di worklog sebelumnya)
            ['code' => 'RU', 'code3' => 'RUS', 'name' => 'Russia', 'region' => 'Europe', 'subregion' => 'Eastern Europe', 'capital' => 'Moscow', 'currency' => 'RUB', 'currency_name' => 'Ruble', 'language' => 'Russian', 'lat' => 61.5240, 'lng' => 105.3188, 'population' => 144000000, 'flag' => '🇷🇺', 'is_featured' => false],
            ['code' => 'ZA', 'code3' => 'ZAF', 'name' => 'South Africa', 'region' => 'Africa', 'subregion' => 'Southern Africa', 'capital' => 'Pretoria', 'currency' => 'ZAR', 'currency_name' => 'Rand', 'language' => 'English', 'lat' => -30.5595, 'lng' => 22.9375, 'population' => 60000000, 'flag' => '🇿🇦', 'is_featured' => false],
            ['code' => 'EG', 'code3' => 'EGY', 'name' => 'Egypt', 'region' => 'Africa', 'subregion' => 'Northern Africa', 'capital' => 'Cairo', 'currency' => 'EGP', 'currency_name' => 'Egyptian Pound', 'language' => 'Arabic', 'lat' => 26.8206, 'lng' => 30.8025, 'population' => 110000000, 'flag' => '🇪🇬', 'is_featured' => false],
            ['code' => 'TR', 'code3' => 'TUR', 'name' => 'Turkey', 'region' => 'Asia', 'subregion' => 'Western Asia', 'capital' => 'Ankara', 'currency' => 'TRY', 'currency_name' => 'Lira', 'language' => 'Turkish', 'lat' => 38.9637, 'lng' => 35.2433, 'population' => 85000000, 'flag' => '🇹🇷', 'is_featured' => false],
            ['code' => 'TH', 'code3' => 'THA', 'name' => 'Thailand', 'region' => 'Asia', 'subregion' => 'Southeast Asia', 'capital' => 'Bangkok', 'currency' => 'THB', 'currency_name' => 'Baht', 'language' => 'Thai', 'lat' => 15.8700, 'lng' => 100.9925, 'population' => 70000000, 'flag' => '🇹🇭', 'is_featured' => false],
            ['code' => 'VN', 'code3' => 'VNM', 'name' => 'Vietnam', 'region' => 'Asia', 'subregion' => 'Southeast Asia', 'capital' => 'Hanoi', 'currency' => 'VND', 'currency_name' => 'Dong', 'language' => 'Vietnamese', 'lat' => 14.0583, 'lng' => 108.2772, 'population' => 98000000, 'flag' => '🇻🇳', 'is_featured' => false],
            ['code' => 'MY', 'code3' => 'MYS', 'name' => 'Malaysia', 'region' => 'Asia', 'subregion' => 'Southeast Asia', 'capital' => 'Kuala Lumpur', 'currency' => 'MYR', 'currency_name' => 'Ringgit', 'language' => 'Malay', 'lat' => 4.2105, 'lng' => 101.9758, 'population' => 33000000, 'flag' => '🇲🇾', 'is_featured' => false],
            ['code' => 'SG', 'code3' => 'SGP', 'name' => 'Singapore', 'region' => 'Asia', 'subregion' => 'Southeast Asia', 'capital' => 'Singapore', 'currency' => 'SGD', 'currency_name' => 'Singapore Dollar', 'language' => 'English', 'lat' => 1.3521, 'lng' => 103.8198, 'population' => 5600000, 'flag' => '🇸🇬', 'is_featured' => false],
            ['code' => 'NL', 'code3' => 'NLD', 'name' => 'Netherlands', 'region' => 'Europe', 'subregion' => 'Western Europe', 'capital' => 'Amsterdam', 'currency' => 'EUR', 'currency_name' => 'Euro', 'language' => 'Dutch', 'lat' => 52.1326, 'lng' => 5.2913, 'population' => 17400000, 'flag' => '🇳🇱', 'is_featured' => false],
            ['code' => 'SA', 'code3' => 'SAU', 'name' => 'Saudi Arabia', 'region' => 'Asia', 'subregion' => 'Western Asia', 'capital' => 'Riyadh', 'currency' => 'SAR', 'currency_name' => 'Riyal', 'language' => 'Arabic', 'lat' => 23.8859, 'lng' => 45.0792, 'population' => 36000000, 'flag' => '🇸🇦', 'is_featured' => false],
            ['code' => 'AE', 'code3' => 'ARE', 'name' => 'United Arab Emirates', 'region' => 'Asia', 'subregion' => 'Western Asia', 'capital' => 'Abu Dhabi', 'currency' => 'AED', 'currency_name' => 'Dirham', 'language' => 'Arabic', 'lat' => 23.4241, 'lng' => 53.8478, 'population' => 9900000, 'flag' => '🇦🇪', 'is_featured' => false],
            ['code' => 'AR', 'code3' => 'ARG', 'name' => 'Argentina', 'region' => 'Americas', 'subregion' => 'South America', 'capital' => 'Buenos Aires', 'currency' => 'ARS', 'currency_name' => 'Argentine Peso', 'language' => 'Spanish', 'lat' => -38.4161, 'lng' => -63.6167, 'population' => 46000000, 'flag' => '🇦🇷', 'is_featured' => false],
            // Anda bisa tambahkan sendiri jika perlu
        ];

        foreach ($countries as $data) {
            Country::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}