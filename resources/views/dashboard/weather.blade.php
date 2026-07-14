@extends('layouts.app')

@section('title', 'Global Weather Monitoring - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-cloud-sun me-2 text-primary"></i>Pemantauan Cuaca Global</h2>
    <span class="text-muted" style="font-size: 0.85rem;">
        <i class="far fa-clock me-1"></i>{{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
    </span>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card p-4 border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05) !important;">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-secondary" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Pilih Negara untuk Memantau Cuaca:</label>
                    <select id="weatherCountrySelect" class="form-select">
                        <option value="">Loading countries...</option>
                    </select>
                </div>
                <div class="col-md-8 d-flex align-items-end">
                    <button class="btn btn-primary" onclick="checkWeather()">
                        <i class="fas fa-search me-2"></i>Periksa Cuaca
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-4 h-100 border-0 shadow-lg" style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05) !important;">
    <h5 class="mb-3 fw-bold"><i class="fas fa-globe me-2 text-info"></i>Peta Cuaca Global (Hujan, Badai, Angin Kencang)</h5>
    <div id="weatherMap" style="height: 65vh; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);"></div>
</div>
@endsection

@push('scripts')
<script>
let weatherMap;
let weatherMarker = null;
let countriesData = [];

document.addEventListener('DOMContentLoaded', function() {
    initWeatherMap();
    loadCountries();
});

function initWeatherMap() {
    const container = document.getElementById('weatherMap');
    if (!container) return;

    weatherMap = L.map('weatherMap').setView([20, 10], 2);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
    }).addTo(weatherMap);
}

function loadCountries() {
    fetch('/api/countries')
        .then(res => res.json())
        .then(data => {
            countriesData = data.countries || [];
            const select = document.getElementById('weatherCountrySelect');
            select.innerHTML = '<option value="">-- Select a Country --</option>';
            
            countriesData.forEach(country => {
                const option = document.createElement('option');
                option.value = country.code;
                option.textContent = `${country.flag} ${country.name}`;
                select.appendChild(option);
            });
        })
        .catch(err => console.error(err));
}

function checkWeather() {
    const code = document.getElementById('weatherCountrySelect').value;
    if (!code) {
        alert("Please select a country first.");
        return;
    }

    const country = countriesData.find(c => c.code === code);
    if (!country || !country.lat || !country.lng) return;

    // Hapus marker sebelumnya
    if (weatherMarker) {
        weatherMap.removeLayer(weatherMarker);
    }

    // Pindah view peta ke negara tersebut
    weatherMap.setView([country.lat, country.lng], 4);

    fetch(`/api/weather?code=${code}`)
        .then(res => res.json())
        .then(data => {
            const weather = data.weather;
            if (!weather) {
                alert("Failed to load weather data.");
                return;
            }

            let icon = '☀️';
            let alertMsg = '';
            const wcode = weather.weathercode;
            const wind = weather.windspeed;

            if (wcode >= 51 && wcode <= 67) { icon = '🌧️'; alertMsg = 'Hujan'; }
            else if (wcode >= 71 && wcode <= 77) { icon = '❄️'; alertMsg = 'Salju'; }
            else if (wcode >= 80 && wcode <= 99) { icon = '⛈️'; alertMsg = 'Badai Petir'; }
            
            if (wind > 40) {
                alertMsg += (alertMsg ? ', ' : '') + 'Angin Kencang';
                icon = '🌪️';
            }

            if (alertMsg === '') alertMsg = 'Normal / Cerah';

            weatherMarker = L.marker([country.lat, country.lng], {
                icon: L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="font-size: 32px; filter: drop-shadow(0px 0px 4px rgba(0,0,0,0.5));">${icon}</div>`,
                    iconSize: [40, 50],
                    iconAnchor: [20, 50]
                })
            }).addTo(weatherMap);
            
            weatherMarker.bindPopup(`
                <div class="text-center">
                    <span class="fs-1">${icon}</span>
                    <h5 class="fw-bold mt-2">${country.flag} ${country.name}</h5>
                </div>
                <hr class="my-1">
                Kondisi: <strong class="${alertMsg !== 'Normal / Cerah' ? 'text-danger' : 'text-success'}">${alertMsg}</strong><br>
                Suhu: <strong>${Math.round(weather.temperature)}°C</strong><br>
                Angin: <strong>${wind} km/h</strong>
            `).openPopup();
        })
        .catch(err => {
            console.error(err);
            alert("Error fetching weather data.");
        });
}
</script>
@endpush
