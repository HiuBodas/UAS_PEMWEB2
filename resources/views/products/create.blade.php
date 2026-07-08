<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Tambah Produk Baru') }}</h2>
        <p class="pos-page-subtitle">INSERT NEW SPECIFICATION FOR INVENTORY STOCKS</p>
    </x-slot>

    <div class="fade-up" style="max-w: 800px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="category_id" class="pos-label">{{ __('Kategori') }}</label>
                            <select id="category_id" name="category_id" class="pos-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="supplier_id" class="pos-label">{{ __('Supplier') }}</label>
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
                    </div>

                    <div class="form-group">
                        <label for="nama_produk" class="pos-label">{{ __('Nama Produk') }}</label>
                        <input id="nama_produk" name="nama_produk" type="text" class="pos-input" value="{{ old('nama_produk') }}" placeholder="Contoh: Aqua Botol 600ml" required />
                        @error('nama_produk')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-grid-3">
                        <div class="form-group">
                            <label for="harga_beli" class="pos-label">{{ __('Harga Beli (Rp)') }}</label>
                            <input id="harga_beli" name="harga_beli" type="number" class="pos-input mono" value="{{ old('harga_beli') }}" placeholder="0" required min="0" />
                            @error('harga_beli')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga_jual" class="pos-label">{{ __('Harga Jual (Rp)') }}</label>
                            <input id="harga_jual" name="harga_jual" type="number" class="pos-input mono" value="{{ old('harga_jual') }}" placeholder="0" required min="0" />
                            @error('harga_jual')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stok" class="pos-label">{{ __('Stok Awal') }}</label>
                            <input id="stok" name="stok" type="number" class="pos-input mono" value="{{ old('stok', 0) }}" placeholder="0" required min="0" />
                            @error('stok')
                                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Gambar Produk --}}
                    <div class="form-group">
                        <label class="pos-label">Gambar Produk <span style="font-weight:400;color:var(--text-muted);">(Opsional)</span></label>
                        <label for="gambar" id="gambar-dropzone" style="
                            display: flex; flex-direction: column; align-items: center; justify-content: center;
                            gap: 0.5rem; cursor: pointer; border: 2px dashed rgba(99,102,241,0.35);
                            border-radius: 0.75rem; padding: 1.5rem; background: rgba(15,23,42,0.4);
                            transition: border-color .2s, background .2s; min-height: 140px;
                        " onmouseover="this.style.borderColor='rgba(99,102,241,0.7)'" onmouseout="this.style.borderColor='rgba(99,102,241,0.35)'">
                            <img id="gambar-preview" src="" alt="Preview" style="display:none; max-height:120px; border-radius:0.5rem; object-fit:cover;">
                            <span id="gambar-placeholder" style="text-align:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366f1" width="36" height="36" style="margin:auto;"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 19.5h16.5M12 3v9m0 0l-2.25-2.25M12 12l2.25-2.25" /></svg>
                                <span style="display:block;margin-top:.5rem;color:var(--text-muted);font-size:.8rem;">Klik atau drag gambar ke sini</span>
                                <span style="display:block;color:var(--text-muted);font-size:.72rem;">JPG, PNG, WEBP — Maks. 2MB</span>
                            </span>
                        </label>
                        <input id="gambar" name="gambar" type="file" accept="image/*" style="display:none;" onchange="
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = e => {
                                    document.getElementById('gambar-preview').src = e.target.result;
                                    document.getElementById('gambar-preview').style.display = 'block';
                                    document.getElementById('gambar-placeholder').style.display = 'none';
                                };
                                reader.readAsDataURL(file);
                            }
                        ">
                        @error('gambar') <div class="pos-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan Produk') }}</button>
                        <a href="{{ route('products.index') }}" class="form-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>