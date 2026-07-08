<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $products = Product::with([
        'category',
        'supplier'
    ])->get();

    return view(
        'products.index',
        compact('products')
    );
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = Category::all();
    $suppliers = Supplier::all();

    return view(
        'products.create',
        compact(
            'categories',
            'suppliers'
        )
    );
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('products', 'public');
            $data['gambar'] = $path;
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view(
            'products.edit',
            compact('product', 'categories', 'suppliers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'nama_produk' => 'required|string|max:255',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['gambar', '_method', '_token']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $path = $request->file('gambar')->store('products', 'public');
            $data['gambar'] = $path;
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage jika ada
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Remove the specified resources in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $idsString = $request->input('ids');
        if ($idsString) {
            $ids = explode(',', $idsString);
            Product::whereIn('id', $ids)->delete();
            return redirect()
                ->route('products.index')
                ->with('success', 'Beberapa produk berhasil dihapus');
        }

        return redirect()
            ->route('products.index')
            ->with('error', 'Tidak ada produk yang terpilih untuk dihapus');
    }
}
