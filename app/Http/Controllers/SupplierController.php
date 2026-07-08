<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $suppliers = Supplier::latest()->get();

    return view(
        'suppliers.index',
        compact('suppliers')
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('suppliers.create');
}
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view(
            'suppliers.edit',
            compact('supplier')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus');
    }

    /**
     * Remove the specified resources in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $idsString = $request->input('ids');
        if ($idsString) {
            $ids = explode(',', $idsString);
            Supplier::whereIn('id', $ids)->delete();
            return redirect()
                ->route('suppliers.index')
                ->with('success', 'Beberapa supplier berhasil dihapus');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('error', 'Tidak ada supplier yang terpilih untuk dihapus');
    }
}
