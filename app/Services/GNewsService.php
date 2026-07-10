<?php

namespace App\Services;

use GuzzleHttp\Client;

class GNewsService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://gnews.io/api/v4/',
            'timeout' => 10,
        ]);
        $this->apiKey = env('GNEWS_API_KEY', '');
    }

    /**
     * Cari berita berdasarkan topik dan negara (opsional)
     */
    public function searchNews($query, $country = null, $max = 10)
    {
        // Jika tidak ada API key, return dummy news (agar tetap jalan)
        if (empty($this->apiKey)) {
            return $this->getDummyNews($query);
        }

        $cacheKey = "gnews_" . md5($query . $country . $max);
        $cached = \Illuminate\Support\Facades\Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        try {
            $params = [
                'q' => $query,
                'max' => $max,
                'token' => $this->apiKey,
                'lang' => 'en',
            ];
            if ($country) {
                $params['country'] = $country;
            }

            $response = $this->client->get('search', ['query' => $params]);
            $data = json_decode($response->getBody(), true);

            if (isset($data['articles']) && !empty($data['articles'])) {
                \Illuminate\Support\Facades\Cache::put($cacheKey, $data['articles'], 3600);
                return $data['articles'];
            }
            return [];
        } catch (\Exception $e) {
            return $this->getDummyNews($query);
        }
    }

    /**
     * Berita dummy jika API key tidak tersedia atau terjadi error
     */
    private function getDummyNews($query)
    {
        $topics = ['logistics', 'trade', 'shipping', 'economy', 'geopolitics'];
        $titles = [
            "Global supply chain faces new challenges in 2024",
            "Trade tensions escalate between major economies",
            "Shipping rates surge amid port congestion",
            "Inflation concerns impact consumer spending",
            "Geopolitical risks threaten global trade routes",
            "Logistics companies invest in digital transformation",
            "Port of Rotterdam reports record container volumes",
            "WTO warns of trade fragmentation",
            "Energy prices affect manufacturing costs",
            "New trade agreement boosts regional cooperation"
        ];

        $articles = [];
        for ($i = 0; $i < 5; $i++) {
            $articles[] = [
                'title' => $titles[array_rand($titles)] . " (dummy)",
                'description' => "This is a sample news article about {$query}. For real news, set GNEWS_API_KEY in .env",
                'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. " . str_repeat("Sample content about {$query}. ", 5),
                'url' => '#',
                'source' => ['name' => 'Dummy News Service'],
                'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-'.rand(1,24).' hours')),
            ];
        }
        return $articles;
    }
}