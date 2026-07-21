@extends('layouts.app')

@section('title', 'Lacak Kargo - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">
        <i class="fas fa-box-open me-2" style="color: var(--accent-amber); filter: drop-shadow(0 0 8px rgba(251,191,36,0.4));"></i>Lacak Kargo
    </h2>
</div>

<div class="row justify-content-center mb-4">
    <div class="col-md-8 animate-in">
        <div class="card p-4" style="background: linear-gradient(135deg, rgba(17, 24, 39, 0.7) 0%, rgba(34, 211, 238, 0.1) 100%); border-color: rgba(34,211,238,0.2);">
            <h5 class="section-title mb-3 text-center">Masukkan Nomor Resi Kargo</h5>
            <form action="{{ route('tracking.search') }}" method="POST" class="d-flex">
                @csrf
                <input type="text" name="tracking_number" class="form-control form-control-lg me-2" placeholder="Contoh: RSK-20260721-001" required value="{{ request('tracking_number') ?? (isset($shipment) ? $shipment->tracking_number : '') }}" style="background: rgba(15,23,42,0.9);">
                <button type="submit" class="btn btn-primary px-4" style="background: var(--accent-blue); border: none; font-weight: 600; color: #0f172a;">
                    <i class="fas fa-search me-2"></i>Lacak
                </button>
            </form>
            @if(session('error'))
                <div class="alert alert-danger mt-3 mb-0" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444;">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>

@if(isset($shipment))
<div class="row g-4 mb-4">
    <div class="col-md-4 animate-in">
        <div class="card p-3 h-100">
            <h5 class="section-title mb-4">
                <i class="fas fa-info-circle me-2" style="color: var(--accent-cyan);"></i>Detail Pengiriman
            </h5>
            
            <div class="mb-4 text-center">
                <div class="text-muted small mb-1">Status Saat Ini</div>
                <h3 class="mb-0 fw-bold" style="color: {{ $shipment->status == 'Delivered' ? 'var(--accent-emerald)' : ($shipment->status == 'Delayed' ? 'var(--accent-rose)' : 'var(--accent-amber)') }}">
                    {{ strtoupper($shipment->status) }}
                </h3>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="text-center w-45">
                        <div class="text-muted small">Asal</div>
                        <div class="fw-bold fs-4">{{ $shipment->origin_country }}</div>
                    </div>
                    <div class="text-muted text-center" style="flex:1;">
                        <i class="fas fa-ship fa-2x" style="color: var(--accent-cyan); opacity:0.8;"></i>
                    </div>
                    <div class="text-center w-45">
                        <div class="text-muted small">Tujuan</div>
                        <div class="fw-bold fs-4">{{ $shipment->destination_country }}</div>
                    </div>
                </div>
            </div>

            <h6 class="border-bottom border-secondary pb-2 mb-3 mt-4" style="border-color: rgba(255,255,255,0.1) !important;">Riwayat Perjalanan (Timeline)</h6>
            <div class="timeline ps-3 border-start border-secondary" style="position: relative; border-color: rgba(255,255,255,0.1) !important;">
                @forelse($shipment->logs as $log)
                <div class="mb-3 position-relative">
                    <div class="position-absolute" style="left: -21px; top: 2px;">
                        <i class="fas fa-circle" style="font-size: 0.6rem; color: var(--accent-blue);"></i>
                    </div>
                    <div class="text-muted small">{{ $log->recorded_at->format('d M Y, H:i') }}</div>
                    <div class="fw-bold text-light">{{ $log->location_name }}</div>
                    <div class="small mt-1" style="color: var(--text-secondary);">{{ $log->status_message }}</div>
                </div>
                @empty
                <div class="text-muted small">Belum ada riwayat perjalanan.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-8 animate-in" style="animation-delay: 0.1s;">
        <div class="card p-3 h-100 d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="section-title mb-0">
                    <i class="fas fa-map-marked-alt me-2" style="color: var(--accent-emerald);"></i>Peta Lokasi Terkini
                </h5>
                <span class="badge bg-dark border text-light" style="border-color: rgba(255,255,255,0.2) !important;">
                    <i class="fas fa-crosshairs me-1 text-cyan"></i> {{ $shipment->current_lat ?? '-' }}, {{ $shipment->current_lng ?? '-' }}
                </span>
            </div>
            
            @if($shipment->current_lat && $shipment->current_lng)
            <div id="trackingMap" class="flex-grow-1" style="min-height: 450px; border-radius: 12px; z-index: 1;"></div>
            @else
            <div class="flex-grow-1 d-flex align-items-center justify-content-center" style="min-height: 450px; background: rgba(15,23,42,0.5); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.2);">
                <div class="text-muted text-center">
                    <i class="fas fa-satellite-dish fa-3x mb-3" style="opacity: 0.3;"></i>
                    <p>Lokasi GPS belum tersedia untuk kargo ini.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if(isset($shipment) && $shipment->current_lat && $shipment->current_lng)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $shipment->current_lat }};
    const lng = {{ $shipment->current_lng }};
    
    const map = L.map('trackingMap').setView([lat, lng], 5);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; OSM &copy; CARTO'
    }).addTo(map);

    // Marker kapal
    const shipIcon = L.divIcon({
        className: 'custom-div-icon',
        html: '<div style="background-color: var(--accent-amber); width: 16px; height: 16px; border-radius: 50%; border: 3px solid #1e293b; box-shadow: 0 0 15px rgba(251,191,36,0.8);"></div>',
        iconSize: [16, 16],
        iconAnchor: [8, 8]
    });

    const marker = L.marker([lat, lng], {icon: shipIcon}).addTo(map);
    
    // Fetch cuaca di lokasi kapal
    fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lng}&current_weather=true`)
        .then(res => res.json())
        .then(data => {
            if(data.current_weather) {
                const w = data.current_weather;
                
                // Decode weathercode
                const code = w.weathercode;
                let icon = '🌤️';
                if (code >= 0 && code <= 1) icon = '☀️';
                else if (code >= 2 && code <= 3) icon = '⛅';
                else if (code >= 45 && code <= 48) icon = '🌫️';
                else if (code >= 51 && code <= 67) icon = '🌧️';
                else if (code >= 71 && code <= 77) icon = '❄️';
                else if (code >= 80 && code <= 99) icon = '⛈️';
                
                marker.bindPopup(`
                    <div style="text-align:center; padding: 5px;">
                        <div style="font-weight: bold; margin-bottom: 5px; color: #38bdf8;">Kargo Anda di Sini</div>
                        <div style="font-size: 24px; line-height: 1;">${icon}</div>
                        <div style="font-size: 16px; font-weight: bold; margin-top: 5px;">${w.temperature}°C</div>
                        <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">Angin: ${w.windspeed} km/h</div>
                    </div>
                `, {
                    closeButton: false,
                    className: 'dark-popup'
                }).openPopup();
            }
        }).catch(e => console.error("Error fetching weather:", e));
        
    setTimeout(() => { map.invalidateSize(); }, 500);
});
</script>
<style>
.dark-popup .leaflet-popup-content-wrapper {
    background: rgba(15, 23, 42, 0.95);
    color: #f8fafc;
    border: 1px solid rgba(255,255,255,0.1);
}
.dark-popup .leaflet-popup-tip {
    background: rgba(15, 23, 42, 0.95);
}
</style>
@endif
@endpush