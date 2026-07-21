<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = \App\Models\Shipment::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        $users = \App\Models\User::all();
        return view('admin.shipments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|unique:shipments',
            'origin_country' => 'required|string|max:2',
            'destination_country' => 'required|string|max:2',
            'status' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'current_lat' => 'nullable|numeric',
            'current_lng' => 'nullable|numeric',
        ]);

        \App\Models\Shipment::create($request->all());

        return redirect()->route('admin.shipments.index')->with('success', 'Shipment created successfully.');
    }

    public function show($id)
    {
        $shipment = \App\Models\Shipment::with('logs', 'user')->findOrFail($id);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit($id)
    {
        $shipment = \App\Models\Shipment::findOrFail($id);
        $users = \App\Models\User::all();
        return view('admin.shipments.edit', compact('shipment', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|unique:shipments,tracking_number,' . $id,
            'origin_country' => 'required|string|max:2',
            'destination_country' => 'required|string|max:2',
            'status' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'current_lat' => 'nullable|numeric',
            'current_lng' => 'nullable|numeric',
        ]);

        $shipment = \App\Models\Shipment::findOrFail($id);
        $shipment->update($request->all());

        return redirect()->route('admin.shipments.index')->with('success', 'Shipment updated successfully.');
    }

    public function destroy($id)
    {
        \App\Models\Shipment::findOrFail($id)->delete();
        return redirect()->route('admin.shipments.index')->with('success', 'Shipment deleted successfully.');
    }
    
    // Custom method to add log
    public function addLog(Request $request, $id)
    {
        $request->validate([
            'location_name' => 'required|string',
            'status_message' => 'required|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $shipment = \App\Models\Shipment::findOrFail($id);
        $shipment->logs()->create($request->all());

        // Update shipment current location if provided
        if ($request->lat && $request->lng) {
            $shipment->update([
                'current_lat' => $request->lat,
                'current_lng' => $request->lng,
            ]);
        }

        return redirect()->route('admin.shipments.show', $id)->with('success', 'Log added successfully.');
    }
}
