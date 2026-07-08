<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Data Produk') }}</h2>
        <p class="pos-page-subtitle">MONAGE YOUR INVENTORY PRODUCTS AND SPECIFICATIONS</p>
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
                    <h3 class="section-title">Daftar Produk</h3>
                    <div class="flex items-center gap-2">
                        <form id="bulk-action-form" action="{{ route('products.bulkDelete') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="ids" id="bulk-ids-input">
                        </form>
                        <button type="button" id="bulk-delete-btn" class="btn btn-danger animate-fade-in" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg> Hapus Terpilih (<span id="selected-count">0</span>)
                        </button>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Tambah Produk
                        </a>
                    </div>
                </div>

                <div class="pos-table-wrap">
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th style="width: 40px; text-align: center;">
                                    <input type="checkbox" id="select-all" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500" style="cursor: pointer;">
                                </th>
                                <th style="width: 80px;">No</th>
                                <th style="width: 60px; text-align:center;">Foto</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th style="width: 120px;">Stok</th>
                                <th style="width: 200px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="select-item rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500" value="{{ $product->id }}" style="cursor: pointer;">
                                    </td>
                                    <td class="mono text-muted">{{ $loop->iteration }}</td>
                                    <td style="text-align:center;">
                                        @if($product->gambar)
                                            <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}"
                                                style="width:40px;height:40px;object-fit:cover;border-radius:0.4rem;border:1px solid rgba(255,255,255,0.08);display:inline-block;">
                                        @else
                                            <span style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:0.4rem;background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.2);">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366f1" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 19.5h16.5" /></svg>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-medium text-gray-100">{{ $product->nama_produk }}</td>
                                    <td><span class="badge badge-purple">{{ $product->category->nama_kategori }}</span></td>
                                    <td class="text-sm text-gray-400">{{ $product->supplier->nama_supplier }}</td>
                                    <td class="mono text-sm text-gray-300">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                                    <td class="mono text-sm text-accent-cyan">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $product->stok <= 5 ? 'badge-red' : 'badge-green' }}">
                                            {{ $product->stok }} unit
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" style="margin: 0;">
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
                                    <td colspan="10" class="text-center text-muted py-8">Tidak ada produk ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const selectItems = document.querySelectorAll('.select-item');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectedCount = document.getElementById('selected-count');
            const bulkIdsInput = document.getElementById('bulk-ids-input');
            const bulkActionForm = document.getElementById('bulk-action-form');

            function updateBulkDeleteButton() {
                const checkedItems = document.querySelectorAll('.select-item:checked');
                const count = checkedItems.length;
                selectedCount.textContent = count;
                if (count > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            selectAll.addEventListener('change', function () {
                selectItems.forEach(item => {
                    item.checked = selectAll.checked;
                });
                updateBulkDeleteButton();
            });

            selectItems.forEach(item => {
                item.addEventListener('change', function () {
                    const allChecked = document.querySelectorAll('.select-item:checked').length === selectItems.length;
                    selectAll.checked = allChecked && selectItems.length > 0;
                    updateBulkDeleteButton();
                });
            });

            bulkDeleteBtn.addEventListener('click', function () {
                const checkedItems = document.querySelectorAll('.select-item:checked');
                const count = checkedItems.length;
                if (count === 0) return;

                if (confirm(`Apakah Anda yakin ingin menghapus ${count} produk terpilih secara massal?`)) {
                    const ids = Array.from(checkedItems).map(item => item.value);
                    bulkIdsInput.value = ids.join(',');
                    bulkActionForm.submit();
                }
            });
        });
    </script>
</x-app-layout>