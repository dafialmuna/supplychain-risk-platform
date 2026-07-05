<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Final - SupplyChain Risk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georgia:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #111111;
            --muted: #4b5563;
            --line: #e5e7eb;
            --soft: #f8fafc;
            --accent: #0f4c81;
        }

        body {
            margin: 0;
            background: #eef2f7;
            color: var(--ink);
            font-family: Georgia, 'Times New Roman', serif;
        }

        .page {
            max-width: 980px;
            margin: 24px auto;
            background: #fff;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--line);
        }

        .page-inner {
            padding: 42px 54px 56px;
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 18px;
            letter-spacing: 0.2px;
        }

        h2 {
            font-size: 20px;
            font-weight: 700;
            margin: 22px 0 10px;
        }

        h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 18px 0 8px;
        }

        .subtitle {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.25;
            margin-bottom: 18px;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            border-bottom: 2px solid var(--line);
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .lead-copy {
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 12px;
        }

        ul, ol {
            margin-bottom: 0;
        }

        li {
            margin-bottom: 4px;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 18px;
        }

        .card-block {
            border: 1px solid var(--line);
            background: var(--soft);
            padding: 18px 18px 14px;
            border-radius: 10px;
            height: 100%;
        }

        .mini-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--accent);
            margin-bottom: 8px;
        }

        .pill {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: #eaf2ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            margin: 0 6px 8px 0;
        }

        .spaced-list li {
            margin-bottom: 8px;
        }

        .mono {
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .footer-note {
            margin-top: 24px;
            border-top: 1px solid var(--line);
            padding-top: 14px;
            color: var(--muted);
            font-size: 13px;
        }

        .badge-soft {
            background: #eef2ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }

        @media (max-width: 768px) {
            .page-inner {
                padding: 24px 18px 30px;
            }

            .two-col {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 22px;
            }

            .subtitle {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-inner">
            <h1>PROJECT FINAL</h1>
            <div class="subtitle">
                Global Supply Chain Risk Intelligence Platform
                <br>
                <span style="font-weight:400; font-size:18px;">(Platform Monitoring Risiko Rantai Pasok Global Berbasis Multi-API dan Analitik Data)</span>
            </div>

            <div class="section">
                <h2 class="section-title">Spesifikasi</h2>
                <p class="lead-copy mb-2">Project ini sangat bergantung pada data untuk:</p>
                <ul class="spaced-list ms-4 mb-3">
                    <li>Mengelola risiko logistik</li>
                    <li>Memantau kondisi cuaca ekstrem</li>
                    <li>Menganalisis gangguan transportasi</li>
                    <li>Mengamati kondisi ekonomi suatu negara</li>
                    <li>Membantu pengambilan keputusan bisnis</li>
                </ul>

                <p class="lead-copy mb-2">Project ini memperlihatkan kemampuan mahasiswa dalam:</p>
                <ul class="spaced-list ms-4">
                    <li>Full Stack Development</li>
                    <li>API Integration</li>
                    <li>Data Engineering</li>
                    <li>Dashboard Analytics</li>
                    <li>Geospatial Visualization</li>
                    <li>Business Intelligence</li>
                    <li>Decision Support System</li>
                </ul>
            </div>

            <div class="section">
                <h2 class="section-title">Studi Kasus</h2>
                <p class="lead-copy mb-3">Sebuah perusahaan ingin mengimpor barang dari berbagai negara.</p>
                <p class="lead-copy mb-2">Masalah:</p>
                <ul class="spaced-list ms-4 mb-3">
                    <li>Cuaca buruk dapat mengganggu pengiriman</li>
                    <li>Nilai tukar mata uang berubah</li>
                    <li>Konflik geopolitik meningkatkan risiko</li>
                    <li>Kemacetan pelabuhan menyebabkan keterlambatan</li>
                    <li>Inflasi suatu negara mempengaruhi biaya produksi</li>
                </ul>
                <p class="lead-copy mb-0">Dibangunlah sistem yang dapat memantau seluruh indikator tersebut dalam satu dashboard.</p>
            </div>

            <div class="section">
                <h2 class="section-title">Teknologi</h2>
                <div class="two-col">
                    <div class="card-block">
                        <div class="mini-label">Backend</div>
                        <ul class="spaced-list ms-4">
                            <li>PHP</li>
                            <li>Laravel</li>
                            <li>MySQL</li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="mini-label">Frontend</div>
                        <ul class="spaced-list ms-4">
                            <li>Bootstrap 5</li>
                            <li>AJAX</li>
                            <li>JavaScript ES6</li>
                        </ul>
                    </div>
                </div>

                <div class="two-col mt-3">
                    <div class="card-block">
                        <div class="mini-label">Visualisasi</div>
                        <ul class="spaced-list ms-4">
                            <li>Chart.js</li>
                            <li>Leaflet.js</li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="mini-label">Deployment</div>
                        <ul class="spaced-list ms-4">
                            <li>Docker (opsional)</li>
                            <li>GitHub</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">API Gratis yang Digunakan</h2>

                <ol class="ps-3">
                    <li class="mb-3">
                        <strong>Open-Meteo API</strong>
                        <div class="ms-3 mt-2">Cuaca global.</div>
                        <div class="ms-3">Website: <a href="https://open-meteo.com/" target="_blank">Open-Meteo</a></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>Temperatur</li>
                            <li>Curah hujan</li>
                            <li>Kecepatan angin</li>
                            <li>Risiko badai</li>
                        </ul>
                        <div class="ms-3 mt-1">Tidak membutuhkan API Key.</div>
                    </li>
                    <li class="mb-3">
                        <strong>World Bank API</strong>
                        <div class="ms-3">Website: <a href="https://data.worldbank.org/" target="_blank">World Bank API</a></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>GDP</li>
                            <li>Inflasi</li>
                            <li>Populasi</li>
                            <li>Ekspor</li>
                            <li>Impor</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>REST Countries API</strong>
                        <div class="ms-3">Website: <a href="https://restcountries.com/" target="_blank">REST Countries API</a></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>Negara</li>
                            <li>Mata uang</li>
                            <li>Wilayah</li>
                            <li>Bahasa</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>ExchangeRate API</strong>
                        <div class="ms-3">Website: <a href="https://www.exchangerate-api.com/" target="_blank">ExchangeRate API</a></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>Kurs mata uang real-time</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>Marine Traffic Alternative API (Gratis)</strong>
                        <div class="ms-3">Gunakan data pelabuhan publik dari <span class="mono">World Port Index Dataset</span></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>Pelabuhan</li>
                            <li>Lokasi pelabuhan</li>
                            <li>Negara</li>
                        </ul>
                    </li>
                    <li class="mb-3">
                        <strong>News API Alternatif Gratis</strong>
                        <div class="ms-3">Gunakan <a href="https://gnews.io/" target="_blank">GNews API</a></div>
                        <div class="ms-3 mt-1">Data:</div>
                        <ul class="ms-4 spaced-list">
                            <li>Berita ekonomi</li>
                            <li>Berita logistik</li>
                            <li>Berita geopolitik</li>
                        </ul>
                    </li>
                    <li>
                        <strong>OpenStreetMap</strong>
                        <div class="ms-3">Menggunakan Leaflet.js.</div>
                    </li>
                </ol>
            </div>

            <div class="section">
                <h2 class="section-title">Fitur Utama</h2>

                <div class="mb-3">
                    <strong>1. Global Country Dashboard</strong>
                    <p class="lead-copy mt-2 mb-1">User memilih negara.</p>
                    <div class="ms-3">Contoh:</div>
                    <div class="ms-4 mono mb-2">Germany<br>China<br>Indonesia<br>Australia</div>
                    <div class="ms-3">Sistem menampilkan:</div>
                    <ul class="ms-4 spaced-list">
                        <li>GDP</li>
                        <li>Inflasi</li>
                        <li>Populasi</li>
                        <li>Mata uang</li>
                        <li>Cuaca saat ini</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>2. Risk Scoring Engine</strong>
                    <p class="lead-copy mt-2 mb-1">Sistem menghitung:</p>
                    <div class="mono ms-3 mb-2">Risk Score = Weather + Inflation + Exchange Rate + News Sentiment</div>
                    <div class="ms-3">Output contoh:</div>
                    <div class="ms-4 mono mb-2">Germany : 22 (Low Risk)<br>China : 47 (Medium Risk)</div>
                    <div class="ms-3">Mahasiswa membuat algoritmanya sendiri.</div>
                </div>

                <div class="mb-3">
                    <strong>3. Global Weather Monitoring</strong>
                    <p class="lead-copy mt-2 mb-1">Peta dunia menunjukkan:</p>
                    <ul class="ms-4 spaced-list">
                        <li>Hujan</li>
                        <li>Badai</li>
                        <li>Angin kencang berdasarkan negara yang dipilih</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>4. Currency Impact Dashboard</strong>
                    <p class="lead-copy mt-2 mb-1">Menampilkan:</p>
                    <ul class="ms-4 spaced-list">
                        <li>Nilai tukar</li>
                        <li>Grafik perubahan kurs</li>
                    </ul>
                    <div class="ms-3">Menggunakan Chart.js.</div>
                </div>

                <div class="mb-3">
                    <strong>5. News Intelligence</strong>
                    <p class="lead-copy mt-2 mb-1">Menampilkan berita terkait:</p>
                    <ul class="ms-4 spaced-list">
                        <li>Logistics</li>
                        <li>Trade</li>
                        <li>Shipping</li>
                        <li>Economy</li>
                    </ul>
                    <div class="ms-3">Menggunakan GNews API.</div>
                </div>

                <div class="mb-3">
                    <strong>6. Port Location Dashboard</strong>
                    <p class="lead-copy mt-2 mb-1">Menampilkan lokasi pelabuhan dunia.</p>
                    <div class="ms-3">Fitur:</div>
                    <ul class="ms-4 spaced-list">
                        <li>Cari pelabuhan</li>
                        <li>Cari negara</li>
                        <li>Marker interaktif</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>7. Data Visualization Dashboard</strong>
                    <p class="lead-copy mt-2 mb-1">Grafik:</p>
                    <ul class="ms-4 spaced-list">
                        <li>GDP Trend</li>
                        <li>Inflation Trend</li>
                        <li>Currency Trend</li>
                        <li>Risk Trend</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>8. Country Comparison Engine</strong>
                    <p class="lead-copy mt-2 mb-1">Bandingkan:</p>
                    <ul class="ms-4 spaced-list">
                        <li>GDP</li>
                        <li>Inflation</li>
                        <li>Risk</li>
                        <li>Weather</li>
                        <li>Currency</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <strong>9. Favorite Monitoring List</strong>
                    <p class="lead-copy mt-2 mb-0">User dapat menyimpan negara yang dipantau.</p>
                </div>

                <div class="mb-0">
                    <strong>10. Admin Dashboard</strong>
                    <p class="lead-copy mt-2 mb-1">Kelola:</p>
                    <ul class="ms-4 spaced-list">
                        <li>User</li>
                        <li>Dataset pelabuhan</li>
                        <li>Artikel analisis</li>
                    </ul>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Fitur AI / Data Science (Tanpa AI Berbayar)</h2>

                <div class="mb-3">
                    <h3>Sentiment Analysis Berita</h3>
                    <p class="lead-copy mb-1">Menggunakan lexicon based sentiment analysis yang dibuat dengan PHP.</p>
                    <div class="ms-3">Output:</div>
                    <div class="ms-4 mono mb-2">Positive : 60%<br>Neutral : 25%<br>Negative : 15%</div>
                    <p class="lead-copy mb-1">Contoh tabel database:</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card-block">
                                <div class="mini-label">positive_words</div>
                                <div class="mono">id&nbsp;&nbsp;word<br>1&nbsp;&nbsp;growth<br>2&nbsp;&nbsp;increase<br>3&nbsp;&nbsp;profit<br>4&nbsp;&nbsp;stable<br>5&nbsp;&nbsp;improve</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-block">
                                <div class="mini-label">negative_words</div>
                                <div class="mono">id&nbsp;&nbsp;word<br>1&nbsp;&nbsp;war<br>2&nbsp;&nbsp;crisis<br>3&nbsp;&nbsp;inflation<br>4&nbsp;&nbsp;delay<br>5&nbsp;&nbsp;disaster</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-0">
                    <h3>Supply Chain Risk Prediction</h3>
                    <p class="lead-copy mb-1">Metode:</p>
                    <div class="mono ms-3 mb-2">Weighted Risk Model</div>
                    <div class="ms-3 mb-1">atau</div>
                    <div class="mono ms-3 mb-2">Simple Scoring Algorithm</div>
                    <p class="lead-copy mb-1">Contoh:</p>
                    <div class="mono ms-3 mb-2">Weather Risk = 30%<br>Inflation Risk = 20%<br>Political News Risk = 40%<br>Currency Risk = 10%<br>Total Risk = 28%</div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Database</h2>
                <div class="pill">users</div>
                <div class="pill">countries</div>
                <div class="pill">risk_scores</div>
                <div class="pill">news_cache</div>
                <div class="pill">ports</div>
                <div class="pill">watchlists</div>
                <div class="pill">articles</div>
            </div>

            <div class="section">
                <h2 class="section-title">REST API yang Harus Dibuat Mahasiswa</h2>
                <div class="mono">GET /api/countries<br>GET /api/risk<br>GET /api/ports<br>GET /api/news<br>GET /api/currency</div>
            </div>

            <div class="section mb-0">
                <h2 class="section-title">Perkiraan Skala Project</h2>
                <ul class="spaced-list ms-4">
                    <li>15-20 tabel database</li>
                    <li>30+ endpoint</li>
                    <li>6-7 API eksternal</li>
                    <li>Dashboard analitik kompleks</li>
                    <li>Sistem scoring dan prediksi</li>
                    <li>Peta interaktif global</li>
                </ul>
            </div>

            <div class="footer-note">
                Halaman ini dibuat sebagai draft web untuk mengikuti struktur tugas dosen. Jika perlu, konten ini bisa dipindah ke layout lain atau dihapus tanpa mengubah dashboard utama.
            </div>
        </div>
    </div>
</body>
</html>