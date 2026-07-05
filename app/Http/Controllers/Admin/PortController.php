<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::all();
        return view('admin.ports.index', compact('ports'));
    }

    public function create()
    {
        return view('admin.ports.create');
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

        Port::create($request->all());
        return redirect()->route('admin.ports.index')->with('success', 'Port added successfully.');
    }

    public function edit(Port $port)
    {
        return view('admin.ports.edit', compact('port'));
    }

    public function update(Request $request, Port $port)
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

        $port->update($request->all());
        return redirect()->route('admin.ports.index')->with('success', 'Port updated successfully.');
    }

    public function destroy(Port $port)
    {
        $port->delete();
        return redirect()->route('admin.ports.index')->with('success', 'Port deleted successfully.');
    }
}