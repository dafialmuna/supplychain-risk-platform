@extends('layouts.app')

@section('title', 'Detail Resi - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">Log Resi: {{ $shipment->tracking_number }}</h2>
    <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

@if(session('success'))
<div class="alert alert-success bg-success bg-opacity-10 text-success border-success mb-4">
    {{ session('success') }}
</div>
@endif

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 h-100">
            <h5 class="section-title mb-4">Riwayat Perjalanan (Logs)</h5>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Pesan Status</th>
                            <th>Koordinat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipment->logs as $log)
                        <tr>
                            <td>{{ $log->recorded_at->format('d M Y, H:i') }}</td>
                            <td>{{ $log->location_name }}</td>
                            <td>{{ $log->status_message }}</td>
                            <td class="small text-muted">{{ $log->lat ?? '-' }}, {{ $log->lng ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada riwayat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card p-4 h-100 border-info" style="background: rgba(14,165,233,0.05);">
            <h5 class="section-title mb-4 text-info"><i class="fas fa-plus-circle me-2"></i>Tambah Log Baru</h5>
            
            <form action="{{ route('admin.shipments.addLog', $shipment->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted">Nama Lokasi (Contoh: Pelabuhan Tanjung Priok)</label>
                    <input type="text" name="location_name" class="form-control bg-dark text-light border-secondary" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Pesan Status (Contoh: Kapal bersandar)</label>
                    <input type="text" name="status_message" class="form-control bg-dark text-light border-secondary" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Latitude (Opsional)</label>
                        <input type="text" name="lat" class="form-control bg-dark text-light border-secondary" value="{{ $shipment->current_lat }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Longitude (Opsional)</label>
                        <input type="text" name="lng" class="form-control bg-dark text-light border-secondary" value="{{ $shipment->current_lng }}">
                    </div>
                </div>
                
                <small class="text-muted d-block mb-3">
                    <i class="fas fa-info-circle me-1"></i>Jika latitude & longitude diisi, posisi utama kargo di Peta Pelacakan otomatis akan terupdate ke koordinat ini.
                </small>

                <button type="submit" class="btn btn-info text-white w-100">
                    <i class="fas fa-save me-2"></i>Simpan Log
                </button>
            </form>
        </div>
    </div>
</div>
@endsection