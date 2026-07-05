@extends('layouts.app')
@section('title', 'Edit Artikel - Admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Artikel</a>
</div>

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4">Edit Artikel Analisis</h3>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Judul Artikel</label>
                <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Kategori</label>
                <select name="category" class="form-select">
                    <option value="analysis" {{ $article->category == 'analysis' ? 'selected' : '' }}>Analysis</option>
                    <option value="report" {{ $article->category == 'report' ? 'selected' : '' }}>Report</option>
                    <option value="insight" {{ $article->category == 'insight' ? 'selected' : '' }}>Insight</option>
                </select>
            </div>
            
            <div class="col-12">
                <label class="form-label fw-bold">Konten (Body)</label>
                <textarea name="body" class="form-control" rows="10" required>{{ $article->body }}</textarea>
            </div>

            <div class="col-12 mt-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="published" id="publishedSwitch" value="1" {{ $article->published ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold {{ $article->published ? 'text-success' : 'text-muted' }}" for="publishedSwitch">Status Publikasi (Published)</label>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Artikel</button>
        </div>
    </form>
</div>
@endsection
