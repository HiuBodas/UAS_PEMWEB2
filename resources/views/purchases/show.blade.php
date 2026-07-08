<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Detail Pembelian') }}</h2>
        <p class="pos-page-subtitle">STOCK PURCHASE ORDER LOGS AND BILLS</p>
    </x-slot>

    <div class="fade-up" style="max-w: 800px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <div class="receipt-header">
                    <div>
                        <h3 class="receipt-title">Catatan Pembelian Stok</h3>
                        <p class="receipt-id">ID: #{{ $purchase->id }}</p>
                    </div>
                    <div class="receipt-meta">
                        <p>Supplier: <strong>{{ $purchase->supplier->nama_supplier }}</strong></p>
                        <p>Dicatat oleh: <strong>{{ $purchase->user->name }}</strong></p>
                        <p>Tanggal: <strong>{{ \Carbon\Carbon::parse($purchase->tanggal)->format('d F Y, H:i') }}</strong></p>
                    </div>
                </div>

                <div class="pos-table-wrap mb-6">
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align: center; width: 100px;">Qty</th>
                                <th style="text-align: right;">Harga Beli / Unit</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchase->details as $detail)
                                <tr>
                                    <td class="font-medium text-gray-100">{{ $detail->product->nama_produk }}</td>
                                    <td class="text-center mono">{{ $detail->qty }}</td>
                                    <td class="text-right mono text-gray-300">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                    <td class="text-right mono text-accent-cyan">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="receipt-total-row">
                                <td colspan="3" style="text-align: right;" class="font-bold text-gray-400">TOTAL PEMBELIAN SUPPLIER</td>
                                <td style="text-align: right;" class="font-extrabold text-accent-cyan mono text-base">
                                    Rp {{ number_format($purchase->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('purchases.index') }}" class="btn btn-ghost">
                        &larr; Kembali
                    </a>
                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pembelian ini? Stok produk akan dikurangi kembali.');" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Hapus Catatan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

