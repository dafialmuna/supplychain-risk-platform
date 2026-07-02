<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExchangeRateService
{
    protected $client;
    protected $baseUrl = 'https://open.er-api.com/v6/';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10,
        ]);
    }

    /**
     * Ambil kurs terbaru untuk base currency tertentu (USD default)
     */
    public function getLatestRates($base = 'USD')
    {
        try {
            $response = $this->client->get("latest/{$base}");
            $data = json_decode($response->getBody(), true);
            if ($data['result'] === 'success') {
                return $data['rates'];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Ambil kurs spesifik base → target
     */
    public function getRate($base, $target)
    {
        $rates = $this->getLatestRates($base);
        if ($rates && isset($rates[$target])) {
            return $rates[$target];
        }
        return null;
    }
}