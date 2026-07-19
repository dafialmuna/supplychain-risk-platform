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
            'timeout' => 2,
            'verify' => false,
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

        $descriptions = [
            "In a recent turn of events, global supply chains are experiencing unprecedented shifts. Industry leaders are warning that issues surrounding {$query} could severely impact delivery times and operational costs. Stakeholders are advised to reconsider their risk mitigation strategies as the economic climate remains highly volatile.",
            "Data from the latest quarter indicates a significant disruption in traditional trade routes. Experts suggest that the current volatility related to {$query} is forcing multinational corporations to heavily invest in alternative logistics frameworks, underscoring the fragile nature of international commerce.",
            "According to prominent economic analysts, the recent surge in demand coupled with bottlenecked ports has created a perfect storm for the industry. The impact of {$query} is expected to resonate throughout the market, driving up inflation and forcing companies to adopt next-generation technologies.",
            "A comprehensive review of the latest market trends reveals that {$query} is becoming a central concern for policymakers. Governments and private sectors are now collaborating to establish more resilient infrastructure capable of withstanding future economic shocks.",
            "Market volatility has reached new heights this week as {$query} continues to dominate headlines. Financial institutions predict that if these disruptions persist, consumer prices will inevitably rise, prompting an urgent need for digital transformation across the global supply network."
        ];

        $articles = [];
        for ($i = 0; $i < 5; $i++) {
            $articles[] = [
                'title' => $titles[array_rand($titles)],
                'description' => $descriptions[array_rand($descriptions)],
                'content' => "This is a detailed analysis of the current situation. " . str_repeat("Developments about {$query} continue to evolve. ", 5),
                'url' => '#',
                'source' => ['name' => 'Global Logistics News'],
                'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-'.rand(1,24).' hours')),
            ];
        }
        return $articles;
    }
}