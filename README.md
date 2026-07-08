<div align="center">

# 🛒 SmartPOS

**Sistem Kasir Modern Berbasis Web**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)

SmartPOS adalah sistem Point of Sale (kasir) berbasis web yang dibangun dengan **Laravel**, dirancang untuk memudahkan pengelolaan inventori, penjualan, pembelian stok, dan pelaporan bisnis dengan tampilan dark mode modern dan antarmuka yang responsif.

</div>

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|-------|------------|
| 🔐 **Multi-Role Auth** | Login dengan peran `admin` dan `petugas` |
| 📦 **Manajemen Produk** | CRUD produk lengkap dengan **upload foto** produk |
| 🏷️ **Kategori & Supplier** | Pengelolaan master data kategori dan supplier |
| 🛍️ **Penjualan (POS)** | Transaksi kasir dengan detail item |
| 📥 **Pembelian Stok** | Pencatatan pembelian dari supplier |
| 📊 **Dashboard Analitik** | Grafik tren penjualan 7 hari & Top 5 produk terlaris |
| 🖼️ **Upload Foto Profil** | Avatar pengguna yang dapat diubah langsung dari topbar |
| 📄 **Ekspor Laporan** | Ekspor data ke PDF dan Excel |
| 🌙 **Dark / Light Mode** | Toggle tema otomatis dengan penyimpanan preferensi |
| 📱 **Responsif** | Sidebar collapsible, tampilan mobile-friendly |

---

## 🧰 Teknologi

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade Templates, Tailwind CSS, Vanilla JavaScript
- **Database**: MySQL 8.0
- **Charts**: Chart.js 4.4
- **Autentikasi**: Laravel Breeze
- **Storage**: Laravel Storage (public disk)
- **Export**: DomPDF (PDF), PhpSpreadsheet / Maatwebsite Excel

---

## 🚀 Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB (atau Laragon / XAMPP)

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/username/smartpos.git
cd smartpos

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=smartpos
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migrasi dan seeder
php artisan migrate --seed

# 8. Buat symbolic link storage
php artisan storage:link

# 9. Build assets
npm run dev

# 10. Jalankan server
php artisan serve
```

Buka browser di `http://localhost:8000`

---

## 👤 Akun Demo

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@smartpos.com | password |
| **Petugas** | petugas@smartpos.com | password |

> **Admin** memiliki akses penuh ke semua fitur termasuk manajemen produk, kategori, supplier, dan laporan.
> **Petugas** hanya dapat mengakses fitur penjualan (kasir).

---

## 📁 Struktur Folder Utama

```
smartpos/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── ProductController.php      # CRUD produk + upload gambar
│   │   ├── ProfileController.php      # Profil user + upload avatar
│   │   ├── SaleController.php
│   │   ├── PurchaseController.php
│   │   ├── CategoryController.php
│   │   ├── SupplierController.php
│   │   └── ExportController.php       # Ekspor PDF & Excel
│   └── Models/
├── database/migrations/
├── resources/views/
│   ├── layouts/app.blade.php          # Layout utama (sidebar + topbar)
│   ├── dashboard.blade.php
│   ├── products/ categories/ suppliers/ sales/ purchases/ profile/
└── storage/app/public/
    ├── products/                       # Gambar produk
    └── avatars/                        # Foto profil pengguna
```

---

## 📸 Fitur Upload Gambar

### Upload Foto Produk

Tersedia di halaman **Tambah Produk** dan **Edit Produk**:
- Format: **JPG, PNG, WEBP** — Maks. 2 MB
- Preview gambar langsung sebelum submit
- Drag & drop atau klik untuk memilih file
- Gambar lama otomatis dihapus saat diganti

### Upload Foto Profil

- Klik avatar di **banner dashboard** atau **topbar kanan atas**
- Upload via AJAX — tanpa reload halaman
- Avatar diperbarui secara real-time di semua elemen

---

## 📄 Ekspor Laporan

| Format | URL |
|--------|-----|
| PDF | `/export-pdf` |
| Excel | `/export-excel` |

---

## 🤝 Kontribusi

1. Fork repositori ini
2. Buat branch: `git checkout -b fitur/nama-fitur`
3. Commit: `git commit -m 'Tambah fitur nama-fitur'`
4. Push: `git push origin fitur/nama-fitur`
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini menggunakan lisensi **MIT**.

---

<div align="center">

Dibuat dengan ❤️ menggunakan **Laravel** · SmartPOS © 2026

</div>
