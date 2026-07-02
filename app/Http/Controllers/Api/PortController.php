<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $query = Port::query();

        // Filter by country code
        if ($request->has('country') && $request->country) {
            $query->where('country_code', $request->country);
        }

        // Search by name or country name
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('country', 'LIKE', "%{$search}%");
            });
        }

        $ports = $query->orderBy('name')->get();

        return response()->json([
            'ports' => $ports,
            'count' => $ports->count(),
        ]);
    }

    public function show($id)
    {
        $port = Port::find($id);
        if (!$port) {
            return response()->json(['error' => 'Port not found'], 404);
        }
        return response()->json(['port' => $port]);
    }
}