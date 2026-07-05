@extends('layouts.app')

@section('title', 'News Intelligence - SupplyChain Risk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-newspaper me-2 text-primary"></i>News Intelligence</h2>
    <span class="text-muted">{{ now()->format('d M Y H:i') }} UTC</span>
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
                let badgeClass = 'bg-secondary';
                if (sentiment === 'positive') badgeClass = 'bg-success';
                else if (sentiment === 'negative') badgeClass = 'bg-danger';

                const card = document.createElement('div');
                card.className = 'col-md-6 mb-3';
                card.innerHTML = `
                    <div class="card h-100 p-3 shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge ${badgeClass} mb-2 px-3 py-2 text-uppercase">
                                <i class="fas fa-robot me-1"></i> Sentiment: ${sentiment}
                            </span>
                            <small class="text-muted">${new Date(item.publishedAt).toLocaleDateString()}</small>
                        </div>
                        <h5 class="card-title fw-bold">
                            <a href="${item.url}" target="_blank" class="text-decoration-none text-dark">${item.title}</a>
                        </h5>
                        <p class="card-text text-muted small">${item.description || 'No description available.'}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center border-top pt-3">
                            <small class="text-muted"><i class="fas fa-building me-1"></i>${item.source.name}</small>
                            <span class="badge bg-light text-dark border">
                                Pos: ${item.pos_score || 0} | Neg: ${item.neg_score || 0}
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
@endpush
