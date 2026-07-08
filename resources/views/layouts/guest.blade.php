<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartPOS — Authentication Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --accent-cyan: #0284c7;
            --accent-purple: #7c3aed;
            --accent-blue: #2563eb;
            --bg-dark: #090d16;
            --bg-card: rgba(17, 24, 39, 0.75);
            --border-glass: rgba(148, 163, 184, 0.12);
            --text-primary: #f1f5f9;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* ── Grid Overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
            pointer-events: none;
        }

        /* ── Container wrapper ── */
        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 440px;
            padding: 1.5rem;
            animation: fadeUp 0.6s ease;
        }

        .auth-card {
            background: var(--bg-card);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.08); /* Clean, standard card border */
            border-radius: 20px;
            padding: 2.25rem 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4); /* Standard shadow, no neon glow */
            position: relative;
            overflow: hidden;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .auth-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.05em;
        }

        /* ── Override forms for premium dark integration ── */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: rgba(9, 13, 22, 0.6) !important;
            border: 1px solid rgba(148, 163, 184, 0.18) !important;
            border-radius: 10px !important;
            padding: 0.65rem 1rem !important;
            color: #f1f5f9 !important; /* Forces readable white text */
            font-family: inherit !important;
            font-size: 0.88rem !important;
            outline: none !important;
            box-shadow: none !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent-cyan) !important;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15) !important;
        }

        /* Autofill override to keep backgrounds dark and text light */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #090d16 inset !important;
            -webkit-text-fill-color: #f1f5f9 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        label {
            display: block;
            font-size: 0.76rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.07em !important;
            color: var(--text-muted) !important;
            margin-bottom: 0.5rem !important;
        }

        /* Gradient buttons matching system */
        button,
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple)) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            padding: 0.65rem 1.25rem !important;
            transition: all 0.2s ease !important;
            cursor: pointer !important;
            box-shadow: none !important;
        }
        button:hover,
        .btn-primary:hover {
            transform: translateY(-1px) !important;
        }

        /* Anchors visibility dark mode */
        .auth-card a {
            color: var(--text-muted) !important;
            font-size: 0.8rem !important;
            transition: color 0.15s ease !important;
            text-decoration: underline !important;
        }

        .auth-card a:hover {
            color: var(--text-primary) !important;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-icon" style="background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple)); padding: 6px; display: inline-flex; align-items: center; justify-content: center; border-radius: 12px; margin-bottom: 0.5rem;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="10" y1="14" x2="14" y2="14"/>
                    </svg>
                </div>
                <h1 class="auth-logo-text">SMARTPOS SYSTEM</h1>
            </div>
            {{ $slot }}
        </div>
    </div>
</body>
</html>
