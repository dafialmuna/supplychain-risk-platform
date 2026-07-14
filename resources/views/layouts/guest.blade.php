<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RiskIntel') }} - Authentication</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Dark theme palette */
            --bg-primary: #0b1120;
            --bg-secondary: #111827;
            --bg-card: rgba(17, 24, 39, 0.6);
            --border-glass: rgba(255, 255, 255, 0.06);

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

            /* Card effects */
            --card-shadow: 0 4px 24px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.04);
            --card-hover-shadow: 0 8px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(56, 189, 248, 0.06);
        }

        body {
            background: var(--bg-primary);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(circle at 50% -20%, rgba(56, 189, 248, 0.15), transparent 60%);
        }

        /* ===== CARDS — Glassmorphism ===== */
        .auth-card {
            border: 1px solid var(--border-glass);
            box-shadow: var(--card-shadow);
            border-radius: 16px;
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }

        .auth-card::before {
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

        /* ===== FORM CONTROLS (dark) ===== */
        .form-control, .form-check-input {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-check-input:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: rgba(56, 189, 248, 0.3);
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.08);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.45);
            opacity: 1; 
        }

        .form-label {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.88rem;
            letter-spacing: 0.2px;
            margin-bottom: 0.5rem;
        }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 12px 20px;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.4);
        }

        .brand-logo {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo i {
            color: var(--accent-cyan);
            margin-right: 10px;
            filter: drop-shadow(0 0 8px rgba(34, 211, 238, 0.6));
        }

        a {
            color: var(--accent-blue);
            text-decoration: none;
            transition: 0.2s;
        }

        a:hover {
            color: var(--accent-cyan);
            text-shadow: 0 0 8px rgba(34, 211, 238, 0.4);
        }
        
        .text-danger {
            color: var(--accent-rose) !important;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .small, small {
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="/" class="brand-logo">
            <i class="fas fa-globe-asia"></i>RiskIntel
        </a>
        
        {{ $slot }}
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.css"></script>
</body>
</html>
