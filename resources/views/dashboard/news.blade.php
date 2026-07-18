@extends('layouts.app')

@section('title', 'News Intelligence - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-newspaper me-2 text-primary"></i>News Intelligence</h2>
    <span class="text-muted" style="font-size: 0.85rem;">
        <i class="far fa-clock me-1"></i>{{ now()->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
    </span>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search Topic</label>
                    <select id="newsTopic" class="form-select">
                        <option value="logistics">Logistics</option>
                        <option value="trade">Trade</option>
                        <option value="shipping">Shipping</option>
                        <option value="economy">Economy</option>
                        <option value="supply chain">Supply Chain</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Country (Optional)</label>
                    <select id="newsCountry" class="form-select">
                        <option value="">Global (All)</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100" onclick="loadNews()"><i class="fas fa-search me-2"></i>Analyze News</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newsContainer" class="row g-3">
    <!-- News cards will be inserted here -->
    <div class="col-12 text-center text-muted py-5" id="newsLoading">
        <div class="spinner-border text-primary mb-3" role="status"></div>
        <p>Loading news and analyzing sentiment...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load countries for dropdown
    fetch('/api/countries')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('newsCountry');
            data.countries.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.name;
                opt.textContent = c.flag + ' ' + c.name;
                select.appendChild(opt);
            });
            loadNews();
        });
});

function loadNews() {
    const topic = document.getElementById('newsTopic').value;
    const country = document.getElementById('newsCountry').value;
    const container = document.getElementById('newsContainer');
    const loading = document.getElementById('newsLoading');
    
    container.innerHTML = '';
    container.appendChild(loading);
    loading.style.display = 'block';

    let url = `/api/news?topic=${encodeURIComponent(topic)}`;
    if (country) {
        url += `&country=${encodeURIComponent(country)}`;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            loading.style.display = 'none';
            if (!data.news || data.news.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted py-5">No news found for this topic.</div>';
                return;
            }

            data.news.forEach(item => {
                const sentiment = item.sentiment; // positive, negative, neutral
                let badgeClass = 'risk-badge-low';
                if (sentiment === 'positive') badgeClass = 'risk-badge-low';
                else if (sentiment === 'negative') badgeClass = 'risk-badge-high';
                else badgeClass = 'bg-secondary text-white';

                const card = document.createElement('div');
                card.className = 'col-md-6 mb-3';
                card.innerHTML = `
                    <div class="card h-100 p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge ${badgeClass} px-3 py-2 text-uppercase" style="border-radius: 8px; font-size: 0.75rem;">
                                <i class="fas fa-robot me-1"></i> Sentimen: ${sentiment === 'positive' ? 'Positif' : (sentiment === 'negative' ? 'Negatif' : 'Netral')}
                            </span>
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>${new Date(item.publishedAt).toLocaleDateString('id-ID')}</small>
                        </div>
                        <h5 class="card-title fw-bold mb-3" style="line-height: 1.4;">
                            <a href="${item.url}" target="_blank" class="news-link text-decoration-none">${item.title}</a>
                        </h5>
                        <p class="card-text text-muted mb-4" style="font-size: 0.85rem; line-height: 1.6;">${item.description || 'Tidak ada deskripsi tersedia.'}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center border-top border-secondary-subtle pt-3">
                            <small class="text-muted"><i class="fas fa-building me-1"></i>${item.source.name}</small>
                            <span class="badge bg-secondary-subtle text-white border-0 px-3 py-2" style="font-size: 0.75rem; border-radius: 6px; background: rgba(255, 255, 255, 0.05) !important;">
                                Positif: <strong class="text-success">${item.pos_score || 0}</strong> | Negatif: <strong class="text-danger">${item.neg_score || 0}</strong>
                            </span>
                        </div>
                    </div>
                `;
                container.appendChild(card);
            });
        })
        .catch(err => {
            loading.style.display = 'none';
            container.innerHTML = '<div class="col-12 text-center text-danger py-5">Error loading news.</div>';
            console.error(err);
        });
}
</script>

<style>
    .news-link {
        color: #f8fafc !important; /* Terang dan bersih */
        transition: all 0.25s ease;
    }
    .news-link:hover {
        color: var(--accent-cyan) !important; /* Efek hover menyala cyan */
        text-shadow: 0 0 8px rgba(34, 211, 238, 0.3);
    }
    .form-label {
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 0.85rem;
    }
</style>
@endpush
