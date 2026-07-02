<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SupplyChain Risk Platform')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
            position: sticky;
            top: 0;
            padding: 0;
        }
        .sidebar .brand {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 1.3rem;
            font-weight: 700;
        }
        .sidebar .brand i {
            color: #38bdf8;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover {
            background: rgba(56, 189, 248, 0.1);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
        }
        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
        }
        /* Main content */
        .main-content {
            padding: 24px 32px;
        }
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border-radius: 12px;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #e9edf2;
            font-weight: 600;
        }
        .kpi-value {
            font-size: 1.8rem;
            font-weight: 700;
        }
        .kpi-label {
            color: #64748b;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .risk-badge-low { background: #dcfce7; color: #166534; }
        .risk-badge-medium { background: #fef9c3; color: #854d0e; }
        .risk-badge-high { background: #fee2e2; color: #991b1b; }
        .risk-badge-critical { background: #fecaca; color: #7f1d1d; }
        .flag-icon { font-size: 2rem; }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="brand">
                    <i class="fas fa-globe-asia me-2"></i>RiskIntel
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-section="dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="country">
                            <i class="fas fa-flag me-2"></i>Country Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="weather">
                            <i class="fas fa-cloud-sun me-2"></i>Weather Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="currency">
                            <i class="fas fa-money-bill-wave me-2"></i>Currency Impact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="news">
                            <i class="fas fa-newspaper me-2"></i>News Intelligence
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="ports">
                            <i class="fas fa-ship me-2"></i>Port Locations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="visualization">
                            <i class="fas fa-chart-bar me-2"></i>Data Visualization
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="compare">
                            <i class="fas fa-balance-scale me-2"></i>Compare
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="watchlist">
                            <i class="fas fa-star me-2"></i>Watchlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-section="admin">
                            <i class="fas fa-cog me-2"></i>Admin
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')
</body>
</html>