@php($user = Auth::user())

<nav class="sidebar-nav">

    {{-- ── MAIN ── --}}
    <div class="sidebar-section">Main</div>

    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="nav-label">Dashboard</span>
        <span class="nav-tooltip">Dashboard</span>
    </a>

    @if($user && in_array($user->role, ['admin', 'petugas']))
        <a href="{{ route('sales.index') }}"
           class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <span class="nav-label">Penjualan</span>
            <span class="nav-tooltip">Penjualan</span>
        </a>
    @endif

    @if($user && $user->role === 'admin')
        {{-- ── MASTER DATA ── --}}
        <div class="sidebar-section">Master Data</div>

        <a href="{{ route('products.index') }}"
           class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
            </svg>
            <span class="nav-label">Produk</span>
            <span class="nav-tooltip">Produk</span>
        </a>

        <a href="{{ route('categories.index') }}"
           class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                <line x1="7" y1="7" x2="7.01" y2="7"/>
            </svg>
            <span class="nav-label">Kategori</span>
            <span class="nav-tooltip">Kategori</span>
        </a>

        <a href="{{ route('suppliers.index') }}"
           class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            <span class="nav-label">Supplier</span>
            <span class="nav-tooltip">Supplier</span>
        </a>

        {{-- ── TRANSAKSI ── --}}
        <div class="sidebar-section">Transaksi</div>

        <a href="{{ route('purchases.index') }}"
           class="nav-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
            </svg>
            <span class="nav-label">Pembelian Stok</span>
            <span class="nav-tooltip">Pembelian</span>
        </a>
    @endif

</nav>
