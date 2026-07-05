<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{

    public function index()
    {
        $watchlists = Watchlist::where('user_id', Auth::id())
            ->with('country')
            ->get();
        return view('watchlist.index', compact('watchlists'));
    }

    public function store(Request $request)
    {
        $request->validate(['country_code' => 'required|string']);
        $country = Country::where('code', $request->country_code)->firstOrFail();

        Watchlist::firstOrCreate([
            'user_id' => Auth::id(),
            'country_id' => $country->id,
        ]);

        return back()->with('success', 'Country added to watchlist.');
    }

    public function destroy($id)
    {
        $item = Watchlist::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with('success', 'Removed from watchlist.');
    }
}