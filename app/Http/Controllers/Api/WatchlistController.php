<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlist = Watchlist::where('user_id', Auth::id())
            ->with('country')
            ->get();

        return response()->json(['watchlist' => $watchlist]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string|size:2',
            'label' => 'nullable|string|max:60',
        ]);

        $country = Country::where('code', $request->country_code)->first();
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        // Upsert: update jika sudah ada, buat baru jika belum
        $watchlist = Watchlist::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'country_id' => $country->id,
            ],
            [
                'label' => $request->label,
            ]
        );

        return response()->json([
            'watchlist' => $watchlist->load('country'),
        ], 201);
    }

    public function destroy($id)
    {
        $watchlist = Watchlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$watchlist) {
            return response()->json(['error' => 'Watchlist item not found'], 404);
        }

        $watchlist->delete();

        return response()->json(['ok' => true]);
    }
}