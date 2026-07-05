@extends('layouts.app')
@section('title', 'Tulis Artikel - Admin')
@section('content')
<div class="mb-4">
    <a href="{{ route('admin.articles.index') }}" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Artikel</a>
</div>

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4">Tulis Artikel Analisis Baru</h3>

    <form action="{{ route('admin.articles.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-bold">Judul Artikel</label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Analisis Dampak Cuaca Ekstrem Terhadap Logistik">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Kategori</label>
                <select name="category" class="form-select">
                    <option value="analysis">Analysis</option>
                    <option value="report">Report</option>
                    <option value="insight">Insight</option>
                </select>
            </div>
            
            <div class="col-12">
                <label class="form-label fw-bold">Konten (Body)</label>
                <textarea name="body" class="form-control" rows="10" required placeholder="Tulis konten analisis Anda di sini..."></textarea>
            </div>

            <div class="col-12 mt-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="published" id="publishedSwitch" value="1" checked>
                    <label class="form-check-label fw-bold text-success" for="publishedSwitch">Publikasikan Langsung (Published)</label>
                </div>
            </div>
        </div>
        
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Artikel</button>
        </div>
    </form>
</div>
@endsection
