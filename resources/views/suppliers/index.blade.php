<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Data Supplier') }}</h2>
        <p class="pos-page-subtitle">MANAGE EXTERNAL DISTRIBUTORS AND VENDORS</p>
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
                    <h3 class="section-title">Daftar Supplier</h3>
                    <div class="flex items-center gap-2">
                        <form id="bulk-action-form" action="{{ route('suppliers.bulkDelete') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" name="ids" id="bulk-ids-input">
                        </form>
                        <button type="button" id="bulk-delete-btn" class="btn btn-danger" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg> Hapus Terpilih (<span id="selected-count">0</span>)
                        </button>
                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Tambah Supplier
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
                                <th>Nama Supplier</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th style="width: 200px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                                <tr>
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="select-item rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500" value="{{ $supplier->id }}" style="cursor: pointer;">
                                    </td>
                                    <td class="mono text-muted">{{ $loop->iteration }}</td>
                                    <td class="font-medium text-gray-100">{{ $supplier->nama_supplier }}</td>
                                    <td class="mono text-sm text-accent-cyan">{{ $supplier->telepon ?? '-' }}</td>
                                    <td class="text-sm text-gray-400">{{ $supplier->alamat ?? '-' }}</td>
                                    <td>
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-edit">
                                                Edit
                                            </a>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');" style="margin: 0;">
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
                                    <td colspan="6" class="text-center text-muted py-8">Tidak ada supplier ditemukan.</td>
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

                if (confirm(`Apakah Anda yakin ingin menghapus ${count} supplier terpilih secara massal?`)) {
                    const ids = Array.from(checkedItems).map(item => item.value);
                    bulkIdsInput.value = ids.join(',');
                    bulkActionForm.submit();
                }
            });
        });
    </script>
</x-app-layout>