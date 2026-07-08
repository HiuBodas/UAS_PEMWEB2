<x-app-layout>
    @php($user = Auth::user())

    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Dashboard POS') }}</h2>
        <p class="pos-page-subtitle">SYSTEM STATUS: OPERATIONAL — SECURE CONNECTION</p>
    </x-slot>

    {{-- Chart.js CDN --}}
    @push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    @endpush

    <div class="fade-up">
        {{-- Welcome banner --}}
        <div class="glass-card mb-6">
            <div class="glass-card-body flex items-center gap-6">
                @if($user)
                    <div class="relative group" style="flex-shrink: 0;">
                        <div id="dashboard-avatar-placeholder" style="
                            width: 80px; height: 80px; border-radius: 50%;
                            background: linear-gradient(135deg, var(--accent), var(--accent-2));
                            display: flex; align-items: center; justify-content: center;
                            font-size: 32px; font-weight: 700; color: #fff;
                            border: 3px solid rgba(255,255,255,0.08); overflow: hidden;
                            position: relative; cursor: pointer;
                        " title="Klik untuk ubah foto profil" onclick="document.getElementById('global-avatar-input').click()">
                            @if($user->avatar)
                                <img id="dashboard-avatar-img" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                            <div style="
                                position: absolute; inset: 0; background: rgba(0,0,0,0.6);
                                display: flex; align-items: center; justify-content: center;
                                opacity: 0; transition: opacity 0.2s ease; color: white;
                            " class="group-hover:opacity-100">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-100 mb-1">
                            Selamat datang kembali, <span class="text-accent-cyan font-extrabold">{{ $user->name }}</span>!
                        </h3>
                        <p class="text-sm text-muted">
                            Semua sistem berjalan normal. Anda masuk sebagai <span class="badge badge-purple uppercase">{{ $user->role }}</span>.
                        </p>
                    </div>
                @else
                    <div class="relative" style="flex-shrink: 0;">
                        <div style="
                            width: 80px; height: 80px; border-radius: 50%;
                            background: linear-gradient(135deg, var(--accent), var(--accent-2));
                            display: flex; align-items: center; justify-content: center;
                            font-size: 32px; font-weight: 700; color: #fff;
                            border: 3px solid rgba(255,255,255,0.08);
                        ">S</div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-100 mb-1">
                            Selamat datang di <span class="text-accent-cyan font-extrabold">SmartPOS</span>
                        </h3>
                        <p class="text-sm text-muted">
                            Ini adalah tampilan preview terbatas dari SmartPOS. <a href="{{ route('login') }}" class="text-accent-cyan underline">Masuk</a>
                            @if (Route::has('register'))
                                atau <a href="{{ route('register') }}" class="text-accent-cyan underline">daftar</a>
                            @endif
                            untuk membuka fitur lengkap seperti manajemen produk, transaksi, dan laporan.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <a href="{{ $user ? route('products.index') : route('login') }}" class="stat-card stat-card-link">
                <span class="stat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#38bdf8" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                </span>
                <div class="stat-card-label">Total Produk</div>
                <div class="stat-card-value mono">{{ $totalProduk }}</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.4rem;">Klik untuk lihat &rarr;</div>
            </a>

            <a href="{{ $user ? route('categories.index') : route('login') }}" class="stat-card stat-card-link">
                <span class="stat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a78bfa" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                </span>
                <div class="stat-card-label">Total Kategori</div>
                <div class="stat-card-value mono">{{ $totalKategori }}</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.4rem;">Klik untuk lihat &rarr;</div>
            </a>

            <a href="{{ $user ? route('suppliers.index') : route('login') }}" class="stat-card stat-card-link">
                <span class="stat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#60a5fa" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                </span>
                <div class="stat-card-label">Total Supplier</div>
                <div class="stat-card-value mono">{{ $totalSupplier }}</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.4rem;">Klik untuk lihat &rarr;</div>
            </a>

            <a href="{{ $user ? route('sales.index') : route('login') }}" class="stat-card stat-card-link">
                <span class="stat-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#34d399" width="22" height="22"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                </span>
                <div class="stat-card-label">Total Transaksi</div>
                <div class="stat-card-value mono">{{ $totalPenjualan }}</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.4rem;">Klik untuk lihat &rarr;</div>
            </a>
        </div>

        {{-- Total Pendapatan Banner --}}
        <div class="glass-card mb-6" style="border-color: rgba(16,185,129,0.18); background: linear-gradient(135deg, rgba(17,24,39,0.8), rgba(6,78,59,0.08));">
            <div class="glass-card-body flex items-center justify-between flex-wrap gap-4">
                <div>
                    <div class="stat-card-label text-accent-green">Total Pendapatan Bersih</div>
                    <div class="text-3xl md:text-4xl font-extrabold text-white mt-2 mono tracking-tight">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <a href="{{ $user ? route('sales.index') : route('login') }}" class="btn btn-green">
                        Lihat Laporan Penjualan &rarr;
                    </a>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            @if($user && $user->role === 'admin')
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            @else
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            @endif

                {{-- Chart 1: Penjualan 7 Hari Terakhir --}}
                <div class="glass-card">
                    <div class="glass-card-body">
                        <div class="section-header" style="margin-bottom: 1.25rem;">
                            <h3 class="section-title">Tren Penjualan 7 Hari Terakhir</h3>
                        </div>
                        <canvas id="salesLineChart" style="max-height: 280px;"></canvas>
                    </div>
                </div>

                {{-- Chart 2: Top 5 Produk Terlaris (admin only) --}}
                @if($user && $user->role === 'admin')
                <div class="glass-card">
                    <div class="glass-card-body">
                        <div class="section-header" style="margin-bottom: 1.25rem;">
                            <h3 class="section-title">Top 5 Produk Terlaris</h3>
                        </div>
                        @if(count($topLabels) > 0)
                            <canvas id="topProductsChart" style="max-height: 280px;"></canvas>
                        @else
                            <p class="text-muted text-sm text-center" style="padding: 3rem 0;">Belum ada data penjualan produk.</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
    (function () {
        // Deteksi tema
        const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
        const gridColor  = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.06)';
        const labelColor = isDark ? '#94a3b8' : '#475569';
        const font = { family: "'Space Grotesk', sans-serif", size: 11 };

        Chart.defaults.font = font;
        Chart.defaults.color = labelColor;

        // ── Chart 1: Line — Penjualan 7 Hari ──
        const ctx1 = document.getElementById('salesLineChart');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            type: 'line',
                            label: 'Pendapatan (Rp)',
                            data: @json($chartPendapatan),
                            borderColor: '#38bdf8',
                            backgroundColor: 'rgba(56,189,248,0.08)',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#38bdf8',
                            pointRadius: 4,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'yPendapatan',
                        },
                        {
                            type: 'bar',
                            label: 'Jumlah Transaksi',
                            data: @json($chartTranaksi),
                            backgroundColor: 'rgba(167,139,250,0.25)',
                            borderColor: '#a78bfa',
                            borderWidth: 1.5,
                            borderRadius: 6,
                            yAxisID: 'yTranaksi',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    if (ctx.dataset.yAxisID === 'yPendapatan') {
                                        return ' Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                    }
                                    return ' ' + ctx.parsed.y + ' transaksi';
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: gridColor } },
                        yPendapatan: {
                            position: 'left',
                            grid: { color: gridColor },
                            ticks: { callback: v => 'Rp ' + (v/1000) + 'K' }
                        },
                        yTranaksi: {
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        }

        // ── Chart 2: Doughnut — Top Produk ──
        const ctx2 = document.getElementById('topProductsChart');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: @json($topLabels),
                    datasets: [{
                        data: @json($topData),
                        backgroundColor: [
                            'rgba(56,189,248,0.75)',
                            'rgba(167,139,250,0.75)',
                            'rgba(52,211,153,0.75)',
                            'rgba(251,191,36,0.75)',
                            'rgba(248,113,113,0.75)',
                        ],
                        borderColor: isDark ? '#0b1120' : '#fff',
                        borderWidth: 3,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '62%',
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14 } },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} unit`
                            }
                        }
                    }
                }
            });
        }

        // Update chart colors when theme changes
        const observer = new MutationObserver(() => {
            Chart.instances && Object.values(Chart.instances).forEach(c => c.update());
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    })();
    </script>
</x-app-layout>