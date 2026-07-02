<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run()
    {
        $ports = [
            ['name' => 'Port of Shanghai', 'country' => 'China', 'country_code' => 'CN', 'lat' => 31.2304, 'lng' => 121.4737, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Singapore', 'country' => 'Singapore', 'country_code' => 'SG', 'lat' => 1.2640, 'lng' => 103.8190, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Rotterdam', 'country' => 'Netherlands', 'country_code' => 'NL', 'lat' => 51.9225, 'lng' => 4.4792, 'type' => 'Seaport', 'region' => 'Europe'],
            ['name' => 'Port of Los Angeles', 'country' => 'United States', 'country_code' => 'US', 'lat' => 33.7419, 'lng' => -118.2615, 'type' => 'Seaport', 'region' => 'Americas'],
            ['name' => 'Port of Dubai', 'country' => 'United Arab Emirates', 'country_code' => 'AE', 'lat' => 25.2048, 'lng' => 55.2708, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Hamburg', 'country' => 'Germany', 'country_code' => 'DE', 'lat' => 53.5511, 'lng' => 9.9937, 'type' => 'Seaport', 'region' => 'Europe'],
            ['name' => 'Port of Antwerp', 'country' => 'Belgium', 'country_code' => 'BE', 'lat' => 51.2206, 'lng' => 4.3997, 'type' => 'Seaport', 'region' => 'Europe'],
            ['name' => 'Port of Qingdao', 'country' => 'China', 'country_code' => 'CN', 'lat' => 36.0669, 'lng' => 120.3826, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Yokohama', 'country' => 'Japan', 'country_code' => 'JP', 'lat' => 35.4437, 'lng' => 139.6380, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Mumbai', 'country' => 'India', 'country_code' => 'IN', 'lat' => 18.9220, 'lng' => 72.8347, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Melbourne', 'country' => 'Australia', 'country_code' => 'AU', 'lat' => -37.8136, 'lng' => 144.9631, 'type' => 'Seaport', 'region' => 'Oceania'],
            ['name' => 'Port of Santos', 'country' => 'Brazil', 'country_code' => 'BR', 'lat' => -23.9600, 'lng' => -46.3340, 'type' => 'Seaport', 'region' => 'Americas'],
            ['name' => 'Port of Jakarta', 'country' => 'Indonesia', 'country_code' => 'ID', 'lat' => -6.1248, 'lng' => 106.8030, 'type' => 'Seaport', 'region' => 'Asia'],
            ['name' => 'Port of Long Beach', 'country' => 'United States', 'country_code' => 'US', 'lat' => 33.7550, 'lng' => -118.1890, 'type' => 'Seaport', 'region' => 'Americas'],
            ['name' => 'Port of Piraeus', 'country' => 'Greece', 'country_code' => 'GR', 'lat' => 37.9429, 'lng' => 23.6465, 'type' => 'Seaport', 'region' => 'Europe'],
            // Tambahkan sisanya (dari worklog)
        ];

        foreach ($ports as $data) {
            Port::create($data);
        }
    }
}