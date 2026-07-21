<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipment1 = \App\Models\Shipment::create([
            'tracking_number' => 'RSK-20260721-001',
            'origin_country' => 'ID',
            'destination_country' => 'SG',
            'status' => 'In Transit',
            'current_lat' => 1.25,
            'current_lng' => 104.2,
        ]);

        $shipment1->logs()->createMany([
            [
                'location_name' => 'Tanjung Priok, Indonesia',
                'status_message' => 'Shipment departed from origin port.',
                'lat' => -6.10,
                'lng' => 106.87,
                'recorded_at' => now()->subDays(2),
            ],
            [
                'location_name' => 'Java Sea',
                'status_message' => 'In transit to Singapore.',
                'lat' => -3.2,
                'lng' => 105.8,
                'recorded_at' => now()->subDay(),
            ],
            [
                'location_name' => 'Singapore Strait',
                'status_message' => 'Approaching destination port. Expected delay due to heavy rain.',
                'lat' => 1.25,
                'lng' => 104.2,
                'recorded_at' => now()->subHours(2),
            ],
        ]);
        
        $shipment2 = \App\Models\Shipment::create([
            'tracking_number' => 'RSK-20260721-002',
            'origin_country' => 'CN',
            'destination_country' => 'US',
            'status' => 'Delayed',
            'current_lat' => 25.1,
            'current_lng' => 121.5,
        ]);

        $shipment2->logs()->createMany([
            [
                'location_name' => 'Shanghai Port, China',
                'status_message' => 'Container loaded onto vessel.',
                'lat' => 31.3,
                'lng' => 121.6,
                'recorded_at' => now()->subDays(4),
            ],
            [
                'location_name' => 'East China Sea',
                'status_message' => 'Vessel halted due to typhoon warning.',
                'lat' => 25.1,
                'lng' => 121.5,
                'recorded_at' => now()->subHours(10),
            ],
        ]);
    }
}
