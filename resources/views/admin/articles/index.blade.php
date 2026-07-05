@extends('layouts.app')
@section('title', 'Kelola Artikel - Admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-alt me-2"></i>Artikel Analisis</h2>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tulis Artikel</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-3 shadow-sm border-0">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Judul Artikel</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td class="fw-bold">{{ $article->title }}</td>
                <td><span class="badge bg-secondary text-uppercase">{{ $article->category }}</span></td>
                <td>{{ $article->author ? $article->author->name : 'Unknown' }}</td>
                <td>
                    @if($article->published)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-warning text-dark">Draft</span>
                    @endif
                </td>
                <td>{{ $article->created_at->format('d M Y') }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
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
