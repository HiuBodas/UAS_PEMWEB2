<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::latest()->get();

    return view(
        'categories.index',
        compact('categories')
    );
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('categories.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required'
    ]);

    Category::create([
        'nama_kategori' => $request->nama_kategori
    ]);

    return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Category $category)
{
    return view(
        'categories.edit',
        compact('category')
    );
}

    /**
     * Update the specified resource in storage.
     */
    public function update(
    Request $request,
    Category $category
)
{
    $request->validate([
        'nama_kategori' => 'required'
    ]);

    $category->update([
        'nama_kategori' => $request->nama_kategori
    ]);

    return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diubah');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
{
    $category->delete();

    return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
}

    /**
     * Remove the specified resources in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $idsString = $request->input('ids');
        if ($idsString) {
            $ids = explode(',', $idsString);
            Category::whereIn('id', $ids)->delete();
            return redirect()
                ->route('categories.index')
                ->with('success', 'Beberapa kategori berhasil dihapus');
        }

        return redirect()
            ->route('categories.index')
            ->with('error', 'Tidak ada kategori yang terpilih untuk dihapus');
    }
}
