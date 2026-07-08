<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Catat Pembelian Stok') }}</h2>
        <p class="pos-page-subtitle">RECORD RESTOCK ACQUISITIONS AND BILL DETAILS</p>
    </x-slot>

    <div class="fade-up" style="max-w: 750px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <form action="{{ route('purchases.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="supplier_id" class="pos-label">{{ __('Pilih Supplier') }}</label>
                        <select id="supplier_id" name="supplier_id" class="pos-select" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="product_id" class="pos-label">{{ __('Pilih Produk') }}</label>
                        <select id="product_id" name="product_id" class="pos-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->nama_produk }} — Stok saat ini: {{ $product->stok }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="qty" class="pos-label">{{ __('Jumlah (Qty)') }}</label>
                            <input id="qty" name="qty" type="number" class="pos-input mono" value="{{ old('qty', 1) }}" required min="1" />
                            @error('qty')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_beli" class="pos-label">{{ __('Harga Beli per Unit (Rp)') }}</label>
                            <input id="harga_beli" name="harga_beli" type="number" class="pos-input mono" value="{{ old('harga_beli') }}" placeholder="0" required min="0" />
                            @error('harga_beli')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ __('Catat Pembelian') }}</button>
                        <a href="{{ route('purchases.index') }}" class="form-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

