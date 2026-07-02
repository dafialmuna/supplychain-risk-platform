<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WorldBankService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.worldbank.org/v2/',
            'timeout' => 15,
        ]);
    }

    public function getIndicator($countryCode, $indicator)
    {
        try {
            $response = $this->client->get("country/{$countryCode}/indicator/{$indicator}", [
                'query' => [
                    'format' => 'json',
                    'per_page' => 1,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            if (isset($data[1][0]['value'])) {
                return $data[1][0]['value'];
            }
            return null;
        } catch (\Exception $e) {
            Log::error("WorldBank API error ({$indicator}): " . $e->getMessage());
            return null;
        }
    }

    public function getGDP($countryCode)
    {
        return $this->getIndicator($countryCode, 'NY.GDP.MKTP.CD');
    }

    public function getInflation($countryCode)
    {
        return $this->getIndicator($countryCode, 'FP.CPI.TOTL.ZG');
    }

    public function getPopulation($countryCode)
    {
        return $this->getIndicator($countryCode, 'SP.POP.TOTL');
    }

    public function getExports($countryCode)
    {
        return $this->getIndicator($countryCode, 'NE.EXP.GNFS.CD');
    }

    public function getImports($countryCode)
    {
        return $this->getIndicator($countryCode, 'NE.IMP.GNFS.CD');
    }
}