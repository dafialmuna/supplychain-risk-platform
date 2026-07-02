<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class WordSeeder extends Seeder
{
    public function run()
    {
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

        foreach ($positive as $word) {
            PositiveWord::firstOrCreate(['word' => $word]);
        }

        foreach ($negative as $word) {
            NegativeWord::firstOrCreate(['word' => $word]);
        }
    }
}