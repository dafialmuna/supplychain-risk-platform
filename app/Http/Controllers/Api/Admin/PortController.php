<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::all();
        $byCountry = Port::selectRaw('country, country_code, count(*) as count')
            ->groupBy('country', 'country_code')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            'ports' => $ports,
            'count' => $ports->count(),
            'by_country' => $byCountry,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'country_code' => 'required|string|size:2',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'type' => 'nullable|string|in:Seaport,River,Airport',
            'region' => 'nullable|string|max:100',
        ]);

        $port = Port::create($request->all());

        return response()->json(['port' => $port], 201);
    }

    public function show($id)
    {
        $port = Port::find($id);
        if (!$port) {
            return response()->json(['error' => 'Port not found'], 404);
        }
        return response()->json(['port' => $port]);
    }

    public function update(Request $request, $id)
    {
        $port = Port::find($id);
        if (!$port) {
            return response()->json(['error' => 'Port not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'country_code' => 'nullable|string|size:2',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'type' => 'nullable|string|in:Seaport,River,Airport',
            'region' => 'nullable|string|max:100',
        ]);

        $port->update($request->all());

        return response()->json(['port' => $port]);
    }

    public function destroy($id)
    {
        $port = Port::find($id);
        if (!$port) {
            return response()->json(['error' => 'Port not found'], 404);
        }

        $port->delete();
        return response()->json(['ok' => true]);
    }
}