<?php

namespace App\Services;

use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentService
{
    protected $positiveWords = [];
    protected $negativeWords = [];

    public function __construct()
    {
        // Load dari database (cache di memory)
        $this->positiveWords = PositiveWord::pluck('word')->toArray();
        $this->negativeWords = NegativeWord::pluck('word')->toArray();
    }

    /**
     * Analisis sentimen teks
     * @return array ['sentiment' => 'positive'|'neutral'|'negative', 'positive' => int, 'negative' => int, 'positivePct' => float, 'negativePct' => float, 'neutralPct' => float, 'matchedPositive' => array, 'matchedNegative' => array]
     */
    public function analyze($text)
    {
        $words = str_word_count(strtolower($text), 1);
        $posMatches = [];
        $negMatches = [];

        foreach ($words as $word) {
            if (in_array($word, $this->positiveWords)) {
                $posMatches[] = $word;
            }
            if (in_array($word, $this->negativeWords)) {
                $negMatches[] = $word;
            }
        }

        $posCount = count($posMatches);
        $negCount = count($negMatches);
        $total = $posCount + $negCount;

        if ($total === 0) {
            return [
                'sentiment' => 'neutral',
                'positive' => 0,
                'negative' => 0,
                'positivePct' => 0,
                'negativePct' => 0,
                'neutralPct' => 100,
                'matchedPositive' => [],
                'matchedNegative' => [],
            ];
        }

        $positivePct = round(($posCount / $total) * 100, 1);
        $negativePct = round(($negCount / $total) * 100, 1);
        $neutralPct = round(100 - $positivePct - $negativePct, 1);

        $sentiment = 'neutral';
        if ($posCount > $negCount) {
            $sentiment = 'positive';
        } elseif ($negCount > $posCount) {
            $sentiment = 'negative';
        }

        return [
            'sentiment' => $sentiment,
            'positive' => $posCount,
            'negative' => $negCount,
            'positivePct' => $positivePct,
            'negativePct' => $negativePct,
            'neutralPct' => $neutralPct,
            'matchedPositive' => array_unique($posMatches),
            'matchedNegative' => array_unique($negMatches),
        ];
    }
}