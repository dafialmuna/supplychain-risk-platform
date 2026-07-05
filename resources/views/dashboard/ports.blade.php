@extends('layouts.app')

@section('title', 'Port Location Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ship me-2 text-primary"></i>Port Location Dashboard</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search Port Name</label>
                    <input type="text" id="portSearch" class="form-control" placeholder="e.g. Tanjung Priok">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filter by Country</label>
                    <input type="text" id="countrySearch" class="form-control" placeholder="e.g. Indonesia">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="filterPorts()"><i class="fas fa-filter me-2"></i>Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-3 h-100">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="mb-0"><i class="fas fa-globe me-2"></i>Global Ports Map</h5>
        <span class="badge bg-primary" id="portCountBadge">Loading...</span>
    </div>
    <div id="portsMap" style="height: 60vh; border-radius: 8px;"></div>
</div>
@endsection

@push('scripts')
<script>
let portsMap;
let markersLayer;
let allPorts = [];

document.addEventListener('DOMContentLoaded', function() {
    initPortsMap();
});

function initPortsMap() {
    const container = document.getElementById('portsMap');
    if (!container) return;

    portsMap = L.map('portsMap').setView([20, 10], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(portsMap);

    markersLayer = L.layerGroup().addTo(portsMap);

    // Fetch all ports
    fetch('/api/ports')
        .then(res => res.json())
        .then(data => {
            allPorts = data.ports || [];
            document.getElementById('portCountBadge').textContent = `${allPorts.length} Ports Loaded`;
            renderPorts(allPorts);
        })
        .catch(err => console.error(err));
}

function renderPorts(ports) {
    markersLayer.clearLayers();
    
    // Limit to 1000 markers for performance if array is too big
    const displayPorts = ports.slice(0, 1000);

    displayPorts.forEach(port => {
        if (port.lat && port.lng) {
            const marker = L.circleMarker([port.lat, port.lng], {
                radius: 6,
                fillColor: '#3b82f6',
                color: '#fff',
                weight: 1,
                opacity: 1,
                fillOpacity: 0.8
            });
            
            marker.bindPopup(`
                <div class="text-center">
                    <i class="fas fa-ship fs-1 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">${port.name}</h6>
                    <span class="badge bg-secondary mb-2">${port.country_code || port.country || 'Unknown'}</span>
                </div>
                <hr class="my-1">
                <small class="text-muted">Type: ${port.type || 'N/A'}</small><br>
                <small class="text-muted">Size: ${port.size || 'N/A'}</small>
            `);
            markersLayer.addLayer(marker);
        }
    });
}

function filterPorts() {
    const nameSearch = document.getElementById('portSearch').value.toLowerCase();
    const countrySearch = document.getElementById('countrySearch').value.toLowerCase();

    const filtered = allPorts.filter(port => {
        const matchName = !nameSearch || (port.name && port.name.toLowerCase().includes(nameSearch));
        const matchCountry = !countrySearch || 
            (port.country && port.country.toLowerCase().includes(countrySearch)) ||
            (port.country_code && port.country_code.toLowerCase().includes(countrySearch));
        return matchName && matchCountry;
    });

    document.getElementById('portCountBadge').textContent = `${filtered.length} Ports Found`;
    renderPorts(filtered);
}
</script>
@endpush
