<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $sales = Sale::with([
        'user',
        'details.product'
    ])->latest()->get();

    return view(
        'sales.index',
        compact('sales')
    );
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $products = Product::all();

    return view(
        'sales.create',
        compact('products')
    );
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $product = Product::findOrFail(
        $request->product_id
    );

    $qty = $request->qty;

    if ($qty > $product->stok) {

        return back()
            ->with('error', 'Stok tidak cukup');
    }

    $subtotal = $qty * $product->harga_jual;

    $sale = Sale::create([
        'user_id' => Auth::id(),
        'tanggal' => now(),
        'total' => $subtotal
    ]);

    SaleDetail::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'qty' => $qty,
        'harga' => $product->harga_jual,
        'subtotal' => $subtotal
    ]);

    $product->decrement('stok', $qty);

    return redirect()
        ->route('sales.index')
        ->with(
            'success',
            'Transaksi berhasil'
        );
}

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'details.product']);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        foreach ($sale->details as $detail) {
            $detail->product->increment('stok', $detail->qty);
        }

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Transaksi berhasil dibatalkan dan stok produk dikembalikan');
    }
}
