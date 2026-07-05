@extends('layouts.app')
@section('title', 'Tambah Pelabuhan - Admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.ports.index') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Dataset Pelabuhan</a>
</div>

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4">Tambah Pelabuhan Baru</h3>

    <form action="{{ route('admin.ports.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama Pelabuhan</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipe Pelabuhan</label>
                <select name="type" class="form-select">
                    <option value="Seaport">Seaport</option>
                    <option value="River">River Port</option>
                    <option value="Airport">Airport</option>
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">Negara</label>
                <input type="text" name="country" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kode Negara (2 huruf)</label>
                <input type="text" name="country_code" class="form-control" maxlength="2" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Region (Opsional)</label>
                <input type="text" name="region" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Latitude</label>
                <input type="number" step="any" name="lat" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Longitude</label>
                <input type="number" step="any" name="lng" class="form-control" required>
            </div>
        </div>
        
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Pelabuhan</button>
        </div>
    </form>
</div>
@endsection
