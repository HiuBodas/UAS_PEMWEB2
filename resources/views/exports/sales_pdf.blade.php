<h2>Laporan Penjualan POS</h2>

<table border="1" width="100%">
    <tr>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

    @foreach($sales as $sale)
        @foreach($sale->details as $detail)
        <tr>
            <td>{{ $sale->tanggal }}</td>
            <td>{{ $sale->user->name }}</td>
            <td>{{ $detail->product->nama_produk }}</td>
            <td>{{ $detail->qty }}</td>
            <td>{{ $detail->subtotal }}</td>
        </tr>
        @endforeach
    @endforeach
</table>