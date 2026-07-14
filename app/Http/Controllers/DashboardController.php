<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function weather()
    {
        return view('dashboard.weather');
    }

    public function currency()
    {
        $currencies = \App\Models\Country::whereNotNull('currency')
            ->select('currency', 'currency_name')
            ->distinct()
            ->orderBy('currency')
            ->get();
        return view('dashboard.currency', compact('currencies'));
    }

    public function news()
    {
        return view('dashboard.news');
    }

    public function ports()
    {
        return view('dashboard.ports');
    }

    public function visualization()
    {
        return view('dashboard.visualization');
    }

    public function compare()
    {
        return view('dashboard.compare');
    }

    public function routing()
    {
        return view('dashboard.routing');
    }
}
