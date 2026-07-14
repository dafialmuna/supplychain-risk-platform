@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2 text-primary"></i>Kelola Pengguna</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Tambah Pengguna
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-borderless table-hover" style="--bs-table-bg: transparent; --bs-table-color: var(--text-primary); --bs-table-hover-bg: rgba(255,255,255,0.05); border-collapse: separate; border-spacing: 0 8px;">
            <thead style="background: rgba(255,255,255,0.05);">
                <tr>
                    <th class="rounded-start">#</th>
                    <th>Nama</th>
                    <th>E-mail</th>
                    <th>Peran</th>
                    <th>Daftar Pantauan</th>
                    <th class="rounded-end">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">{{ $user->role === 'admin' ? 'admin' : 'user' }}</span></td>
                    <td>
                        @forelse($user->watchlists as $wl)
                            <a href="{{ route('dashboard', ['country' => $wl->country->code]) }}" class="text-decoration-none">
                                <span class="badge bg-primary mb-1" style="background: rgba(14, 165, 233, 0.2) !important; color: #38bdf8 !important; border: 1px solid rgba(56, 189, 248, 0.3); transition: 0.2s;" onmouseover="this.style.background='rgba(14, 165, 233, 0.4)'" onmouseout="this.style.background='rgba(14, 165, 233, 0.2)'" title="Lihat Dasbor Lengkap (Cuaca, Berita, Risiko & Peta) untuk {{ $wl->country->name }}">
                                    {{ $wl->country->name ?? $wl->country_id }} <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7em;"></i>
                                </span>
                            </a>
                        @empty
                            <span class="text-muted small">Belum ada</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada pengguna.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection