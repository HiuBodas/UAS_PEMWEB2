<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Detail Transaksi') }}</h2>
        <p class="pos-page-subtitle">TRANSACTION SPECIFICATION AND RECEIPT</p>
    </x-slot>

    <div class="fade-up" style="max-w: 800px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <div class="receipt-header">
                    <div>
                        <h3 class="receipt-title">Struk Penjualan POS</h3>
                        <p class="receipt-id">ID: #{{ $sale->id }}</p>
                    </div>
                    <div class="receipt-meta">
                        <p>Kasir: <strong>{{ $sale->user->name }}</strong></p>
                        <p>Tanggal: <strong>{{ \Carbon\Carbon::parse($sale->tanggal)->format('d F Y, H:i') }}</strong></p>
                    </div>
                </div>

                <div class="pos-table-wrap mb-6">
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align: center; width: 100px;">Qty</th>
                                <th style="text-align: right;">Harga Satuan</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->details as $detail)
                                <tr>
                                    <td class="font-medium text-gray-100">{{ $detail->product->nama_produk }}</td>
                                    <td class="text-center mono">{{ $detail->qty }}</td>
                                    <td class="text-right mono text-gray-300">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="text-right mono text-accent-cyan">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="receipt-total-row">
                                <td colspan="3" style="text-align: right;" class="font-bold text-gray-400">TOTAL BELANJA</td>
                                <td style="text-align: right;" class="font-extrabold text-accent-cyan mono text-base">
                                    Rp {{ number_format($sale->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('sales.index') }}" class="btn btn-ghost">
                        &larr; Kembali
                    </a>
                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Stok produk akan dikembalikan.');" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Batalkan Transaksi (Kembalikan Stok)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

