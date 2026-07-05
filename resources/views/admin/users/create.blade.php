@extends('layouts.app')
@section('title', 'Tambah User - Admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User</a>
</div>

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4">Tambah User Baru</h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required placeholder="Masukkan nama">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Peran (Role)</label>
                <select name="role" class="form-select" required>
                    <option value="admin">Admin</option>
                    <option value="analyst">Analyst</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan User</button>
        </div>
    </form>
</div>
@endsection
