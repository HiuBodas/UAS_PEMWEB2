<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Data Pembelian') }}</h2>
        <p class="pos-page-subtitle">LOG INCOMING PRODUCT ACQUISITIONS AND STOCK PURCHASES</p>
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

        <div class="glass-card">
            <div class="glass-card-body">
                <div class="section-header">
                    <h3 class="section-title">Riwayat Pembelian Stok</h3>
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Catat Pembelian Baru
                    </a>
                </div>

                <div class="pos-table-wrap">
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">No</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th>Total Pembelian</th>
                                <th style="width: 200px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchases as $purchase)
                                <tr>
                                    <td class="mono text-muted">{{ $loop->iteration }}</td>
                                    <td class="mono text-gray-300">
                                        {{ \Carbon\Carbon::parse($purchase->tanggal)->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="font-medium text-gray-100">{{ $purchase->supplier->nama_supplier }}</td>
                                    <td class="mono text-sm text-accent-cyan font-bold">
                                        Rp {{ number_format($purchase->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-detail">
                                                Detail
                                            </a>
                                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pembelian ini? Stok produk akan dikurangi kembali.');" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-8">Tidak ada catatan pembelian ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

