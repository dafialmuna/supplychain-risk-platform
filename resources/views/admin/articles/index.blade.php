@extends('layouts.app')
@section('title', 'Kelola Artikel - Admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt me-2"></i>Artikel Analisis</h2>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tulis Artikel</a>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(52, 211, 153, 0.3); color: #34d399;">
    <i class="fas fa-check-circle me-2 fs-5"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<div class="card p-3 shadow-sm border-0">
    <table class="table table-borderless table-hover align-middle" style="--bs-table-bg: transparent; --bs-table-color: var(--text-primary); --bs-table-hover-bg: rgba(255,255,255,0.05); border-collapse: separate; border-spacing: 0 8px;">
        <thead style="background: rgba(255,255,255,0.05);">
            <tr>
                <th class="rounded-start">ID</th>
                <th>Judul Artikel</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th class="text-end rounded-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td class="text-white fw-bold">{{ $article->title }}</td>
                <td><span class="badge bg-secondary text-uppercase" style="background: rgba(255,255,255,0.1) !important;">{{ $article->category }}</span></td>
                <td>{{ $article->author ? $article->author->name : 'Unknown' }}</td>
                <td>
                    @if($article->published)
                        <span class="badge bg-success" style="background: rgba(16, 185, 129, 0.2) !important; color: #34d399 !important; border: 1px solid rgba(52, 211, 153, 0.3);">Diterbitkan</span>
                    @else
                        <span class="badge bg-warning" style="background: rgba(245, 158, 11, 0.2) !important; color: #fbbf24 !important; border: 1px solid rgba(251, 191, 36, 0.3);">Draft</span>
                    @endif
                </td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-info" style="background: rgba(14, 165, 233, 0.2); border: 1px solid rgba(56, 189, 248, 0.3); color: #38bdf8;"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(248, 113, 113, 0.3); color: #f87171;"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">Belum ada artikel analisis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
