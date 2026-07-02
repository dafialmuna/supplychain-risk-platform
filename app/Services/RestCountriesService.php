<?php

namespace App\Services;

use GuzzleHttp\Client;

class RestCountriesService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://restcountries.com/v3.1/',
            'timeout' => 10,
        ]);
    }

    /**
     * Ambil data negara berdasarkan kode alpha2 (misal 'ID')
     */
    public function getCountry($code)
    {
        try {
            $response = $this->client->get("alpha/{$code}");
            $data = json_decode($response->getBody(), true);
            if (isset($data[0])) {
                return $data[0];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Ambil daftar semua negara (untuk dropdown, dll)
     */
    public function getAllCountries()
    {
        try {
            $response = $this->client->get('all');
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [];
        }
    }
}