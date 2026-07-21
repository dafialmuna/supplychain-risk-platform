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
            /* Dark theme palette */
            --bg-primary: #0b1120;
            --bg-secondary: #111827;
            --bg-card: rgba(17, 24, 39, 0.6);
            --bg-card-solid: #141c2f;
            --border-glass: rgba(255, 255, 255, 0.06);
            --border-glow: rgba(56, 189, 248, 0.15);

            /* Sidebar */
            --sidebar-bg: linear-gradient(180deg, #070d1a 0%, #0f172a 50%, #0b1120 100%);
            --sidebar-text: #64748b;
            --sidebar-active: rgba(56, 189, 248, 0.08);
            --sidebar-active-text: #38bdf8;
            --sidebar-hover: rgba(255, 255, 255, 0.03);

            /* Text */
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;

            /* Accent neon colors */
            --accent-cyan: #22d3ee;
            --accent-blue: #38bdf8;
            --accent-emerald: #34d399;
            --accent-amber: #fbbf24;
            --accent-rose: #fb7185;
            --accent-violet: #a78bfa;

            /* Card effects */
            --card-shadow: 0 4px 24px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.04);
            --card-hover-shadow: 0 8px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(56, 189, 248, 0.06);
            --card-glow-cyan: 0 0 30px rgba(34, 211, 238, 0.08);
            --card-glow-emerald: 0 0 30px rgba(52, 211, 153, 0.08);
            --card-glow-amber: 0 0 30px rgba(251, 191, 36, 0.08);
            --card-glow-rose: 0 0 30px rgba(251, 113, 133, 0.08);
        }

        /* ===== BASE ===== */
        body {
            background: var(--bg-primary);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .small, small {
            color: var(--text-secondary);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.14); }

        .sidebar {
            height: 100vh;
            overflow-y: auto;
            background: var(--sidebar-bg);
            color: #e2e8f0;
            position: sticky;
            top: 0;
            padding: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.3);
        }

        .sidebar .brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            background: rgba(56, 189, 248, 0.03);
        }

        .sidebar .brand i {
            color: var(--accent-cyan);
            filter: drop-shadow(0 0 8px rgba(34, 211, 238, 0.4));
        }

        .sidebar .nav-link,
        .sidebar .nav-button {
            color: var(--sidebar-text);
            padding: 14px 22px;
            border-radius: 12px;
            margin: 4px 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: flex;
            align-items: center;
            width: calc(100% - 32px);
            border: 0;
            background: transparent;
            text-align: left;
            font-weight: 500;
            font-size: 1.05rem;
            position: relative;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-button:hover {
            background: var(--sidebar-hover);
            color: var(--text-primary);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: var(--sidebar-active);
            color: var(--sidebar-active-text);
            box-shadow: inset 4px 0 0 var(--sidebar-active-text);
            font-weight: 600;
        }

        .sidebar .nav-link.active i {
            filter: drop-shadow(0 0 8px rgba(56, 189, 248, 0.6));
        }

        .sidebar .nav-link i,
        .sidebar .nav-button i {
            width: 28px;
            text-align: center;
            font-size: 1.2rem;
            margin-right: 8px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 24px 28px;
            background: var(--bg-primary);
            min-height: 100vh;
        }

        /* ===== CARDS — Glassmorphism ===== */
        .card {
            border: 1px solid var(--border-glass);
            box-shadow: var(--card-shadow);
            border-radius: 16px;
            background: var(--bg-card);
            color: var(--text-primary);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            padding: 1px;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 50%, rgba(56,189,248,0.05) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-2px);
            border-color: rgba(56, 189, 248, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== KPI CARDS ===== */
        .kpi-card {
            position: relative;
        }

        .kpi-card .kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: 14px;
        }

        .kpi-card.kpi-cyan .kpi-icon { background: rgba(34, 211, 238, 0.1); color: var(--accent-cyan); }
        .kpi-card.kpi-emerald .kpi-icon { background: rgba(52, 211, 153, 0.1); color: var(--accent-emerald); }
        .kpi-card.kpi-rose .kpi-icon { background: rgba(251, 113, 133, 0.1); color: var(--accent-rose); }
        .kpi-card.kpi-amber .kpi-icon { background: rgba(251, 191, 36, 0.1); color: var(--accent-amber); }

        .kpi-card.kpi-cyan:hover { box-shadow: var(--card-shadow), var(--card-glow-cyan); }
        .kpi-card.kpi-emerald:hover { box-shadow: var(--card-shadow), var(--card-glow-emerald); }
        .kpi-card.kpi-rose:hover { box-shadow: var(--card-shadow), var(--card-glow-rose); }
        .kpi-card.kpi-amber:hover { box-shadow: var(--card-shadow), var(--card-glow-amber); }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .kpi-card.kpi-cyan .kpi-value { color: var(--accent-cyan); }
        .kpi-card.kpi-emerald .kpi-value { color: var(--accent-emerald); }
        .kpi-card.kpi-rose .kpi-value { color: var(--accent-rose); }
        .kpi-card.kpi-amber .kpi-value { color: var(--accent-amber); }

        .kpi-label {
            color: var(--text-muted);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        /* ===== RISK BADGES ===== */
        .risk-badge-low { background: rgba(52, 211, 153, 0.15); color: #34d399; font-weight: 600; }
        .risk-badge-medium { background: rgba(251, 191, 36, 0.15); color: #fbbf24; font-weight: 600; }
        .risk-badge-high { background: rgba(251, 113, 133, 0.15); color: #fb7185; font-weight: 600; }
        .risk-badge-critical { background: rgba(239, 68, 68, 0.2); color: #ef4444; font-weight: 600; }

        /* ===== SECTION HEADERS ===== */
        .section-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }

        .section-title i {
            filter: drop-shadow(0 0 6px currentColor);
            opacity: 0.85;
        }

        /* ===== FORM CONTROLS (dark) ===== */
        .form-select,
        .form-control {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-select:focus,
        .form-control:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: rgba(56, 189, 248, 0.3);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
        }

        .form-select option {
            background: #0f172a;
            color: var(--text-primary);
        }

        /* ===== PLACEHOLDER VISIBILITY ===== */
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.45);
            opacity: 1; /* Override Firefox default opacity */
        }

        /* ===== FORM LABEL ===== */
        .form-label {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.88rem;
            letter-spacing: 0.2px;
        }

        /* ===== DETAIL STATS (country info row) ===== */
        .stat-item {
            text-align: center;
            padding: 12px 8px;
            position: relative;
        }

        .stat-item + .stat-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: rgba(255, 255, 255, 0.06);
        }

        .stat-item .kpi-label { font-size: 0.72rem; }
        .stat-item .kpi-value { font-size: 1.4rem; color: var(--text-primary); }

        /* ===== WEATHER & CURRENCY CARDS ===== */
        .weather-card {
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.7) 0%, rgba(30, 58, 95, 0.4) 100%);
        }

        .currency-card {
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.7) 0%, rgba(20, 60, 40, 0.3) 100%);
        }

        .weather-stats {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        .weather-stats .col-4 + .col-4 {
            border-left: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* ===== RISK GAUGE ===== */
        .risk-gauge {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto;
        }

        .risk-gauge svg {
            transform: rotate(-90deg);
        }

        .risk-gauge .gauge-bg {
            fill: none;
            stroke: rgba(255, 255, 255, 0.06);
            stroke-width: 6;
        }

        .risk-gauge .gauge-fill {
            fill: none;
            stroke-width: 6;
            stroke-linecap: round;
            transition: stroke-dashoffset 1s cubic-bezier(0.4, 0, 0.2, 1), stroke 0.5s;
        }

        .risk-gauge .gauge-value {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .risk-gauge .gauge-number {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease-out both;
        }

        .animate-in:nth-child(1) { animation-delay: 0.05s; }
        .animate-in:nth-child(2) { animation-delay: 0.1s; }
        .animate-in:nth-child(3) { animation-delay: 0.15s; }
        .animate-in:nth-child(4) { animation-delay: 0.2s; }

        .row > .animate-in:nth-child(1) { animation-delay: 0.05s; }
        .row > .animate-in:nth-child(2) { animation-delay: 0.12s; }
        .row > .animate-in:nth-child(3) { animation-delay: 0.19s; }
        .row > .animate-in:nth-child(4) { animation-delay: 0.26s; }

        /* ===== TEXT UTILITIES ===== */
        .text-muted { color: var(--text-muted) !important; }
        h2, h3, h5 { color: var(--text-primary); }

        /* ===== BADGE overrides ===== */
        .badge.bg-secondary { background: rgba(100, 116, 139, 0.2) !important; color: var(--text-secondary); }

        /* ===== BTN OVERRIDES ===== */
        .btn-outline-warning {
            border-color: rgba(251, 191, 36, 0.3);
            color: var(--accent-amber);
        }
        .btn-outline-warning:hover {
            background: rgba(251, 191, 36, 0.1);
            border-color: var(--accent-amber);
            color: var(--accent-amber);
        }

        /* ===== MAP container ===== */
        #weatherMap {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }
        
        .leaflet-container {
            background: #0b1120 !important; /* Same as body background or slate-900 (#0f172a) */
        }

        /* Fix Leaflet popups for dark theme */
        .leaflet-popup-content-wrapper {
            background: rgba(15, 23, 42, 0.95);
            color: var(--text-primary);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        .leaflet-popup-tip { background: rgba(15, 23, 42, 0.95); }

        /* Leaflet zoom controls — dark */
        .leaflet-control-zoom a {
            background: rgba(15, 23, 42, 0.85) !important;
            color: var(--text-primary) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(8px);
            transition: background 0.2s;
        }
        .leaflet-control-zoom a:hover {
            background: rgba(30, 41, 59, 0.95) !important;
            color: var(--accent-cyan) !important;
        }
        .leaflet-control-zoom {
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 10px !important;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
        }

        /* Leaflet attribution — dark */
        .leaflet-control-attribution {
            background: rgba(11, 17, 32, 0.7) !important;
            color: var(--text-muted) !important;
            font-size: 0.65rem !important;
            backdrop-filter: blur(4px);
        }
        .leaflet-control-attribution a {
            color: var(--accent-blue) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .main-content { padding: 16px; }
            .kpi-value { font-size: 1.5rem; }
        }

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
                        <a class="nav-link {{ request()->routeIs('dashboard.weather') ? 'active' : '' }}" href="{{ route('dashboard.weather') }}" data-section="weather">
                            <i class="fas fa-cloud-sun me-2"></i>Weather Map
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tracking.*') ? 'active' : '' }}" href="{{ route('tracking.index') }}" data-section="tracking">
                            <i class="fas fa-box-open me-2 text-warning"></i>Lacak Kargo
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
                    @else
                        <a href="{{ route('login') }}" class="nav-button" style="color: var(--accent-cyan);">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
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