@extends('layouts.app')

@section('title', 'Country Comparison - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-balance-scale me-2 text-primary"></i>Country Comparison Engine</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
</div>

<div class="row g-4 mb-4">
    <!-- Country A -->
    <div class="col-md-6">
        <div class="card p-3 shadow-sm border-0">
            <label class="form-label fw-bold">Select Country A</label>
            <select id="countryA" class="form-select mb-3">
                <option value="">Loading...</option>
            </select>
            
            <div id="dataA" style="display:none;">
                <div class="text-center mb-4 border-bottom pb-3">
                    <span id="flagA" class="display-1"></span>
                    <h3 id="nameA" class="mt-2">-</h3>
                    <div class="badge bg-secondary" id="levelA">-</div>
                </div>
                
                <table class="table table-borderless" style="--bs-table-bg: transparent; --bs-table-color: var(--text-primary);">
                    <tbody>
                        <tr>
                            <td class="text-muted">GDP (USD)</td>
                            <td class="text-end fw-bold" id="gdpA">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Inflation</td>
                            <td class="text-end fw-bold" id="infA">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Population</td>
                            <td class="text-end fw-bold" id="popA">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Weather</td>
                            <td class="text-end fw-bold" id="weaA">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Exchange Rate (USD)</td>
                            <td class="text-end fw-bold" id="excA">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Risk Score</td>
                            <td class="text-end fw-bold fs-4 text-primary" id="riskA">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Country B -->
    <div class="col-md-6">
        <div class="card p-3 shadow-sm border-0">
            <label class="form-label fw-bold">Select Country B</label>
            <select id="countryB" class="form-select mb-3">
                <option value="">Loading...</option>
            </select>
            
            <div id="dataB" style="display:none;">
                <div class="text-center mb-4 border-bottom pb-3">
                    <span id="flagB" class="display-1"></span>
                    <h3 id="nameB" class="mt-2">-</h3>
                    <div class="badge bg-secondary" id="levelB">-</div>
                </div>
                
                <table class="table table-borderless" style="--bs-table-bg: transparent; --bs-table-color: var(--text-primary);">
                    <tbody>
                        <tr>
                            <td class="text-muted">GDP (USD)</td>
                            <td class="text-end fw-bold" id="gdpB">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Inflation</td>
                            <td class="text-end fw-bold" id="infB">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Population</td>
                            <td class="text-end fw-bold" id="popB">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Weather</td>
                            <td class="text-end fw-bold" id="weaB">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Exchange Rate (USD)</td>
                            <td class="text-end fw-bold" id="excB">-</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Risk Score</td>
                            <td class="text-end fw-bold fs-4 text-primary" id="riskB">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let countryList = [];

document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/countries')
        .then(res => res.json())
        .then(data => {
            countryList = data.countries;
            const selectA = document.getElementById('countryA');
            const selectB = document.getElementById('countryB');
            
            selectA.innerHTML = '<option value="">-- Choose Country A --</option>';
            selectB.innerHTML = '<option value="">-- Choose Country B --</option>';

            countryList.forEach(c => {
                const optA = document.createElement('option');
                optA.value = c.code;
                optA.textContent = c.flag + ' ' + c.name;
                selectA.appendChild(optA);

                const optB = document.createElement('option');
                optB.value = c.code;
                optB.textContent = c.flag + ' ' + c.name;
                selectB.appendChild(optB);
            });
        });

    document.getElementById('countryA').addEventListener('change', function() {
        if(this.value) loadCountryData(this.value, 'A');
    });

    document.getElementById('countryB').addEventListener('change', function() {
        if(this.value) loadCountryData(this.value, 'B');
    });
});

function loadCountryData(code, side) {
    const country = countryList.find(c => c.code === code);
    
    document.getElementById(`flag${side}`).textContent = country.flag;
    document.getElementById(`name${side}`).textContent = country.name;
    document.getElementById(`data${side}`).style.display = 'block';

    fetch(`/api/risk?code=${code}`)
        .then(res => res.json())
        .then(data => {
            const risk = data.risk || {};
            
            const badge = document.getElementById(`level${side}`);
            badge.textContent = (risk.level || 'Unknown').toUpperCase();
            badge.className = 'badge ' + (risk.level ? 'risk-badge-' + risk.level : 'bg-secondary');

            let gdpDisplay = '-';
            if (data.gdp) {
                if (data.gdp >= 1e12) gdpDisplay = '$' + (data.gdp / 1e12).toFixed(2) + 'T';
                else if (data.gdp >= 1e9) gdpDisplay = '$' + (data.gdp / 1e9).toFixed(2) + 'B';
                else gdpDisplay = '$' + data.gdp;
            }
            document.getElementById(`gdp${side}`).textContent = gdpDisplay;
            
            document.getElementById(`inf${side}`).textContent = data.inflation ? data.inflation.toFixed(2) + '%' : '-';
            
            let popDisplay = '-';
            if (data.population) {
                if (data.population >= 1e9) popDisplay = (data.population / 1e9).toFixed(2) + 'B';
                else if (data.population >= 1e6) popDisplay = (data.population / 1e6).toFixed(2) + 'M';
                else popDisplay = data.population;
            }
            document.getElementById(`pop${side}`).textContent = popDisplay;

            document.getElementById(`wea${side}`).textContent = data.weather ? `${Math.round(data.weather.temperature)}°C` : '-';
            
            document.getElementById(`exc${side}`).textContent = data.exchange_rate ? `1 USD = ${data.exchange_rate.rate} ${data.exchange_rate.target}` : '-';
            
            document.getElementById(`risk${side}`).textContent = risk.total || '-';
        })
        .catch(err => console.error(err));
}
</script>
@endpush
