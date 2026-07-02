<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenMeteoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.open-meteo.com/v1/',
            'timeout' => 10,
        ]);
    }

    /**
     * Ambil data cuaca saat ini berdasarkan latitude & longitude
     */
    public function getCurrentWeather($lat, $lng)
    {
        try {
            $response = $this->client->get('forecast', [
                'query' => [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current_weather' => true,
                    'timezone' => 'auto',
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['current_weather'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}