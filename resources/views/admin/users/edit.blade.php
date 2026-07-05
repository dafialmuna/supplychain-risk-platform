@extends('layouts.app')
@section('title', 'Edit User - Admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar User</a>
</div>

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4">Edit User</h3>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin diubah">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Peran (Role)</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="analyst" {{ $user->role == 'analyst' ? 'selected' : '' }}>Analyst</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update User</button>
        </div>
    </form>
</div>
@endsection
