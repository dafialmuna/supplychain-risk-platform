@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1 text-white"><i class="fas fa-cog me-2 text-primary"></i>Dasbor Admin</h2>
        <p class="text-muted mb-0">Kelola pengguna, dataset pelabuhan, dan artikel analisis dari satu tempat.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-4 text-center h-100 border-0 shadow-sm" style="background: rgba(14, 165, 233, 0.05); border: 1px solid rgba(56, 189, 248, 0.1) !important;">
            <div class="display-4 fw-bold text-primary mb-2">{{ $totalUsers }}</div>
            <p class="text-white mb-0">Total Pengguna</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 text-center h-100 border-0 shadow-sm" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(52, 211, 153, 0.1) !important;">
            <div class="display-4 fw-bold text-success mb-2">{{ $totalPorts }}</div>
            <p class="text-white mb-0">Kumpulan Data Pelabuhan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 text-center h-100 border-0 shadow-sm" style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(251, 191, 36, 0.1) !important;">
            <div class="display-4 fw-bold text-warning mb-2">{{ $totalArticles }}</div>
            <p class="text-white mb-0">Artikel Analisis</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-4 h-100 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="mb-0 text-white"><i class="fas fa-users me-2 text-primary"></i>Pengguna</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary" style="background: rgba(14, 165, 233, 0.2); border: 1px solid rgba(56, 189, 248, 0.3); color: #38bdf8;">Kelola</a>
            </div>
            <p class="text-muted small mb-3">Tambah, ubah, dan hapus akun admin atau user.</p>
            <ul class="list-unstyled mb-0">
                @forelse($users->take(5) as $user)
                    <li class="d-flex justify-content-between border-bottom py-2" style="border-color: rgba(255,255,255,0.05) !important;">
                        <span class="text-white">{{ $user->name }}</span>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">{{ $user->role === 'admin' ? 'admin' : 'user' }}</span>
                    </li>
                @empty
                    <li class="text-muted">Belum ada pengguna.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 h-100 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="mb-0 text-white"><i class="fas fa-anchor me-2 text-success"></i>Dataset Pelabuhan</h5>
                <a href="{{ route('admin.ports.index') }}" class="btn btn-sm btn-success" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(52, 211, 153, 0.3); color: #34d399;">Kelola</a>
            </div>
            <p class="text-muted small mb-3">Atur data pelabuhan yang dipakai untuk analisis risiko logistik.</p>
            @php
                $portsByCountry = \App\Models\Port::selectRaw('country, count(*) as count')
                    ->groupBy('country')
                    ->orderBy('count', 'desc')
                    ->limit(5)
                    ->get();
            @endphp
            <ul class="list-unstyled mb-0">
                @forelse($portsByCountry as $item)
                    <li class="d-flex justify-content-between border-bottom py-2" style="border-color: rgba(255,255,255,0.05) !important;">
                        <span class="text-white">{{ $item->country }}</span>
                        <span class="badge bg-secondary" style="background: rgba(255,255,255,0.1) !important;">{{ $item->count }}</span>
                    </li>
                @empty
                    <li class="text-muted">Belum ada dataset pelabuhan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 h-100 border-0 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3" style="border-color: rgba(255,255,255,0.05) !important;">
                <h5 class="mb-0 text-white"><i class="fas fa-newspaper me-2 text-warning"></i>Artikel Analisis</h5>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-warning" style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(251, 191, 36, 0.3); color: #fbbf24;">Kelola</a>
            </div>
            <p class="text-muted small mb-3">Publikasikan analisis untuk mendukung keputusan operasional.</p>
            <ul class="list-unstyled mb-0">
                @forelse($users->take(0) as $unused)
                @empty
                    <li class="text-muted">Buka halaman artikel untuk melihat daftar analisis.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection