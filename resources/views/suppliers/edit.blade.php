<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Edit Supplier') }}</h2>
        <p class="pos-page-subtitle">MODIFY EXISTING VENDOR SPECIFICATIONS</p>
    </x-slot>

    <div class="fade-up" style="max-w: 650px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama_supplier" class="pos-label">{{ __('Nama Supplier') }}</label>
                        <input id="nama_supplier" name="nama_supplier" type="text" class="pos-input" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required autofocus />
                        @error('nama_supplier')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telepon" class="pos-label">{{ __('No. Telepon') }}</label>
                        <input id="telepon" name="telepon" type="text" class="pos-input mono" value="{{ old('telepon', $supplier->telepon) }}" />
                        @error('telepon')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="pos-label">{{ __('Alamat') }}</label>
                        <textarea id="alamat" name="alamat" class="pos-textarea" rows="3">{{ old('alamat', $supplier->alamat) }}</textarea>
                        @error('alamat')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ __('Update Supplier') }}</button>
                        <a href="{{ route('suppliers.index') }}" class="form-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>