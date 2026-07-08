<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'details.product'])->latest()->get();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('purchases.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->qty;
        $subtotal = $qty * $request->harga_beli;

        $purchase = Purchase::create([
            'supplier_id' => $request->supplier_id,
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => $subtotal
        ]);

        PurchaseDetail::create([
            'purchase_id' => $purchase->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'harga_beli' => $request->harga_beli,
            'subtotal' => $subtotal
        ]);

        // 🔥 STOK BERTAMBAH (INI PENTING)
        $product->increment('stok', $qty);

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Pembelian berhasil dicatat dan stok ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'details.product', 'user']);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        foreach ($purchase->details as $detail) {
            $detail->product->decrement('stok', $detail->qty);
        }

        $purchase->delete();

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Catatan pembelian berhasil dihapus dan stok disesuaikan');
    }
}
