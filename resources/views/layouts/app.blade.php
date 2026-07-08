<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartPOS — {{ config('app.name', 'SmartPOS') }}</title>

    {{-- Anti-FOUC: apply saved theme BEFORE any CSS renders --}}
    <script>
        (function(){
            var t = localStorage.getItem('spos-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    <\/script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ═══════════════════════════════════════════
           CORE VARIABLES
        ═══════════════════════════════════════════ */
        :root {
            --sidebar-w: 260px;
            --sidebar-collapsed-w: 72px;
            --topbar-h: 60px;
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
            --dur: 0.35s;
        }

        /* ── Dark Mode (default) ── */
        [data-theme="dark"] {
            --bg-base:      #060b17;
            --bg-surface:   #0b1120;
            --bg-sidebar:   #07101f;
            --bg-card:      rgba(11, 20, 42, 0.8);
            --bg-topbar:    rgba(6, 11, 23, 0.92);
            --border:       rgba(37, 99, 235, 0.12);
            --border-sub:   rgba(255, 255, 255, 0.04);
            --text-1:       #f1f5f9;
            --text-2:       #94a3b8;
            --text-3:       #475569;
            --accent:       #3b82f6;
            --accent-2:     #818cf8;
            --accent-h:     #2563eb;
            --accent-sub:   rgba(59, 130, 246, 0.09);
            --shadow:       0 20px 60px rgba(0, 0, 0, 0.55);
            --sb-thumb:     rgba(59, 130, 246, 0.2);
        }

        /* ── Light Mode ── */
        [data-theme="light"] {
            --bg-base:      #eef2fb;
            --bg-surface:   #f6f8ff;
            --bg-sidebar:   #ffffff;
            --bg-card:      rgba(255, 255, 255, 0.92);
            --bg-topbar:    rgba(238, 242, 251, 0.96);
            --border:       #dde5f5;
            --border-sub:   rgba(0, 0, 0, 0.04);
            --text-1:       #0f172a;
            --text-2:       #475569;
            --text-3:       #94a3b8;
            --accent:       #2563eb;
            --accent-2:     #4f46e5;
            --accent-h:     #1d4ed8;
            --accent-sub:   rgba(37, 99, 235, 0.07);
            --shadow:       0 10px 30px rgba(0, 0, 0, 0.07);
            --sb-thumb:     rgba(37, 99, 235, 0.15);
        }

        /* ═══════════════════════════════════════════
           BASE RESET
        ═══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-base);
            color: var(--text-1);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            transition: background var(--dur) var(--ease), color var(--dur) var(--ease);
        }

        /* ═══════════════════════════════════════════
           CANVAS / BACKGROUND
        ═══════════════════════════════════════════ */
        #cosmos-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background-image:
                linear-gradient(var(--border-sub) 1px, transparent 1px),
                linear-gradient(90deg, var(--border-sub) 1px, transparent 1px);
            background-size: 52px 52px;
            transition: opacity var(--dur) var(--ease);
        }

        /* ═══════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
            transition:
                width var(--dur) var(--ease),
                background var(--dur) var(--ease),
                border-color var(--dur) var(--ease),
                box-shadow var(--dur) var(--ease);
        }

        [data-theme="dark"] .sidebar { box-shadow: 6px 0 32px rgba(0,0,0,0.35); }
        [data-theme="light"] .sidebar { box-shadow: 4px 0 20px rgba(0,0,0,0.06); }

        .sidebar.collapsed { width: var(--sidebar-collapsed-w); }

        /* Logo row */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0 1rem;
            height: var(--topbar-h);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            overflow: hidden;
            transition: border-color var(--dur) var(--ease);
        }

        .sidebar-logo-icon {
            width: 38px; height: 38px;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
            transition: transform 0.3s var(--ease);
        }

        .sidebar.collapsed .sidebar-logo-icon { transform: scale(0.92); }

        .sidebar-logo-text {
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--text-1);
            white-space: nowrap;
            transition: opacity var(--dur) var(--ease), transform var(--dur) var(--ease);
        }

        .sidebar.collapsed .sidebar-logo-text {
            opacity: 0;
            transform: translateX(-10px);
            pointer-events: none;
        }

        /* Nav scroll area */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 0.65rem 0;
        }

        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

        /* Section label */
        .sidebar-section {
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: var(--text-3);
            padding: 0.9rem 1.35rem 0.3rem;
            font-family: 'JetBrains Mono', monospace;
            white-space: nowrap;
            transition: opacity var(--dur) var(--ease), transform var(--dur) var(--ease);
        }

        .sidebar.collapsed .sidebar-section {
            opacity: 0;
            transform: translateX(-6px);
            pointer-events: none;
        }

        /* Nav item */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.62rem 1rem;
            margin: 0.08rem 0.6rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-2);
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nav-item:hover {
            background: var(--accent-sub);
            color: var(--text-1);
        }

        .nav-item.active {
            background: var(--accent-sub);
            color: var(--accent);
            font-weight: 600;
        }

        /* Active left bar */
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 18%; bottom: 18%;
            width: 3px;
            background: linear-gradient(to bottom, var(--accent), var(--accent-2));
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 20px; height: 20px;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .nav-item:hover .nav-icon { transform: scale(1.1) translateX(1px); }
        .nav-item.active .nav-icon { color: var(--accent); }

        .nav-label {
            transition: opacity var(--dur) var(--ease), transform var(--dur) var(--ease);
            flex: 1;
        }

        .sidebar.collapsed .nav-label {
            opacity: 0;
            transform: translateX(-8px);
            pointer-events: none;
        }

        /* Tooltip on collapsed hover */
        .nav-item .nav-tooltip {
            position: absolute;
            left: calc(var(--sidebar-collapsed-w) + 8px);
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            color: var(--text-1);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transform: translateX(-6px);
            transition: opacity 0.15s ease, transform 0.15s ease;
            box-shadow: var(--shadow);
            z-index: 200;
        }

        .sidebar.collapsed .nav-item:hover .nav-tooltip {
            opacity: 1;
            transform: translateX(0);
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 0.65rem;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
            transition: border-color var(--dur) var(--ease);
        }

        /* Collapse toggle button */
        .collapse-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            width: 100%;
            padding: 0.55rem;
            border-radius: 9px;
            background: var(--accent-sub);
            border: 1px solid var(--border);
            color: var(--text-2);
            cursor: pointer;
            font-family: inherit;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s ease;
            overflow: hidden;
            white-space: nowrap;
        }

        .collapse-btn:hover { color: var(--accent); border-color: var(--accent); }

        .collapse-btn-icon {
            width: 16px; height: 16px;
            flex-shrink: 0;
            transition: transform var(--dur) var(--ease);
        }

        .sidebar.collapsed .collapse-btn-icon { transform: rotate(180deg); }

        .collapse-btn-label {
            transition: opacity var(--dur) var(--ease), transform var(--dur) var(--ease);
        }

        .sidebar.collapsed .collapse-btn-label {
            opacity: 0;
            transform: translateX(-8px);
            pointer-events: none;
        }

        /* ═══════════════════════════════════════════
           MAIN WRAP
        ═══════════════════════════════════════════ */
        .main-wrap {
            position: relative;
            z-index: 2;
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--dur) var(--ease);
        }

        .main-wrap.expanded { margin-left: var(--sidebar-collapsed-w); }

        /* ═══════════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════════ */
        .topbar {
            position: sticky;
            top: 0; z-index: 40;
            height: var(--topbar-h);
            background: var(--bg-topbar);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            gap: 1rem;
            transition: background var(--dur) var(--ease), border-color var(--dur) var(--ease);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
            min-width: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            flex-shrink: 0;
        }

        /* Mobile hamburger / toggle */
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--accent-sub);
            border: 1px solid var(--border);
            color: var(--text-2);
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .mobile-menu-btn:hover { color: var(--text-1); border-color: var(--accent); }

        /* ═══════════════════════════════════════════
           THEME TOGGLE SWITCH
        ═══════════════════════════════════════════ */
        .theme-toggle {
            position: relative;
            width: 54px; height: 28px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--accent-sub);
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .theme-toggle:hover { border-color: var(--accent); }

        .theme-knob {
            position: absolute;
            top: 3px; left: 3px;
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.3s ease;
        }

        [data-theme="light"] .theme-knob { transform: translateX(26px); }

        /* ═══════════════════════════════════════════
           USER BADGE & DROPDOWN
        ═══════════════════════════════════════════ */
        .pos-user-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            background: var(--accent-sub);
            border: 1px solid var(--border);
            border-radius: 999px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .pos-user-badge:hover { border-color: var(--accent); }

        .pos-user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .pos-user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-2);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pos-user-role {
            font-size: 0.62rem;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .pos-role-admin {
            background: rgba(124, 58, 237, 0.12);
            color: #a78bfa;
            border: 1px solid rgba(124, 58, 237, 0.2);
        }

        .pos-role-petugas {
            background: rgba(5, 150, 105, 0.12);
            color: #34d399;
            border: 1px solid rgba(5, 150, 105, 0.2);
        }

        .pos-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: var(--bg-sidebar);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.4rem;
            min-width: 185px;
            box-shadow: var(--shadow);
            display: none;
            z-index: 999;
        }

        .pos-dropdown.open { display: block; animation: fadeDropdown 0.15s ease; }

        @keyframes fadeDropdown {
            from { opacity: 0; transform: translateY(-6px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .pos-dropdown a, .pos-dropdown button {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.82rem;
            color: var(--text-2);
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
            transition: all 0.15s ease;
        }

        .pos-dropdown a:hover, .pos-dropdown button:hover {
            background: var(--accent-sub);
            color: var(--text-1);
        }

        .pos-dropdown .divider { height: 1px; background: var(--border); margin: 0.3rem 0; }

        /* ═══════════════════════════════════════════
           PAGE HEADER (slot)
        ═══════════════════════════════════════════ */
        .pos-page-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-1);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pos-page-subtitle {
            font-size: 0.68rem;
            color: var(--text-3);
            font-family: 'JetBrains Mono', monospace;
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════════ */
        .pos-main { flex: 1; padding: 1.5rem 0 3rem; }
        .pos-container { max-width: 1400px; margin: 0 auto; padding: 0 1.5rem; }

        /* ═══════════════════════════════════════════
           GLASS CARD
        ═══════════════════════════════════════════ */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: background var(--dur) var(--ease), border-color var(--dur) var(--ease);
        }

        .glass-card-body { padding: 1.5rem; }

        /* ═══════════════════════════════════════════
           STAT CARDS
        ═══════════════════════════════════════════ */
        .stat-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--accent);
        }

        /* Clickable stat card link */
        .stat-card-link {
            text-decoration: none;
            cursor: pointer;
            display: block;
        }

        .stat-card-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-3);
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-card-value {
            font-size: 2.2rem;
            font-weight: 700;
            margin-top: 0.5rem;
            line-height: 1;
            color: var(--text-1);
        }

        .stat-card-icon {
            position: absolute;
            top: 1.25rem; right: 1.25rem;
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            background: var(--accent-sub);
        }

        /* ═══════════════════════════════════════════
           TABLE
        ═══════════════════════════════════════════ */
        .pos-table-wrap {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .pos-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .pos-table thead tr { background: var(--accent-sub); }

        .pos-table thead th {
            padding: 0.9rem 1rem;
            text-align: left;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-3);
            font-family: 'JetBrains Mono', monospace;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .pos-table tbody tr {
            border-bottom: 1px solid var(--border-sub);
            transition: background 0.15s ease;
        }

        .pos-table tbody tr:last-child { border-bottom: none; }
        .pos-table tbody tr:hover { background: var(--accent-sub); }

        .pos-table tbody td {
            padding: 0.85rem 1rem;
            color: var(--text-2);
            vertical-align: middle;
        }

        /* ═══════════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-h); transform: translateY(-1px); }

        .btn-purple { background: #7c3aed; color: #fff; }
        .btn-purple:hover { background: #6d28d9; transform: translateY(-1px); }

        .btn-green { background: #059669; color: #fff; }
        .btn-green:hover { background: #047857; transform: translateY(-1px); }

        .btn-ghost {
            background: transparent;
            color: var(--text-2);
            border: 1px solid var(--border);
        }
        .btn-ghost:hover { background: var(--accent-sub); color: var(--text-1); border-color: var(--accent); }

        .btn-danger {
            background: transparent;
            color: #f87171;
            border: 1px solid rgba(248, 113, 113, 0.2);
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        .btn-danger:hover { background: rgba(248,113,113,0.06); border-color: rgba(248,113,113,0.4); }

        .btn-edit {
            background: transparent;
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.2);
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        .btn-edit:hover { background: rgba(56,189,248,0.06); border-color: rgba(56,189,248,0.4); }

        .btn-detail {
            background: transparent;
            color: #a78bfa;
            border: 1px solid rgba(167, 139, 250, 0.2);
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
        .btn-detail:hover { background: rgba(167,139,250,0.06); border-color: rgba(167,139,250,0.4); }

        /* ═══════════════════════════════════════════
           FORM ELEMENTS
        ═══════════════════════════════════════════ */
        .pos-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-3);
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 0.5rem;
        }

        .pos-input, .pos-select, .pos-textarea {
            width: 100%;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.65rem 1rem;
            color: var(--text-1);
            font-family: inherit;
            font-size: 0.88rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background var(--dur) var(--ease);
            outline: none;
        }

        .pos-input:focus, .pos-select:focus, .pos-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-sub);
        }

        .pos-input::placeholder, .pos-textarea::placeholder { color: var(--text-3); }
        .pos-select { cursor: pointer; }
        .pos-select option { background: var(--bg-surface); }
        .pos-textarea { resize: vertical; }

        .pos-error {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* ═══════════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════════ */
        .alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 1.1rem;
            border-radius: 10px;
            font-size: 0.83rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .alert-success { background: rgba(5,150,105,0.08); border: 1px solid rgba(5,150,105,0.2); color: #34d399; }
        .alert-error   { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

        /* ═══════════════════════════════════════════
           BADGES
        ═══════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
        }

        .badge-green  { background: rgba(5,150,105,0.1); color: #34d399; border: 1px solid rgba(5,150,105,0.2); }
        .badge-red    { background: rgba(239,68,68,0.1);  color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
        .badge-cyan   { background: rgba(2,132,199,0.1);  color: #38bdf8; border: 1px solid rgba(2,132,199,0.2); }
        .badge-purple { background: rgba(124,58,237,0.1); color: #c084fc; border: 1px solid rgba(124,58,237,0.2); }

        /* ═══════════════════════════════════════════
           SECTION HEADER
        ═══════════════════════════════════════════ */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 3px; height: 1.1em;
            background: linear-gradient(to bottom, var(--accent), var(--accent-2));
            border-radius: 2px;
        }

        /* ═══════════════════════════════════════════
           FORM LAYOUT
        ═══════════════════════════════════════════ */
        .form-group { margin-bottom: 1.25rem; }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; }

        @media (max-width: 640px) {
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.75rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .form-cancel { font-size: 0.82rem; color: var(--text-3); text-decoration: none; transition: color 0.15s; }
        .form-cancel:hover { color: var(--text-2); }

        /* ═══════════════════════════════════════════
           RECEIPT
        ═══════════════════════════════════════════ */
        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .receipt-title { font-size: 1.1rem; font-weight: 700; color: var(--text-1); }
        .receipt-id { font-size: 0.75rem; color: #38bdf8; font-family: 'JetBrains Mono', monospace; margin-top: 0.25rem; }
        .receipt-meta { text-align: right; }
        .receipt-meta p { font-size: 0.8rem; color: var(--text-3); margin-bottom: 0.2rem; }
        .receipt-meta strong { color: var(--text-2); font-weight: 500; }
        .receipt-total-row td { padding: 0.85rem 1rem; background: var(--accent-sub); }

        /* ═══════════════════════════════════════════
           SCROLLBAR
        ═══════════════════════════════════════════ */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--sb-thumb); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        /* ═══════════════════════════════════════════
           ANIMATIONS
        ═══════════════════════════════════════════ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-up             { animation: fadeUp 0.4s ease both; }
        .fade-up-delay-1     { animation-delay: 0.05s; }
        .fade-up-delay-2     { animation-delay: 0.1s; }
        .fade-up-delay-3     { animation-delay: 0.15s; }
        .fade-up-delay-4     { animation-delay: 0.2s; }

        /* ═══════════════════════════════════════════
           UTILITY CLASSES
        ═══════════════════════════════════════════ */
        .text-accent-cyan   { color: #38bdf8; }
        .text-accent-purple { color: #a78bfa; }
        .text-accent-green  { color: #34d399; }
        .mono               { font-family: 'JetBrains Mono', monospace; }
        .text-muted         { color: var(--text-3); }
        .text-sm            { font-size: 0.85rem; }
        .font-medium        { font-weight: 500; }
        .font-bold          { font-weight: 700; }
        .font-extrabold     { font-weight: 800; }
        .mt-1               { margin-top: 0.25rem; }
        .mb-6               { margin-bottom: 1.5rem; }
        .flex               { display: flex; }
        .items-center       { align-items: center; }
        .justify-between    { justify-content: space-between; }
        .gap-2              { gap: 0.5rem; }
        .gap-3              { gap: 0.75rem; }
        .gap-4              { gap: 1rem; }
        .text-gray-100      { color: var(--text-1); }
        .text-gray-300      { color: #cbd5e1; }
        .text-gray-400      { color: var(--text-3); }
        .text-white         { color: #ffffff; }
        .tracking-tight     { letter-spacing: -0.025em; }
        .uppercase          { text-transform: uppercase; }
        .text-right         { text-align: right; }
        .text-center        { text-align: center; }
        .text-base          { font-size: 1rem; }
        .text-3xl           { font-size: 1.875rem; }
        .text-4xl           { font-size: 2.25rem; }
        .flex-wrap          { flex-wrap: wrap; }
        .flex-1             { flex: 1; }
        .grid               { display: grid; }
        .grid-cols-1        { grid-template-columns: repeat(1, 1fr); }
        .gap-6              { gap: 1.5rem; }
        .hidden             { display: none; }

        @media (min-width: 640px)  { .sm\:block  { display: block; } }
        @media (min-width: 768px)  { .md\:grid-cols-2  { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .lg\:grid-cols-4  { grid-template-columns: repeat(4, 1fr); } }

        /* ═══════════════════════════════════════════
           SIDEBAR FULLY HIDDEN STATE (desktop)
        ═══════════════════════════════════════════ */
        .sidebar {
            transition:
                width var(--dur) var(--ease),
                transform var(--dur) var(--ease),
                background var(--dur) var(--ease),
                border-color var(--dur) var(--ease),
                box-shadow var(--dur) var(--ease);
        }

        .sidebar.sidebar-hidden {
            transform: translateX(-100%);
        }

        .main-wrap.no-sidebar {
            margin-left: 0;
        }

        /* ── Icon SVG theme state ── */
        .icon-sun  { display: none; }
        .icon-moon { display: block; }
        [data-theme="light"] .icon-moon { display: none; }
        [data-theme="light"] .icon-sun  { display: block; }

        /* ═══════════════════════════════════════════
           MOBILE
        ═══════════════════════════════════════════ */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 49;
            animation: fadeIn 0.2s ease;
        }

        .sidebar-backdrop.show { display: block; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
            }

            .sidebar.mobile-open { transform: translateX(0) !important; }
            .sidebar .collapse-btn,
            .sidebar .sidebar-section { display: block !important; opacity: 1 !important; }
            .sidebar .nav-label { opacity: 1 !important; transform: none !important; }

        /* Avatar Edit Styles */
        .pos-user-avatar:hover .avatar-edit-overlay {
            opacity: 1;
        }
        .avatar-edit-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Global hidden input for avatar upload -->
    <input type="file" id="global-avatar-input" accept="image/*" style="display: none;">
    <!-- Particle background canvas -->
    <canvas id="cosmos-canvas"></canvas>

    <!-- Mobile backdrop -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    <!-- ═══ SIDEBAR ═══ -->
    <aside class="sidebar" id="sidebar">

        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                    <line x1="12" y1="12" x2="12" y2="16"/>
                    <line x1="10" y1="14" x2="14" y2="14"/>
                </svg>
            </div>
            <span class="sidebar-logo-text">SMARTPOS</span>
        </div>

        <!-- Nav links (from navigation.blade.php) -->
        @include('layouts.navigation')

        <!-- Collapse toggle -->
        <div class="sidebar-footer">
            <button class="collapse-btn" id="sidebar-collapse" title="Toggle sidebar">
                <svg class="collapse-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 19l-7-7 7-7"/>
                    <path d="M18 19l-7-7 7-7"/>
                </svg>
                <span class="collapse-btn-label">Tutup Sidebar</span>
            </button>
        </div>
    </aside>

    <!-- ═══ MAIN AREA ═══ -->
    <div class="main-wrap" id="main-wrap">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <!-- Mobile hamburger -->
                <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Open menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M3 12h18M3 6h18M3 18h18"/>
                    </svg>
                </button>

                @isset($header)
                    <div>{{ $header }}</div>
                @endisset
            </div>

            <div class="topbar-right">
                <!-- Theme toggle -->
                <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle theme">
                    <div class="theme-knob" id="theme-knob">
                        <svg class="icon-moon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                        <svg class="icon-sun" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="5"/>
                            <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                    </div>
                </button>

                <!-- User dropdown -->
                @auth
                    <div class="pos-user-badge" id="user-badge">
                        <div class="pos-user-avatar" id="avatar-click-target" style="position: relative; overflow: hidden; cursor: pointer;" title="Klik untuk ubah foto profil">
                            @if(Auth::user()->avatar)
                                <img id="topbar-avatar-img" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span id="topbar-avatar-letter">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                            <div class="avatar-edit-overlay">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </div>
                        </div>
                        <span class="pos-user-name sm:block hidden">{{ Auth::user()->name }}</span>
                        <span class="pos-user-role {{ Auth::user()->role === 'admin' ? 'pos-role-admin' : 'pos-role-petugas' }}">
                            {{ Auth::user()->role }}
                        </span>

                        <div class="pos-dropdown" id="user-dropdown">
                            <a href="{{ route('profile.edit') }}">{{ __('Profil Saya') }}</a>
                            <div class="divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="color: #f87171;">{{ __('Log Out') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" style="padding: 0.6rem 0.95rem; border: 1px solid var(--border); border-radius: 999px; color: var(--text-2); text-decoration: none;">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="padding: 0.6rem 0.95rem; border: 1px solid var(--accent); border-radius: 999px; color: var(--accent); text-decoration: none;">Daftar</a>
                    @endif
                @endauth
            </div>
        </header>

        <!-- Page content -->
        <main class="pos-main">
            <div class="pos-container">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
    /* ═══════════════════════════════════════════
       PARTICLE CANVAS
    ═══════════════════════════════════════════ */
    (function () {
        const canvas = document.getElementById('cosmos-canvas');
        const ctx    = canvas.getContext('2d');
        let W, H, pts = [];
        const N = 55, D = 115;

        const resize = () => { W = canvas.width = innerWidth; H = canvas.height = innerHeight; };
        const mkPt   = () => ({
            x: Math.random() * W, y: Math.random() * H,
            vx: (Math.random() - 0.5) * 0.2,
            vy: (Math.random() - 0.5) * 0.2,
            r:  Math.random() * 1.4 + 0.5,
            a:  Math.random() * 0.22 + 0.06
        });

        const init = () => { pts = Array.from({ length: N }, mkPt); };

        const draw = () => {
            ctx.clearRect(0, 0, W, H);
            const dark = document.documentElement.getAttribute('data-theme') === 'dark';
            const lc   = dark ? '59,130,246' : '100,116,139';
            const dc   = dark ? '100,116,139' : '148,163,184';
            const la   = dark ? 0.07 : 0.05;

            for (let i = 0; i < pts.length; i++) {
                for (let j = i + 1; j < pts.length; j++) {
                    const dx = pts[i].x - pts[j].x, dy = pts[i].y - pts[j].y;
                    const d  = Math.sqrt(dx * dx + dy * dy);
                    if (d < D) {
                        ctx.beginPath();
                        ctx.moveTo(pts[i].x, pts[i].y);
                        ctx.lineTo(pts[j].x, pts[j].y);
                        ctx.strokeStyle = `rgba(${lc},${(1 - d / D) * la})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            }

            pts.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${dc},${p.a})`;
                ctx.fill();
                p.x += p.vx; p.y += p.vy;
                if (p.x < -8)  p.x = W + 8;
                if (p.x > W+8) p.x = -8;
                if (p.y < -8)  p.y = H + 8;
                if (p.y > H+8) p.y = -8;
            });

            requestAnimationFrame(draw);
        };

        addEventListener('resize', () => { resize(); init(); });
        resize(); init(); draw();
    })();

    /* ═══════════════════════════════════════════
       THEME TOGGLE — icons driven by CSS, no FOUC
    ═══════════════════════════════════════════ */
    (function () {
        // Theme is already applied by the anti-FOUC inline script in <head>.
        // This just wires the click handler.
        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            const html = document.documentElement;
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('spos-theme', next);
        });
    })();

    /* ═══════════════════════════════════════════
       SIDEBAR — hamburger (all screens) + icon-collapse
    ═══════════════════════════════════════════ */
    (function () {
        const sidebar   = document.getElementById('sidebar');
        const mainWrap  = document.getElementById('main-wrap');
        const colBtn    = document.getElementById('sidebar-collapse');
        const hamburger = document.getElementById('mobile-menu-btn');
        const backdrop  = document.getElementById('sidebar-backdrop');
        const isMobile  = () => window.innerWidth <= 768;

        /* ── Restore desktop sidebar state ── */
        if (!isMobile()) {
            const saved = localStorage.getItem('spos-sidebar');
            if (saved === 'collapsed') {
                sidebar?.classList.add('collapsed');
                mainWrap?.classList.add('expanded');
            } else if (saved === 'hidden') {
                sidebar?.classList.add('sidebar-hidden');
                mainWrap?.classList.add('no-sidebar');
            }
        }

        /* ── Icon-only collapse (inside sidebar button) ── */
        colBtn?.addEventListener('click', () => {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            mainWrap?.classList.toggle('expanded', isCollapsed);
            localStorage.setItem('spos-sidebar', isCollapsed ? 'collapsed' : 'expanded');
        });

        /* ── Hamburger: unified show/hide on all screens ── */
        hamburger?.addEventListener('click', () => {
            if (isMobile()) {
                /* Mobile: overlay slide in */
                const isOpen = sidebar.classList.toggle('mobile-open');
                backdrop?.classList.toggle('show', isOpen);
                document.body.style.overflow = isOpen ? 'hidden' : '';
            } else {
                /* Desktop: fully hide/show sidebar */
                const isHidden = sidebar.classList.toggle('sidebar-hidden');
                mainWrap?.classList.toggle('no-sidebar', isHidden);
                /* Clear collapsed state when hiding */
                if (isHidden) {
                    sidebar.classList.remove('collapsed');
                    mainWrap?.classList.remove('expanded');
                }
                localStorage.setItem('spos-sidebar', isHidden ? 'hidden' : 'expanded');
            }
        });

        /* ── Close mobile overlay on backdrop click ── */
        backdrop?.addEventListener('click', () => {
            sidebar?.classList.remove('mobile-open');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        });
    })();

    /* ═══════════════════════════════════════════
       USER DROPDOWN
    ═══════════════════════════════════════════ */
    (function () {
        const badge    = document.getElementById('user-badge');
        const dropdown = document.getElementById('user-dropdown');

        badge?.addEventListener('click', e => {
            e.stopPropagation();
            dropdown?.classList.toggle('open');
        });

        document.addEventListener('click', () => dropdown?.classList.remove('open'));
    })();

    /* ═══════════════════════════════════════════
       AVATAR UPLOAD VIA AJAX
     ═══════════════════════════════════════════ */
    (function () {
        const clickTarget = document.getElementById('avatar-click-target');
        const fileInput   = document.getElementById('global-avatar-input');

        clickTarget?.addEventListener('click', e => {
            e.stopPropagation(); // prevent dropdown from opening
            fileInput?.click();
        });

        fileInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('_token', '{{ csrf_token() }}');

            // Show progress state
            if (clickTarget) clickTarget.style.opacity = '0.5';

            fetch("{{ route('profile.avatar.update') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (clickTarget) clickTarget.style.opacity = '1';
                if (data.success) {
                    // Update topbar avatar
                    const newAvatarHtml = `<img id="topbar-avatar-img" src="${data.avatar_url}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="avatar-edit-overlay">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </div>`;
                    if (clickTarget) clickTarget.innerHTML = newAvatarHtml;

                    // Update dashboard avatar if exists on current page
                    const dbAvatarPlaceholder = document.getElementById('dashboard-avatar-placeholder');
                    if (dbAvatarPlaceholder) {
                        dbAvatarPlaceholder.innerHTML = `<img id="dashboard-avatar-img" src="${data.avatar_url}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.2s ease; color: white;" class="group-hover:opacity-100">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </div>`;
                    }
                    
                    // Simple toast or alert notification
                    alert(data.message);
                } else {
                    alert('Gagal memperbarui foto profil.');
                }
            })
            .catch(err => {
                if (clickTarget) clickTarget.style.opacity = '1';
                console.error(err);
                alert('Terjadi kesalahan saat mengunggah foto.');
            });
        });
    })();
    </script>
</body>
</html>
