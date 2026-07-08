<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'supplier_id',
        'nama_produk',
        'harga_beli',
        'harga_jual',
        'stok',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relasi Many-to-Many: Product <-> Sale melalui sale_details
     */
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_details')
                    ->withPivot('qty', 'harga', 'subtotal')
                    ->withTimestamps();
    }
}