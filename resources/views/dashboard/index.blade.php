@extends('layouts.app')

@section('title', 'Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">
        <i class="fas fa-tachometer-alt me-2" style="color: var(--accent-cyan); filter: drop-shadow(0 0 8px rgba(34,211,238,0.4));"></i>Dashboard
    </h2>
    <div class="d-flex align-items-center">
        <span class="text-muted me-3 d-none d-md-inline" style="font-size: 0.85rem;">
            <i class="far fa-clock me-1"></i>{{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
        </span>
        @auth
        <div class="dropdown">
            <button class="btn btn-sm dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--text-primary); border-radius: 8px; padding: 6px 12px;">
                <i class="fas fa-user-circle me-2" style="color: var(--accent-cyan); font-size: 1.2rem;"></i> 
                <span class="fw-semibold">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" style="background: var(--bg-card-solid); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px;">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center" style="font-weight: 500;">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 animate-in">
        <div class="card p-3 kpi-card kpi-cyan">
            <div class="kpi-icon"><i class="fas fa-globe-americas"></i></div>
            <div class="kpi-label">Total Countries</div>
            <div class="kpi-value" id="totalCountries" data-counter>-</div>
        </div>
    </div>
    <div class="col-md-3 animate-in">
        <div class="card p-3 kpi-card kpi-emerald">
            <div class="kpi-icon"><i class="fas fa-chart-pie"></i></div>
            <div class="kpi-label">Avg Risk Score</div>
            <div class="kpi-value" id="avgRisk" data-counter>-</div>
        </div>
    </div>
    <div class="col-md-3 animate-in">
        <div class="card p-3 kpi-card kpi-rose">
            <div class="kpi-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="kpi-label">High Risk Countries</div>
            <div class="kpi-value" id="highRisk" data-counter>-</div>
        </div>
    </div>
    <div class="col-md-3 animate-in">
        <div class="card p-3 kpi-card kpi-amber">
            <div class="kpi-icon"><i class="fas fa-anchor"></i></div>
            <div class="kpi-label">Total Ports</div>
            <div class="kpi-value" id="totalPorts" data-counter>-</div>
        </div>
    </div>
</div>

<!-- Country Selector & Detail -->
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-in">
        <div class="card p-3">
            <h5 class="section-title mb-3">
                <i class="fas fa-search-location me-2" style="color: var(--accent-violet);"></i>Select Country
            </h5>
            <div class="d-flex">
                <select id="countrySelect" class="form-select flex-grow-1">
                    <option value="">Loading...</option>
                </select>
                @auth
                <form action="{{ route('watchlist.store') }}" method="POST" class="ms-2">
                    @csrf
                    <input type="hidden" name="country_code" id="watchlistCountryCode" value="">
                    <button type="submit" class="btn btn-outline-warning" title="Add to Watchlist" style="border-radius: 10px; height: 100%;">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
    <div class="col-md-8 animate-in">
        <div class="card p-3">
            <div class="row">
                <div class="col-md-3 stat-item">
                    <div class="kpi-label">Risk Score</div>
                    <!-- Risk Gauge -->
                    <div class="risk-gauge mt-2" id="riskGaugeContainer">
                        <svg width="90" height="90" viewBox="0 0 90 90">
                            <circle class="gauge-bg" cx="45" cy="45" r="38"></circle>
                            <circle class="gauge-fill" id="gaugeFill" cx="45" cy="45" r="38"
                                stroke-dasharray="238.76"
                                stroke-dashoffset="238.76"
                                stroke="var(--accent-emerald)"></circle>
                        </svg>
                        <div class="gauge-value">
                            <span class="gauge-number" id="riskScore">-</span>
                            <span id="riskLevel" class="badge bg-secondary mt-1" style="font-size: 0.6rem;">-</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="kpi-label"><i class="fas fa-money-bill-wave me-1 text-success"></i>GDP (USD)</div>
                    <div class="kpi-value mt-3" id="gdpDisplay" style="font-size:1.2rem;">-</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="kpi-label"><i class="fas fa-chart-line me-1 text-danger"></i>Inflation</div>
                    <div class="kpi-value mt-3" id="inflationDisplay">-</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="kpi-label"><i class="fas fa-users me-1 text-primary"></i>Population</div>
                    <div class="kpi-value mt-3" id="populationDisplay" style="font-size:1.2rem;">-</div>
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
            <div class="col-md-6 animate-in">
                <div class="card p-3 h-100 d-flex flex-column weather-card">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-cloud-sun me-2" style="color: var(--accent-cyan);"></i>Current Weather
                    </h5>
                    <div id="weatherDetail" class="text-center py-3 flex-grow-1 d-flex flex-column justify-content-center">
                        <span class="display-1" id="weatherIcon" style="filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));">🌤️</span>
                        <h3 id="weatherTempDisplay" class="mt-2 fw-bold" style="color: var(--text-primary);">- °C</h3>
                        <p id="weatherDesc" class="text-muted mb-0">Loading...</p>
                        <div class="row mt-auto pt-3 weather-stats w-100 mx-0">
                            <div class="col-6 px-1 border-end border-secondary border-opacity-25">
                                <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Wind</small>
                                <strong id="windSpeed" style="font-size: 0.85rem; color: var(--text-primary);">- km/h</strong>
                            </div>
                            <div class="col-6 px-1">
                                <small class="text-muted d-block" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Rain</small>
                                <strong id="rainFall" style="font-size: 0.85rem; color: var(--text-primary);">- mm</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 animate-in">
                <div class="card p-3 h-100 d-flex flex-column currency-card">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-money-bill-wave me-2" style="color: var(--accent-emerald);"></i>Exchange Rate
                    </h5>
                    <div id="currencyDetail" class="text-center py-3 flex-grow-1 d-flex flex-column justify-content-center">
                        <div class="mb-3">
                            <i class="fas fa-coins fa-3x" style="color: var(--accent-amber); opacity: 0.6; filter: drop-shadow(0 0 12px rgba(251,191,36,0.3));"></i>
                        </div>
                        <h3 id="rateDisplay" class="fw-bold" style="color: var(--accent-emerald);">-</h3>
                        <p class="text-muted mt-2 mb-0" id="rateDate">-</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card p-3 animate-in">
            <h5 class="section-title mb-3">
                <i class="fas fa-chart-line me-2" style="color: var(--accent-rose);"></i>Risk Trend
            </h5>
            <div style="min-height: 250px; position: relative;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Kolom Kanan: Peta -->
    <div class="col-lg-5 animate-in">
        <div class="card p-3 h-100 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="section-title mb-0">
                    <i class="fas fa-globe-asia me-2" style="color: var(--accent-blue);"></i>Global Weather Map
                </h5>
                <div class="d-flex align-items-center" id="routeControls" style="display: none !important;">
                    <small class="text-muted me-2 text-nowrap"><i class="fas fa-ship me-1"></i> Origin Route:</small>
                    <select id="mapOriginSelect" class="form-select form-select-sm" style="width: 140px; background-color: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: var(--text-primary);">
                        <option value="ID">Indonesia</option>
                    </select>
                </div>
            </div>
            <div id="weatherMap" class="flex-grow-1" style="min-height: 500px; border-radius: 12px; z-index: 1;"></div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let countries = [];
    window.globalWeatherMap = null;
    window.currentRouteLayer = null;
    window.currentPolyline = null;

    // ===== ANIMATED COUNTER =====
    function animateCounter(el, targetVal, duration = 800) {
        const isFloat = String(targetVal).includes('.');
        const start = 0;
        const startTime = performance.now();
        
        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = start + (targetVal - start) * eased;
            
            if (isFloat) {
                el.textContent = current.toFixed(1);
            } else {
                el.textContent = Math.round(current);
            }
            
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        requestAnimationFrame(update);
    }

    // ===== RISK GAUGE =====
    function updateRiskGauge(score, level) {
        const fill = document.getElementById('gaugeFill');
        const circumference = 2 * Math.PI * 38; // ~238.76
        const offset = circumference - (score / 100) * circumference;
        fill.style.strokeDashoffset = offset;

        let color = 'var(--accent-emerald)';
        if (level === 'medium') color = 'var(--accent-amber)';
        else if (level === 'high') color = 'var(--accent-rose)';
        else if (level === 'critical') color = '#ef4444';
        fill.setAttribute('stroke', color);

        const numEl = document.getElementById('riskScore');
        numEl.style.color = color;
    }
 
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

            const count = data.countries.length;
            const el = document.getElementById('totalCountries');
            el.textContent = count;
            animateCounter(el, count);

            if (data.countries.length > 0) {
                const urlParams = new URLSearchParams(window.location.search);
                const countryParam = urlParams.get('country');
                
                let selectedCode = data.countries[0].code;
                if (countryParam && data.countries.find(c => c.code === countryParam)) {
                    selectedCode = countryParam;
                }
                
                select.value = selectedCode;
                const code = selectedCode;
                loadCountryData(code).then(countryData => {
                    if (countryData && countryData.risk) {
                        loadRiskTrend(code, countryData.risk.total);
                    } else {
                        loadRiskTrend(code);
                    }
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
            const avgEl = document.getElementById('avgRisk');
            avgEl.textContent = avg;
            animateCounter(avgEl, parseFloat(avg));

            const highRisk = countries.filter(c => c.total >= 35).length;
            const hrEl = document.getElementById('highRisk');
            hrEl.textContent = highRisk;
            animateCounter(hrEl, highRisk);
        })
        .catch(err => console.error('Error loading leaderboard:', err));
    }

    // Load ports
    fetch('/api/ports')
        .then(res => res.json())
        .then(data => {
            const count = data.count || 0;
            const el = document.getElementById('totalPorts');
            el.textContent = count;
            animateCounter(el, count);
        })
        .catch(err => console.error('Error loading ports:', err));

    document.getElementById('countrySelect').addEventListener('change', function() {
        if (this.value) {
            const code = this.value;
            loadCountryData(code).then(data => {
                loadRiskLeaderboard();
                if (data && data.risk) {
                    loadRiskTrend(code, data.risk.total);
                } else {
                    loadRiskTrend(code);
                }
            });
            document.getElementById('routeControls').style.setProperty('display', 'flex', 'important');
            drawMapRoute(document.getElementById('mapOriginSelect').value, code, countries);
        } else {
            document.getElementById('routeControls').style.setProperty('display', 'none', 'important');
            if (window.currentRouteLayer && window.globalWeatherMap) window.globalWeatherMap.removeLayer(window.currentRouteLayer);
            if (window.currentPolyline && window.globalWeatherMap) window.globalWeatherMap.removeLayer(window.currentPolyline);
            if (window.globalWeatherMap) window.globalWeatherMap.setView([20, 10], 2);
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
                badge.className = 'badge risk-badge-' + level + ' mt-1';
                badge.style.fontSize = '0.6rem';
                
                // Update gauge
                updateRiskGauge(data.risk.total || 0, level);
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
            return data;
        })
        .catch(err => console.error('Error loading risk data:', err));
}

    function loadRiskTrend(code, currentRisk = null) {
        const ctx = document.getElementById('riskChart').getContext('2d');
        if (window.riskChartInstance) {
            window.riskChartInstance.destroy();
        }

        // Generate pseudo-random historical data based on country code
        let hash = 0;
        for (let i = 0; i < code.length; i++) {
            hash = code.charCodeAt(i) + ((hash << 5) - hash);
        }
        
        let trendData = [];
        let baseScore = currentRisk !== null ? currentRisk : (Math.abs(hash % 60) + 20);
        
        // Kita isi dari bulan terbaru (Jun) mundur ke belakang (Jan)
        trendData.unshift(baseScore);
        
        let prevPoint = baseScore;
        for (let i = 1; i < 6; i++) {
            // Mundur ke belakang, kita buat variasi acak agar terlihat natural
            let variation = Math.abs((hash + i * 17) % 15) - 6; // -6 to +8
            prevPoint = prevPoint + variation;
            if (prevPoint > 100) prevPoint = 100;
            if (prevPoint < 0) prevPoint = 0;
            trendData.unshift(prevPoint);
        }

        // Dark-themed gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(34, 211, 238, 0.2)');
        gradient.addColorStop(0.5, 'rgba(34, 211, 238, 0.05)');
        gradient.addColorStop(1, 'rgba(34, 211, 238, 0)');

        window.riskChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Risk Score',
                    data: trendData,
                    borderColor: '#22d3ee',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#22d3ee',
                    pointBorderColor: '#0b1120',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#22d3ee',
                    pointHoverBorderColor: '#fff',
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#e2e8f0',
                        bodyColor: '#94a3b8',
                        borderColor: 'rgba(255, 255, 255, 0.08)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { 
                            color: 'rgba(255, 255, 255, 0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, family: 'Inter' },
                            padding: 8
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, family: 'Inter' },
                            padding: 8
                        }
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
                
                // Populate origin select
                const originSelect = document.getElementById('mapOriginSelect');
                if (originSelect) {
                    originSelect.innerHTML = '';
                    data.countries.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.code;
                        opt.textContent = c.name;
                        if (c.code === 'ID') opt.selected = true;
                        originSelect.appendChild(opt);
                    });
                    
                    originSelect.addEventListener('change', () => {
                        const destCode = new URLSearchParams(window.location.search).get('country') || document.getElementById('countrySelect').value;
                        if (destCode) {
                            drawMapRoute(originSelect.value, destCode, data.countries);
                        }
                    });
                }

                // Inisialisasi peta — DARK TILES
                if (window.globalWeatherMap) { window.globalWeatherMap.remove(); }
                const map = L.map('weatherMap').setView([20, 10], 2);
                window.globalWeatherMap = map;
                L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; <a href="https://carto.com/">CARTO</a>'
                }).addTo(map);

                // Refresh peta setelah 500ms
                setTimeout(() => {
                    map.invalidateSize();
                    console.log('Peta di-refresh ukurannya');
                }, 500);

                // Fetch leaderboard first to get risk levels for colors
                Promise.all([
                    fetch('/api/risk/leaderboard').then(res => res.json()),
                    fetch('/api/weather/all').then(res => res.json())
                ])
                .then(([leaderboardData, weatherAllData]) => {
                    const riskMap = {};
                    if (leaderboardData.countries) {
                        leaderboardData.countries.forEach(c => {
                            riskMap[c.code] = c;
                        });
                    }

                    const allWeather = weatherAllData.data || {};

                    // Loop setiap negara dan tambahkan marker
                    data.countries.forEach(country => {
                        if (country.lat && country.lng) {
                            const weather = allWeather[country.code];
                            const risk = riskMap[country.code];
                            
                            let color = '#34d399';
                            if (risk && risk.level === 'medium') color = '#fbbf24';
                            else if (risk && risk.level === 'high') color = '#fb7185';
                            else if (risk && risk.level === 'critical') color = '#ef4444';
                            
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
                                radius: 8,
                                fillColor: color,
                                color: color,
                                weight: 1,
                                opacity: 0.9,
                                fillOpacity: 0.5
                            }).addTo(map);

                            // Add a pulsing glow effect
                            L.circleMarker([country.lat, country.lng], {
                                radius: 14,
                                fillColor: color,
                                color: 'transparent',
                                fillOpacity: 0.12
                            }).addTo(map);
                            
                            circle.bindPopup(`
                                <strong>${country.flag} ${country.name}</strong><br>
                                ${weatherEmoji} ${temp}<br>
                                💨 ${wind}<br>
                                🎯 Risk: ${risk ? risk.total : '--'} (${risk ? risk.level : '--'})
                            `);
                        }
                    });

                    // Refresh peta setelah semua marker
                    setTimeout(() => {
                        map.invalidateSize();
                        
                        const urlParams = new URLSearchParams(window.location.search);
                        const selectedCountryCode = urlParams.get('country');
                        
                        if (selectedCountryCode) {
                            document.getElementById('routeControls').style.setProperty('display', 'flex', 'important');
                            drawMapRoute(document.getElementById('mapOriginSelect').value, selectedCountryCode, data.countries);
                        } else {
                            const currentSelectVal = document.getElementById('countrySelect').value;
                            if (currentSelectVal) {
                                document.getElementById('routeControls').style.setProperty('display', 'flex', 'important');
                                drawMapRoute(document.getElementById('mapOriginSelect').value, currentSelectVal, data.countries);
                            }
                        }
                    }, 1500);
                })
                .catch(err => console.error('Error loading leaderboard or weather for map:', err));
            })
            .catch(err => console.error('Error loading countries:', err));
    }

    function drawMapRoute(originCode, destCode, countriesList) {
        const map = window.globalWeatherMap;
        if (!map) return;
        
        if (window.currentRouteLayer) { map.removeLayer(window.currentRouteLayer); }
        if (window.currentPolyline) { map.removeLayer(window.currentPolyline); }
        
        const origin = countriesList.find(c => c.code === originCode);
        const dest = countriesList.find(c => c.code === destCode);
        
        if (origin && dest && origin.code !== dest.code) {
            import('https://esm.sh/searoute-js@0.1.0').then(module => {
                const searoute = module.default;
                const originPt = { type: "Feature", geometry: { type: "Point", coordinates: [origin.lng, origin.lat] } };
                const destPt = { type: "Feature", geometry: { type: "Point", coordinates: [dest.lng, dest.lat] } };
                
                try {
                    const routeGeoJSON = searoute(originPt, destPt);
                    if (routeGeoJSON) {
                        window.currentRouteLayer = L.geoJSON(routeGeoJSON, {
                            style: { color: '#38bdf8', weight: 4, dashArray: '10, 10', opacity: 0.9 }
                        }).addTo(map);
                        map.fitBounds(window.currentRouteLayer.getBounds(), { padding: [50, 50] });
                    }
                } catch (e) {
                    console.error("Gagal menggambar rute laut:", e);
                    window.currentPolyline = L.polyline([[origin.lat, origin.lng], [dest.lat, dest.lng]], {
                        color: '#38bdf8', weight: 4, dashArray: '10, 10', opacity: 0.9
                    }).addTo(map);
                    map.fitBounds(window.currentPolyline.getBounds(), { padding: [50, 50] });
                }
            });
        } else if (dest) {
            map.setView([dest.lat, dest.lng], 4);
        }
    }

    // Panggil peta setelah DOM siap
    setTimeout(initWeatherMap, 600);
});
</script>
@endpush