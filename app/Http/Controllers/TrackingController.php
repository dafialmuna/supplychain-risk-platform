<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $shipment = \App\Models\Shipment::with('logs')
            ->where('tracking_number', $request->tracking_number)
            ->first();

        if (!$shipment) {
            return back()->with('error', 'Tracking number not found.');
        }

        return view('tracking.index', compact('shipment'));
    }
}
