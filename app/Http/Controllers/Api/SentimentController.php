<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SentimentService;
use Illuminate\Http\Request;

class SentimentController extends Controller
{
    protected $sentiment;

    public function __construct(SentimentService $sentiment)
    {
        $this->sentiment = $sentiment;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:3',
        ]);

        $result = $this->sentiment->analyze($request->text);

        return response()->json([
            'result' => $result,
            'input' => $request->text,
        ]);
    }
}