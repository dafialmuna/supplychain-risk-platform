<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GNewsService;
use App\Services\SentimentService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected $gnews;
    protected $sentiment;

    public function __construct(GNewsService $gnews, SentimentService $sentiment)
    {
        $this->gnews = $gnews;
        $this->sentiment = $sentiment;
    }

    public function index(Request $request)
    {
        $country = $request->country ?? '';
        $topic = $request->topic ?? 'logistics';
        $max = $request->max ?? 10;

        // Build query based on country and topic
        $query = $topic;
        if ($country) {
            $query .= " {$country}";
        }

        $news = $this->gnews->searchNews($query, $max);

        // Analyze sentiment for each news
        foreach ($news as &$item) {
            $text = ($item['title'] ?? '') . ' ' . ($item['description'] ?? '');
            $result = $this->sentiment->analyze($text);
            $item['sentiment'] = $result['sentiment'];
            $item['pos_score'] = $result['positive'];
            $item['neg_score'] = $result['negative'];
        }

        return response()->json([
            'news' => $news,
            'country' => $country,
            'topic' => $topic,
            'count' => count($news),
        ]);
    }
}