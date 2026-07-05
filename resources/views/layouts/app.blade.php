<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SupplyChain Risk Platform')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --primary-bg: #f8fafc;
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            --sidebar-text: #94a3b8;
            --sidebar-active: rgba(56, 189, 248, 0.15);
            --sidebar-active-text: #38bdf8;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background: var(--primary-bg);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #e2e8f0;
            position: sticky;
            top: 0;
            padding: 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        .sidebar .brand {
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.3rem;
            font-weight: 700;
        }

        .sidebar .brand i {
            color: #38bdf8;
        }

        .sidebar .nav-link,
        .sidebar .nav-button {
            color: var(--sidebar-text);
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            align-items: center;
            width: calc(100% - 24px);
            border: 0;
            background: transparent;
            text-align: left;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-button:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: var(--sidebar-active-text);
            box-shadow: inset 3px 0 0 var(--sidebar-active-text);
        }

        .sidebar .nav-link i,
        .sidebar .nav-button i {
            width: 24px;
            text-align: center;
        }

        .main-content {
            padding: 24px 32px;
        }

        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 16px;
            background: #ffffff;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-3px);
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
            <nav class="col-md-3 col-lg-2 sidebar d-flex flex-column">
                <div class="brand">
                    <i class="fas fa-globe-asia me-2"></i>RiskIntel
                </div>

                <ul class="nav flex-column mt-3 flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" data-section="dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}" data-section="country">
                            <i class="fas fa-flag me-2"></i>Country Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.weather') ? 'active' : '' }}" href="{{ route('dashboard.weather') }}" data-section="weather">
                            <i class="fas fa-cloud-sun me-2"></i>Weather Map
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.currency') ? 'active' : '' }}" href="{{ route('dashboard.currency') }}" data-section="currency">
                            <i class="fas fa-money-bill-wave me-2"></i>Currency Impact
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.news') ? 'active' : '' }}" href="{{ route('dashboard.news') }}" data-section="news">
                            <i class="fas fa-newspaper me-2"></i>News Intelligence
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.ports') ? 'active' : '' }}" href="{{ route('dashboard.ports') }}" data-section="ports">
                            <i class="fas fa-ship me-2"></i>Port Locations
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.routing') ? 'active' : '' }}" href="{{ route('dashboard.routing') }}" data-section="routing">
                            <i class="fas fa-route me-2"></i>Shipping Route
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.visualization') ? 'active' : '' }}" href="{{ route('dashboard.visualization') }}" data-section="visualization">
                            <i class="fas fa-chart-bar me-2"></i>Data Visualization
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.compare') ? 'active' : '' }}" href="{{ route('dashboard.compare') }}" data-section="compare">
                            <i class="fas fa-balance-scale me-2"></i>Compare
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('watchlist.index') ? 'active' : '' }}" href="{{ route('watchlist.index') }}" data-section="watchlist">
                            <i class="fas fa-star me-2"></i>Watchlist
                        </a>
                    </li>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-cog me-2"></i>Admin
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="mt-auto px-3 pb-3">
                    @auth
                        <div class="text-white-50 small mb-2">{{ auth()->user()->name }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-button">
                                <i class="fas fa-right-from-bracket me-2"></i>Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>

            <main class="col-md-9 col-lg-10 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')
</body>
</html>