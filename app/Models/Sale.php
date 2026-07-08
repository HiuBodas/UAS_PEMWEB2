<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'total'
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Relasi Many-to-Many: Sale <-> Product melalui sale_details
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_details')
                    ->withPivot('qty', 'harga', 'subtotal')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}