<table border="1">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($sales as $sale)
            @foreach($sale->details as $detail)
            <tr>
                <td>{{ $sale->tanggal }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ $detail->product->nama_produk }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->harga }}</td>
                <td>{{ $detail->subtotal }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>