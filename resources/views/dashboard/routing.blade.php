@extends('layouts.app')

@section('title', 'Shipping Route Simulation - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-route me-2 text-primary"></i>Shipping Route Simulation</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
</div>

<div class="row g-4 mb-4">
    <!-- Kontrol Rute -->
    <div class="col-md-4">
        <div class="card p-4 h-100 shadow-sm border-0">
            <h5 class="mb-4"><i class="fas fa-ship me-2 text-info"></i>Plan Your Route</h5>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Origin Port</label>
                <select id="originPort" class="form-select">
                    <option value="">Loading ports...</option>
                </select>
            </div>
            
            <div class="text-center my-2 text-muted">
                <i class="fas fa-arrow-down"></i>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Destination Port</label>
                <select id="destPort" class="form-select">
                    <option value="">Loading ports...</option>
                </select>
            </div>
            
            <button class="btn btn-primary w-100 py-2 fw-bold" onclick="simulateRoute()">
                <i class="fas fa-route me-2"></i>Simulate Route
            </button>
            
            <hr class="my-4">
            
            <!-- Hasil Kalkulasi (Distance & Midpoint Weather) -->
            <div id="routeResults" class="d-none">
                <h6 class="fw-bold mb-3">Route Analysis</h6>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Estimated Distance:</span>
                    <strong id="routeDistance">-</strong>
                </div>
                
                <div class="p-3 rounded mt-3 text-center" style="background: rgba(0, 0, 0, 0.2); border: 1px solid rgba(255,255,255,0.05);">
                    <small class="text-muted d-block mb-2">Risiko Cuaca Laut (Titik Tengah)</small>
                    <div class="display-4 mb-2" id="midpointIcon">🌊</div>
                    <strong id="midpointTemp" class="fs-4 d-block text-white">- °C</strong>
                    <span id="midpointWind" class="badge bg-primary mt-1" style="background: rgba(56, 189, 248, 0.2) !important; color: #38bdf8 !important; border: 1px solid rgba(56, 189, 248, 0.3);">- km/h wind</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map Container -->
    <div class="col-md-8">
        <div class="card p-3 shadow-sm border-0 h-100">
            <div id="routeMap" style="height: 70vh; border-radius: 8px;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let routeMap;
let allPorts = [];
let routeLayer = null;
let markers = [];

document.addEventListener('DOMContentLoaded', function() {
    initRouteMap();
    loadPorts();
});

function initRouteMap() {
    routeMap = L.map('routeMap').setView([20, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(routeMap);
}

function loadPorts() {
    fetch('/api/ports')
        .then(res => res.json())
        .then(data => {
            allPorts = data.ports || [];
            // Sort by country -> name
            allPorts.sort((a, b) => {
                let countryA = a.country || a.country_code || '';
                let countryB = b.country || b.country_code || '';
                if(countryA === countryB) {
                    return (a.name || '').localeCompare(b.name || '');
                }
                return countryA.localeCompare(countryB);
            });
            
            populateSelect('originPort');
            populateSelect('destPort');

            // Cek parameter URL dari halaman Admin (Klik daftar pantauan user)
            const urlParams = new URLSearchParams(window.location.search);
            const destCountry = urlParams.get('destination');
            
            if (destCountry) {
                // Set default asal: Tanjung Priok / Port dari Indonesia
                const defaultOrigin = allPorts.find(p => (p.country === 'Indonesia' || p.country_code === 'ID') && p.name.includes('Priok')) || allPorts.find(p => p.country === 'Indonesia');
                // Set tujuan berdasarkan parameter negara
                const defaultDest = allPorts.find(p => p.country_code === destCountry || p.country === destCountry);
                
                if (defaultOrigin && defaultDest) {
                    document.getElementById('originPort').value = defaultOrigin.id;
                    document.getElementById('destPort').value = defaultDest.id;
                    
                    // Otomatis hitung rute
                    setTimeout(() => {
                        simulateRoute();
                    }, 500);
                }
            }
        })
        .catch(err => console.error("Failed to load ports", err));
}

function populateSelect(elementId) {
    const select = document.getElementById(elementId);
    select.innerHTML = '<option value="">-- Select a Port --</option>';
    
    // Create optgroups by country
    let currentCountry = '';
    let optgroup = null;
    
    // Ambil 500 pelabuhan utama saja agar select tidak terlalu berat
    const majorPorts = allPorts.slice(0, 500);
    
    majorPorts.forEach(port => {
        if (!port.lat || !port.lng) return;
        
        let cName = port.country || port.country_code || 'Unknown Country';
        
        if (cName !== currentCountry) {
            optgroup = document.createElement('optgroup');
            optgroup.label = cName;
            select.appendChild(optgroup);
            currentCountry = cName;
        }
        
        const option = document.createElement('option');
        // Simpan index sebagai value
        option.value = port.id; 
        option.textContent = port.name;
        optgroup.appendChild(option);
    });
}

function getPortById(id) {
    return allPorts.find(p => p.id == id);
}

function simulateRoute() {
    const originId = document.getElementById('originPort').value;
    const destId = document.getElementById('destPort').value;
    
    if (!originId || !destId) {
        alert("Please select both Origin and Destination ports.");
        return;
    }
    
    if (originId === destId) {
        alert("Origin and Destination cannot be the same.");
        return;
    }
    
    const origin = getPortById(originId);
    const dest = getPortById(destId);
    
    if (!origin || !dest) return;
    
    // Hapus rute sebelumnya
    if (routeLayer) routeMap.removeLayer(routeLayer);
    markers.forEach(m => routeMap.removeLayer(m));
    markers = [];
    
    const originLatLng = L.latLng(origin.lat, origin.lng);
    const destLatLng = L.latLng(dest.lat, dest.lng);
    
    // Tambah Marker Asal
    const markerO = L.marker(originLatLng).addTo(routeMap)
        .bindPopup(`<b>Origin:</b> ${origin.name} (${origin.country || origin.country_code})`).openPopup();
    
    // Tambah Marker Tujuan
    const markerD = L.marker(destLatLng).addTo(routeMap)
        .bindPopup(`<b>Destination:</b> ${dest.name} (${dest.country || dest.country_code})`);
        
    markers.push(markerO, markerD);
    
    // Tampilkan loading di tombol
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghitung rute laut...';
    btn.disabled = true;

    // Load searoute-js dinamis dan gambar rute laut
    import('https://esm.sh/searoute-js@0.1.0').then(module => {
        const searoute = module.default;
        
        const originPt = {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [origin.lng, origin.lat] }
        };
        
        const destPt = {
            "type": "Feature",
            "geometry": { "type": "Point", "coordinates": [dest.lng, dest.lat] }
        };

        try {
            // Kalkulasi rute laut sebenarnya!
            const routeGeoJSON = searoute(originPt, destPt);
            
            if (routeGeoJSON) {
                routeLayer = L.geoJSON(routeGeoJSON, {
                    style: { color: '#f59e0b', weight: 4, dashArray: '10, 10', opacity: 0.8 }
                }).addTo(routeMap);
                
                // Kalkulasi Jarak (dari GeoJSON properties atau pakai turf)
                // searoute-js biasanya memasukkan properties.length (dalam satuan nautikal mil, atau sesuai argumen)
                // Kita hitung jarak di frontend saja atau ambil properties-nya
                let distanceKm = 0;
                if (routeGeoJSON.properties && routeGeoJSON.properties.length) {
                    distanceKm = Math.round(routeGeoJSON.properties.length * 1.852); // NM to KM
                } else {
                    // Fallback jarak lurus jika properties tidak ada
                    distanceKm = Math.round(originLatLng.distanceTo(destLatLng) / 1000);
                }
                
                document.getElementById('routeDistance').textContent = distanceKm.toLocaleString() + " km (Rute Laut)";
                
                // Cari titik tengah rute (midpoint dari koordinat array)
                const coords = routeGeoJSON.geometry.coordinates;
                const midIndex = Math.floor(coords.length / 2);
                const midLng = coords[midIndex][0];
                const midLat = coords[midIndex][1];
                
                routeMap.fitBounds(routeLayer.getBounds(), { padding: [50, 50] });
                
                // Tampilkan hasil UI
                document.getElementById('routeResults').classList.remove('d-none');
                
                // Fetch cuaca laut di Midpoint rute sebenarnya
                fetchMidpointWeather(midLat, midLng);
            } else {
                throw new Error("Rute laut tidak ditemukan.");
            }
        } catch (e) {
            console.error("Searoute error:", e);
            // Fallback ke garis lurus jika rute laut gagal
            routeLayer = L.polyline([originLatLng, destLatLng], {
                color: '#ef4444', weight: 4, dashArray: '10, 10', opacity: 0.8
            }).addTo(routeMap);
            
            const distanceKm = Math.round(originLatLng.distanceTo(destLatLng) / 1000);
            document.getElementById('routeDistance').textContent = distanceKm.toLocaleString() + " km (Rute Lurus/Udara)";
            document.getElementById('routeResults').classList.remove('d-none');
            
            const midLat = (parseFloat(origin.lat) + parseFloat(dest.lat)) / 2;
            const midLng = (parseFloat(origin.lng) + parseFloat(dest.lng)) / 2;
            fetchMidpointWeather(midLat, midLng);
            
            routeMap.fitBounds(routeLayer.getBounds(), { padding: [50, 50] });
        }
    }).catch(err => {
        console.error("Gagal load module searoute-js:", err);
    }).finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}


function fetchMidpointWeather(lat, lng) {
    document.getElementById('midpointTemp').textContent = "Loading...";
    document.getElementById('midpointWind').textContent = "-";
    document.getElementById('midpointIcon').textContent = "🌊";
    
    // Panggil Open-Meteo API langsung dari klien
    fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lng}&current_weather=true`)
        .then(res => res.json())
        .then(data => {
            if (data.current_weather) {
                const w = data.current_weather;
                document.getElementById('midpointTemp').textContent = `${w.temperature} °C`;
                document.getElementById('midpointWind').textContent = `${w.windspeed} km/h wind`;
                
                // Icon sederhana berdasarkan windspeed atau cuaca
                if (w.windspeed > 40) {
                    document.getElementById('midpointIcon').textContent = "🌪️";
                    document.getElementById('midpointIcon').className = "display-4 mb-2 text-danger";
                } else if (w.windspeed > 20) {
                    document.getElementById('midpointIcon').textContent = "💨";
                    document.getElementById('midpointIcon').className = "display-4 mb-2 text-warning";
                } else {
                    document.getElementById('midpointIcon').textContent = "⛵";
                    document.getElementById('midpointIcon').className = "display-4 mb-2 text-info";
                }
                
                // Tambah marker titik tengah di peta
                const midMarker = L.circleMarker([lat, lng], {
                    radius: 8, fillColor: '#ef4444', color: '#fff', weight: 2, fillOpacity: 1
                }).addTo(routeMap).bindPopup(`<b>Ocean Midpoint</b><br>${w.temperature}°C, Wind: ${w.windspeed} km/h`);
                
                markers.push(midMarker);
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('midpointTemp').textContent = "Data unavailable";
        });
}
</script>
@endpush
