@extends('layouts.app')

@section('title', 'Edit Resi - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">Edit Resi: {{ $shipment->tracking_number }}</h2>
    <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card p-4 mx-auto" style="max-width: 600px;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.shipments.update', $shipment->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label text-muted">Nomor Resi (Tracking Number)</label>
            <input type="text" name="tracking_number" class="form-control" value="{{ old('tracking_number', $shipment->tracking_number) }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label text-muted">Pemilik Kargo</label>
            <select name="user_id" class="form-select bg-dark text-light border-secondary">
                <option value="">-- Publik / Tanpa Pemilik --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $shipment->user_id) == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Kode Negara Asal (2 Huruf)</label>
                <input type="text" name="origin_country" class="form-control" value="{{ old('origin_country', $shipment->origin_country) }}" required maxlength="2">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Kode Negara Tujuan (2 Huruf)</label>
                <input type="text" name="destination_country" class="form-control" value="{{ old('destination_country', $shipment->destination_country) }}" required maxlength="2">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted">Status</label>
            <select name="status" class="form-select bg-dark text-light border-secondary" required>
                <option value="Pending" {{ (old('status', $shipment->status) == 'Pending') ? 'selected' : '' }}>Pending</option>
                <option value="In Transit" {{ (old('status', $shipment->status) == 'In Transit') ? 'selected' : '' }}>In Transit</option>
                <option value="Delayed" {{ (old('status', $shipment->status) == 'Delayed') ? 'selected' : '' }}>Delayed</option>
                <option value="Delivered" {{ (old('status', $shipment->status) == 'Delivered') ? 'selected' : '' }}>Delivered</option>
            </select>
        </div>
        
        <hr class="border-secondary my-4">
        
        <h6 class="mb-3 text-info">Update Lokasi GPS Terakhir (Opsional)</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Latitude</label>
                <input type="text" name="current_lat" class="form-control" value="{{ old('current_lat', $shipment->current_lat) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Longitude</label>
                <input type="text" name="current_lng" class="form-control" value="{{ old('current_lng', $shipment->current_lng) }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Kargo</button>
    </form>
</div>
@endsection