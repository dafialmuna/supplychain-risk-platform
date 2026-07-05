@extends('layouts.app')

@section('title', 'Data Visualization Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2 text-primary"></i>Data Visualization Dashboard</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <label class="form-label fw-bold">Select Country for Trends</label>
        <select id="countrySelect" class="form-select">
            <option value="">Loading countries...</option>
        </select>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-3 h-100 shadow-sm border-0">
            <h5 class="text-center mb-3">GDP Trend (Simulated)</h5>
            <div style="height: 250px;">
                <canvas id="gdpChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 h-100 shadow-sm border-0">
            <h5 class="text-center mb-3">Inflation Trend (Simulated)</h5>
            <div style="height: 250px;">
                <canvas id="inflationChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 h-100 shadow-sm border-0">
            <h5 class="text-center mb-3">Currency Trend (Simulated)</h5>
            <div style="height: 250px;">
                <canvas id="currencyChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 h-100 shadow-sm border-0">
            <h5 class="text-center mb-3">Risk Score Trend (Simulated)</h5>
            <div style="height: 250px;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const charts = {};

document.addEventListener('DOMContentLoaded', function() {
    // Load countries
    fetch('/api/countries')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('countrySelect');
            select.innerHTML = '';
            data.countries.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.code;
                opt.textContent = c.flag + ' ' + c.name;
                select.appendChild(opt);
            });

            if (data.countries.length > 0) {
                select.value = data.countries[0].code;
                loadTrends(data.countries[0].code);
            }
        });

    document.getElementById('countrySelect').addEventListener('change', function() {
        if (this.value) {
            loadTrends(this.value);
        }
    });
});

function loadTrends(code) {
    // Generate simulated historical labels (e.g. 6 months)
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

    // In a real scenario, this would fetch from an API like `/api/trend?code=${code}`
    // For now, we simulate the data to fulfill the Chart.js requirement
    const gdpData = generateSimulatedData(6, 1000, 5000);
    const inflationData = generateSimulatedData(6, 1, 10);
    const currencyData = generateSimulatedData(6, 0.5, 2.0);
    const riskData = generateSimulatedData(6, 20, 80);

    updateChart('gdpChart', 'GDP', labels, gdpData, '#10b981');
    updateChart('inflationChart', 'Inflation (%)', labels, inflationData, '#ef4444');
    updateChart('currencyChart', 'Currency vs USD', labels, currencyData, '#3b82f6');
    updateChart('riskChart', 'Risk Score', labels, riskData, '#f59e0b');
}

function updateChart(canvasId, label, labels, data, color) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    
    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }

    charts[canvasId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: hexToRgbA(color, 0.1),
                tension: 0.3,
                fill: true,
                pointBackgroundColor: color
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
                    beginAtZero: false,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                }
            }
        }
    });
}

function generateSimulatedData(count, min, max) {
    const arr = [];
    for(let i = 0; i < count; i++) {
        arr.push(Number((Math.random() * (max - min) + min).toFixed(2)));
    }
    return arr;
}

function hexToRgbA(hex, alpha){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+alpha+')';
    }
    throw new Error('Bad Hex');
}
</script>
@endpush
