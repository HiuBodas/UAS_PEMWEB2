<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Route Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Semua Route yang Membutuhkan Autentikasi (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Export Routes
    Route::get('/export-pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('export.excel');

    // Admin Only
    Route::middleware(['role:admin'])->group(function () {
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
        Route::resource('categories', CategoryController::class);

        Route::post('suppliers/bulk-delete', [SupplierController::class, 'bulkDelete'])->name('suppliers.bulkDelete');
        Route::resource('suppliers', SupplierController::class);

        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
        Route::resource('products', ProductController::class);

        Route::resource('purchases', PurchaseController::class);
    });

    // Admin & Petugas (Sales)
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::resource('sales', SaleController::class);
    });
});

require __DIR__.'/auth.php';