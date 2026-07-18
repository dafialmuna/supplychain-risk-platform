<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WordSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $positive = [
            'growth', 'increase', 'profit', 'stable', 'improve', 'positive', 'gain',
            'boost', 'recovery', 'expansion', 'surplus', 'boom', 'upturn', 'revival',
            'strengthen', 'success', 'opportunity', 'benefit', 'advantage', 'win',
            'achieve', 'progress', 'development', 'innovation', 'efficiency',
            'productivity', 'optimism', 'confidence', 'investment', 'demand',
            'supply', 'logistics', 'trade', 'shipping', 'economy', 'business',
            'market', 'export', 'import'
        ];

        $negative = [
            'war', 'crisis', 'inflation', 'delay', 'disaster', 'drop', 'fall',
            'decline', 'loss', 'deficit', 'slowdown', 'recession', 'conflict',
            'tension', 'sanction', 'embargo', 'blockade', 'shortage', 'scarcity',
            'volatility', 'uncertainty', 'instability', 'corruption', 'fraud',
            'default', 'bankruptcy', 'downgrade', 'outbreak', 'pandemic', 'lockdown',
            'restriction', 'closure', 'interruption', 'disruption', 'halt',
            'strike', 'protest', 'riot', 'violence', 'terror', 'attack', 'threat',
            'risk', 'danger', 'vulnerability', 'weakness', 'failure', 'collapse',
            'crash', 'plunge', 'slump'
        ];

        $positiveData = array_map(function ($word) use ($now) {
            return [
                'word' => $word,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $positive);

        $negativeData = array_map(function ($word) use ($now) {
            return [
                'word' => $word,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $negative);

        // Bulk insert or ignore to prevent duplicates without firing a query per word
        DB::table('positive_words')->insertOrIgnore($positiveData);
        DB::table('negative_words')->insertOrIgnore($negativeData);
    }
}