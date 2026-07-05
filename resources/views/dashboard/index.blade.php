@extends('layouts.app')

@section('title', 'Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3">
            <div class="kpi-label">Total Countries</div>
            <div class="kpi-value" id="totalCountries">-</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="kpi-label">Avg Risk Score</div>
            <div class="kpi-value" id="avgRisk">-</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="kpi-label">High Risk Countries</div>
            <div class="kpi-value" id="highRisk">-</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3">
            <div class="kpi-label">Total Ports</div>
            <div class="kpi-value" id="totalPorts">-</div>
        </div>
    </div>
</div>

<!-- Country Selector & Detail -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h5 class="mb-3">Select Country</h5>
            <div class="d-flex">
                <select id="countrySelect" class="form-select flex-grow-1">
                    <option value="">Loading...</option>
                </select>
                @auth
                <form action="{{ route('watchlist.store') }}" method="POST" class="ms-2">
                    @csrf
                    <input type="hidden" name="country_code" id="watchlistCountryCode" value="">
                    <button type="submit" class="btn btn-outline-warning" title="Add to Watchlist">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="kpi-label">Risk Score</div>
                    <div class="kpi-value" id="riskScore">-</div>
                    <span id="riskLevel" class="badge bg-secondary">-</span>
                </div>
                <div class="col-md-3 text-center">
                    <div class="kpi-label">GDP (USD)</div>
                    <div class="kpi-value" id="gdpDisplay" style="font-size:1.2rem;">-</div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="kpi-label">Inflation</div>
                    <div class="kpi-value" id="inflationDisplay">-</div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="kpi-label">Population</div>
                    <div class="kpi-value" id="populationDisplay" style="font-size:1.2rem;">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Layout: Kiri (Cuaca, Kurs, Grafik) & Kanan (Peta) -->
<div class="row g-3 mb-4">
    <!-- Kolom Kiri: Cuaca, Kurs, dan Tren -->
    <div class="col-lg-7">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="card p-3 h-100 d-flex flex-column">
                    <h5 class="mb-0"><i class="fas fa-cloud-sun me-2 text-info"></i>Current Weather</h5>
                    <div id="weatherDetail" class="text-center py-3 flex-grow-1 d-flex flex-column justify-content-center">
                        <span class="display-1" id="weatherIcon">🌤️</span>
                        <h3 id="weatherTempDisplay" class="mt-2 fw-bold">- °C</h3>
                        <p id="weatherDesc" class="text-muted mb-0">Loading...</p>
                        <div class="row mt-auto pt-3 border-top w-100 mx-0">
                            <div class="col-4 px-1">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Wind</small>
                                <strong id="windSpeed" style="font-size: 0.85rem;">- km/h</strong>
                            </div>
                            <div class="col-4 px-1 border-start border-end">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Rain</small>
                                <strong id="rainFall" style="font-size: 0.85rem;">- mm</strong>
                            </div>
                            <div class="col-4 px-1">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Humidity</small>
                                <strong id="humidity" style="font-size: 0.85rem;">- %</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 h-100 d-flex flex-column">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2 text-success"></i>Exchange Rate</h5>
                    <div id="currencyDetail" class="text-center py-3 flex-grow-1 d-flex flex-column justify-content-center">
                        <div class="mb-3">
                            <i class="fas fa-coins fa-3x text-warning opacity-75"></i>
                        </div>
                        <h3 id="rateDisplay" class="text-primary fw-bold">-</h3>
                        <p class="text-muted mt-2 mb-0" id="rateDate">-</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card p-3">
            <h5 class="mb-3"><i class="fas fa-chart-line me-2 text-danger"></i>Risk Trend</h5>
            <div style="min-height: 250px; position: relative;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Kolom Kanan: Peta -->
    <div class="col-lg-5">
        <div class="card p-3 h-100 d-flex flex-column">
            <h5 class="mb-3"><i class="fas fa-globe-asia me-2 text-primary"></i>Peta Cuaca Global</h5>
            <div id="weatherMap" class="flex-grow-1" style="min-height: 500px; border-radius: 12px; z-index: 1;"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let countries = [];
 
    // Load countries
    fetch('/api/countries')
        .then(res => res.json())
        .then(data => {
            countries = data.countries;
            const select = document.getElementById('countrySelect');
            select.innerHTML = '';
            data.countries.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.code;
                opt.textContent = c.flag + ' ' + c.name;
                select.appendChild(opt);
            });

            document.getElementById('totalCountries').textContent = data.countries.length;
            if (data.countries.length > 0) {
                select.value = data.countries[0].code;
                loadCountryData(data.countries[0].code).then(() => {
                    loadRiskTrend(data.countries[0].code);
                    loadRiskLeaderboard();
                });
            }
        })
        .catch(err => console.error('Error loading countries:', err));

    function loadRiskLeaderboard() {
        fetch('/api/risk/leaderboard')
        .then(res => res.json())
        .then(data => {
            const countries = data.countries || [];
            const total = countries.length;
            if (total === 0) return;
            const sum = countries.reduce((acc, c) => acc + c.total, 0);
            const avg = (sum / total).toFixed(1);
            document.getElementById('avgRisk').textContent = avg;
            const highRisk = countries.filter(c => c.total >= 35).length;
            document.getElementById('highRisk').textContent = highRisk;
        })
        .catch(err => console.error('Error loading leaderboard:', err));
    }

    // Load ports
    fetch('/api/ports')
        .then(res => res.json())
        .then(data => {
            document.getElementById('totalPorts').textContent = data.count || 0;
        })
        .catch(err => console.error('Error loading ports:', err));

    document.getElementById('countrySelect').addEventListener('change', function() {
        if (this.value) {
            loadCountryData(this.value).then(() => {
                loadRiskLeaderboard();
            });
            loadRiskTrend(this.value);
        }
    });

    function loadCountryData(code) {
    console.log('Loading data for:', code);
    
    // Update hidden input for watchlist
    const watchlistInput = document.getElementById('watchlistCountryCode');
    if (watchlistInput) watchlistInput.value = code;

    return fetch(`/api/risk?code=${code}`)
        .then(res => res.json())
        .then(data => {
            console.log('Data received:', data);
            
            // === TAMPILKAN RISK SCORE ===
            if (data.risk) {
                document.getElementById('riskScore').textContent = data.risk.total || '-';
                const level = data.risk.level || 'unknown';
                const badge = document.getElementById('riskLevel');
                badge.textContent = level.toUpperCase();
                badge.className = 'badge risk-badge-' + level;
            }
            
            // === TAMPILKAN GDP ===
            if (data.gdp) {
                const gdp = data.gdp;
                let display = gdp;
                let suffix = '';
                if (gdp >= 1e12) { display = (gdp / 1e12).toFixed(2); suffix = 'T'; }
                else if (gdp >= 1e9) { display = (gdp / 1e9).toFixed(2); suffix = 'B'; }
                else if (gdp >= 1e6) { display = (gdp / 1e6).toFixed(2); suffix = 'M'; }
                document.getElementById('gdpDisplay').textContent = '$' + display + suffix;
            } else {
                document.getElementById('gdpDisplay').textContent = '-';
            }
            
            // === TAMPILKAN INFLASI ===
            if (data.inflation) {
                document.getElementById('inflationDisplay').textContent = data.inflation.toFixed(2) + '%';
            } else {
                document.getElementById('inflationDisplay').textContent = '-';
            }
            
            // === TAMPILKAN POPULASI ===
            if (data.population) {
                const pop = data.population;
                let display = pop;
                let suffix = '';
                if (pop >= 1e9) { display = (pop / 1e9).toFixed(2); suffix = 'B'; }
                else if (pop >= 1e6) { display = (pop / 1e6).toFixed(2); suffix = 'M'; }
                document.getElementById('populationDisplay').textContent = display + suffix;
            } else {
                document.getElementById('populationDisplay').textContent = '-';
            }
            
            // === TAMPILKAN CUACA ===
            if (data.weather) {
                const w = data.weather;
                const temp = w.temperature || 0;
                document.getElementById('weatherTempDisplay').textContent = temp + ' °C';
                
                const code = w.weathercode || 0;
                let icon = '🌤️';
                if (code >= 0 && code <= 1) icon = '☀️';
                else if (code >= 2 && code <= 3) icon = '⛅';
                else if (code >= 45 && code <= 48) icon = '🌫️';
                else if (code >= 51 && code <= 67) icon = '🌧️';
                else if (code >= 71 && code <= 77) icon = '❄️';
                else if (code >= 80 && code <= 99) icon = '⛈️';
                document.getElementById('weatherIcon').textContent = icon;
                
                const desc = {
                    0: 'Clear sky', 1: 'Mainly clear', 2: 'Partly cloudy', 3: 'Overcast',
                    45: 'Fog', 48: 'Depositing rime fog',
                    51: 'Light drizzle', 53: 'Moderate drizzle', 55: 'Dense drizzle',
                    61: 'Light rain', 63: 'Moderate rain', 65: 'Heavy rain',
                    71: 'Light snow', 73: 'Moderate snow', 75: 'Heavy snow',
                    80: 'Light rain showers', 81: 'Moderate rain showers', 82: 'Violent rain showers',
                    95: 'Thunderstorm', 96: 'Thunderstorm with hail'
                };
                document.getElementById('weatherDesc').textContent = desc[code] || 'Unknown';
                document.getElementById('windSpeed').textContent = (w.windspeed || 0) + ' km/h';
                document.getElementById('rainFall').textContent = (w.precipitation || 0) + ' mm';
            } else {
                document.getElementById('weatherTempDisplay').textContent = '- °C';
                document.getElementById('weatherIcon').textContent = '🌤️';
                document.getElementById('weatherDesc').textContent = 'No weather data';
                document.getElementById('windSpeed').textContent = '- km/h';
                document.getElementById('rainFall').textContent = '- mm';
            }
            
            // === TAMPILKAN KURS ===
            if (data.exchange_rate) {
                const rate = data.exchange_rate;
                document.getElementById('rateDisplay').textContent = '1 USD = ' + (rate.rate || '-') + ' ' + (rate.target || '');
                document.getElementById('rateDate').textContent = rate.date || '';
            } else {
                document.getElementById('rateDisplay').textContent = 'No rate data';
            }
        })
        .catch(err => console.error('Error loading risk data:', err));
}

    function loadRiskTrend(code) {
        const ctx = document.getElementById('riskChart').getContext('2d');
        if (window.riskChartInstance) {
            window.riskChartInstance.destroy();
        }
        window.riskChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Risk Score',
                    data: [35, 32, 28, 25, 22, 20],
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#0d9488'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ===== PETA CUACA GLOBAL (DIPERBAIKI) =====
    function initWeatherMap() {
        console.log('Inisialisasi peta...');
        const container = document.getElementById('weatherMap');
        if (!container) {
            console.error('Container #weatherMap tidak ditemukan!');
            return;
        }

        // Kosongkan container
        container.innerHTML = '';

        fetch('/api/countries')
            .then(res => res.json())
            .then(data => {
                console.log('Data countries diterima:', data.countries.length);
                
                // Inisialisasi peta
                const map = L.map('weatherMap').setView([20, 10], 2);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Refresh peta setelah 500ms
                setTimeout(() => {
                    map.invalidateSize();
                    console.log('Peta di-refresh ukurannya');
                }, 500);

                // Fetch leaderboard first to get risk levels for colors
                fetch('/api/risk/leaderboard')
                    .then(res => res.json())
                    .then(leaderboardData => {
                        const riskMap = {};
                        if (leaderboardData.countries) {
                            leaderboardData.countries.forEach(c => {
                                riskMap[c.code] = c;
                            });
                        }

                        // Loop setiap negara dan tambahkan marker
                        data.countries.forEach(country => {
                            if (country.lat && country.lng) {
                                // Hanya panggil weather API, yang jauh lebih ringan daripada risk API (6 external calls)
                                fetch(`/api/weather?code=${country.code}`)
                                    .then(res => res.json())
                                    .then(weatherData => {
                                        const weather = weatherData.weather;
                                        const risk = riskMap[country.code];
                                        
                                        let color = 'green';
                                        if (risk && risk.level === 'medium') color = 'orange';
                                        else if (risk && risk.level === 'high') color = 'red';
                                        else if (risk && risk.level === 'critical') color = 'darkred';
                                        
                                        let weatherEmoji = '☀️';
                                        if (weather) {
                                            const code = weather.weathercode;
                                            if (code >= 0 && code <= 2) weatherEmoji = '☀️';
                                            else if (code >= 3 && code <= 5) weatherEmoji = '⛅';
                                            else if (code >= 10 && code <= 20) weatherEmoji = '🌧️';
                                            else if (code >= 30 && code <= 40) weatherEmoji = '🌫️';
                                            else if (code >= 60 && code <= 70) weatherEmoji = '🌧️';
                                            else if (code >= 80 && code <= 90) weatherEmoji = '⛈️';
                                            else if (code >= 95 && code <= 99) weatherEmoji = '⛈️';
                                        }
                                        const temp = weather ? `${Math.round(weather.temperature)}°C` : '--';
                                        const wind = weather ? `${weather.windspeed} km/h` : '--';
                                        
                                        const circle = L.circleMarker([country.lat, country.lng], {
                                            radius: 10,
                                            fillColor: color,
                                            color: '#fff',
                                            weight: 2,
                                            opacity: 1,
                                            fillOpacity: 0.7
                                        }).addTo(map);
                                        
                                        circle.bindPopup(`
                                            <strong>${country.flag} ${country.name}</strong><br>
                                            ${weatherEmoji} ${temp}<br>
                                            💨 ${wind}<br>
                                            🎯 Risk: ${risk ? risk.total : '--'} (${risk ? risk.level : '--'})
                                        `);
                                    })
                                    .catch(err => console.error('Error loading weather for', country.code, err));
                            }
                        });
                    })
                    .catch(err => console.error('Error loading leaderboard for map:', err));

                // Refresh peta setelah semua marker
                setTimeout(() => {
                    map.invalidateSize();
                    console.log('Peta di-refresh setelah marker');
                }, 1500);
            })
            .catch(err => console.error('Error loading countries:', err));
    }

    // Panggil peta setelah DOM siap
    setTimeout(initWeatherMap, 600);
});
</script>
@endpush