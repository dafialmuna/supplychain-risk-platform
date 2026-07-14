<?php

namespace App\Services;

use GuzzleHttp\Client;

class RestCountriesService
{
    protected $client;

    protected $jsonUrl = 'https://raw.githubusercontent.com/restcountries/restcountries/master/src/main/resources/countriesV3.1.json';
    protected $cachedData = null;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false, // Bypass SSL for local development
            'timeout' => 15,
        ]);
    }

    protected function fetchData()
    {
        if ($this->cachedData !== null) {
            return $this->cachedData;
        }

        try {
            $response = $this->client->get($this->jsonUrl);
            $this->cachedData = json_decode($response->getBody(), true);
            return $this->cachedData;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Ambil data negara berdasarkan kode alpha2 (misal 'ID')
     */
    public function getCountry($code)
    {
        $data = $this->fetchData();
        if (is_array($data)) {
            foreach ($data as $country) {
                if (isset($country['cca2']) && strtoupper($country['cca2']) === strtoupper($code)) {
                    return $country;
                }
            }
        }
        return null;
    }

    /**
     * Ambil daftar semua negara (untuk dropdown, dll)
     */
    public function getAllCountries()
    {
        return $this->fetchData();
    }
}