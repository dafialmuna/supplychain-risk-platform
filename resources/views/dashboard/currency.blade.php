@extends('layouts.app')

@section('title', 'Currency Impact Dashboard - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-money-bill-wave me-2 text-primary"></i>Currency Impact Dashboard</h2>
    <span class="text-muted" style="font-size: 0.85rem;">
        <i class="far fa-clock me-1"></i>{{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 h-100">
            <h5 class="mb-3">Select Base Currency</h5>
            <select id="baseCurrency" class="form-select mb-3">
                @foreach($currencies as $curr)
                    <option value="{{ $curr->currency }}" {{ $curr->currency == 'USD' ? 'selected' : '' }}>
                        {{ $curr->currency }} - {{ $curr->currency_name }}
                    </option>
                @endforeach
            </select>

            <h5 class="mb-3">Select Target Currency</h5>
            <select id="targetCurrency" class="form-select mb-3">
                @foreach($currencies as $curr)
                    <option value="{{ $curr->currency }}" {{ $curr->currency == 'EUR' ? 'selected' : '' }}>
                        {{ $curr->currency }} - {{ $curr->currency_name }}
                    </option>
                @endforeach
            </select>

            <div class="mt-auto pt-3 border-top text-center">
                <div class="kpi-label">Current Exchange Rate</div>
                <h3 id="currentRate" class="text-primary mt-2">-</h3>
                <small class="text-muted" id="rateDetail">-</small>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-3 h-100">
            <h5><i class="fas fa-chart-area me-2"></i>Grafik Perubahan Kurs (30 Hari Terakhir)</h5>
            <div style="height: 300px;">
                <canvas id="currencyChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currencyChart;

    function loadCurrencyData() {
        const base = document.getElementById('baseCurrency').value;
        const target = document.getElementById('targetCurrency').value;

        if (base === target) {
            document.getElementById('currentRate').textContent = '1.0000';
            document.getElementById('rateDetail').textContent = `1 ${base} = 1 ${target}`;
            return;
        }

        // Fetch current rate and historical trend
        fetch(`/api/currency/trend?base=${base}&target=${target}&days=30`)
            .then(res => res.json())
            .then(data => {
                const points = data.points;
                if (!points || points.length === 0) return;

                const latestRate = points[points.length - 1].rate;
                document.getElementById('currentRate').textContent = latestRate;
                document.getElementById('rateDetail').textContent = `1 ${base} = ${latestRate} ${target}`;

                const labels = points.map(p => p.date);
                const values = points.map(p => p.rate);

                updateChart(labels, values, target);
            })
            .catch(err => console.error(err));
    }

    function updateChart(labels, data, target) {
        const ctx = document.getElementById('currencyChart').getContext('2d');
        if (currencyChart) {
            currencyChart.destroy();
        }

        currencyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: `Exchange Rate to ${target}`,
                    data: data,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.2,
                    fill: true
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
                        beginAtZero: false
                    }
                }
            }
        });
    }

    document.getElementById('baseCurrency').addEventListener('change', loadCurrencyData);
    document.getElementById('targetCurrency').addEventListener('change', loadCurrencyData);

    loadCurrencyData();
});
</script>
@endpush