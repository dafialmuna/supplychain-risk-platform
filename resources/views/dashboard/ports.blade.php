@extends('layouts.app')

@section('title', 'Port Location Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-ship me-2 text-primary"></i>Dasbor Lokasi Pelabuhan</h2>
    <span class="text-muted" style="font-size: 0.85rem;">
        <i class="far fa-clock me-1"></i>{{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
    </span>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card p-4 border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05) !important;">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary">Cari Nama Pelabuhan</label>
                    <select id="portSearch" class="form-select">
                        <option value="">Semua Pelabuhan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-secondary">Saring berdasarkan Negara</label>
                    <select id="countrySearch" class="form-select">
                        <option value="">Semua Negara</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="filterPorts()"><i class="fas fa-filter me-2"></i>Terapkan Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 h-100 border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05) !important;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-globe me-2 text-info"></i>Peta Pelabuhan Global</h5>
        <span class="badge bg-primary px-3 py-2" id="portCountBadge" style="border-radius: 8px; font-weight: 500;">Loading...</span>
    </div>
    <div id="portsMap" style="height: 65vh; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);"></div>
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
    
    // Gunakan Dark Mode Tile Layer agar serasi dengan tema
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
    }).addTo(portsMap);

    markersLayer = L.layerGroup().addTo(portsMap);

    // Fetch all ports
    fetch('/api/ports')
        .then(res => res.json())
        .then(data => {
            allPorts = data.ports || [];
            
            // Populate Country Dropdown
            const countrySet = new Set();
            allPorts.forEach(p => {
                if (p.country) countrySet.add(p.country);
                else if (p.country_code) countrySet.add(p.country_code);
            });
            const countries = Array.from(countrySet).sort();
            const countrySelect = document.getElementById('countrySearch');
            countries.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c;
                opt.textContent = c;
                countrySelect.appendChild(opt);
            });

            // Populate Port Dropdown (Sorted alphabetically)
            const portSelect = document.getElementById('portSearch');
            const sortedPorts = [...allPorts].sort((a,b) => (a.name || '').localeCompare(b.name || ''));
            sortedPorts.forEach(p => {
                if (p.name) {
                    const opt = document.createElement('option');
                    opt.value = p.name;
                    opt.textContent = `${p.name} (${p.country_code || p.country || 'Unknown'})`;
                    portSelect.appendChild(opt);
                }
            });
            
            document.getElementById('portCountBadge').textContent = `${allPorts.length} Port Ditemukan`;
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
                radius: 5,
                fillColor: '#38bdf8', // warna cyan terang
                color: '#0ea5e9',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.85,
                className: 'glow-marker'
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
        const matchName = !nameSearch || (port.name && port.name.toLowerCase() === nameSearch);
        const matchCountry = !countrySearch || 
            (port.country && port.country.toLowerCase() === countrySearch) ||
            (port.country_code && port.country_code.toLowerCase() === countrySearch);
        return matchName && matchCountry;
    });

    document.getElementById('portCountBadge').textContent = `${filtered.length} Port Ditemukan`;
    renderPorts(filtered);
}
</script>

<style>
.glow-marker {
    filter: drop-shadow(0 0 6px rgba(56, 189, 248, 0.8));
    transition: all 0.3s ease;
}
.glow-marker:hover {
    filter: drop-shadow(0 0 12px rgba(56, 189, 248, 1));
}
.form-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-secondary);
}
</style>
@endpush
