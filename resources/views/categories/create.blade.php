<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Tambah Kategori') }}</h2>
        <p class="pos-page-subtitle">CREATE NEW PRODUCT CATEGORY IN THE DATABASE</p>
    </x-slot>

    <div class="fade-up" style="max-w: 600px; margin: 0 auto;">
        <div class="glass-card">
            <div class="glass-card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama_kategori" class="pos-label">{{ __('Nama Kategori') }}</label>
                        <input id="nama_kategori" name="nama_kategori" type="text" class="pos-input" value="{{ old('nama_kategori') }}" placeholder="Contoh: Makanan, Minuman, Elektronik..." required autofocus />
                        @error('nama_kategori')
                            <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ __('Simpan Kategori') }}</button>
                        <a href="{{ route('categories.index') }}" class="form-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>