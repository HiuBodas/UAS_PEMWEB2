<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Data Penjualan') }}</h2>
        <p class="pos-page-subtitle">LOG TRANSACTION HISTORIES AND EXPORT REPORTS</p>
    </x-slot>

    <div class="fade-up">
        @if(session('success'))
            <div class="alert alert-success">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </span>
                <div>
                    <span class="font-bold">Sukses!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                </span>
                <div>
                    <span class="font-bold">Error!</span> {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="glass-card">
            <div class="glass-card-body">
                <div class="section-header flex-wrap gap-4">
                    <h3 class="section-title">Daftar Transaksi Penjualan</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('sales.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Transaksi Baru
                        </a>
                        <a href="{{ route('export.excel') }}" class="btn btn-green">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75.125V5.625c0-.621.504-1.125 1.125-1.125h17.25c.621 0 1.125.504 1.125 1.125v12.75c0 .621-.504 1.125-1.125 1.125m-3.375.125H3.375m0 0h17.25M6 18.375V7.125h12v11.25H6z" /></svg> Export Excel
                        </a>
                        <a href="{{ route('export.pdf') }}" class="btn btn-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg> Export PDF
                        </a>
                    </div>
                </div>

                <div class="pos-table-wrap">
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">No</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Kasir</th>
                                <th>Total Belanja</th>
                                <th style="width: 220px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td class="mono text-muted">{{ $loop->iteration }}</td>
                                    <td class="mono text-gray-300">
                                        {{ \Carbon\Carbon::parse($sale->tanggal)->format('d-m-Y H:i') }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="pos-user-avatar" style="width:24px; height:24px; font-size:10px;">
                                                {{ strtoupper(substr($sale->user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-100">{{ $sale->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="mono text-sm text-accent-cyan font-bold">
                                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-detail">
                                                Detail Struk
                                            </a>
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok produk akan dikembalikan.');" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Batalkan
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-8">Tidak ada transaksi ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>