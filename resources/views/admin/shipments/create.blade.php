@extends('layouts.app')

@section('title', 'Buat Resi Baru - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0" style="font-weight: 800; letter-spacing: -0.5px;">Buat Resi Baru</h2>
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

    <form action="{{ route('admin.shipments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label text-muted">Nomor Resi (Tracking Number)</label>
            <input type="text" name="tracking_number" class="form-control" value="RSK-{{ date('Ymd') }}-{{ rand(100,999) }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label text-muted">Pemilik Kargo (Opsional)</label>
            <select name="user_id" class="form-select bg-dark text-light border-secondary">
                <option value="">-- Publik / Tanpa Pemilik --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            <small class="text-muted">Jika dipilih, user tersebut bisa melihat resi ini di menu Kargo Saya.</small>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Kode Negara Asal (2 Huruf)</label>
                <input type="text" name="origin_country" class="form-control" placeholder="Contoh: ID" required maxlength="2">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Kode Negara Tujuan (2 Huruf)</label>
                <input type="text" name="destination_country" class="form-control" placeholder="Contoh: US" required maxlength="2">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted">Status Awal</label>
            <select name="status" class="form-select bg-dark text-light border-secondary" required>
                <option value="Pending">Pending</option>
                <option value="In Transit">In Transit</option>
                <option value="Delayed">Delayed</option>
                <option value="Delivered">Delivered</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Kargo</button>
    </form>
</div>
@endsection