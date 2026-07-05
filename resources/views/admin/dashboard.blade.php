@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="fas fa-cog me-2 text-primary"></i>Admin Dashboard</h2>
        <p class="text-muted mb-0">Kelola user, dataset pelabuhan, dan artikel analisis dari satu tempat.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <h3 class="mb-1">{{ $totalUsers }}</h3>
            <p class="text-muted mb-0">User</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <h3 class="mb-1">{{ $totalPorts }}</h3>
            <p class="text-muted mb-0">Dataset Pelabuhan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center h-100">
            <h3 class="mb-1">{{ $totalArticles }}</h3>
            <p class="text-muted mb-0">Artikel Analisis</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">User</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
            </div>
            <p class="text-muted mb-2">Tambah, ubah, dan hapus akun admin atau analyst.</p>
            <ul class="list-unstyled mb-0">
                @forelse($users->take(5) as $user)
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $user->name }}</span>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">{{ $user->role }}</span>
                    </li>
                @empty
                    <li class="text-muted">Belum ada user.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Dataset Pelabuhan</h5>
                <a href="{{ route('admin.ports.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
            </div>
            <p class="text-muted mb-2">Atur data pelabuhan yang dipakai untuk analisis risiko logistik.</p>
            @php
                $portsByCountry = \App\Models\Port::selectRaw('country, count(*) as count')
                    ->groupBy('country')
                    ->orderBy('count', 'desc')
                    ->limit(5)
                    ->get();
            @endphp
            <ul class="list-unstyled mb-0">
                @forelse($portsByCountry as $item)
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $item->country }}</span>
                        <span>{{ $item->count }}</span>
                    </li>
                @empty
                    <li class="text-muted">Belum ada dataset pelabuhan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Artikel Analisis</h5>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
            </div>
            <p class="text-muted mb-2">Publikasikan analisis untuk mendukung keputusan operasional.</p>
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